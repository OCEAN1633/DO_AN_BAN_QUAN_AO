<?php
include('config.php');

// Kiểm tra xem có mã sản phẩm được truyền từ URL không
if (isset($_GET['cart_id'])) {
    $cart_id = $_GET['cart_id'];
    $query = "DELETE FROM cart WHERE cart_id = $cart_id";
    $result = mysqli_query($conn, $query);
    echo '<script>window.history.back();</script>';
    
} else {
       echo "Không tìm thấy mã giỏ hàng.";
}
mysqli_close($conn);
?>
