

<?php
    include('../config.php');
    include('../head.php');

    if(isset($_POST['submit'])) {
        // Lấy dữ liệu từ form
        $title = $_POST['title'];
        $description = $_POST['description'];
        $status = $_POST['status'];

        // Xử lý ảnh
        $image = $_FILES['image']['name'];
        $image_temp = $_FILES['image']['tmp_name'];
        move_uploaded_file($image_temp, "upload/$image");

        // Lấy ngày hiện tại
        $created_at = date('Y-m-d H:i:s');

        // Thực hiện câu truy vấn để chèn dữ liệu vào bảng slider
        $sql = "INSERT INTO slider (title, description, image, status, created_at) VALUES ('$title', '$description', '$image', '$status', '$create_at')";

        if (mysqli_query($conn, $sql)) {
            // Nếu chèn thành công, chuyển đến trang index hoặc thông báo thành công
            header("Location: index.php");
        } else {
            // Nếu chèn thất bại, hiển thị thông báo lỗi
            echo "Lỗi: " . $sql . "<br>" . mysqli_error($conn);
        }
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
                                    <strong>Thêm</strong> Slider
                                </div>
                                <div class="card-body card-block">
                                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                        <!-- Giao diện form nhập dữ liệu ở đây -->
                                        <div class="card-body card-block">
                                
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="text-input" class="form-control-label">Tiêu đề</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="text" id="text-input" name="title" placeholder="Nhập tiêu đề" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="text-input" class="form-control-label">Mô tả</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="text" id="text-input" name="description" placeholder="Nhập mô tả" class="form-control">
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
                                            <label class="form-control-label">Trạng thái</label>
                                        </div>
                                        <div class="col col-md-9">
                                            <div class="form-check-inline form-check">
                                                <label for="inline-radio1" class="form-check-label" style="padding-right: 20px;">
                                                    <input type="radio" id="inline-radio1" name="status" value="2" class="form-check-input">Ẩn
                                                </label>
                                                <label for="inline-radio2" class="form-check-label">
                                                    <input type="radio" id="inline-radio2" name="status" value="1" class="form-check-input">Hiện
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" name="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm" onclick="clearForm()">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
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

<script>
function clearForm() {
    document.getElementById("text-input").value = "";
    document.getElementById("file-input").value = "";
    document.getElementById("inline-radio1").checked = false;
    document.getElementById("inline-radio2").checked = false;
}
</script>
     <!-- Jquery JS-->
     <script src="../vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="../vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="../vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="../vendor/slick/slick.min.js">
    </script>
    <script src="../vendor/wow/wow.min.js"></script>
    <script src="../vendor/animsition/animsition.min.js"></script>
    <script src="../vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="../vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="../vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="../vendor/circle-progress/circle-progress.min.js"></script>
    <script src="../vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="../vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="../js/main.js"></script>

</body>

</html>
<!-- end document-->
