<?php
session_start();
include 'connect.php';

$error_fields = []; // Mảng để lưu các trường bị lỗi
$show_login_form = true; // Biến để hiển thị form đăng nhập đầu tiên
$login_error = ''; // Biến lưu lỗi đăng nhập
$register_error = ''; // Biến lưu lỗi đăng ký
$register_success = ''; // Biến lưu thông báo đăng ký thành công

// Lưu lỗi vào session để có thể hiển thị khi chuyển form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Đăng nhập
    if (isset($_POST['identifier'], $_POST['password']) && isset($_POST['login'])) {
        $identifier = $conn->real_escape_string($_POST['identifier']);
        $password = $_POST['password'];

        $sql = "SELECT * FROM khach_hang WHERE (email = '$identifier' OR sdt = '$identifier') LIMIT 1";
        $result = $conn->query($sql);

        if ($result === false) {
            $login_error = "Lỗi truy vấn cơ sở dữ liệu: " . $conn->error;
        } else if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if ($password === $user['mat_khau']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['ho_ten'];
                $_SESSION['user_phone'] = $user['sdt'];
                header('Location: home.php');
                exit;
            } else {
                // Store the login error message in the session
                $_SESSION['login_error'] = "Mật khẩu không đúng.";
            }
        } else {
            $_SESSION['login_error'] = "Tài khoản không tồn tại.";
        }
        $show_login_form = true; // Hiển thị form đăng nhập khi có lỗi
    }

    // Đăng ký
    elseif (isset($_POST['lastName'], $_POST['firstName'], $_POST['phone'], $_POST['address'], $_POST['email'], $_POST['password'], $_POST['confirmPassword']) && isset($_POST['register'])) {
        $lastName = $conn->real_escape_string($_POST['lastName']);
        $firstName = $conn->real_escape_string($_POST['firstName']);
        $phone = $conn->real_escape_string($_POST['phone']);
        $address = $conn->real_escape_string($_POST['address']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        // Kiểm tra mật khẩu và xác nhận mật khẩu
        if ($password !== $confirmPassword) {
            $_SESSION['register_error'] = "Mật khẩu xác nhận không khớp.";
            $_SESSION['error_fields'][] = 'confirmPassword';
        } elseif (empty($password) || empty($confirmPassword)) {
            $_SESSION['register_error'] = "Vui lòng nhập mật khẩu và xác nhận mật khẩu.";
            $_SESSION['error_fields'][] = 'password';
            $_SESSION['error_fields'][] = 'confirmPassword';
        } else {
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number = preg_match('@[0-9]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);

            if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                $_SESSION['register_error'] = "Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt.";
                $_SESSION['error_fields'][] = 'password';
            } else {
                $checkSql = "SELECT * FROM khach_hang WHERE email = '$email' OR sdt = '$phone' LIMIT 1";
                $checkResult = $conn->query($checkSql);
                if ($checkResult && $checkResult->num_rows > 0) {
                    $_SESSION['register_error'] = "Email hoặc số điện thoại đã được đăng ký.";
                    $_SESSION['error_fields'][] = 'email';
                    $_SESSION['error_fields'][] = 'phone';
                } else {
                    $ho_ten = $lastName . ' ' . $firstName;
                    $insertSql = "INSERT INTO khach_hang (ho_ten, sdt, dia_chi, email, mat_khau, vai_tro_id) VALUES (?, ?, ?, ?, ?, 1)";
                    $stmt = $conn->prepare($insertSql);
                    $stmt->bind_param("sssss", $ho_ten, $phone, $address, $email, $password);
                    if ($stmt->execute()) {
                        $_SESSION['register_success'] = "Đăng ký thành công. Vui lòng đăng nhập.";
                        $_SESSION['error_fields'] = []; // Xóa lỗi sau khi đăng ký thành công
                        $show_login_form = true; // Sau khi đăng ký thành công, chuyển sang form đăng nhập
                    } else {
                        $_SESSION['register_error'] = "Lỗi khi đăng ký: " . $conn->error;
                    }
                    $stmt->close();
                }
            }
        }
        $show_login_form = false; // Hiển thị form đăng ký khi có lỗi
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Member Benefits & Đăng nhập</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-[#f3f4ff] min-h-screen flex items-center justify-center px-4 py-10">

  <div class="w-full max-w-7xl border border-gray-300 rounded-xl shadow-xl bg-white p-6 md:p-10 flex flex-col lg:flex-row gap-6 lg:gap-10">

    <div class="w-full lg:w-1/2 flex flex-col items-center lg:items-start">
      <img 
        src="https://storage.googleapis.com/a1aa/image/eb555bab-e307-4580-ace6-1579b71a1e50.jpg"
        alt="Hình minh họa mua sắm"
        class="w-full max-w-sm mx-auto rounded-lg shadow-lg object-cover"
        loading="lazy"
      />
      <div class="mt-6 px-2 sm:px-4">
        <h2 class="text-[#1a1a1a] font-semibold text-2xl mb-4 text-center lg:text-left">QUYỀN LỢI THÀNH VIÊN</h2>
        <ul class="space-y-4 text-[#1a1a1a] text-base leading-relaxed">
          <li class="flex items-start">
            <i class="fas fa-check-circle text-blue-500 mt-1 mr-3 text-xl"></i>
            <span>Mua hàng khắp thế giới cực dễ dàng, nhanh chóng</span>
          </li>
          <li class="flex items-start">
            <i class="fas fa-check-circle text-blue-500 mt-1 mr-3 text-xl"></i>
            <span>Theo dõi chi tiết đơn hàng, địa chỉ thanh toán dễ dàng</span>
          </li>
          <li class="flex items-start">
            <i class="fas fa-check-circle text-blue-500 mt-1 mr-3 text-xl"></i>
            <span>Nhận nhiều chương trình ưu đãi hấp dẫn từ chúng tôi</span>
          </li>
        </ul>
      </div>
    </div>

    <div class="w-full lg:w-1/2 rounded-lg shadow-lg p-6">
      <div class="flex border-b text-sm font-semibold mb-6">
        <button type="button" onclick="showForm('login')" id="btn-login" class="flex-1 py-2 text-center border-b-2 <?= $show_login_form ? 'border-red-500 text-black' : 'text-gray-500' ?>">Đăng nhập</button>
        <button type="button" onclick="showForm('register')" id="btn-register" class="flex-1 py-2 text-center border-b-2 <?= !$show_login_form ? 'border-red-500 text-black' : 'text-gray-500' ?>">Đăng ký</button>
      </div>

      <!-- Hiển thị lỗi đăng nhập nếu có -->
      <?php if (!empty($_SESSION['login_error']) && $show_login_form): ?>
        <div class="text-red-600 mb-4 font-semibold" role="alert"><?= $_SESSION['login_error'] ?></div>
        <?php unset($_SESSION['login_error']); ?>
      <?php endif; ?>

      <!-- Hiển thị thông báo đăng ký thành công -->
      <?php if (!empty($_SESSION['register_success'])): ?>
        <div class="text-green-600 mb-4 font-semibold" role="alert"><?= $_SESSION['register_success'] ?></div>
        <script>
          window.registerSuccess = true;
        </script>
        <?php unset($_SESSION['register_success']); ?>
      <?php else: ?>
        <script>
          window.registerSuccess = false;
        </script>
      <?php endif; ?>

      <!-- Form Đăng ký -->
      <form id="form-register" method="post" class="space-y-4 <?= !$show_login_form ? 'block' : 'hidden' ?>">
        <?php if (!empty($_SESSION['register_error'])): ?>
          <div class="text-red-600 mb-4 font-semibold" role="alert"><?= $_SESSION['register_error'] ?></div>
          <?php unset($_SESSION['register_error']); ?>
        <?php endif; ?>
        <input name="lastName" class="w-full border rounded px-3 py-2 text-base <?= in_array('lastName', $_SESSION['error_fields'] ?? []) ? 'border-red-500' : '' ?>" placeholder="Họ" value="<?= htmlspecialchars($_POST['lastName'] ?? '') ?>" required />
        <input name="firstName" class="w-full border rounded px-3 py-2 text-base <?= in_array('firstName', $_SESSION['error_fields'] ?? []) ? 'border-red-500' : '' ?>" placeholder="Tên" value="<?= htmlspecialchars($_POST['firstName'] ?? '') ?>" required />
        <input name="phone" class="w-full border rounded px-3 py-2 text-base <?= in_array('phone', $_SESSION['error_fields'] ?? []) ? 'border-red-500' : '' ?>" placeholder="Số điện thoại" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" required />
        <input name="address" class="w-full border rounded px-3 py-2 text-base <?= in_array('address', $_SESSION['error_fields'] ?? []) ? 'border-red-500' : '' ?>" placeholder="Địa chỉ" value="<?= htmlspecialchars($_POST['address'] ?? '') ?>" required />
        <input name="email" type="email" class="w-full border rounded px-3 py-2 text-base <?= in_array('email', $_SESSION['error_fields'] ?? []) ? 'border-red-500' : '' ?>" placeholder="Email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required />

        <div class="relative">
          <input name="password" type="password" class="w-full border rounded px-3 py-2 pr-10 text-base <?= in_array('password', $_SESSION['error_fields'] ?? []) ? 'border-red-500' : '' ?>" placeholder="Mật khẩu" required id="register-password" />
          <button type="button" onclick="togglePassword('register-password', this)" class="absolute right-2 top-2 text-gray-500"><i class="fa fa-eye"></i></button>
        </div>

        <div class="relative">
          <input name="confirmPassword" type="password" class="w-full border rounded px-3 py-2 pr-10 text-base <?= in_array('confirmPassword', $_SESSION['error_fields'] ?? []) ? 'border-red-500' : '' ?>" placeholder="Xác nhận mật khẩu" required id="confirm-password" />
          <button type="button" onclick="togglePassword('confirm-password', this)" class="absolute right-2 top-2 text-gray-500"><i class="fa fa-eye"></i></button>
        </div>

        <button type="submit" name="register" class="w-full bg-red-500 text-white py-2 rounded text-base font-semibold hover:bg-red-600 transition">Tạo tài khoản</button>
      </form>

      <!-- Form Đăng nhập -->
      <form id="form-login" method="post" class="space-y-4 <?= $show_login_form ? 'block' : 'hidden' ?>">
        <input name="identifier" class="w-full border rounded px-3 py-2 text-base" placeholder="Email hoặc SĐT" required />
        <div class="relative">
            <input name="password" type="password" class="w-full border rounded px-3 py-2 pr-10 text-base" placeholder="Mật khẩu" required id="login-password" />
            <button type="button" onclick="togglePassword('login-password', this)" class="absolute right-2 top-2 text-gray-500"><i class="fa fa-eye"></i></button>
        </div>

        <!-- Liên kết Quên mật khẩu -->
        <a href="forgot_password.php" class="text-blue-500 text-sm block text-right mb-4">Quên mật khẩu?</a>

        <button type="submit" name="login" class="w-full bg-red-500 text-white py-2 rounded text-base font-semibold hover:bg-red-600 transition">Đăng nhập</button>
      </form>

    </div>
  </div>

  <script>
    function showForm(form) {
      document.getElementById('form-login').classList.toggle('hidden', form !== 'login');
      document.getElementById('form-register').classList.toggle('hidden', form !== 'register');
      document.getElementById('btn-login').classList.toggle('border-red-500', form === 'login');
      document.getElementById('btn-login').classList.toggle('text-black', form === 'login');
      document.getElementById('btn-login').classList.toggle('text-gray-500', form !== 'login');
      document.getElementById('btn-register').classList.toggle('border-red-500', form === 'register');
      document.getElementById('btn-register').classList.toggle('text-black', form === 'register');
      document.getElementById('btn-register').classList.toggle('text-gray-500', form !== 'register');
    }

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

    // Automatically switch to login form after successful registration
    window.addEventListener('DOMContentLoaded', () => {
      if (window.registerSuccess) {
        showForm('login');
      }
    });
  </script>
</body>
</html>
