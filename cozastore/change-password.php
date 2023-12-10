<?php

include('config.php');
include('header.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $old_password = $_POST['old_pw'];
    $new_password = $_POST['new_pw'];
    $retype_password = $_POST['retype_pw'];

    // Kiểm tra mật khẩu cũ có khớp với mật khẩu trong cơ sở dữ liệu hay không
    $query = "SELECT password FROM user WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $hashed_password = $row['password'];

        if (md5($old_password) === $hashed_password) {
            if ($new_password === $retype_password) {
                $new_hashed_password = md5($new_password);
                $update_query = "UPDATE user SET password = '$new_hashed_password' WHERE user_id = '$user_id'";
                mysqli_query($conn, $update_query);

                echo "Đổi mật khẩu thành công!";
                header("Location: infor.php");
                exit();
            } else {
                echo "Mật khẩu mới và mật khẩu nhập lại không khớp!";
            }
        } else {
            echo "Mật khẩu cũ không chính xác!";
        }
    }
}

?>


<title>Đổi mật khẩu</title>

<body class="animsition">

    <?php
    include('cart.php');

    ?>
    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-01.jpg');">
        <h2 class="ltext-105 cl0 txt-center">
            Đổi mật khẩu
        </h2>
    </section>

    <!-- Content page -->
    <section class="bg0 p-t-75 p-b-120">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div>
                <label for="old_pw">Mật khẩu cũ:</label>
                <input type="password" id="old_pw" name="old_pw" required>
            </div>
            <div>
                <label for="new_pw">Mật khẩu mới:</label>
                <input type="password" id="new_pw" name="new_pw" required>
            </div>
            <div>
                <label for="retype_pw">Nhập lại mật khẩu mới:</label>
                <input type="password" id="retype_pw" name="retype_pw" required>
            </div>
            <button type="submit">Đổi mật khẩu</button>
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


</body>

</html>