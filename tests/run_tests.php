<?php
/**
 * Automated Test Runner for ElectroStore
 * Usage: php tests/run_tests.php
 */

// Fix session warnings: Ensure session is initialized before any text is output or flushed to stdout
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load project configuration if available
if (file_exists(__DIR__ . '/../config.php')) {
    require_once __DIR__ . '/../config.php';
}

echo "=========================================================\n";
echo "  ElectroStore - Automated PHP Test Suite Runner\n";
echo "=========================================================\n\n";

// Autoloader with Linux ext4 case-tolerance
spl_autoload_register(function ($class) {
    if (str_starts_with($class, 'App\\')) {
        $baseDir = __DIR__ . '/../app/';
        $rel = substr($class, 4);
    } elseif (str_starts_with($class, 'Tests\\')) {
        $baseDir = __DIR__ . '/';
        $rel = substr($class, 6);
    } else {
        return;
    }

    $path = str_replace('\\', '/', $rel) . '.php';
    if (file_exists($baseDir . $path)) {
        require_once $baseDir . $path;
        return;
    }

    // Fallback for Linux ext4 lowercase directory structure (e.g. models/Cart.php)
    $parts = explode('/', $path);
    if (count($parts) > 1) {
        $parts[0] = strtolower($parts[0]);
        $lowercaseDirFile = $baseDir . implode('/', $parts);
        if (file_exists($lowercaseDirFile)) {
            require_once $lowercaseDirFile;
            return;
        }
    }
});

// Resolve and display active database driver
$configuredDriver = getenv('DB_DRIVER') ?: (defined('DB_DRIVER') ? DB_DRIVER : 'auto');
$activeEngine = \App\Models\Database::getDriverUsed();
if (empty($activeEngine)) {
    try {
        \App\Models\Database::getConnection();
        $activeEngine = \App\Models\Database::getDriverUsed();
    } catch (\Throwable $e) {
        $activeEngine = 'unknown (' . $e->getMessage() . ')';
    }
}
echo "[CONFIG] DB_DRIVER setting: {$configuredDriver} | Active Engine: {$activeEngine}\n\n";

$testSuites = [
    \Tests\CartTest::class,
    \Tests\OrderTest::class,
    \Tests\ProductTest::class,
    \Tests\AuthTest::class,
    \Tests\RustEngineClientTest::class,
    \Tests\HttpFlowTest::class,
];

$totalTests = 0;
$passedTests = 0;
$failedTests = 0;

foreach ($testSuites as $suiteClass) {
    echo "[SUITE] " . $suiteClass . "\n";
    try {
        $results = $suiteClass::run();
    } catch (\Throwable $suiteEx) {
        echo "  [FAIL] Suite fatal error: " . $suiteEx->getMessage() . "\n\n";
        $failedTests++;
        $totalTests++;
        continue;
    }

    foreach ($results as $test) {
        $totalTests++;
        if (!empty($test['passed'])) {
            $passedTests++;
            echo "  [PASS] " . $test['name'] . "\n";
        } else {
            $failedTests++;
            $errorInfo = !empty($test['error']) ? " (Error: {$test['error']})" : "";
            echo "  [FAIL] " . $test['name'] . $errorInfo . "\n";
        }
    }
    echo "\n";
}

echo "=========================================================\n";
echo "  TEST SUMMARY: {$passedTests}/{$totalTests} PASSED";
if ($failedTests > 0) {
    echo " ({$failedTests} FAILED)";
}
echo "\n=========================================================\n";

exit($failedTests > 0 ? 1 : 0);
