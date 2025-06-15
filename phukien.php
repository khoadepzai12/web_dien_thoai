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
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.9));
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
        font-style: italic;
        /* In nghiêng */
        color: #cccccc;
        /* Màu chữ nhạt (xám sáng) */
        font-size: 1rem;
        margin-bottom: 4px;
        font-weight: 400;
        /* Không in đậm */
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
        background-color: #0d6efd;
        /* xanh nhạt Bootstrap */
        color: #fff;
    }
    </style>
</head>

<body>

    <!-- Start of LiveChat (www.livechat.com) code -->
    <script>
    window.__lc = window.__lc || {};
    window.__lc.license = 19196757;
    window.__lc.integration_name = "manual_channels";
    window.__lc.product_name = "livechat";;
    (function(n, t, c) {
        function i(n) {
            return e._h ? e._h.apply(null, n) : e._q.push(n)
        }
        var e = {
            _q: [],
            _h: null,
            _v: "2.0",
            on: function() {
                i(["on", c.call(arguments)])
            },
            once: function() {
                i(["once", c.call(arguments)])
            },
            off: function() {
                i(["off", c.call(arguments)])
            },
            get: function() {
                if (!e._h) throw new Error("[LiveChatWidget] You can't use getters before load.");
                return i(["get", c.call(arguments)])
            },
            call: function() {
                i(["call", c.call(arguments)])
            },
            init: function() {
                var n = t.createElement("script");
                n.async = !0, n.type = "text/javascript", n.src = "https://cdn.livechatinc.com/tracking.js",
                    t.head.appendChild(n)
            }
        };
        !n.__lc.asyncInit && e.init(), n.LiveChatWidget = n.LiveChatWidget || e
    }(window, document, [].slice))
    </script>
    <noscript><a href="https://www.livechat.com/chat-with/19196757/" rel="nofollow">Chat with us</a>, powered by <a
            href="https://www.livechat.com/?welcome" rel="noopener nofollow" target="_blank">LiveChat</a></noscript>
    <!-- End of LiveChat code -->



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
            <div class="d-flex flex-column gap-3">
                <?php $dong = $_GET['dong'] ?? ''; ?>

                <!-- Bộ lọc dòng phụ kiện -->
                <nav class="d-flex flex-wrap gap-3">
                    <a href="phukien.php"
                        class="btn btn-sm border-0 pb-1 <?= empty($dong) ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Tất
                        cả</a>
                    <a href="?dong=phukieniphone"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'phukieniphone' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Phụ
                        kiện iPhone</a>
                    <a href="?dong=phukienmac"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'phukienmac' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Phụ
                        kiện Mac</a>
                    <a href="?dong=phukienipad"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'phukienipad' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Phụ
                        kiện iPad</a>
                    <a href="?dong=phukienwatch"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'phukienwatch' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Phụ
                        kiện Apple Watch</a>
                    <a href="?dong=sacduphong"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'sacduphong' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Sạc
                        dự phòng</a>
                    <a href="?dong=banphim"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'banphim' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Bàn
                        phím</a>
                    <a href="?dong=adapter"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'adapter' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Adapter
                        sạc</a>
                    <a href="?dong=capsac"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'capsac' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Cáp
                        sạc</a>
                    <a href="?dong=hub"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'hub' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Hub,
                        cáp chuyển đổi</a>
                    <a href="?dong=opiphone"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'opiphone' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Ốp
                        lưng, ví da iPhone</a>
                    <a href="?dong=opipad"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'opipad' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Ốp
                        lưng iPad</a>
                    <a href="?dong=chuot"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'chuot' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Chuột
                        máy tính</a>
                    <a href="?dong=gimbal"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'gimbal' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Gimbal</a>
                    <a href="?dong=but"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'but' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Bút
                        tablet</a>
                    <a href="?dong=airtag"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'airtag' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Airtag</a>
                    <a href="?dong=appletv"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'appletv' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Apple
                        TV</a>
                    <a href="?dong=miengdan"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'miengdan' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Miếng
                        dán</a>
                    <a href="?dong=flycam"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'flycam' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Flycam</a>
                    <a href="?dong=tui"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'tui' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Túi
                        đựng AirPods</a>
                    <a href="?dong=balo"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'balo' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Balo,
                        túi chống sốc</a>
                    <a href="?dong=daywatch"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'daywatch' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Dây/Ốp
                        Apple Watch</a>
                    <a href="?dong=gia"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'gia' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Giá
                        đỡ laptop</a>
                    <a href="?dong=micro"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'micro' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Micro
                        thu âm điện thoại</a>
                    <a href="?dong=camera"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'camera' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Camera
                        hành trình / hành động</a>
                    <a href="?dong=miengdanlens"
                        class="btn btn-sm border-0 pb-1 <?= $dong == 'miengdanlens' ? 'text-white border-bottom border-white fw-semibold' : 'text-light' ?>">Miếng
                        dán Camera</a>
                </nav>

                <!-- Dropdown sắp xếp -->
                <div class="dropdown mt-2">
                    <button class="btn btn-sm text-white dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Xếp theo: Nổi bật
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item"
                                href="?<?= http_build_query(array_merge($_GET, ['sort' => 'gia_asc'])) ?>">Giá tăng
                                dần</a></li>
                        <li><a class="dropdown-item"
                                href="?<?= http_build_query(array_merge($_GET, ['sort' => 'gia_desc'])) ?>">Giá giảm
                                dần</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!--phụ kiện----------------------------------------------------------- -->
    <?php
include 'connect.php';

$orderBy = "sp.id DESC";
if (isset($_GET['sort'])) {
  $orderBy = ($_GET['sort'] === 'gia_asc') ? "gia ASC" : (($_GET['sort'] === 'gia_desc') ? "gia DESC" : $orderBy);
}

$dong = $_GET['dong'] ?? '';

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
  WHERE sp.loai_id = 6
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
                <div id="slider-track-phukien"
                    style="display: flex; gap: 30px; flex-wrap: wrap; justify-content: center; transition: transform 0.4s ease;">
                    <?php if (!empty($products)): ?>
                    <?php foreach ($products as $sp): ?>
                    <a href="chi_tiet_san_pham.php?id=<?= $sp['id']; ?>" style="text-decoration: none; color: inherit;">
                        <div style="width: 285px; flex-shrink: 0; background-color: #323232; border-radius: 16px; padding: 20px; text-align: center; min-height: 480px;"
                            onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.3)'"
                            onmouseout="this.style.transform='none'; this.style.boxShadow='none'">

                            <img src="/webphone/img/<?= htmlspecialchars($sp['ten_file']); ?>"
                                alt="<?= htmlspecialchars($sp['ten_san_pham']); ?>"
                                style="width: 100%; height: 210px; object-fit: contain;">

                            <p style="color: white; font-size: 15px; margin-top: 10px;"><?= $sp['ten_san_pham']; ?></p>
                            <p style="color: white; font-weight: bold; font-size: 18px; margin: 6px 0;">
                                <?= number_format($sp['gia'], 0, ',', '.'); ?>₫</p>

                            <?php if (!empty($sp['gia_goc'])): ?>
                            <p style="color: #ccc; font-size: 13px; text-decoration: line-through;">
                                <?= number_format($sp['gia_goc'], 0, ',', '.'); ?>₫</p>
                            <?php endif; ?>

                            <?php if (!empty($sp['phan_tram_giam'])): ?>
                            <p style="color: orange; font-size: 13px;">-<?= $sp['phan_tram_giam']; ?>%</p>
                            <?php endif; ?>

                            <p style="color: orange; font-size: 14px;">Online giá rẻ quá</p>
                        </div>
                    </a>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <div style="color: white; text-align: center; font-size: 16px;">Không có sản phẩm nào để hiển thị.
                    </div>
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