<?php
require_once __DIR__ . '/../models/Tag.php';

class TagController {
    private $tagModel;

    public function __construct() {
        $this->tagModel = new Category();
    }

    // Hiển thị tất cả danh mục
    public function index() {
        $Tags = $this->tagModel->all();
        // Giả sử bạn có một view để hiển thị danh sách danh mục
        include __DIR__ . '/../views/Tags/TagsPage.php';
    }

    public function getAllTags($limit, $offset)
    {
        $tagModel = new Tag();
        $Tags = $tagModel->getAllTags($limit, $offset);
        $total = $tagModel->countTags(); // Thêm hàm đếm tổng số customer
        return [
            'tags' => $Tags,
            'totalTags' => $total,
            'totalPages' => ceil($total / $limit),
        ];
    }
    public function getSearchTags($search, $status, $sort, $limit, $offset)
    {
        $tagModel = new Tag();
        $tags = $tagModel->getFilteredTags($search, $status, $sort,$limit, $offset);
        $total = $tagModel->getFilteredTagsCount($search, $status, $sort); // Thêm hàm đếm tổng số customer
        return [
            'tags' => $tags,
            'totalTags' => $total,
            'totalPages' => ceil($total / $limit),
        ];
    }
    public function insertTags()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $status = 'active';

            // Lưu thông tin đăng ký mới vào cơ sở dữ liệu
            $tagModel = new Tag();
            $userId = $tagModel->insertTag($name, $description, $status);
            session_start();
            if ($userId >=1) {
                $_SESSION['toast'] = ['type' => 'success', 'text' => 'Tag added successfully.'];
            } else if($userId === 0){
                $_SESSION['toast'] = ['type' => 'danger', 'text' => 'Failed to update tag.'];
            } else if($userId === -1){
                $_SESSION['toast'] = ['type' => 'danger', 'text' => 'Username or email already exists.'];
            }else if($userId === -2){
                $_SESSION['toast'] = ['type' => 'danger', 'text' => 'User does not exist.'];
            }
            header('Location: /admin/tags');
            exit;
        }
    }
    public function updateTags()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $status = $_POST['status'];

            // Lưu thông tin đăng ký mới vào cơ sở dữ liệu
            $tagModel = new Tag();
            $userId = $tagModel->updateTag($id, $name, $description, $status);
            session_start();
            if ($userId >=1) {
                $_SESSION['toast'] = ['type' => 'success', 'text' => 'Tag updated successfully.'];
            } else if($userId === 0){
                $_SESSION['toast'] = ['type' => 'danger', 'text' => 'Failed to update tag.'];
            } else if($userId === -1){
                $_SESSION['toast'] = ['type' => 'danger', 'text' => 'Username or email already exists.'];
            }else if($userId === -2){
                $_SESSION['toast'] = ['type' => 'danger', 'text' => 'User does not exist.'];
            }
            header('Location: /admin/tags');
            exit;
        }
    }
}
