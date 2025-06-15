<?php
session_start(); // Nếu chưa gọi

include 'connect.php';
include 'header.php';
include 'chi_tiet_san_pham2.php';

$id = $_GET['id'] ?? 0;

// Lấy sản phẩm hiện tại (biến thể)
$sql = "SELECT * FROM san_pham WHERE id = $id";
$result = mysqli_query($conn, $sql);
if (!$result || mysqli_num_rows($result) == 0) {
    die("Sản phẩm không tồn tại.");
}
$ct = mysqli_fetch_assoc($result);  // Biến thể hiện tại

// Lấy danh sách các sản phẩm cùng ma_san_pham
$ma_sp = $ct['ma_san_pham'];
$result_all = mysqli_query($conn, "SELECT * FROM san_pham WHERE ma_san_pham = '$ma_sp'");

$list_dungluong = [];
$list_mausac = [];
while ($row = mysqli_fetch_assoc($result_all)) {
    $dl = $row['dung_luong'];
    $mau = $row['mau_sac'];
    $list_dungluong[$dl][$mau] = $row['id'];
    $list_mausac[$dl][$mau] = [
        'ma_mau' => $row['ma_mau'],
        'gia' => $row['gia'],
        'phan_tram_giam' => $row['phan_tram_giam']
    ];
}
// Tính giá gốc
$gia = $ct['gia'];
$giam = $ct['phan_tram_giam'];
$gia_goc = $giam > 0 ? round($gia - ($gia*( $giam /100)), -3) : $gia;
// Dọn tên sản phẩm
function cleanTenSanPham($ten, $dungluong) {
    $pattern = preg_quote(trim($dungluong), '/');
    $ten = preg_replace('/\b' . $pattern . '\b/i', '', $ten);
    return trim(preg_replace('/\s+/', ' ', $ten));
}
$ten_sp_clean = cleanTenSanPham($ct['ten_san_pham'], $ct['dung_luong']);

// Ảnh phụ, phụ kiện, đánh giá, bài viết
$anh_phu = mysqli_query($conn, "SELECT * FROM hinh_anh_san_pham WHERE san_pham_id = $id");
$phu_kien = mysqli_query($conn, "SELECT * FROM san_pham WHERE loai_id = 6 LIMIT 4");
$danh_gia = mysqli_query($conn, "SELECT * FROM danh_gia WHERE san_pham_id = $id");
$bai_viet = mysqli_query($conn, "SELECT * FROM bai_viet WHERE hien_thi = 1 AND loai_bai_viet = 'tin_tuc' AND san_pham_id = $id ORDER BY ngay_dang DESC");
$mo_ta = $ct['mo_ta'] ?? '';

// Thông tin đã bán
$sql_ban = "SELECT SUM(so_luong) AS tong_ban FROM don_hang_chi_tiet WHERE san_pham_id = $id";
$result_ban = mysqli_query($conn, $sql_ban);
$tong_ban = ($result_ban && $row = mysqli_fetch_assoc($result_ban)) ? $row['tong_ban'] : 0;

// Trung bình sao
$sql_sao = "SELECT AVG(so_sao) AS diem_tb FROM danh_gia WHERE san_pham_id = $id";
$result_sao = mysqli_query($conn, $sql_sao);
$diem_tb = ($result_sao && $row = mysqli_fetch_assoc($result_sao)) ? round($row['diem_tb'], 1) : 0;

// Dữ liệu đã sẵn: $ct (biến thể), $list_dungluong, $list_mausac, $gia_goc, $ten_sp_clean
// => Dùng trong giao diện chi_tiet_san_pham.php


// Truy vấn lấy đánh giá + tên khách hàng (JOIN)
$sql = "SELECT dg.*, kh.ho_ten
        FROM danh_gia dg
        JOIN khach_hang kh ON dg.khach_hang_id = kh.id
        WHERE dg.san_pham_id = $id
        ORDER BY dg.ngay_danh_gia DESC";

$danh_gia = mysqli_query($conn, $sql);


$id = $_GET['id'] ?? 0;
$khach_hang_id = $_SESSION['khach_hang_id'] ?? null;
$thong_bao = '';

// Lấy danh sách đánh giá JOIN với tên khách
$sql = "SELECT dg.*, kh.ho_ten
        FROM danh_gia dg
        JOIN khach_hang kh ON dg.khach_hang_id = kh.id
        WHERE dg.san_pham_id = $id
        ORDER BY dg.ngay_danh_gia DESC";
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
        height: 60px;
        /* hoặc chiều cao của header */
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

    .menu li a:hover {
        background-color: black;
        color: white;
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
        z-index: 3;
    }

    /* Thumbnail đang active */
    .active-thumb {
        border: 2px solidrgba(10, 10, 10, 0.42) !important;
        /* màu xanh bootstrap */
    }

    #thumbnailContainer {
        scrollbar-width: none;
        /* Firefox */
        -ms-overflow-style: none;
        /* IE, Edge */
    }

    #thumbnailContainer::-webkit-scrollbar {
        display: none;
        /* Chrome, Safari */
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
        background-color: #0d6efd;
        /* xanh nhạt Bootstrap */
        color: #fff;
    }

    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    </style>
</head>
<script>
// Nút lướt thumbnail trái/phải
function scrollThumbnail(direction) {
    const container = document.getElementById('thumbnailContainer');
    const scrollAmount = container.clientWidth * 0.9; // Lướt theo chiều rộng container
    container.scrollBy({
        left: direction * scrollAmount,
        behavior: 'smooth'
    });
}

// Click ảnh nhỏ → chuyển ảnh lớn tương ứng
function goToSlide(index) {
    const carousel = document.querySelector('#carouselAnhPhu');
    const instance = bootstrap.Carousel.getOrCreateInstance(carousel);
    instance.to(index);
}

// Khi ảnh lớn chuyển → cập nhật ảnh nhỏ + cuộn thumbnail mượt, không scroll toàn trang
document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.getElementById('carouselAnhPhu');
    carousel.addEventListener('slid.bs.carousel', function(e) {
        const index = e.to;
        const thumbnails = document.querySelectorAll('.thumbnail-item');
        const container = document.getElementById('thumbnailContainer');

        thumbnails.forEach((thumb, i) => {
            if (i === index) {
                thumb.classList.add('border-primary', 'border-2');

                // ✅ Scroll ngang mượt trong container, không ảnh hưởng toàn trang
                const containerRect = container.getBoundingClientRect();
                const thumbRect = thumb.getBoundingClientRect();
                const scrollOffset = thumbRect.left - containerRect.left - container
                    .clientWidth / 2 + thumbRect.width / 2;

                container.scrollBy({
                    left: scrollOffset,
                    behavior: 'smooth'
                });

            } else {
                thumb.classList.remove('border-primary', 'border-2');
            }
        });
    });
});

function themVaoGio(spId) {
    fetch('them_vao_gio_ajax.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id=' + spId
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Cập nhật số giỏ hàng
                document.getElementById('cart-count').innerText = data.so_luong;
            } else {
                alert('Thêm vào giỏ thất bại');
            }
        })
        .catch(err => {
            alert('Lỗi kết nối: ' + err);
        });
}
</script>



<body>



    <div class="container-fluid py-4 "
        style="padding-left: 30px; padding-right: 30px; max-width: 90%; margin-left: auto; margin-right: auto;">
        <!-- Tên sản phẩm -->
        <div class="mb-3">
            <h2 class="mb-1">
                <?= $ten_sp_clean ?>
                <span class="text-dark"><?= $ct['dung_luong'] ?></span>
                <span class="text-dark"><?= $ct['mau_sac'] ?></span>
            </h2>
            <span class="badge bg-dark text-warning">Chỉ có tại <strong>Topzone</strong></span>
            <span>Đã bán <?= $tong_ban ?> </span>
            <span class="text-warning">⭐ <?= $diem_tb ?></span>
            <a href="#thongSo" class="text-decoration-none text-primary">Thông số</a>

        </div>



        <!--------------------------------------------------------------------------------------------------------- -->

        <div class="row">

            <!-- CỘT TRÁI -->
            <div class="col-md-6">
                <div class="p-4 border rounded bg-light shadow-sm">


                    <!-- Carousel Ảnh lớn -->
                    <div id="carouselAnhPhu" class="carousel slide mb-3" data-bs-ride="carousel">
                        <div class="carousel-inner text-center">
                            <?php
      $i = 0;
      mysqli_data_seek($anh_phu, 0);
      while ($a = mysqli_fetch_assoc($anh_phu)) {
        $active = $i === 0 ? 'active' : '';
        echo "
        <div class='carousel-item $active'>
          <img src='img/{$a['ten_file']}' class='img-fluid' style='max-height: 400px; object-fit: contain;'>
        </div>";
        $i++;
      }
      ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselAnhPhu"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselAnhPhu"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>

                    <!-- Thumbnail cuộn ngang có nút -->

                    <!-- Wrapper có vị trí tương đối -->
                    <div class="position-relative">

                        <!-- Nút trái -->
                        <button class="btn position-absolute top-50 start-0 translate-middle-y z-2 bg-white shadow"
                            style="width: 36px; height: 60px; border-radius: 10px 0 0 10px;"
                            onclick="scrollThumbnail(-1)">
                            <span class="carousel-control-prev-icon"></span>
                        </button>

                        <!-- Gradient mờ bên trái -->
                        <div class="position-absolute start-0 top-0 bottom-0 z-1"
                            style="width: 40px; background: linear-gradient(to right, #fff, transparent); pointer-events: none;">
                        </div>

                        <!-- Thumbnail container -->
                        <div class="d-flex overflow-auto gap-2 px-5 mb-3" id="thumbnailContainer"
                            style="scroll-behavior: smooth;">
                            <?php
    mysqli_data_seek($anh_phu, 0);
    $i = 0;
    while ($a = mysqli_fetch_assoc($anh_phu)) {
      $active = $i === 0 ? "border-primary border-2" : "";
      echo "<img src='img/{$a['ten_file']}' 
                class='img-thumbnail thumbnail-item $active' 
                data-index='$i'
                style='width: 80px; cursor: pointer;' 
                onclick='goToSlide($i)'>";
      $i++;
    }
    ?>
                        </div>

                        <!-- Gradient mờ bên phải -->
                        <div class="position-absolute end-0 top-0 bottom-0 z-1"
                            style="width: 40px; background: linear-gradient(to left, #fff, transparent); pointer-events: none;">
                        </div>

                        <!-- Nút phải -->
                        <button class="btn position-absolute top-50 end-0 translate-middle-y z-2 bg-white shadow"
                            style="width: 36px; height: 60px; border-radius: 0 10px 10px 0;"
                            onclick="scrollThumbnail(1)">
                            <span class="carousel-control-next-icon"></span>
                        </button>

                    </div>


                </div>





                <!-- Cam kết -->
                <!-- Cam kết -->
                <div class="border rounded p-3 bg-light mt-4">
                    <strong>TOPZONE cam kết</strong>
                    <div class="row mt-2">
                        <div class="col-6 d-flex align-items-start mb-2">
                            <img src="img/box.png" width="24" class="me-2 mt-1">
                            <span>Sản phẩm mới (Cần thanh toán trước khi mở hộp).</span>
                        </div>
                        <div class="col-6 d-flex align-items-start mb-2">
                            <img src="img/box.png" width="24" class="me-2 mt-1">
                            <span>Bộ sản phẩm gồm: Hộp, Sách hướng dẫn, Cây lấy sim, Cáp Type C</span>
                        </div>
                        <div class="col-6 d-flex align-items-start mb-2">
                            <img src="img/return.png" width="24" class="me-2 mt-1">
                            <span>Hư gì đổi nấy 12 tháng tại 2955 siêu thị toàn quốc (miễn phí tháng đầu) <a>Xem chi
                                    tiết</a></span>
                        </div>
                        <div class="col-6 d-flex align-items-start mb-2">
                            <img src="img/shield.png" width="24" class="me-2 mt-1">
                            <span>Bảo hành chính hãng điện thoại 1 năm tại các trung tâm bảo hành hãng <a>Xem địa chỉ
                                    bảo hành</a></span>
                        </div>
                    </div>
                </div>


                <!-- Phụ kiện -->
                <h4 class="mt-5"
                    style="font-family: Arial, sans-serif; font-size: 22px; color: #333; font-weight: bold;">Phụ kiện
                    nên mua kèm</h4>
                <div class="row row-cols-1 row-cols-sm-2 g-3">
                    <?php while($pk = mysqli_fetch_assoc($phu_kien)) { ?>
                    <div class="col">
                        <a href="chi_tiet_san_pham.php?id=<?= $pk['id'] ?>" class="text-decoration-none text-dark">
                            <div class="border rounded p-3 h-100 d-flex align-items-center gap-3 flex-nowrap shadow-sm"
                                style="transition: all 0.3s ease; background-color: #f9f9f9;">
                                <img src="img/<?= $pk['id'] ?>.jpg" class="img-fluid"
                                    style="width: 80px; height: auto; flex-shrink: 0; border-radius: 8px;">
                                <div class="flex-grow-1 overflow-hidden">
                                    <strong class="d-block text-truncate"
                                        style="font-size: 16px; font-weight: bold; color: #333;"><?= $pk['ten_san_pham'] ?></strong>
                                    <span class="text-danger"
                                        style="font-size: 16px; font-weight: bold;"><?= number_format($pk['gia']) ?>₫</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php } ?>
                </div>

                <div id="thongSo" class="border rounded p-4 bg-light mt-4" style="font-family: 'Arial', sans-serif;">
                    <!-- Tabs Thông tin sản phẩm -->
                    <h1 class="mt-0" style="font-size: 33px; color: #333; font-weight: bold; text-align: center;">Thông
                        số kĩ thuật</h1>

                    <p style="font-size: 16px; color: #555;">
                        <?php echo nl2br(htmlspecialchars($mo_ta)); ?>
                    </p>
                </div>



                <!-- đánh giá--------------------------------->

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
                                <div class="progress-bar bg-warning" role="progressbar"
                                    style="width: <?= $percent ?>%;"></div>
                            </div>
                            <div style="width: 40px;"><?= $so_luong ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>


                    <div class="review-box mb-4">
                        <?php
    mysqli_data_seek($danh_gia, 0);
    $count = 0;
    while ($dg = mysqli_fetch_assoc($danh_gia)) {
        echo "<div class='border-bottom pb-3 mb-3'>";
        echo "<div class='d-flex justify-content-between align-items-center'>";
        echo "<strong>" . htmlspecialchars($dg['ho_ten']) . "</strong>";
        echo "<span class='text-warning fw-bold'>⭐ {$dg['so_sao']}/5</span>";
        echo "</div>";
        echo "<p class='mb-1 text-muted'>" . nl2br(htmlspecialchars($dg['binh_luan'])) . "</p>";
        echo "<small class='text-secondary'>" . date('d/m/Y H:i', strtotime($dg['ngay_danh_gia'])) . "</small>";
        echo "</div>";
        $count++;
        if ($count == 3) break;
    }
    if ($count == 0) echo "<p class='text-muted'>Chưa có đánh giá nào cho sản phẩm này.</p>";
    ?>

                        <?php if ($count >= 3): ?>
                        <a href="#allReviews" class="btn btn-outline-dark btn-sm mb-3">Xem tất cả đánh giá</a>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4 gap-3">
                        <a href="tat_ca_danh_gia.php?id=<?= $id ?>" class="btn btn-outline-dark w-50 py-3 fs-6">
                            Xem <?= $total_reviews ?> đánh giá
                        </a>

                        <button class="btn btn-dark w-50 py-3 fs-6" data-bs-toggle="collapse"
                            data-bs-target="#formDanhGia">
                            ✍️ Viết đánh giá
                        </button>
                    </div>


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
                                <textarea name="binh_luan" class="form-control" rows="4"
                                    placeholder="Chia sẻ trải nghiệm sử dụng..." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-dark w-50 py-3 fs-6-center mx-auto d-block">Gửi đánh
                                giá</button>

                            <!-- Thông báo -->
                            <div id="thongBaoDanhGia" class="mt-3"></div>
                        </form>
                    </div>
                </div>

            </div>
            <script>
            document.getElementById('ajaxReviewForm').addEventListener('submit', function(e) {
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
                        document.getElementById('thongBaoDanhGia').innerHTML =
                            "<div class='alert alert-danger'>Lỗi gửi đánh giá!</div>";
                    });
            });
            </script>




            <!-- CỘT PHẢI -->
            <div class="col-md-6">
                <div class="p-3 border rounded bg-white shadow-sm">


                    <!-- Ảnh khuyến mãi responsive -->
                    <img src="img/khuyen_mai.png" alt="Ảnh sản phẩm" class="img-fluid w-100"
                        style="max-width: auto; height: auto;">



                    <!-- Chọn dung lượng -->
                    <div class="mb-3">
                        <strong>Dung lượng:</strong><br>
                        <?php foreach ($list_dungluong as $dl => $ds_mau): ?>
                        <?php 
      $first_mau = array_key_first($ds_mau);
      $id_moi = $ds_mau[$first_mau]; // ID tương ứng với dung lượng đó + màu đầu tiên
    ?>
                        <a href="?id=<?= $id_moi ?>"
                            class="btn btn-outline-secondary <?= $dl === $ct['dung_luong'] ? 'active' : '' ?>">
                            <?= $dl ?>
                        </a>
                        <?php endforeach; ?>
                    </div>

                    <!-- Chọn màu sắc -->

                    <div class="mb-4">
                        <strong>Màu sắc:</strong><br>
                        <div class="d-flex gap-2">
                            <?php foreach ($list_mausac[$ct['dung_luong']] as $mau => $data): ?>
                            <?php $id_moi = $list_dungluong[$ct['dung_luong']][$mau]; ?>
                            <a href="?id=<?= $id_moi ?>" title="<?= $mau ?>"
                                class="rounded-circle border <?= $mau === $ct['mau_sac'] ? 'border-3 border-primary' : '' ?>"
                                style="display:inline-block; width:36px; height:36px; background-color:<?= $data['ma_mau'] ?? '#ccc' ?>;">
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- Giá sản phẩm -->
                    <div class="mb-3">
                        <h3 class="text-danger d-inline-block me-2"><?= number_format($gia_goc) ?>₫</h3>

                        <?php if ($giam > 0): ?>
                        <span class="text-muted d-inline-block">
                            <del><?= number_format($gia) ?>₫</del>
                            - Giảm <?= $giam ?>%
                        </span>
                        <?php endif; ?>
                    </div>






                    <!-- Khuyến mãi -->
                    <div class="border rounded p-4 bg-light mt-3" style="font-family: 'Arial', sans-serif;">
                        <strong style="font-size: 18px; color: #333;">Khuyến mãi trị giá <span
                                style="color: #e60000;">500.000₫</span></strong>
                        <ol class="mt-3 ps-4" style="list-style-type: decimal; font-size: 16px; color: #555;">
                            <li class="mb-2"><i class="fas fa-gift" style="color: #e60000;"></i> Phiếu mua hàng AirPods,
                                Apple Watch, Macbook trị giá <span style="color: #e60000;">500.000₫</span></li>
                            <li class="mb-2"><i class="fas fa-gift" style="color: #e60000;"></i> Phiếu mua hàng máy lạnh
                                trị giá <span style="color: #e60000;">300.000₫</span> <a href="#" target="_blank"
                                    style="color: #007bff; text-decoration: none;">(Xem chi tiết tại đây)</a></li>
                            <li class="mb-2"><i class="fas fa-gift" style="color: #e60000;"></i> Phiếu mua hàng áp dụng
                                mua Sạc dự phòng, Tai nghe và Loa bluetooth trị giá <span
                                    style="color: #e60000;">100.000₫</span></li>
                            <li class="mb-2"><i class="fas fa-gift" style="color: #e60000;"></i> Phiếu mua hàng máy lọc
                                nước trị giá <span style="color: #e60000;">300.000₫</span></li>
                            <li class="mb-2"><i class="fas fa-gift" style="color: #e60000;"></i> Phiếu mua hàng áp dụng
                                cho các sim Gmobile, Itel, Vina trị giá <span style="color: #e60000;">50.000₫</span> <a
                                    href="#" target="_blank" style="color: #007bff; text-decoration: none;">(Xem chi
                                    tiết tại đây)</a></li>
                            <li class="mb-2"><i class="fas fa-gift" style="color: #e60000;"></i> Nhập mã VNPAYTGDD3 giảm
                                từ <span style="color: #e60000;">80.000₫</span> đến <span
                                    style="color: #e60000;">150.000₫</span> khi thanh toán qua VNPAY-QR <a href="#"
                                    target="_blank" style="color: #007bff; text-decoration: none;">(Xem chi tiết tại
                                    đây)</a></li>
                        </ol>
                        <p class="text-warning mb-2" style="font-size: 16px;">• Giao hàng nhanh chóng (tùy khu vực)</p>
                        <p class="text-warning mb-0" style="font-size: 16px;">• Mỗi số điện thoại chỉ mua 3 sản phẩm
                            trong 1 tháng</p>
                    </div>



                    <!-- Hộp chứa nút -->
                    <div class="text-center mt-4">


                        <!-- Nút Thêm vào giỏ -->
                        <form action="" method="post" style="display:inline;">
                            <input type="hidden" name="product_id" value="<?= $id ?>">
                            <input type="hidden" class="form-control" id="quantity" name="quantity" value="1">
                            <button name="add_to_cart" type="submit"
                                class="btn btn-outline-danger btn-lg px-4 py-3 w-100 w-md-auto mt-2">
                                <i class="bi bi-cart-plus me-2"></i> Mua hàng
                            </button>
                        </form>






                    </div>
                    <br>

                    <div class="shipping-info"
                        style="font-family: Arial, sans-serif; font-size: 18px; line-height: 1.6;">
                        <p><strong style="font-size: 20px; color: #333;">🚚 Giao tiết kiệm</strong></p>
                        <p style="font-size: 18px; color: #555;">Giao từ 12h - 14h, ngày mai (05/06): <span
                                style="color: green; font-weight: bold;">Miễn phí</span></p>
                    </div>
                    <div class="order-call" style="font-family: Arial, sans-serif; font-size: 18px; line-height: 1.6;">
                        <p><strong style="font-size: 20px; color: #333;">📞 Gọi đặt mua</strong> <a
                                href="tel:1900232460"
                                style="color: #007bff; text-decoration: none; font-weight: bold;">1900 232 460</a> (8:00
                            - 21:30)</p>
                    </div>




                </div>

            </div>
        </div>

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
                    <p class="mb-1">Mua hàng: <a href="tel:19009696.42"
                            class="text-info text-decoration-none fw-normal">1900.9696.42</a> (8:00 – 21:30)</p>
                    <p class="mb-1">Khiếu nại: <a href="tel:19009868.43"
                            class="text-info text-decoration-none fw-normal">1900.9868.43</a> (8:00 – 21:30)</p>
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
                    <p><a href="#" style="color: #00bfff; font-weight: 500;">Tích điểm Quà tặng VIP</a></p>
                    <p><a href="#" class="text-white">Giới thiệu TopZone</a></p>
                    <p><a href="#" class="text-white">Chính sách dữ liệu cá nhân</a></p>
                    <p><a href="#" class="text-white">Xem bản mobile</a></p>
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
                    © 2018. Công ty cổ phần Thế Giới Di Động. GPĐKKD: 0303217354 do sở KH & ĐT TP.HCM cấp ngày
                    02/01/2007.<br>
                    Địa chỉ: 128 Trần Quang Khải, P.Tân Định, Q.1, TP. Hồ Chí Minh. Điện thoại: 028 38125960. <br>
                    Địa chỉ liên hệ và gửi chứng từ: Lô T2-1.2, Đường D1, Đ. D1, P.Tân Phú, TP.Thủ Đức, TP.Hồ Chí Minh.
                    <br>
                    Chịu trách nhiệm nội dung: Huỳnh Văn Tốt. Email: hotrotdmt@thegioididong.com
                </p>
            </div>
        </div>
    </footer>




</body>

</html>