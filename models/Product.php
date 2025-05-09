<?php
require_once __DIR__ . '/../config/connection.php';

class Product {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }
    public function getAllProducts($limit, $offset)
    {
        $sql = "SELECT * FROM products LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function countProducts()
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM products");
        return $stmt->fetchColumn();
    }
    public function getFilteredProducts($search, $status, $sort, $limit, $offset)
    {
        try {
            $sql = "SELECT * FROM products WHERE 1";
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
    public function getFilteredProductsCount($search, $status, $sort)
    {
        try {
            $sql = "SELECT count(*) FROM products where 1";
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

            return $stmt->fetchColumn();
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
