<?php
session_start();  // Bắt đầu phiên làm việc
if (!isset($_SESSION['user_id'])) {
    header('Location: dangki.php');  // Nếu chưa đăng nhập, chuyển hướng đến trang đăng ký
    exit();
}
include 'connect.php';  // Kết nối cơ sở dữ liệu
include 'header.php';  // Bao gồm header của trang web

$user_id = $_SESSION['user_id'];  // Lấy ID người dùng từ session

// Lấy thông tin người dùng
$stmt = $conn->prepare("SELECT ho_ten, email FROM khach_hang WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$user = null;
if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    $user = [
        'ho_ten' => '',
        'email' => ''
    ];
}
$stmt->close();

// Lấy lịch sử mua hàng của người dùng
$sql_orders = "SELECT dh.id AS order_id, dh.ngay_dat, dh.tong_tien, dh.trang_thai
               FROM don_hang dh
               WHERE dh.khach_hang_id = ?
               ORDER BY dh.ngay_dat DESC";  // Sắp xếp theo ngày đặt hàng giảm dần
$stmt_orders = $conn->prepare($sql_orders);
$stmt_orders->bind_param("i", $user_id);
$stmt_orders->execute();
$result_orders = $stmt_orders->get_result();
$orders = [];
while ($row = $result_orders->fetch_assoc()) {
    $orders[] = $row;
}
$stmt_orders->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Trang Tài Khoản</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-light py-4">
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header bg-primary text-white">
                <h2 class="h5 mb-0">TRANG TÀI KHOẢN</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Left column: user greeting and navigation -->
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h5 class="mb-3">Xin chào, <?= htmlspecialchars($user['ho_ten']) ?>!</h5>
<div class="list-group">
    <a href="dia_chi.php" class="list-group-item list-group-item-action">Tài khoảng chi tiết</a>
    <a href="doi_mat_khau.php" class="list-group-item list-group-item-action">Đổi mật khẩu</a>
    <a href="logout.php" class="list-group-item list-group-item-action">Đăng xuất</a>
</div>
                    </div>

                    <!-- Right column: user account information -->
                    <div class="col-md-8">
                        <h5 class="mb-3">THÔNG TIN TÀI KHOẢN</h5>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Họ tên:</span>
                                <span class="fw-semibold"><?= htmlspecialchars($user['ho_ten']) ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Email:</span>
                                <span class="fw-semibold"><?= htmlspecialchars($user['email']) ?></span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Section: Lịch sử mua hàng -->
                <div class="mt-4">
                    <h5 class="mb-3">LỊCH SỬ MUA HÀNG</h5>
                    <?php if (!empty($orders)): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Đơn hàng</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>#<?= $order['order_id'] ?></td>
                                <td><?= date('d/m/Y H:i:s', strtotime($order['ngay_dat'])) ?></td>
                                <td><?= number_format($order['tong_tien'], 0, ',', '.') ?>₫</td>
                                <td><?= htmlspecialchars($order['trang_thai']) ?></td>
                                <td><a href="chi_tiet_don_hang.php?don_hang_id=<?= $order['order_id'] ?>"
                                        class="btn btn-info btn-sm">Xem</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <p class="text-muted">Bạn chưa có đơn hàng nào.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper (optional for some components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
include 'fooder1.php';  // Bao gồm footer của trang web
?>