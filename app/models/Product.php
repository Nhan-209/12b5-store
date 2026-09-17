<?php
namespace App\Models;

use PDO;

class Product {
    public static function all(int $limit = 50, int $offset = 0): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT p.*, c.name as category_name, c.slug as category_slug, b.name as brand_name, b.slug as brand_slug
            FROM products p
            JOIN categories c ON p.category_id = c.id
            JOIN brands b ON p.brand_id = b.id
            WHERE p.status = 1
            ORDER BY p.id DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll();
        return array_map([self::class, 'formatProduct'], $products);
    }

    public static function getFeatured(int $limit = 8): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT p.*, c.name as category_name, c.slug as category_slug, b.name as brand_name, b.slug as brand_slug
            FROM products p
            JOIN categories c ON p.category_id = c.id
            JOIN brands b ON p.brand_id = b.id
            WHERE p.status = 1 AND p.featured = 1
            ORDER BY p.sales_count DESC, p.id DESC
            LIMIT ?
        ");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll();
        return array_map([self::class, 'formatProduct'], $products);
    }

    public static function getLatest(int $limit = 8): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT p.*, c.name as category_name, c.slug as category_slug, b.name as brand_name, b.slug as brand_slug
            FROM products p
            JOIN categories c ON p.category_id = c.id
            JOIN brands b ON p.brand_id = b.id
            WHERE p.status = 1
            ORDER BY p.created_at DESC
            LIMIT ?
        ");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll();
        return array_map([self::class, 'formatProduct'], $products);
    }

    public static function findById(int $id): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT p.*, c.name as category_name, c.slug as category_slug, b.name as brand_name, b.slug as brand_slug
            FROM products p
            JOIN categories c ON p.category_id = c.id
            JOIN brands b ON p.brand_id = b.id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? self::formatProduct($row) : null;
    }

    public static function findBySlug(string $slug): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT p.*, c.name as category_name, c.slug as category_slug, b.name as brand_name, b.slug as brand_slug
            FROM products p
            JOIN categories c ON p.category_id = c.id
            JOIN brands b ON p.brand_id = b.id
            WHERE p.slug = ?
        ");
        $stmt->execute([$slug]);
        $row = $stmt->fetch();
        return $row ? self::formatProduct($row) : null;
    }

    public static function filter(array $filters = []): array {
        $pdo = Database::getConnection();
        $sql = "
            SELECT p.*, c.name as category_name, c.slug as category_slug, b.name as brand_name, b.slug as brand_slug
            FROM products p
            JOIN categories c ON p.category_id = c.id
            JOIN brands b ON p.brand_id = b.id
            WHERE p.status = 1
        ";
        $params = [];

        if (!empty($filters['category_id'])) {
            $sql .= " AND p.category_id = ?";
            $params[] = (int)$filters['category_id'];
        }
        if (!empty($filters['category_slug'])) {
            $sql .= " AND c.slug = ?";
            $params[] = $filters['category_slug'];
        }
        if (!empty($filters['brand_id'])) {
            $sql .= " AND p.brand_id = ?";
            $params[] = (int)$filters['brand_id'];
        }
        if (!empty($filters['brand_slug'])) {
            $sql .= " AND b.slug = ?";
            $params[] = $filters['brand_slug'];
        }
        if (!empty($filters['min_price'])) {
            $sql .= " AND p.price >= ?";
            $params[] = (float)$filters['min_price'];
        }
        if (!empty($filters['max_price'])) {
            $sql .= " AND p.price <= ?";
            $params[] = (float)$filters['max_price'];
        }
        if (!empty($filters['keyword'])) {
            $sql .= " AND (p.name LIKE ? OR p.short_description LIKE ? OR p.sku LIKE ?)";
            $kw = "%" . $filters['keyword'] . "%";
            $params[] = $kw;
            $params[] = $kw;
            $params[] = $kw;
        }

        // Sorting
        $sort = $filters['sort'] ?? 'newest';
        switch ($sort) {
            case 'price_asc':
                $sql .= " ORDER BY p.price ASC";
                break;
            case 'price_desc':
                $sql .= " ORDER BY p.price DESC";
                break;
            case 'best_seller':
                $sql .= " ORDER BY p.sales_count DESC";
                break;
            case 'rating':
                $sql .= " ORDER BY p.rating DESC";
                break;
            case 'newest':
            default:
                $sql .= " ORDER BY p.id DESC";
                break;
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();
        return array_map([self::class, 'formatProduct'], $rows);
    }

    public static function create(array $data): int {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO products (category_id, brand_id, name, slug, sku, price, original_price, stock, featured, status, thumbnail, short_description, description, specs)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['category_id'],
            $data['brand_id'],
            $data['name'],
            $data['slug'],
            $data['sku'],
            $data['price'],
            $data['original_price'] ?? null,
            $data['stock'] ?? 0,
            $data['featured'] ?? 0,
            $data['status'] ?? 1,
            $data['thumbnail'] ?? null,
            $data['short_description'] ?? null,
            $data['description'] ?? null,
            is_array($data['specs']) ? json_encode($data['specs'], JSON_UNESCAPED_UNICODE) : $data['specs']
        ]);
        return (int)$pdo->lastInsertId();
    }

    public static function update(int $id, array $data): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            UPDATE products
            SET category_id = ?, brand_id = ?, name = ?, slug = ?, sku = ?, price = ?, original_price = ?, stock = ?, featured = ?, status = ?, thumbnail = ?, short_description = ?, description = ?, specs = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['category_id'],
            $data['brand_id'],
            $data['name'],
            $data['slug'],
            $data['sku'],
            $data['price'],
            $data['original_price'] ?? null,
            $data['stock'] ?? 0,
            $data['featured'] ?? 0,
            $data['status'] ?? 1,
            $data['thumbnail'] ?? null,
            $data['short_description'] ?? null,
            $data['description'] ?? null,
            is_array($data['specs']) ? json_encode($data['specs'], JSON_UNESCAPED_UNICODE) : $data['specs'],
            $id
        ]);
    }

    public static function delete(int $id): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function updateStock(int $id, int $quantityDiff): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE products SET stock = stock + ? WHERE id = ? AND stock + ? >= 0");
        return $stmt->execute([$quantityDiff, $id, $quantityDiff]);
    }

    public static function getReviews(int $productId): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM reviews WHERE product_id = ? ORDER BY created_at DESC");
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }

    public static function addReview(int $productId, ?int $userId, string $userName, int $rating, string $comment): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO reviews (product_id, user_id, user_name, rating, comment) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$productId, $userId, $userName, $rating, $comment]);
    }

    private static function formatProduct(array $p): array {
        if (!empty($p['specs']) && is_string($p['specs'])) {
            $decoded = json_decode($p['specs'], true);
            $p['specs_array'] = is_array($decoded) ? $decoded : [];
        } else {
            $p['specs_array'] = is_array($p['specs'] ?? null) ? $p['specs'] : [];
        }
        $p['formatted_price'] = number_format((float)$p['price'], 0, ',', '.') . ' ₫';
        if (!empty($p['original_price']) && (float)$p['original_price'] > (float)$p['price']) {
            $p['formatted_original_price'] = number_format((float)$p['original_price'], 0, ',', '.') . ' ₫';
            $p['discount_percent'] = round((1 - ((float)$p['price'] / (float)$p['original_price'])) * 100);
        } else {
            $p['formatted_original_price'] = null;
            $p['discount_percent'] = 0;
        }
        return $p;
    }
}
