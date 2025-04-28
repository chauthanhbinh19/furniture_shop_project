<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/');

// Route cho admin
if (strpos($uri, '/admin') === 0) {
    require_once __DIR__ . '/routes/AdminRoutes.php';
    routeAdmin($uri);
    exit;
}

// Route cho sản phẩm (hoặc các nhóm chức năng khác)
if (strpos($uri, '/products') === 0) {
    require_once __DIR__ . '/routes/ProductsRoutes.php';
    routeProducts($uri);
    exit;
}

// Route cho users
if (strpos($uri, '/products') === 0) {
    require_once __DIR__ . '/routes/Users.php';
    routeProducts($uri);
    exit;
}

// Route mặc định cho các trang public
require_once __DIR__ . '/routes/WebRoutes.php';
routeWeb($uri);
