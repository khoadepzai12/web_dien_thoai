<?php
session_start();
include_once 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mã hoá mật khẩu người dùng nhập vào bằng SHA1
    $hashed_password = sha1($password);

    // Kiểm tra xem là admin hay nhân viên và thực hiện truy vấn tương ứng
    $sql_admin = "SELECT * FROM quan_tri_vien WHERE ten_dang_nhap = '$username' AND mat_khau = '$hashed_password'";
    $sql_employee = "SELECT * FROM nhan_vien WHERE email_cong_ty = '$username' AND mat_khau = '$hashed_password'";

    // Kiểm tra login của admin
    $result_admin = $conn->query($sql_admin);
    if ($result_admin->num_rows > 0) {
        $user = $result_admin->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];  // Lưu ID người dùng vào session
        $_SESSION['role'] = 'admin';  // Đặt role admin
        header("Location: index_admin.php");  // Chuyển hướng về trang Dashboard
        exit();
    }

    // Kiểm tra login của nhân viên $result_employee = $conn->query($sql_employee);
    //if ($result_employee->num_rows > 0) {
     //   $user = $result_employee->fetch_assoc();
     //   $_SESSION['user_id'] = $user['id'];  // Lưu ID người dùng vào session
     //   $_SESSION['role'] = 'employee';  // Đặt role employee
    //    header("Location: index_admin.php");  // Chuyển hướng về trang Dashboard
    //    exit();
    //}

   
    // Nếu không tìm thấy tài khoản
    $error = "Thông tin đăng nhập không chính xác.";
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="icon" href="images/admin.png" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex justify-content-center align-items-center"
    style="height: 100vh; background-image: url('images/pxfuel.jpg'); background-size: cover; background-position: center;">
    <div class="card" style="width: 20rem;">
        <div class="d-flex justify-content-center">
            <a href="home.php">
                <img src="img/admin.png" class="card-img-top" alt="Admin Icon"
                    style="width: 100px; height: 100px; margin: 20px auto;">
            </a>
        </div>
        <div class="card-body">
            <h3 class="card-title text-center">Đăng nhập</h3>
            <?php if (isset($error)) { echo "<p class='text-danger text-center'>$error</p>"; } ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Email công ty</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>