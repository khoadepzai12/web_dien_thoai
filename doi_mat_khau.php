<?php
ob_start();
session_start();

// Bắt đầu phiên làm việc
if (!isset($_SESSION['user_id'])) {
    header('Location: dangki.php'); // Nếu chưa đăng nhập, chuyển hướng đến trang đăng ký
    exit();
}

include 'connect.php'; // Kết nối cơ sở dữ liệu

$user_id = $_SESSION['user_id']; // Lấy ID người dùng từ session

// Xử lý thay đổi mật khẩu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra và xử lý kết nối cơ sở dữ liệu
    $stmt = $conn->prepare("SELECT mat_khau FROM khach_hang WHERE id = ?");
    if ($stmt === false) {
        die('Lỗi trong câu lệnh SQL: ' . $conn->error);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->free_result(); // Tiêu thụ kết quả để tránh lỗi "Commands out of sync"

    if ($hashed_password === null) {
        $message = "Không tìm thấy mật khẩu cho người dùng này. Kiểm tra ID người dùng hoặc bảng cơ sở dữ liệu.";
    } else {
        // So sánh mật khẩu hiện tại
        if ($current_password === $hashed_password) {
            if ($new_password === $confirm_password) {
                // Chuẩn bị và thực thi câu lệnh cập nhật mật khẩu mới
                $stmt_update = $conn->prepare("UPDATE khach_hang SET mat_khau = ? WHERE id = ?");
                if ($stmt_update === false) {
                    die('Lỗi trong câu lệnh SQL: ' . $conn->error);
                }
                // Lưu mật khẩu mới dưới dạng văn bản thuần (không khuyến nghị, nên mã hóa)
                $stmt_update->bind_param("si", $new_password, $user_id);
                $stmt_update->execute();
                $stmt_update->close();
                
                // Thông báo và chuyển hướng
                header('Location: thong_tin_tai_khoan.php'); // Chuyển hướng về trang thông tin tài khoản
                exit(); // Dừng mã để không tiếp tục thực thi thêm gì nữa
            } else {
                $message = "Mật khẩu xác nhận không khớp!";
            }
        } else {
            $message = "Mật khẩu hiện tại không đúng!";
        }
    }
    $stmt->close();
}

include 'header.php'; // Bao gồm header của trang web
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Thay Đổi Mật Khẩu</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light py-4">
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header bg-primary text-white">
                <h2 class="h5 mb-0">THAY ĐỔI MẬT KHẨU</h2>
            </div>
            <div class="card-body">
                <?php if (isset($message)): ?>
                    <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Mật khẩu mới</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Thay đổi mật khẩu</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS Bundle with Popper (optional for some components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include 'fooder1.php'; // Bao gồm footer của trang web ?>
<?php ob_end_flush(); ?>
