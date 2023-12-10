<?php
include('config.php');
?>
<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    echo "Bạn chưa đăng nhập!";
} else {
    $user_name = $_SESSION['user_name'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $prod_id = $_POST['prod_id'];
        $cart_number = $_POST['num-product'];
        $size_id = $_POST['time'];

        // Kiểm tra xem prod_id đã có trong bảng cart của người dùng hay chưa
        $check_query = "SELECT * FROM cart WHERE user_name = '$user_name' AND prod_id = '$prod_id'";
        $check_result = $conn->query($check_query);

        if ($check_result->num_rows > 0) {
            $update_query = "UPDATE cart SET cart_number = cart_number + '$cart_number' WHERE user_name = '$user_name' AND prod_id = '$prod_id'AND size_id = '$size_id'";
            if ($conn->query($update_query) === TRUE) {
                echo '<script>window.history.back();</script>';

            } else {
                echo "Lỗi khi cập nhật sản phẩm trong bảng cart: " . $conn->error;
            }
        } else {
            $insert_query = "INSERT INTO cart (user_name, prod_id, cart_number, size_id) VALUES ('$user_name', '$prod_id', '$cart_number','$size_id')";
            if ($conn->query($insert_query) === TRUE) {
                echo '<script>window.history.back();</script>';
            } else {
                echo "Lỗi khi thêm sản phẩm vào bảng cart: " . $conn->error;
            }
        }
    }
} 

?>

