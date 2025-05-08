<?php
require_once __DIR__ . '/../models/SubCategory.php';

class SubCategoryController
{
    public function __construct() {}
    public function getAllSubCategories($limit, $offset)
    {
        $subCategoryModel = new SubCategory();
        $categoryModel = new Category();
        $subCategories = $subCategoryModel->getAllSubCategories($limit, $offset);
        $total = $subCategoryModel->countSubCategories(); // Thêm hàm đếm tổng số customer
        $categories = $categoryModel->all();
        return [
            'subCategories' => $subCategories,
            'categories' => $categories,
            'totalSubCategories' => $total,
            'totalPages' => ceil($total / $limit),
        ];
    }
    public function getSearchSubCategories($search, $status, $sort, $limit, $offset)
    {
        $subCategoryModel = new SubCategory();
        $categoryModel = new Category();
        $subCategories = $subCategoryModel->getFilteredSubCategories($search, $status, $sort, $limit, $offset);
        $total = $subCategoryModel->getFilteredSubCategoriesCount($search, $status, $sort); // Thêm hàm đếm tổng số customer
        $categories = $categoryModel->all();
        return [
            'subCategories' => $subCategories,
            'categories' => $categories,
            'totalSubCategories' => $total,
            'totalPages' => ceil($total / $limit),
        ];
    }
    public function insertSubCategories()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $status = 'active';
            $category = $_POST['category'];

            // Lưu thông tin đăng ký mới vào cơ sở dữ liệu
            $subCategoryModel = new SubCategory();
            $userId = $subCategoryModel->insertSubCategory($name, $description, $status, $category);
            session_start();
            if ($userId >= 1) {
                $_SESSION['toast'] = ['type' => 'success', 'text' => 'Category added successfully.'];
            } else if ($userId === 0) {
                $_SESSION['toast'] = ['type' => 'danger', 'text' => 'Failed to update category.'];
            } else if ($userId === -1) {
                $_SESSION['toast'] = ['type' => 'danger', 'text' => 'Username or email already exists.'];
            } else if ($userId === -2) {
                $_SESSION['toast'] = ['type' => 'danger', 'text' => 'User does not exist.'];
            }
            header('Location: /admin/sub-categories');
            exit;
        }
    }
    public function updateSubCategories()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $status = $_POST['status'];
            $category = $_POST['category'];

            // Lưu thông tin đăng ký mới vào cơ sở dữ liệu
            $subCategoryModel = new SubCategory();
            $userId = $subCategoryModel->updateSubCategory($id, $name, $description, $status, $category);
            session_start();
            if ($userId >= 1) {
                $_SESSION['toast'] = ['type' => 'success', 'text' => 'Category updated successfully.'];
            } else if ($userId === 0) {
                $_SESSION['toast'] = ['type' => 'danger', 'text' => 'Failed to update category.'];
            } else if ($userId === -1) {
                $_SESSION['toast'] = ['type' => 'danger', 'text' => 'Username or email already exists.'];
            } else if ($userId === -2) {
                $_SESSION['toast'] = ['type' => 'danger', 'text' => 'User does not exist.'];
            }
            header('Location: /admin/sub-categories');
            exit;
        }
    }
}
