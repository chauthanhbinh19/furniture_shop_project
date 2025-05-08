<?php
require_once __DIR__ . '/../config/connection.php';

class SubCategory
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all()
    {
        return $this->db->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllSubCategories($limit, $offset)
    {
        $sql = "SELECT sc.*, c.name as 'category_name' FROM sub_categories sc, categories c 
        where sc.category_id = c.id LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function countSubCategories()
    {
        try {
            $stmt = $this->db->query("SELECT count(*) FROM sub_categories sc, categories c where sc.category_id = c.id");
            $count = $stmt->fetchColumn();

            return $count;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getFilteredSubCategories($search, $status, $sort, $limit, $offset)
    {
        try {
            $sql = "SELECT sc.*, c.name as 'category_name' FROM sub_categories sc, categories c 
            where sc.category_id = c.id";
            // Tìm kiếm
            if (!empty($search)) {
                $sql .= " AND (sc.id = :exactId OR 
                           sc.name LIKE :search OR 
                           sc.description LIKE :search)";
            }

            // Lọc theo trạng thái
            if (!empty($status) && $status !== 'all') {
                $sql .= " AND sc.status = :status";
            }

            // Sắp xếp
            if ($sort === 'oldest') {
                $sql .= " ORDER BY sc.created_at ASC";
            } else {
                $sql .= " ORDER BY sc.created_at DESC"; // mặc định newest
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
    public function getFilteredSubCategoriesCount($search, $status, $sort)
    {
        try {
            $sql = "SELECT count(*) FROM sub_categories sc, categories c where sc.category_id = c.id";
            // Tìm kiếm
            if (!empty($search)) {
                $sql .= " AND (sc.id = :exactId OR 
                           sc.name LIKE :search OR 
                           sc.description LIKE :search)";
            }

            // Lọc theo trạng thái
            if (!empty($status) && $status !== 'all') {
                $sql .= " AND sc.status = :status";
            }

            // Sắp xếp
            if ($sort === 'oldest') {
                $sql .= " ORDER BY sc.created_at ASC";
            } else {
                $sql .= " ORDER BY sc.created_at DESC"; // mặc định newest
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
    public function insertSubCategory($name, $description, $status, $category)
    {
        try {
            // Câu lệnh insert
            $sql = "INSERT INTO sub_categories (category_id, name, description, status) 
                VALUES (:category_id, :name, :description, :status)";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':category_id', $category);
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
    public function updateSubCategory($id, $name, $description, $status, $category)
    {
        try {
            // Câu lệnh UPDATE
            $sql = "UPDATE sub_categories 
                SET name = :name, description = :description, status = :status, category_id = :category_id
                WHERE id = :id";

            $stmt = $this->db->prepare($sql);

            // Gắn giá trị vào các tham số trong truy vấn
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':category_id', $category);

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
