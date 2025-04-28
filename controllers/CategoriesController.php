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

    // Hiển thị chi tiết danh mục
    public function show($id) {
        $category = $this->categoryModel->find($id);
        if ($category) {
            // Giả sử bạn có một view để hiển thị thông tin chi tiết danh mục
            include __DIR__ . '/../views/categories/show.php';
        } else {
            // Nếu không tìm thấy danh mục
            echo "Category not found!";
        }
    }

    // Tạo mới danh mục
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Nhận dữ liệu từ form và tạo danh mục
            $name = $_POST['name'];
            $description = $_POST['description'];
            $this->categoryModel->create($name, $description);
            // Chuyển hướng về trang danh sách danh mục sau khi tạo thành công
            header('Location: /categories');
        } else {
            // Hiển thị form tạo danh mục
            include __DIR__ . '/../views/categories/create.php';
        }
    }
}
