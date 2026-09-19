<?php
namespace Tests;

use App\Models\Cart;
use App\Models\Product;

class CartTest {
    public static function run(): array {
        $results = [];

        // Reset cart session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        Cart::clear();

        // TC 1: Add product to cart
        $addRes = Cart::addItem(1, 2);
        $results[] = [
            'name' => 'CartTest: Add product #1 with quantity 2',
            'passed' => $addRes['success'] === true && count($addRes['cart']['items']) === 1 && $addRes['cart']['total_items'] === 2
        ];

        // TC 2: Update quantity
        $updateRes = Cart::updateQuantity(1, 3);
        $results[] = [
            'name' => 'CartTest: Update quantity of product #1 to 3',
            'passed' => $updateRes['success'] === true && $updateRes['cart']['total_items'] === 3
        ];

        // TC 3: Exceed stock limit
        $overStockRes = Cart::addItem(1, 999999);
        $results[] = [
            'name' => 'CartTest: Reject adding quantity exceeding stock',
            'passed' => $overStockRes['success'] === false
        ];

        // TC 4: Apply valid coupon WELCOME2026
        $couponRes = Cart::applyCoupon('WELCOME2026');
        $cart = Cart::getCart();
        $results[] = [
            'name' => 'CartTest: Apply coupon WELCOME2026',
            'passed' => $couponRes['success'] === true && $cart['discount_amount'] > 0
        ];

        // TC 5: Remove coupon via empty code
        $removeCouponRes = Cart::applyCoupon('');
        $cartAfterRemoval = Cart::getCart();
        $results[] = [
            'name' => 'CartTest: Remove coupon via empty code resets discount to 0',
            'passed' => $removeCouponRes['success'] === true && (float)$cartAfterRemoval['discount_amount'] === 0.0 && empty($cartAfterRemoval['coupon'])
        ];

        // TC 6: Remove product #1 from cart
        $removeRes = Cart::removeItem(1);
        $emptyCart = Cart::getCart();
        $results[] = [
            'name' => 'CartTest: Remove product #1 from cart',
            'passed' => $removeRes['success'] === true && count($emptyCart['items']) === 0
        ];

        // TC 7: Shipping fee calculation on orders under 5,000,000₫
        Cart::clear();
        $addSmallRes = Cart::addItem(11, 1); // Củ sạc nhanh Xiaomi 67W: 590,000₫ (< 5M)
        $smallCart = Cart::getCart();
        $results[] = [
            'name' => 'CartTest: Calculate 30,000₫ shipping fee for orders under 5,000,000₫',
            'passed' => $addSmallRes['success'] === true &&
                        (float)$smallCart['shipping_fee'] === 30000.0 &&
                        (float)$smallCart['final_amount'] === 620000.0 &&
                        $smallCart['formatted_shipping_fee'] === '30.000 ₫'
        ];

        // TC 8: Free shipping calculation on orders >= 5,000,000₫
        Cart::clear();
        $addLargeRes = Cart::addItem(1, 1); // iPhone 16 Pro Max: 34,990,000₫ (>= 5M)
        $largeCart = Cart::getCart();
        $results[] = [
            'name' => 'CartTest: Free shipping (0₫) for orders >= 5,000,000₫',
            'passed' => $addLargeRes['success'] === true &&
                        (float)$largeCart['shipping_fee'] === 0.0 &&
                        (float)$largeCart['final_amount'] === 34990000.0 &&
                        $largeCart['formatted_shipping_fee'] === '0 ₫'
        ];

        Cart::clear();
        return $results;
    }
}
