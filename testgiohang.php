<?php
session_start();
include 'connect.php';
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: dangki.php');  // Nếu chưa đăng nhập, chuyển hướng đến trang đăng ký
    exit();
}

$user_id = $_SESSION['user_id'];

// Cập nhật số lượng sản phẩm nếu được gửi POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cap_nhat_so_luong'])) {
        foreach ($_POST['so_luong'] as $gio_hang_id => $so_luong) {
            $so_luong = max(1, (int)$so_luong); // Không cho nhỏ hơn 1
            $stmt = $conn->prepare("UPDATE gio_hang SET so_luong = ? WHERE id = ? AND khach_hang_id = ?");
            $stmt->bind_param("iii", $so_luong, $gio_hang_id, $user_id);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Xoá sản phẩm
    if (isset($_POST['xoa_id'])) {
        $xoa_id = (int)$_POST['xoa_id'];
        $stmt = $conn->prepare("DELETE FROM gio_hang WHERE id = ? AND khach_hang_id = ?");
        $stmt->bind_param("ii", $xoa_id, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    // Mã giảm giá
    if (isset($_POST['ma_giam_gia'])) {
        $_SESSION['ma_giam_gia'] = trim($_POST['ma_giam_gia']);
    }
}

// Lấy giỏ hàng
$sql = "SELECT gh.id AS gio_hang_id, sp.ten_san_pham, sp.gia, sp.dung_luong, sp.mau_sac, gh.so_luong,
               (sp.gia * gh.so_luong) AS total_price
        FROM gio_hang gh
        JOIN san_pham sp ON gh.san_pham_id = sp.id
        WHERE gh.khach_hang_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$total_cart_value = 0;
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $total_cart_value += $row['total_price'];
}
$stmt->close();

// Kiểm tra mã giảm giá
$giam_phan_tram = 0;
$tong_tien_sau_giam = $total_cart_value;
$ma_ap_dung = $_SESSION['ma_giam_gia'] ?? '';

if ($ma_ap_dung !== '') {
    $sql = "SELECT * FROM ma_giam_gia 
            WHERE ma_code = ? AND trang_thai = 1 AND so_lan_su_dung > da_su_dung 
                  AND CURDATE() BETWEEN ngay_bat_dau AND ngay_ket_thuc
            LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $ma_ap_dung);
    $stmt->execute();
    $res_coupon = $stmt->get_result();
    if ($row = $res_coupon->fetch_assoc()) {
        if ($total_cart_value >= $row['gia_tri_toi_thieu']) {
            $giam_phan_tram = $row['giam_phan_tram'];
            $tong_tien_sau_giam = $total_cart_value * (1 - $giam_phan_tram / 100);
        }
    }
    $stmt->close();
}

// Truy vấn lấy địa chỉ giao hàng của người dùng
$sql_address = "SELECT * FROM dia_chi_giao_hang WHERE khach_hang_id = ?";
$stmt_address = $conn->prepare($sql_address);
$stmt_address->bind_param("i", $user_id);
$stmt_address->execute();
$result_address = $stmt_address->get_result();
$address = $result_address->fetch_assoc(); // Lấy địa chỉ đầu tiên nếu có
$stmt_address->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light py-4">
    <div class="container">
        <h2 class="text-center mb-4">🛒 Giỏ Hàng Của Bạn</h2>

        <?php if (!empty($cart_items)): ?>
        <form method="post">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Dung lượng</th>
                        <th>Màu sắc</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng tiền</th>
                        <th>Xoá</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['ten_san_pham']) ?></td>
                        <td><?= htmlspecialchars($item['dung_luong']) ?></td>
                        <td><?= htmlspecialchars($item['mau_sac']) ?></td>
                        <td><?= number_format($item['gia']) ?>₫</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                <input type="number" name="so_luong[<?= $item['gio_hang_id'] ?>]"
                                    value="<?= $item['so_luong'] ?>" min="1" class="form-control text-center w-25 me-2">
                                <button type="submit" name="cap_nhat_so_luong" class="btn btn-sm btn-primary">Cập
                                    nhật</button>
                            </div>
                        </td>
                        <td><?= number_format($item['total_price']) ?>₫</td>
                        <td>
                            <button type="submit" name="xoa_id" value="<?= $item['gio_hang_id'] ?>"
                                class="btn btn-sm btn-danger">🗑️</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Nhập mã giảm giá -->
            <div class="row mt-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nhập mã giảm giá:</label>
                    <div class="input-group">
                        <input type="text" name="ma_giam_gia" class="form-control" placeholder="Nhập mã..."
                            value="<?= htmlspecialchars($ma_ap_dung) ?>">
                        <button class="btn btn-primary" type="submit">Áp dụng</button>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <button type="submit" name="cap_nhat_so_luong" class="btn btn-outline-dark">Cập nhật số
                        lượng</button>
                </div>
            </div>

            <!-- Tổng cộng -->
            <div class="mt-4">
                <?php if ($giam_phan_tram > 0): ?>
                <p>Áp dụng mã: <strong class="text-success"><?= htmlspecialchars($ma_ap_dung) ?></strong>
                    (<?= $giam_phan_tram ?>%)</p>
                <h4 class="text-success">Tổng tiền sau giảm: <?= number_format($tong_tien_sau_giam, 0, ',', '.') ?>₫
                </h4>
                <?php else: ?>
                <h4>Tổng cộng: <?= number_format($total_cart_value, 0, ',', '.') ?>₫</h4>
                <?php endif; ?>
            </div>



            <!-- Cột phải: Địa chỉ giao hàng và phương thức thanh toán -->
            <div class="col-md-6">
                <h4>Thông Tin Giao Hàng</h4>
                <?php if ($address): ?>
                <p><strong>Người nhận: </strong><?= htmlspecialchars($address['ten_nguoi_nhan']) ?></p>
                <p><strong>Địa chỉ: </strong><?= htmlspecialchars($address['dia_chi']) ?></p>
                <p><strong>Số điện thoại: </strong><?= htmlspecialchars($address['so_dien_thoai']) ?></p>
                <?php else: ?>
                <p>Chưa có địa chỉ giao hàng. <a href="dia_chi.php">Thêm địa chỉ giao hàng</a></p>
                <?php endif; ?>

                <h5 class="mt-4">💳 Chọn hình thức thanh toán:</h5>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="hinh_thuc_thanh_toan" id="cod" value="COD"
                        checked>
                    <label class="form-check-label" for="cod">Thanh toán khi nhận hàng (COD)</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="hinh_thuc_thanh_toan" id="bank"
                        value="Chuyen_khoan">
                    <label class="form-check-label" for="bank">Chuyển khoản ngân hàng</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="hinh_thuc_thanh_toan" id="vnpay" value="VNPay">
                    <label class="form-check-label" for="vnpay">Thanh toán bằng VNPay</label>
                </div>

                <!-- Hiển thị thêm QR code và ghi chú cho VNPay và Chuyển khoản ngân hàng -->
                <div id="payment-details" class="mt-4" style="display:none;">
                    <div id="qr-vnpay" style="display:none;">
                        <h6 class="mb-2">QR Code thanh toán VNPay:</h6>
                        <img src="img/qrvnpay.jpg" alt="VNPay QR Code" class="img-fluid" style="max-width: 150px;">
                        <p class="mt-2">Vui lòng quét QR để thanh toán qua VNPay.</p>
                    </div>
                    <div id="bank-transfer" style="display:none;">
                        <h6 class="mb-2">Chuyển khoản ngân hàng:</h6>
                        <p>Vui lòng chuyển khoản vào tài khoản ngân hàng sau:</p>
                        <img src="img/qr.jpg" alt="VNPay QR Code" class="img-fluid" style="max-width: 150px;">
                        <p><strong>Số tài khoản:</strong> 009070809</p>
                        <p><strong>Ngân hàng:</strong> MB Bank</p>
                        <p><strong>Chủ tài khoản:</strong> Top Zone</p>
                    </div>
                </div>
            </div>
    </div>

    <div class="d-flex justify-content-center">
        <a href="thanh_toan.php" class="btn btn-success btn-lg mt-4">💳 Thanh toán</a>
    </div>
    </form>
    <?php else: ?>
    <p class="text-center text-muted">Giỏ hàng của bạn đang trống.</p>
    <?php endif; ?>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
const codRadio = document.getElementById('cod');
const bankRadio = document.getElementById('bank');
const vnpayRadio = document.getElementById('vnpay');
const paymentDetails = document.getElementById('payment-details');
const qrVnpay = document.getElementById('qr-vnpay');
const bankTransfer = document.getElementById('bank-transfer');

// Lắng nghe thay đổi phương thức thanh toán
codRadio.addEventListener('change', togglePaymentDetails);
bankRadio.addEventListener('change', togglePaymentDetails);
vnpayRadio.addEventListener('change', togglePaymentDetails);

function togglePaymentDetails() {
    paymentDetails.style.display = "block";
    qrVnpay.style.display = vnpayRadio.checked ? "block" : "none";
    bankTransfer.style.display = bankRadio.checked ? "block" : "none";
}

// Mặc định hiển thị phương thức COD
togglePaymentDetails();
</script>

</html>