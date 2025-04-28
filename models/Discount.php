<?php
// Discount.php
class Discount {
    private $db;
    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    public function findByPromotion($promotionId) {
        $stmt = $this->db->prepare("SELECT * FROM discounts WHERE promotion_id = ?");
        $stmt->execute([$promotionId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}