<?php
namespace App\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Services\SearchService;
use App\Services\RecommendationService;
use App\Core\Csrf;

class ProductController {
    public function index(): void {
        $categories = Category::all();
        $brands = Brand::all();

        $searchQuery = trim($_GET['q'] ?? '');
        $categorySlug = trim($_GET['category'] ?? '');
        $brandSlug = trim($_GET['brand'] ?? '');
        $minPrice = isset($_GET['min_price']) && $_GET['min_price'] !== '' ? (float)$_GET['min_price'] : null;
        $maxPrice = isset($_GET['max_price']) && $_GET['max_price'] !== '' ? (float)$_GET['max_price'] : null;
        $sort = $_GET['sort'] ?? 'newest';

        $selectedCategory = $categorySlug ? Category::findBySlug($categorySlug) : null;
        $selectedBrand = $brandSlug ? Brand::findBySlug($brandSlug) : null;

        $engineInfo = null;

        if (!empty($searchQuery)) {
            // Powered by Rust Search Engine
            $searchService = new SearchService();
            $searchRes = $searchService->executeSearch($searchQuery, [
                'min_price' => $minPrice,
                'max_price' => $maxPrice,
                'category_id' => $selectedCategory['id'] ?? null,
                'brand_id' => $selectedBrand['id'] ?? null
            ]);
            $products = $searchRes['results'];
            $engineInfo = [
                'engine' => $searchRes['engine'],
                'latency_ms' => $searchRes['latency_ms'],
                'count' => $searchRes['count']
            ];
        } else {
            $filters = [
                'category_id' => $selectedCategory['id'] ?? null,
                'brand_id' => $selectedBrand['id'] ?? null,
                'min_price' => $minPrice,
                'max_price' => $maxPrice,
                'sort' => $sort
            ];
            $products = Product::filter($filters);
        }

        require __DIR__ . '/../views/products/index.php';
    }

    public function detail(string $slug): void {
        $product = Product::findBySlug($slug);
        if (!$product) {
            http_response_code(404);
            require __DIR__ . '/../views/errors/404.php';
            return;
        }

        $reviews = Product::getReviews($product['id']);

        // Recommendations using Rust Engine Cosine Similarity
        $recService = new RecommendationService();
        $recData = $recService->getRecommendationsForProduct((int)$product['id'], 4);

        $relatedProducts = [];
        if (!empty($recData['recommendations'])) {
            foreach ($recData['recommendations'] as $rec) {
                if (isset($rec['product'])) {
                    $relatedProducts[] = $rec['product'];
                } elseif (isset($rec['product_id'])) {
                    $p = Product::findById((int)$rec['product_id']);
                    if ($p) $relatedProducts[] = $p;
                }
            }
        }

        $engineInfo = [
            'engine' => $recData['engine'] ?? 'php_fallback',
            'latency_ms' => $recData['latency_ms'] ?? 0.8
        ];

        require __DIR__ . '/../views/products/detail.php';
    }

    public function addReview(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/');
            exit;
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        $product = Product::findById($productId);
        if (!$product) {
            header('Location: ' . BASE_URL . '/');
            exit;
        }

        if (!Csrf::validate()) {
            $_SESSION['flash_error'] = 'Mã bảo mật CSRF không hợp lệ hoặc phiên đã hết hạn. Vui lòng thử lại.';
            header('Location: ' . BASE_URL . '/product/' . $product['slug'] . '#reviews');
            exit;
        }

        if (empty($_SESSION['user']['id'])) {
            $_SESSION['flash_error'] = 'Quý khách vui lòng đăng nhập tài khoản đã mua hàng để gửi đánh giá.';
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $userId = (int)$_SESSION['user']['id'];

        // Strict verification: user must have bought this product in a completed order
        if (!Product::hasPurchased($userId, $productId)) {
            $_SESSION['flash_error'] = 'Chỉ những khách hàng đã mua và nhận hàng thành công đối với sản phẩm này mới có thể viết đánh giá.';
            header('Location: ' . BASE_URL . '/product/' . $product['slug'] . '#reviews');
            exit;
        }

        $rating = max(1, min(5, (int)($_POST['rating'] ?? 5)));
        $name = trim($_POST['user_name'] ?? '');
        $comment = trim($_POST['comment'] ?? '');

        if (empty($name) && isset($_SESSION['user']['name'])) {
            $name = $_SESSION['user']['name'];
        }
        if (empty($name)) {
            $name = 'Khách hàng';
        }

        if (!empty($comment)) {
            Product::addReview($productId, $userId, $name, $rating, $comment);
            $_SESSION['flash_success'] = 'Cảm ơn quý khách đã gửi nhận xét đánh giá sản phẩm!';
        }

        header('Location: /product/' . $product['slug'] . '#reviews');
        exit;
    }
}
