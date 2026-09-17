<?php
namespace App\Services;

use App\Models\Product;

class RecommendationService {
    private RustEngineService $rustEngine;

    public function __construct() {
        $this->rustEngine = new RustEngineService();
    }

    public function getRecommendationsForProduct(int $productId, int $limit = 4): array {
        $allProducts = Product::all(100, 0);
        return $this->rustEngine->getRecommendations($allProducts, $productId, $limit);
    }
}
