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

        // Check ownership: allow admin, owner user, or guest session who placed the order
        $currentUser = $_SESSION['user'] ?? null;
        $lastOrderCode = $_SESSION['last_order_code'] ?? '';
        $isAuthorized = false;

        if ($currentUser && ($currentUser['role'] === 'admin' || (isset($order['user_id']) && (int)$order['user_id'] === (int)$currentUser['id']))) {
            $isAuthorized = true;
        } elseif (!empty($lastOrderCode) && hash_equals($lastOrderCode, $order['order_code'])) {
            $isAuthorized = true;
        }

        if (!$isAuthorized) {
            $_SESSION['flash_error'] = 'Bạn không có quyền truy cập hoặc xem chi tiết đơn hàng này.';
            header('Location: ' . (!empty($currentUser) ? '/orders' : '/'));
            exit;
        }

        require __DIR__ . '/../views/orders/detail.php';
    }
}
