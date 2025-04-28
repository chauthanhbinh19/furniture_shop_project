<?php
// Review.php
class Review {
    private $db;
    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    public function findByProduct($productId) {
        $stmt = $this->db->prepare("SELECT * FROM reviews WHERE product_id = ? ORDER BY created_at DESC");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($userId, $productId, $rating, $comment) {
        $stmt = $this->db->prepare("INSERT INTO reviews (user_id, product_id, rating, comment) VALUES (?, ?, ?, ?)");
        $stmt->execute([$userId, $productId, $rating, $comment]);
    }
}
