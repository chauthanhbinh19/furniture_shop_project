<?php
// UserAddress.php
class UserAddress {
    private $db;
    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    public function findByUser($userId) {
        $stmt = $this->db->prepare("SELECT * FROM user_addresses WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}