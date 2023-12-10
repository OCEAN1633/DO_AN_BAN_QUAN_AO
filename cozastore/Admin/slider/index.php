<?php
include('../head.php');
include('../config.php');
?>
<?php
// Truy vấn cơ sở dữ liệu để lấy dữ liệu slider
$query = "SELECT slider_id, title, description, image, status, created_at FROM slider
ORDER BY slider_id DESC";
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
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <h3 class="title-5 m-b-35">Danh sách Slider</h3>
                        <div class="table-data__tool-right">
                            <a href="add.php" class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="zmdi zmdi-plus"></i>add item</a>

                        </div>
                    </div>
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2">
                            <thead>
                                <tr>

                                    <th>id</th>
                                    <th>Tiêu đề</th>
                                    <th>Mô tả</th>
                                    <th>Ảnh</th>
                                    <th>Status</th>
                                    <th>Ngày tạo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr class='tr-shadow'>";
                                    echo "<td>" . $row['slider_id'] . "</td>";
                                    echo "<td>" . $row['title'] . "</td>";
                                    echo "<td>" . $row['description'] . "</td>";
                                    echo "<td><img src='../img/" . $row['image'] . "' alt='Ảnh Slider' width='100px'></td>";
                                    echo "<td>";
                                    echo "<span class='status--process'>" . $row['status'] . "</span>";
                                    echo "</td>";
                                    echo "<td>" . $row['created_at'] . "</td>";
                                    echo "<td>";
                                    echo "<div class='table-data-feature'>";
                                    echo "<a href='edit.php?id=" . $row['slider_id'] . "' class='item' data-toggle='tooltip' data-placement='top' title='Edit'>";
                                    echo "<i class='zmdi zmdi-edit'></i>";
                                    echo "</a>";
                                    echo "<a href='delete.php?id=" . $row['slider_id'] . "' class='item' data-toggle='tooltip' data-placement='top'  title='Delete' onclick='return confirmDelete()'>";
                                    echo "<i class='zmdi zmdi-delete'></i>";
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
        <!-- Xác nhận xóa  -->
        <script>
            function confirmDelete() {
                return confirm("Bạn có chắc chắn muốn xóa sản phẩm này?");
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

</body>