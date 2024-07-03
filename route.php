<?php
$routes = [
    '/' => 'home.php',
    '/video' => 'video.php',
];

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

function handle404() {
    http_response_code(404);
    echo "404 Not Found";
    exit();
}

$route = rtrim($requestUri, '/');
if (!isset($routes[$route])) {
    handle404();
}

include $routes[$route];
?>
