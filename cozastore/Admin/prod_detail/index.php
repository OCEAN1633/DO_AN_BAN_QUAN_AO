<?php
include('../head.php');
include('../config.php');
?>

<?php
// Lấy dữ liệu trạng thái duyệt từ danh sách trạng thái
$statuses = array('Tất cả', 'Còn hàng', 'Hết hàng');

// Xử lý việc chọn trạng thái
if (isset($_GET['status'])) {
    $selectedStatus = $_GET['status'];
    if ($selectedStatus == 'Tất cả') {
        $statusCondition = ""; // Hiển thị tất cả trạng thái
    } else {
        $statusCondition = "AND pd.number " . ($selectedStatus == 'Còn hàng' ? '>' : '<=') . " 0";
    }
} else {
    $selectedStatus = 'Tất cả';
    $statusCondition = ""; // Hiển thị tất cả trạng thái nếu không chọn
}

// Truy vấn cơ sở dữ liệu để lấy dữ liệu từ bảng prod_detail, product và size với điều kiện trạng thái
$query = "SELECT pd.detail_id, p.prod_name, s.size_name, pd.number, CASE WHEN pd.number <= 0 THEN 'Hết hàng' ELSE 'Còn hàng' END AS status, p.prod_image
          FROM prod_detail pd
          INNER JOIN product p ON pd.prod_id = p.prod_id
          INNER JOIN size s ON pd.size_id = s.size_id
          WHERE 1 $statusCondition
          ORDER BY pd.detail_id DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}
if (isset($_GET['success'])) {
    if ($_GET['success'] == 1) {
        echo '<div class="alert alert-success">Xóa thành công!</div>';
    } else {
        echo '<div class="alert alert-danger">Xóa thất bại! Vui lòng thử lại.</div>';
    }
}
?>

<body class="animsition">
    <div class="page-wrapper">
        <?php
        include('../sidebar.php');
        ?>
        <div class="page-container">
        <div class="row" style="margin:100px 20px;">
            <div class="col-md-12">
                <h3 class="title-5 m-b-35">Kho hàng</h3>
                <!-- DATA TABLE -->
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="filter-dropdown">
                            <form action="" method="GET">
                                <div class="rs-select2--light rs-select2--sm">
                                    <select class="js-select2" name="status">
                                        <?php
                                        foreach ($statuses as $status) {
                                            $selected = ($status == $selectedStatus) ? 'selected' : '';
                                            echo "<option value='$status' $selected>$status</option>";
                                        }
                                        ?>
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                </div>
                                <button type="submit" class="btn btn-primary">Lọc</button>
                            </form>
                        </div>
                    </div>

                    <div class="table-data__tool-right">
                        <a href="add.php" class="au-btn au-btn-icon au-btn--green au-btn--small">
                            <i class="zmdi zmdi-plus"></i>Thêm sản phẩm</a>
                    </div>
                </div>
                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th>ID </th>
                                <th>Sản phẩm</th>
                                <th>Ảnh sản phẩm</th>
                                <th>Size</th>
                                <th>Số lượng</th>
                                <th>Trạng thái</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr class='tr-shadow'>";
                                echo "<td>" . $row['detail_id'] . "</td>";
                                echo "<td>" . $row['prod_name'] . "</td>";
                                echo "<td><img src='../img/" . $row['prod_image'] . "' alt='Ảnh sản phẩm' width='100px'></td>";
                                echo "<td>" . $row['size_name'] . "</td>";
                                echo "<td>" . $row['number'] . "</td>";
                                if ($row['status'] == 'Còn hàng') {
                                    echo "<td class='text-success'>" . $row['status'] . "</td>";
                                } else {
                                    echo "<td class='text-danger'>" . $row['status'] . "</td>";
                                }
                                echo "<td>";
                                
                                echo "<div class='table-data-feature'>";
                                
                                echo "<a href='edit.php?detail_id=" . $row['detail_id'] . "' class='item' data-toggle='tooltip' data-placement='top' title='Edit'>";
                                echo "<i class='zmdi zmdi-edit'></i>";
                                echo "</a>";
                                
                                echo "</div>";
                                echo "</td>";
                                echo "</tr>";
                                echo "<tr class='spacer'></tr>";
                            }
                            mysqli_close($conn);
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- END DATA TABLE -->
            </div>
        </div>
        </div>
        <style>
            .filter-dropdown {
                display: flex;
                align-items: center;
            }

            .filter-dropdown form {
                display: flex;
                align-items: center;
            }

            .filter-dropdown .js-select2 {
                margin-right: 10px;
            }
        </style>

        <!-- Thêm JavaScript để gửi yêu cầu Ajax và cập nhật số lượng  -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript">
            function updateQuantity(detail_id) {
                var newQuantity = $("#quantity_" + detail_id).val();
                if (newQuantity >= 0) {
                    $.ajax({
                        type: "POST",
                        url: "update_quantity.php", // Tạo tệp PHP xử lý cập nhật số lượng
                        data: {
                            detail_id: detail_id,
                            new_quantity: newQuantity
                        },
                        success: function(data) {
                            if (data == "success") {
                                alert("Cập nhật số lượng thành công.");
                            } else {
                                alert("Lỗi: Không thể cập nhật số lượng.");
                            }
                        }
                    });
                } else {
                    alert("Số lượng không được âm.");
                }
            }
        </script>
        <!-- Jquery JS-->
        <script src="../vendor/jquery-3.2.1.min.js"></script>
        <script src="../vendor/jquery-3.2.1.min.js"></script>
        <!-- Bootstrap JS-->
        <script src="../vendor/bootstrap-4.1/popper.min.js"></script>
        <script src="../vendor/bootstrap-4.1/bootstrap.min.js"></script>
        <!-- ../Vendor JS       -->
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

    </div>
</body>