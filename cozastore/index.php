<?php
include('config.php');
include('header.php');
?>

<title>Trang chủ</title>

<body class="animsition">
<?php
include('cart.php');
?>
    <!-- Slider -->
    <section class="section-slide">
        <div class="wrap-slick1">
            <div class="slick1">
                <?php
                $sql = "SELECT slider_id, title, description, image FROM slider WHERE status = 1 ORDER BY created_at DESC LIMIT 3";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    echo '<section class="section-slide"><div class="wrap-slick1"><div class="slick1">';

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="item-slick1" style="background-image: url(Admin/img/' . $row['image'] . ');">';
                        echo '<div class="container h-full"><div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">';
                        echo '<div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">';
                        echo '<span class="ltext-101 cl2 respon2">' . $row['description'] . '</span>';
                        echo '</div>';
                        echo '<div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">';
                        echo '<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">' . $row['title'] . '</h2>';
                        echo '</div>';
                        echo '<div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">';
                        echo '<a href="product.php" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">Mua sắm ngay</a>';
                        echo '</div>';
                        echo '</div></div></div>';
                    }

                    echo '</div></div></section>';
                } else {
                    // Xử lý trường hợp không có dữ liệu
                    echo 'Không có dữ liệu slider nào.';
                } ?>


            </div>
        </div>
    </section>





    <!-- Product -->
    <section class="bg0 p-t-23 p-b-140">
        <div class="container">
            <div class="p-b-10">
                <h3 class="ltext-103 cl5">
                    Sản phẩm nổi bật
                </h3>
            </div>

            <div class="flex-w flex-sb-m p-b-52">
                <?php
                $currentCategory = isset($_GET['category']) ? $_GET['category'] : 'all';
                $searchKeyword = isset($_GET['search-product']) ? $_GET['search-product'] : '';

                $sql = "SELECT prod_id, prod_name, prod_image, price FROM product";
                if ($currentCategory != 'all') {
                    $sql .= " WHERE cat_id = '$currentCategory'";
                }
                if (!empty($searchKeyword)) {
                    $sql .= " AND prod_name LIKE '%$searchKeyword%'";
                }
                $sql .= " LIMIT 16";

                $result = $conn->query($sql);

                $sql_categories = "SELECT cat_id, cat_name FROM category";
                $result_categories = $conn->query($sql_categories);

                if ($result_categories->num_rows > 0) {
                    echo '<div class="flex-w flex-l-m filter-tope-group m-tb-10">';

                    $currentClassAll = ($currentCategory === 'all') ? 'how-active1' : '';
                    echo '<a href="?category=all" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 ' . $currentClassAll . '">Tất cả</a>';

                    while ($row = $result_categories->fetch_assoc()) {
                        $cat_id = $row["cat_id"];
                        $currentClass = ($cat_id === $currentCategory) ? 'how-active1' : '';
                        $cat_name = $row["cat_name"];
                        echo '<a href="?category=' . $cat_id . '" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 ' . $currentClass . '">' . $cat_name . '</a>';
                    }

                    echo '</div>';
                }
                ?>
                <div class="flex-w flex-c-m m-tb-10">
                    <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
                        <i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
                        <i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i> Filter
                    </div>

                    <div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
                        <i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
                        <i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i> Search
                    </div>
                </div>

                <!-- Search product -->
                <div class="dis-none panel-search w-full p-t-10 p-b-15">
                    <div class="bor8 dis-flex p-l-15">
                        <form action="" method="get">
                            <button type="submit" class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
                                <i class="zmdi zmdi-search"></i>
                            </button>
                            <input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product" placeholder="Search" value="<?php echo isset($_GET['search-product']) ? $_GET['search-product'] : ''; ?>">
                        </form>
                    </div>
                </div>

                <!-- Filter -->
                <div class="dis-none panel-filter w-full p-t-10">
                    <div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
                        <div class="filter-col1 p-r-15 p-b-27">
                            <div class="mtext-102 cl2 p-b-15">
                                Sort By
                            </div>

                            <ul>
                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04">
                                        Cũ nhất
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04">
                                        Mới nhất
                                    </a>
                                </li>

                            </ul>
                        </div>

                        <div class="filter-col2 p-r-15 p-b-27">
                            <div class="mtext-102 cl2 p-b-15">
                                Price
                            </div>

                            <ul>
                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04 filter-link-active">
                                        All
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04">
                                        0đ - 200,000đ
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04">
                                        200,000đ - 500,000đ
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04">
                                        500,000đ - 1,000,000đ
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04">
                                        1,000,000đ +
                                    </a>
                                </li>


                            </ul>
                        </div>

                        <div class="filter-col3 p-r-15 p-b-27">
                            <div class="mtext-102 cl2 p-b-15">
                                Color
                            </div>

                            <ul>
                                <li class="p-b-6">
                                    <span class="fs-15 lh-12 m-r-6" style="color: #222;">
                                        <i class="zmdi zmdi-circle"></i>
                                    </span>

                                    <a href="#" class="filter-link stext-106 trans-04">
                                        Black
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <span class="fs-15 lh-12 m-r-6" style="color: #4272d7;">
                                        <i class="zmdi zmdi-circle"></i>
                                    </span>

                                    <a href="#" class="filter-link stext-106 trans-04 filter-link-active">
                                        Blue
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <span class="fs-15 lh-12 m-r-6" style="color: #b3b3b3;">
                                        <i class="zmdi zmdi-circle"></i>
                                    </span>

                                    <a href="#" class="filter-link stext-106 trans-04">
                                        Grey
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <span class="fs-15 lh-12 m-r-6" style="color: #00ad5f;">
                                        <i class="zmdi zmdi-circle"></i>
                                    </span>

                                    <a href="#" class="filter-link stext-106 trans-04">
                                        Green
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <span class="fs-15 lh-12 m-r-6" style="color: #fa4251;">
                                        <i class="zmdi zmdi-circle"></i>
                                    </span>

                                    <a href="#" class="filter-link stext-106 trans-04">
                                        Red
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <span class="fs-15 lh-12 m-r-6" style="color: #aaa;">
                                        <i class="zmdi zmdi-circle-o"></i>
                                    </span>

                                    <a href="#" class="filter-link stext-106 trans-04">
                                        White
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Hiện thị sản phẩm -->
            <div class="row isotope-grid">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $prod_name = $row["prod_name"];
                        $prod_image = $row["prod_image"];
                        $price = $row["price"];

                        echo '<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item ' . $currentCategory . '">';
                        echo '<div class="block2">';
                        echo '<div class="block2-pic hov-img0">';
                        echo '<img src="Admin/img/' . $prod_image . '" alt="IMG-PRODUCT">';
                        echo '<a href="product-detail.php?prod_id=' . $row["prod_id"] . '" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04" data-product-name="' . $prod_name . '" data-product-price="' . $price . '">Xem hàng</a>';
                        echo '</div>';
                        echo '<div class="block2-txt flex-w flex-t p-t-14">';
                        echo '<div class="block2-txt-child1 flex-col-l ">';
                        echo '<a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">' . $prod_name . '</a>';
                        echo '<span class="stext-105 cl3" data-product-color="Red">' . number_format($price) . ' đ</span>';

                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "Không tìm thấy sản phẩm.";
                } ?>

            </div>

            <!-- Load more -->
            <div class="flex-c-m flex-w w-full p-t-45">
                <a href="#" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
                    Xem thêm
                </a>
            </div>
        </div>
    </section>

    <?php
    include('footer.php');
    ?>


    <style>
        .cl-prd{
            padding-top: 8px;
            padding-bottom: 12px;
        }
        .cl-pr {
            font-size: 13px;
            color: #555;
            line-height: 1.2;
            padding-left: 20px;
            background-color: transparent;
            
        }
    </style>
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
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/slick/slick.min.js"></script>
    <script src="js/slick-custom.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/parallax100/parallax100.js"></script>
    <script>
        $('.parallax100').parallax100();
    </script>
    <!--===============================================================================================-->
    <script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
    <script>
        $('.gallery-lb').each(function() { // the containers for all your galleries
            $(this).magnificPopup({
                delegate: 'a', // the selector for gallery item
                type: 'image',
                gallery: {
                    enabled: true
                },
                mainClass: 'mfp-fade'
            });
        });
    </script>
    <!--===============================================================================================-->
    <script src="vendor/isotope/isotope.pkgd.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/sweetalert/sweetalert.min.js"></script>
    <script>
        $('.js-addwish-b2').on('click', function(e) {
            e.preventDefault();
        });

        $('.js-addwish-b2').each(function() {
            var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
            $(this).on('click', function() {
                swal(nameProduct, "is added to wishlist !", "success");

                $(this).addClass('js-addedwish-b2');
                $(this).off('click');
            });
        });

        $('.js-addwish-detail').each(function() {
            var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

            $(this).on('click', function() {
                swal(nameProduct, "is added to wishlist !", "success");

                $(this).addClass('js-addedwish-detail');
                $(this).off('click');
            });
        });

        /*---------------------------------------------*/

        $('.js-addcart-detail').each(function() {
            var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
            $(this).on('click', function() {
                swal(nameProduct, "is added to cart !", "success");
            });
        });
    </script>
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
    <script>
        window.scroll({
            top: 650,
            behavior: "smooth",
        });
    </script>

    <!--===============================================================================================-->
    <script src="js/main.js"></script>

</body>

</html>
