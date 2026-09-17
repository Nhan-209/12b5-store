<?php
namespace App\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Services\SearchService;
use App\Services\RustEngineService;

class ApiController {
    public function cartCount(): void {
        header('Content-Type: application/json');
        $cart = Cart::getCart();
        echo json_encode([
            'total_items' => $cart['total_items'],
            'subtotal' => $cart['subtotal'],
            'formatted_subtotal' => $cart['formatted_subtotal']
        ]);
        exit;
    }

    public function liveSearch(): void {
        header('Content-Type: application/json');
        $q = trim($_GET['q'] ?? '');
        if (strlen($q) < 2) {
            echo json_encode(['results' => []]);
            exit;
        }

        $searchService = new SearchService();
        $searchRes = $searchService->executeSearch($q);
        $topItems = array_slice($searchRes['results'], 0, 5);

        echo json_encode([
            'engine' => $searchRes['engine'],
            'latency_ms' => $searchRes['latency_ms'],
            'results' => array_map(function($p) {
                return [
                    'id' => $p['id'],
                    'name' => $p['name'],
                    'slug' => $p['slug'],
                    'price' => $p['formatted_price'] ?? number_format((float)$p['price'], 0, ',', '.') . ' ₫',
                    'thumbnail' => $p['thumbnail'] ?? 'default-device.jpg'
                ];
            }, $topItems)
        ]);
        exit;
    }

    public function rustStatus(): void {
        header('Content-Type: application/json');
        $rust = new RustEngineService();
        $isAvailable = $rust->isAvailable();
        echo json_encode([
            'available' => $isAvailable,
            'message' => $isAvailable ? 'Rust Microservice is active and responding.' : 'Rust Microservice is offline, falling back to PHP core engine.'
        ]);
        exit;
    }
}
