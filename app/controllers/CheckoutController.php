<?php
namespace App\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Core\Csrf;

class CheckoutController {
    public function index(): void {
        $cart = Cart::getCart();
        if (empty($cart['items'])) {
            header('Location: /cart');
            exit;
        }

        $user = $_SESSION['user'] ?? null;
        require __DIR__ . '/../views/checkout/index.php';
    }

    public function process(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /checkout');
            exit;
        }

        if (!Csrf::validate()) {
            $_SESSION['flash_error'] = 'Mã bảo mật CSRF không hợp lệ hoặc phiên đã hết hạn. Vui lòng thử lại.';
            header('Location: /checkout');
            exit;
        }

        $cart = Cart::getCart();
        if (empty($cart['items'])) {
            $_SESSION['flash_error'] = 'Giỏ hàng của bạn đang trống.';
            header('Location: /cart');
            exit;
        }

        $name = trim($_POST['customer_name'] ?? '');
        $email = trim($_POST['customer_email'] ?? '');
        $phone = trim($_POST['customer_phone'] ?? '');
        $address = trim($_POST['shipping_address'] ?? '');
        $paymentMethod = $_POST['payment_method'] ?? 'cod';
        $notes = trim($_POST['notes'] ?? '');

        $allowedPaymentMethods = ['cod', 'bank_transfer'];
        if (!in_array($paymentMethod, $allowedPaymentMethods, true)) {
            $_SESSION['flash_error'] = 'Phương thức thanh toán không hợp lệ.';
            header('Location: /checkout');
            exit;
        }

        if (empty($name) || empty($email) || empty($phone) || empty($address)) {
            $_SESSION['flash_error'] = 'Vui lòng điền đầy đủ các thông tin bắt buộc.';
            header('Location: /checkout');
            exit;
        }

        $orderData = [
            'user_id' => $_SESSION['user']['id'] ?? null,
            'customer_name' => $name,
            'customer_email' => $email,
            'customer_phone' => $phone,
            'shipping_address' => $address,
            'payment_method' => $paymentMethod,
            'total_amount' => $cart['subtotal'],
            'discount_amount' => $cart['discount_amount'],
            'final_amount' => $cart['final_amount'],
            'notes' => $notes,
            'coupon_code' => $cart['coupon']['code'] ?? null
        ];

        $res = Order::createOrder($orderData, $cart['items']);

        if (!$res['success']) {
            $_SESSION['flash_error'] = $res['message'];
            header('Location: /cart');
            exit;
        }

        // Clear cart after successful order
        Cart::clear();

        // Store authorized order code and ID in session
        $_SESSION['last_order_code'] = $res['order_code'];
        $_SESSION['last_order_id'] = $res['order_id'] ?? null;

        header('Location: /checkout/success?code=' . urlencode($res['order_code']));
        exit;
    }

    public function success(): void {
        $code = trim($_GET['code'] ?? '');
        if (empty($code)) {
            header('Location: /');
            exit;
        }

        $order = Order::findByCode($code);
        if (!$order) {
            header('Location: /');
            exit;
        }

        // Authorization check: User must be order owner or possess current session's last_order_code, or be an admin
        $currentUserId = $_SESSION['user']['id'] ?? null;
        $currentUserRole = $_SESSION['user']['role'] ?? '';
        $lastOrderCode = $_SESSION['last_order_code'] ?? '';

        $isAuthorized = false;
        if ($currentUserRole === 'admin') {
            $isAuthorized = true;
        } elseif ($currentUserId !== null && !empty($order['user_id']) && (int)$order['user_id'] === (int)$currentUserId) {
            $isAuthorized = true;
        } elseif (!empty($lastOrderCode) && hash_equals($lastOrderCode, $order['order_code'])) {
            $isAuthorized = true;
        }

        if (!$isAuthorized) {
            $_SESSION['flash_error'] = 'Bạn không có quyền truy cập hoặc xem chi tiết đơn hàng này.';
            header('Location: /');
            exit;
        }

        // Generate simulated VietQR code info if bank transfer
        $qrUrl = null;
        if ($order['payment_method'] === 'bank_transfer') {
            $bankId = 'MB'; // MBBank
            $accountNo = '0901234567';
            $template = 'compact2';
            $amount = (int)$order['final_amount'];
            $description = urlencode($order['order_code']);
            $qrUrl = "https://img.vietqr.io/image/{$bankId}-{$accountNo}-{$template}.png?amount={$amount}&addInfo={$description}&accountName=CONG%20TY%20CONG%20NGHE%2012B5%20STORE";
        }

        require __DIR__ . '/../views/checkout/success.php';
    }
}
