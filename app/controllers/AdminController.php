<?php
namespace App\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;
use App\Models\User;
use App\Services\AnalyticsService;
use App\Services\RustEngineService;
use App\Core\Csrf;

class AdminController {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $user = $_SESSION['user'] ?? null;
        if (!$user || ($user['role'] ?? '') !== 'admin') {
            $_SESSION['flash_error'] = 'Bạn không có quyền truy cập khu vực Quản trị.';
            header('Location: /login');
            exit;
        }
    }

    public function dashboard(): void {
        $analyticsService = new AnalyticsService();
        $metrics = $analyticsService->getDashboardMetrics();

        $rustEngine = new RustEngineService();
        $isRustOnline = $rustEngine->isAvailable();

        $recentOrders = Order::all(5);
        $totalProducts = count(Product::all(100, 0));
        $totalUsers = count(User::all(100));

        require __DIR__ . '/../views/admin/dashboard.php';
    }

    public function products(): void {
        $products = Product::all(100, 0, null);
        $categories = Category::all();
        $brands = Brand::all();
        require __DIR__ . '/../views/admin/products.php';
    }

    public function createProduct(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Csrf::check();

            $name = trim($_POST['name'] ?? '');
            $slug = trim($_POST['slug'] ?? '');
            $sku = trim($_POST['sku'] ?? '');
            $categoryId = (int)($_POST['category_id'] ?? 1);
            $brandId = (int)($_POST['brand_id'] ?? 1);
            $price = (float)($_POST['price'] ?? 0);
            $originalPrice = !empty($_POST['original_price']) ? (float)$_POST['original_price'] : null;
            $stock = (int)($_POST['stock'] ?? 0);
            $featured = isset($_POST['featured']) ? 1 : 0;
            $thumbnail = trim($_POST['thumbnail'] ?? 'default-device.jpg');
            $shortDesc = trim($_POST['short_description'] ?? '');
            $description = trim($_POST['description'] ?? '');

            // Build specs array
            $specs = [];
            if (!empty($_POST['spec_cpu'])) $specs['cpu'] = trim($_POST['spec_cpu']);
            if (!empty($_POST['spec_ram'])) $specs['ram'] = trim($_POST['spec_ram']);
            if (!empty($_POST['spec_storage'])) $specs['storage'] = trim($_POST['spec_storage']);
            if (!empty($_POST['spec_screen'])) $specs['screen'] = trim($_POST['spec_screen']);
            if (!empty($_POST['spec_gpu'])) $specs['gpu'] = trim($_POST['spec_gpu']);
            if (!empty($_POST['spec_battery'])) $specs['battery'] = trim($_POST['spec_battery']);

            if (empty($slug)) {
                $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
            }
            if (empty($sku)) {
                $sku = 'EL-' . strtoupper(substr(uniqid(), -6));
            }

            Product::create([
                'name' => $name,
                'slug' => $slug,
                'sku' => $sku,
                'category_id' => $categoryId,
                'brand_id' => $brandId,
                'price' => $price,
                'original_price' => $originalPrice,
                'stock' => $stock,
                'featured' => $featured,
                'status' => 1,
                'thumbnail' => $thumbnail,
                'short_description' => $shortDesc,
                'description' => $description,
                'specs' => $specs
            ]);

            $_SESSION['flash_success'] = 'Đã thêm sản phẩm thiết bị điện tử mới thành công!';
            header('Location: /admin/products');
            exit;
        }

        $categories = Category::all();
        $brands = Brand::all();
        require __DIR__ . '/../views/admin/product_form.php';
    }

    public function editProduct(int $id): void {
        $product = Product::findById($id);
        if (!$product) {
            header('Location: /admin/products');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Csrf::check();

            $name = trim($_POST['name'] ?? '');
            $slug = trim($_POST['slug'] ?? '');
            $sku = trim($_POST['sku'] ?? '');
            $categoryId = (int)($_POST['category_id'] ?? 1);
            $brandId = (int)($_POST['brand_id'] ?? 1);
            $price = (float)($_POST['price'] ?? 0);
            $originalPrice = !empty($_POST['original_price']) ? (float)$_POST['original_price'] : null;
            $stock = (int)($_POST['stock'] ?? 0);
            $featured = isset($_POST['featured']) ? 1 : 0;
            $status = isset($_POST['status']) ? 1 : 0;
            $thumbnail = trim($_POST['thumbnail'] ?? $product['thumbnail']);
            $shortDesc = trim($_POST['short_description'] ?? '');
            $description = trim($_POST['description'] ?? '');

            $specs = [];
            if (!empty($_POST['spec_cpu'])) $specs['cpu'] = trim($_POST['spec_cpu']);
            if (!empty($_POST['spec_ram'])) $specs['ram'] = trim($_POST['spec_ram']);
            if (!empty($_POST['spec_storage'])) $specs['storage'] = trim($_POST['spec_storage']);
            if (!empty($_POST['spec_screen'])) $specs['screen'] = trim($_POST['spec_screen']);
            if (!empty($_POST['spec_gpu'])) $specs['gpu'] = trim($_POST['spec_gpu']);
            if (!empty($_POST['spec_battery'])) $specs['battery'] = trim($_POST['spec_battery']);

            Product::update($id, [
                'name' => $name,
                'slug' => $slug,
                'sku' => $sku,
                'category_id' => $categoryId,
                'brand_id' => $brandId,
                'price' => $price,
                'original_price' => $originalPrice,
                'stock' => $stock,
                'featured' => $featured,
                'status' => $status,
                'thumbnail' => $thumbnail,
                'short_description' => $shortDesc,
                'description' => $description,
                'specs' => $specs
            ]);

            $_SESSION['flash_success'] = 'Đã cập nhật thông tin sản phẩm!';
            header('Location: /admin/products');
            exit;
        }

        $categories = Category::all();
        $brands = Brand::all();
        require __DIR__ . '/../views/admin/product_form.php';
    }

    public function deleteProduct(int $id = 0): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/products');
            exit;
        }
        Csrf::check();

        if ($id <= 0) {
            $id = (int)($_POST['id'] ?? 0);
        }

        if ($id > 0) {
            Product::delete($id);
            $_SESSION['flash_success'] = 'Đã chuyển trạng thái sản phẩm sang Ngừng kinh doanh (Soft Delete an toàn).';
        }
        header('Location: /admin/products');
        exit;
    }

    public function orders(): void {
        $status = $_GET['status'] ?? '';
        $orders = Order::all(100, $status);
        require __DIR__ . '/../views/admin/orders.php';
    }

    public function updateOrderStatus(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Csrf::check();
            $orderId = (int)($_POST['order_id'] ?? 0);
            $status = $_POST['status'] ?? 'pending';
            $paymentStatus = $_POST['payment_status'] ?? null;

            $allowedStatuses = ['pending', 'processing', 'shipping', 'completed', 'cancelled'];
            $allowedPaymentStatuses = ['pending', 'paid', 'failed'];

            if (!in_array($status, $allowedStatuses, true)) {
                $_SESSION['flash_error'] = 'Trạng thái đơn hàng không hợp lệ.';
                header('Location: /admin/orders');
                exit;
            }

            if ($paymentStatus !== null && $paymentStatus !== '' && !in_array($paymentStatus, $allowedPaymentStatuses, true)) {
                $_SESSION['flash_error'] = 'Trạng thái thanh toán không hợp lệ.';
                header('Location: /admin/orders');
                exit;
            }
            if ($paymentStatus === '') {
                $paymentStatus = null;
            }

            if ($orderId > 0) {
                Order::updateStatus($orderId, $status, $paymentStatus);
                $_SESSION['flash_success'] = 'Cập nhật trạng thái đơn hàng thành công!';
            }
        }

        header('Location: /admin/orders');
        exit;
    }

    public function users(): void {
        $users = User::all(100);
        require __DIR__ . '/../views/admin/users.php';
    }
}
