<?php
// ProductImage.php
require_once __DIR__ . '/../config/connection.php';

class ProductImage {
    private $db;
    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    public function findByProduct($productId) {
        $stmt = $this->db->prepare("SELECT * FROM product_images WHERE product_id = ? ORDER BY sort_order ASC");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($productId, $imageUrl, $isThumbnail = false, $sortOrder = 0) {
        $stmt = $this->db->prepare("INSERT INTO product_images (product_id, image_url, is_thumbnail, sort_order) VALUES (?, ?, ?, ?)");
        $stmt->execute([$productId, $imageUrl, $isThumbnail, $sortOrder]);
    }
}