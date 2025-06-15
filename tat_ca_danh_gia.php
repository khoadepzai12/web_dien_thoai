<?php

session_start(); // Nếu chưa gọi

include 'header.php';

include 'connect.php';

$id = (int) ($_GET['id'] ?? 0);
$page = (int) ($_GET['page'] ?? 1);
$limit = 5;
$start = ($page - 1) * $limit;

$sao_filter = $_GET['sao'] ?? 'all';
$sort_order = $_GET['sort'] ?? 'desc';
$order_by = ($sort_order === 'asc') ? 'ASC' : 'DESC';

// --- Truy vấn sản phẩm ---
$sql_sp = "SELECT ten_san_pham FROM san_pham WHERE id = $id";
$sp = mysqli_fetch_assoc(mysqli_query($conn, $sql_sp));

// --- Điều kiện lọc ---
$where = "dg.san_pham_id = $id";
if (is_numeric($sao_filter)) {
  $where .= " AND dg.so_sao = $sao_filter";
}

// --- Đếm tổng đánh giá (cho phân trang) ---
$count_sql = "SELECT COUNT(*) AS tong FROM danh_gia dg WHERE $where";
$tong_dg = mysqli_fetch_assoc(mysqli_query($conn, $count_sql))['tong'];
$tong_trang = ceil($tong_dg / $limit);

// --- Lấy danh sách đánh giá ---
$sql = "
  SELECT dg.*, kh.ho_ten, img.ten_file AS hinh_anh
  FROM danh_gia dg
  JOIN khach_hang kh ON dg.khach_hang_id = kh.id
  LEFT JOIN (
    SELECT san_pham_id, MIN(ten_file) AS ten_file
    FROM hinh_anh_san_pham
    GROUP BY san_pham_id
  ) AS img ON dg.san_pham_id = img.san_pham_id
  WHERE $where
  ORDER BY dg.ngay_danh_gia $order_by
  LIMIT $start, $limit
";
$danh_gia = mysqli_query($conn, $sql);
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= $sp['ten_san_pham'] ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- Bootstrap + FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap" rel="stylesheet">
  <!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <style>
   
    body {
      margin: 0;
    font-family: 'Poppins', sans-serif;
      background-color: while;
      color: black;
      
    }
      header {
      height: 70px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 20px;
      top: 0;
      z-index: 999;
      background-color: black;
    }

    .logo-area {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .topzone-logo {
      height: 60px;
    }

    .apple-logo {
      height: 70px;
    }

    .menu {
      display: flex;
      flex: 1;
      justify-content: space-evenly;
      list-style: none;
      margin: 0 40px;
      padding: 0;
      height: 100%;
    }

    .menu li {
      flex: 1;
      text-align: center;
       height: 60px; /* hoặc chiều cao của header */
    }

    .menu li a {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100%;
      width: 100%;

      color: white;
      text-decoration: none;
      font-size: 15px;
      font-weight: 600;
      transition: background-color 0.3s, color 0.3s;
    }

    .menu li a:hover{
      background-color:black;
      color:white;
    }

    .icon-area {
      display: flex;
      gap: 10px;
    }

    .circle-btn {
      width: 36px;
      height: 36px;
      background-color: #2f3033;
      border-radius: 50%;
      color: white;
      font-size: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    .circle-btn .badge {
      position: absolute;
      top: -6px;
      right: -6px;
      background-color: red;
      color: white;
      font-size: 11px;
      padding: 2px 5px;
      border-radius: 50%;
    }
    .accordion-button {
      border: 1px solid #ccc !important;
      border-radius: 8px !important;
      background-color: #f8f9fa;
    }
    .accordion-item {
      border: 1px solid #ccc;
      border-radius: 8px;
      margin-bottom: 10px;
    }
    .review-box {
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 15px;
      margin-top: 1rem;
      background-color: #fff;
    }
    .review-box strong {
      color: #f4c150;
    }
    .review-box .btn {
      margin-right: 10px;
    }
    .review-box .border-bottom {
      padding: 0.5rem 0;
    }
    .thumb-img {
  transition: transform 0.2s;
  border: 2px solid transparent;
}
.thumb-img:hover {
transform: scale(1.1);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  z-index: 3;}

/* Thumbnail đang active */
.active-thumb {
  border: 2px solidrgba(10, 10, 10, 0.42) !important; /* màu xanh bootstrap */
}
#thumbnailContainer {
  scrollbar-width: none;        /* Firefox */
  -ms-overflow-style: none;     /* IE, Edge */
}

#thumbnailContainer::-webkit-scrollbar {
  display: none;                /* Chrome, Safari */
}
/* Link trong footer */
.footer-info a {
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
  font-weight: 400 !important;
  font-size: 16px !important;
  color: #ffffff;
  text-decoration: none;
  transition: color 0.3s ease;
}


/* Link màu xanh riêng (ví dụ "Tích điểm VIP") */
.footer-info a.text-info {
  color: #0d6efd;
  font-weight: 400 !important;
}

/* Hover link chung */
.footer-info a:hover {
  color: #0d6efd !important;
  font-weight: 400 !important;

}
/* hình tròn logo*/
.circle-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background-color: #2f3033;
  color: white;
  text-decoration: none;
  transition: background-color 0.3s ease, color 0.3s ease;
}

.circle-icon:hover {
  background-color: #0d6efd; /* xanh nhạt Bootstrap */
  color: #fff;
}
.text-truncate {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}


  
  </style>
</head>






<body>



    <div  class="container-fluid py-4 "style="padding-left: 30px; padding-right: 30px; max-width: 90%; margin-left: auto; margin-right: auto;">



  <!--------------------------------------------------------------------------------------------------------- -->

  <div class="row">



<!-- đánh giá--------------------------------->
  <h3 class="fw-bold text-dark mb-3">
    <?= $tong_dg ?> đánh giá <?= htmlspecialchars($sp['ten_san_pham']) ?>
  </h3>


  <div class="border rounded p-4 bg-white shadow-sm mt-4">
  <h4 class="mb-4" style="font-weight: 600;">💬 Đánh giá sản phẩm</h4>
  <!-- đặt ngay sau đây -->
<?php
$total_reviews = 0;
$star_counts = [];

for ($i = 5; $i >= 1; $i--) {
  $query = "SELECT COUNT(*) as count FROM danh_gia WHERE san_pham_id = $id AND so_sao = $i";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);
  $star_counts[$i] = $row['count'];
  $total_reviews += $row['count'];
}
?>
<!-- Thống kê đánh giá tổng quan -->
<div class="bg-light p-3 rounded mb-4">
  <h6 class="fw-bold mb-3">📊 Đánh giá tổng quan</h6>
  <?php foreach ($star_counts as $sao => $so_luong): 
    $percent = $total_reviews > 0 ? round(($so_luong / $total_reviews) * 100) : 0;
  ?>
    <div class="d-flex align-items-center mb-1">
      <div style="width: 60px;"><?= $sao ?> sao</div>
      <div class="progress flex-grow-1 mx-2" style="height: 8px;">
        <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $percent ?>%;"></div>
      </div>
      <div style="width: 40px;"><?= $so_luong ?></div>
    </div>
  <?php endforeach; ?>
</div>
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">

  <!-- Bộ lọc số sao -->
  <div class="filter-stars d-flex align-items-center flex-wrap gap-2">
    <strong class="me-2">Lọc đánh giá:</strong>
    <button class="btn btn-outline-dark btn-sm filter-btn active" data-sao="all">Tất cả</button>
    <?php for ($i = 5; $i >= 1; $i--): ?>
      <button class="btn btn-outline-secondary btn-sm filter-btn" data-sao="<?= $i ?>">
        <?= $i ?> <i class="fa fa-star text-warning"></i>
      </button>
    <?php endfor; ?>
  </div>

  <!-- Bộ lọc xếp theo sao -->
  <div>
    <select id="sortDanhGia" class="form-select form-select-sm w-auto">
      <option value="desc">Số sao cao nhất</option>
      <option value="asc">Số sao thấp nhất</option>
    </select>
  </div>
</div>


<div class="review-box mb-4">
  <?php
  mysqli_data_seek($danh_gia, 0);
  $count = mysqli_num_rows($danh_gia);

  if ($count > 0) {
    $i = 0;
    while ($dg = mysqli_fetch_assoc($danh_gia)) {
        echo "<div class='border-bottom pb-3 mb-3'>";
        echo "<div class='d-flex justify-content-between align-items-center'>";
        echo "<strong>" . htmlspecialchars($dg['ho_ten']) . "</strong>";
        echo "<span class='text-warning fw-bold'>⭐ {$dg['so_sao']}/5</span>";
        echo "</div>";
        echo "<p class='mb-1 text-muted'>" . nl2br(htmlspecialchars($dg['binh_luan'])) . "</p>";
        echo "<small class='text-secondary'>" . date('d/m/Y H:i', strtotime($dg['ngay_danh_gia'])) . "</small>";
        echo "</div>";
        $i++;
    }

    // 👉 Hiển thị nút "Xem tất cả" nếu có nhiều hơn 3
    if ($count > 3) {
      echo '<a href="#allReviews" class="btn btn-outline-dark btn-sm mb-3">Xem tất cả đánh giá</a>';
    }

  } else {
    echo "<div class='alert alert-warning'> Không có đánh giá nào với số sao này.</div>";
  }
  ?>
</div>


  

  <?php if (isset($_SESSION['khach_hang_id'])): ?>
  <div id="formDanhGia" class="collapse mt-3">
    <form id="ajaxReviewForm">
      <input type="hidden" name="san_pham_id" value="<?= $id ?>">

      <div class="mb-3">
        <label class="form-label fw-semibold">Chọn số sao:</label>
        <select name="so_sao" class="form-select w-25" required>
          <option value="5">5 ⭐ - Tuyệt vời</option>
          <option value="4">4 ⭐ - Tốt</option>
          <option value="3">3 ⭐ - Bình thường</option>
          <option value="2">2 ⭐ - Tạm được</option>
          <option value="1">1 ⭐ - Tệ</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Nhận xét của bạn:</label>
        <textarea name="binh_luan" class="form-control" rows="4" placeholder="Chia sẻ trải nghiệm sử dụng..." required></textarea>
      </div>

      <button type="submit" class="btn btn-success px-4">Gửi đánh giá</button>

      <!-- Thông báo -->
      <div id="thongBaoDanhGia" class="mt-3"></div>
    </form>
  </div>
  <?php else: ?>
    <div class="alert alert-warning mt-3">
      Vui lòng <a href="dangki.php">đăng nhập</a> để có thể đánh giá sản phẩm.
    </div>
  <?php endif; ?>
</div>

</div>
<script>
  document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      const sao = this.dataset.sao;
      const sort = document.getElementById('sortDanhGia').value;
      const url = new URL(window.location.href);
      url.searchParams.set('sao', sao);
      url.searchParams.set('sort', sort);
      window.location.href = url.toString();
    });
  });

  document.getElementById('sortDanhGia').addEventListener('change', function () {
    const sao = document.querySelector('.filter-btn.active')?.dataset.sao || 'all';
    const sort = this.value;
    const url = new URL(window.location.href);
    url.searchParams.set('sao', sao);
    url.searchParams.set('sort', sort);
    window.location.href = url.toString();
  });
</script>

<script>
document.getElementById('ajaxReviewForm').addEventListener('submit', function (e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);

  fetch('xu_ly_danh_gia.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(data => {
    document.getElementById('thongBaoDanhGia').innerHTML = data;
    form.reset();
  })
  .catch(err => {
    document.getElementById('thongBaoDanhGia').innerHTML = "<div class='alert alert-danger'>Lỗi gửi đánh giá!</div>";
  });
});
</script>




    
  <!-- Sản phẩm liên quan -->
 
        </div>


  <!-- Section: Footer -->
<!-- Footer phần 1: Logo -->
<div class="footer-logo text-white d-flex align-items-center" style="height: 100px; background-color: #000;">
    <div class="col-md-1 mb-4"></div>

  <div class="container-fluid ps-5 d-flex align-items-center gap-4">
    <img src="img/logo-topzone-removebg-preview.png" alt="TopZone Logo" style="height: 70px;">
    <img src="img/tao1.png" alt="Apple Reseller" style="height: 80px;">
  </div>
</div>

<!-- Footer phần 2: Thông tin -->
<footer class="footer-info bg-black text-white pt-5">
  <div class="container-fluid px-5">
    <div class="row text-start text-md-start">
  <div class="col-md-1 mb-4"></div>

      <!-- Cột 1 -->
      <div class="col-md-2 mb-4">
        <h6 class="fw-bold">Tổng đài</h6>
        <p class="mb-1">Mua hàng: <a href="tel:19009696.42" class="text-info text-decoration-none fw-normal">1900.9696.42</a> (8:00 – 21:30)</p>
        <p class="mb-1">Khiếu nại: <a href="tel:19009868.43" class="text-info text-decoration-none fw-normal">1900.9868.43</a> (8:00 – 21:30)</p>
        <h6 class="mt-4 fw-bold">Kết nối với chúng tôi</h6>
        <div class="d-flex gap-3 mt-2">
        <a href="#" class="circle-icon"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="circle-icon"><i class="fab fa-youtube"></i></a>
        <a href="#" class="circle-icon"><i class="fas fa-phone-alt"></i></a>
        </div>

      </div>

      <!-- Cột 2 -->
      <div class="col-md-2   mb-4">
        <h6 class="fw-bold">Hệ thống cửa hàng</h6>
        <p><a href="#" class="text-white">Xem 85 cửa hàng</a></p>
        <p><a href="#" class="text-white">Nội quy cửa hàng</a></p>
        <p><a href="#" class="text-white">Chất lượng phục vụ</a></p>
        <p><a href="#" class="text-white">Chính sách bảo hành & đổi trả</a></p>
      </div>

      <!-- Cột 3 -->
      <div class="col-md-2 mb-4">
        <h6 class="fw-bold">Hỗ trợ khách hàng</h6>
        <p><a href="#" class="text-white">Điều kiện giao dịch chung</a></p>
        <p><a href="#" class="text-white">Hướng dẫn mua online</a></p>
        <p><a href="#" class="text-white">Chính sách giao hàng</a></p>
        <p><a href="#" class="text-white">Hướng dẫn thanh toán</a></p>
      </div>

      <!-- Cột 4 -->
      <div class="col-md-2 mb-4">
        <h6 class="fw-bold">Về TopZone</h6>
        <p><a href="#"  style="color: #00bfff; font-weight: 500;">Tích điểm Quà tặng VIP</a></p>
        <p><a href="#" class="text-white">Giới thiệu TopZone</a></p>
        <p><a href="#" class="text-white">Chính sách dữ liệu cá nhân</a></p>
        <p><a href="#"class="text-white">Xem bản mobile</a></p>
      </div>

  <!-- Cột 5 -->
    <div class="col-md-2 mb-4">
  <h6 class="fw-bold">Trung tâm bảo hành TopCare</h6>
  <p><a href="#" class="text-white text-decoration-none">Giới thiệu TopCare</a></p>
  </div>
    <div class="col-md-1 mb-4"></div>

  </div>
    </div>


  <!-- Footer phần cuối -->
  <div class="bg-dark text-secondary pt-3 pb-4">
    <div class="container-fluid px-5 small">
      <hr class="border-secondary">
      <p class="mb-0">
        © 2018. Công ty cổ phần Thế Giới Di Động. GPĐKKD: 0303217354 do sở KH & ĐT TP.HCM cấp ngày 02/01/2007.<br>
        Địa chỉ: 128 Trần Quang Khải, P.Tân Định, Q.1, TP. Hồ Chí Minh. Điện thoại: 028 38125960. <br>
        Địa chỉ liên hệ và gửi chứng từ: Lô T2-1.2, Đường D1, Đ. D1, P.Tân Phú, TP.Thủ Đức, TP.Hồ Chí Minh. <br>
        Chịu trách nhiệm nội dung: Huỳnh Văn Tốt. Email: hotrotdmt@thegioididong.com
      </p>
    </div>
  </div>
</footer>




</body>
</html>