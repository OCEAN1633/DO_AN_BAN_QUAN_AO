<?php
include('../config.php');
include('../head.php');

$errorMessage = "";
if (isset($_POST['submit'])) {
    $detail_id = $_POST['detail_id'];
    $number = $_POST['number'];
    
    // Check if the number is negative
    if ($number < 0) {
        $errorMessage = "Số lượng không được âm.";
    } else {
        // Update the quantity (number) for the product detail
        $updateSQL = "UPDATE prod_detail SET number = $number WHERE detail_id = $detail_id";
        if (mysqli_query($conn, $updateSQL)) {
            header("Location: index.php");
        } else {
            echo "Error: " . $updateSQL . "<br>" . mysqli_error($conn);
        }
    }
}

if (isset($_GET['detail_id'])) {
    $detail_id = $_GET['detail_id'];
    $selectSQL = "SELECT pd.detail_id, p.prod_name, s.size_name, pd.number, CASE WHEN pd.number <= 0 THEN 'Hết hàng' ELSE 'Còn hàng' END AS status
                  FROM prod_detail pd
                  JOIN product p ON pd.prod_id = p.prod_id
                  JOIN size s ON pd.size_id = s.size_id
                  WHERE pd.detail_id = $detail_id";
    $result = mysqli_query($conn, $selectSQL);
    $row = mysqli_fetch_assoc($result);
} else {
    exit("Product Detail ID not specified.");
}
?>

<body class="animsition">
    <div class="page-wrapper">
        <?php
        include('../sidebar.php');
        ?>
        <div class="page-container">

        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Chỉnh sửa</strong> Chi tiết sản phẩm
                                </div>
                                <div class="card-body card-block">
                                    <form action="" method="post" class="form-horizontal" onsubmit="return confirmSave();">
                                        <input type="hidden" name="detail_id" value="<?php echo $row['detail_id']; ?>">
                                        <div class="card-body card-block">
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="prod_name" class="form-control-label">Tên sản phẩm</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="prod_name" name="prod_name" value="<?php echo $row['prod_name']; ?>" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="size_name" class="form-control-label">Size</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="size_name" name="size_name" value="<?php echo $row['size_name']; ?>" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="number" class="form-control-label">Số lượng</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="number" id="number" name="number" value="<?php echo $row['number']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="status" class="form-control-label">Trạng thái</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="status" name="status" value="<?php echo $row['status']; ?>" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                
                                                <?php if (!empty($errorMessage)) : ?>
                                                    <div class="alert alert-danger" role="alert">
                                                        <?php echo $errorMessage; ?>
                                                    </div>
                                                <?php elseif (!empty($successMessage)) : ?>
                                                    <div class="alert alert-success" role="alert">
                                                        <?php echo $successMessage; ?>
                                                    </div>
                                                <?php endif; ?>

                                                <button type="submit" name="submit" class="btn btn-primary btn-sm">
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
