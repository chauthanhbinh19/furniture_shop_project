<?php
require_once __DIR__ . '/../config/connection.php';

class Product {
    private $db;

    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    public function all() {
        $stmt = $this->db->query("SELECT * FROM products ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $description, $price, $stock, $categoryId) {
        $stmt = $this->db->prepare("
            INSERT INTO products (name, description, price, stock, category_id)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$name, $description, $price, $stock, $categoryId]);
        return $this->db->lastInsertId();
    }

    public function update($id, $name, $description, $price, $stock, $categoryId) {
        $stmt = $this->db->prepare("
            UPDATE products SET name = ?, description = ?, price = ?, stock = ?, category_id = ?
            WHERE id = ?
        ");
        $stmt->execute([$name, $description, $price, $stock, $categoryId, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function assignCategories($productId, $categoryIds) {
        $stmt = $this->db->prepare("INSERT INTO product_categories (product_id, category_id) VALUES (?, ?)");
        foreach ($categoryIds as $catId) {
            $stmt->execute([$productId, $catId]);
        }
    }

    public function syncCategories($productId, $categoryIds) {
        $this->db->prepare("DELETE FROM product_categories WHERE product_id = ?")->execute([$productId]);
        $this->assignCategories($productId, $categoryIds);
    }
    // Lấy danh mục của một sản phẩm
    public function getCategories($productId) {
        $stmt = $this->db->prepare("
            SELECT c.* 
            FROM categories c
            JOIN product_categories pc ON c.id = pc.category_id
            WHERE pc.product_id = ?
        ");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
