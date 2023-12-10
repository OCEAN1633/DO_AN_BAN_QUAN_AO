<?php
include('config.php');
include('header.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_name'])) {
    // Chuyển hướng đến trang đăng nhập hoặc xử lý theo cách thích hợp
    header("Location: login/login.php");
    exit();
}

// Lấy thông tin người dùng từ cơ sở dữ liệu dựa trên user_name
$user_name = $_SESSION['user_name'];
$query = "SELECT * FROM user WHERE user_name = '$user_name'";
$result = mysqli_query($conn, $query);

if ($result) {
    $user = mysqli_fetch_assoc($result);
    $fullname = isset($user['fullname']) ? $user['fullname'] : "Chưa thiết lập";
    $email = isset($user['user_email']) ? $user['user_email'] : "Chưa thiết lập";
    $phone = isset($user['user_phone']) ? $user['user_phone'] : "Chưa thiết lập";
    $avatar = isset($user['user_img']) ? $user['user_img'] : "./Admin/img/avt.jpg";
} else {
    // Xử lý lỗi truy vấn cơ sở dữ liệu
    $fullname = "Chưa thiết lập";
    $email = "Chưa thiết lập";
    $phone = "Chưa thiết lập";
    $avatar = "./Admin/img/avt.jpg";
}
?>

<title>Thông tin cá nhân</title>

<body class="animsition">

    <?php
    include('cart.php');
    ?>
    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-01.jpg');">
        <h2 class="ltext-105 cl0 txt-center">
            Thông tin cá nhân
        </h2>
    </section>


    <!-- Content page -->
    <section class="bg0 p-t-75 p-b-120">
        <div class="user-info">
            <div class="user-info-left">
                <div class="info-item">
                    <span class="info-label">Họ và tên:</span>
                    <input type="text" id="fullName" value="<?php echo $fullname; ?>" style="color: <?php echo ($fullname == 'Chưa thiết lập') ? 'red' : 'black'; ?>">
                </div>
                <div class="info-item">
                    <span class="info-label">Tên đăng nhập:</span>
                    <span id="username"><?php echo $user_name; ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Gmail:</span>
                    <span id="email"><?php echo $email; ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Số điện thoại:</span>
                    <span id="phone" style="color: <?php echo ($phone == 'Chưa thiết lập') ? 'red' : 'black'; ?>"><?php echo $phone; ?></span>
                </div>
                <div style="margin-top: 30px;" class="info-item">
                    <a href="infor-edit.php" class="edit-link">Sửa thông tin</a>
                    <a style="padding-left: 20px;" href="change-password.php" class="change-link">Đổi mật khẩu</a>
                </div>
            </div>
            <div class="user-info-right">
                <div class="info-item">
                    <span class="info-label">Ảnh đại diện:</span>
                    <div class="user-avatar">
                        <img src="<?php echo $avatar; ?>" alt="Avatar" id="userAvatar">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        .info-item input {
            padding: 4px
        }

        .user-info {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin: 0 475px;
        }

        .user-info-left {
            flex: 1;
            padding: 10px;
        }

        .info-item {
            margin-bottom: 20px;
        }

        .info-label {
            font-weight: bold;
            margin-right: 5px;
        }

        .user-avatar {
            text-align: center;
            margin-top: 10px;
        }

        #userAvatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 5px;
            cursor: pointer;
        }

        .edit-link {
            cursor: pointer;
            color: #3498db;
        }

        .edit-link:hover {
            text-decoration: underline;
        }

        /* Thêm mã CSS sau vào cuối file CSS của bạn */
        /* Nút chọn ảnh */

        .edit-link {
            cursor: pointer;
            color: #3498db;
            text-decoration: none;
            border-bottom: 1px dashed transparent;
            /* Tạo đường gạch chân */
            transition: border-color 0.3s;
            /* Hiệu ứng khi di chuột qua nút */
        }

        .edit-link:hover {
            border-color: #3498db;
            /* Màu đường gạch chân khi di chuột qua */
        }

        /* Hình ảnh đại diện hình tròn */

        .user-avatar {
            text-align: center;
            margin-top: 10px;
        }

        #userAvatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 5px;
            cursor: pointer;
            transition: transform 0.3s;
            /* Hiệu ứng khi di chuột qua hình ảnh */
        }

        #userAvatar:hover {
            transform: scale(1.1);
            /* Phóng to hình ảnh khi di chuột qua */
        }
    </style>



    <?php
    include('footer.php');
    ?>


    <!-- Back to top -->
    <div class="btn-back-to-top" id="myBtn">
        <span class="symbol-btn-back-to-top">
            <i class="zmdi zmdi-chevron-up"></i>
        </span>
    </div>

    <!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <script>
        $(".js-select2").each(function() {
            $(this).select2({
                minimumResultsForSearch: 20,
                dropdownParent: $(this).next('.dropDownSelect2')
            });
        })
    </script>
    <!--===============================================================================================-->
    <script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script>
        $('.js-pscroll').each(function() {
            $(this).css('position', 'relative');
            $(this).css('overflow', 'hidden');
            var ps = new PerfectScrollbar(this, {
                wheelSpeed: 1,
                scrollingThreshold: 1000,
                wheelPropagation: false,
            });

            $(window).on('resize', function() {
                ps.update();
            })
        });
    </script>
    <!--===============================================================================================-->
    <script src="js/main.js"></script>



</body>

</html>