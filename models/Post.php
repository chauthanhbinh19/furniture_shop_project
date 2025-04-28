<?php
// Post.php
class Post {
    private $db;
    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    public function allPublished() {
        $stmt = $this->db->query("SELECT * FROM posts WHERE published = TRUE ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}