<?php
namespace App\Controllers;

use App\Models\Cart;
use App\Models\Order;

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
            'notes' => $notes
        ];

        $res = Order::createOrder($orderData, $cart['items']);

        if (!$res['success']) {
            $_SESSION['flash_error'] = $res['message'];
            header('Location: /cart');
            exit;
        }

        // Clear cart after successful order
        Cart::clear();

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
