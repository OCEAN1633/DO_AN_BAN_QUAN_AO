<?php
include('config.php');
include('header.php');
?>
<title>Blog</title>

<body class="animsition">


    <!-- Cart -->
    <?php
include('cart.php');
?>


    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('Admin/img/bg-98.jpg');">
        <h2 class="ltext-105 cl0 txt-center">
            Blog
        </h2>
    </section>



    <!-- Content page -->
    <?php
    // Lấy thể loại được chọn (nếu có) từ tham số truyền qua URL
    $blogcat_id = isset($_GET['blogcat_id']) ? $_GET['blogcat_id'] : 0;

    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $per_page = 3;

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }


    $start = ($page - 1) * $per_page;

    // Truy vấn tất cả thể loại từ bảng "blog_cat"
    $sql_blogcat = "SELECT * FROM blog_cat";
    $result_blogcat = mysqli_query($conn, $sql_blogcat);

    if (!empty($search)) {
        $sql_blog = "SELECT * FROM blog WHERE (title LIKE '%$search%' OR summary LIKE '%$search%') AND (blogcat_id = $blogcat_id OR $blogcat_id = 0) AND status = 1 ORDER BY created_at DESC LIMIT $start, $per_page";
        $sql_count = "SELECT COUNT(*) as total FROM blog WHERE (title LIKE '%$search%' OR summary LIKE '%$search%') AND (blogcat_id = $blogcat_id OR $blogcat_id = 0) AND status = 1";
    } else {
        if ($blogcat_id == 0) {
            $sql_blog = "SELECT * FROM blog WHERE status = 1 ORDER BY created_at DESC LIMIT $start, $per_page";
            $sql_count = "SELECT COUNT(*) as total FROM blog WHERE status = 1";
        } else {
            $sql_blog = "SELECT * FROM blog WHERE blogcat_id = $blogcat_id AND status = 1 ORDER BY created_at DESC LIMIT $start, $per_page";
            $sql_count = "SELECT COUNT(*) as total FROM blog WHERE blogcat_id = $blogcat_id AND status = 1";
        }
    }

    $result_blog = mysqli_query($conn, $sql_blog);
    $result_count = mysqli_query($conn, $sql_count);

    // Lấy tổng số bài viết
    if ($result_count) {
        $row_count = mysqli_fetch_assoc($result_count);
        $total_blogs = $row_count['total'];
    } else {
        $total_blogs = 0;
    }
    ?>

    <section class="bg0 p-t-62 p-b-60">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-9 p-b-80">
                    <div class="p-r-45 p-r-0-lg">
                        <!-- Hiển thị danh sách bài viết -->
                        <?php
                        if (mysqli_num_rows($result_blog) > 0) {
                            while ($row_blog = mysqli_fetch_assoc($result_blog)) {
                        ?>
                                <div class="p-b-63">
                                    <a href="blog-detail.php?blog_id=<?php echo $row_blog['blog_id']; ?>" class="hov-img0 how-pos5-parent">
                                        <img src="Admin/img/<?php echo $row_blog['image']; ?>" alt="IMG-BLOG">
                                    </a>

                                    <div class="p-t-32">
                                        <h4 class="p-b-15">
                                            <a href="blog-detail.php?blog_id=<?php echo $row_blog['blog_id']; ?>" class="ltext-108 cl2 hov-cl1 trans-04">
                                                <?php echo $row_blog['title']; ?>
                                            </a>
                                        </h4>

                                        <p class="stext-117 cl6">
                                            <?php echo $row_blog['summary']; ?>
                                        </p>

                                        <div class="flex-w flex-sb-m p-t-18">
                                            <span>
                                                <?php echo $row_blog['created_at']; ?>
                                            </span>

                                            <a href="blog-detail.php?blog_id=<?php echo $row_blog['blog_id']; ?>" class="stext-101 cl2 hov-cl1 trans-04 m-tb-10">
                                                Continue Reading
                                                <i class="fa fa-long-arrow-right m-l-9"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo "Không có bài viết nào.";
                        }
                        ?>

                        <!-- Pagination -->
                        <div class="flex-l-m flex-w w-full p-t-10 m-lr--7">
                            <?php
                            // Tính tổng số trang dựa trên số lượng bài viết và số bài viết trên mỗi trang
                            $total_pages = ceil($total_blogs / $per_page);

                            // Hiển thị các nút phân trang
                            for ($i = 1; $i <= $total_pages; $i++) {
                                $paginationClass = ($i == $page) ? 'current' : 'inactive';
                                echo '<a href="blog.php?page=' . $i . '&blogcat_id=' . $blogcat_id . '" class="flex-c-m how-pagination1 trans-04 m-all-7 ' . $paginationClass . '">' . $i . '</a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3 p-b-80">
                    <div class="side-menu">
                        <div class="bor17 of-hidden pos-relative">
                            <form method="GET">
                                <input class="stext-103 cl2 plh4 size-116 p-l-28 p-r-55" type="text" name="search" placeholder="Search">
                                <button type="submit" class="flex-c-m size-122 ab-t-r fs-18 cl4 hov-cl1 trans-04">
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Thể loại blog -->
                        <div class="p-t-55">
                            <h4 class="mtext-112 cl2 p-b-33">
                                Thể loại
                            </h4>
                            <ul>
                                <li class="bor18">
                                    <a href="blog.php" class="dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4 <?php echo ($blogcat_id == 0) ? 'current' : 'inactive'; ?>">
                                        Tất cả
                                    </a>
                                </li>
                                <?php
                                if (mysqli_num_rows($result_blogcat) > 0) {
                                    while ($row_cat = mysqli_fetch_assoc($result_blogcat)) {
                                ?>
                                        <li class="bor18">
                                            <a href="blog.php?blogcat_id=<?php echo $row_cat['blogcat_id']; ?>" class="dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4 <?php echo ($blogcat_id == $row_cat['blogcat_id']) ? 'current' : 'inactive'; ?>">
                                                <?php echo $row_cat['blogcat_name']; ?>
                                            </a>
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

    <style>
        .current {
            background-color: #000;
            color: #fff;

        }

        .inactive {
            background-color: #fff;
            color: #777;
        }
    </style>


    <?php
    include('footer.php');
    ?>


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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var categoryLinks = document.querySelectorAll(".bor18 a");

            categoryLinks.forEach(function(link) {
                link.addEventListener("click", function(e) {
                    // Loại bỏ lớp "current" từ tất cả các trang hoặc thể loại
                    categoryLinks.forEach(function(otherLink) {
                        otherLink.classList.remove("current");
                    });

                    // Thêm lớp "current" cho trang hoặc thể loại được chọn
                    link.classList.add("current");
                });
            });
        });
    </script>


</body>