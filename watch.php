<?php
session_start(); // Nếu chưa gọi

include 'connect.php';
include 'header.php';
?>
<!DOCTYPE html>
<meta name="viewport" content="width=1300">

<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>TopZone Menu Clone</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
  
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
      background-color: #000;
      color: white;
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
    /*banner */
    .banner-img {
    max-height: 284px;
    object-fit: cover;
    object-position: center;
  }

  .carousel {
    margin-top: 0;
  }

  .carousel-control-prev-icon,
  .carousel-control-next-icon {
    background-color: rgba(0, 0, 0, 0.4);
    border-radius: 50%;
    padding: 10px;
  }

  .carousel-indicators [data-bs-target] {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #bbb;
    margin: 5px;
  }

  .carousel-indicators .active {
    background-color: #0dcaf0;
  }
  /*video foother */
.hero-video-wrapper {
  height: 100vh;
  max-height: 700px;
}

.hero-video {
  position: absolute;
  top: 0;
  left: 0;
  object-fit: cover;
  z-index: 0;
}

.gradient-overlay {
  z-index: 1;
  background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.9));
}

.hero-content {
  z-index: 2;
}
.footer-info {
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
}
.footer-info h6 {
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
  font-weight: 600;
  font-size: 20px;
}

.footer-info p {
  margin-bottom: 0.5rem;
}
/* dia chi*/
.store-box {
  max-width: 960px;
  margin: 0 auto;
  font-size: 1.1rem;
  background-color: #000;
}

.store-item {
  margin-bottom: 2rem;
  padding-bottom: 0.5rem;
  border-bottom: 1px solid #333;
}

.store-title {
  font-weight: bold;
  font-size: 1.15rem;
  margin-bottom: 4px;
}

.store-address {
  font-style: italic;             /* In nghiêng */
  color: #cccccc;                 /* Màu chữ nhạt (xám sáng) */
  font-size: 1rem;
  margin-bottom: 4px;
  font-weight: 400;              /* Không in đậm */
}


.store-pay {
  font-style: italic;
  color: #0d6efd;
  font-size: 1rem;
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



  </style>
</head>
<body>





<!-- BANNER CAROUSEL -->
<div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">

    <!-- Slide 1 -->
    <div class="carousel-item active">
      <img src="img/hinhbanner1.png" class="d-block w-100" alt="AirPods Pro 2">
    </div>

    <!-- Slide 2 -->
    <div class="carousel-item">
      <img src="img/banner2.png" class="d-block w-100" alt="Banner 2">
    </div>

    <!-- Slide 3 -->
    <div class="carousel-item">
      <img src="img/banner3.png" class="d-block w-100" alt="Banner 3">
    </div>

    <!-- Slide 4 -->
    <div class="carousel-item">
      <img src="img/banner4.png" class="d-block w-100" alt="Banner 4">
    </div>

    <!-- Slide 5 -->
    <div class="carousel-item">
      <img src="img/banner5.png" class="d-block w-100" alt="Banner 5">
    </div>
  </div>

  <!-- Controls -->
  <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
  </button>

  <!-- Indicators -->
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active"></button>
    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1"></button>
    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="2"></button>
    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="3"></button>
    <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="4"></button>
  </div>
</div>
<!-- bộ lọc máy -->
<section style="background-color: #2c2c2c; padding: 30px 0;">
  <div class="container">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-3">

      <?php $dong = $_GET['dong'] ?? ''; ?>

      <!-- Bộ lọc dòng Tai nghe / Loa -->
     <nav class="d-flex overflow-auto gap-3">
        <a href="watch.php" class="btn btn-sm border-0 pb-1 <?= empty($dong) ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Tất cả</a>
        <a href="?dong=series10" class="btn btn-sm border-0 pb-1 <?= $dong == 'series10' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Apple Watch Series 10</a>
        <a href="?dong=ultra2" class="btn btn-sm border-0 pb-1 <?= $dong == 'ultra2' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Apple Watch Ultra 2</a>
        <a href="?dong=series9" class="btn btn-sm border-0 pb-1 <?= $dong == 'series9' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Apple Watch Series 9</a>
        <a href="?dong=se2" class="btn btn-sm border-0 pb-1 <?= $dong == 'se2' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Apple Watch SE 2</a>
      </nav>
      <!-- Dropdown sắp xếp -->
      <div class="dropdown">
        <button class="btn btn-sm text-white dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Xếp theo: Nổi bật
        </button>
        <ul class="dropdown-menu dropdown-menu-dark">
          <li><a class="dropdown-item" href="?<?= http_build_query(array_merge($_GET, ['sort' => 'gia_asc'])) ?>">Giá tăng dần</a></li>
          <li><a class="dropdown-item" href="?<?= http_build_query(array_merge($_GET, ['sort' => 'gia_desc'])) ?>">Giá giảm dần</a></li>
        </ul>
      </div>

    </div>
  </div>
</section>
<!--Ipad----------------------------------------------------------- -->
   <?php
include 'connect.php';

$orderBy = "sp.id DESC";
if (isset($_GET['sort'])) {
  $orderBy = ($_GET['sort'] === 'gia_asc') ? "gia ASC" : (($_GET['sort'] === 'gia_desc') ? "gia DESC" : $orderBy);
}

$dong = $_GET['dong'] ?? '';

// Lấy sản phẩm iPad (loai_id = 3 chẳng hạn nếu bạn đặt iPad là 3 trong bảng `loai_san_pham`)
$sql = "
  SELECT sp.id, sp.ten_san_pham, sp.gia AS gia_goc, sp.phan_tram_giam,
         ROUND(sp.gia * (100 - sp.phan_tram_giam) / 100) AS gia,
         ha.ten_file
  FROM san_pham sp
  LEFT JOIN (
    SELECT san_pham_id, MIN(id) AS id_min
    FROM hinh_anh_san_pham
    GROUP BY san_pham_id
  ) ha_min ON sp.id = ha_min.san_pham_id
  LEFT JOIN hinh_anh_san_pham ha ON ha.id = ha_min.id_min
  WHERE sp.loai_id = 4
";

if (!empty($dong)) {
  $sql .= " AND sp.ma_san_pham LIKE '%ipad$dong%'";
}

$sql .= " ORDER BY $orderBy";

$result = $conn->query($sql);
if (!$result) {
  die("Lỗi truy vấn SQL: " . $connect->error);
}

$products = [];
while ($sp = $result->fetch_assoc()) {
  $products[] = $sp;
}

?>
<section style="background-color: #2c2c2c; padding: 70px 0;">
  <div class="slider-wrapper" style="position: relative; max-width: 1240px; margin: auto;">
    <div class="slider-container" style="overflow: hidden;">
      <div id="slider-track-phukien" style="display: flex; gap: 30px; transition: transform 0.4s ease;">
        <?php if (!empty($products)): ?>
          <?php foreach ($products as $sp): ?>
            <a href="chi_tiet_san_pham.php?id=<?= $sp['id']; ?>" style="text-decoration: none; color: inherit;">
              <div style="width: 285px; flex-shrink: 0; background-color: #323232; border-radius: 16px; padding: 20px; text-align: center; min-height: 480px;"
                   onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.3)'"
                   onmouseout="this.style.transform='none'; this.style.boxShadow='none'">
                <img src="/webphone/img/<?= htmlspecialchars($sp['ten_file']); ?>"
                     alt="<?= htmlspecialchars($sp['ten_san_pham']); ?>"
                     style="width: 100%; height: 210px; object-fit: contain;">

                <p style="color: white; font-size: 15px; margin-top: 10px;">
                  <?= $sp['ten_san_pham']; ?>
                </p>

                <p style="color: white; font-weight: bold; font-size: 18px; margin: 6px 0;">
                  <?= number_format($sp['gia'], 0, ',', '.'); ?>₫
                </p>

                <?php if (!empty($sp['gia_goc'])): ?>
                  <p style="color: #ccc; font-size: 13px; text-decoration: line-through;">
                    <?= number_format($sp['gia_goc'], 0, ',', '.'); ?>₫
                  </p>
                <?php endif; ?>

                <?php if (!empty($sp['phan_tram_giam'])): ?>
                  <p style="color: orange; font-size: 13px;">-<?= $sp['phan_tram_giam']; ?>%</p>
                <?php endif; ?>

                <p style="color: orange; font-size: 14px;">Online giá rẻ quá</p>
              </div>
            </a>
          <?php endforeach; ?>
        <?php else: ?>
          <div style="color: white; text-align: center; font-size: 16px;">Không có sản phẩm nào để hiển thị.</div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

    <?php
include 'footer.php'; 
?>




</body>
</html>
