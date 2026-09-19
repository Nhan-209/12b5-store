<?php
/**
 * Isolated Worker for Adversarial HTTP Simulation
 */

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
$_SERVER['QUERY_STRING'] = is_array($parsedUri) ? ($parsedUri['query'] ?? '') : '';
if (!empty($_SERVER['QUERY_STRING'])) {
    parse_str($_SERVER['QUERY_STRING'], $parsedGet);
    $get = array_merge($parsedGet, $get);
}
$_GET = $get;
$_POST = $post;

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

    $result = [
        'status' => $statusCode,
        'body' => $body,
    ];

    echo "\n---RESPONSE_START---\n";
    echo json_encode($result);
    echo "\n---RESPONSE_END---\n";
});

chdir(__DIR__ . '/../public');
require __DIR__ . '/../public/index.php';
