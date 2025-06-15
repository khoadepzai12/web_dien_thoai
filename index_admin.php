<?php
session_start();
include_once 'config/db.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Nếu chưa đăng nhập, chuyển về trang đăng nhập
    exit();
}

$nam_hien_tai = date("Y");

// Doanh thu từng tháng năm hiện tại
$sql_thang = "SELECT MONTH(ngay_dat) as thang, IFNULL(SUM(tong_tien),0) as doanh_thu 
              FROM don_hang 
              WHERE YEAR(ngay_dat) = $nam_hien_tai AND trang_thai='da_giao'
              GROUP BY thang
              ORDER BY thang";
$result_thang = $conn->query($sql_thang);

$doanh_thu_thang = array_fill(1, 12, 0);
while($row = $result_thang->fetch_assoc()) {
    $doanh_thu_thang[(int)$row['thang']] = (float)$row['doanh_thu'];
}

// Số lượng đơn hàng theo trạng thái
$sql_trangthai = "SELECT trang_thai, COUNT(*) as sl FROM don_hang GROUP BY trang_thai";
$result_tt = $conn->query($sql_trangthai);

$donhang_trangthai = [
    'cho_xu_ly' => 0,
    'dang_giao' => 0,
    'da_giao' => 0,
    'huy' => 0
];
while($row = $result_tt->fetch_assoc()) {
    $donhang_trangthai[$row['trang_thai']] = (int)$row['sl'];
}

// Các thống kê tổng quan
$sql_doanhthu = "SELECT IFNULL(SUM(tong_tien),0) AS doanh_thu FROM don_hang WHERE trang_thai = 'da_giao'";
$doanhthu = $conn->query($sql_doanhthu)->fetch_assoc()['doanh_thu'];

$sql_tonkho = "SELECT IFNULL(SUM(so_luong),0) AS ton_kho FROM san_pham";
$tonkho = $conn->query($sql_tonkho)->fetch_assoc()['ton_kho'];

$sql_donhang = "SELECT COUNT(*) AS so_don FROM don_hang";
$sodon = $conn->query($sql_donhang)->fetch_assoc()['so_don'];

// Lấy thông tin người dùng từ session
$user_id = $_SESSION['user_id'];
$sql_user = "SELECT ten_dang_nhap FROM quan_tri_vien WHERE id = $user_id";
$result_user = $conn->query($sql_user);
$user = $result_user->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard</title>
    <link rel="icon" href="images/admin.png" type="image/x-icon" />
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="home.php">TopZone</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index_admin.php">Dashboard</a></li>
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

    <!-- Main Content -->
    <div class="container my-5">
        <h1 class="mb-4 text-center">Dashboard - Thống kê tổng quan cửa hàng</h1>

        <!-- Thống kê nhanh -->
        <div class="row g-4 justify-content-center text-center">
            <div class="col-12 col-md-4">
                <div class="card shadow-sm text-bg-primary p-4">
                    <h2 class="display-4"><?= number_format($doanhthu) ?>₫</h2>
                    <p class="fs-5">Doanh thu đã giao</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card shadow-sm text-bg-success p-4">
                    <h2 class="display-4"><?= number_format($tonkho) ?></h2>
                    <p class="fs-5">Tổng số lượng hàng tồn kho</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card shadow-sm text-bg-warning p-4">
                    <h2 class="display-4"><?= number_format($sodon) ?></h2>
                    <p class="fs-5">Tổng số đơn hàng</p>
                </div>
            </div>
        </div>

        <!-- Biểu đồ -->
        <div class="row mt-5">
            <div class="col-md-6">
                <h4>Doanh thu theo tháng năm <?= $nam_hien_tai ?></h4>
                <canvas id="chartDoanhThu"></canvas>
            </div>
            <div class="col-md-6">
                <h4>Đơn hàng theo trạng thái</h4>
                <canvas id="chartDonHang"></canvas>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle CDN (Popper + Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    // Dữ liệu doanh thu theo tháng
    const doanhThuThang = <?= json_encode(array_values($doanh_thu_thang)) ?>;

    // Labels tháng
    const labelsThang = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];

    // Biểu đồ cột doanh thu theo tháng
    const ctx1 = document.getElementById('chartDoanhThu').getContext('2d');
    const chartDoanhThu = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: labelsThang,
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: doanhThuThang,
                backgroundColor: 'rgba(13,110,253,0.7)',
                borderColor: 'rgba(13,110,253,1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString() + '₫';
                        }
                    }
                }
            },
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Dữ liệu đơn hàng theo trạng thái
    const donHangTrangThai = <?= json_encode(array_values($donhang_trangthai)) ?>;
    const labelsTrangThai = ['Chờ xử lý', 'Đang giao', 'Đã giao', 'Huỷ'];

    // Biểu đồ tròn đơn hàng theo trạng thái
    const ctx2 = document.getElementById('chartDonHang').getContext('2d');
    const chartDonHang = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: labelsTrangThai,
            datasets: [{
                data: donHangTrangThai,
                backgroundColor: [
                    'rgba(255,193,7,0.7)', // vàng
                    'rgba(13,110,253,0.7)', // xanh dương
                    'rgba(25,135,84,0.7)', // xanh lá
                    'rgba(220,53,69,0.7)' // đỏ
                ],
                borderColor: 'white',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
    </script>

</body>

</html>