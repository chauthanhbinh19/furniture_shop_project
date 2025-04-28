<?php

function routeProducts($uri) {
    require_once __DIR__ . '/../controllers/ProductController.php';
    // $controller = new ProductController();

    $path = trim(str_replace('/products', '', $uri), '/');

    switch ($path) {
        case '':
            $controller->index(); // Danh sách sản phẩm
            break;
        case 'create':
            $controller->create(); // Trang tạo sản phẩm
            break;
        case 'manage':
            $controller->manage(); // Quản lý sản phẩm
            break;
        default:
            http_response_code(404);
            echo "404 - Product page not found";
            break;
    }
}
