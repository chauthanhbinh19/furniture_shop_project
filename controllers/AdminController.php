<?php

require_once 'UsersController.php';
require_once 'ProductsController.php';
require_once 'CategoriesController.php';
require_once 'SubCategoriesController.php';
require_once 'TagsController.php';
class AdminController
{
    public function handle($uri)
    {
        // Tách phần sau /admin
        $subPath = trim(str_replace('/admin', '', $uri), '/');

        // Nếu không có gì => dashboard
        $page = $subPath === '' ? 'dashboard' : $subPath;

        // Danh sách các trang hợp lệ
        switch ($page) {
            case 'dashboard':
                $controllerName = ucfirst($page) . 'Controller';
                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    $data = $controller->index();  // Gọi phương thức index để lấy dữ liệu
                    $this->renderAdminLayout($page, $data);
                } else {
                    $this->renderAdminLayout($page, 1);
                }
                break;
            case 'users':
                $controllerName = ucfirst($page) . 'Controller';
                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    $data = $controller->index();  // Gọi phương thức index để lấy dữ liệu
                    $this->renderAdminLayout($page, $data);
                } else {
                    $this->renderAdminLayout($page, 1);
                }
                break;
            case 'customers':
                $controller = new UserController();

                if (isset($_GET['action']) && $_GET['action'] === 'insertCustomers') {
                    $controller->insertCustomers();
                }
                if (isset($_GET['action']) && $_GET['action'] === 'updateCustomers') {
                    $controller->updateCustomers();
                }

                $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $limit = 10;
                $offset = ($currentPage - 1) * $limit;

                $search = $_GET['search'] ?? null;
                $status = $_GET['status'] ?? 'all';
                $sort = $_GET['sort'] ?? 'newest';
                if ($search || $status !== 'all' || $sort) {
                    $data = $controller->getFilteredCustomers($search, $status, $sort, $limit, $offset);
                } else {
                    $data = $controller->getAllCustomers($limit, $offset);
                }

                $data['currentPage'] = $currentPage;
                $data['searchTerm'] = $search;
                $data['status'] = $status;
                $data['sort'] = $sort;

                $page = "Users/CustomersPage";
                $this->renderAdminLayout($page, $data);
                break;
            case 'employees':
                $controller = new UserController();

                if (isset($_GET['action']) && $_GET['action'] === 'insertEmployees') {
                    $controller->insertEmployees();
                }
                if (isset($_GET['action']) && $_GET['action'] === 'updateEmployees') {
                    $controller->updateEmployees();
                }

                $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $limit = 10;
                $offset = ($currentPage - 1) * $limit;

                $search = $_GET['search'] ?? null;
                $status = $_GET['status'] ?? 'all';
                $sort = $_GET['sort'] ?? 'newest';
                if ($search || $status !== 'all' || $sort) {
                    $data = $controller->getSearchEmployees($search,  $status, $sort, $limit, $offset);
                } else {
                    $data = $controller->getAllEmployees($limit, $offset);
                }

                $data['currentPage'] = $currentPage;
                $data['searchTerm'] = $search;
                $data['status'] = $status;
                $data['sort'] = $sort;

                $page = "Users/EmployeesPage";
                $this->renderAdminLayout($page, $data);
                break;
            case 'orders':
                $controllerName = ucfirst($page) . 'Controller';
                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    $data = $controller->index();  // Gọi phương thức index để lấy dữ liệu
                    $this->renderAdminLayout($page, $data);
                } else {
                    $this->renderAdminLayout($page, 1);
                }
                break;
            case 'products':
                $controller = new ProductController();

                $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $limit = 10;
                $offset = ($currentPage - 1) * $limit;

                $search = $_GET['search'] ?? null;
                $status = $_GET['status'] ?? 'all';
                $sort = $_GET['sort'] ?? 'newest';
                if ($search || $status !== 'all' || $sort) {
                    $data = $controller->getSearchProducts($search, $status, $sort, $limit, $offset);
                } else {
                    $data = $controller->getAllProducts($limit, $offset);
                }

                $data['currentPage'] = $currentPage;
                $data['searchTerm'] = $search;
                $data['status'] = $status;
                $data['sort'] = $sort;

                $page = "Products/ProductsPage";
                $this->renderAdminLayout($page, $data);
                break;
            case 'insert-products':
                $page = "Products/InsertProducts";
                $this->renderAdminLayout($page, 1);
                break;
            case 'categories':
                $controller = new CategoryController();

                if (isset($_GET['action']) && $_GET['action'] === 'insertCategories') {
                    $controller->insertCategories();
                }
                if (isset($_GET['action']) && $_GET['action'] === 'updateCategories') {
                    $controller->updateCategories();
                }

                $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $limit = 10;
                $offset = ($currentPage - 1) * $limit;

                $search = $_GET['search'] ?? null;
                $status = $_GET['status'] ?? 'all';
                $sort = $_GET['sort'] ?? 'newest';
                if ($search || $status !== 'all' || $sort) {
                    $data = $controller->getSearchCategories($search, $status, $sort, $limit, $offset);
                } else {
                    $data = $controller->getAllCategories($limit, $offset);
                }

                $data['currentPage'] = $currentPage;
                $data['searchTerm'] = $search;
                $data['status'] = $status;
                $data['sort'] = $sort;

                $page = "Categories/CategoriesPage";
                $this->renderAdminLayout($page, $data);
                break;
            case 'sub-categories':
                $controller = new SubCategoryController();

                if (isset($_GET['action']) && $_GET['action'] === 'insertSubCategories') {
                    $controller->insertSubCategories();
                }
                if (isset($_GET['action']) && $_GET['action'] === 'updateSubCategories') {
                    $controller->updateSubCategories();
                }

                $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $limit = 10;
                $offset = ($currentPage - 1) * $limit;

                $search = $_GET['search'] ?? null;
                $status = $_GET['status'] ?? 'all';
                $sort = $_GET['sort'] ?? 'newest';
                if ($search || $status !== 'all' || $sort) {
                    $data = $controller->getSearchSubCategories($search, $status, $sort, $limit, $offset);
                } else {
                    $data = $controller->getAllSubCategories($limit, $offset);
                }

                $data['currentPage'] = $currentPage;
                $data['searchTerm'] = $search;
                $data['status'] = $status;
                $data['sort'] = $sort;
                
                $page = "Categories/SubCategoriesPage";
                $this->renderAdminLayout($page, $data);
                break;
            case 'tags':
                $controller = new TagController();

                if (isset($_GET['action']) && $_GET['action'] === 'insertTags') {
                    $controller->insertTags();
                }
                if (isset($_GET['action']) && $_GET['action'] === 'updateTags') {
                    $controller->updateTags();
                }

                $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $limit = 10;
                $offset = ($currentPage - 1) * $limit;

                $search = $_GET['search'] ?? null;
                $status = $_GET['status'] ?? 'all';
                $sort = $_GET['sort'] ?? 'newest';
                if ($search || $status !== 'all' || $sort) {
                    $data = $controller->getSearchTags($search, $status, $sort, $limit, $offset);
                } else {
                    $data = $controller->getAllTags($limit, $offset);
                }

                $data['currentPage'] = $currentPage;
                $data['searchTerm'] = $search;
                $data['status'] = $status;
                $data['sort'] = $sort;

                $page = "Tags/TagsPage";
                $this->renderAdminLayout($page, $data);
                break;
            case 'discounts':
                $controllerName = ucfirst($page) . 'Controller';
                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    $data = $controller->index();  // Gọi phương thức index để lấy dữ liệu
                    $this->renderAdminLayout($page, $data);
                } else {
                    $this->renderAdminLayout($page, 1);
                }
                break;
            case 'promotions':
                $controllerName = ucfirst($page) . 'Controller';
                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    $data = $controller->index();  // Gọi phương thức index để lấy dữ liệu
                    $this->renderAdminLayout($page, $data);
                } else {
                    $this->renderAdminLayout($page, 1);
                }
                break;
            case 'vouchers':
                $controllerName = ucfirst($page) . 'Controller';
                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    $data = $controller->index();  // Gọi phương thức index để lấy dữ liệu
                    $this->renderAdminLayout($page, $data);
                } else {
                    $this->renderAdminLayout($page, 1);
                }
                break;
            case 'settings':
                $controllerName = ucfirst($page) . 'Controller';
                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    $data = $controller->index();  // Gọi phương thức index để lấy dữ liệu
                    $this->renderAdminLayout($page, $data);
                } else {
                    $this->renderAdminLayout($page, 1);
                }
                break;

            default:
                // Page không hợp lệ, xử lý 404 hoặc chuyển hướng
                http_response_code(404);
                echo "Page not found.";
                break;
        }
    }

    private function renderAdminLayout($page, $data)
    {
        include __DIR__ . '/../views/AdminPage.php';
    }
}
