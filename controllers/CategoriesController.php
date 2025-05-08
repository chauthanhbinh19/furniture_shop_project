<?php
require_once __DIR__ . '/../models/Category.php';

class CategoryController {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new Category();
    }

    // Hiển thị tất cả danh mục
    public function index() {
        $categories = $this->categoryModel->all();
        // Giả sử bạn có một view để hiển thị danh sách danh mục
        include __DIR__ . '/../views/Categories/CategoriesPage.php';
    }

    public function getAllCategories($limit, $offset)
    {
        $categoryModel = new Category();
        $categories = $categoryModel->getAllCategories($limit, $offset);
        $total = $categoryModel->countCategories(); // Thêm hàm đếm tổng số customer
        return [
            'categories' => $categories,
            'totalCategories' => $total,
            'totalPages' => ceil($total / $limit),
        ];
    }
    public function getSearchCategories($search, $status, $sort, $limit, $offset)
    {
        $categoryModel = new Category();
        $categories = $categoryModel->getFilteredCategories($search, $status, $sort,$limit, $offset);
        $total = $categoryModel->getFilteredCategoriesCount($search, $status, $sort); // Thêm hàm đếm tổng số customer
        return [
            'categories' => $categories,
            'totalCategories' => $total,
            'totalPages' => ceil($total / $limit),
        ];
    }
    public function insertCategories()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $status = 'active';

            // Lưu thông tin đăng ký mới vào cơ sở dữ liệu
            $categoryModel = new Category();
            $userId = $categoryModel->insertCategory($name, $description, $status);
            session_start();
            if ($userId >=1) {
                $_SESSION['toast'] = ['type' => 'success', 'text' => 'Category added successfully.'];
            } else if($userId === 0){
                $_SESSION['toast'] = ['type' => 'danger', 'text' => 'Failed to update category.'];
            } else if($userId === -1){
                $_SESSION['toast'] = ['type' => 'danger', 'text' => 'Username or email already exists.'];
            }else if($userId === -2){
                $_SESSION['toast'] = ['type' => 'danger', 'text' => 'User does not exist.'];
            }
            header('Location: /admin/categories');
            exit;
        }
    }
    public function updateCategories()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $status = $_POST['status'];

            // Lưu thông tin đăng ký mới vào cơ sở dữ liệu
            $tagModel = new Category();
            $userId = $tagModel->updateCategory($id, $name, $description, $status);
            session_start();
            if ($userId >=1) {
                $_SESSION['toast'] = ['type' => 'success', 'text' => 'Category updated successfully.'];
            } else if($userId === 0){
                $_SESSION['toast'] = ['type' => 'danger', 'text' => 'Failed to update category.'];
            } else if($userId === -1){
                $_SESSION['toast'] = ['type' => 'danger', 'text' => 'Username or email already exists.'];
            }else if($userId === -2){
                $_SESSION['toast'] = ['type' => 'danger', 'text' => 'User does not exist.'];
            }
            header('Location: /admin/categories');
            exit;
        }
    }
}
