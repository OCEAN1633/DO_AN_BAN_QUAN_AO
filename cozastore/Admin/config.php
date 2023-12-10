<?php
$host = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "storecoza"; 
// Kết nối đến cơ sở dữ liệu
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Không thể kết nối đến cơ sở dữ liệu: " . mysqli_connect_error());
}