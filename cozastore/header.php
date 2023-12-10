<!DOCTYPE html>
<html lang="vn">
<?php
include('session_manager.php'); // Include file quản lý session

// Kiểm tra xem người dùng đã đăng nhập hay chưa
$isLoggedIn = isset($_SESSION['user_name']);
$user_name = $isLoggedIn ? $_SESSION['user_name'] : "Đăng nhập";
$logout_link = $isLoggedIn ? "login/logout.php" : "login/login.php";
$logout_text = $isLoggedIn ? "Đăng xuất" : "Đăng nhập";
$avatar = isset($_SESSION['user_img']) ? $_SESSION['user_img'] : './Admin/img/avt.jpg';
?>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.png" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/linearicons-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/slick/slick.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/MagnificPopup/magnific-popup.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
</head>
<!-- Header -->
<header>
    <!-- Header desktop -->
    <div class="container-menu-desktop">
        <!-- Topbar -->
        <div class="top-bar">
            <div class="content-topbar flex-sb-m h-full container">
                <div class="left-top-bar">
                    Miễn phí vận chuyển trên 1.000.000đ
                </div>

                <div class="right-top-bar flex-w h-full">
                    <a href="infor.php" class="flex-c-m trans-04 p-lr-25">
                        <img style="vertical-align: middle; height: -webkit-fill-available; border-style: none;
        padding: 8px;  border-radius: 50%;" src="<?php echo $avatar; ?>" alt="Avatar" class="avatar-img">
                        <?php echo $user_name; ?>
                    </a>
                    <?php if ($isLoggedIn) { ?>
                        <a href="<?php echo $logout_link; ?>" class="flex-c-m trans-04 p-lr-25">
                            <?php echo $logout_text; ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop container">

                <!-- Logo desktop -->
                <a href="index.php" class="logo">
                    <img src="images/icons/logo-01.png" alt="IMG-LOGO">
                </a>

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li <?php if (basename($_SERVER['PHP_SELF']) == 'index.php') {
                                echo 'class="active-menu"';
                            } ?>>
                            <a href="index.php">Trang chủ</a>
                        </li>
                        <li <?php if (basename($_SERVER['PHP_SELF']) == 'product.php') {
                                echo 'class="active-menu"';
                            } ?>>
                            <a href="product.php">Cửa hàng</a>
                        </li>
                        <li <?php if (basename($_SERVER['PHP_SELF']) == 'blog.php') {
                                echo 'class="active-menu"';
                            } ?>>
                            <a href="blog.php">Tin tức</a>
                        </li>
                        <li <?php if (basename($_SERVER['PHP_SELF']) == 'contact.html') {
                         echo 'class="active-menu"';
                            } ?>>
                            <a style="display:none" href="contact.html">Liên hệ</a>
                        </li>
                    </ul>
                </div>


                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m">


                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="2">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>


                </div>
            </nav>
        </div>
    </div>



</header>