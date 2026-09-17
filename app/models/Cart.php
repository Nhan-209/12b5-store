<?php
namespace App\Models;

use PDO;

class Cart {
    public static function getCart(int $userId = 0, string $sessionId = ''): array {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Use PHP Session as primary fast storage
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $items = [];
        $total = 0.0;
        $totalItems = 0;

        foreach ($_SESSION['cart'] as $productId => $item) {
            $product = Product::findById((int)$productId);
            if ($product) {
                $subtotal = (float)$product['price'] * (int)$item['quantity'];
                $items[] = [
                    'product_id' => $product['id'],
                    'name' => $product['name'],
                    'slug' => $product['slug'],
                    'sku' => $product['sku'],
                    'thumbnail' => $product['thumbnail'],
                    'price' => (float)$product['price'],
                    'formatted_price' => $product['formatted_price'],
                    'stock' => (int)$product['stock'],
                    'quantity' => (int)$item['quantity'],
                    'subtotal' => $subtotal,
                    'formatted_subtotal' => number_format($subtotal, 0, ',', '.') . ' ₫'
                ];
                $total += $subtotal;
                $totalItems += (int)$item['quantity'];
            }
        }

        // Coupon calculation
        $coupon = $_SESSION['coupon'] ?? null;
        $discountAmount = 0.0;
        if ($coupon && $total >= (float)($coupon['min_order_value'] ?? 0)) {
            if ($coupon['discount_type'] === 'percent') {
                $discountAmount = $total * ((float)$coupon['discount_value'] / 100);
            } else {
                $discountAmount = (float)$coupon['discount_value'];
            }
            if ($discountAmount > $total) {
                $discountAmount = $total;
            }
        } else if ($coupon) {
            // Min order value not met, reset coupon
            unset($_SESSION['coupon']);
            $coupon = null;
        }

        $finalAmount = max(0.0, $total - $discountAmount);

        return [
            'items' => $items,
            'total_items' => $totalItems,
            'subtotal' => $total,
            'formatted_subtotal' => number_format($total, 0, ',', '.') . ' ₫',
            'discount_amount' => $discountAmount,
            'formatted_discount' => number_format($discountAmount, 0, ',', '.') . ' ₫',
            'final_amount' => $finalAmount,
            'formatted_final_amount' => number_format($finalAmount, 0, ',', '.') . ' ₫',
            'coupon' => $coupon
        ];
    }

    public static function addItem(int $productId, int $quantity = 1): array {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $product = Product::findById($productId);
        if (!$product) {
            return ['success' => false, 'message' => 'Sản phẩm không tồn tại.'];
        }

        $currentQty = $_SESSION['cart'][$productId]['quantity'] ?? 0;
        $newQty = $currentQty + $quantity;

        if ($newQty > (int)$product['stock']) {
            return [
                'success' => false,
                'message' => 'Số lượng yêu cầu vượt quá số lượng tồn kho còn lại (' . $product['stock'] . ' sản phẩm).'
            ];
        }

        $_SESSION['cart'][$productId] = [
            'quantity' => $newQty
        ];

        return [
            'success' => true,
            'message' => 'Đã thêm sản phẩm vào giỏ hàng thành công!',
            'cart' => self::getCart()
        ];
    }

    public static function updateQuantity(int $productId, int $quantity): array {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($quantity <= 0) {
            return self::removeItem($productId);
        }

        $product = Product::findById($productId);
        if (!$product) {
            return ['success' => false, 'message' => 'Sản phẩm không tồn tại.'];
        }

        if ($quantity > (int)$product['stock']) {
            return [
                'success' => false,
                'message' => 'Tồn kho chỉ còn ' . $product['stock'] . ' sản phẩm.'
            ];
        }

        $_SESSION['cart'][$productId] = [
            'quantity' => $quantity
        ];

        return [
            'success' => true,
            'message' => 'Đã cập nhật số lượng.',
            'cart' => self::getCart()
        ];
    }

    public static function removeItem(int $productId): array {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }

        return [
            'success' => true,
            'message' => 'Đã xóa sản phẩm khỏi giỏ hàng.',
            'cart' => self::getCart()
        ];
    }

    public static function applyCoupon(string $code): array {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM coupons WHERE code = ? AND status = 1");
        $stmt->execute([strtoupper(trim($code))]);
        $coupon = $stmt->fetch();

        if (!$coupon) {
            return ['success' => false, 'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn.'];
        }

        $cart = self::getCart();
        if ($cart['subtotal'] < (float)$coupon['min_order_value']) {
            return [
                'success' => false,
                'message' => 'Đơn hàng tối thiểu ' . number_format((float)$coupon['min_order_value'], 0, ',', '.') . ' ₫ để sử dụng mã này.'
            ];
        }

        $_SESSION['coupon'] = $coupon;
        return [
            'success' => true,
            'message' => 'Áp dụng mã giảm giá thành công!',
            'cart' => self::getCart()
        ];
    }

    public static function clear(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['cart'] = [];
        unset($_SESSION['coupon']);
    }
}
