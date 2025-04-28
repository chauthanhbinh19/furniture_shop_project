<?php
// Voucher.php
class Voucher {
    private $db;
    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    public function findByCode($code) {
        $stmt = $this->db->prepare("SELECT * FROM vouchers WHERE code = ? AND active = TRUE");
        $stmt->execute([$code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function incrementUsage($voucherId) {
        $stmt = $this->db->prepare("UPDATE vouchers SET uses = uses + 1 WHERE id = ?");
        $stmt->execute([$voucherId]);
    }
}