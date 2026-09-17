<?php
namespace App\Models;

use PDO;

class Category {
    public static function all(): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT c.*, (SELECT COUNT(*) FROM products p WHERE p.category_id = c.id AND p.status = 1) as product_count FROM categories c ORDER BY c.id ASC");
        return $stmt->fetchAll();
    }

    public static function findById(int $id): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function findBySlug(string $slug): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE slug = ?");
        $stmt->execute([$slug]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
}
