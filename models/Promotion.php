<?php

require_once __DIR__ . '/../config/connection.php';
class Promotion {
    private $db;

    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    // Lấy tất cả khuyến mãi đang hoạt động
    public function allActive() {
        $stmt = $this->db->query("SELECT * FROM promotions WHERE active = TRUE");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết khuyến mãi theo ID
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM promotions WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo khuyến mãi mới
    public function create($title, $description, $startDate, $endDate) {
        $stmt = $this->db->prepare("INSERT INTO promotions (title, description, start_date, end_date) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $description, $startDate, $endDate]);
    }

    // Cập nhật khuyến mãi
    public function update($id, $title, $description, $startDate, $endDate) {
        $stmt = $this->db->prepare("UPDATE promotions SET title = ?, description = ?, start_date = ?, end_date = ? WHERE id = ?");
        $stmt->execute([$title, $description, $startDate, $endDate, $id]);
    }

    // Xóa khuyến mãi
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM promotions WHERE id = ?");
        $stmt->execute([$id]);
    }
}
