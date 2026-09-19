<?php
/**
 * Database Configuration
 * Supports auto-detection of MySQL or fallback to SQLite for portable presentation
 *
 * Configuration override hierarchy:
 * 1. Environment Variable
 * 2. config.php Constant
 * 3. Default Value
 */

// Ensure config.php is included if it exists
$configFile = dirname(__DIR__, 2) . '/config.php';
if (file_exists($configFile)) {
    require_once $configFile;
}

// Helper to resolve parameter by hierarchy: Environment Variable > config.php Constant > Default
$resolve = function (string $envName, ?string $constName, $default) {
    $envVal = getenv($envName);
    if ($envVal !== false && $envVal !== '') {
        return $envVal;
    }
    if ($constName !== null && defined($constName)) {
        $constVal = constant($constName);
        if ($constVal !== null && $constVal !== '') {
            return $constVal;
        }
    }
    return $default;
};

// Password specific resolver: allows empty string password
$resolvePass = function (string $envName, ?string $constName, string $default = '') {
    $envVal = getenv($envName);
    if ($envVal !== false) {
        return $envVal;
    }
    if ($constName !== null && defined($constName)) {
        return (string)constant($constName);
    }
    return $default;
};

$driver = strtolower((string)$resolve('DB_DRIVER', 'DB_DRIVER', 'auto'));
$host = (string)$resolve('DB_HOST', 'DB_HOST', '127.0.0.1');
$port = (int)$resolve('DB_PORT', 'DB_PORT', 3306);
$database = (string)$resolve('DB_NAME', 'DB_NAME', '12b5_store');
$username = (string)$resolve('DB_USER', 'DB_USER', 'root');
$password = $resolvePass('DB_PASS', 'DB_PASS', '');
$sqlitePath = (string)$resolve('DB_SQLITE_PATH', 'DB_SQLITE_PATH', dirname(__DIR__, 2) . '/database/electro.sqlite');

return [
    'driver' => $driver, // 'auto', 'mysql', or 'sqlite'

    'mysql' => [
        'host' => $host,
        'port' => $port,
        'database' => $database,
        'username' => $username,
        'password' => $password,
        'charset' => 'utf8mb4'
    ],

    'sqlite' => [
        'path' => $sqlitePath
    ],

    // Rust Engine Microservice Configuration
    'rust_engine' => [
        'enabled' => true,
        'host' => getenv('RUST_HOST') ?: '127.0.0.1',
        'port' => getenv('RUST_PORT') ?: 5000,
        'timeout_ms' => 1500, // Fast timeout: if Rust isn't running, fallback immediately
    ]
];
