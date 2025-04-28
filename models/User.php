<?php
require_once __DIR__ . '/../config/connection.php';

class User {
    private $db;
    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function all() {
        return $this->db->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Phương thức để tạo người dùng
    public function create($username, $password, $email, $fullName, $phoneNumber, $dateOfBirth, $gender, $role) {
        $sql = "INSERT INTO users (username, password, email, full_name, phone_number, date_of_birth, gender, role) 
                VALUES (:username, :password, :email, :full_name, :phone_number, :date_of_birth, :gender, :role)";

        $stmt = $this->db->prepare($sql);  // Sử dụng kết nối để chuẩn bị truy vấn

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':full_name', $fullName);
        $stmt->bindParam(':phone_number', $phoneNumber);
        $stmt->bindParam(':date_of_birth', $dateOfBirth);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':role', $role);

        // Thực thi truy vấn
        if ($stmt->execute()) {
            return $this->db->lastInsertId();  // Trả về ID của người dùng vừa tạo
        } else {
            return false;  // Lỗi nếu không thể chèn vào cơ sở dữ liệu
        }
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }
}
