<?php
session_start();
include 'connect.php';
include 'header.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: dangki.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user information
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

// Fetch addresses for the user
$address_stmt = $conn->prepare("SELECT id, ten_nguoi_nhan, dia_chi, so_dien_thoai FROM dia_chi_giao_hang WHERE khach_hang_id = ?");
$address_stmt->bind_param("i", $user_id);
$address_stmt->execute();
$address_result = $address_stmt->get_result();

$addresses = [];
if ($address_result) {
    while ($row = $address_result->fetch_assoc()) {
        $addresses[] = $row;
    }
}
$address_stmt->close();

// Handle the form submission to add a new address
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_nguoi_nhan = $_POST['ten_nguoi_nhan'];
    $dia_chi = $_POST['dia_chi'];
    $so_dien_thoai = $_POST['so_dien_thoai'];

    // Insert the new address into the database
    $insert_stmt = $conn->prepare("INSERT INTO dia_chi_giao_hang (khach_hang_id, ten_nguoi_nhan, dia_chi, so_dien_thoai) VALUES (?, ?, ?, ?)");
    $insert_stmt->bind_param("isss", $user_id, $ten_nguoi_nhan, $dia_chi, $so_dien_thoai);
    $insert_stmt->execute();
    $insert_stmt->close();

    // Redirect back to the same page to show the updated list of addresses
    echo "<script>alert('Địa chỉ mới đã được thêm thành công!'); window.location.href = 'dia_chi.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Thông tin tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f8f8;
        margin: 0;
        font-size: 16px;
    }

    .account-container {
        max-width: 1200px;
        margin: 2rem auto;
        background-color: #ffffff;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .account-menu a {
        color: #333333;
        font-weight: 600;
        padding: 8px 0;
        font-size: 16px;
        display: block;
        text-decoration: none;
    }

    .account-menu a:hover {
        color: #d93e3e;
    }

    .account-info p {
        margin-bottom: 20px;
        font-size: 16px;
        color: black;
    }

    .account-info strong {
        font-weight: 600;
    }

    .account-info {
        font-size: 16px;
    }

    .account-menu h2,
    .account-info h2 {
        color: black;
        font-size: 18px;
        margin-bottom: 20px;
    }

    .list-group-item {
        background-color: transparent !important;
        border: none;
    }

    .list-group-item:hover {
        background-color: #f0f0f0;
    }

    .btn-primary {
        background-color: #ff5f5f;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        text-align: center;
        color: white;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #d93e3e;
    }

    .footer {
        background-color: #333;
        color: white;
        padding: 20px;
        text-align: center;
    }

    .address-section {
        font-size: 16px;
        color: black;
    }

    .address-container {
        padding: 15px;
        margin-top: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .address-container p {
        margin: 5px 0;
    }

    .address-container .btn {
        background-color: #007bff;
        color: white;
    }

    .address-container .btn:hover {
        background-color: #0056b3;
    }

    .address-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .address-row>div {
        margin-right: 20px;
    }

    .address-btn {
        background-color: #007bff;
        color: white;
        border-radius: 5px;
    }
    </style>
</head>

<body>
    <div class="account-container">
        <div class="row">
            <div class="col-md-3 account-menu">
                <h2 class="mb-4">TRANG TÀI KHOẢN</h2>
                <p class="fw-semibold mb-4">Xin chào, <?= htmlspecialchars($user['ho_ten']) ?> !</p>
                <nav>
                    <a href="thong_tin_tai_khoan.php">Thông tin tài khoản</a>
                    <a href="logout.php">Đăng xuất</a>
                    <a href="dia_chi.php" class="fs-6 text-dark text-decoration-none">Sổ địa chỉ</a>
                </nav>
            </div>

            <div class="col-md-9 account-info">
                <h2 class="mb-4">THÔNG TIN TÀI KHOẢN</h2>
                <p><strong>Họ tên:</strong> <?= htmlspecialchars($user['ho_ten']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>

                <div class="main-content">
                    <h3 class="card-header">Địa chỉ giao hàng</h3>
                    <?php if (!empty($addresses)): ?>
                    <div class="address-section">
                        <?php foreach ($addresses as $addr): ?>
                        <div class="address-row">
                            <div>
                                <strong><?= htmlspecialchars($addr['ten_nguoi_nhan']) ?></strong><br />
                                <?= nl2br(htmlspecialchars($addr['dia_chi'])) ?><br />
                                <em><?= htmlspecialchars($addr['so_dien_thoai']) ?></em>
                            </div>
                            <div>
                                <a href="edit_address.php?id=<?= $addr['id'] ?>" class="btn btn-sm address-btn">Chỉnh
                                    sửa</a>
                                <a href="delete.php?id=<?= $addr['id'] ?>" class="btn btn-sm address-btn">Xóa</a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <p>Chưa có địa chỉ giao hàng nào.</p>
                    <?php endif; ?>
                </div>

                <!-- Button to show the address form -->
                <button id="addAddressBtn" class="btn btn-primary mt-3">Thêm địa chỉ giao hàng</button>

                <!-- Form for adding a new address (hidden by default) -->
                <div id="addressForm" style="display: none; margin-top: 20px;">
                    <h3>Thêm địa chỉ giao hàng</h3>
                    <form method="POST" action="dia_chi.php">
                        <div class="mb-3">
                            <label for="ten_nguoi_nhan" class="form-label">Tên người nhận</label>
                            <input type="text" class="form-control" id="ten_nguoi_nhan" name="ten_nguoi_nhan"
                                required />
                        </div>
                        <div class="mb-3">
                            <label for="dia_chi" class="form-label">Địa chỉ</label>
                            <textarea class="form-control" id="dia_chi" name="dia_chi" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai" required />
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm địa chỉ</button>
                        <button type="button" id="cancelBtn" class="btn btn-secondary ml-3">Hủy</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Show the form when clicking "Thêm địa chỉ giao hàng"
    document.getElementById('addAddressBtn').addEventListener('click', function() {
        document.getElementById('addressForm').style.display = 'block';
    });

    // Hide the form when clicking "Hủy"
    document.getElementById('cancelBtn').addEventListener('click', function() {
        document.getElementById('addressForm').style.display = 'none';
    });
    </script>
</body>

</html>