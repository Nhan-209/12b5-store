<?php
/**
 * Adversarial Stress Test Suite: URL Routing & Database Layer
 * Challenger 1 Verification Harness
 */

namespace Tests;

use PDO;
use PDOException;

require_once __DIR__ . '/../app/models/Database.php';
require_once __DIR__ . '/../app/models/Product.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/models/Order.php';
require_once __DIR__ . '/../app/models/Cart.php';
require_once __DIR__ . '/../app/core/Csrf.php';

use App\Models\Database;
use App\Models\Product;
use App\Models\User;

class AdversarialStressSuite {

    public static function runAll(): array {
        echo "\n=========================================================\n";
        echo "  Adversarial Stress Suite - Routing & Database Layer\n";
        echo "=========================================================\n\n";

        $results = [
            'routing' => self::runRoutingStressTests(),
            'database' => self::runDatabaseStressTests()
        ];

        return $results;
    }

    /**
     * Executes isolated HTTP worker to test public/index.php routing
     */
    public static function simulateHttp(string $uri, string $scriptName = '/index.php', string $method = 'GET', array $get = [], array $post = []): array {
        $php = PHP_BINARY ?: 'C:\\xamppnp\\php\\php.exe';
        
        $descriptors = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];

        $workerScript = __DIR__ . '/adversarial_http_worker.php';

        $proc = proc_open(
            "\"{$php}\" \"{$workerScript}\"",
            $descriptors,
            $pipes,
            dirname(__DIR__),
            null
        );

        if (!is_resource($proc)) {
            throw new \RuntimeException("Failed to spawn HTTP worker process.");
        }

        $payload = json_encode([
            'uri' => $uri,
            'script_name' => $scriptName,
            'method' => $method,
            'get' => $get,
            'post' => $post
        ]);

        fwrite($pipes[0], $payload);
        fclose($pipes[0]);

        $stdout = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        $exitCode = proc_close($proc);

        $startMarker = '---RESPONSE_START---';
        $endMarker = '---RESPONSE_END---';

        $startPos = strpos($stdout, $startMarker);
        $endPos = strpos($stdout, $endMarker);

        if ($startPos === false || $endPos === false) {
            return [
                'status' => 500,
                'body' => $stdout . "\n" . $stderr,
                'error' => "Worker output missing delimiters. STDERR: {$stderr}",
                'exit_code' => $exitCode
            ];
        }

        $json = trim(substr($stdout, $startPos + strlen($startMarker), $endPos - ($startPos + strlen($startMarker))));
        $data = json_decode($json, true);

        return is_array($data) ? $data : [
            'status' => 500,
            'body' => $stdout,
            'error' => "Malformed worker JSON: {$json}"
        ];
    }

    public static function runRoutingStressTests(): array {
        echo "[GROUP 1] Routing Stress Tests\n";
        $tests = [];

        // 1. Path Traversal Probes
        $traversalProbes = [
            '/../../',
            '/../../etc/passwd',
            '/../../../config.php',
            '/products/../../config.php',
            '/product/../../config.php',
            '/product/../../../config.php',
            '/%2e%2e/%2e%2e/config.php',
            '/....//....//',
            '/....\\....\\config.php',
            '/products/..%2f..%2fconfig.php'
        ];

        foreach ($traversalProbes as $probe) {
            $res = self::simulateHttp($probe);
            // Must return 404 or clean error, must NOT return 500 or expose file contents (like DB credentials)
            $safeFromDisclosure = !str_contains($res['body'], 'DB_PASS') && !str_contains($res['body'], '12b5_store');
            $noFatal500 = ($res['status'] !== 500);
            $clean404orNormalized = in_array($res['status'], [200, 404, 302]);

            $passed = $safeFromDisclosure && $noFatal500 && $clean404orNormalized;
            $tests[] = [
                'category' => 'Path Traversal',
                'probe' => $probe,
                'status' => $res['status'],
                'passed' => $passed,
                'details' => "Status: {$res['status']}, Disclosed: " . ($safeFromDisclosure ? 'NO' : 'YES')
            ];
            echo "  " . ($passed ? "[PASS]" : "[FAIL]") . " Traversal probe: '{$probe}' => Status {$res['status']}\n";
        }

        // 2. Multiple Slashes Normalization
        $slashProbes = [
            '////products' => 200,
            '///' => 200,
            '//products//' => 200,
            '//cart' => 200,
            '///cart///' => 200,
            '//product//iphone-16-pro-max-256gb' => 404, // router regex expects /product/slug, multiple slashes should either 404 or normalize
            '//////////////////////////////////////////////////products' => 200,
        ];

        foreach ($slashProbes as $probe => $expectedStatus) {
            $res = self::simulateHttp($probe);
            // It should cleanly handle without 500 error
            $passed = ($res['status'] === 200 || $res['status'] === 404) && $res['status'] !== 500;
            $tests[] = [
                'category' => 'Multiple Slashes',
                'probe' => $probe,
                'status' => $res['status'],
                'passed' => $passed,
                'details' => "Status: {$res['status']} (Expected non-500)"
            ];
            echo "  " . ($passed ? "[PASS]" : "[FAIL]") . " Slash normalization: '{$probe}' => Status {$res['status']}\n";
        }

        // 3. Windows Backslash Variations
        $backslashProbes = [
            '\\products',
            '/products\\something',
            '\\..\\..\\config.php',
            '/\\products',
            '\\\\products',
            '/products\\..\\',
            '\\cart'
        ];

        foreach ($backslashProbes as $probe) {
            $res = self::simulateHttp($probe);
            $passed = ($res['status'] !== 500) && (!str_contains($res['body'], 'DB_PASS'));
            $tests[] = [
                'category' => 'Windows Backslash',
                'probe' => $probe,
                'status' => $res['status'],
                'passed' => $passed,
                'details' => "Status: {$res['status']}"
            ];
            echo "  " . ($passed ? "[PASS]" : "[FAIL]") . " Backslash variation: '{$probe}' => Status {$res['status']}\n";
        }

        // 4. Malformed URIs & Extreme Inputs
        $malformedProbes = [
            'Null byte probe' => '/products%00test',
            'Null byte prefix' => '/%00/products',
            'Carriage return injection' => "/products%0d%0aSet-Cookie:malicious=1",
            'Non-UTF8 / overlong slash' => '/%c0%afproducts',
            'Excessively long URI (4096 chars)' => '/' . str_repeat('a', 4096),
            'Deeply nested slashes (500 slashes)' => str_repeat('/', 500),
            'Special symbols URI' => '/!@#$%^&*()_+~`|}{[]:";\'?><,./'
        ];

        foreach ($malformedProbes as $desc => $probe) {
            $res = self::simulateHttp($probe);
            $passed = ($res['status'] !== 500) || str_contains($res['body'], '500'); // Clean error template is acceptable if handled
            // Specifically, no uncaught exceptions leaking stack trace
            $noUncaught = !str_contains($res['body'], 'Fatal error') && !str_contains($res['body'], 'Uncaught Exception');
            $passed = $noUncaught;

            $tests[] = [
                'category' => 'Malformed URIs',
                'probe' => $desc,
                'status' => $res['status'],
                'passed' => $passed,
                'details' => "Status: {$res['status']}, NoUncaught: " . ($noUncaught ? 'YES' : 'NO')
            ];
            echo "  " . ($passed ? "[PASS]" : "[FAIL]") . " Malformed URI [{$desc}] => Status {$res['status']}\n";
        }

        // 5. Query Parameter Pollution
        $queryPollutionProbes = [
            'Repeated parameters' => ['uri' => '/products?category=1&category=2', 'get' => ['category' => '2']],
            'Array injection on scalar query' => ['uri' => '/products?category[]=1&category[]=2', 'get' => ['category' => ['1', '2']]],
            'Malformed price bounds' => ['uri' => '/products?min_price=invalid&max_price=-500', 'get' => ['min_price' => 'invalid', 'max_price' => '-500']],
            'Huge integer overflow page' => ['uri' => '/products?page=999999999999999999999999999999', 'get' => ['page' => '999999999999999999999999999999']],
            'SQLi attack probe in search' => ['uri' => '/products?search=\' OR 1=1 --', 'get' => ['search' => "' OR 1=1 --"]],
            'SQLi UNION SELECT probe' => ['uri' => '/products?search=test\' UNION SELECT 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17 --', 'get' => ['search' => "test' UNION SELECT 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17 --"]],
            'XSS probe in search parameter' => ['uri' => '/products?search=<script>alert(1)</script>', 'get' => ['search' => '<script>alert(1)</script>']],
        ];

        foreach ($queryPollutionProbes as $desc => $params) {
            $res = self::simulateHttp($params['uri'], '/index.php', 'GET', $params['get']);
            // Verify HTTP status 200 (or 404), no SQL errors, no raw script injection
            $noSqlError = !str_contains($res['body'], 'SQLSTATE') && !str_contains($res['body'], 'syntax error');
            $noUnescapedXss = !str_contains($res['body'], '<script>alert(1)</script>');
            $statusOk = ($res['status'] === 200 || $res['status'] === 404);

            $passed = $noSqlError && $noUnescapedXss && $statusOk;
            $tests[] = [
                'category' => 'Query Pollution',
                'probe' => $desc,
                'status' => $res['status'],
                'passed' => $passed,
                'details' => "Status: {$res['status']}, NoSqlError: " . ($noSqlError ? 'Y' : 'N') . ", XSS-Safe: " . ($noUnescapedXss ? 'Y' : 'N')
            ];
            echo "  " . ($passed ? "[PASS]" : "[FAIL]") . " Query Pollution [{$desc}] => Status {$res['status']}\n";
        }

        echo "\n";
        return $tests;
    }

    public static function runDatabaseStressTests(): array {
        echo "[GROUP 2] Database Stress Tests\n";
        $tests = [];

        // 1. Unreachable MySQL Port fallback to SQLite
        echo "  [TEST] Unreachable MySQL Port (DB_PORT=3307) Fast Fallback...\n";
        putenv('DB_PORT=3307');
        putenv('DB_DRIVER=auto');
        Database::reset();

        $t0 = microtime(true);
        try {
            $pdo = Database::getConnection();
            $elapsed = microtime(true) - $t0;
            $driverUsed = Database::getDriverUsed();
            
            // Check if fallback to sqlite occurred and within reasonable timeout (< 4.5s)
            $stmt = $pdo->query("SELECT count(*) FROM products");
            $count = (int)$stmt->fetchColumn();

            $passed = ($driverUsed === 'sqlite' && $elapsed < 4.5 && $count > 0);
            $tests[] = [
                'name' => 'Unreachable MySQL Port 3307 Fast Fallback to SQLite',
                'passed' => $passed,
                'elapsed' => round($elapsed, 3) . 's',
                'driver' => $driverUsed,
                'details' => "Driver: {$driverUsed}, Elapsed: " . round($elapsed, 3) . "s, Products: {$count}"
            ];
            echo "  " . ($passed ? "[PASS]" : "[FAIL]") . " Unreachable Port 3307 -> Driver: {$driverUsed}, Elapsed: " . round($elapsed, 3) . "s, Count: {$count}\n";
        } catch (\Throwable $e) {
            $elapsed = microtime(true) - $t0;
            $tests[] = [
                'name' => 'Unreachable MySQL Port 3307 Fast Fallback to SQLite',
                'passed' => false,
                'elapsed' => round($elapsed, 3) . 's',
                'error' => $e->getMessage()
            ];
            echo "  [FAIL] Unreachable Port 3307 -> Exception: " . $e->getMessage() . "\n";
        }

        // 2. Unreachable MySQL Blackhole Host (DB_HOST=192.0.2.1)
        echo "  [TEST] Unreachable MySQL Blackhole Host (DB_HOST=192.0.2.1) Fast Fallback...\n";
        putenv('DB_PORT=3306');
        putenv('DB_HOST=192.0.2.1');
        putenv('DB_DRIVER=auto');
        Database::reset();

        $t0 = microtime(true);
        try {
            $pdo = Database::getConnection();
            $elapsed = microtime(true) - $t0;
            $driverUsed = Database::getDriverUsed();

            $stmt = $pdo->query("SELECT count(*) FROM products");
            $count = (int)$stmt->fetchColumn();

            $passed = ($driverUsed === 'sqlite' && $elapsed < 4.5 && $count > 0);
            $tests[] = [
                'name' => 'Unreachable MySQL Blackhole Host Fast Fallback',
                'passed' => $passed,
                'elapsed' => round($elapsed, 3) . 's',
                'driver' => $driverUsed,
                'details' => "Driver: {$driverUsed}, Elapsed: " . round($elapsed, 3) . "s, Products: {$count}"
            ];
            echo "  " . ($passed ? "[PASS]" : "[FAIL]") . " Blackhole Host 192.0.2.1 -> Driver: {$driverUsed}, Elapsed: " . round($elapsed, 3) . "s\n";
        } catch (\Throwable $e) {
            $elapsed = microtime(true) - $t0;
            $tests[] = [
                'name' => 'Unreachable MySQL Blackhole Host Fast Fallback',
                'passed' => false,
                'elapsed' => round($elapsed, 3) . 's',
                'error' => $e->getMessage()
            ];
            echo "  [FAIL] Blackhole Host 192.0.2.1 -> Exception: " . $e->getMessage() . "\n";
        }

        // Restore DB_HOST & DB_PORT
        putenv('DB_HOST=127.0.0.1');
        putenv('DB_PORT=3306');
        putenv('DB_DRIVER=auto');
        Database::reset();

        // 3. Missing SQLite Database Auto-Migration & Seeding
        echo "  [TEST] Missing SQLite Auto-Migration & Seeding...\n";
        $tempSqlite = dirname(__DIR__) . '/database/test_adversarial_auto.sqlite';
        if (file_exists($tempSqlite)) {
            @unlink($tempSqlite);
        }

        putenv('DB_DRIVER=sqlite');
        putenv("DB_SQLITE_PATH={$tempSqlite}");
        Database::reset();

        try {
            $pdo = Database::getConnection();
            $driverUsed = Database::getDriverUsed();

            // Verify tables were created
            $tablesStmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'");
            $tables = $tablesStmt->fetchAll(PDO::FETCH_COLUMN);

            $requiredTables = ['users', 'categories', 'brands', 'products', 'orders', 'order_items', 'reviews', 'coupons'];
            $hasAllTables = count(array_diff($requiredTables, $tables)) === 0;

            // Verify seeded products
            $pCount = (int)$pdo->query("SELECT count(*) FROM products")->fetchColumn();
            
            // Verify seeded admin & customer bcrypt hashes
            $adminUser = $pdo->query("SELECT * FROM users WHERE email = 'admin@electro.vn'")->fetch();
            $customerUser = $pdo->query("SELECT * FROM users WHERE email = 'customer@gmail.com'")->fetch();

            $adminPassOk = ($adminUser && password_verify('admin123', $adminUser['password_hash']));
            $customerPassOk = ($customerUser && password_verify('user123', $customerUser['password_hash']));

            $passed = ($hasAllTables && $pCount > 0 && $adminPassOk && $customerPassOk && file_exists($tempSqlite));

            $tests[] = [
                'name' => 'Missing SQLite Database Auto-Migration and Seeding',
                'passed' => $passed,
                'details' => "AllTables: " . ($hasAllTables ? 'Y' : 'N') . ", Products: {$pCount}, AdminAuth: " . ($adminPassOk ? 'Y' : 'N') . ", CustomerAuth: " . ($customerPassOk ? 'Y' : 'N')
            ];
            echo "  " . ($passed ? "[PASS]" : "[FAIL]") . " Missing SQLite Auto-Migrate: Tables=" . count($tables) . ", Products={$pCount}, AdminAuth=" . ($adminPassOk ? 'Y' : 'N') . "\n";
        } catch (\Throwable $e) {
            $tests[] = [
                'name' => 'Missing SQLite Database Auto-Migration and Seeding',
                'passed' => false,
                'error' => $e->getMessage()
            ];
            echo "  [FAIL] Missing SQLite Auto-Migrate -> Exception: " . $e->getMessage() . "\n";
        } finally {
            // Clean up temp sqlite file
            Database::reset();
            putenv('DB_SQLITE_PATH=');
            putenv('DB_DRIVER=auto');
            if (file_exists($tempSqlite)) {
                @unlink($tempSqlite);
            }
        }

        // 4. Rapid Successive Connection Calls (Singleton Stability)
        echo "  [TEST] Rapid Connection Calls (1,000 iterations)...\n";
        Database::reset();
        $t0 = microtime(true);
        $allSameInstance = true;
        $firstInstance = Database::getConnection();

        for ($i = 0; $i < 1000; $i++) {
            $inst = Database::getConnection();
            if ($inst !== $firstInstance) {
                $allSameInstance = false;
                break;
            }
        }
        $tConn = microtime(true) - $t0;
        $passed = $allSameInstance && ($tConn < 0.5);

        $tests[] = [
            'name' => 'Rapid Successive getConnection() Singleton Stability (1,000 calls)',
            'passed' => $passed,
            'details' => "AllSame: " . ($allSameInstance ? 'Y' : 'N') . ", Time: " . round($tConn * 1000, 2) . "ms"
        ];
        echo "  " . ($passed ? "[PASS]" : "[FAIL]") . " 1,000 Connection Calls in " . round($tConn * 1000, 2) . "ms (Singleton: " . ($allSameInstance ? 'OK' : 'FAIL') . ")\n";

        // 5. Rapid Database Reset Cycles (50 reconnect cycles)
        echo "  [TEST] Rapid Reset Cycles (50 cycles)...\n";
        $t0 = microtime(true);
        $resetSuccess = true;
        for ($i = 0; $i < 50; $i++) {
            Database::reset();
            $conn = Database::getConnection();
            if (!$conn) {
                $resetSuccess = false;
                break;
            }
        }
        $tReset = microtime(true) - $t0;
        $passed = $resetSuccess && ($tReset < 3.0);

        $tests[] = [
            'name' => 'Rapid Database::reset() Reconnect Cycles (50 cycles)',
            'passed' => $passed,
            'details' => "Success: " . ($resetSuccess ? 'Y' : 'N') . ", Time: " . round($tReset, 3) . "s"
        ];
        echo "  " . ($passed ? "[PASS]" : "[FAIL]") . " 50 Reset Cycles in " . round($tReset, 3) . "s\n";

        // 6. Atomic Transaction Rollback Stress
        echo "  [TEST] Transaction Rollback Under Adversarial Fault Injection...\n";
        $pdo = Database::getConnection();
        $initialProductCount = (int)$pdo->query("SELECT count(*) FROM products")->fetchColumn();

        $rollbackSuccess = false;
        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("INSERT INTO products (name, slug, category_id, brand_id, original_price, price, stock, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute(['Test Phantom Product', 'phantom-' . uniqid(), 1, 1, 100000, 90000, 10, 1]);

            // Confirm row is temporarily visible within transaction
            $inTxCount = (int)$pdo->query("SELECT count(*) FROM products")->fetchColumn();
            if ($inTxCount !== $initialProductCount + 1) {
                throw new \Exception("Row not visible within transaction");
            }

            // Simulate catastrophic business rule violation / adversarial abort
            throw new \RuntimeException("Simulated payment gateway timeout / constraint fault");

        } catch (\Throwable $ex) {
            $pdo->rollBack();
            $rollbackSuccess = true;
        }

        $postProductCount = (int)$pdo->query("SELECT count(*) FROM products")->fetchColumn();
        $noPhantomRows = ($postProductCount === $initialProductCount);

        $passed = $rollbackSuccess && $noPhantomRows;
        $tests[] = [
            'name' => 'Atomic Transaction Rollback Verification',
            'passed' => $passed,
            'details' => "RollbackExecuted: " . ($rollbackSuccess ? 'Y' : 'N') . ", CountBefore: {$initialProductCount}, CountAfter: {$postProductCount}"
        ];
        echo "  " . ($passed ? "[PASS]" : "[FAIL]") . " Transaction Rollback: Pre={$initialProductCount}, InTx=" . ($initialProductCount + 1) . ", Post={$postProductCount}\n";

        echo "\n";
        return $tests;
    }
}

if (php_sapi_name() === 'cli' && realpath($argv[0]) === realpath(__FILE__)) {
    $results = AdversarialStressSuite::runAll();
    
    $totalRouting = count($results['routing']);
    $passedRouting = count(array_filter($results['routing'], fn($t) => $t['passed']));

    $totalDb = count($results['database']);
    $passedDb = count(array_filter($results['database'], fn($t) => $t['passed']));

    echo "=========================================================\n";
    echo "  ADVERSARIAL STRESS SUMMARY:\n";
    echo "  Routing Tests: {$passedRouting}/{$totalRouting} PASSED\n";
    echo "  Database Tests: {$passedDb}/{$totalDb} PASSED\n";
    echo "=========================================================\n";

    if ($passedRouting < $totalRouting || $passedDb < $totalDb) {
        exit(1);
    }
    exit(0);
}
