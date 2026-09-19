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
                    $mysqlPdo = self::connectMysql($config['mysql']);
                    // If MySQL connects but has 0 tables or missing products table, fall back to SQLite
                    $check = $mysqlPdo->query("SHOW TABLES LIKE 'products'");
                    if (!$check || $check->fetchColumn() === false) {
                        throw new PDOException("MySQL database has no required tables.");
                    }
                    self::$instance = $mysqlPdo;
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
            PDO::ATTR_TIMEOUT => 2,
        ]);
    }

    private static function connectSqlite(string $path): PDO {
        $sqliteDir = dirname($path);
        if (!is_dir($sqliteDir)) {
            mkdir($sqliteDir, 0777, true);
        }
        $pdo = new PDO("sqlite:" . $path, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        $pdo->exec("PRAGMA foreign_keys = ON;");

        // Self-healing auto-migration: check if table 'products' exists
        $check = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='products'")->fetchColumn();
        if (!$check) {
            self::migrateSqlite($pdo);
        }

        return $pdo;
    }

    private static function migrateSqlite(PDO $pdo): void {
        $baseDir = dirname(__DIR__, 2);
        $schemaFile = $baseDir . '/database/schema_sqlite.sql';
        $seedFile = $baseDir . '/database/seed_sqlite.sql';

        if (file_exists($schemaFile)) {
            $schemaSql = file_get_contents($schemaFile);
            if (!empty($schemaSql)) {
                $pdo->exec($schemaSql);
            }
        }

        if (file_exists($seedFile)) {
            $seedSql = file_get_contents($seedFile);
            if (!empty($seedSql)) {
                $pdo->exec($seedSql);
            }
        }

        // Guarantee demo accounts have genuine bcrypt hashes
        $adminHash = password_hash('admin123', PASSWORD_BCRYPT);
        $customerHash = password_hash('user123', PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
        $stmt->execute([$adminHash, 'admin@electro.vn']);
        $stmt->execute([$customerHash, 'customer@gmail.com']);
    }

    public static function reset(): void {
        self::$instance = null;
        self::$driverUsed = '';
    }

    public static function getDriverUsed(): string {
        return self::$driverUsed;
    }
}
