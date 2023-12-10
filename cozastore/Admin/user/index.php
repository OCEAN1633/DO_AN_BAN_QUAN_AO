<?php
include('../head.php');
include('../config.php');

// Query to fetch user data
$query = "SELECT * FROM user";
$result = mysqli_query($conn, $query);

?>

<body class="animsition">
    <div class="page-wrapper">
        <?php
        include('../sidebar.php');
        ?>
        <div class="page-container">
            <!-- MAIN CONTENT-->
            <div class="row" style="margin:100px 20px;">

                <div class="col-md-12">
                    <div class="table-data__tool">
                        <h3 class="title-5 m-b-35">Danh sách người dùng</h3>

                    </div>
                    <!-- DATA TABLE-->
                    <div class="table-responsive m-b-40">
                        <table class="table table-borderless table-data3">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên đăng nhập</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày đăng ký</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $statusTag = $row['status_email'] == 'unverified' ? '<span style="color: red;">Chưa xác thực</span>' : '<span style="color: green;">Đã xác thực</span>';
                                    echo "<tr>";
                                    echo "<td>{$row['user_id']}</td>";
                                    echo "<td>{$row['user_name']}</td>";
                                    echo "<td>{$row['user_email']}</td>";
                                    echo "<td>{$row['user_phone']}</td>";
                                    echo "<td>{$statusTag}</td>";
                                    echo "<td>{$row['created_at']}</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- END DATA TABLE-->
                </div>


            </div>
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <!-- ... (remaining scripts) -->

    <!-- Main JS-->
    <script src="js/main.js"></script>

</body>

</html>
<!-- end document-->