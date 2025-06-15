<?php
$host = 'localhost';          // hoặc 127.0.0.1
$dbname = 'webmobile0906';    // Tên CSDL
$username = 'root';           // Tài khoản MySQL mặc định của XAMPP
$password = '';               // Mặc định XAMPP không có mật khẩu

// Tạo kết nối
$conn = new mysqli($host, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$conn->set_charset("utf8");

?>