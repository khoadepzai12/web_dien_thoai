<?php
session_start();
include 'connect.php';

$reset_error = '';
$reset_success = '';
$email = isset($_GET['email']) ? $conn->real_escape_string($_GET['email']) : '';
$token = isset($_GET['token']) ? $conn->real_escape_string($_GET['token']) : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmPassword'];

    // Kiểm tra mật khẩu
    if ($password !== $confirm_password) {
        $reset_error = "Mật khẩu xác nhận không khớp.";
    } elseif (empty($password) || empty($confirm_password)) {
        $reset_error = "Vui lòng nhập mật khẩu và xác nhận mật khẩu.";
    } else {
        // Kiểm tra mật khẩu hợp lệ
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            $reset_error = "Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt.";
        } else {
            // Kiểm tra token mặc định
            if ($token === '123456') {
                $sql = "SELECT * FROM khach_hang WHERE email = ? LIMIT 1";
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    $reset_error = "Lỗi chuẩn bị truy vấn: " . $conn->error;
                } else {
                    $stmt->bind_param("s", $email);
                    if (!$stmt->execute()) {
                        $reset_error = "Lỗi thực thi truy vấn: " . $stmt->error;
                    } else {
                        $result = $stmt->get_result();
                        if ($result->num_rows === 1) {
                            // Cập nhật mật khẩu trực tiếp mà không mã hóa
                            $sql = "UPDATE khach_hang SET mat_khau = ? WHERE email = ?";
                            $stmt = $conn->prepare($sql);
                            if (!$stmt) {
                                $reset_error = "Lỗi chuẩn bị truy vấn cập nhật: " . $conn->error;
                            } else {
                                $stmt->bind_param("ss", $password, $email);
                                if ($stmt->execute()) {
                                    $affected_rows = $stmt->affected_rows;
                                    if ($affected_rows > 0) {
                                        $reset_success = "Mật khẩu đã được đặt lại thành công. Vui lòng đăng nhập.";
                                    } else {
                                        $reset_error = "Không có bản ghi nào được cập nhật. Kiểm tra email.";
                                    }
                                } else {
                                    $reset_error = "Lỗi khi cập nhật mật khẩu: " . $stmt->error;
                                }
                            }
                        } else {
                            $reset_error = "Email không tồn tại.";
                        }
                    }
                }
            } else {
                $reset_error = "Token không hợp lệ.";
            }
            if (isset($stmt) && $stmt) {
                $stmt->close();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đặt lại mật khẩu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        body {
            background-image: url('https://static.vecteezy.com/system/resources/previews/030/620/272/large_2x/olden-minimalist-wallpaper-free-photo.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.7), rgba(255, 255, 255, 0.9));
            backdrop-filter: blur(5px);
            z-index: 1;
        }
        .container {
            position: relative;
            z-index: 2;
        }
    </style>
</head>
<body>
    <div class="container w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 border border-gray-200 mx-auto">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Đặt lại mật khẩu</h2>

        <?php if ($reset_success): ?>
            <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6 text-center font-medium" role="alert"><?= $reset_success ?></div>
            <a href="dangki.php" class="block text-center mt-6 text-blue-600 hover:text-blue-800 font-medium">Quay lại đăng nhập</a>
        <?php else: ?>
            <?php if ($reset_error): ?>
                <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-6 text-center font-medium" role="alert"><?= $reset_error ?></div>
            <?php endif; ?>
            <form method="post" class="space-y-6">
                <div class="relative">
                    <label for="reset-password" class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu mới</label>
                    <input id="reset-password" name="password" type="password" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-900 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200" placeholder="Nhập mật khẩu mới" required />
                    <button type="button" onclick="togglePassword('reset-password', this)" class="absolute right-3 top-10 text-gray-500"><i class="fa fa-eye"></i></button>
                </div>
                <div class="relative">
                    <label for="confirm-password" class="block text-sm font-medium text-gray-700 mb-2">Xác nhận mật khẩu</label>
                    <input id="confirm-password" name="confirmPassword" type="password" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-900 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-200" placeholder="Xác nhận mật khẩu mới" required />
                    <button type="button" onclick="togglePassword('confirm-password', this)" class="absolute right-3 top-10 text-gray-500"><i class="fa fa-eye"></i></button>
                </div>
                <button type="submit" name="reset_password" class="w-full bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition duration-200">Đặt lại mật khẩu</button>
            </form>
            <a href="dangki.php" class="block text-center mt-6 text-blue-600 hover:text-blue-800 font-medium">Quay lại đăng nhập</a>
        <?php endif; ?>
    </div>

    <script>
        function togglePassword(id, btn) {
            const passwordField = document.getElementById(id);
            const icon = btn.querySelector('i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>