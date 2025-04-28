<?php

function routeWeb($uri)
{
    switch ($uri) {
        case '':
            require_once __DIR__ . '/../controllers/HomeController.php';
            (new HomeController())->index();
            break;
        case '/':
            require_once __DIR__ . '/../controllers/HomeController.php';
            (new HomeController())->index();
            break;
        case '/index.php':
            require_once __DIR__ . '/../controllers/HomeController.php';
            (new HomeController())->index();
            break;
        case '/about':
            require_once __DIR__ . '/../views/about.php';
            break;
        case '/signin':
            require_once __DIR__ . '/../views/Users/SignInPage.php';
            break;
        case '/signup':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                require_once __DIR__ . '/../controllers/UsersController.php';
                (new UserController())->signup(); // Gọi phương thức signup trong UserController
            } else {
                require_once __DIR__ . '/../views/Users/SignUpPage.php'; // Trả về trang signup
            }
            break;
        default:
            http_response_code(404);
            echo "404 - Page not found";
            break;
    }
}
