<?php
/**
 * Database Configuration
 * Supports auto-detection of MySQL or fallback to SQLite for portable presentation
 */

return [
    'driver' => getenv('DB_DRIVER') ?: 'auto', // 'mysql', 'sqlite', or 'auto'
    
    'mysql' => [
        'host' => getenv('DB_HOST') ?: '127.0.0.1',
        'port' => getenv('DB_PORT') ?: 3306,
        'database' => getenv('DB_NAME') ?: 'electro_db',
        'username' => getenv('DB_USER') ?: 'root',
        'password' => getenv('DB_PASS') !== false ? getenv('DB_PASS') : '',
        'charset' => 'utf8mb4'
    ],
    
    'sqlite' => [
        'path' => __DIR__ . '/../../database/electro.sqlite'
    ],

    // Rust Engine Microservice Configuration
    'rust_engine' => [
        'enabled' => true,
        'host' => getenv('RUST_HOST') ?: '127.0.0.1',
        'port' => getenv('RUST_PORT') ?: 5000,
        'timeout_ms' => 1500, // Fast timeout: if Rust isn't running, fallback immediately
    ]
];
