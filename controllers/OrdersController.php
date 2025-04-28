<?php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/OrderItem.php';

class OrderController {

    // Hiển thị tất cả đơn hàng
    public function index() {
        $orderModel = new Order();
        $orders = $orderModel->all();
        require_once __DIR__ . '/../views/Orders/OrdersPage.php'; // Chuyển đến view để hiển thị tất cả đơn hàng
    }

    // Hiển thị chi tiết đơn hàng
    public function show($id) {
        $orderModel = new Order();
        $order = $orderModel->find($id);
        
        $orderItemModel = new OrderItem();
        $orderItems = $orderItemModel->allByOrderId($id);
        
        require_once __DIR__ . '/../views/orders/show.php'; // Chuyển đến view để hiển thị chi tiết đơn hàng
    }

    // Tạo mới đơn hàng
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_POST['user_id'];
            $totalAmount = $_POST['total_amount'];
            $status = $_POST['status'] ?? 'pending';

            $orderModel = new Order();
            $orderId = $orderModel->create($userId, $totalAmount, $status);

            // Tạo các mục cho đơn hàng (order items)
            $orderItemModel = new OrderItem();
            foreach ($_POST['order_items'] as $item) {
                $orderItemModel->create($orderId, $item['product_id'], $item['quantity'], $item['price']);
            }

            header('Location: /orders'); // Chuyển hướng về trang danh sách đơn hàng
        } else {
            require_once __DIR__ . '/../views/orders/create.php'; // Chuyển đến form tạo mới đơn hàng
        }
    }

    // Cập nhật trạng thái đơn hàng
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $status = $_POST['status'];

            $orderModel = new Order();
            $orderModel->update($id, $status);

            header("Location: /orders/$id"); // Chuyển hướng về trang chi tiết đơn hàng
        } else {
            $orderModel = new Order();
            $order = $orderModel->find($id);

            require_once __DIR__ . '/../views/orders/update.php'; // Chuyển đến form cập nhật trạng thái đơn hàng
        }
    }

    // Xóa đơn hàng
    public function destroy($id) {
        $orderModel = new Order();
        $orderModel->delete($id);

        header('Location: /orders'); // Chuyển hướng về trang danh sách đơn hàng
    }
}
