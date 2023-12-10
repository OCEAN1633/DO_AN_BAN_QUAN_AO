<?php
ob_start();

include('config.php');
include('header.php');
// Lấy thông tin người dùng hiện tại
$user_name = $_SESSION['user_name'];
$query = "SELECT * FROM user WHERE user_name = '$user_name'";
$result = mysqli_query($conn, $query);

if ($result) {
    $user = mysqli_fetch_assoc($result);
    $fullname = isset($user['fullname']) ? $user['fullname'] : "";
    $email = isset($user['user_email']) ? $user['user_email'] : "";
    $phone = isset($user['user_phone']) ? $user['user_phone'] : "";
    $avatar = isset($user['user_img']) ? $user['user_img'] : "./Admin/img/avt.jpg";
} else {
    // Xử lý lỗi truy vấn cơ sở dữ liệu
    $fullname = "";
    $email = "";
    $phone = "";
    $avatar = "./Admin/img/avt.jpg";
}

// Xử lý khi form được gửi đi
// Xử lý khi form được gửi đi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    // Validate và làm sạch dữ liệu nhập từ người dùng nếu cần

    // Đưa dấu ngoặc nhọn này lên đầu hàm xử lý form
    $newAvatar = $avatar;  // Mặc định là ảnh cũ

    if (!empty($_FILES['image']['name'])) {
        // Xử lý ảnh mới
        $newImage = $_FILES['image']['name'];
        $newImage_temp = $_FILES['image']['tmp_name'];

        // Thư mục lưu trữ ảnh mới
        $uploadDir = 'upload/'; // Thay đổi với đường dẫn thực tế
        $newAvatar = $uploadDir . $newImage;

        // Đảm bảo thư mục tồn tại
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Tạo thư mục nếu nó không tồn tại
        }

        // Di chuyển ảnh đã tải lên đến thư mục đích
        if (!move_uploaded_file($newImage_temp, $newAvatar)) {
            echo "Tải lên ảnh đại diện mới thất bại!";
            exit;
        }
    }

    // Cập nhật cơ sở dữ liệu với đường dẫn ảnh đại diện mới hoặc cũ
    $updateAvatarQuery = "UPDATE user SET user_img = '$newAvatar' WHERE user_name = '$user_name'";
    $updateAvatarResult = mysqli_query($conn, $updateAvatarQuery);

    // Cập nhật thông tin người dùng khác trong cơ sở dữ liệu (nếu có)
    $newFullname = mysqli_real_escape_string($conn, $_POST['new_fullname']);
    $newPhone = mysqli_real_escape_string($conn, $_POST['new_phone']);

    $updateQuery = "UPDATE user SET fullname = '$newFullname', user_phone = '$newPhone' WHERE user_name = '$user_name'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateAvatarResult && $updateResult) {
        header("Location:infor.php");
        ob_end_flush();
        exit();
    } else {
        echo "Cập nhật thông tin thất bại!";
    }
}
?>


<title>Thông tin cá nhân</title>

<body class="animsition">

    <!-- Cart -->
    <div class="wrap-header-cart js-panel-cart">
        <div class="s-full js-hide-cart"></div>

        <div class="header-cart flex-col-l p-l-65 p-r-25">
            <div class="header-cart-title flex-w flex-sb-m p-b-8">
                <span class="mtext-103 cl2">
                    Your Cart
                </span>

                <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                    <i class="zmdi zmdi-close"></i>
                </div>
            </div>

            <div class="header-cart-content flex-w js-pscroll">
                <ul class="header-cart-wrapitem w-full">
                    <li class="header-cart-item flex-w flex-t m-b-12">
                        <div class="header-cart-item-img">
                            <img src="images/item-cart-01.jpg" alt="IMG">
                        </div>

                        <div class="header-cart-item-txt p-t-8">
                            <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                White Shirt Pleat
                            </a>

                            <span class="header-cart-item-info">
                                1 x $19.00
                            </span>
                        </div>
                    </li>

                    <li class="header-cart-item flex-w flex-t m-b-12">
                        <div class="header-cart-item-img">
                            <img src="images/item-cart-02.jpg" alt="IMG">
                        </div>

                        <div class="header-cart-item-txt p-t-8">
                            <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                Converse All Star
                            </a>

                            <span class="header-cart-item-info">
                                1 x $39.00
                            </span>
                        </div>
                    </li>

                    <li class="header-cart-item flex-w flex-t m-b-12">
                        <div class="header-cart-item-img">
                            <img src="images/item-cart-03.jpg" alt="IMG">
                        </div>

                        <div class="header-cart-item-txt p-t-8">
                            <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                Nixon Porter Leather
                            </a>

                            <span class="header-cart-item-info">
                                1 x $17.00
                            </span>
                        </div>
                    </li>
                </ul>

                <div class="w-full">
                    <div class="header-cart-total w-full p-tb-40">
                        Total: $75.00
                    </div>

                    <div class="header-cart-buttons flex-w w-full">
                        <a href="shoping-cart.html" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                            View Cart
                        </a>

                        <a href="shoping-cart.html" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
                            Check Out
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-01.jpg');">
        <h2 class="ltext-105 cl0 txt-center">
            Sửa thông tin cá nhân
        </h2>
    </section>

    <!-- Content page -->
    <section class="bg0 p-t-75 p-b-120">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
            <div class="user-info">
                <div class="user-info-left">
                    <!-- Thêm trường nhập cho thông tin có thể chỉnh sửa -->
                    <div class="info-item">
                        <span class="info-label">Họ và tên:</span>
                        <input type="text" name="new_fullname" value="<?php echo $fullname; ?>">
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
                        <input type="text" name="new_phone" value="<?php echo $phone; ?>">
                    </div>
                    <div style="margin-top: 30px;" class="info-item">
                        <button class="edit-link" type="submit" name="save">Lưu thay đổi</button>
                    </div>
                </div>
                <div class="user-info-right">
                    <div class="info-item">
                        <span class="info-label">Ảnh đại diện:</span>
                        <div style="display: table-caption;" class="user-avatar">
                            <input type="file" id="image" name="image" class="form-control-file" onchange="showImagePreview(this);">
                            <img  id="userAvatar" src="<?php echo $avatar; ?>" alt="Ảnh đại diện ">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <style>
        .info-item input {
            padding: 4px
        }

        .user-info {
            display: flex;
            justify-content: space-evenly;
            align-items: flex-start;
            margin: 0 300px;
        }

        .user-info-right,
        .user-info-left {
            flex: inherit;
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
    <script>function showImagePreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            document.getElementById('userAvatar').src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
    }
}
</script>


</body>

</html>