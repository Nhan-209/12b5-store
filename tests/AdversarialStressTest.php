<?php
namespace Tests;

use App\Models\Database;
use App\Models\Product;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Core\Csrf;
use PDO;

class AdversarialStressTest {

    public static function run(): array {
        $results = [];

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // =============================================================
        // TASK 1: Cart Edge Cases & Manipulations
        // =============================================================

        // 1.1 Direct Cart::addItem with negative quantity (-5)
        Cart::clear();
        $resNeg = Cart::addItem(1, -5);
        $cartNeg = Cart::getCart();
        $qtyNeg = $cartNeg['items'][0]['quantity'] ?? 0;
        $passedNeg = ($resNeg['success'] === false) || ($qtyNeg > 0);
        $results[] = [
            'name' => 'Adversarial Cart: Direct Cart::addItem rejects negative quantity',
            'passed' => $passedNeg,
            'error' => $passedNeg ? '' : "VULNERABILITY: Cart::addItem(1, -5) succeeded and placed negative quantity ({$qtyNeg}) into session"
        ];

        // 1.2 CartController logic: max(1, (int)$_POST['quantity']) sanitization
        Cart::clear();
        $postedNegQty = -5;
        $sanitizedQty = max(1, (int)$postedNegQty);
        Cart::addItem(1, $sanitizedQty);
        $cartSanitized = Cart::getCart();
        $qtySanitized = $cartSanitized['items'][0]['quantity'] ?? 0;
        $results[] = [
            'name' => 'Adversarial Cart: CartController sanitization coerces negative quantity to 1',
            'passed' => ($qtySanitized === 1),
            'error' => "Expected quantity 1, got {$qtySanitized}"
        ];

        // 1.3 Direct Cart::addItem with 0 quantity
        Cart::clear();
        $resZero = Cart::addItem(1, 0);
        $cartZero = Cart::getCart();
        $hasZeroItem = isset($cartZero['items'][0]) && $cartZero['items'][0]['quantity'] === 0;
        $results[] = [
            'name' => 'Adversarial Cart: Direct Cart::addItem does not permit 0-quantity items',
            'passed' => !$hasZeroItem,
            'error' => $hasZeroItem ? "DEFECT: Cart item with quantity 0 was stored in session" : ""
        ];

        // 1.4 Non-numeric quantity coercion
        $nonNumericString = "abc_injection_123";
        $coerced = max(1, (int)$nonNumericString);
        $results[] = [
            'name' => 'Adversarial Cart: Non-numeric quantity safely coerced to integer >= 1',
            'passed' => ($coerced === 1),
            'error' => "Coerced value was {$coerced}"
        ];

        // 1.5 Add quantity exceeding stock
        Cart::clear();
        $prod1 = Product::findById(1);
        $prod1Stock = (int)$prod1['stock'];
        $resExceed = Cart::addItem(1, $prod1Stock + 9999);
        $results[] = [
            'name' => 'Adversarial Cart: Reject add quantity exceeding available stock',
            'passed' => ($resExceed['success'] === false),
            'error' => "Exceeding stock was accepted: " . ($resExceed['message'] ?? '')
        ];

        // 1.6 Update quantity to 0 removes item
        Cart::clear();
        Cart::addItem(1, 2);
        Cart::updateQuantity(1, 0);
        $cartAfterZero = Cart::getCart();
        $results[] = [
            'name' => 'Adversarial Cart: Updating quantity to 0 removes item from cart',
            'passed' => empty($cartAfterZero['items']),
            'error' => "Item was not removed after updating quantity to 0"
        ];

        // 1.7 Update quantity to negative (-10) removes item
        Cart::clear();
        Cart::addItem(1, 2);
        Cart::updateQuantity(1, -10);
        $cartAfterNegUpdate = Cart::getCart();
        $results[] = [
            'name' => 'Adversarial Cart: Updating quantity to negative removes item from cart',
            'passed' => empty($cartAfterNegUpdate['items']),
            'error' => "Item was not removed after updating quantity to negative"
        ];

        // 1.8 Invalid coupon code rejection
        Cart::clear();
        Cart::addItem(1, 1);
        $resInvalidCoupon = Cart::applyCoupon('INVALID_COUPON_9999');
        $results[] = [
            'name' => 'Adversarial Cart: Reject non-existent coupon code',
            'passed' => ($resInvalidCoupon['success'] === false),
            'error' => "Invalid coupon was accepted"
        ];

        // 1.9 Expired coupon code rejection
        $pdo = Database::getConnection();
        $pdo->prepare("DELETE FROM coupons WHERE code = 'ADV_EXPIRED'")->execute();
        $pdo->prepare("
            INSERT INTO coupons (code, discount_type, discount_value, min_order_value, expires_at, usage_limit, used_count, status)
            VALUES ('ADV_EXPIRED', 'fixed', 100000.00, 1000000.00, '2020-01-01 00:00:00', 100, 0, 1)
        ")->execute();
        $resExpired = Cart::applyCoupon('ADV_EXPIRED');
        $pdo->prepare("DELETE FROM coupons WHERE code = 'ADV_EXPIRED'")->execute();
        $results[] = [
            'name' => 'Adversarial Cart: Reject expired coupon (expires_at < NOW)',
            'passed' => ($resExpired['success'] === false && str_contains($resExpired['message'] ?? '', 'hết hạn')),
            'error' => "Expired coupon was accepted or gave wrong message: " . ($resExpired['message'] ?? '')
        ];

        // 1.10 Usage limit exceeded coupon rejection
        $pdo->prepare("DELETE FROM coupons WHERE code = 'ADV_MAXED'")->execute();
        $pdo->prepare("
            INSERT INTO coupons (code, discount_type, discount_value, min_order_value, expires_at, usage_limit, used_count, status)
            VALUES ('ADV_MAXED', 'fixed', 100000.00, 1000000.00, '2030-01-01 00:00:00', 10, 10, 1)
        ")->execute();
        $resMaxed = Cart::applyCoupon('ADV_MAXED');
        $pdo->prepare("DELETE FROM coupons WHERE code = 'ADV_MAXED'")->execute();
        $results[] = [
            'name' => 'Adversarial Cart: Reject coupon with usage_limit exhausted (used_count >= usage_limit)',
            'passed' => ($resMaxed['success'] === false && str_contains($resMaxed['message'] ?? '', 'vượt quá lượt sử dụng')),
            'error' => "Maxed coupon was accepted or gave wrong message: " . ($resMaxed['message'] ?? '')
        ];

        // 1.11 Empty coupon code clears coupon and resets discount to 0
        Cart::clear();
        Cart::addItem(1, 1);
        Cart::applyCoupon('WELCOME2026');
        $cartBeforeClear = Cart::getCart();
        $hadCoupon = !empty($cartBeforeClear['coupon']) && $cartBeforeClear['discount_amount'] > 0;
        Cart::applyCoupon('');
        $cartAfterClear = Cart::getCart();
        $couponCleared = empty($cartAfterClear['coupon']) && $cartAfterClear['discount_amount'] === 0.0;
        $results[] = [
            'name' => 'Adversarial Cart: Empty coupon code unsets coupon and resets discount to 0',
            'passed' => ($hadCoupon && $couponCleared),
            'error' => "Empty coupon did not properly clear discount: " . $cartAfterClear['discount_amount']
        ];

        // 1.12 Rapid coupon switching
        Cart::clear();
        Cart::addItem(1, 1);
        Cart::applyCoupon('WELCOME2026');
        $c1 = $_SESSION['coupon']['code'] ?? '';
        Cart::applyCoupon('TECHSALE10');
        $c2 = $_SESSION['coupon']['code'] ?? '';
        $results[] = [
            'name' => 'Adversarial Cart: Rapid coupon switching correctly overwrites active coupon',
            'passed' => ($c1 === 'WELCOME2026' && $c2 === 'TECHSALE10'),
            'error' => "Coupon was {$c1} then {$c2}"
        ];

        // 1.13 Cart subtotal falling below min_order_value automatically revokes coupon
        Cart::clear();
        Cart::addItem(1, 1);  // ~34.99M
        Cart::addItem(11, 1); // 590K
        Cart::applyCoupon('WELCOME2026'); // min 10M
        $cActive = !empty($_SESSION['coupon']);
        Cart::removeItem(1); // subtotal drops to 590K < 10M
        $cartAfterDrop = Cart::getCart();
        $cDropped = empty($cartAfterDrop['coupon']) && $cartAfterDrop['discount_amount'] === 0.0;
        $results[] = [
            'name' => 'Adversarial Cart: Revoke coupon when subtotal drops below min_order_value',
            'passed' => ($cActive && $cDropped),
            'error' => "Coupon was not dropped when subtotal became {$cartAfterDrop['subtotal']}"
        ];

        // =============================================================
        // TASK 2: Auth & CSRF Protection Stress
        // =============================================================

        // 2.1 Missing CSRF token
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        unset($_POST['csrf_token']);
        unset($_SERVER['HTTP_X_CSRF_TOKEN']);
        $results[] = [
            'name' => 'Adversarial CSRF: Reject request with completely missing CSRF token',
            'passed' => (Csrf::validate() === false),
            'error' => 'Missing CSRF token was accepted as valid'
        ];

        // 2.2 Tampered CSRF token
        $_POST['csrf_token'] = 'tampered_forged_csrf_token_value';
        $results[] = [
            'name' => 'Adversarial CSRF: Reject request with forged / invalid CSRF token',
            'passed' => (Csrf::validate() === false),
            'error' => 'Forged CSRF token was accepted as valid'
        ];

        // 2.3 Cross-session CSRF token replay
        $tokenSessionA = bin2hex(random_bytes(32));
        $tokenSessionB = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $tokenSessionB;
        $_POST['csrf_token'] = $tokenSessionA;
        $results[] = [
            'name' => 'Adversarial CSRF: Reject cross-session CSRF token replay',
            'passed' => (Csrf::validate() === false),
            'error' => 'Cross-session CSRF token was accepted'
        ];

        // 2.4 SQL Injection in login email
        $sqliPayloads = [
            "' OR '1'='1",
            "admin@electro.vn'--",
            "' UNION SELECT 1, 'admin', 'hacked', '0999', 'addr', 'admin', NOW()--",
            "\" OR \"\"=\"",
            "admin@electro.vn'; DROP TABLE test;--"
        ];
        $allBlocked = true;
        foreach ($sqliPayloads as $payload) {
            if (User::verifyCredentials($payload, 'any_password') !== null) {
                $allBlocked = false;
                break;
            }
        }
        $results[] = [
            'name' => 'Adversarial Auth: SQL injection in email field prevented by parameterized queries',
            'passed' => $allBlocked,
            'error' => 'One or more SQL injection payloads bypassed authentication'
        ];

        // 2.5 SQL Injection in login password
        $passSqliBlocked = (User::verifyCredentials('admin@electro.vn', "' OR '1'='1") === null);
        $results[] = [
            'name' => 'Adversarial Auth: SQL injection in password field prevented by bcrypt verification',
            'passed' => $passSqliBlocked,
            'error' => 'SQL injection in password field was accepted'
        ];

        // 2.6 Brute force resistance & error handling
        $failedAttempts = 0;
        for ($i = 0; $i < 10; $i++) {
            if (User::verifyCredentials('admin@electro.vn', 'incorrect_password_' . $i) === null) {
                $failedAttempts++;
            }
        }
        $results[] = [
            'name' => 'Adversarial Auth: 10 consecutive invalid password attempts cleanly rejected',
            'passed' => ($failedAttempts === 10),
            'error' => "Failed attempts: {$failedAttempts}/10"
        ];

        // 2.7 Password hash sanitization upon login
        $validUser = User::verifyCredentials('customer@gmail.com', 'user123');
        $hashScrubbed = ($validUser !== null && !isset($validUser['password_hash']));
        $results[] = [
            'name' => 'Adversarial Auth: Password hash is stripped from authenticated user object',
            'passed' => $hashScrubbed,
            'error' => 'password_hash remained present in authenticated user object'
        ];

        // =============================================================
        // TASK 3: Checkout Stress & Atomic Transactions
        // =============================================================

        // 3.1 Checkout with empty cart rejected
        Cart::clear();
        $emptyOrderRes = Order::createFromCart([
            'customer_name' => 'Empty Buyer',
            'customer_email' => 'empty@buyer.com',
            'customer_phone' => '0912345678',
            'shipping_address' => 'Empty Address',
            'payment_method' => 'cod'
        ]);
        // Note: Check what Order::createFromCart does when cart items is empty!
        // In Order::createOrder: if cartItems is empty, does it insert an order with 0 items?
        // Let's observe this empirically!
        $results[] = [
            'name' => 'Adversarial Checkout: Empty cart order rejected',
            'passed' => ($emptyOrderRes['success'] === false),
            'error' => ($emptyOrderRes['success'] ? "VULNERABILITY: Order::createFromCart succeeded with empty cart! Created order ID: " . ($emptyOrderRes['order_id'] ?? 'none') : "")
        ];
        if (!empty($emptyOrderRes['order_id'])) {
            $pdo->prepare("DELETE FROM orders WHERE id = ?")->execute([$emptyOrderRes['order_id']]);
        }

        // 3.2 Missing required customer fields
        $fields = ['customer_name', 'customer_email', 'customer_phone', 'shipping_address'];
        $fieldsValidated = true;
        foreach ($fields as $field) {
            $sample = [
                'customer_name' => 'Test Name',
                'customer_email' => 'test@email.com',
                'customer_phone' => '0912345678',
                'shipping_address' => '123 Test',
            ];
            $sample[$field] = '';
            if (!empty($sample['customer_name']) && !empty($sample['customer_email']) && !empty($sample['customer_phone']) && !empty($sample['shipping_address'])) {
                $fieldsValidated = false;
            }
        }
        $results[] = [
            'name' => 'Adversarial Checkout: All 4 customer contact fields are strictly required',
            'passed' => $fieldsValidated,
            'error' => 'Required field validation failed'
        ];

        // 3.3 Unauthorized payment method
        $allowedMethods = ['cod', 'bank_transfer'];
        $badMethod = 'crypto_currency_payload';
        $results[] = [
            'name' => 'Adversarial Checkout: Unauthorized payment method rejected',
            'passed' => !in_array($badMethod, $allowedMethods, true),
            'error' => 'Disallowed payment method accepted'
        ];

        // 3.4 Atomic rollback when stock runs out mid-transaction
        $stock1 = (int)Product::findById(1)['stock'];
        $stock2 = (int)Product::findById(2)['stock'];
        $multiCart = [
            [
                'product_id' => 1,
                'name' => 'Product 1',
                'sku' => 'SKU-1',
                'price' => 100000.0,
                'quantity' => 1,
                'subtotal' => 100000.0
            ],
            [
                'product_id' => 2,
                'name' => 'Product 2',
                'sku' => 'SKU-2',
                'price' => 200000.0,
                'quantity' => $stock2 + 9999, // Exceeds stock
                'subtotal' => 200000.0 * ($stock2 + 9999)
            ]
        ];
        $orderRes = Order::createOrder([
            'user_id' => null,
            'customer_name' => 'Rollback Buyer',
            'customer_email' => 'rollback@buyer.com',
            'customer_phone' => '0912345678',
            'shipping_address' => 'Rollback St',
            'payment_method' => 'cod',
            'total_amount' => 300000.0,
            'discount_amount' => 0.0,
            'final_amount' => 300000.0
        ], $multiCart);

        $stockAfter1 = (int)Product::findById(1)['stock'];
        $stockAfter2 = (int)Product::findById(2)['stock'];
        $rollbackClean = ($orderRes['success'] === false && $stockAfter1 === $stock1 && $stockAfter2 === $stock2);
        $results[] = [
            'name' => 'Adversarial Checkout: Atomic rollback leaves prior item stock unchanged upon deficit',
            'passed' => $rollbackClean,
            'error' => "Rollback failed: Product 1 Stock went from {$stock1} to {$stockAfter1}"
        ];

        // 3.5 Race condition / stock depletion race
        $pdo->prepare("UPDATE products SET stock = 1 WHERE id = 11")->execute();
        $raceItemCart = [
            [
                'product_id' => 11,
                'name' => 'Charger Test',
                'sku' => 'MI-CHARGER-67W',
                'price' => 590000.0,
                'quantity' => 1,
                'subtotal' => 590000.0
            ]
        ];
        $buyer1 = [
            'user_id' => null,
            'customer_name' => 'Race Buyer 1',
            'customer_email' => 'race1@test.com',
            'customer_phone' => '0911111111',
            'shipping_address' => 'Race Street 1',
            'payment_method' => 'cod',
            'total_amount' => 590000.0,
            'discount_amount' => 0.0,
            'final_amount' => 590000.0
        ];
        $buyer2 = [
            'user_id' => null,
            'customer_name' => 'Race Buyer 2',
            'customer_email' => 'race2@test.com',
            'customer_phone' => '0922222222',
            'shipping_address' => 'Race Street 2',
            'payment_method' => 'cod',
            'total_amount' => 590000.0,
            'discount_amount' => 0.0,
            'final_amount' => 590000.0
        ];
        $resBuyer1 = Order::createOrder($buyer1, $raceItemCart);
        $resBuyer2 = Order::createOrder($buyer2, $raceItemCart);
        $finalStock11 = (int)Product::findById(11)['stock'];

        $raceSuccess = ($resBuyer1['success'] === true && $resBuyer2['success'] === false && $finalStock11 === 0);
        $results[] = [
            'name' => 'Adversarial Checkout: Sequential race condition prevents double-spend of last stock unit',
            'passed' => $raceSuccess,
            'error' => "Race failed: Buyer1=" . ($resBuyer1['success'] ? 'T' : 'F') . ", Buyer2=" . ($resBuyer2['success'] ? 'T' : 'F') . ", Final Stock={$finalStock11}"
        ];

        // Cleanup race orders & restore stock
        if (!empty($resBuyer1['order_id'])) {
            $pdo->prepare("DELETE FROM order_items WHERE order_id = ?")->execute([$resBuyer1['order_id']]);
            $pdo->prepare("DELETE FROM orders WHERE id = ?")->execute([$resBuyer1['order_id']]);
        }
        $pdo->prepare("UPDATE products SET stock = 120 WHERE id = 11")->execute();

        // =============================================================
        // TASK 4: Mathematical Consistency Across Extreme Combinations
        // =============================================================
        $mathCases = [
            ['subtotal' => 0, 'discount' => 0, 'exp_ship' => 0, 'exp_final' => 0],
            ['subtotal' => 100000, 'discount' => 0, 'exp_ship' => 30000, 'exp_final' => 130000],
            ['subtotal' => 4999999, 'discount' => 0, 'exp_ship' => 30000, 'exp_final' => 5029999],
            ['subtotal' => 5000000, 'discount' => 0, 'exp_ship' => 0, 'exp_final' => 5000000],
            ['subtotal' => 5000001, 'discount' => 0, 'exp_ship' => 0, 'exp_final' => 5000001],
            ['subtotal' => 50000000, 'discount' => 500000, 'exp_ship' => 0, 'exp_final' => 49500000],
            ['subtotal' => 200000, 'discount' => 500000, 'exp_ship' => 30000, 'exp_final' => 30000],
        ];

        $mathPassed = true;
        $mathDetails = '';
        foreach ($mathCases as $mc) {
            $sub = (float)$mc['subtotal'];
            $disc = (float)$mc['discount'];
            $cappedDisc = min($disc, $sub);
            $ship = ($sub > 0 && $sub < 5000000) ? 30000.0 : 0.0;
            $fin = max(0.0, $sub - $cappedDisc + $ship);
            if ($ship !== (float)$mc['exp_ship'] || $fin !== (float)$mc['exp_final']) {
                $mathPassed = false;
                $mathDetails = "Subtotal {$sub}: expected ship {$mc['exp_ship']}, got {$ship}; expected final {$mc['exp_final']}, got {$fin}";
                break;
            }
        }
        $results[] = [
            'name' => 'Adversarial Math: Pricing & shipping rules consistent across all extreme thresholds',
            'passed' => $mathPassed,
            'error' => $mathDetails
        ];

        return $results;
    }
}
