<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM slider WHERE slider_id = $id";
    
    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
    } else {
        // Xóa thất bại, xử lý lỗi tại đây nếu cần
        echo "Xóa thất bại. Lỗi: " . mysqli_error($conn);
    }
}
mysqli_close($conn);
?>