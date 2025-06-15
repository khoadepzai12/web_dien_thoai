<?php
include 'connect.php'; // Kết nối MySQL
include 'header.php'; // Bao gồm header

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sql = "SELECT * FROM bai_viet WHERE id = $id AND hien_thi = 1";  // Add `hien_thi = 1` condition to show only visible posts
$result = $conn->query($sql);
$bv = $result->fetch_assoc();
if (!$bv) {
  echo "Bài viết không tồn tại!";
  exit;
}

// Lấy các đoạn nội dung từ bảng bai_viet_chi_tiet
$sql_noi_dung = "SELECT * FROM bai_viet_chi_tiet WHERE bai_viet_id = $id ORDER BY thu_tu ASC";
$result_noi_dung = $conn->query($sql_noi_dung);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($bv['tieu_de']) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
    body {
        background-color: #000000;
        font-family: Arial, sans-serif;
    }

    .container {
        max-width: 700px;
        width: 100%;
        margin: 0 auto;
        padding-left: 15px;
        padding-right: 15px;
    }

    .article-title-bar {
        background-color: #000000;
        color: white;
        padding: 30px 20px;
    }

    .article-title-bar h1 {
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.5;
    }

    .article-title {
        font-size: 1.8rem;
        font-weight: bold;
        text-transform: uppercase;
        margin: 0;
        line-height: 1.4;
    }

    .article-wrapper {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        margin-top: 0;
        margin-bottom: 50px;
        overflow: hidden;
    }

    .article-image {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 0;
        margin-bottom: 30px;
    }

    .article-body {
        padding: 30px;
    }

    .article-content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #495057;
        text-align: justify;
    }

    .article-content img {
        display: block;
        max-width: 120%;
        width: 120% !important;
        height: auto;
        margin: 0 auto 1rem auto;
        border-radius: 10px;
        text-align: center;
    }

    @media (max-width: 576px) {
        .article-title {
            font-size: 1.2rem;
        }

        .article-body {
            padding: 20px 15px;
        }

        .article-content {
            font-size: 0.95rem;
        }
    }
    </style>
</head>

<body>

    <!-- TIÊU ĐỀ NẰM NGOÀI VÙNG TRẮNG -->
    <div class="article-title-bar">
        <div class="container text-start">
            <h1 class="article-title"><?= htmlspecialchars($bv['tieu_de']) ?></h1>
        </div>
    </div>

    <!-- PHẦN BÀI VIẾT TRONG KHỐI TRẮNG -->
    <div class="container">
        <div class="article-wrapper">
            <img src="img/<?= $bv['thumbnail'] ?>" alt="Ảnh bài viết" class="article-image">
            <p style="text-align: center; font-size: 0.9rem; color: #777;">
                <em>Nguồn: <strong>Tom's Guide</strong></em>
            </p>
            <div class="article-body">
                <div class="article-content">
                    <?php while ($nd = $result_noi_dung->fetch_assoc()): ?>
                    <?php if ($nd['loai'] === 'noi_dung'): ?>
                    <p><?= nl2br(htmlspecialchars($nd['noidung_hoac_hinh'])) ?></p>
                    <?php elseif ($nd['loai'] === 'hinh_anh'): ?>
                    <img src="img/<?= htmlspecialchars($nd['noidung_hoac_hinh']) ?>" alt="Ảnh bài viết">
                    <?php endif; ?>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- BÀI VIẾT LIÊN QUAN -->
    <div class="container mb-5 position-relative">
        <h5 class="text-white fw-bold mb-4" style="border-left: 6px solid #00ffff; padding-left: 10px;">BÀI VIẾT LIÊN
            QUAN</h5>

        <!-- Nút điều hướng -->
        <button id="prevBtn" class="btn btn-dark position-absolute top-50 start-0 translate-middle-y z-1"
            style="border-radius: 50%;">‹</button>
        <button id="nextBtn" class="btn btn-dark position-absolute top-50 end-0 translate-middle-y z-1"
            style="border-radius: 50%;">›</button>

        <!-- Slider ngang -->
        <div id="relatedSlider" class="d-flex overflow-auto gap-3 px-2 scroll-smooth" style="scroll-behavior: smooth;">
            <?php
      $sql_lien_quan = "SELECT id, tieu_de, thumbnail, ngay_dang FROM bai_viet 
                        WHERE loai_bai_viet = 'tin_tuc' AND hien_thi = 1 
                        AND id != $id 
                        ORDER BY ngay_dang DESC 
                        LIMIT 10";
      $rs_lien_quan = $conn->query($sql_lien_quan);

      while ($bv_lq = $rs_lien_quan->fetch_assoc()):
        $link = "chi_tiet_bai_viet.php?id=" . $bv_lq['id'];
        $img = "img/" . htmlspecialchars($bv_lq['thumbnail']);
        $title = htmlspecialchars($bv_lq['tieu_de']);
        $date = date("d/m/Y", strtotime($bv_lq['ngay_dang']));
      ?>
            <a href="<?= $link ?>" class="text-decoration-none flex-shrink-0" style="width: 250px;">
                <div class="card bg-dark text-white h-100 border-0 rounded-4 overflow-hidden">
                    <img src="<?= $img ?>" class="card-img-top" style="height: 160px; object-fit: cover;"
                        alt="<?= $title ?>">
                    <div class="card-body">
                        <h6 class="card-title" style="font-size: 15px;"><?= $title ?></h6>
                        <p class="card-text text-secondary" style="font-size: 13px;"><?= $date ?></p>
                    </div>
                </div>
            </a>
            <?php endwhile; ?>
        </div>
    </div>

    <script>
    const slider = document.getElementById("relatedSlider");
    const nextBtn = document.getElementById("nextBtn");
    const prevBtn = document.getElementById("prevBtn");

    if (slider && nextBtn && prevBtn) {
        nextBtn.addEventListener("click", () => {
            slider.scrollBy({
                left: 300,
                behavior: 'smooth'
            });
        });

        prevBtn.addEventListener("click", () => {
            slider.scrollBy({
                left: -300,
                behavior: 'smooth'
            });
        });
    }
    </script>
</body>

</html>
<?php include 'fooder1.php'; ?>