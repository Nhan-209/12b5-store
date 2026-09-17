<?php
namespace App\Controllers;

use App\Models\Order;

class OrderController {
    public function index(): void {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $userId = (int)$_SESSION['user']['id'];
        $orders = Order::getByUser($userId);

        require __DIR__ . '/../views/orders/index.php';
    }

    public function detail(string $orderCode): void {
        $order = Order::findByCode($orderCode);
        if (!$order) {
            header('Location: /orders');
            exit;
        }

        // Check ownership if not admin
        $currentUser = $_SESSION['user'] ?? null;
        if (!$currentUser || ($currentUser['role'] !== 'admin' && (int)$order['user_id'] !== (int)$currentUser['id'])) {
            // Allow if guest tracking by exact code
        }

        require __DIR__ . '/../views/orders/detail.php';
    }
}
