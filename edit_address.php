<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: dangki.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$address_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch the address details for the given address ID
if ($address_id > 0) {
    $stmt = $conn->prepare("SELECT id, ten_nguoi_nhan, dia_chi, so_dien_thoai FROM dia_chi_giao_hang WHERE id = ? AND khach_hang_id = ?");
    $stmt->bind_param("ii", $address_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $address = $result->fetch_assoc(); // Fetch the address details
    } else {
        // If no address found or not owned by the current user
        echo "Không tìm thấy địa chỉ này.";
        exit();
    }
    $stmt->close();
} else {
    echo "Invalid address ID.";
    exit();
}

// Handle form submission for editing the address
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_nguoi_nhan = $_POST['ten_nguoi_nhan'];
    $dia_chi = $_POST['dia_chi'];
    $so_dien_thoai = $_POST['so_dien_thoai'];

    // Update the address details in the database
    $update_stmt = $conn->prepare("UPDATE dia_chi_giao_hang SET ten_nguoi_nhan = ?, dia_chi = ?, so_dien_thoai = ? WHERE id = ? AND khach_hang_id = ?");
    $update_stmt->bind_param("ssiii", $ten_nguoi_nhan, $dia_chi, $so_dien_thoai, $address_id, $user_id);
    $update_stmt->execute();

    if ($update_stmt->affected_rows > 0) {
        header('Location: dia_chi.php'); // Redirect to address list
        exit();
    } else {
        echo "Error updating address or no change detected.";
    }
    $update_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sửa địa chỉ giao hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f8f8;
        }

        .container {
            margin-top: 50px;
            max-width: 600px;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #ff5f5f;
            border: none;
        }

        .btn-primary:hover {
            background-color: #d93e3e;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Sửa địa chỉ giao hàng</h2>
    <form method="POST" action="edit_address.php?id=<?= $address_id ?>">
        <div class="mb-3">
            <label for="ten_nguoi_nhan" class="form-label">Tên người nhận</label>
            <input type="text" class="form-control" id="ten_nguoi_nhan" name="ten_nguoi_nhan" value="<?= htmlspecialchars($address['ten_nguoi_nhan']) ?>" required />
        </div>
        <div class="mb-3">
            <label for="dia_chi" class="form-label">Địa chỉ</label>
            <textarea class="form-control" id="dia_chi" name="dia_chi" rows="3" required><?= htmlspecialchars($address['dia_chi']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai" value="<?= htmlspecialchars($address['so_dien_thoai']) ?>" required />
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật địa chỉ</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
