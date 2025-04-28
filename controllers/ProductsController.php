<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';

class ProductController {
    private $productModel;
    private $categoryModel;

    // Constructor: Khởi tạo đối tượng Product và Category model
    public function __construct() {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }

    // Hiển thị danh sách sản phẩm
    public function index() {
        $products = $this->productModel->all();  // Sử dụng phương thức instance
        include __DIR__ . '/../views/Products/ProductsPage.php';
    }

    // Xem chi tiết sản phẩm
    public function show($id) {
        $product = $this->productModel->find($id);
        $categories = $this->productModel->getCategories($id);
        include __DIR__ . '/../views/products/show.php';
    }

    // Form tạo mới sản phẩm
    public function createForm() {
        $categories = $this->categoryModel->all();
        include __DIR__ . '/../views/products/create.php';
    }

    // Lưu sản phẩm mới
    public function store() {
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $price = $_POST['price'] ?? 0;
        $stock = $_POST['stock'] ?? 0;
        $categoryId = $_POST['category_id'] ?? null;
        $extraCategories = $_POST['extra_categories'] ?? [];

        // Lưu sản phẩm
        $productId = $this->productModel->create($name, $description, $price, $stock, $categoryId);

        // Lưu các danh mục bổ sung
        if (!empty($extraCategories)) {
            $this->productModel->assignCategories($productId, $extraCategories);
        }

        header('Location: /products');
    }

    // Form sửa sản phẩm
    public function editForm($id) {
        $product = $this->productModel->find($id);
        $categories = $this->categoryModel->all();
        $selectedCategories = array_column($this->productModel->getCategories($id), 'id');
        include __DIR__ . '/../views/products/edit.php';
    }

    // Cập nhật thông tin sản phẩm
    public function update($id) {
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $price = $_POST['price'] ?? 0;
        $stock = $_POST['stock'] ?? 0;
        $categoryId = $_POST['category_id'] ?? null;
        $extraCategories = $_POST['extra_categories'] ?? [];

        // Cập nhật sản phẩm
        $this->productModel->update($id, $name, $description, $price, $stock, $categoryId);

        // Đồng bộ lại danh mục cho sản phẩm
        $this->productModel->syncCategories($id, $extraCategories);

        header('Location: /products/' . $id);
    }

    // Xóa sản phẩm
    public function delete($id) {
        $this->productModel->delete($id);
        header('Location: /products');
    }
}
