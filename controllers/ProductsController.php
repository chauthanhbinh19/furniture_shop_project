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

    public function getAllProducts($limit, $offset)
    {
        $productModel = new Product();
        $Products = $productModel->getAllProducts($limit, $offset);
        $total = $productModel->countProducts(); // Thêm hàm đếm tổng số customer
        return [
            'products' => $Products,
            'totalProducts' => $total,
            'totalPages' => ceil($total / $limit),
        ];
    }
    public function getSearchProducts($search, $status, $sort, $limit, $offset)
    {
        $productModel = new Product();
        $Products = $productModel->getFilteredProducts($search, $status, $sort,$limit, $offset);
        $total = $productModel->getFilteredProductsCount($search, $status, $sort); // Thêm hàm đếm tổng số customer
        return [
            'products' => $Products,
            'totalProducts' => $total,
            'totalPages' => ceil($total / $limit),
        ];
    }
}
