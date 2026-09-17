<?php
namespace App\Models;

use PDO;

class Brand {
    public static function all(): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT b.*, (SELECT COUNT(*) FROM products p WHERE p.brand_id = b.id AND p.status = 1) as product_count FROM brands b ORDER BY b.name ASC");
        return $stmt->fetchAll();
    }

    public static function findById(int $id): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM brands WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function findBySlug(string $slug): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM brands WHERE slug = ?");
        $stmt->execute([$slug]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
}
