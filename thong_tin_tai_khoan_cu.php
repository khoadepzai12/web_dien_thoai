<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: dangki.php');
    exit();
}
include 'connect.php';
include 'header.php';
$user_id = $_SESSION['user_id'];

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Account Page</title>
  <!-- Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card-custom {
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    .card-header {
      background-color:rgb(27, 28, 29);
      color: white;
    }
    .list-group-item-action:hover {
      background-color:rgb(24, 25, 27);
      color: white;
    }
    .fw-semibold {
      font-weight: 600;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="card card-custom">
      <div class="card-header">
        <h2 class="h5 mb-0">TRANG TÀI KHOẢN</h2>
      </div>
      <div class="card-body">
        <div class="row">
          <!-- Left column: user greeting and navigation -->
          <div class="col-md-4 mb-4 mb-md-0">
            <h5 class="mb-3">Xin chào, <?= htmlspecialchars($user['ho_ten']) ?>!</h5>
            <div class="list-group">
              <a href="dia_chi.php" class="list-group-item list-group-item-action">Sổ địa chỉ</a>
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
      </div>
    </div>
  </div>

  <?php include 'fooder1.php'; ?>

  <!-- Bootstrap JS Bundle with Popper (optional for some components) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
