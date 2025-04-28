<?php

class Database {
    private static $conn;
    public static function getConnection() {
        if (self::$conn === null) {
            try {
                // Kết nối cơ sở dữ liệu
                self::$conn = new PDO("mysql:host=localhost;dbname=furnitureDB;charset=utf8", 'root', 'binh123456'); // Thay đổi thông tin cấu hình nếu cần
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
?>
