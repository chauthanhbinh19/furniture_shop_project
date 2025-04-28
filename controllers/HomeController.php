<?php

class HomeController {
    public function index() {
        // Nếu cần DB: require connection ở đây
        // require_once __DIR__ . '/../config/connection.php';
        $title = "Welcome to Furniture Shop";
        extract(['title' => $title]);
        require_once __DIR__ . '/../views/HomePage.php';
    }
}
