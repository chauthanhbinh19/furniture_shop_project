<?php

class AdminController
{
    public function handle($uri)
    {
        // Tách phần sau /admin
        $subPath = trim(str_replace('/admin', '', $uri), '/');

        // Nếu không có gì => dashboard
        $page = $subPath === '' ? 'dashboard' : $subPath;

        // Danh sách các trang hợp lệ
        $allowedPages = [
            'dashboard',
            'users',
            'customers',
            'orders',
            'products',
            'categories',
            'discounts',
            'promotions',
            'vouchers',
            'settings'
        ];

        if (in_array($page, $allowedPages)) {
            $controllerName = ucfirst($page) . 'Controller';
            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                $data = $controller->index();  // Gọi phương thức index() để lấy dữ liệu

                // Render layout và truyền dữ liệu
                $this->renderAdminLayout($page, $data);
            } else {
                $this->renderAdminLayout($page,1);
            }
        } else {
            http_response_code(404);
            echo "<h4>404 - Page not found</h4>";
        }
    }

    private function renderAdminLayout($page, $data)
    {
        include __DIR__ . '/../views/AdminPage.php';
    }
}
