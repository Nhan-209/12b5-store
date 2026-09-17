<?php
namespace App\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Services\RecommendationService;

class HomeController {
    public function index(): void {
        $categories = Category::all();
        $brands = Brand::all();
        $featuredProducts = Product::getFeatured(8);
        $latestProducts = Product::getLatest(8);

        // Rust-powered recommendations (e.g. for flagship item #1 - iPhone 16 Pro Max)
        $recService = new RecommendationService();
        $recData = $recService->getRecommendationsForProduct(1, 4);

        $recommendedProducts = [];
        if (!empty($recData['recommendations'])) {
            foreach ($recData['recommendations'] as $rec) {
                if (isset($rec['product'])) {
                    $recommendedProducts[] = $rec['product'];
                } elseif (isset($rec['product_id'])) {
                    $prod = Product::findById((int)$rec['product_id']);
                    if ($prod) $recommendedProducts[] = $prod;
                }
            }
        }

        $engineInfo = [
            'engine' => $recData['engine'] ?? 'php_fallback',
            'latency_ms' => $recData['latency_ms'] ?? 1.2
        ];

        require __DIR__ . '/../views/home/index.php';
    }
}
