<?php
//session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: dangki.php'); // Nếu chưa đăng nhập, chuyển hướng về trang đăng ký
    exit();
}

include 'connect.php';
//include 'header.php';

$id = $_GET['id'] ?? 0; // Lấy ID sản phẩm từ URL

// Lấy sản phẩm hiện tại (biến thể)
$sql = "SELECT * FROM san_pham WHERE id = $id";
$result = mysqli_query($conn, $sql);
if (!$result || mysqli_num_rows($result) == 0) {
    die("Sản phẩm không tồn tại.");
}
$ct = mysqli_fetch_assoc($result);  // Biến thể hiện tại

// Kiểm tra nếu người dùng thêm sản phẩm vào giỏ
if (isset($_POST['add_to_cart'])) {
    $user_id = $_SESSION['user_id'];  // ID người dùng từ session
    $product_id = $_POST['product_id'];  // ID sản phẩm
    $quantity = $_POST['quantity'];  // Số lượng sản phẩm

    // Kiểm tra sản phẩm đã có trong giỏ chưa
    $check_cart = "SELECT * FROM gio_hang WHERE khach_hang_id = ? AND san_pham_id = ?";
    $stmt = $conn->prepare($check_cart);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Nếu sản phẩm đã có, cập nhật số lượng
        $update_cart = "UPDATE gio_hang SET so_luong = so_luong + ? WHERE khach_hang_id = ? AND san_pham_id = ?";
        $stmt_update = $conn->prepare($update_cart);
        if ($stmt_update) {
            $stmt_update->bind_param("iii", $quantity, $user_id, $product_id);
            $stmt_update->execute();
            $stmt_update->close();  // Đảm bảo đóng khi sử dụng
        } else {
            // Nếu có lỗi khi chuẩn bị truy vấn
            echo "Lỗi cập nhật giỏ hàng: " . $conn->error;
        }
    } else {
        // Nếu sản phẩm chưa có, thêm mới vào giỏ hàng
        $insert_cart = "INSERT INTO gio_hang (khach_hang_id, san_pham_id, so_luong) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($insert_cart);
        if ($stmt_insert) {
            $stmt_insert->bind_param("iii", $user_id, $product_id, $quantity);
            $stmt_insert->execute();
            $stmt_insert->close();  // Đảm bảo đóng khi sử dụng
        } else {
            // Nếu có lỗi khi chuẩn bị truy vấn
            echo "Lỗi thêm sản phẩm vào giỏ hàng: " . $conn->error;
        }
    }

    $stmt->close();  // Đảm bảo đóng khi sử dụng
    // Chuyển hướng về trang giỏ hàng hoặc thông báo thành công
    echo "<script>alert('Sản phẩm đã được thêm vào giỏ hàng thành công!'); window.location.href = 'gio_hang.php';</script>";
    
    exit();
}

// Dữ liệu sản phẩm
$gia = $ct['gia'];
$giam = $ct['phan_tram_giam'];
$gia_goc = $giam > 0 ? round($gia - ($gia * ($giam / 100)), -3) : $gia;

// Lấy ảnh phụ, phụ kiện, đánh giá, bài viết
$anh_phu = mysqli_query($conn, "SELECT * FROM hinh_anh_san_pham WHERE san_pham_id = $id");
$phu_kien = mysqli_query($conn, "SELECT * FROM san_pham WHERE loai_id = 6 LIMIT 4");
$danh_gia = mysqli_query($conn, "SELECT * FROM danh_gia WHERE san_pham_id = $id");

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($ct['ten_san_pham']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <!-- <h2><?= htmlspecialchars($ct['ten_san_pham']) ?></h2>
        <p>Giá: <?= number_format($gia_goc, 0, ',', '.') ?>₫</p>
        <p><strong>Giảm: <?= $giam ?>%</strong></p> -->

        <!-- Form thêm vào giỏ
        <form method="POST">
            <input type="hidden" name="product_id" value="<?= $id ?>">
            <div class="mb-3">
                <label for="quantity" class="form-label">Số lượng</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1">
            </div>
            <button type="submit" name="add_to_cart" class="btn btn-primary">Thêm vào giỏ</button>
        </form> 
        -->


        <!-- Các thông tin khác như đánh giá, ảnh sản phẩm
        <h5>Đánh giá sản phẩm</h5>
        <?php while ($dg = mysqli_fetch_assoc($danh_gia)): ?>
        <div>
            <strong><?= htmlspecialchars($dg['ho_ten']) ?></strong>: <?= htmlspecialchars($dg['binh_luan']) ?>
        </div>
        <?php endwhile; ?> 
        -->

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>