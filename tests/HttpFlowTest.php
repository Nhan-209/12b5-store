<?php
namespace Tests;

use App\Models\Database;
use App\Models\Product;
use App\Models\Order;
use App\Core\Csrf;

/**
 * Programmatic HTTP / Front-Controller Verification Suite
 * Verifies Dual-Environment Routing, Asset Resolution, Cart Flows, Auth, and Checkout
 */
class HttpFlowTest {

    public static function run(): array {
        $results = [];

        // Pre-generate a known valid CSRF token for test requests
        $csrfToken = bin2hex(random_bytes(32));

        // -------------------------------------------------------------
        // Group A: Dual-Environment URL Routing & Asset Resolution (R1)
        // -------------------------------------------------------------

        // TC 1: Standalone mode renders root page with status 200 and relative asset paths (/css/..., /js/...)
        try {
            $res = self::simulateRequest([
                'uri' => '/',
                'script_name' => '/index.php'
            ]);
            $hasCss = str_contains($res['body'], '<link rel="stylesheet" href="/css/style.css">');
            $hasJs = str_contains($res['body'], '<script src="/js/app.js"></script>');
            $noSubfolder = !str_contains($res['body'], '/12b5-store/public/css/style.css');
            $noBackslash = !str_contains($res['body'], '/\/css') && !str_contains($res['body'], '//css');

            $results[] = [
                'name' => 'HttpFlowTest: Standalone mode renders root page with status 200 and relative asset paths (/css/..., /js/...)',
                'passed' => ($res['status'] === 200 && $hasCss && $hasJs && $noSubfolder && $noBackslash),
                'error' => ($res['status'] !== 200 ? "Status was {$res['status']}" : (!$hasCss ? "Missing CSS" : (!$hasJs ? "Missing JS" : (!$noSubfolder ? "Found subfolder prefix" : "Backslash glitch"))))
            ];
        } catch (\Throwable $e) {
            $results[] = [
                'name' => 'HttpFlowTest: Standalone mode renders root page with status 200 and relative asset paths (/css/..., /js/...)',
                'passed' => false,
                'error' => $e->getMessage()
            ];
        }

        // TC 2: Standalone mode product catalog renders with status 200 and clean asset paths
        try {
            $res = self::simulateRequest([
                'uri' => '/products',
                'script_name' => '/index.php'
            ]);
            $hasCss = str_contains($res['body'], '<link rel="stylesheet" href="/css/style.css">');
            $noSubfolder = !str_contains($res['body'], '/12b5-store/public/css/style.css');
            $hasTitle = str_contains($res['body'], 'Sản Phẩm') || str_contains($res['body'], 'san-pham');

            $results[] = [
                'name' => 'HttpFlowTest: Standalone mode product catalog renders with status 200 and clean asset paths',
                'passed' => ($res['status'] === 200 && $hasCss && $noSubfolder && $hasTitle),
                'error' => "Status: {$res['status']}"
            ];
        } catch (\Throwable $e) {
            $results[] = [
                'name' => 'HttpFlowTest: Standalone mode product catalog renders with status 200 and clean asset paths',
                'passed' => false,
                'error' => $e->getMessage()
            ];
        }

        // TC 3: Standalone mode product detail renders with status 200 and correct specs
        try {
            $res = self::simulateRequest([
                'uri' => '/product/iphone-16-pro-max-256gb',
                'script_name' => '/index.php'
            ]);
            $hasProduct = str_contains($res['body'], 'iPhone 16 Pro Max');
            $noSubfolder = !str_contains($res['body'], '/12b5-store/public/');

            $results[] = [
                'name' => 'HttpFlowTest: Standalone mode product detail renders with status 200 and correct specs',
                'passed' => ($res['status'] === 200 && $hasProduct && $noSubfolder),
                'error' => "Status: {$res['status']}"
            ];
        } catch (\Throwable $e) {
            $results[] = [
                'name' => 'HttpFlowTest: Standalone mode product detail renders with status 200 and correct specs',
                'passed' => false,
                'error' => $e->getMessage()
            ];
        }

        // TC 4: Standalone mode cart page renders with status 200
        try {
            $res = self::simulateRequest([
                'uri' => '/cart',
                'script_name' => '/index.php'
            ]);
            $hasCart = str_contains($res['body'], 'Giỏ hàng');
            $noSubfolder = !str_contains($res['body'], '/12b5-store/public/');

            $results[] = [
                'name' => 'HttpFlowTest: Standalone mode cart page renders with status 200',
                'passed' => ($res['status'] === 200 && $hasCart && $noSubfolder),
                'error' => "Status: {$res['status']}"
            ];
        } catch (\Throwable $e) {
            $results[] = [
                'name' => 'HttpFlowTest: Standalone mode cart page renders with status 200',
                'passed' => false,
                'error' => $e->getMessage()
            ];
        }

        // TC 5: Apache subfolder mode renders root page with status 200 and prefixed assets (/12b5-store/public/...)
        try {
            $res = self::simulateRequest([
                'uri' => '/12b5-store/public/',
                'script_name' => '/12b5-store/public/index.php'
            ]);
            $hasCss = str_contains($res['body'], '<link rel="stylesheet" href="/12b5-store/public/css/style.css">');
            $hasJs = str_contains($res['body'], '<script src="/12b5-store/public/js/app.js"></script>');

            $results[] = [
                'name' => 'HttpFlowTest: Apache subfolder mode renders root page with status 200 and prefixed assets (/12b5-store/public/...)',
                'passed' => ($res['status'] === 200 && $hasCss && $hasJs),
                'error' => ($res['status'] !== 200 ? "Status {$res['status']}" : (!$hasCss ? "Missing prefixed CSS" : "Missing prefixed JS"))
            ];
        } catch (\Throwable $e) {
            $results[] = [
                'name' => 'HttpFlowTest: Apache subfolder mode renders root page with status 200 and prefixed assets (/12b5-store/public/...)',
                'passed' => false,
                'error' => $e->getMessage()
            ];
        }

        // TC 6: Apache subfolder mode product catalog renders with status 200 and prefixed assets
        try {
            $res = self::simulateRequest([
                'uri' => '/12b5-store/public/products',
                'script_name' => '/12b5-store/public/index.php'
            ]);
            $hasCss = str_contains($res['body'], '/12b5-store/public/css/style.css');

            $results[] = [
                'name' => 'HttpFlowTest: Apache subfolder mode product catalog renders with status 200 and prefixed assets',
                'passed' => ($res['status'] === 200 && $hasCss),
                'error' => "Status {$res['status']}"
            ];
        } catch (\Throwable $e) {
            $results[] = [
                'name' => 'HttpFlowTest: Apache subfolder mode product catalog renders with status 200 and prefixed assets',
                'passed' => false,
                'error' => $e->getMessage()
            ];
        }

        // TC 7: Apache subfolder mode unauthenticated redirect dynamically prepends /12b5-store/public
        try {
            $res = self::simulateRequest([
                'uri' => '/12b5-store/public/profile',
                'script_name' => '/12b5-store/public/index.php'
            ]);
            $passed = ($res['status'] === 302 && $res['location'] === '/12b5-store/public/login');

            $results[] = [
                'name' => 'HttpFlowTest: Apache subfolder mode unauthenticated redirect dynamically prepends /12b5-store/public',
                'passed' => $passed,
                'error' => "Status {$res['status']}, Location: " . ($res['location'] ?? 'none')
            ];
        } catch (\Throwable $e) {
            $results[] = [
                'name' => 'HttpFlowTest: Apache subfolder mode unauthenticated redirect dynamically prepends /12b5-store/public',
                'passed' => false,
                'error' => $e->getMessage()
            ];
        }

        // -------------------------------------------------------------
        // Group B: Shopping Cart & Session Logic (R3)
        // -------------------------------------------------------------

        // TC 8: AJAX Add to Cart with valid CSRF returns HTTP 200 JSON with updated cart count
        try {
            $res = self::simulateRequest([
                'method' => 'POST',
                'uri' => '/cart/add',
                'script_name' => '/index.php',
                'headers' => ['X-Requested-With' => 'XMLHttpRequest'],
                'post' => [
                    'product_id' => 1,
                    'quantity' => 2,
                    'csrf_token' => $csrfToken
                ],
                'session_data' => ['csrf_token' => $csrfToken]
            ]);
            $json = json_decode($res['body'], true);
            $passed = ($res['status'] === 200 && is_array($json) && !empty($json['success']) && isset($json['cart']['total_items']) && (int)$json['cart']['total_items'] === 2);

            $results[] = [
                'name' => 'HttpFlowTest: AJAX Add to Cart with valid CSRF returns HTTP 200 JSON with updated cart count',
                'passed' => $passed,
                'error' => "Status {$res['status']}, Body: " . substr($res['body'], 0, 200)
            ];
        } catch (\Throwable $e) {
            $results[] = [
                'name' => 'HttpFlowTest: AJAX Add to Cart with valid CSRF returns HTTP 200 JSON with updated cart count',
                'passed' => false,
                'error' => $e->getMessage()
            ];
        }

        // TC 9: AJAX Add to Cart with invalid CSRF returns HTTP 403 Forbidden
        try {
            $res = self::simulateRequest([
                'method' => 'POST',
                'uri' => '/cart/add',
                'script_name' => '/index.php',
                'headers' => ['X-Requested-With' => 'XMLHttpRequest'],
                'post' => [
                    'product_id' => 1,
                    'quantity' => 1,
                    'csrf_token' => 'invalid_csrf_token_tampered'
                ],
                'session_data' => ['csrf_token' => $csrfToken]
            ]);
            $json = json_decode($res['body'], true);
            $passed = ($res['status'] === 403 && is_array($json) && empty($json['success']));

            $results[] = [
                'name' => 'HttpFlowTest: AJAX Add to Cart with invalid CSRF returns HTTP 403 Forbidden',
                'passed' => $passed,
                'error' => "Status {$res['status']}, Body: " . substr($res['body'], 0, 200)
            ];
        } catch (\Throwable $e) {
            $results[] = [
                'name' => 'HttpFlowTest: AJAX Add to Cart with invalid CSRF returns HTTP 403 Forbidden',
                'passed' => false,
                'error' => $e->getMessage()
            ];
        }

        // TC 10: Standard form Add to Cart returns HTTP 302 with Location prepending BASE_URL
        try {
            $res = self::simulateRequest([
                'method' => 'POST',
                'uri' => '/12b5-store/public/cart/add',
                'script_name' => '/12b5-store/public/index.php',
                'post' => [
                    'product_id' => 2,
                    'quantity' => 1,
                    'csrf_token' => $csrfToken
                ],
                'session_data' => ['csrf_token' => $csrfToken]
            ]);
            $passed = ($res['status'] === 302 && $res['location'] === '/12b5-store/public/cart');

            $results[] = [
                'name' => 'HttpFlowTest: Standard form Add to Cart returns HTTP 302 with Location prepending BASE_URL',
                'passed' => $passed,
                'error' => "Status {$res['status']}, Location: " . ($res['location'] ?? 'none')
            ];
        } catch (\Throwable $e) {
            $results[] = [
                'name' => 'HttpFlowTest: Standard form Add to Cart returns HTTP 302 with Location prepending BASE_URL',
                'passed' => false,
                'error' => $e->getMessage()
            ];
        }

        // TC 11: Coupon apply (WELCOME2026) and removal (empty code) resets discount to 0
        try {
            // Step 1: Apply coupon WELCOME2026
            $resApply = self::simulateRequest([
                'method' => 'POST',
                'uri' => '/cart/coupon',
                'script_name' => '/index.php',
                'headers' => ['X-Requested-With' => 'XMLHttpRequest'],
                'post' => [
                    'coupon_code' => 'WELCOME2026',
                    'csrf_token' => $csrfToken
                ],
                'session_data' => [
                    'csrf_token' => $csrfToken,
                    'cart' => [1 => ['product_id' => 1, 'quantity' => 1]] // iPhone 16 Pro Max: 34.99M >= 10M min order value
                ]
            ]);
            $jsonApply = json_decode($resApply['body'], true);
            $applyPassed = ($resApply['status'] === 200 && is_array($jsonApply) && !empty($jsonApply['success']) && (float)($jsonApply['cart']['discount_amount'] ?? 0) > 0);

            // Step 2: Remove coupon by submitting empty code
            $resRemove = self::simulateRequest([
                'method' => 'POST',
                'uri' => '/cart/coupon',
                'script_name' => '/index.php',
                'headers' => ['X-Requested-With' => 'XMLHttpRequest'],
                'post' => [
                    'coupon_code' => '',
                    'csrf_token' => $csrfToken
                ],
                'session_data' => $resApply['session']
            ]);
            $jsonRemove = json_decode($resRemove['body'], true);
            $removePassed = ($resRemove['status'] === 200 && is_array($jsonRemove) && !empty($jsonRemove['success']) && (float)($jsonRemove['cart']['discount_amount'] ?? 0) === 0.0 && empty($jsonRemove['cart']['coupon']));

            $results[] = [
                'name' => 'HttpFlowTest: Coupon apply (WELCOME2026) and removal (empty code) resets discount to 0',
                'passed' => ($applyPassed && $removePassed),
                'error' => "Apply passed: " . ($applyPassed ? 'YES' : 'NO') . ", Remove passed: " . ($removePassed ? 'YES' : 'NO')
            ];
        } catch (\Throwable $e) {
            $results[] = [
                'name' => 'HttpFlowTest: Coupon apply (WELCOME2026) and removal (empty code) resets discount to 0',
                'passed' => false,
                'error' => $e->getMessage()
            ];
        }

        // TC 12: Cart summary page calculates subtotal, 30,000₫ shipping fee for < 5M, and total
        try {
            $res = self::simulateRequest([
                'uri' => '/cart',
                'script_name' => '/index.php',
                'session_data' => [
                    'cart' => [11 => ['product_id' => 11, 'quantity' => 1]] // Củ sạc nhanh Xiaomi 67W: 590,000₫ (< 5M)
                ]
            ]);
            $hasSubtotal = str_contains($res['body'], '590.000');
            $hasShipping = str_contains($res['body'], '30.000');
            $hasTotal = str_contains($res['body'], '620.000');

            $results[] = [
                'name' => 'HttpFlowTest: Cart summary page calculates subtotal, 30,000₫ shipping fee for < 5M, and total',
                'passed' => ($res['status'] === 200 && $hasSubtotal && $hasShipping && $hasTotal),
                'error' => "Status {$res['status']}, Subtotal: " . ($hasSubtotal ? 'YES' : 'NO') . ", Shipping: " . ($hasShipping ? 'YES' : 'NO') . ", Total: " . ($hasTotal ? 'YES' : 'NO')
            ];
        } catch (\Throwable $e) {
            $results[] = [
                'name' => 'HttpFlowTest: Cart summary page calculates subtotal, 30,000₫ shipping fee for < 5M, and total',
                'passed' => false,
                'error' => $e->getMessage()
            ];
        }

        // -------------------------------------------------------------
        // Group C: Authentication & Checkout (R2 & R3)
        // -------------------------------------------------------------

        // TC 13: User login with seeded credentials returns HTTP 302 and sets authenticated user in session
        try {
            $res = self::simulateRequest([
                'method' => 'POST',
                'uri' => '/login',
                'script_name' => '/index.php',
                'post' => [
                    'email' => 'customer@gmail.com',
                    'password' => 'user123',
                    'csrf_token' => $csrfToken
                ],
                'session_data' => ['csrf_token' => $csrfToken]
            ]);
            $isLoggedIn = !empty($res['session']['user']) && $res['session']['user']['email'] === 'customer@gmail.com';
            $passed = ($res['status'] === 302 && $res['location'] === '/' && $isLoggedIn);

            $results[] = [
                'name' => 'HttpFlowTest: User login with seeded credentials returns HTTP 302 and sets authenticated user in session',
                'passed' => $passed,
                'error' => "Status {$res['status']}, Location: " . ($res['location'] ?? 'none') . ", LoggedIn: " . ($isLoggedIn ? 'YES' : 'NO')
            ];
        } catch (\Throwable $e) {
            $results[] = [
                'name' => 'HttpFlowTest: User login with seeded credentials returns HTTP 302 and sets authenticated user in session',
                'passed' => false,
                'error' => $e->getMessage()
            ];
        }

        // TC 14: User login in Apache subfolder mode returns HTTP 302 redirecting to /12b5-store/public/
        try {
            $res = self::simulateRequest([
                'method' => 'POST',
                'uri' => '/12b5-store/public/login',
                'script_name' => '/12b5-store/public/index.php',
                'post' => [
                    'email' => 'customer@gmail.com',
                    'password' => 'user123',
                    'csrf_token' => $csrfToken
                ],
                'session_data' => ['csrf_token' => $csrfToken]
            ]);
            $passed = ($res['status'] === 302 && $res['location'] === '/12b5-store/public/');

            $results[] = [
                'name' => 'HttpFlowTest: User login in Apache subfolder mode returns HTTP 302 redirecting to /12b5-store/public/',
                'passed' => $passed,
                'error' => "Status {$res['status']}, Location: " . ($res['location'] ?? 'none')
            ];
        } catch (\Throwable $e) {
            $results[] = [
                'name' => 'HttpFlowTest: User login in Apache subfolder mode returns HTTP 302 redirecting to /12b5-store/public/',
                'passed' => false,
                'error' => $e->getMessage()
            ];
        }

        // TC 15: User login with invalid password is rejected without setting session
        try {
            $res = self::simulateRequest([
                'method' => 'POST',
                'uri' => '/login',
                'script_name' => '/index.php',
                'post' => [
                    'email' => 'customer@gmail.com',
                    'password' => 'wrong_password_attempt',
                    'csrf_token' => $csrfToken
                ],
                'session_data' => ['csrf_token' => $csrfToken]
            ]);
            $noUser = empty($res['session']['user']);
            $hasErrMsg = str_contains($res['body'], 'không chính xác');
            $passed = ($res['status'] === 200 && $noUser && $hasErrMsg);

            $results[] = [
                'name' => 'HttpFlowTest: User login with invalid password is rejected without setting session',
                'passed' => $passed,
                'error' => "Status {$res['status']}, NoUser: " . ($noUser ? 'YES' : 'NO') . ", HasErrMsg: " . ($hasErrMsg ? 'YES' : 'NO')
            ];
        } catch (\Throwable $e) {
            $results[] = [
                'name' => 'HttpFlowTest: User login with invalid password is rejected without setting session',
                'passed' => false,
                'error' => $e->getMessage()
            ];
        }

        // TC 16 & 17: Checkout order placement returns HTTP 302 redirect and records order, items, stock decrement, and shipping fee
        $orderIdCreated = null;
        $initialStock = 0;
        try {
            $pdo = Database::getConnection();

            // Record initial stock for product #11
            $initialStock = (int)$pdo->query("SELECT stock FROM products WHERE id = 11")->fetchColumn();

            $res = self::simulateRequest([
                'method' => 'POST',
                'uri' => '/checkout/process',
                'script_name' => '/index.php',
                'post' => [
                    'customer_name' => 'Nguyễn Văn An Flow Test',
                    'customer_email' => 'customer@gmail.com',
                    'customer_phone' => '0987654321',
                    'shipping_address' => 'Số 456 Phố Tràng Tiền, Hoàn Kiếm, Hà Nội',
                    'payment_method' => 'cod',
                    'notes' => 'HTTP flow automated test order',
                    'csrf_token' => $csrfToken
                ],
                'session_data' => [
                    'csrf_token' => $csrfToken,
                    'user' => [
                        'id' => 2,
                        'name' => 'Nguyễn Văn An',
                        'email' => 'customer@gmail.com',
                        'role' => 'customer'
                    ],
                    'cart' => [
                        11 => ['product_id' => 11, 'quantity' => 1] // 590,000₫ (< 5M) -> shipping fee 30,000₫
                    ]
                ]
            ]);

            $is302 = ($res['status'] === 302);
            $locationMatches = str_starts_with($res['location'] ?? '', '/checkout/success?code=ORD-');
            $orderCode = $res['session']['last_order_code'] ?? '';

            // Verify order in database
            $orderStmt = $pdo->prepare("SELECT * FROM orders WHERE order_code = ?");
            $orderStmt->execute([$orderCode]);
            $dbOrder = $orderStmt->fetch();

            $orderExists = ($dbOrder !== false);
            $orderIdCreated = $orderExists ? (int)$dbOrder['id'] : null;

            $correctAmounts = false;
            $itemsCountValid = false;
            $stockDecremented = false;

            if ($orderExists) {
                // Total = 590,000₫, shipping = 30,000₫, final = 620,000₫
                $correctAmounts = ((float)$dbOrder['total_amount'] === 590000.0 && (float)$dbOrder['final_amount'] === 620000.0);

                // Verify order_items
                $itemsStmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
                $itemsStmt->execute([$orderIdCreated]);
                $dbItems = $itemsStmt->fetchAll();
                $itemsCountValid = (count($dbItems) === 1 && (int)$dbItems[0]['product_id'] === 11 && (int)$dbItems[0]['quantity'] === 1);

                // Verify stock decrement
                $newStock = (int)$pdo->query("SELECT stock FROM products WHERE id = 11")->fetchColumn();
                $stockDecremented = ($newStock === $initialStock - 1);
            }

            $tc16Passed = ($is302 && $locationMatches && $orderExists && $correctAmounts && $itemsCountValid && $stockDecremented);

            $results[] = [
                'name' => 'HttpFlowTest: Checkout order placement returns HTTP 302 redirect and records order, items, stock decrement, and shipping fee',
                'passed' => $tc16Passed,
                'error' => "302: " . ($is302 ? 'Y' : 'N') . ", Location: " . ($locationMatches ? 'Y' : 'N') . ", DBOrder: " . ($orderExists ? 'Y' : 'N') . ", Amounts: " . ($correctAmounts ? 'Y' : 'N') . ", Items: " . ($itemsCountValid ? 'Y' : 'N') . ", StockDec: " . ($stockDecremented ? 'Y' : 'N')
            ];

            // TC 17: Authorized order confirmation view returns HTTP 200 with matching order code
            if ($orderExists) {
                $resSuccess = self::simulateRequest([
                    'uri' => '/checkout/success?code=' . urlencode($orderCode),
                    'script_name' => '/index.php',
                    'session_data' => $res['session']
                ]);
                $successPassed = ($resSuccess['status'] === 200 && str_contains($resSuccess['body'], $orderCode) && str_contains($resSuccess['body'], 'Đặt hàng thành công'));

                $results[] = [
                    'name' => 'HttpFlowTest: Authorized order confirmation view returns HTTP 200 with matching order code',
                    'passed' => $successPassed,
                    'error' => "Status {$resSuccess['status']}, Body has code: " . (str_contains($resSuccess['body'], $orderCode) ? 'Y' : 'N')
                ];
            } else {
                $results[] = [
                    'name' => 'HttpFlowTest: Authorized order confirmation view returns HTTP 200 with matching order code',
                    'passed' => false,
                    'error' => 'Skipped because order was not recorded'
                ];
            }

        } catch (\Throwable $e) {
            $results[] = [
                'name' => 'HttpFlowTest: Checkout order placement returns HTTP 302 redirect and records order, items, stock decrement, and shipping fee',
                'passed' => false,
                'error' => $e->getMessage()
            ];
            $results[] = [
                'name' => 'HttpFlowTest: Authorized order confirmation view returns HTTP 200 with matching order code',
                'passed' => false,
                'error' => $e->getMessage()
            ];
        } finally {
            // Restore database cleanliness
            if ($orderIdCreated !== null && $orderIdCreated > 0) {
                try {
                    $pdo = Database::getConnection();
                    $pdo->prepare("DELETE FROM order_items WHERE order_id = ?")->execute([$orderIdCreated]);
                    $pdo->prepare("DELETE FROM orders WHERE id = ?")->execute([$orderIdCreated]);
                    if ($initialStock > 0) {
                        $pdo->prepare("UPDATE products SET stock = ? WHERE id = 11")->execute([$initialStock]);
                    }
                } catch (\Throwable $cleanEx) {
                    // Ignore cleanup exceptions
                }
            }
        }

        return $results;
    }

    /**
     * Launch an isolated sub-process to simulate a full HTTP request lifecycle against public/index.php
     */
    public static function simulateRequest(array $options): array {
        $php = self::findPhpBinary();
        $workerScript = __FILE__;

        $descriptors = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];

        // Pass clean environment map
        $env = [];
        foreach ($_SERVER as $k => $v) {
            if (is_string($v)) {
                $env[$k] = $v;
            }
        }
        foreach ($_ENV as $k => $v) {
            if (is_string($v)) {
                $env[$k] = $v;
            }
        }
        $env['SystemRoot'] = getenv('SystemRoot') ?: 'C:\\Windows';
        $env['PATH'] = getenv('PATH') ?: '';
        $env['TEMP'] = getenv('TEMP') ?: sys_get_temp_dir();
        $env['TMP'] = getenv('TMP') ?: sys_get_temp_dir();
        if (getenv('DB_DRIVER')) {
            $env['DB_DRIVER'] = getenv('DB_DRIVER');
        }
        if (getenv('DB_NAME')) {
            $env['DB_NAME'] = getenv('DB_NAME');
        }
        if (getenv('DB_HOST')) {
            $env['DB_HOST'] = getenv('DB_HOST');
        }
        if (getenv('DB_PORT')) {
            $env['DB_PORT'] = getenv('DB_PORT');
        }
        if (getenv('DB_USER')) {
            $env['DB_USER'] = getenv('DB_USER');
        }
        if (getenv('DB_PASS') !== false) {
            $env['DB_PASS'] = getenv('DB_PASS');
        }

        $cmd = [$php, $workerScript, '--worker'];
        $proc = @proc_open($cmd, $descriptors, $pipes, dirname(__DIR__), $env);

        if (!is_resource($proc)) {
            $cmdStr = '"' . $php . '" "' . $workerScript . '" --worker';
            $proc = proc_open($cmdStr, $descriptors, $pipes, dirname(__DIR__), $env);
            if (!is_resource($proc)) {
                throw new \RuntimeException("Failed to launch HTTP flow worker process with binary: {$php}");
            }
        }

        $payload = json_encode($options);
        fwrite($pipes[0], $payload);
        fclose($pipes[0]);

        $stdout = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        proc_close($proc);

        $startMarker = '---HTTP_WORKER_RESPONSE_START---';
        $endMarker = '---HTTP_WORKER_RESPONSE_END---';

        $startPos = strpos($stdout, $startMarker);
        $endPos = strpos($stdout, $endMarker);

        if ($startPos === false || $endPos === false) {
            throw new \RuntimeException(
                "Worker output missing markers.\nSTDOUT:\n" . substr($stdout, 0, 1000) . "\nSTDERR:\n" . substr($stderr, 0, 1000)
            );
        }

        $jsonStr = trim(substr($stdout, $startPos + strlen($startMarker), $endPos - ($startPos + strlen($startMarker))));
        $response = json_decode($jsonStr, true);

        if (!is_array($response)) {
            throw new \RuntimeException("Failed to decode worker response: {$jsonStr}\nSTDERR: {$stderr}");
        }

        return $response;
    }

    /**
     * Worker execution loop inside child process
     */
    public static function executeWorker(): void {
        $stdin = file_get_contents('php://stdin');
        $req = json_decode($stdin, true);
        if (!is_array($req)) {
            $req = [];
        }

        $method = strtoupper($req['method'] ?? 'GET');
        $uri = $req['uri'] ?? '/';
        $scriptName = $req['script_name'] ?? '/index.php';
        $post = $req['post'] ?? [];
        $get = $req['get'] ?? [];
        $headers = $req['headers'] ?? [];
        $cookies = $req['cookies'] ?? [];
        $sessionData = $req['session_data'] ?? [];
        $sessionId = $req['session_id'] ?? null;

        // Reset and populate $_SERVER
        $_SERVER['REQUEST_METHOD'] = $method;
        $_SERVER['REQUEST_URI'] = $uri;
        $_SERVER['SCRIPT_NAME'] = $scriptName;
        $_SERVER['PHP_SELF'] = $scriptName;
        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
        $_SERVER['SERVER_NAME'] = 'localhost';
        $_SERVER['HTTP_HOST'] = 'localhost';
        $_SERVER['SERVER_PORT'] = '80';
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $_SERVER['SCRIPT_FILENAME'] = realpath(__DIR__ . '/../public/index.php');
        $_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__ . '/../public');

        $parsedUri = parse_url($uri);
        $_SERVER['QUERY_STRING'] = $parsedUri['query'] ?? '';
        if (!empty($_SERVER['QUERY_STRING'])) {
            parse_str($_SERVER['QUERY_STRING'], $parsedGet);
            $get = array_merge($parsedGet, $get);
        }
        $_GET = $get;
        $_POST = $post;
        $_COOKIE = $cookies;

        foreach ($headers as $k => $v) {
            $key = 'HTTP_' . strtoupper(str_replace('-', '_', $k));
            $_SERVER[$key] = $v;
        }
        if (isset($headers['Content-Type'])) {
            $_SERVER['CONTENT_TYPE'] = $headers['Content-Type'];
        }

        if (!empty($sessionId)) {
            session_id($sessionId);
        }
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!empty($sessionData)) {
            foreach ($sessionData as $k => $v) {
                $_SESSION[$k] = $v;
            }
        }

        // Output buffering and shutdown handler to capture headers, status code, and HTML body
        ob_start();

        register_shutdown_function(function () {
            $body = '';
            while (ob_get_level() > 0) {
                $body = ob_get_clean() . $body;
            }

            $statusCode = http_response_code();
            if (!$statusCode || $statusCode === 0) {
                $statusCode = 200;
            }

            $headers = headers_list();
            $location = null;
            foreach ($headers as $h) {
                if (stripos($h, 'Location:') === 0) {
                    $location = trim(substr($h, 9));
                }
            }

            if ($location !== null && $statusCode === 200) {
                $statusCode = 302;
            }

            $result = [
                'status' => $statusCode,
                'headers' => $headers,
                'location' => $location,
                'body' => $body,
                'session' => $_SESSION ?? [],
                'session_id' => session_id(),
            ];

            echo "\n---HTTP_WORKER_RESPONSE_START---\n";
            echo json_encode($result);
            echo "\n---HTTP_WORKER_RESPONSE_END---\n";
        });

        chdir(__DIR__ . '/../public');
        require __DIR__ . '/../public/index.php';
    }

    private static function findPhpBinary(): string {
        $candidates = [
            defined('PHP_BINARY') && !empty(PHP_BINARY) ? PHP_BINARY : null,
            'C:\\xamppnp\\php\\php.exe',
            'C:\\xampp\\php\\php.exe',
            'C:\\php\\php.exe',
            'php'
        ];
        foreach ($candidates as $cand) {
            if (!empty($cand) && file_exists($cand)) {
                return $cand;
            }
        }
        return 'php';
    }
}

// Worker mode entry point: executed when invoked as isolated sub-process for HTTP simulation
if (php_sapi_name() === 'cli' && isset($argv[1]) && $argv[1] === '--worker') {
    HttpFlowTest::executeWorker();
    exit(0);
}
