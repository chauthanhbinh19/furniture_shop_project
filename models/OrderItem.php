<?php
require_once __DIR__ . '/../config/connection.php';

class OrderItem {
    private $db;

    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    // Lấy tất cả các mục trong đơn hàng theo ID đơn hàng
    public function allByOrderId($orderId) {
        $stmt = $this->db->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy thông tin chi tiết mục trong đơn hàng theo ID
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM order_items WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo mới một mục trong đơn hàng
    public function create($orderId, $productId, $quantity, $price) {
        $stmt = $this->db->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, price)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$orderId, $productId, $quantity, $price]);
        return $this->db->lastInsertId(); // Trả về ID của mục trong đơn hàng mới
    }

    // Cập nhật số lượng hoặc giá của mục trong đơn hàng
    public function update($id, $quantity, $price) {
        $stmt = $this->db->prepare("
            UPDATE order_items SET quantity = ?, price = ?
            WHERE id = ?
        ");
        $stmt->execute([$quantity, $price, $id]);
    }

    // Xóa mục trong đơn hàng
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM order_items WHERE id = ?");
        $stmt->execute([$id]);
    }
}
