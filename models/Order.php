<?php
require_once __DIR__ . '/../config/connection.php';

class Order {
    private $db;

    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    // Lấy tất cả các đơn hàng
    public function all() {
        return $this->db->query("SELECT * FROM orders ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết đơn hàng theo ID
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo mới đơn hàng
    public function create($userId, $totalAmount, $status = 'pending') {
        $stmt = $this->db->prepare("
            INSERT INTO orders (user_id, total_amount, status)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$userId, $totalAmount, $status]);
        return $this->db->lastInsertId(); // Trả về ID của đơn hàng mới
    }

    // Cập nhật thông tin đơn hàng
    public function update($id, $status) {
        $stmt = $this->db->prepare("
            UPDATE orders SET status = ?
            WHERE id = ?
        ");
        $stmt->execute([$status, $id]);
    }

    // Xóa đơn hàng
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM orders WHERE id = ?");
        $stmt->execute([$id]);
    }
}
