<?php
session_start();
$toast = $_SESSION['toast'] ?? null;
$toastTitle = '';

// Kiểm tra xem có toast không
if ($toast) {
    // Lấy type từ session để gán cho toastType
    $toastType = $toast['type'];

    // Gán title dựa trên type
    switch ($toastType) {
        case 'success':
            $toastTitle = 'Success!';
            break;
        case 'danger':
            $toastTitle = 'Error!';
            break;
        case 'warning':
            $toastTitle = 'Warning!';
            break;
        case 'info':
            $toastTitle = 'Information';
            break;
    }
    unset($_SESSION['toast']); // Xóa toast sau khi đã xử lý
}
?>

<?php if ($toast): ?>
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        <div id="liveToast" class="toast bg-<?php echo $toast['type']; ?> text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-white text-<?php echo $toast['type']; ?>">
                <!-- SVG icon -->
                <svg class="bi me-2" width="20" height="20" role="img" aria-label="icon">
                    <?php if ($toast['type'] === 'success'): ?>
                        <use xlink:href="#check-circle-fill" />
                    <?php elseif ($toast['type'] === 'danger'): ?>
                        <use xlink:href="#exclamation-triangle-fill" />
                    <?php elseif ($toast['type'] === 'warning'): ?>
                        <use xlink:href="#exclamation-triangle-fill" />
                    <?php else: ?>
                        <use xlink:href="#info-fill" />
                    <?php endif; ?>
                </svg>
                <strong class="me-auto"><?php echo ucfirst($toastTitle); ?></strong>
                <small>just now</small>
                <button type="button" class="btn-close btn-close-dark ms-2 mb-1" data-coreui-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body bg-white text-dark">
                <?php echo htmlspecialchars($toast['text']); ?>
            </div>
        </div>
    </div>

    <!-- SVG Symbols -->
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 11.03a.75.75 0 0 0 1.07 0l3.992-3.993a.75.75 0 1 0-1.06-1.06L7.5 9.44 6.03 7.97a.75.75 0 0 0-1.06 1.06l2 2z" />
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zM8.93 4.58a1 1 0 1 1-1.86.68 1 1 0 0 1 1.86-.68zM8 6a.5.5 0 0 1 .5.5v4.793l.854.853a.5.5 0 0 1-.708.708l-1-1A.5.5 0 0 1 7.5 11V6.5A.5.5 0 0 1 8 6z" />
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 0c-.535 0-1.06.21-1.414.586L.586 6.586a2 2 0 0 0 0 2.828l6 6a2 2 0 0 0 2.828 0l6-6a2 2 0 0 0 0-2.828l-6-6A1.996 1.996 0 0 0 8 0zM7.002 4.25a.75.75 0 1 1 1.496 0l-.35 4.2a.4.4 0 0 1-.796 0l-.35-4.2zm.998 6.75a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
        </symbol>
    </svg>

    <!-- Auto-hide after 2 seconds -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toastEl = document.getElementById('liveToast');
            const toast = new coreui.Toast(toastEl, {
                delay: 2000
            });
            toast.show();
        });
    </script>
<?php endif; ?>
<?php
// Kiểm tra và hiển thị thông báo thành công
if (isset($_SESSION['success_message'])) {
    echo "<div class='alert alert-success' role='alert'>" . $_SESSION['success_message'] . "</div>";
    unset($_SESSION['success_message']);  // Sau khi hiển thị thì xóa thông báo
}

// Kiểm tra và hiển thị thông báo lỗi
if (isset($_SESSION['error_message'])) {
    echo "<div class='alert alert-danger' role='alert'>" . $_SESSION['error_message'] . "</div>";
    unset($_SESSION['error_message']);  // Sau khi hiển thị thì xóa thông báo
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../public/css/coreui.min.css">
    <link rel="stylesheet" href="../includes/sidebar.css">
    <link rel="stylesheet" href="../src/table.css">
    <link rel="stylesheet" href="../src/input.css">
    <!-- FontAwesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Material Icons CDN -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-uHvY2kx41Y...=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />



    <!-- <link rel="stylesheet" href="../includes/sidebar.css"> -->
    <script src="../public/js/coreui.bundle.min.js"></script>
</head>

<body>

    <div class="d-flex flex-column min-vh-100 bg-light">
        <div class="d-flex flex-grow-1">
            <!-- Sidebar chiếm chiều rộng cố định -->
            <?php include __DIR__ . '/../includes/sidebar.php'; ?>

            <!-- Nội dung và Header chiếm phần còn lại -->
            <div class="content-wrapper d-flex flex-column flex-grow-1">
                <?php include __DIR__ . '/../includes/header.php'; ?>
                <div class="flex-grow-1 px-3">
                    <!-- Nội dung -->
                    <div class="container-lg">
                        <?php
                        $viewPath = __DIR__ . "/$page.php";
                        if (file_exists($viewPath)) {
                            include $viewPath;
                        } else {
                            echo "<h4>Page not found</h4>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/public/js/coreui.bundle.min.js"></script>
</body>

</html>