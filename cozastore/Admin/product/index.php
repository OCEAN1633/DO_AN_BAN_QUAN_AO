<?php
include('../head.php');
include('../config.php');
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
                    <h3 class="title-5 m-b-35">Danh sách sản phẩm</h3>
                    <div class="table-data__tool-right">
                        <a href="add.php" class="au-btn au-btn-icon au-btn--green au-btn--small">
                            <i class="zmdi zmdi-plus"></i> Thêm sản phẩm</a>
                    </div>
                </div>
                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Thể loại</th>
                                <th>Tiêu đề</th>
                                <th>Mô tả</th>
                                <th>Ảnh</th>
                                <th>Giá</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT product.prod_id, product.prod_name, product.title, product.description, product.prod_image, product.price, category.cat_name
                                FROM product
                                INNER JOIN category ON product.cat_id = category.cat_id
                                ORDER BY product.created_at DESC";
                            $result = mysqli_query($conn, $query);

                            if (!$result) {
                                die("Lỗi truy vấn: " . mysqli_error($conn));
                            }

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr class='tr-shadow'>";
                                echo "<td>" . $row['prod_id'] . "</td>";
                                echo "<td>" . $row['prod_name'] . "</td>";
                                echo "<td>" . $row['cat_name'] . "</td>";
                                echo "<td>" . $row['title'] . "</td>";
                                echo "<td>" . $row['description'] . "</td>";
                                echo "<td><img src='../img/" . $row['prod_image'] . "' alt='Ảnh sản phẩm' width='100px'></td>";
                                echo "<td>" . number_format($row['price']) . "</td>";
                                echo "<td>";
                                echo "<div class='table-data-feature'>";
                                echo "<a href='edit.php?prod_id=" . $row['prod_id'] . "' class='item' data-toggle='tooltip' data-placement='top' title='Edit'>";
                                echo "<i class='zmdi zmdi-edit'></i>";
                                echo "</a>";
                                echo "<a href='delete.php?prod_id=" . $row['prod_id'] . "' class='item' data-toggle='tooltip' data-placement='top' title='Delete' onclick='return confirmDelete()'>";
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
        <script src="../vendor/bootstrap-4.1/popper.min.js"></script>
        <script src="../vendor/bootstrap-4.1/bootstrap.min.js"></script>
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