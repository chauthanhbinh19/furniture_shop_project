<?php

function routeAdmin($uri) {
    require_once __DIR__ . '/../controllers/AdminController.php';
    (new AdminController())->handle($uri);
}
