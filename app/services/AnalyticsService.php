<?php
namespace App\Services;

use App\Models\Order;
use App\Models\Product;

class AnalyticsService {
    private RustEngineService $rustEngine;

    public function __construct() {
        $this->rustEngine = new RustEngineService();
    }

    public function getDashboardMetrics(): array {
        $orders = Order::all(100);
        $products = Product::all(100, 0);
        return $this->rustEngine->calculateAnalytics($orders, $products);
    }

    public static function fallbackAnalytics(array $orders, array $products): array {
        $engine = new RustEngineService();
        return $engine->fallbackPhpAnalytics($orders, $products);
    }
}
