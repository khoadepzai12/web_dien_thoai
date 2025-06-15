<?php
session_start();
include 'connect.php';

$reset_error = '';
$reset_success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['forgot_password'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $token = $conn->real_escape_string($_POST['token']);

    // Kiểm tra email tồn tại
    $sql = "SELECT * FROM khach_hang WHERE email = '$email' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Kiểm tra token mặc định
        if ($token === '123456') {
            // Token đúng, chuyển hướng trực tiếp đến trang đặt lại mật khẩu
            header("Location: reset_password.php?email=$email&token=123456");
            exit;
        } else {
            // Token không phải mặc định, xử lý gửi email như cũ
            $reset_token = bin2hex(random_bytes(32)); // Tạo token ngẫu nhiên
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token hết hạn sau 1 giờ

            // Lưu token vào cơ sở dữ liệu
            $sql = "UPDATE khach_hang SET reset_token = ?, reset_token_expiry = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $reset_token, $expiry, $email);
            if ($stmt->execute()) {
                // Gửi email chứa liên kết đặt lại mật khẩu
                $reset_link = "http://yourdomain.com/reset_password.php?token=$reset_token&email=$email";
                $subject = "Yêu cầu đặt lại mật khẩu";
                $message = "Chào bạn,\n\nVui lòng nhấp vào liên kết sau để đặt lại mật khẩu: $reset_link\nLiên kết này có hiệu lực trong 1 giờ.\n\nTrân trọng,\nĐội ngũ hỗ trợ";
                $headers = "From: no-reply@yourdomain.com";

                if (mail($email, $subject, $message, $headers)) {
                    $reset_success = "Một email chứa liên kết đặt lại mật khẩu đã được gửi đến $email.";
                } else {
                    $reset_error = "Lỗi khi gửi email. Vui lòng thử lại.";
                }
            } else {
                $reset_error = "Lỗi khi lưu token: " . $conn->error;
            }
            $stmt->close();
        }
    } else {
        $reset_error = "Email không tồn tại.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quên mật khẩu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('https://static.vecteezy.com/system/resources/previews/030/620/272/large_2x/olden-minimalist-wallpaper-free-photo.jpg'); /* Replace with your image URL */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.9; /* Adjust opacity for a faded effect */
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-md border border-gray-300 rounded-xl shadow-xl bg-white p-6 bg-opacity-90">
        <h2 class="text-2xl font-semibold text-center mb-6">Quên mật khẩu</h2>

        <?php if ($reset_success): ?>
            <div class="text-green-600 mb-4 font-semibold" role="alert"><?= $reset_success ?></div>
        <?php endif; ?>
        <?php if ($reset_error): ?>
            <div class="text-red-600 mb-4 font-semibold" role="alert"><?= $reset_error ?></div>
        <?php endif; ?>

        <form method="post" class="space-y-4">
            <input name="email" type="email" class="w-full border rounded px-3 py-2 text-base" placeholder="Nhập email của bạn" required />
            <button type="button" class="w-full bg-red-500 text-white py-2 rounded text-base font-semibold hover:bg-red-600 transition">Gửi mã OTP</button>

            <input name="token" type="text" class="w-full border rounded px-3 py-2 text-base" placeholder="Nhập token" required />
            <button type="submit" name="forgot_password" class="w-full bg-red-500 text-white py-2 rounded text-base font-semibold hover:bg-red-600 transition">Gửi yêu cầu</button>
        </form>
        <a href="dangki.php" class="text-blue-500 text-sm block text-center mt-4">Quay lại đăng nhập</a>
    </div>
</body>
</html>
