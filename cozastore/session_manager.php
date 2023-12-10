<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra đăng nhập và thiết lập các biến session tại đây
// ...
if (isset($_SESSION['user_name'])) {
    $isLoggedIn = true;
} else {
    $isLoggedIn = false;
}
?>
