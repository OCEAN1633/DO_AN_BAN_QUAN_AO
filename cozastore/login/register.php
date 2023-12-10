<?php
require('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $password_confirmation = $_POST['re_pass']; // Thêm dòng này

    if (empty($name) || empty($email) || empty($password) || empty($password_confirmation)) {
        echo "Vui lòng điền đầy đủ thông tin vào các trường.";
    } elseif ($password !== $password_confirmation) {
        echo "Mật khẩu và mật khẩu xác nhận không khớp. Vui lòng kiểm tra lại.";
    } else {
        // Kiểm tra xem email hoặc tên đăng nhập đã tồn tại trong cơ sở dữ liệu
        $check_query = "SELECT * FROM user WHERE user_email = '$email' OR user_name = '$name'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            echo "Email hoặc tên đăng nhập đã tồn tại. Vui lòng chọn thông tin khác.";
        } else {
            $hashed_password = md5($password);
            // $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $created_at = date("Y-m-d H:i:s");
            // Thêm thông tin người dùng mới vào cơ sở dữ liệu
            $insert_query = "INSERT INTO user (user_name, user_email, password, created_at) VALUES ('$name', '$email', '$hashed_password', '$created_at')";

            if (mysqli_query($conn, $insert_query)) {
                echo "Đăng ký tài khoản thành công!";
                header("Location: login.php"); // Chuyển hướng đến trang login.php
            } else {
                echo "Đã xảy ra lỗi khi đăng ký tài khoản: " . mysqli_error($conn);
            }
        }
    }
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

<body>
    <div class="main">
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Đăng ký</h2>
                        <form method="POST" class="register-form" id="register-form">
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Tên tài khoản" required />
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Email" required />
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="pass" placeholder="Mật khẩu" required />
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="re_pass" id="re_pass" placeholder="Xác nhận mật khẩu" required />
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" required />
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in <a href="#" class="term-service">Terms of service</a></label>
                            </div>

                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Đăng ký" />
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/register.jpg" alt="sing up image"></figure>
                        <a href="login.php" class="signup-image-link">Tôi đã là thành viên</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>