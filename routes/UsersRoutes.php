<?php

function routeUsers($uri) {
    // require_once __DIR__ . '/../controllers/ProductController.php';
    // $controller = new ProductController();

    $path = trim(str_replace('/products', '', $uri), '/');

    switch ($path) {
        
        default:
            http_response_code(404);
            echo "404 - Product page not found";
            break;
    }
}
