<?php
namespace App\Models;

use PDO;
use Exception;

class Order {
    public static function createOrder(array $orderData, array $cartItems): array {
        $pdo = Database::getConnection();

        try {
            $pdo->beginTransaction();

            // 1. Double check stock and active status for all items
            foreach ($cartItems as $item) {
                $stmt = $pdo->prepare("SELECT stock, name, status FROM products WHERE id = ?");
                $stmt->execute([$item['product_id']]);
                $prod = $stmt->fetch();

                if (!$prod) {
                    $pdo->rollBack();
                    return [
                        'success' => false,
                        'message' => 'Sản phẩm ID ' . $item['product_id'] . ' không tồn tại.'
                    ];
                }

                if (isset($prod['status']) && (int)$prod['status'] === 0) {
                    $pdo->rollBack();
                    return [
                        'success' => false,
                        'message' => 'Sản phẩm "' . $prod['name'] . '" đã ngừng kinh doanh.'
                    ];
                }

                if ((int)$prod['stock'] < (int)$item['quantity']) {
                    $pdo->rollBack();
                    return [
                        'success' => false,
                        'message' => 'Sản phẩm "' . $prod['name'] . '" không đủ số lượng tồn kho.'
                    ];
                }
            }

            // 2. Insert Order record
            $orderCode = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
            $stmt = $pdo->prepare("
                INSERT INTO orders (
                    user_id, order_code, customer_name, customer_email, customer_phone,
                    shipping_address, payment_method, payment_status, order_status,
                    total_amount, discount_amount, final_amount, notes
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $orderData['user_id'] ?? null,
                $orderCode,
                $orderData['customer_name'],
                $orderData['customer_email'],
                $orderData['customer_phone'],
                $orderData['shipping_address'],
                $orderData['payment_method'] ?? 'cod',
                $orderData['payment_method'] === 'bank_transfer' ? 'pending' : 'pending',
                'pending',
                $orderData['total_amount'],
                $orderData['discount_amount'] ?? 0.0,
                $orderData['final_amount'],
                $orderData['notes'] ?? null
            ]);
            $orderId = (int)$pdo->lastInsertId();

            // 3. Insert Order items & decrease stock atomically
            $itemStmt = $pdo->prepare("
                INSERT INTO order_items (order_id, product_id, product_name, product_sku, unit_price, quantity, subtotal)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stockStmt = $pdo->prepare("UPDATE products SET stock = stock - ?, sales_count = sales_count + ? WHERE id = ? AND stock >= ?");

            foreach ($cartItems as $item) {
                $itemStmt->execute([
                    $orderId,
                    $item['product_id'],
                    $item['name'],
                    $item['sku'],
                    $item['price'],
                    $item['quantity'],
                    $item['subtotal']
                ]);
                $stockStmt->execute([
                    $item['quantity'],
                    $item['quantity'],
                    $item['product_id'],
                    $item['quantity']
                ]);
                if ($stockStmt->rowCount() === 0) {
                    $pdo->rollBack();
                    return [
                        'success' => false,
                        'message' => 'Sản phẩm "' . $item['name'] . '" không còn đủ số lượng trong kho.'
                    ];
                }
            }

            // 4. Increment coupon used_count if coupon was used
            if (!empty($orderData['coupon_code'])) {
                $couponStmt = $pdo->prepare("UPDATE coupons SET used_count = used_count + 1 WHERE code = ? AND (usage_limit IS NULL OR used_count < usage_limit)");
                $couponStmt->execute([$orderData['coupon_code']]);
                if ($couponStmt->rowCount() === 0) {
                    $pdo->rollBack();
                    return [
                        'success' => false,
                        'message' => 'Mã khuyến mãi "' . $orderData['coupon_code'] . '" đã vượt quá số lần sử dụng cho phép.'
                    ];
                }
            }

            $pdo->commit();

            return [
                'success' => true,
                'order_id' => $orderId,
                'order_code' => $orderCode,
                'final_amount' => $orderData['final_amount'],
                'message' => 'Đặt hàng thành công!'
            ];
        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            return [
                'success' => false,
                'message' => 'Lỗi khi tạo đơn hàng: ' . $e->getMessage()
            ];
        }
    }

    public static function findById(int $id): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$id]);
        $order = $stmt->fetch();
        if (!$order) return null;

        $itemsStmt = $pdo->prepare("SELECT oi.*, p.thumbnail FROM order_items oi LEFT JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
        $itemsStmt->execute([$id]);
        $order['items'] = $itemsStmt->fetchAll();
        $order['formatted_total'] = number_format((float)$order['total_amount'], 0, ',', '.') . ' ₫';
        $order['formatted_discount'] = number_format((float)$order['discount_amount'], 0, ',', '.') . ' ₫';
        $order['formatted_final'] = number_format((float)$order['final_amount'], 0, ',', '.') . ' ₫';
        return $order;
    }

    public static function findByCode(string $code): ?array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT id FROM orders WHERE order_code = ?");
        $stmt->execute([trim($code)]);
        $res = $stmt->fetch();
        return $res ? self::findById((int)$res['id']) : null;
    }

    public static function getByUser(int $userId): array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC");
        $stmt->execute([$userId]);
        $orders = $stmt->fetchAll();
        foreach ($orders as &$ord) {
            $ord['formatted_final'] = number_format((float)$ord['final_amount'], 0, ',', '.') . ' ₫';
        }
        return $orders;
    }

    public static function all(int $limit = 50, string $status = ''): array {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM orders";
        $params = [];
        if (!empty($status)) {
            $sql .= " WHERE order_status = ?";
            $params[] = $status;
        }
        $sql .= " ORDER BY id DESC LIMIT ?";
        $params[] = $limit;

        $stmt = $pdo->prepare($sql);
        foreach ($params as $idx => $val) {
            $stmt->bindValue($idx + 1, $val, is_int($val) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $stmt->execute();
        $orders = $stmt->fetchAll();
        foreach ($orders as &$ord) {
            $ord['formatted_final'] = number_format((float)$ord['final_amount'], 0, ',', '.') . ' ₫';
        }
        return $orders;
    }

    public static function updateStatus(int $id, string $status, ?string $paymentStatus = null): bool {
        $pdo = Database::getConnection();
        if ($paymentStatus !== null) {
            $stmt = $pdo->prepare("UPDATE orders SET order_status = ?, payment_status = ? WHERE id = ?");
            return $stmt->execute([$status, $paymentStatus, $id]);
        }
        $stmt = $pdo->prepare("UPDATE orders SET order_status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }
}
