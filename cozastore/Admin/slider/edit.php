<?php
include('../config.php');
include('../head.php');

// Kiểm tra xem có tham số id được truyền vào từ URL không
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Lấy dữ liệu của item cần chỉnh sửa từ cơ sở dữ liệu
    $sql = "SELECT * FROM slider WHERE slider_id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Nếu item tồn tại, hiển thị nó trong biểu mẫu
        $title = $row['title'];
        $description = $row['description'];
        $image = $row['image'];
        $status = $row['status'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ biểu mẫu
    $newTitle = $_POST['title'];
    $newDescription = $_POST['description'];
    $newStatus = $_POST['status'];

    // Kiểm tra xem có tải lên ảnh mới hay không
    if (!empty($_FILES['image']['name'])) {
        // Xử lý ảnh mới
        $newImage = $_FILES['image']['name'];
        $newImage_temp = $_FILES['image']['tmp_name'];
        move_uploaded_file($newImage_temp, "upload/$newImage");
    } else {
        // Nếu không có ảnh mới, sử dụng ảnh cũ
        $newImage = $image;
    }
    $currentTime = date("Y-m-d H:i:s");
    // Cập nhật dữ liệu vào cơ sở dữ liệu
    $updateSql = "UPDATE slider SET title = '$newTitle', description = '$newDescription',image = '$newImage', status = '$newStatus', created_at = '$currentTime' WHERE slider_id = $id";

    if ($conn->query($updateSql) === TRUE) {
        // Dữ liệu đã được cập nhật thành công
        header("Location: index.php"); // Chuyển hướng đến trang index sau khi lưu
        exit; // Kết thúc kịch bản sau khi chuyển hướng
    } else {
        echo "Lỗi: " . $updateSql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!-- Bắt đầu hiển thị biểu mẫu -->

<body class="animsition">
    <div class="page-wrapper">
        <?php include('../sidebar.php'); ?>
        <div class="page-container">
            <!-- MAIN CONTENT -->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Sửa</strong> Slider
                                    </div>
                                    <div class="card-body card-block">
                                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" onsubmit="return confirmSave()" ;>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class="form-control-label">Tiêu đề</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="title" value="<?php echo $title; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class="form-control-label">Mô tả</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="description" value="<?php echo $description; ?>" class="form-control">
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
                                                            <input type="radio" id="inline-radio1" name="status" value="2" <?php if ($status == 2) echo "checked"; ?> class="form-check-input">Ẩn
                                                        </label>
                                                        <label for="inline-radio2" class="form-check-label">
                                                            <input type="radio" id="inline-radio2" name="status" value="1" <?php if ($status == 1) echo "checked"; ?> class="form-check-input">Hiện
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-dot-circle-o"></i> Submit
                                                </button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Xác nhận lưu -->
    <script>
        function confirmSave() {
            return confirm("Bạn có chắc chắn muốn lưu thay đổi?");
        }
    </script>

    <!-- Jquery JS-->
    <script src="../vendor/jquery-3.2.1.min.js"></script>
    <script src="../vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="../vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="../vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- ../Vendor JS       -->
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