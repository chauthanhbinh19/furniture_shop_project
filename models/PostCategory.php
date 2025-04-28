<?php
// PostCategory.php
class PostCategory {
    private $db;
    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    public function all() {
        $stmt = $this->db->query("SELECT * FROM post_categories ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}