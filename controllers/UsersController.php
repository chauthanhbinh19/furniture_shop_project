<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    // Hiển thị danh sách tất cả người dùng
    public function index() {
        $users = $this->userModel->all();
        // Giả sử bạn có một view để hiển thị danh sách người dùng
        include __DIR__ . '/../views/Users/UsersPage.php';
    }

    // Phương thức xử lý đăng nhập
    public function signin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $identifier = $_POST['identifier'];
            $password = $_POST['password'];

            // Kiểm tra người dùng với identifier (username/email)
            $userModel = new User();
            $user = $userModel->find($identifier); // Tìm người dùng theo username hoặc email

            if ($user && password_verify($password, $user['password'])) {
                // Đăng nhập thành công, lưu thông tin vào session hoặc cookie
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: dashboard.php'); // Điều hướng tới trang Dashboard
                exit;
            } else {
                // Đăng nhập thất bại
                $error = "Invalid credentials.";
                // Trả về giao diện đăng nhập với thông báo lỗi
                include __DIR__.'/../views/Users/SignInPage.php';
            }
        }
    }

    // Phương thức xử lý đăng ký
    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullName = $_POST['full_name'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $phoneNumber = $_POST['phone_number'];
            $dateOfBirth = $_POST['date_of_birth'];
            $gender = $_POST['gender'];
            $role = 'customer';

            // Lưu thông tin đăng ký mới vào cơ sở dữ liệu
            $userModel = new User();
            $userId = $userModel->create($username, $password, $email, $fullName, $phoneNumber, $dateOfBirth, $gender, $role);

            // Đăng nhập ngay sau khi đăng ký thành công
            session_start();
            $_SESSION['user_id'] = $userId;
            $_SESSION['username'] = $username;
            header('Location: /admin'); // Điều hướng tới trang Dashboard
            exit;
        }
    }

    // Hiển thị thông tin chi tiết người dùng
    public function show($id) {
        $user = $this->userModel->find($id);
        if ($user) {
            // Giả sử bạn có một view để hiển thị chi tiết người dùng
            include __DIR__ . '/../views/users/show.php';
        } else {
            // Nếu không tìm thấy người dùng
            echo "User not found!";
        }
    }

    // Tạo mới người dùng
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Nhận dữ liệu từ form và tạo người dùng
            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Mã hóa mật khẩu
            $email = $_POST['email'];
            $fullName = $_POST['full_name'];
            
            // Tạo người dùng mới
            // $this->userModel->create($username, $password, $email, $fullName);
            // Chuyển hướng về trang danh sách người dùng sau khi tạo thành công
            header('Location: /users');
        } else {
            // Hiển thị form tạo người dùng
            include __DIR__ . '/../views/users/create.php';
        }
    }

    // Xóa người dùng
    public function delete($id) {
        $this->userModel->delete($id);
        // Sau khi xóa, chuyển hướng về danh sách người dùng
        header('Location: /users');
    }
}
