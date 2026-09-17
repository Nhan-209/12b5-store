<?php
namespace Tests;

use App\Models\Product;
use App\Models\Order;
use App\Services\RustEngineService;

class RustEngineClientTest {
    public static function run(): array {
        $results = [];
        $service = new RustEngineService();

        $allProducts = Product::all(50, 0);

        // TC 1: Search engine execution (handles either Rust or PHP fallback)
        $searchRes = $service->search($allProducts, 'iPhone');
        $results[] = [
            'name' => 'RustEngineClientTest: Search query execution returns scored items',
            'passed' => !empty($searchRes['results']) && $searchRes['count'] > 0
        ];

        // TC 2: Recommendation engine execution
        $recRes = $service->getRecommendations($allProducts, 1, 4);
        $results[] = [
            'name' => 'RustEngineClientTest: Recommendations engine returns top similarity items',
            'passed' => !empty($recRes['recommendations']) && count($recRes['recommendations']) <= 4
        ];

        // TC 3: Analytics engine execution
        $orders = Order::all(50);
        $analyticsRes = $service->calculateAnalytics($orders, $allProducts);
        $results[] = [
            'name' => 'RustEngineClientTest: Analytics computes revenue forecast & ABC classification',
            'passed' => isset($analyticsRes['forecast_next_day_revenue']) && isset($analyticsRes['abc_analysis']['class_a_count'])
        ];

        return $results;
    }
}
