<?php
namespace App\Services;

class RustEngineService {
    private string $host;
    private int $port;
    private int $timeoutMs;
    private bool $enabled;

    public function __construct() {
        $config = require __DIR__ . '/../config/database.php';
        $cfg = $config['rust_engine'] ?? [];
        $this->enabled = $cfg['enabled'] ?? true;
        $this->host = $cfg['host'] ?? '127.0.0.1';
        $this->port = (int)($cfg['port'] ?? 5000);
        $this->timeoutMs = (int)($cfg['timeout_ms'] ?? 1500);
    }

    public function isAvailable(): bool {
        if (!$this->enabled) return false;
        $res = $this->callApi('GET', '/api/health', null, 500);
        return !empty($res['success']) && ($res['data']['status'] ?? '') === 'ok';
    }

    public function search(array $products, string $query, array $filters = []): array {
        $startTime = microtime(true);

        if ($this->enabled) {
            $payload = [
                'query' => $query,
                'min_price' => $filters['min_price'] ?? null,
                'max_price' => $filters['max_price'] ?? null,
                'category_id' => $filters['category_id'] ?? null,
                'brand_id' => $filters['brand_id'] ?? null,
                'products' => array_map(function($p) {
                    return [
                        'id' => (int)$p['id'],
                        'name' => $p['name'],
                        'slug' => $p['slug'],
                        'price' => (float)$p['price'],
                        'category_name' => $p['category_name'] ?? '',
                        'brand_name' => $p['brand_name'] ?? '',
                        'short_description' => $p['short_description'] ?? '',
                        'specs' => empty($p['specs_array']) ? (object)[] : $p['specs_array']
                    ];
                }, $products)
            ];

            $apiRes = $this->callApi('POST', '/api/search', $payload);
            if (!empty($apiRes['success']) && isset($apiRes['data']['results'])) {
                $duration = round((microtime(true) - $startTime) * 1000, 2);
                
                // Enrich Rust scored results with full product view fields
                $productsById = [];
                foreach ($products as $p) {
                    $productsById[$p['id']] = $p;
                }

                $enriched = [];
                foreach ($apiRes['data']['results'] as $scored) {
                    $pid = $scored['id'];
                    if (isset($productsById[$pid])) {
                        $p = $productsById[$pid];
                        $p['match_score'] = $scored['match_score'] ?? 1.0;
                        $enriched[] = $p;
                    } else {
                        $enriched[] = $scored;
                    }
                }

                return [
                    'engine' => 'rust',
                    'latency_ms' => $duration,
                    'count' => count($enriched),
                    'results' => $enriched
                ];
            }
        }

        // Fallback: Pure PHP Fuzzy & Token Search
        $results = $this->fallbackPhpSearch($products, $query, $filters);
        $duration = round((microtime(true) - $startTime) * 1000, 2);
        return [
            'engine' => 'php_fallback',
            'latency_ms' => $duration,
            'count' => count($results),
            'results' => $results
        ];
    }

    public function getRecommendations(array $allProducts, int $targetProductId, int $limit = 4): array {
        $startTime = microtime(true);

        if ($this->enabled) {
            $payload = [
                'target_id' => $targetProductId,
                'limit' => $limit,
                'products' => array_map(function($p) {
                    return [
                        'id' => (int)$p['id'],
                        'name' => $p['name'],
                        'category_id' => (int)$p['category_id'],
                        'brand_id' => (int)$p['brand_id'],
                        'price' => (float)$p['price'],
                        'rating' => (float)($p['rating'] ?? 5.0),
                        'specs' => empty($p['specs_array']) ? (object)[] : $p['specs_array']
                    ];
                }, $allProducts)
            ];

            $apiRes = $this->callApi('POST', '/api/recommendations', $payload);
            if (!empty($apiRes['success']) && isset($apiRes['data']['recommendations'])) {
                $duration = round((microtime(true) - $startTime) * 1000, 2);
                
                $productsById = [];
                foreach ($allProducts as $p) {
                    $productsById[$p['id']] = $p;
                }

                $enrichedRecs = [];
                foreach ($apiRes['data']['recommendations'] as $rec) {
                    $pid = $rec['product_id'];
                    $rec['product'] = $productsById[$pid] ?? ($rec['product'] ?? []);
                    $enrichedRecs[] = $rec;
                }

                return [
                    'engine' => 'rust',
                    'latency_ms' => $duration,
                    'recommendations' => $enrichedRecs
                ];
            }
        }

        // Fallback: Pure PHP Cosine Similarity on Electronics Feature Vectors
        $results = $this->fallbackPhpRecommendations($allProducts, $targetProductId, $limit);
        $duration = round((microtime(true) - $startTime) * 1000, 2);
        return [
            'engine' => 'php_fallback',
            'latency_ms' => $duration,
            'recommendations' => $results
        ];
    }

    public function calculateAnalytics(array $orders, array $products): array {
        $startTime = microtime(true);

        if ($this->enabled) {
            $payload = [
                'orders' => array_map(function($o) {
                    return [
                        'id' => (int)$o['id'],
                        'final_amount' => (float)$o['final_amount'],
                        'order_status' => $o['order_status'],
                        'created_at' => $o['created_at']
                    ];
                }, $orders),
                'products' => array_map(function($p) {
                    return [
                        'id' => (int)$p['id'],
                        'name' => $p['name'],
                        'price' => (float)$p['price'],
                        'stock' => (int)$p['stock'],
                        'sales_count' => (int)($p['sales_count'] ?? 0)
                    ];
                }, $products)
            ];

            $apiRes = $this->callApi('POST', '/api/analytics', $payload);
            if (!empty($apiRes['success']) && isset($apiRes['data'])) {
                $duration = round((microtime(true) - $startTime) * 1000, 2);
                $data = $apiRes['data'];
                $data['engine'] = 'rust';
                $data['latency_ms'] = $duration;
                return $data;
            }
        }

        // Fallback: Pure PHP Analytics & Linear Regression
        $data = $this->fallbackPhpAnalytics($orders, $products);
        $duration = round((microtime(true) - $startTime) * 1000, 2);
        $data['engine'] = 'php_fallback';
        $data['latency_ms'] = $duration;
        return $data;
    }

    private function callApi(string $method, string $path, ?array $payload = null, ?int $timeoutOverride = null): array {
        $url = "http://{$this->host}:{$this->port}{$path}";
        $timeoutSeconds = ($timeoutOverride ?? $this->timeoutMs) / 1000.0;

        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, (int)($timeoutSeconds * 1000));
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 400);

            if ($method === 'POST') {
                curl_setopt($ch, CURLOPT_POST, true);
                $json = json_encode($payload ?: []);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($json)
                ]);
            }

            $response = @curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $err = curl_error($ch);
            curl_close($ch);

            if ($response !== false && $httpCode >= 200 && $httpCode < 300) {
                $decoded = json_decode($response, true);
                if (is_array($decoded)) {
                    return ['success' => true, 'data' => $decoded];
                }
            }
        } else {
            // Fallback to stream context
            $options = [
                'http' => [
                    'method' => $method,
                    'timeout' => $timeoutSeconds,
                    'ignore_errors' => true
                ]
            ];
            if ($method === 'POST') {
                $json = json_encode($payload ?: []);
                $options['http']['header'] = "Content-Type: application/json\r\nContent-Length: " . strlen($json);
                $options['http']['content'] = $json;
            }
            $context = stream_context_create($options);
            $response = @file_get_contents($url, false, $context);
            if ($response !== false) {
                $decoded = json_decode($response, true);
                if (is_array($decoded)) {
                    return ['success' => true, 'data' => $decoded];
                }
            }
        }

        return ['success' => false, 'error' => 'Rust Engine unreachable'];
    }

    /**
     * Fallback PHP Search Algorithm (Levenshtein + Token Overlap)
     */
    public function fallbackPhpSearch(array $products, string $query, array $filters = []): array {
        $q = mb_strtolower(trim($query), 'UTF-8');
        $queryTokens = array_filter(explode(' ', $q));
        $scored = [];

        foreach ($products as $p) {
            // Apply price filters
            if (!empty($filters['min_price']) && (float)$p['price'] < (float)$filters['min_price']) continue;
            if (!empty($filters['max_price']) && (float)$p['price'] > (float)$filters['max_price']) continue;
            if (!empty($filters['category_id']) && (int)$p['category_id'] !== (int)$filters['category_id']) continue;
            if (!empty($filters['brand_id']) && (int)$p['brand_id'] !== (int)$filters['brand_id']) continue;

            if (empty($queryTokens)) {
                $scored[] = ['product' => $p, 'score' => 1.0];
                continue;
            }

            $searchableText = mb_strtolower(
                $p['name'] . ' ' .
                ($p['brand_name'] ?? '') . ' ' .
                ($p['category_name'] ?? '') . ' ' .
                ($p['short_description'] ?? '') . ' ' .
                json_encode($p['specs_array'] ?? [], JSON_UNESCAPED_UNICODE),
                'UTF-8'
            );

            $score = 0.0;
            // Exact substring check
            if (strpos($searchableText, $q) !== false) {
                $score += 10.0;
            }

            // Token matching
            foreach ($queryTokens as $tok) {
                if (strpos($searchableText, $tok) !== false) {
                    $score += 3.0;
                }
            }

            if ($score > 0.0) {
                $scored[] = ['product' => $p, 'score' => $score];
            }
        }

        usort($scored, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        return array_map(function($item) {
            $prod = $item['product'];
            $prod['match_score'] = round($item['score'], 2);
            return $prod;
        }, $scored);
    }

    /**
     * Fallback PHP Cosine Similarity Recommendation Algorithm
     */
    public function fallbackPhpRecommendations(array $products, int $targetId, int $limit = 4): array {
        $target = null;
        foreach ($products as $p) {
            if ((int)$p['id'] === $targetId) {
                $target = $p;
                break;
            }
        }
        if (!$target) return [];

        $targetVector = $this->buildFeatureVector($target);
        $recommendations = [];

        foreach ($products as $p) {
            if ((int)$p['id'] === $targetId) continue;
            $vec = $this->buildFeatureVector($p);
            $sim = $this->cosineSimilarity($targetVector, $vec);
            if ($sim > 0.1) {
                $recommendations[] = [
                    'product_id' => (int)$p['id'],
                    'similarity' => round($sim, 4),
                    'product' => $p
                ];
            }
        }

        usort($recommendations, function($a, $b) {
            return $b['similarity'] <=> $a['similarity'];
        });

        return array_slice($recommendations, 0, $limit);
    }

    private function buildFeatureVector(array $product): array {
        $vector = [];
        // Feature 1: Category ID one-hot
        $vector['cat_' . ($product['category_id'] ?? 0)] = 2.5;
        // Feature 2: Brand ID one-hot
        $vector['brand_' . ($product['brand_id'] ?? 0)] = 2.0;
        // Feature 3: Normalized price range
        $price = (float)$product['price'];
        $vector['price_tier'] = min(5.0, max(1.0, log10(max(1000.0, $price)) / 1.5));
        
        // Feature 4: Specs tokens
        $specs = $product['specs_array'] ?? [];
        foreach ($specs as $key => $val) {
            if (is_string($val)) {
                $words = explode(' ', strtolower($val));
                foreach ($words as $w) {
                    if (strlen($w) >= 3) {
                        $vector['spec_' . $w] = 1.0;
                    }
                }
            }
        }
        return $vector;
    }

    private function cosineSimilarity(array $vecA, array $vecB): float {
        $dotProduct = 0.0;
        $normA = 0.0;
        $normB = 0.0;

        foreach ($vecA as $k => $v) {
            $normA += $v * $v;
            if (isset($vecB[$k])) {
                $dotProduct += $v * $vecB[$k];
            }
        }
        foreach ($vecB as $v) {
            $normB += $v * $v;
        }

        if ($normA <= 0.0 || $normB <= 0.0) return 0.0;
        return $dotProduct / (sqrt($normA) * sqrt($normB));
    }

    /**
     * Fallback PHP Analytics Algorithm (Linear Regression & Pareto ABC Analysis)
     */
    public function fallbackPhpAnalytics(array $orders, array $products): array {
        $completedOrders = array_filter($orders, fn($o) => in_array($o['order_status'], ['completed', 'shipping', 'processing']));
        $totalRevenue = array_reduce($completedOrders, fn($sum, $o) => $sum + (float)$o['final_amount'], 0.0);
        $totalOrdersCount = count($orders);

        // Daily revenue aggregation
        $daily = [];
        foreach ($completedOrders as $o) {
            $day = substr($o['created_at'], 0, 10);
            $daily[$day] = ($daily[$day] ?? 0.0) + (float)$o['final_amount'];
        }
        ksort($daily);

        // Linear regression for revenue trend: y = m*x + b
        $x = [];
        $y = [];
        $i = 1;
        foreach ($daily as $amount) {
            $x[] = $i++;
            $y[] = $amount;
        }
        $n = count($x);
        $slope = 0.0;
        $intercept = 0.0;
        $forecastNextDay = 0.0;

        if ($n >= 2) {
            $meanX = array_sum($x) / $n;
            $meanY = array_sum($y) / $n;
            $num = 0.0;
            $den = 0.0;
            for ($k = 0; $k < $n; $k++) {
                $num += ($x[$k] - $meanX) * ($y[$k] - $meanY);
                $den += ($x[$k] - $meanX) ** 2;
            }
            $slope = $den > 0 ? $num / $den : 0;
            $intercept = $meanY - ($slope * $meanX);
            $forecastNextDay = max(0.0, ($slope * ($n + 1)) + $intercept);
        } else {
            $forecastNextDay = $totalRevenue / max(1, $n);
        }

        // ABC Inventory Analysis (Pareto 80/20)
        // Value = Price * Sales Count
        $inventoryValues = [];
        $totalInventorySalesValue = 0.0;
        foreach ($products as $p) {
            $salesVal = (float)$p['price'] * (int)($p['sales_count'] ?? 0);
            $inventoryValues[] = [
                'id' => (int)$p['id'],
                'name' => $p['name'],
                'sales_value' => $salesVal,
                'stock' => (int)$p['stock']
            ];
            $totalInventorySalesValue += $salesVal;
        }

        usort($inventoryValues, fn($a, $b) => $b['sales_value'] <=> $a['sales_value']);
        $cumValue = 0.0;
        $classA = [];
        $classB = [];
        $classC = [];

        foreach ($inventoryValues as $item) {
            $cumValue += $item['sales_value'];
            $pct = $totalInventorySalesValue > 0 ? ($cumValue / $totalInventorySalesValue) * 100 : 0;
            if ($pct <= 70) {
                $item['category'] = 'A';
                $classA[] = $item;
            } elseif ($pct <= 90) {
                $item['category'] = 'B';
                $classB[] = $item;
            } else {
                $item['category'] = 'C';
                $classC[] = $item;
            }
        }

        return [
            'total_revenue' => $totalRevenue,
            'total_orders' => $totalOrdersCount,
            'completed_orders_count' => count($completedOrders),
            'forecast_next_day_revenue' => round($forecastNextDay, 2),
            'trend_slope' => round($slope, 2),
            'abc_analysis' => [
                'class_a_count' => count($classA),
                'class_b_count' => count($classB),
                'class_c_count' => count($classC),
                'top_revenue_items' => array_slice($classA, 0, 5)
            ]
        ];
    }
}
