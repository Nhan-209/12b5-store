<?php
namespace App\Models;

use PDO;

class User {
    public static function findById(int $id): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT id, name, email, phone, address, role, created_at FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function findByEmail(string $email): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(array $data): int {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO users (name, email, password_hash, phone, address, role)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
        $role = $data['role'] ?? 'customer';
        $stmt->execute([
            $data['name'],
            $data['email'],
            $passwordHash,
            $data['phone'] ?? null,
            $data['address'] ?? null,
            $role
        ]);
        return (int)$pdo->lastInsertId();
    }

    public static function verifyCredentials(string $email, string $password): ?array {
        $user = self::findByEmail($email);
        if (!$user) {
            return null;
        }
        if (password_verify($password, $user['password_hash'])) {
            unset($user['password_hash']);
            return $user;
        }
        return null;
    }

    public static function updateProfile(int $id, array $data): bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE users SET name = ?, phone = ?, address = ? WHERE id = ?");
        return $stmt->execute([
            $data['name'],
            $data['phone'] ?? null,
            $data['address'] ?? null,
            $id
        ]);
    }

    public static function all(int $limit = 100): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT id, name, email, phone, address, role, created_at FROM users ORDER BY id DESC LIMIT ?");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
