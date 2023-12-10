<?php
session_start();

// Hủy phiên làm việc
session_unset();
session_destroy();

header("Location: login.php"); 
exit;
?>