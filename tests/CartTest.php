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

        // TC 5: Remove item
        $removeRes = Cart::removeItem(1);
        $emptyCart = Cart::getCart();
        $results[] = [
            'name' => 'CartTest: Remove product #1 from cart',
            'passed' => $removeRes['success'] === true && count($emptyCart['items']) === 0
        ];

        Cart::clear();
        return $results;
    }
}
