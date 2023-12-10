<?php
include('../config.php');

// Kiểm tra xem có mã sản phẩm được truyền từ URL không
if (isset($_GET['prod_id'])) {
    $prod_id = $_GET['prod_id'];
    $query = "DELETE FROM product WHERE prod_id = $prod_id";
    $result = mysqli_query($conn, $query);
    if ($result) {
        header('Location: index.php');
        exit();
    } else {
        echo "Xóa sản phẩm thất bại: " . mysqli_error($conn);
    }
} else {
       echo "Không tìm thấy mã sản phẩm.";
}
mysqli_close($conn);
?>
