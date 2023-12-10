<?php
require('config.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['your_name'];
    $password = $_POST['your_pass'];

    // Kiểm tra xem tên đăng nhập có tồn tại trong cơ sở dữ liệu
    $query = "SELECT user_id, user_name, password FROM user WHERE user_name = '$username'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        // Kiểm tra mật khẩu
        $hashed_password = md5($password);

        if ($hashed_password === $row['password']) {
            // Mật khẩu chính xác, cho phép đăng nhập
            $_SESSION['user_name'] = $username;
            $_SESSION['user_id'] = $row['user_id'];
            // Lưu trạng thái đăng nhập ở đây (ví dụ: sử dụng phiên làm việc, cookie, hoặc JWT)
            header("Location: ../index.php"); // Chuyển hướng đến trang chính
            exit();
        } else {
            echo "Sai mật khẩu. Vui lòng kiểm tra lại.";
        }
    } else {
        echo "Tên đăng nhập không tồn tại. Vui lòng kiểm tra lại.";
    }

    // Kiểm tra xem tên đăng nhập có tồn tại trong cơ sở dữ liệu
    if (isset($_POST['remember_me'])) {
        $expire = time() + 60 * 60 * 24 * 30; // 30 days
        setcookie('remember_me', $username, $expire, '/');
        setcookie('remember_me_password', md5($password), $expire, '/');
    } else {
        setcookie('remember_me', '', time() - 3600, '/');
        setcookie('remember_me_password', '', time() - 3600, '/');
    }
}

// Kiểm tra cookie khi người dùng truy cập trang
if (isset($_COOKIE['remember_me']) && isset($_COOKIE['remember_me_password']) && !isset($_SESSION['user_name'])) {
    // Giải mã mật khẩu từ cookie (lưu ý: mã hóa mật khẩu nên được thực hiện bằng phương pháp an toàn như bcrypt)
    $saved_password = $_COOKIE['remember_me_password'];

    // Kiểm tra mật khẩu
    $query = "SELECT user_name, password FROM user WHERE user_name = '$username'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        if ($saved_password === md5($row['password'])) {
            $_SESSION['user_name'] = $_COOKIE['remember_me'];
            header("Location: ../index.php");
            exit();
        }
    }

    // Nếu mật khẩu không hợp lệ, hủy bỏ cookie
    setcookie('remember_me', '', time() - 3600, '/');
    setcookie('remember_me_password', '', time() - 3600, '/');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign In</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="main">
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/login.jpeg" alt="login image"></figure>
                        <a href="register.php" class="signup-image-link">Tạo tài khoản</a>
                    </div>
                    <div class="signin-form">
                        <h2 class="form-title">Đăng nhập</h2>
                        <form method="POST" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="your_name" id="your_name" placeholder="Tên đăng nhập" required autocomplete="username" />
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="your_pass" id="your_pass" placeholder="Mật khẩu" required autocomplete="current-password" />
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Đăng nhập" />
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember_me" id="remember_me" class="agree-term" />
                                <label for="remember_me" class="label-agree-term"><span><span></span></span>Lưu tài khoản</label>
                            </div>
                        </form>
                        <div class="social-login">
                            <span class="social-label">Hoặc đăng nhập bằng</span>
                            <ul class="socials">
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
