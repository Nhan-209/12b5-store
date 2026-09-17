<?php
namespace App\Controllers;

use App\Models\Cart;

class CartController {
    public function index(): void {
        $cart = Cart::getCart();
        require __DIR__ . '/../views/cart/index.php';
    }

    public function add(): void {
        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity = max(1, (int)($_POST['quantity'] ?? 1));

        $res = Cart::addItem($productId, $quantity);

        if ($this->isAjax()) {
            header('Content-Type: application/json');
            echo json_encode($res);
            exit;
        }

        if (!$res['success']) {
            $_SESSION['flash_error'] = $res['message'];
        } else {
            $_SESSION['flash_success'] = $res['message'];
        }

        header('Location: /cart');
        exit;
    }

    public function update(): void {
        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 1);

        $res = Cart::updateQuantity($productId, $quantity);

        if ($this->isAjax()) {
            header('Content-Type: application/json');
            echo json_encode($res);
            exit;
        }

        header('Location: /cart');
        exit;
    }

    public function remove(): void {
        $productId = (int)($_POST['product_id'] ?? 0);
        $res = Cart::removeItem($productId);

        if ($this->isAjax()) {
            header('Content-Type: application/json');
            echo json_encode($res);
            exit;
        }

        header('Location: /cart');
        exit;
    }

    public function applyCoupon(): void {
        $code = trim($_POST['coupon_code'] ?? '');
        $res = Cart::applyCoupon($code);

        if ($this->isAjax()) {
            header('Content-Type: application/json');
            echo json_encode($res);
            exit;
        }

        if (!$res['success']) {
            $_SESSION['flash_error'] = $res['message'];
        } else {
            $_SESSION['flash_success'] = $res['message'];
        }

        header('Location: /cart');
        exit;
    }

    private function isAjax(): bool {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);
    }
}
