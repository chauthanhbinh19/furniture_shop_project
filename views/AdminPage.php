<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../public/css/coreui.min.css">
    <link rel="stylesheet" href="../includes/sidebar.css">
    <!-- FontAwesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Material Icons CDN -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- <link rel="stylesheet" href="../includes/sidebar.css"> -->
    <script src="../public/js/coreui.bundle.min.js"></script>
    <style>
        .wrapper {
            margin-left: 250px;
            /* hoặc đúng width sidebar */
        }

        #sidebar.collapsed {
            display: none;
            /* Hoặc dùng các thuộc tính khác để làm cho sidebar ẩn đi */
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>

    <div class="wrapper d-flex flex-column min-vh-100 bg-light">

        <?php include __DIR__ . '/../includes/header.php'; ?>

        <div class=" flex-grow-1 px-3">
            <!-- Nội dung -->
            <div class="container-lg">
                <?php
                $viewPath = __DIR__ . "/Admin/$page.php";
                if (file_exists($viewPath)) {
                    include $viewPath;
                } else {
                    echo "<h4>Page not found</h4>";
                }
                ?>
            </div>
        </div>
    </div>
    <script src="/public/js/coreui.bundle.min.js"></script>
</body>

</html>