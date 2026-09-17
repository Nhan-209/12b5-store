<?php
namespace App\Models;

use PDO;
use PDOException;

class Database {
    private static ?PDO $instance = null;
    private static string $driverUsed = '';

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            $config = require __DIR__ . '/../config/database.php';
            $driver = $config['driver'] ?? 'auto';

            if ($driver === 'sqlite') {
                self::$instance = self::connectSqlite($config['sqlite']['path']);
                self::$driverUsed = 'sqlite';
            } elseif ($driver === 'mysql') {
                self::$instance = self::connectMysql($config['mysql']);
                self::$driverUsed = 'mysql';
            } else {
                // Auto mode: try MySQL, fallback to SQLite
                try {
                    self::$instance = self::connectMysql($config['mysql']);
                    self::$driverUsed = 'mysql';
                } catch (\Throwable $e) {
                    // Fallback to SQLite
                    self::$instance = self::connectSqlite($config['sqlite']['path']);
                    self::$driverUsed = 'sqlite';
                }
            }
        }
        return self::$instance;
    }

    private static function connectMysql(array $cfg): PDO {
        $dsn = sprintf(
            "mysql:host=%s;port=%s;dbname=%s;charset=%s",
            $cfg['host'],
            $cfg['port'],
            $cfg['database'],
            $cfg['charset']
        );
        return new PDO($dsn, $cfg['username'], $cfg['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }

    private static function connectSqlite(string $path): PDO {
        $sqliteDir = dirname($path);
        if (!is_dir($sqliteDir)) {
            mkdir($sqliteDir, 0777, true);
        }
        return new PDO("sqlite:" . $path, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    public static function getDriverUsed(): string {
        return self::$driverUsed;
    }
}
