<?php
require_once __DIR__ . '/../config/connection.php';

class User
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all()
    {
        return $this->db->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllCustomers($limit, $offset)
    {
        $sql = "SELECT * FROM users WHERE role = 'customer' LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function countCustomers()
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM users WHERE role = 'customer'");
        return $stmt->fetchColumn();
    }
    public function getFilteredCustomers($search, $status, $sort, $limit, $offset)
    {
        try {
            $sql = "SELECT * FROM users WHERE role = 'customer'";
            // Tìm kiếm
            if (!empty($search)) {
                $sql .= " AND (id = :exactId OR 
                           full_name LIKE :search OR 
                           username LIKE :search OR 
                           email LIKE :search OR 
                           phone_number LIKE :search)";
            }

            // Lọc theo trạng thái
            if (!empty($status) && $status !== 'all') {
                $sql .= " AND status = :status";
            }

            // Sắp xếp
            if ($sort === 'oldest') {
                $sql .= " ORDER BY created_at ASC";
            } else {
                $sql .= " ORDER BY created_at DESC"; // mặc định newest
            }

            $sql .= " LIMIT :limit OFFSET :offset";

            $stmt = $this->db->prepare($sql);

            // Gán giá trị cho tìm kiếm
            if (!empty($search)) {
                if (ctype_digit($search)) {
                    $stmt->bindValue(':exactId', (int)$search, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue(':exactId', 0, PDO::PARAM_INT); // Không khớp ID nào
                }

                $likeSearch = '%' . $search . '%';
                $stmt->bindValue(':search', $likeSearch, PDO::PARAM_STR);
            }

            // Gán giá trị cho status
            if (!empty($status) && $status !== 'all') {
                $stmt->bindValue(':status', $status, PDO::PARAM_STR);
            }

            // Limit & offset
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function getFilteredCustomersCount($search, $status, $sort)
    {
        try {
            $sql = "SELECT count(*) FROM users WHERE role = 'customer'";
            // Tìm kiếm
            if (!empty($search)) {
                $sql .= " AND (id = :exactId OR 
                           full_name LIKE :search OR 
                           username LIKE :search OR 
                           email LIKE :search OR 
                           phone_number LIKE :search)";
            }

            // Lọc theo trạng thái
            if (!empty($status) && $status !== 'all') {
                $sql .= " AND status = :status";
            }

            // Sắp xếp
            if ($sort === 'oldest') {
                $sql .= " ORDER BY created_at ASC";
            } else {
                $sql .= " ORDER BY created_at DESC"; // mặc định newest
            }

            $stmt = $this->db->prepare($sql);

            // Gán giá trị cho tìm kiếm
            if (!empty($search)) {
                if (ctype_digit($search)) {
                    $stmt->bindValue(':exactId', (int)$search, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue(':exactId', 0, PDO::PARAM_INT); // Không khớp ID nào
                }

                $likeSearch = '%' . $search . '%';
                $stmt->bindValue(':search', $likeSearch, PDO::PARAM_STR);
            }

            // Gán giá trị cho status
            if (!empty($status) && $status !== 'all') {
                $stmt->bindValue(':status', $status, PDO::PARAM_STR);
            }
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function getAllEmployees($limit, $offset)
    {
        $sql = "SELECT * FROM users WHERE role = 'employee' LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function countEmployees()
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM users WHERE role = 'employee'");
        return $stmt->fetchColumn();
    }
    public function getFilteredEmployees($search, $status, $sort, $limit, $offset)
    {
        try {
            $sql = "SELECT * FROM users WHERE role = 'employee'";
            // Tìm kiếm
            if (!empty($search)) {
                $sql .= " AND (id = :exactId OR 
                           full_name LIKE :search OR 
                           username LIKE :search OR 
                           email LIKE :search OR 
                           phone_number LIKE :search)";
            }

            // Lọc theo trạng thái
            if (!empty($status) && $status !== 'all') {
                $sql .= " AND status = :status";
            }

            // Sắp xếp
            if ($sort === 'oldest') {
                $sql .= " ORDER BY created_at ASC";
            } else {
                $sql .= " ORDER BY created_at DESC"; // mặc định newest
            }

            $sql .= " LIMIT :limit OFFSET :offset";

            $stmt = $this->db->prepare($sql);

            // Gán giá trị cho tìm kiếm
            if (!empty($search)) {
                if (ctype_digit($search)) {
                    $stmt->bindValue(':exactId', (int)$search, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue(':exactId', 0, PDO::PARAM_INT); // Không khớp ID nào
                }

                $likeSearch = '%' . $search . '%';
                $stmt->bindValue(':search', $likeSearch, PDO::PARAM_STR);
            }

            // Gán giá trị cho status
            if (!empty($status) && $status !== 'all') {
                $stmt->bindValue(':status', $status, PDO::PARAM_STR);
            }

            // Limit & offset
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function getFilteredEmployeesCount($search, $status, $sort)
    {
        try {
            $sql = "SELECT count(*) FROM users WHERE role = 'employee'";
            // Tìm kiếm
            if (!empty($search)) {
                $sql .= " AND (id = :exactId OR 
                           full_name LIKE :search OR 
                           username LIKE :search OR 
                           email LIKE :search OR 
                           phone_number LIKE :search)";
            }

            // Lọc theo trạng thái
            if (!empty($status) && $status !== 'all') {
                $sql .= " AND status = :status";
            }

            // Sắp xếp
            if ($sort === 'oldest') {
                $sql .= " ORDER BY created_at ASC";
            } else {
                $sql .= " ORDER BY created_at DESC"; // mặc định newest
            }

            $stmt = $this->db->prepare($sql);

            // Gán giá trị cho tìm kiếm
            if (!empty($search)) {
                if (ctype_digit($search)) {
                    $stmt->bindValue(':exactId', (int)$search, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue(':exactId', 0, PDO::PARAM_INT); // Không khớp ID nào
                }

                $likeSearch = '%' . $search . '%';
                $stmt->bindValue(':search', $likeSearch, PDO::PARAM_STR);
            }

            // Gán giá trị cho status
            if (!empty($status) && $status !== 'all') {
                $stmt->bindValue(':status', $status, PDO::PARAM_STR);
            }
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Phương thức để tạo người dùng
    public function insertUser($username, $password, $email, $fullName, $phoneNumber, $dateOfBirth, $gender, $role, $image, $status)
    {
        try {
            // Kiểm tra bắt buộc
            if (empty($username) || empty($password) || empty($email) || empty($fullName)) {
                throw new Exception("Username, password, email và full name là bắt buộc.");
            }

            // Kiểm tra username/email đã tồn tại chưa
            $checkSql = "SELECT COUNT(*) FROM users WHERE username = :username OR email = :email";
            $checkStmt = $this->db->prepare($checkSql);
            $checkStmt->bindParam(':username', $username);
            $checkStmt->bindParam(':email', $email);
            $checkStmt->execute();

            if ($checkStmt->fetchColumn() > 0) {
                return -1;
            }

            // Mã hóa mật khẩu
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Câu lệnh insert
            $sql = "INSERT INTO users (username, password, email, full_name, phone_number, date_of_birth, gender, role, image, status) 
                VALUES (:username, :password, :email, :full_name, :phone_number, :date_of_birth, :gender, :role, :image, :status)";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':full_name', $fullName);
            $stmt->bindParam(':phone_number', $phoneNumber);
            $stmt->bindParam(':date_of_birth', $dateOfBirth);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':status', $status);

            if ($stmt->execute()) {
                return $this->db->lastInsertId();
            } else {
                return 0;
            }
        } catch (Exception $e) {
            // Có thể log lỗi tại đây nếu cần
            return 0;
        }
    }

    public function updateUser($id, $username, $password, $email, $fullName, $phoneNumber, $dateOfBirth, $gender, $role, $image, $status)
    {
        try {
            // Kiểm tra các tham số bắt buộc
            if (empty($id) || empty($username) || empty($password) || empty($email) || empty($fullName)) {
                throw new Exception("Id, Username, Password, Email và Full Name là bắt buộc.");
            }

            // Kiểm tra xem user có tồn tại không (Optional, nếu muốn kiểm tra user trước khi cập nhật)
            $checkSql = "SELECT COUNT(*) FROM users WHERE id = :id";
            $checkStmt = $this->db->prepare($checkSql);
            $checkStmt->bindParam(':id', $id);
            $checkStmt->execute();

            if ($checkStmt->fetchColumn() == 0) {
                return -2;
            }

            // Câu lệnh UPDATE
            $sql = "UPDATE users 
                SET username = :username, password = :password, email = :email, full_name = :full_name, 
                    phone_number = :phone_number, date_of_birth = :date_of_birth, gender = :gender, role = :role, image = :image, status = :status
                WHERE id = :id";

            $stmt = $this->db->prepare($sql);

            // Gắn giá trị vào các tham số trong truy vấn
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':full_name', $fullName);
            $stmt->bindParam(':phone_number', $phoneNumber);
            $stmt->bindParam(':date_of_birth', $dateOfBirth);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':status', $status);

            // Thực thi truy vấn
            if ($stmt->execute()) {
                return 1;  // Trả về true nếu cập nhật thành công
            } else {
                return 0;
            }
        } catch (Exception $e) {
            return 0;  // Trả về 0 nếu có lỗi
        }
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }
}
