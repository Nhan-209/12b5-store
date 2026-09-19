<?php
namespace App\Controllers;

use App\Models\Cart;
use App\Core\Csrf;

class CartController {
    public function index(): void {
        $cart = Cart::getCart();
        require __DIR__ . '/../views/cart/index.php';
    }

    public function add(): void {
        if (!Csrf::validate()) {
            if ($this->isAjax()) {
                http_response_code(403);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'CSRF token không hợp lệ hoặc phiên đã hết hạn.']);
                exit;
            }
            $_SESSION['flash_error'] = 'Phiên làm việc không hợp lệ (CSRF). Vui lòng thử lại.';
            header('Location: ' . BASE_URL . '/cart');
            exit;
        }

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

        header('Location: ' . BASE_URL . '/cart');
        exit;
    }

    public function update(): void {
        if (!Csrf::validate()) {
            if ($this->isAjax()) {
                http_response_code(403);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'CSRF token không hợp lệ hoặc phiên đã hết hạn.']);
                exit;
            }
            $_SESSION['flash_error'] = 'Phiên làm việc không hợp lệ (CSRF). Vui lòng thử lại.';
            header('Location: ' . BASE_URL . '/cart');
            exit;
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 1);

        $res = Cart::updateQuantity($productId, $quantity);

        if ($this->isAjax()) {
            header('Content-Type: application/json');
            echo json_encode($res);
            exit;
        }

        header('Location: ' . BASE_URL . '/cart');
        exit;
    }

    public function remove(): void {
        if (!Csrf::validate()) {
            if ($this->isAjax()) {
                http_response_code(403);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'CSRF token không hợp lệ hoặc phiên đã hết hạn.']);
                exit;
            }
            $_SESSION['flash_error'] = 'Phiên làm việc không hợp lệ (CSRF). Vui lòng thử lại.';
            header('Location: ' . BASE_URL . '/cart');
            exit;
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        $res = Cart::removeItem($productId);

        if ($this->isAjax()) {
            header('Content-Type: application/json');
            echo json_encode($res);
            exit;
        }

        header('Location: ' . BASE_URL . '/cart');
        exit;
    }

    public function applyCoupon(): void {
        if (!Csrf::validate()) {
            if ($this->isAjax()) {
                http_response_code(403);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'CSRF token không hợp lệ hoặc phiên đã hết hạn.']);
                exit;
            }
            $_SESSION['flash_error'] = 'Phiên làm việc không hợp lệ (CSRF). Vui lòng thử lại.';
            header('Location: ' . BASE_URL . '/cart');
            exit;
        }

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

        header('Location: ' . BASE_URL . '/cart');
        exit;
    }

    private function isAjax(): bool {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);
    }
}
