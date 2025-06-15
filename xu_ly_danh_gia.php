<?php
session_start();
include 'connect.php';


if (!isset($_SESSION['user_id'])) {
  echo "<div class='alert alert-warning'>Bạn cần đăng nhập để đánh giá.</div>";
  exit;
}

$san_pham_id = $_POST['san_pham_id'] ?? 0;
$so_sao = $_POST['so_sao'] ?? 0;
$binh_luan = trim($_POST['binh_luan'] ?? '');
$khach_hang_id = $_SESSION['user_id'];

// ✅ Kiểm tra dữ liệu hợp lệ
if ($so_sao >= 1 && $so_sao <= 5 && $binh_luan !== '') {

  // ✅ (Tùy chọn) Kiểm tra đã đánh giá chưa
  $check = $conn->prepare("SELECT id FROM danh_gia WHERE san_pham_id = ? AND khach_hang_id = ?");
  $check->bind_param("ii", $san_pham_id, $khach_hang_id);
  $check->execute();
  $check->store_result();
  
  if ($check->num_rows > 0) {
    echo "<div class='alert alert-info'>Bạn đã đánh giá sản phẩm này rồi.</div>";
    exit;
  }
  $check->close();

  // ✅ Chèn đánh giá mới
  $stmt = $conn->prepare("INSERT INTO danh_gia (san_pham_id, khach_hang_id, so_sao, binh_luan, ngay_danh_gia) VALUES (?, ?, ?, ?, NOW())");
  $stmt->bind_param("iiis", $san_pham_id, $khach_hang_id, $so_sao, $binh_luan);
  
  if ($stmt->execute()) {
    echo "<div class='alert alert-success'>🎉 Cảm ơn bạn đã đánh giá sản phẩm!</div>";
  } else {
    echo "<div class='alert alert-danger'>❌ Có lỗi khi lưu đánh giá. Vui lòng thử lại.</div>";
  }
  $stmt->close();

} else {
  echo "<div class='alert alert-warning'>Vui lòng chọn số sao và nhập bình luận.</div>";
}
?>
