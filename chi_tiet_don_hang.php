<?php
session_start();  // Bắt đầu phiên làm việc
if (!isset($_SESSION['user_id'])) {
    header('Location: dangki.php');  // Nếu chưa đăng nhập, chuyển hướng đến trang đăng ký
    exit();
}

include 'connect.php';  // Kết nối cơ sở dữ liệu
include 'header.php';  // Bao gồm header của trang web

$user_id = $_SESSION['user_id'];  // Lấy ID người dùng từ session

// Kiểm tra nếu có don_hang_id trong URL
if (isset($_GET['don_hang_id'])) {
    $order_id = (int)$_GET['don_hang_id'];  // Lấy ID đơn hàng từ URL
} else {
    // Nếu không có, chuyển hướng về trang tài khoản
    header('Location: taikhoan.php');
    exit();
}

// Lấy thông tin đơn hàng
$sql_order = "SELECT dh.id AS order_id, dh.ngay_dat, dh.tong_tien, dh.trang_thai, dh.hinh_thuc_thanh_toan, dh.dia_chi_giao_hang_id,
                     dc.dia_chi, dc.ten_nguoi_nhan, dc.so_dien_thoai
              FROM don_hang dh
              LEFT JOIN dia_chi_giao_hang dc ON dh.dia_chi_giao_hang_id = dc.id
              WHERE dh.id = ? AND dh.khach_hang_id = ?";  // Kiểm tra quyền truy cập của người dùng
$stmt_order = $conn->prepare($sql_order);
$stmt_order->bind_param("ii", $order_id, $user_id);
$stmt_order->execute();
$result_order = $stmt_order->get_result();
$order = null;

if ($result_order && $result_order->num_rows === 1) {
    $order = $result_order->fetch_assoc();  // Lấy thông tin đơn hàng
} else {
    echo "Không tìm thấy đơn hàng này.";
    exit();
}
$stmt_order->close();

// Lấy chi tiết đơn hàng (sản phẩm trong đơn hàng)
$sql_details = "SELECT sp.ten_san_pham, sp.gia, sp.dung_luong, sp.mau_sac, ctdh.so_luong, (sp.gia * ctdh.so_luong) AS total_price
                FROM chi_tiet_don_hang ctdh
                JOIN san_pham sp ON ctdh.san_pham_id = sp.id
                WHERE ctdh.don_hang_id = ?";
$stmt_details = $conn->prepare($sql_details);
$stmt_details->bind_param("i", $order_id);
$stmt_details->execute();
$result_details = $stmt_details->get_result();
$products = [];

while ($row = $result_details->fetch_assoc()) {
    $products[] = $row;  // Lấy danh sách các sản phẩm trong đơn hàng
}
$stmt_details->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chi tiết đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light py-4">
    <div class="container">
        <h2 class="text-center mb-4">Chi Tiết Đơn Hàng #<?= $order['order_id'] ?></h2>

        <!-- Thông tin đơn hàng -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Thông Tin Đơn Hàng</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Ngày đặt:</span>
                        <span class="fw-semibold"><?= date('d/m/Y H:i:s', strtotime($order['ngay_dat'])) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Tổng tiền:</span>
                        <span class="fw-semibold"><?= number_format($order['tong_tien'], 0, ',', '.') ?>₫</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Trạng thái:</span>
                        <span class="fw-semibold"><?= htmlspecialchars($order['trang_thai']) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Hình thức thanh toán:</span>
                        <span class="fw-semibold"><?= htmlspecialchars($order['hinh_thuc_thanh_toan']) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Địa chỉ giao hàng:</span>
                        <span class="fw-semibold"><?= htmlspecialchars($order['ten_nguoi_nhan']) ?>,
                            <?= htmlspecialchars($order['dia_chi']) ?>,
                            <?= htmlspecialchars($order['so_dien_thoai']) ?></span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Sản phẩm trong đơn hàng -->
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Danh Sách Sản Phẩm</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($products)): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Dung lượng</th>
                            <th>Màu sắc</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= htmlspecialchars($product['ten_san_pham']) ?></td>
                            <td><?= htmlspecialchars($product['dung_luong']) ?></td>
                            <td><?= htmlspecialchars($product['mau_sac']) ?></td>
                            <td><?= number_format($product['gia'], 0, ',', '.') ?>₫</td>
                            <td><?= $product['so_luong'] ?></td>
                            <td><?= number_format($product['total_price'], 0, ',', '.') ?>₫</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p class="text-muted">Không có sản phẩm nào trong đơn hàng này.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-4 text-center">
            <a href="thong_tin_tai_khoan.php" class="btn btn-primary">Quay lại trang tài khoản</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>