<?php
include('config.php');
include('header.php');
?>
<title>Chi tiết bài viết</title>

<body class="animsition">
    <?php

    if (isset($_GET['blog_id'])) {
        $blog_id = $_GET['blog_id'];
        $sql = "SELECT b.*, bc.blogcat_name FROM blog b
            INNER JOIN blog_cat bc ON b.blogcat_id = bc.blogcat_id
            WHERE b.blog_id = $blog_id";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        } else {
            echo "Không tìm thấy bài viết.";
        }
    } else {
        echo "Vui lòng chọn một bài viết để xem chi tiết.";
    }

    // Lấy danh sách thể loại từ cơ sở dữ liệu
    $sql_categories = "SELECT * FROM blog_cat";
    $result_categories = mysqli_query($conn, $sql_categories);

    // Lấy danh sách 3 bài viết mới nhất có status = 1
    $sql_latest_blogs = "SELECT * FROM blog WHERE status = 1 ORDER BY created_at DESC LIMIT 3";
    $result_latest_blogs = mysqli_query($conn, $sql_latest_blogs);
    ?>


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


    <!-- breadcrumb -->
    <div class="container" style="margin-top: 50px">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="index.php" class="stext-109 cl8 hov-cl1 trans-04">
                Trang chủ
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <a href="blog.php" class="stext-109 cl8 hov-cl1 trans-04">
                Tin tức
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
                <?php echo $row['title']; ?>
            </span>
        </div>
    </div>


    <!-- Content page -->
    <section class="bg0 p-t-52 p-b-20">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-9 p-b-80">
                    <div class="p-r-45 p-r-0-lg">
                        <div class="wrap-pic-w how-pos5-parent">
                            <img src="Admin/img/<?php echo $row['image']; ?>" alt="IMG-BLOG">
                        </div>

                        <div class="p-t-32">
                            <span>
                                <?php echo $row['created_at']; ?>
                                <span class="cl12 m-l-4 m-r-6">|</span>
                            </span>

                            <span>
                                <?php echo $row['blogcat_name']; ?>
                                <span class="cl12 m-l-4 m-r-6">|</span>
                            </span>

                            <h4 class="ltext-109 cl2 p-b-28">
                                <?php echo $row['title']; ?>
                            </h4>

                            <p class="stext-117 cl6 p-b-26">
                                <?php echo $row['content']; ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3 p-b-80">
                    <div class="side-menu">


                        <div class="p-t-55">
                            <h4 class="mtext-112 cl2 p-b-33">
                                Thể loại
                            </h4>

                            <ul>
                                <li class="bor18">
                                    <a href="blog.php" class="dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4">
                                        Tất cả
                                    </a>
                                </li>

                                <?php
                                // Hiển thị danh sách thể loại từ cơ sở dữ liệu
                                if (mysqli_num_rows($result_categories) > 0) {
                                    while ($category = mysqli_fetch_assoc($result_categories)) {
                                ?>
                                        <li class="bor18">
                                            <a href="blog.php?blogcat_id=<?php echo $category['blogcat_id']; ?>" class="dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4">
                                                <?php echo $category['blogcat_name']; ?>
                                            </a>
                                        </li>
                                <?php
                                    }
                                }
                                ?>

                            </ul>
                        </div>

                        <div class="p-t-65">
                            <h4 class="mtext-112 cl2 p-b-33">
                                Featured Blog
                            </h4>

                            <ul>
                                <?php
                                // Hiển thị danh sách 3 bài viết mới nhất
                                if (mysqli_num_rows($result_latest_blogs) > 0) {
                                    while ($latest_blog = mysqli_fetch_assoc($result_latest_blogs)) {
                                ?>
                                        <li class="flex-w flex-t p-b-30">
                                            <a href="blog-detail.php?blog_id=<?php echo $latest_blog['blog_id']; ?>" class="wrao-pic-w size-214 hov-ovelay1 m-r-20">
                                                <img style="width: 100%" src="Admin/img/<?php echo $latest_blog['image']; ?>" alt="blog-img">
                                            </a>

                                            <div class="size-215 flex-col-t p-t-8">
                                                <a href="blog-detail.php?blog_id=<?php echo $latest_blog['blog_id']; ?>" class="stext-116 cl8 hov-cl1 trans-04">
                                                    <?php echo $latest_blog['title']; ?>
                                                </a>

                                                <span class="stext-116 cl6 p-t-20">
                                                    <?php echo substr($latest_blog['summary'], 0, 60); // Chỉ hiển thị 100 ký tự đầu 
                                                    ?>
                                                    <?php if (strlen($latest_blog['summary']) > 60) echo '...'; // Nếu tóm tắt dài hơn 100 ký tự, hiển thị dấu ba chấm 
                                                    ?>
                                                </span>

                                            </div>
                                        </li>
                                <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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