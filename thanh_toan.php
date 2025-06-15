<?php
session_start();  // Bắt đầu phiên làm việc
ob_start();  // Bật output buffering

include 'connect.php';  // Kết nối cơ sở dữ liệu
include 'header.php';  // Bao gồm header của trang web

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header('Location: dangki.php');  // Nếu chưa đăng nhập, chuyển hướng đến trang đăng ký
    exit();
}

$user_id = $_SESSION['user_id'];  // Lấy ID người dùng từ session
$error_message = '';  // Khởi tạo biến lỗi
$success_message = '';  // Khởi tạo biến thông báo thành công

// Hàm để xóa các ký tự thừa và bảo vệ dữ liệu khỏi các tấn công XSS
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Hàm cập nhật số lượng sản phẩm trong giỏ hàng
function updateCartQuantities($conn, $user_id, $quantities) {
    $success = true;  // Biến theo dõi trạng thái thành công
    foreach ($quantities as $cart_id => $quantity) {
        $quantity = max(1, (int)$quantity);  // Đảm bảo số lượng không nhỏ hơn 1
        $stmt = $conn->prepare("UPDATE gio_hang SET so_luong = ? WHERE id = ? AND khach_hang_id = ?");
        if ($stmt) {
            $stmt->bind_param("iii", $quantity, $cart_id, $user_id);  // Liên kết tham số với câu lệnh SQL
            $success = $success && $stmt->execute();  // Thực thi câu lệnh và kiểm tra thành công
            $stmt->close();  // Đóng câu lệnh sau khi thực thi
        } else {
            $success = false;  // Nếu không thực thi được, trả về false
        }
    }
    return $success;
}

// Hàm xóa sản phẩm khỏi giỏ hàng
function removeCartItem($conn, $user_id, $cart_id) {
    $stmt = $conn->prepare("DELETE FROM gio_hang WHERE id = ? AND khach_hang_id = ?");
    if ($stmt) {
        $stmt->bind_param("ii", $cart_id, $user_id);  // Liên kết tham số
        $result = $stmt->execute();  // Thực thi câu lệnh
        $stmt->close();  // Đóng câu lệnh
        return $result;  // Trả về kết quả
    }
    return false;  // Nếu không có kết quả, trả về false
}

// Hàm lấy các sản phẩm trong giỏ hàng của người dùng
function getCartItems($conn, $user_id) {
    $sql = "SELECT gh.id AS gio_hang_id, sp.ten_san_pham, sp.gia, sp.dung_luong, sp.mau_sac, gh.so_luong,
                   (sp.gia * gh.so_luong) AS total_price, gh.san_pham_id
            FROM gio_hang gh
            JOIN san_pham sp ON gh.san_pham_id = sp.id
            WHERE gh.khach_hang_id = ?";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) return [];  // Nếu không thể tạo câu lệnh, trả về mảng rỗng
    
    $stmt->bind_param("i", $user_id);  // Liên kết tham số
    $stmt->execute();  // Thực thi câu lệnh
    $result = $stmt->get_result();  // Lấy kết quả từ câu lệnh

    $cart_items = [];  // Khởi tạo mảng giỏ hàng
    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row;  // Thêm sản phẩm vào mảng giỏ hàng
    }
    $stmt->close();  // Đóng câu lệnh
    return $cart_items;  // Trả về mảng sản phẩm trong giỏ hàng
}

// Hàm kiểm tra mã giảm giá
function validateDiscountCode($conn, $code, $cart_total) {
    $sql = "SELECT * FROM ma_giam_gia 
            WHERE ma_code = ? AND trang_thai = 1 AND so_lan_su_dung > da_su_dung 
                  AND CURDATE() BETWEEN ngay_bat_dau AND ngay_ket_thuc
            LIMIT 1";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) return ['valid' => false, 'discount' => 0];  // Nếu không thể chuẩn bị câu lệnh, trả về mã giảm giá không hợp lệ
    
    $stmt->bind_param("s", $code);  // Liên kết mã giảm giá
    $stmt->execute();  // Thực thi câu lệnh
    $result = $stmt->get_result();  // Lấy kết quả từ câu lệnh
    
    if ($row = $result->fetch_assoc()) {
        if ($cart_total >= $row['gia_tri_toi_thieu']) {
            $stmt->close();  // Đóng câu lệnh
            return ['valid' => true, 'discount' => $row['giam_phan_tram'], 'data' => $row];  // Trả về thông tin giảm giá
        }
    }
    $stmt->close();  // Đóng câu lệnh
    return ['valid' => false, 'discount' => 0];  // Nếu không hợp lệ, trả về mã giảm giá không hợp lệ
}

// Hàm lấy địa chỉ giao hàng của người dùng
function getUserAddresses($conn, $user_id) {
    $sql = "SELECT * FROM dia_chi_giao_hang WHERE khach_hang_id = ? ORDER BY id ASC";
    $stmt = $conn->prepare($sql);
    if (!$stmt) return [];  // Nếu không thể lấy dữ liệu, trả về mảng rỗng
    
    $stmt->bind_param("i", $user_id);  // Liên kết tham số
    $stmt->execute();  // Thực thi câu lệnh
    $result = $stmt->get_result();  // Lấy kết quả từ câu lệnh
    
    $addresses = [];  // Khởi tạo mảng địa chỉ
    while ($row = $result->fetch_assoc()) {
        $addresses[] = $row;  // Thêm địa chỉ vào mảng
    }
    $stmt->close();  // Đóng câu lệnh
    return $addresses;  // Trả về mảng địa chỉ
}

// Hàm tạo đơn hàng mới
function createOrder($conn, $user_id, $total_amount, $payment_method, $address_id, $cart_items) {
    // Bắt đầu giao dịch
    $conn->begin_transaction();
    
    try {
        // Kiểm tra nếu $final_total là NULL, thay thế bằng 0
        if ($total_amount === NULL) {
            $total_amount = 0;
        }

        // Tạo câu lệnh SQL để thêm đơn hàng
$sql = "INSERT INTO don_hang (khach_hang_id, tong_tien, hinh_thuc_thanh_toan, trang_thai, ngay_dat) 
        VALUES (?, ?, ?, 'cho_xu_ly', NOW())";

// Tạo đối tượng statement
$stmt = $conn->prepare($sql);
if (!$stmt) {
    error_log("Lỗi khi chuẩn bị câu lệnh SQL: " . $conn->error);  // Ghi lại lỗi chi tiết
    die("Không thể chuẩn bị câu lệnh tạo đơn hàng");
}

// Liên kết các tham số vào câu lệnh SQL
$stmt->bind_param("ids", $user_id, $final_total, $payment_method);  

// Kiểm tra nếu không thể thực thi câu lệnh
if (!$stmt->execute()) {
    error_log("Lỗi khi thực thi câu lệnh SQL: " . $stmt->error);  // Ghi lại lỗi chi tiết khi thực thi
    die("Không thể tạo đơn hàng");
} 

$order_id = $stmt->insert_id;  // Lấy id của đơn hàng vừa tạo
$stmt->close();  // Đóng câu lệnh sau khi thực thi

// Tiến hành các bước tiếp theo (chèn chi tiết đơn hàng, xóa giỏ hàng, v.v.)


        // Tạo chi tiết đơn hàng
        $sql_detail = "INSERT INTO chi_tiet_don_hang (don_hang_id, san_pham_id, so_luong, gia) VALUES (?, ?, ?, ?)";
        $stmt_detail = $conn->prepare($sql_detail);
        if (!$stmt_detail) {
            error_log("Lỗi khi chuẩn bị câu lệnh chi tiết đơn hàng: " . $conn->error);  // Ghi lại lỗi chi tiết
            die("Không thể chuẩn bị câu lệnh chi tiết đơn hàng");
        }

        foreach ($cart_items as $item) {
            $stmt_detail->bind_param("iiid", $order_id, $item['san_pham_id'], $item['so_luong'], $item['gia']);
            if (!$stmt_detail->execute()) {
                error_log("Lỗi khi thực thi câu lệnh chi tiết đơn hàng: " . $stmt_detail->error);  // Ghi lại lỗi chi tiết
                die("Không thể tạo chi tiết đơn hàng");
            }
        }

        // Đóng câu lệnh chi tiết đơn hàng sau khi đã thực thi tất cả
        $stmt_detail->close();

        // Xóa giỏ hàng sau khi đặt hàng thành công
        $stmt_clear = $conn->prepare("DELETE FROM gio_hang WHERE khach_hang_id = ?");
        if (!$stmt_clear) {
            error_log("Lỗi khi chuẩn bị câu lệnh xóa giỏ hàng: " . $conn->error);  // Ghi lại lỗi chi tiết
            die("Không thể chuẩn bị câu lệnh xóa giỏ hàng");
        }
        $stmt_clear->bind_param("i", $user_id);
        if (!$stmt_clear->execute()) {
            error_log("Lỗi khi thực thi câu lệnh xóa giỏ hàng: " . $stmt_clear->error);  // Ghi lại lỗi chi tiết
            die("Không thể xóa giỏ hàng");
        }
        $stmt_clear->close();  // Đóng câu lệnh xóa giỏ hàng

        // Xóa mã giảm giá khỏi session
        unset($_SESSION['ma_giam_gia']);

        // Commit giao dịch và chuyển hướng đến trang xác nhận đơn hàng
        $conn->commit();  // Thực hiện commit sau khi mọi thứ thành công
        header("Location: xac_nhan_don_hang.php?don_hang_id=$order_id");
        exit();

    } catch (Exception $e) {
        $conn->rollback();  // Nếu có lỗi, rollback giao dịch
        error_log("Lỗi khi tạo đơn hàng: " . $e->getMessage());  // Ghi lại lỗi
        die("Không thể tạo đơn hàng: " . $e->getMessage());  // Ném lại lỗi cho người dùng
    }
}

// Xử lý yêu cầu đặt hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Cập nhật số lượng giỏ hàng
        if (isset($_POST['cap_nhat_so_luong']) && isset($_POST['so_luong'])) {
            if (updateCartQuantities($conn, $user_id, $_POST['so_luong'])) {
                $success_message = "Cập nhật số lượng thành công!";
            } else {
                $error_message = "Có lỗi xảy ra khi cập nhật số lượng.";
            }
        }
        
        // Xóa sản phẩm khỏi giỏ hàng
        if (isset($_POST['xoa_id'])) {
            $cart_id = (int)$_POST['xoa_id'];
            if (removeCartItem($conn, $user_id, $cart_id)) {
                $success_message = "Đã xóa sản phẩm khỏi giỏ hàng!";
            } else {
                $error_message = "Có lỗi xảy ra khi xóa sản phẩm.";
            }
        }
        
        // Áp dụng mã giảm giá
        if (isset($_POST['ma_giam_gia'])) {
            $_SESSION['ma_giam_gia'] = sanitizeInput($_POST['ma_giam_gia']);
        }
        
        // Đặt hàng
        if (isset($_POST['dat_hang'])) {
            $cart_items = getCartItems($conn, $user_id);
            $addresses = getUserAddresses($conn, $user_id);
            
            // Kiểm tra dữ liệu
            if (empty($addresses)) {
                throw new Exception("Vui lòng thêm địa chỉ giao hàng trước khi đặt hàng!");
            }
            if (empty($cart_items)) {
                throw new Exception("Giỏ hàng của bạn đang trống!");
            }
            if (!isset($_POST['dia_chi_id']) || empty($_POST['dia_chi_id'])) {
                throw new Exception("Vui lòng chọn địa chỉ giao hàng!");
            }
            if (!isset($_POST['hinh_thuc_thanh_toan'])) {
                throw new Exception("Vui lòng chọn hình thức thanh toán!");
            }
            
            $address_id = (int)$_POST['dia_chi_id'];  // Lấy ID địa chỉ
            $payment_method = sanitizeInput($_POST['hinh_thuc_thanh_toan']);  // Lấy phương thức thanh toán
            $final_total = $_SESSION['final_total'];  // Lấy tổng tiền sau khi giảm giá

            // Tạo đơn hàng
            $order_id = createOrder($conn, $user_id, $final_total, $payment_method, $address_id, $cart_items);
            
            // Xóa mã giảm giá
            unset($_SESSION['ma_giam_gia']);
            
            // Chuyển hướng đến trang xác nhận đơn hàng
            header("Location: xac_nhan_don_hang.php?don_hang_id=$order_id");
            exit();
        }
        
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

// Lấy giỏ hàng và thông tin giảm giá
$cart_items = getCartItems($conn, $user_id);
$total_cart_value = array_sum(array_column($cart_items, 'total_price'));
$addresses = getUserAddresses($conn, $user_id);

// Tính toán giá trị giảm giá
$discount_percent = 0;
$final_total = $total_cart_value;
$discount_code = $_SESSION['ma_giam_gia'] ?? '';

if (!empty($discount_code) && $total_cart_value > 0) {
    $discount_info = validateDiscountCode($conn, $discount_code, $total_cart_value);
    if ($discount_info['valid']) {
        $discount_percent = $discount_info['discount'];
        $final_total = $total_cart_value * (1 - $discount_percent / 100);
    }
}
$_SESSION['final_total'] = $final_total; // Lưu tổng tiền vào session
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h2 class="text-center mb-4">
                    <i class="fas fa-shopping-cart me-2"></i>Giỏ Hàng Của Bạn
                </h2>

                <!-- Alert Messages -->
                <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= htmlspecialchars($error_message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if (!empty($success_message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= htmlspecialchars($success_message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if (!empty($cart_items)): ?>
                <form method="post" id="cartForm">
                    <!-- Cart Items Table -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Sản phẩm trong giỏ</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th>Thông số</th>
                                            <th>Giá</th>
                                            <th>Số lượng</th>
                                            <th>Tổng tiền</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cart_items as $item): ?>
                                        <tr class="cart-item-row">
                                            <td>
                                                <strong><?= htmlspecialchars($item['ten_san_pham']) ?></strong>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?= htmlspecialchars($item['dung_luong']) ?><br>
                                                    <?= htmlspecialchars($item['mau_sac']) ?>
                                                </small>
                                            </td>
                                            <td>
                                                <strong><?= number_format($item['gia'], 0, ',', '.') ?>₫</strong>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm" style="width: 120px;">
                                                    <input type="number" name="so_luong[<?= $item['gio_hang_id'] ?>]"
                                                        value="<?= $item['so_luong'] ?>" min="1" max="99"
                                                        class="form-control text-center">
                                                    <button type="submit" name="cap_nhat_so_luong"
                                                        class="btn btn-outline-primary btn-sm" title="Cập nhật">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <strong class="text-success">
                                                    <?= number_format($item['total_price'], 0, ',', '.') ?>₫
                                                </strong>
                                            </td>
                                            <td>
                                                <button type="submit" name="xoa_id" value="<?= $item['gio_hang_id'] ?>"
                                                    class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')"
                                                    title="Xóa sản phẩm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Discount Code Section -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-tag me-2"></i>Mã giảm giá</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" name="ma_giam_gia" class="form-control"
                                            placeholder="Nhập mã giảm giá..."
                                            value="<?= htmlspecialchars($discount_code) ?>">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-check me-1"></i>Áp dụng
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-2 mt-md-0">
                                    <?php if ($discount_percent > 0): ?>
                                    <div class="alert alert-success mb-0 py-2">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Áp dụng mã <strong><?= htmlspecialchars($discount_code) ?></strong>
                                        (giảm <?= $discount_percent ?>%)
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Tổng cộng</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="mb-1">Tổng tiền hàng:
                                        <strong><?= number_format($total_cart_value, 0, ',', '.') ?>₫</strong>
                                    </p>
                                    <?php if ($discount_percent > 0): ?>
                                    <p class="mb-1 text-success">Giảm giá (<?= $discount_percent ?>%):
                                        <strong>-<?= number_format($total_cart_value - $final_total, 0, ',', '.') ?>₫</strong>
                                    </p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-sm-6 text-end">
                                    <h4 class="text-primary mb-0">
                                        Thành tiền: <?= number_format($final_total, 0, ',', '.') ?>₫
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Địa chỉ giao hàng</h5>
                            <a href="dia_chi.php" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-plus me-1"></i>Thêm địa chỉ
                            </a>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($addresses)): ?>
                            <?php foreach ($addresses as $index => $addr): ?>
                            <div class="form-check address-card border rounded p-3 mb-3">
                                <input class="form-check-input" type="radio" name="dia_chi_id"
                                    id="addr_<?= $addr['id'] ?>" value="<?= $addr['id'] ?>"
                                    <?= $index == 0 ? 'checked' : '' ?>>
                                <label class="form-check-label w-100" for="addr_<?= $addr['id'] ?>">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="mb-1"><?= htmlspecialchars($addr['ten_nguoi_nhan']) ?></h6>
                                            <p class="mb-1 text-muted"><?= htmlspecialchars($addr['dia_chi']) ?></p>
                                            <small class="text-muted">
                                                <i
                                                    class="fas fa-phone me-1"></i><?= htmlspecialchars($addr['so_dien_thoai']) ?>
                                            </small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Chưa có địa chỉ giao hàng!</strong>
                                <p class="mb-0">Bạn cần thêm ít nhất một địa chỉ giao hàng để có thể đặt hàng.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Hình thức thanh toán</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="hinh_thuc_thanh_toan"
                                            id="cod" value="COD" checked>
                                        <label class="form-check-label" for="cod">
                                            <i class="fas fa-money-bill-wave me-2"></i>Thanh toán khi nhận hàng (COD)
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="hinh_thuc_thanh_toan"
                                            id="bank" value="Chuyen_khoan">
                                        <label class="form-check-label" for="bank">
                                            <i class="fas fa-university me-2"></i>Chuyển khoản ngân hàng
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="hinh_thuc_thanh_toan"
                                            id="vnpay" value="VNPay">
                                        <label class="form-check-label" for="vnpay">
                                            <i class="fas fa-wallet me-2"></i>Thanh toán bằng VNPay
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="payment-details" class="payment-details" style="display:none;">
                                        <div id="qr-vnpay" style="display:none;" class="text-center">
                                            <h6 class="mb-3">QR Code thanh toán VNPay</h6>
                                            <img src="img/qrvnpay.jpg" alt="VNPay QR Code" class="img-fluid rounded"
                                                style="max-width: 200px;">
                                            <p class="mt-2 text-muted">Quét mã QR để thanh toán qua VNPay</p>
                                        </div>
                                        <div id="bank-transfer" style="display:none;" class="text-center">
                                            <h6 class="mb-3">Thông tin chuyển khoản</h6>
                                            <img src="img/qr.jpg" alt="Bank QR Code" class="img-fluid rounded mb-3"
                                                style="max-width: 200px;">
                                            <div class="text-start">
                                                <p class="mb-1"><strong>Số tài khoản:</strong> 009070809</p>
                                                <p class="mb-1"><strong>Ngân hàng:</strong> MB Bank</p>
                                                <p class="mb-1"><strong>Chủ tài khoản:</strong> Top Zone</p>
                                                <p class="mb-0 text-muted">Vui lòng ghi rõ mã đơn hàng khi chuyển khoản
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Place Order Button -->
                    <?php if (!empty($addresses)): ?>
                    <div class="text-center">
                        <button type="submit" name="dat_hang" class="btn btn-success btn-lg px-5">
                            <i class="fas fa-shopping-cart me-2"></i>Đặt hàng ngay
                        </button>
                    </div>
                    <?php endif; ?>
                </form>

                <?php else: ?>
                <!-- Empty Cart -->
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
                    <h4 class="text-muted mb-3">Giỏ hàng của bạn đang trống</h4>
                    <p class="text-muted mb-4">Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm</p>
                    <a href="index.php" class="btn btn-primary btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Payment method toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const paymentRadios = document.querySelectorAll('input[name="hinh_thuc_thanh_toan"]');
        const paymentDetails = document.getElementById('payment-details');
        const qrVnpay = document.getElementById('qr-vnpay');
        const bankTransfer = document.getElementById('bank-transfer');

        function togglePaymentDetails() {
            const selectedPayment = document.querySelector('input[name="hinh_thuc_thanh_toan"]:checked').value;

            if (selectedPayment === 'COD') {
                paymentDetails.style.display = 'none';
            } else {
                paymentDetails.style.display = 'block';
                qrVnpay.style.display = selectedPayment === 'VNPay' ? 'block' : 'none';
                bankTransfer.style.display = selectedPayment === 'Chuyen_khoan' ? 'block' : 'none';
            }
        }

        // Add event listeners
        paymentRadios.forEach(radio => {
            radio.addEventListener('change', togglePaymentDetails);
        });

        // Initialize
        togglePaymentDetails();

        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });

    // Confirm before removing items
    function confirmRemove() {
        return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?');
    }
    </script>
</body>

</html>