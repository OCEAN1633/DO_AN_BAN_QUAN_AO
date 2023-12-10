<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Login</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<?php
require('config.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Kiểm tra xem tên đăng nhập có tồn tại trong cơ sở dữ liệu
    $query = "SELECT admin_email, admin_pw FROM admin WHERE admin_email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        // Kiểm tra mật khẩu
        $hashed_password = md5($password);
        if ($hashed_password === $row['admin_pw']) {
            // Mật khẩu chính xác, cho phép đăng nhập
            $_SESSION['admin_email'] = $email;
            header("Location: /cozastore/admin/index.php"); // Chuyển hướng đến trang chính
            exit();
        } else {
            echo "Sai mật khẩu. Vui lòng kiểm tra lại.";
        }
    } else {
        echo "Tên đăng nhập không tồn tại. Vui lòng kiểm tra lại.";
    }

    // Kiểm tra và thiết lập cookie 'remember_me' nếu người dùng chọn ghi nhớ mật khẩu
    if (isset($_POST['remember_me'])) {
        $expire = time() + 60 * 60 * 24 * 30; // 30 ngày
        setcookie('remember_me', $email, $expire, '/');
        setcookie('remember_me_password', md5($password), $expire, '/');
    } else {
        // Xóa cookie 'remember_me' nếu không chọn ghi nhớ mật khẩu
        setcookie('remember_me', '', time() - 3600, '/');
        setcookie('remember_me_password', '', time() - 3600, '/');
    }
}

// Kiểm tra cookie khi người dùng truy cập trang
if (isset($_COOKIE['remember_me']) && isset($_COOKIE['remember_me_password']) && !isset($_SESSION['admin_email'])) {
    // Lấy thông tin từ cookie
    $saved_email = $_COOKIE['remember_me'];
    $saved_password = $_COOKIE['remember_me_password'];

    // Kiểm tra và so sánh mật khẩu trong cơ sở dữ liệu với mật khẩu lưu trong cookie
    $query = "SELECT admin_email, admin_pw FROM admin WHERE admin_email = '$saved_email'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        // So sánh mật khẩu
        if (md5($row['admin_pw']) === $saved_password) {
            // Mật khẩu hợp lệ, đăng nhập và lưu trạng thái đăng nhập
            $_SESSION['admin_email'] = $saved_email;

            // Chuyển hướng đến trang chính nếu đăng nhập thành công từ cookie
            header("Location: /cozastore/admin/index.php");
            exit();
        }
    }

    // Nếu mật khẩu không hợp lệ, xóa cookie 'remember_me'
    setcookie('remember_me', '', time() - 3600, '/');
    setcookie('remember_me_password', '', time() - 3600, '/');
}
?>
<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <img src="images/icon/logo.png" alt="CoolAdmin">
                            </a>
                        </div>
                        <div class="login-form">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label>Email </label>
                                    <input class="au-input au-input--full" type="email" name="email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label>Mật khẩu</label>
                                    <input class="au-input au-input--full" type="password" name="password" placeholder="Mật khẩu">
                                </div>
                                <div class="login-checkbox">
                                    <label>
                                        <input type="checkbox" name="remember_me">Nhớ mật khẩu
                                    </label>

                                </div>
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">Đăng nhập</button>

                            </form>
                            <div class="register-link">
                                <p>
                                    Bạn chưa có tài khoản?
                                    <a href="register.php">Đăng ký ở đây</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="js/main.js"></script>

</body>

</html>
<!-- end document-->
