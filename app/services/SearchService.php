<?php
namespace App\Services;

use App\Models\Product;

class SearchService {
    private RustEngineService $rustEngine;

    public function __construct() {
        $this->rustEngine = new RustEngineService();
    }

    public function executeSearch(string $query, array $filters = []): array {
        $allProducts = Product::all(100, 0);
        return $this->rustEngine->search($allProducts, $query, $filters);
    }

    public static function fallbackSearch(array $products, string $query, array $filters = []): array {
        $engine = new RustEngineService();
        return $engine->fallbackPhpSearch($products, $query, $filters);
    }
}
