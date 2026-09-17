<?php
/**
 * Automated Test Runner for ElectroStore
 * Usage: php tests/run_tests.php
 */

echo "=========================================================\n";
echo "  ElectroStore - Automated PHP Test Suite Runner\n";
echo "=========================================================\n\n";

// Autoloader
spl_autoload_register(function ($class) {
    if (str_starts_with($class, 'App\\')) {
        $file = __DIR__ . '/../app/' . str_replace('\\', '/', substr($class, 4)) . '.php';
    } elseif (str_starts_with($class, 'Tests\\')) {
        $file = __DIR__ . '/' . str_replace('\\', '/', substr($class, 6)) . '.php';
    } else {
        return;
    }
    if (file_exists($file)) {
        require_once $file;
    }
});

$testSuites = [
    \Tests\CartTest::class,
    \Tests\OrderTest::class,
    \Tests\RustEngineClientTest::class,
];

$totalTests = 0;
$passedTests = 0;
$failedTests = 0;

foreach ($testSuites as $suiteClass) {
    echo "[SUITE] " . $suiteClass . "\n";
    $results = $suiteClass::run();

    foreach ($results as $test) {
        $totalTests++;
        if ($test['passed']) {
            $passedTests++;
            echo "  [PASS] " . $test['name'] . "\n";
        } else {
            $failedTests++;
            echo "  [FAIL] " . $test['name'] . "\n";
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
