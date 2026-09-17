<?php
/**
 * ElectroStore - Modern Electronics E-Commerce Web Application
 * Front Controller & Routing Engine
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Simple PSR-4 style autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/../app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// Normalize request path
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$parsedUrl = parse_url($requestUri);
$path = rtrim($parsedUrl['path'] ?? '/', '/');
if (empty($path)) {
    $path = '/';
}

// Router dispatch
try {
    if ($path === '/') {
        (new \App\Controllers\HomeController())->index();
    } elseif ($path === '/products') {
        (new \App\Controllers\ProductController())->index();
    } elseif (preg_match('#^/product/([a-zA-Z0-9_-]+)$#', $path, $matches)) {
        (new \App\Controllers\ProductController())->detail($matches[1]);
    } elseif ($path === '/product/review') {
        (new \App\Controllers\ProductController())->addReview();
    } elseif ($path === '/cart') {
        (new \App\Controllers\CartController())->index();
    } elseif ($path === '/cart/add') {
        (new \App\Controllers\CartController())->add();
    } elseif ($path === '/cart/update') {
        (new \App\Controllers\CartController())->update();
    } elseif ($path === '/cart/remove') {
        (new \App\Controllers\CartController())->remove();
    } elseif ($path === '/cart/coupon') {
        (new \App\Controllers\CartController())->applyCoupon();
    } elseif ($path === '/checkout') {
        (new \App\Controllers\CheckoutController())->index();
    } elseif ($path === '/checkout/process') {
        (new \App\Controllers\CheckoutController())->process();
    } elseif ($path === '/checkout/success') {
        (new \App\Controllers\CheckoutController())->success();
    } elseif ($path === '/orders') {
        (new \App\Controllers\OrderController())->index();
    } elseif (preg_match('#^/order/([a-zA-Z0-9_-]+)$#', $path, $matches)) {
        (new \App\Controllers\OrderController())->detail($matches[1]);
    } elseif ($path === '/login') {
        (new \App\Controllers\AuthController())->login();
    } elseif ($path === '/register') {
        (new \App\Controllers\AuthController())->register();
    } elseif ($path === '/logout') {
        (new \App\Controllers\AuthController())->logout();
    } elseif ($path === '/profile') {
        (new \App\Controllers\AuthController())->profile();
    } elseif ($path === '/admin') {
        (new \App\Controllers\AdminController())->dashboard();
    } elseif ($path === '/admin/products') {
        (new \App\Controllers\AdminController())->products();
    } elseif ($path === '/admin/products/create') {
        (new \App\Controllers\AdminController())->createProduct();
    } elseif (preg_match('#^/admin/products/edit/([0-9]+)$#', $path, $matches)) {
        (new \App\Controllers\AdminController())->editProduct((int)$matches[1]);
    } elseif (preg_match('#^/admin/products/delete/([0-9]+)$#', $path, $matches)) {
        (new \App\Controllers\AdminController())->deleteProduct((int)$matches[1]);
    } elseif ($path === '/admin/orders') {
        (new \App\Controllers\AdminController())->orders();
    } elseif ($path === '/admin/orders/update-status') {
        (new \App\Controllers\AdminController())->updateOrderStatus();
    } elseif ($path === '/admin/users') {
        (new \App\Controllers\AdminController())->users();
    } elseif ($path === '/api/cart-count') {
        (new \App\Controllers\ApiController())->cartCount();
    } elseif ($path === '/api/live-search') {
        (new \App\Controllers\ApiController())->liveSearch();
    } elseif ($path === '/api/rust-status') {
        (new \App\Controllers\ApiController())->rustStatus();
    } else {
        http_response_code(404);
        echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>404 Not Found - ElectroStore</title><link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css'></head><body class='bg-light d-flex align-items-center justify-content-center' style='min-height: 100vh;'><div class='text-center p-5 bg-white rounded-4 shadow-sm'><h1>404</h1><p class='lead'>Không tìm thấy trang yêu cầu.</p><a href='/' class='btn btn-primary'>Về trang chủ</a></div></body></html>";
    }
} catch (\Throwable $e) {
    http_response_code(500);
    echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>500 Error - ElectroStore</title><link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css'></head><body class='bg-light p-5'><div class='container'><div class='alert alert-danger shadow-sm rounded-4 p-4'><h4>Đã xảy ra lỗi hệ thống!</h4><p class='mb-0'>" . htmlspecialchars($e->getMessage()) . "</p></div><a href='/' class='btn btn-secondary mt-3'>Về trang chủ</a></div></body></html>";
}
