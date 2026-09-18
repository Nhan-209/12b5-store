<?php
namespace Tests;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductTest {
    public static function run(): array {
        $results = [];

        try {
            // TC 1: Product list retrieval
            $products = Product::all(10, 0);
            $results[] = [
                'name' => 'ProductTest: Retrieve active electronics products',
                'passed' => !empty($products) && count($products) > 0 && isset($products[0]['formatted_price'])
            ];

            // TC 2: Find product by slug
            $prod = Product::findBySlug('iphone-16-pro-max-256gb');
            $results[] = [
                'name' => 'ProductTest: Find product by slug with parsed JSON specs',
                'passed' => $prod !== null && !empty($prod['specs_array']) && isset($prod['specs_array']['cpu'])
            ];

            // TC 3: Filter by category and price range
            $filtered = Product::filter([
                'category_id' => 1,
                'min_price' => 20000000,
                'max_price' => 40000000
            ]);
            $allWithinPrice = true;
            foreach ($filtered as $p) {
                if ($p['price'] < 20000000 || $p['price'] > 40000000 || $p['category_id'] != 1) {
                    $allWithinPrice = false;
                    break;
                }
            }
            $results[] = [
                'name' => 'ProductTest: Filter by category ID and price bounds',
                'passed' => !empty($filtered) && $allWithinPrice
            ];

            // TC 4: Add and retrieve product review
            $reviewAdded = Product::addReview(1, 2, 'Tester', 5, 'Sản phẩm dùng rất tốt, cấu hình cực mạnh!');
            $reviews = Product::getReviews(1);
            $results[] = [
                'name' => 'ProductTest: Submit review and verify persistence',
                'passed' => $reviewAdded && !empty($reviews) && $reviews[0]['rating'] == 5
            ];

            // TC 5: Verify completed order purchase check for reviews
            $hasPurchasedValid = Product::hasPurchased(2, 1);
            $hasPurchasedInvalid = Product::hasPurchased(2, 9999);
            $results[] = [
                'name' => 'ProductTest: Verify completed order purchase check for reviews',
                'passed' => ($hasPurchasedValid === true && $hasPurchasedInvalid === false)
            ];
        } finally {
            // Cleanup test review and restore product rating to keep database pristine
            $pdo = \App\Models\Database::getConnection();
            $pdo->prepare("DELETE FROM reviews WHERE user_name = 'Tester'")->execute();
            $avgStmt = $pdo->prepare("SELECT AVG(rating) as avg_rating, COUNT(*) as cnt FROM reviews WHERE product_id = 1");
            $avgStmt->execute();
            $stats = $avgStmt->fetch();
            $pdo->prepare("UPDATE products SET rating = ?, review_count = ? WHERE id = 1")->execute([
                round((float)($stats['avg_rating'] ?? 0), 1),
                (int)($stats['cnt'] ?? 0)
            ]);
        }

        return $results;
    }
}
