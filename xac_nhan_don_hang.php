<?php
session_start();  // Bắt đầu phiên làm việc

include 'connect.php';  // Kết nối cơ sở dữ liệu
include 'header.php';  // Bao gồm header của trang web

// Kiểm tra xem người dùng có đăng nhập hay không
if (!isset($_SESSION['user_id'])) {
    header('Location: dangki.php');  // Nếu chưa đăng nhập, chuyển hướng đến trang đăng ký
    exit();
}

$user_id = $_SESSION['user_id'];  // Lấy ID người dùng từ session

// Lấy ID đơn hàng từ URL
$order_id = isset($_GET['don_hang_id']) ? (int)$_GET['don_hang_id'] : 0;

// Kiểm tra xem đơn hàng có tồn tại trong cơ sở dữ liệu không
if ($order_id > 0) {
    // Lấy thông tin đơn hàng
    $sql_order = "SELECT * FROM don_hang WHERE id = ? AND khach_hang_id = ?";
    $stmt = $conn->prepare($sql_order);
    $stmt->bind_param("ii", $order_id, $user_id);  // Liên kết tham số với câu lệnh
    $stmt->execute();
    $result_order = $stmt->get_result();
    $order = $result_order->fetch_assoc();
    $stmt->close();

    if (!$order) {
        header('Location: index.php');  // Nếu đơn hàng không tồn tại hoặc không phải của người dùng, chuyển hướng về trang chủ
        exit();
    }

    // Lấy các chi tiết đơn hàng
    $sql_details = "SELECT ctdh.*, sp.ten_san_pham, sp.gia, sp.dung_luong, sp.mau_sac 
                    FROM chi_tiet_don_hang ctdh
                    JOIN san_pham sp ON ctdh.san_pham_id = sp.id
                    WHERE ctdh.don_hang_id = ?";
    $stmt_details = $conn->prepare($sql_details);
    $stmt_details->bind_param("i", $order_id);
    $stmt_details->execute();
    $result_details = $stmt_details->get_result();
    $order_details = [];
    while ($row = $result_details->fetch_assoc()) {
        $order_details[] = $row;
    }
    $stmt_details->close();
} else {
    header('Location: index.php');  // Nếu không có ID đơn hàng hợp lệ, chuyển hướng về trang chủ
    exit();
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light py-4">
    <div class="container">
        <h2 class="text-center mb-4">Xác Nhận Đơn Hàng</h2>

        <div class="card mb-4">
            <div class="card-header">
                <h5>Thông tin đơn hàng #<?= $order['id'] ?></h5>
            </div>
            <div class="card-body">
                <p><strong>Ngày đặt:</strong> <?= date("d-m-Y H:i", strtotime($order['ngay_dat'])) ?></p>
                <p><strong>Trạng thái:</strong>
                    <?= $order['trang_thai'] == 'cho_xu_ly' ? 'Chờ xử lý' : ($order['trang_thai'] == 'dang_giao' ? 'Đang giao' : 'Đã giao') ?>
                </p>
                <p><strong>Phương thức thanh toán:</strong>
                    <?= $order['hinh_thuc_thanh_toan'] == 'COD' ? 'Thanh toán khi nhận hàng' : ($order['hinh_thuc_thanh_toan'] == 'Chuyen_khoan' ? 'Chuyển khoản ngân hàng' : 'VNPay') ?>
                </p>
                <p><strong>Tổng tiền:</strong> <?= number_format($order['tong_tien'], 0, ',', '.') ?>₫</p>
                <p><strong>Trạng thái thanh toán:</strong>
                    <?= $order['trang_thai_thanh_toan'] == 'chua_thanh_toan' ? 'Chưa thanh toán' : 'Đã thanh toán' ?>
                </p>
            </div>
        </div>

        <h5 class="mb-3">Chi tiết sản phẩm trong đơn hàng:</h5>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Sản phẩm</th>
                    <th>Dung lượng</th>
                    <th>Màu sắc</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_details as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['ten_san_pham']) ?></td>
                    <td><?= htmlspecialchars($item['dung_luong']) ?></td>
                    <td><?= htmlspecialchars($item['mau_sac']) ?></td>
                    <td><?= number_format($item['gia'], 0, ',', '.') ?>₫</td>
                    <td><?= $item['so_luong'] ?></td>
                    <td><?= number_format($item['gia'] * $item['so_luong'], 0, ',', '.') ?>₫</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-center mt-4">
            <a href="home.php" class="btn btn-primary">Tiếp tục mua sắm</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>