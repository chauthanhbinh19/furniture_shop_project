<?php
require_once __DIR__ . '/../models/Promotion.php';

class PromotionController {

    // Hiển thị tất cả khuyến mãi đang hoạt động
    public function index() {
        $promotionModel = new Promotion();
        $promotions = $promotionModel->allActive();
        require_once __DIR__ . '/../views/promotions/index.php'; // Chuyển đến view để hiển thị các khuyến mãi
    }

    // Hiển thị chi tiết khuyến mãi
    public function show($id) {
        $promotionModel = new Promotion();
        $promotion = $promotionModel->find($id);
        require_once __DIR__ . '/../views/promotions/show.php'; // Chuyển đến view để hiển thị chi tiết khuyến mãi
    }

    // Tạo mới khuyến mãi
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $startDate = $_POST['start_date'];
            $endDate = $_POST['end_date'];

            $promotionModel = new Promotion();
            $promotionModel->create($title, $description, $startDate, $endDate);

            header('Location: /promotions'); // Chuyển hướng về trang danh sách khuyến mãi
        } else {
            require_once __DIR__ . '/../views/promotions/create.php'; // Chuyển đến form tạo khuyến mãi mới
        }
    }

    // Cập nhật khuyến mãi
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $startDate = $_POST['start_date'];
            $endDate = $_POST['end_date'];

            $promotionModel = new Promotion();
            $promotionModel->update($id, $title, $description, $startDate, $endDate);

            header("Location: /promotions/$id"); // Chuyển hướng về trang chi tiết khuyến mãi
        } else {
            $promotionModel = new Promotion();
            $promotion = $promotionModel->find($id);
            require_once __DIR__ . '/../views/promotions/update.php'; // Chuyển đến form cập nhật khuyến mãi
        }
    }

    // Xóa khuyến mãi
    public function destroy($id) {
        $promotionModel = new Promotion();
        $promotionModel->delete($id);

        header('Location: /promotions'); // Chuyển hướng về trang danh sách khuyến mãi
    }
}
