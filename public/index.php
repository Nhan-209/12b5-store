<?php
/**
 * ElectroStore - Modern Electronics E-Commerce Web Application
 * Front Controller & Routing Engine
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set BASE_URL for XAMPP compatibility
$scriptDir = dirname($_SERVER['SCRIPT_NAME'] ?? '');
define('BASE_URL', $scriptDir === '/' || $scriptDir === '\\' ? '' : rtrim($scriptDir, '/'));

// Simple PSR-4 style autoloader with Linux case-insensitivity tolerance
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/../app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $path = str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($baseDir . $path)) {
        require_once $baseDir . $path;
        return;
    }

    // Try lowercase directory for Linux ext4 case-sensitive filesystem
    $parts = explode('/', $path);
    if (count($parts) > 1) {
        $parts[0] = strtolower($parts[0]);
        $fallback = $baseDir . implode('/', $parts);
        if (file_exists($fallback)) {
            require_once $fallback;
            return;
        }
    }
});

// Normalize request path (supports both root and Apache/XAMPP subfolder execution)
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$parsedUrl = parse_url($requestUri);
$path = $parsedUrl['path'] ?? '/';

$scriptDir = dirname($_SERVER['SCRIPT_NAME'] ?? '');
if ($scriptDir !== '/' && $scriptDir !== '\\' && !empty($scriptDir) && str_starts_with($path, $scriptDir)) {
    $path = substr($path, strlen($scriptDir));
}
$path = '/' . trim($path, '/');
if ($path === '//') {
    $path = '/';
}

// Router dispatch
try {
    if ($path === '/') {
        (new \App\Controllers\HomeController())->index();
    } elseif ($path === '/products') {
        (new \App\Controllers\ProductController())->index();
    } elseif ($path === '/product/review') {
        (new \App\Controllers\ProductController())->addReview();
    } elseif (preg_match('#^/product/([a-zA-Z0-9_-]+)$#', $path, $matches)) {
        (new \App\Controllers\ProductController())->detail($matches[1]);
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
    } elseif ($path === '/admin/products/delete') {
        $id = (int)($_POST['id'] ?? 0);
        (new \App\Controllers\AdminController())->deleteProduct($id);
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
        if (file_exists(__DIR__ . '/../app/views/errors/404.php')) {
            require __DIR__ . '/../app/views/errors/404.php';
        } else {
            echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>404 Not Found - ElectroStore</title><link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css'></head><body class='bg-light d-flex align-items-center justify-content-center' style='min-height: 100vh;'><div class='text-center p-5 bg-white rounded-4 shadow-sm'><h1>404</h1><p class='lead'>Không tìm thấy trang yêu cầu.</p><a href='/' class='btn btn-primary'>Về trang chủ</a></div></body></html>";
        }
    }
} catch (\Throwable $e) {
    error_log($e->getMessage());
    http_response_code(500);
    $errorMessage = 'Đã xảy ra sự cố hệ thống. Vui lòng thử lại sau.';
    try {
        if (file_exists(__DIR__ . '/../app/views/errors/500.php')) {
            require __DIR__ . '/../app/views/errors/500.php';
        } else {
            echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>500 Error - ElectroStore</title><link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css'></head><body class='bg-light d-flex align-items-center justify-content-center' style='min-height: 100vh;'><div class='text-center p-5 bg-white rounded-4 shadow-sm' style='max-width: 500px;'><h1 class='display-4 text-danger fw-bold'>500</h1><p class='lead'>Đã xảy ra sự cố hệ thống. Vui lòng thử lại sau.</p><a href='/' class='btn btn-primary'>Về trang chủ</a></div></body></html>";
        }
    } catch (\Throwable $renderEx) {
        error_log($renderEx->getMessage());
        echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>500 Error - ElectroStore</title><link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css'></head><body class='bg-light d-flex align-items-center justify-content-center' style='min-height: 100vh;'><div class='text-center p-5 bg-white rounded-4 shadow-sm' style='max-width: 500px;'><h1 class='display-4 text-danger fw-bold'>500</h1><p class='lead'>Đã xảy ra sự cố hệ thống. Vui lòng thử lại sau.</p><a href='/' class='btn btn-primary'>Về trang chủ</a></div></body></html>";
    }
}
