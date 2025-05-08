<?php
require_once __DIR__ . '/../config/connection.php';

class Tag {
    private $db;
    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function all() {
        return $this->db->query("SELECT * FROM tags")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllTags($limit, $offset)
    {
        $sql = "SELECT * FROM tags LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function countTags()
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM tags");
        return $stmt->fetchColumn();
    }
    public function getFilteredTags($search, $status, $sort, $limit, $offset)
    {
        try {
            $sql = "SELECT * FROM tags WHERE 1";
            // Tìm kiếm
            if (!empty($search)) {
                $sql .= " AND (id = :exactId OR 
                           name LIKE :search OR 
                           description LIKE :search";
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
    public function getFilteredTagsCount($search, $status, $sort)
    {
        try {
            $sql = "SELECT * FROM tags WHERE 1";
            // Tìm kiếm
            if (!empty($search)) {
                $sql .= " AND (id = :exactId OR 
                           name LIKE :search OR 
                           description LIKE :search";
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
    public function insertTag($name, $description, $status)
    {
        try {
            // Câu lệnh insert
            $sql = "INSERT INTO tags (name, description, status) 
                VALUES (:name, :description, :status)";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
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
    public function updateTag($id, $name, $description, $status)
    {
        try {
            // Câu lệnh UPDATE
            $sql = "UPDATE tags 
                SET name = :name, description = :description, status = :status
                WHERE id = :id";

            $stmt = $this->db->prepare($sql);

            // Gắn giá trị vào các tham số trong truy vấn
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
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
}
