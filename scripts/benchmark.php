<?php
/**
 * ElectroStore - Algorithmic Performance Benchmark Suite
 * Evaluates execution latency and throughput for Fuzzy Search, Cosine Similarity, and Analytics.
 * Usage: php scripts/benchmark.php
 */

echo "=================================================================\n";
echo "  ElectroStore Algorithmic Benchmark Suite (PHP Fallback & Rust)\n";
echo "=================================================================\n\n";

// Autoload core application classes
spl_autoload_register(function ($class) {
    if (str_starts_with($class, 'App\\')) {
        $baseDir = __DIR__ . '/../app/';
        $rel = substr($class, 4);
        $path = str_replace('\\', '/', $rel) . '.php';
        if (file_exists($baseDir . $path)) {
            require_once $baseDir . $path;
            return;
        }
        $parts = explode('/', $path);
        if (count($parts) > 1) {
            $parts[0] = strtolower($parts[0]);
            $fallback = $baseDir . implode('/', $parts);
            if (file_exists($fallback)) {
                require_once $fallback;
                return;
            }
        }
    }
});

use App\Models\Product;
use App\Models\Order;
use App\Services\SearchService;
use App\Services\RecommendationService;
use App\Services\AnalyticsService;
use App\Services\RustEngineService;

$products = Product::all(100, 0);
if (empty($products)) {
    echo "[WARN] No products found in database. Initializing in-memory fallback set...\n";
    $products = [];
    for ($i = 1; $i <= 50; $i++) {
        $products[] = [
            'id' => $i,
            'name' => "Thiết bị điện tử cao cấp Model {$i} Pro Max",
            'slug' => "thiet-bi-model-{$i}",
            'price' => 15000000.0 + ($i * 500000),
            'category_id' => ($i % 5) + 1,
            'brand_id' => ($i % 4) + 1,
            'specs_array' => ['cpu' => 'M3 Pro', 'ram' => '16GB', 'gpu' => 'RTX 4070']
        ];
    }
}

$rustService = new RustEngineService();
$rustOnline = $rustService->isAvailable();

echo "System Status:\n";
echo "  - Sample products count: " . count($products) . "\n";
echo "  - Rust Engine (127.0.0.1:5000): " . ($rustOnline ? "ONLINE" : "OFFLINE (Benchmarking PHP Fallback engine)") . "\n\n";

// 1. Benchmark: Fuzzy Search (Levenshtein & Token Matching)
echo "--- 1. Benchmarking Fuzzy Search (Levenshtein + Token Matching) ---\n";
$iterations = 300;
$query = "macbook pro m3";

$startMem = memory_get_usage();
$startTime = microtime(true);
for ($i = 0; $i < $iterations; $i++) {
    SearchService::fallbackSearch($products, $query);
}
$endTime = microtime(true);
$phpFuzzyDuration = ($endTime - $startTime) * 1000;
$phpFuzzyAvg = $phpFuzzyDuration / $iterations;
$phpFuzzyOps = round($iterations / ($endTime - $startTime));
$phpFuzzyMem = (memory_get_usage() - $startMem) / 1024;

echo "  [A] PHP Fallback Search (Pure CPU Algorithm In-Memory):\n";
echo "    Total time ({$iterations} runs): " . round($phpFuzzyDuration, 2) . " ms\n";
echo "    Average algorithm latency: " . round($phpFuzzyAvg, 3) . " ms\n";
echo "    Throughput: {$phpFuzzyOps} ops/sec\n";
echo "    Memory delta: " . round($phpFuzzyMem, 2) . " KB\n";

if ($rustOnline) {
    $rustSearchRuns = 50;
    $rustStart = microtime(true);
    for ($i = 0; $i < $rustSearchRuns; $i++) {
        $rustService->searchProducts($query, $products);
    }
    $rustSearchDuration = (microtime(true) - $rustStart) * 1000;
    $rustSearchAvg = $rustSearchDuration / $rustSearchRuns;
    echo "  [B] Rust Microservice (End-to-End via HTTP loopback):\n";
    echo "    Average round-trip latency: " . round($rustSearchAvg, 3) . " ms (gồm JSON serialize + HTTP loopback + Rust compute)\n";
}
echo "\n";

// 2. Benchmark: Recommendation Engine (Cosine Similarity on Feature Vectors)
echo "--- 2. Benchmarking Recommendation Engine (Cosine Similarity) ---\n";
$recIterations = 200;
$targetId = $products[0]['id'] ?? 1;

$startTime = microtime(true);
for ($i = 0; $i < $recIterations; $i++) {
    RecommendationService::fallbackRecommendations($products, $targetId, 4);
}
$endTime = microtime(true);
$phpRecDuration = ($endTime - $startTime) * 1000;
$phpRecAvg = $phpRecDuration / $recIterations;
$phpRecOps = round($recIterations / ($endTime - $startTime));

echo "  [A] PHP Fallback Cosine Recommendation (Pure CPU Algorithm):\n";
echo "    Total time ({$recIterations} runs): " . round($phpRecDuration, 2) . " ms\n";
echo "    Average algorithm latency: " . round($phpRecAvg, 3) . " ms\n";
echo "    Throughput: {$phpRecOps} ops/sec\n";

if ($rustOnline) {
    $rustRecRuns = 50;
    $rustStart = microtime(true);
    for ($i = 0; $i < $rustRecRuns; $i++) {
        $rustService->getRecommendations($targetId, $products, 4);
    }
    $rustRecDuration = (microtime(true) - $rustStart) * 1000;
    $rustRecAvg = $rustRecDuration / $rustRecRuns;
    echo "  [B] Rust Microservice (End-to-End via HTTP loopback):\n";
    echo "    Average round-trip latency: " . round($rustRecAvg, 3) . " ms\n";
}
echo "\n";

// 3. Benchmark: Analytics (Linear Regression & Pareto ABC Analysis)
echo "--- 3. Benchmarking Business Analytics (Linear Regression & ABC) ---\n";
$orders = Order::all(50);
$analyticsIterations = 200;

$startTime = microtime(true);
for ($i = 0; $i < $analyticsIterations; $i++) {
    AnalyticsService::fallbackAnalytics($orders, $products);
}
$endTime = microtime(true);
$phpAnalyticsDuration = ($endTime - $startTime) * 1000;
$phpAnalyticsAvg = $phpAnalyticsDuration / $analyticsIterations;
$phpAnalyticsOps = round($analyticsIterations / ($endTime - $startTime));

echo "  [A] PHP Fallback Analytics (Pure CPU Algorithm):\n";
echo "    Total time ({$analyticsIterations} runs): " . round($phpAnalyticsDuration, 2) . " ms\n";
echo "    Average algorithm latency: " . round($phpAnalyticsAvg, 3) . " ms\n";
echo "    Throughput: {$phpAnalyticsOps} ops/sec\n";

if ($rustOnline) {
    $rustAnaRuns = 50;
    $rustStart = microtime(true);
    for ($i = 0; $i < $rustAnaRuns; $i++) {
        $rustService->getAnalytics($orders, $products);
    }
    $rustAnaDuration = (microtime(true) - $rustStart) * 1000;
    $rustAnaAvg = $rustAnaDuration / $rustAnaRuns;
    echo "  [B] Rust Microservice (End-to-End via HTTP loopback):\n";
    echo "    Average round-trip latency: " . round($rustAnaAvg, 3) . " ms\n";
}
echo "\n";

echo "=================================================================\n";
echo "  Benchmark Summary & Architectural Analysis:\n";
echo "  1. Algorithm Latency vs End-to-End Request Latency:\n";
echo "     - Algorithm latency: thời gian tính toán thuần CPU trong bộ nhớ.\n";
echo "       Thuật toán Rust biên dịch tối ưu (SIMD, zero-cost abstractions)\n";
echo "       rất mạnh ở bài toán tổ hợp, ma trận và tập dữ liệu lớn.\n";
echo "     - End-to-end latency: bao gồm đóng gói JSON từ PHP, gửi qua HTTP\n";
echo "       loopback 127.0.0.1, Rust parse struct, xử lý và trả về JSON.\n";
echo "  2. Thiết kế Hybrid Đồ án:\n";
echo "     - Rust Microservice: Tối ưu cho tác vụ CPU-bound nặng.\n";
echo "     - PHP Fallback: Đảm bảo khả năng chịu lỗi (fault-tolerance),\n";
echo "       hệ thống vẫn phục vụ người dùng 100% khi service Rust offline.\n";
echo "=================================================================\n";
