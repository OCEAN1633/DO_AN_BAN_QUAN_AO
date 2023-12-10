<?php
include('../config.php');
include('../head.php');

if(isset($_POST['submit'])) {
    $prod_id = $_GET['prod_id']; // Lấy prod_id từ URL

    // Lấy dữ liệu từ form
    $prod_name = $_POST['prod_name'];
    $cat_id = $_POST['category'];
    $color_id = $_POST['color'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Xử lý ảnh nếu được tải lên
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $image_temp = $_FILES['image']['tmp_name'];
        move_uploaded_file($image_temp, "upload/$image");
        $update_image = "prod_image = '$image',";
    }

    if (!empty($_FILES['thumbnail1']['name'])) {
        $thumbnail1 = $_FILES['thumbnail1']['name'];
        $thumbnail1_temp = $_FILES['thumbnail1']['tmp_name'];
        move_uploaded_file($thumbnail1_temp, "upload/$thumbnail1");
        $update_thumbnail1 = "thumbnail1 = '$thumbnail1',";
    }

    if (!empty($_FILES['thumbnail2']['name'])) {
        $thumbnail2 = $_FILES['thumbnail2']['name'];
        $thumbnail2_temp = $_FILES['thumbnail2']['tmp_name'];
        move_uploaded_file($thumbnail2_temp, "upload/$thumbnail2");
        $update_thumbnail2 = "thumbnail2 = '$thumbnail2',";
    }

    // Thực hiện câu truy vấn để cập nhật dữ liệu trong bảng product
    $sql = "UPDATE product SET
            prod_name = '$prod_name',
            cat_id = '$cat_id',
            color_id = '$color_id',
            title = '$title',
            description = '$description',
            $update_image
            $update_thumbnail1
            $update_thumbnail2
            price = '$price'
            WHERE prod_id = $prod_id";

    if (mysqli_query($conn, $sql)) {
        // Nếu cập nhật thành công, chuyển đến trang index hoặc thông báo thành công
        header("Location: index.php");
    } else {
        // Nếu cập nhật thất bại, hiển thị thông báo lỗi
        echo "Lỗi: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Lấy thông tin sản phẩm cần sửa
if (isset($_GET['prod_id'])) {
    $prod_id = $_GET['prod_id'];
    $select_query = "SELECT * FROM product WHERE prod_id = $prod_id";
    $result = mysqli_query($conn, $select_query);
    $row = mysqli_fetch_assoc($result);
}
?>

<body class="animsition">
    <div class="page-wrapper">
        <?php
        include('../sidebar.php');
        ?>
        <div class="page-container">
        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Chỉnh sửa</strong> Sản phẩm
                                </div>
                                <div class="card-body card-block">
                                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" onsubmit="return confirmSave();">
                                        <input type="hidden" name="prod_id" value="<?php echo $row['prod_id']; ?>">
                                        <div class="card-body card-block">
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class="form-control-label">Tên sản phẩm</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="prod_name" value="<?php echo $row['prod_name']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="select" class=" form-control-label">Thể loại</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="category" id="select" class="form-control">
                                                        <?php
                                                        $category_query = "SELECT cat_id, cat_name FROM category";
                                                        $category_result = mysqli_query($conn, $category_query);
                                                        while ($cat_row = mysqli_fetch_assoc($category_result)) {
                                                            $selected = ($cat_row['cat_id'] == $row['cat_id']) ? "selected" : "";
                                                            echo "<option value='" . $cat_row['cat_id'] . "' $selected>" . $cat_row['cat_name'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="select" class=" form-control-label">Màu sắc</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="color" id="select" class="form-control">
                                                        <?php
                                                        $color_query = "SELECT color_id, color_name FROM color";
                                                        $color_result = mysqli_query($conn, $color_query);
                                                        while ($color_row = mysqli_fetch_assoc($color_result)) {
                                                            $selected = ($color_row['color_id'] == $row['color_id']) ? "selected" : "";
                                                            echo "<option value='" . $color_row['color_id'] . "' $selected>" . $color_row['color_name'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class="form-control-label">Tiêu đề</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="title" value="<?php echo $row['title']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class="form-control-label">Mô tả</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="description" value="<?php echo $row['description']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="file-input" class="form-control-label">Ảnh</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="file" id="file-input" name="image" class="form-control-file">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="file-input" class="form-control-label">Thumbnail 1</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="file" id="file-input" name="thumbnail1" class="form-control-file">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="file-input" class="form-control-label">Thumbnail 2</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="file" id="file-input" name="thumbnail2" class="form-control-file">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class="form-control-label">Giá</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="price" value="<?php echo $row['price']; ?>" class="form-control">
                                                </div>
                                            </div>
                                           
                                            <div class="card-footer">
                                                <button type="submit" name ="submit" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-dot-circle-o"></i> Submit
                                                </button>
                                               
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="copyright">
                                <p>Copyright © 2018 Colorlib. All rights reserved. Template by <a href="https:colorlib.com">Colorlib</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
</body>

<!-- Các tệp script và kết thúc tệp HTML -->
</html>

        <!-- Xác nhận lưu -->
    <script>
        function confirmSave() {
            return confirm("Bạn có chắc chắn muốn lưu thay đổi?");
        }
    </script>
                                                        

    <!-- Jquery JS-->
    <script src="../vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="../vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="../vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- ../Vendor JS -->
    <script src="../vendor/slick/slick.min.js"></script>
    <script src="../vendor/wow/wow.min.js"></script>
    <script src="../vendor/animsition/animsition.min.js"></script>
    <script src="../vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <script src="../vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="../vendor/counter-up/jquery.counterup.min.js"></script>
    <script src="../vendor/circle-progress/circle-progress.min.js"></script>
    <script src="../vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="../vendor/select2/select2.min.js"></script>

    <!-- Main JS-->
    <script src="../js/main.js"></script>
</body>