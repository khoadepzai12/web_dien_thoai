<?php
require_once 'connect.php';


$keyword = strtolower(trim($_GET['keyword'] ?? ''));
if (empty($keyword)) {
  header('Location: home.php');
  exit;
}

// Hàm tách loại sản phẩm và dòng/mẫu (nếu có)
function parseKeyword($keyword, $map) {
  foreach ($map as $key => $value) {
    if (strpos($keyword, $key) !== false) {
      // Tách phần còn lại sau key làm model (loại bỏ khoảng trắng)
      $model = trim(str_replace($key, '', $keyword));
      return [$value, $model];
    }
  }
  return [null, null];
}

// Định nghĩa map từ khóa → trang đích
$map = [
  'iphone'    => 'iphone.php',
  'ipad'      => 'ipad.php',
  'macbook'   => 'macbook.php',
  'mac'       => 'macbook.php',
  'watch'     => 'watch.php',
  'airpods'   => 'am-thanh.php',
  'tai nghe'  => 'am-thanh.php',
  'loa'       => 'am-thanh.php',
  'phukien'   => 'phukien.php',
  'pk'        => 'phukien.php'
];

// Tìm trang phù hợp và model
list($foundPage, $model) = parseKeyword($keyword, $map);

// Nếu tìm được, chuyển hướng sang trang đó (có thể kèm tham số)
if (!empty($foundPage)) {
  if (!empty($model)) {
    header("Location: {$foundPage}?dong=" . urlencode($model));
  } else {
    header("Location: {$foundPage}");
  }
  exit;
}

  
// Nếu không khớp gì, fallback: tìm theo tên sản phẩm (tương tự ban đầu)
// Tách loại sản phẩm và model từ keyword
function parseKeywordFallback($keyword) {
  $parts = explode(' ', $keyword, 2);
  $type = $parts[0];
  $model = $parts[1] ?? '';
  return [$type, $model];
}

list($type, $model) = parseKeywordFallback($keyword);

$sql = "
  SELECT sp.loai_id
  FROM san_pham sp
  WHERE sp.ten_san_pham REGEXP '[[:<:]]" . $connect->real_escape_string($type) . "[[:>:]]'
  LIMIT 1
";

$result = $connect->query($sql);
if ($row = $result->fetch_assoc()) {
  switch ($row['loai_id']) {
    case 1: $page = 'iphone.php'; break;
    case 2: $page = 'ipad.php'; break;
    case 3: $page = 'macbook.php'; break;
    case 4: $page = 'watch.php'; break;
    case 5: $page = 'am-thanh.php'; break;
    case 6: $page = 'phukien.php'; break;
    default: $page = 'home.php'; break;
  }
  if (!empty($model)) {
    header("Location: {$page}?dong=" . urlencode($model));
  } else {
    header("Location: {$page}");
  }
  exit;
} else {
  echo "<script>alert('Không tìm thấy sản phẩm phù hợp!'); window.location='home.php';</script>";
}