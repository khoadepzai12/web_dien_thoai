<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Chuyển hướng về trang đăng nhập nếu chưa đăng nhập
    exit();
}

// Lấy thông tin tài khoản từ cơ sở dữ liệu
include_once 'config/db.php';
$user_id = $_SESSION['user_id'];

if ($_SESSION['role'] == 'admin') {
    $sql = "SELECT * FROM quan_tri_vien WHERE id = $user_id";
} else {
    $sql = "SELECT * FROM nhan_vien WHERE id = $user_id";
}

$result = $conn->query($sql);

if ($result === false) {
    die("Lỗi truy vấn: " . $conn->error);  // Kiểm tra nếu truy vấn không thành công
}

$user = $result->fetch_assoc();

// Kiểm tra vai trò của người dùng (admin or nhân viên)
if ($_SESSION['role'] == 'admin') {
    $role_sql = "SELECT * FROM vai_tro WHERE id = " . $user['vai_tro_id'];
    $role_result = $conn->query($role_sql);

    if ($role_result === false) {
        die("Lỗi truy vấn vai trò: " . $conn->error);  // Kiểm tra nếu truy vấn không thành công
    }

    $role = $role_result->fetch_assoc();
    $role_name = $role ? $role['ten_vai_tro'] : 'Chưa xác định';
} else {
    $role_name = 'Nhân viên';
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Thông tin tài khoản</title>
    <link rel="icon" href="images/admin.png" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Điện thoại Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="sanpham/index.php">Sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="baiviet/index.php">Bài viết</a></li>
                    <li class="nav-item"><a class="nav-link" href="donhang/index.php">Đơn hàng</a></li>
                    <li class="nav-item"><a class="nav-link" href="khachhang/index.php">Khách hàng</a></li>
                    <li class="nav-item"><a class="nav-link" href="nhanvien/index.php">Nhân viên</a></li>
                    <li class="nav-item"><a class="nav-link" href="giamgia/index.php">Mã giảm giá</a></li>
                    <li class="nav-item"><a class="nav-link" href="baohanh/index.php">Bảo hành</a></li>
                    <li class="nav-item"><a class="nav-link" href="profile.php">Tài khoản</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Đăng xuất</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Thông tin tài khoản -->
    <div class="container my-5">
        <h1 class="mb-4 text-center">Thông tin tài khoản</h1>

        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card shadow-sm p-4">
                    <h3 class="card-title">Thông tin cá nhân</h3>
                    <!--<p><strong>Tên đăng nhập:</strong> <?= $user['ten_dang_nhap'] ?></p>-->
                    <p><strong>Email công ty:</strong>
                        <?= isset($user['email_cong_ty']) ? $user['email_cong_ty'] : 'Chưa có email' ?></p>
                    <p><strong>Vai trò:</strong> <?= $role_name ?></p>
                    <p><strong>Số điện thoại:</strong>
                        <?= isset($user['sdt']) ? $user['sdt'] : 'Chưa có số điện thoại' ?></p>
                    <a href="index.php" class="btn btn-primary">Trở về Dashboard</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle CDN (Popper + Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>