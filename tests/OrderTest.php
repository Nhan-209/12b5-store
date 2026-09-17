<?php
namespace Tests;

use App\Models\Order;
use App\Models\Product;

class OrderTest {
    public static function run(): array {
        $results = [];

        // Check product stock before order
        $product = Product::findById(2);
        $initialStock = (int)$product['stock'];

        $cartItems = [
            [
                'product_id' => 2,
                'name' => $product['name'],
                'sku' => $product['sku'],
                'price' => (float)$product['price'],
                'quantity' => 1,
                'subtotal' => (float)$product['price']
            ]
        ];

        $orderData = [
            'user_id' => 2,
            'customer_name' => 'Nguyễn Văn An Test',
            'customer_email' => 'customer@gmail.com',
            'customer_phone' => '0912345678',
            'shipping_address' => 'Số 123 Test Street, TP.HCM',
            'payment_method' => 'cod',
            'total_amount' => (float)$product['price'],
            'discount_amount' => 0.0,
            'final_amount' => (float)$product['price'],
            'notes' => 'Unit test order'
        ];

        // TC 1: Create valid order
        $res = Order::createOrder($orderData, $cartItems);
        $orderCreated = $res['success'] && !empty($res['order_code']);
        $results[] = [
            'name' => 'OrderTest: Create valid order with atomic transaction',
            'passed' => $orderCreated
        ];

        // TC 2: Verify stock decrement
        $updatedProduct = Product::findById(2);
        $stockDecremented = ((int)$updatedProduct['stock'] === $initialStock - 1);
        $results[] = [
            'name' => 'OrderTest: Stock decremented atomically by purchased quantity',
            'passed' => $stockDecremented
        ];

        // TC 3: Order retrieval by code
        $fetchedOrder = Order::findByCode($res['order_code']);
        $results[] = [
            'name' => 'OrderTest: Retrieve order by unique order code',
            'passed' => ($fetchedOrder !== null && $fetchedOrder['customer_name'] === 'Nguyễn Văn An Test')
        ];

        // TC 4: Reject order if stock insufficient
        $insufficientCart = [
            [
                'product_id' => 2,
                'name' => $product['name'],
                'sku' => $product['sku'],
                'price' => (float)$product['price'],
                'quantity' => 999999,
                'subtotal' => (float)$product['price'] * 999999
            ]
        ];
        $failRes = Order::createOrder($orderData, $insufficientCart);
        $results[] = [
            'name' => 'OrderTest: Rollback transaction if requested quantity > stock',
            'passed' => ($failRes['success'] === false)
        ];

        return $results;
    }
}
