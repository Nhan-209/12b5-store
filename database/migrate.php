<?php
/**
 * Database Migration & Seed CLI Script
 * Usage:
 *   php database/migrate.php [--driver=mysql|sqlite] [--force]
 */

echo "=========================================================\n";
echo "  ElectroStore - Database Migration & Seeding Tool\n";
echo "=========================================================\n\n";

$options = getopt("", ["driver::", "force"]);
$driver = $options['driver'] ?? 'auto';

$dbConfigFile = __DIR__ . '/../app/config/database.php';
$config = file_exists($dbConfigFile) ? require $dbConfigFile : [
    'driver' => 'auto',
    'mysql' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'database' => 'electro_db',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4'
    ],
    'sqlite' => [
        'path' => __DIR__ . '/electro.sqlite'
    ]
];

$pdo = null;
$selectedDriver = null;

if ($driver === 'sqlite' || ($driver === 'auto' && empty($config['mysql']['host']))) {
    $selectedDriver = 'sqlite';
} else {
    // Try MySQL first
    try {
        $dsn = sprintf(
            "mysql:host=%s;port=%s;charset=%s",
            $config['mysql']['host'],
            $config['mysql']['port'],
            $config['mysql']['charset']
        );
        $tempPdo = new PDO($dsn, $config['mysql']['username'], $config['mysql']['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        $tempPdo->exec("CREATE DATABASE IF NOT EXISTS `{$config['mysql']['database']}` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
        $tempPdo = null;

        $dsnDb = sprintf(
            "mysql:host=%s;port=%s;dbname=%s;charset=%s",
            $config['mysql']['host'],
            $config['mysql']['port'],
            $config['mysql']['database'],
            $config['mysql']['charset']
        );
        $pdo = new PDO($dsnDb, $config['mysql']['username'], $config['mysql']['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        $selectedDriver = 'mysql';
        echo "[INFO] Connected to MySQL successfully.\n";
    } catch (Exception $e) {
        if ($driver === 'mysql') {
            die("[ERROR] MySQL connection failed: " . $e->getMessage() . "\n");
        }
        echo "[WARN] MySQL connection failed ({$e->getMessage()}). Switching to SQLite fallback...\n";
        $selectedDriver = 'sqlite';
    }
}

if ($selectedDriver === 'sqlite') {
    $sqlitePath = $config['sqlite']['path'];
    $pdo = new PDO("sqlite:" . $sqlitePath, null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    echo "[INFO] Using SQLite database at: {$sqlitePath}\n";

    $schemaFile = __DIR__ . '/schema_sqlite.sql';
    $seedFile = __DIR__ . '/seed_sqlite.sql';
} else {
    $schemaFile = __DIR__ . '/schema.sql';
    $seedFile = __DIR__ . '/seed.sql';
}

echo "[INFO] Running schema from: " . basename($schemaFile) . "...\n";
$schemaSql = file_get_contents($schemaFile);
$pdo->exec($schemaSql);
echo "[OK] Tables created.\n";

echo "[INFO] Seeding initial data from: " . basename($seedFile) . "...\n";
$seedSql = file_get_contents($seedFile);
$pdo->exec($seedSql);

// Guarantee 100% valid bcrypt hashes using runtime password_hash()
$adminHash = password_hash('admin123', PASSWORD_BCRYPT);
$customerHash = password_hash('user123', PASSWORD_BCRYPT);
$pdo->prepare("UPDATE users SET password_hash = ? WHERE id = 1")->execute([$adminHash]);
$pdo->prepare("UPDATE users SET password_hash = ? WHERE id = 2")->execute([$customerHash]);
echo "[OK] Initial data seeded with verified bcrypt credentials.\n\n";

$stmt = $pdo->query("SELECT COUNT(*) as cnt FROM products");
$prodCount = $stmt->fetch()['cnt'];
echo "=========================================================\n";
echo "  Migration Complete! {$prodCount} products ready in {$selectedDriver}.\n";
echo "=========================================================\n";
