<?php
session_start(); // Nếu chưa gọi
// Sau khi người dùng đăng nhập thành công


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
                <a href="am-thanh.php">
                    <img src="img/hinhbanner1.png" class="d-block w-100" alt="AirPods Pro 2">
                </a>
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
    <!-- body sản phẩm ---------------------------------------------->
    <section style="background-color: #2c2c2c; padding-top: 100px;  ">
        <div style="max-width: 1240px; margin: auto;">
            <ul style="
      display: flex;
      justify-content: space-between;
      flex-wrap: nowrap;
      list-style: none;
      margin: 0 auto;
      padding: 0;
      gap: 20px;
    ">

                <!-- iPhone -->
                <li style="width: 200px; height: 250px; background-color: #323232; border-radius: 12px;
      text-align: center; padding: 20px 10px; box-sizing: border-box;box-shadow: 0 0 0 rgba(0,0,0,0);
" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 12px 24px rgba(242, 233, 233, 0.3)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0 0 rgba(0,0,0,0)'">
                    <a href="iphone.php" style="text-decoration: none; color: #fff; display: block;">
                        <img src="img/iphone_link.png" alt="iPhone"
                            style="max-width: 100%; height: auto; margin: 0 auto 10px; display: block;">
                        <p style="font-weight: bold;">iPhone</p>
                    </a>
                </li>

                <!-- Mac -->
                <li style="width: 200px; height: 250px; background-color: #323232; border-radius: 12px;
      text-align: center; padding: 20px 10px; box-sizing: border-box;box-shadow: 0 0 0 rgba(0,0,0,0);
" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 12px 24px rgba(242, 233, 233, 0.3)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0 0 rgba(0,0,0,0)'">
                    <a href="mac.php" style="text-decoration: none; color: #fff; display: block;">
                        <img src="img/Mac_link.png" alt="Mac"
                            style="max-width: 100%; height: auto; margin: 0 auto 10px; display: block;">
                        <p style="font-weight: bold;">Mac</p>
                    </a>
                </li>

                <!-- iPad -->
                <li style="width: 200px; height: 250px; background-color: #323232; border-radius: 12px;
      text-align: center; padding: 20px 10px; box-sizing: border-box;box-shadow: 0 0 0 rgba(0,0,0,0);
" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 12px 24px rgba(242, 233, 233, 0.3)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0 0 rgba(0,0,0,0)'">
                    <a href="ipad.php" style="text-decoration: none; color: #fff; display: block;">
                        <img src="img/Ipad_link.png" alt="iPad"
                            style="max-width: 100%; height: auto; margin: 0 auto 10px; display: block;">
                        <p style="font-weight: bold;">iPad</p>
                    </a>
                </li>

                <!-- Watch -->
                <li style="width: 200px; height: 250px; background-color: #323232; border-radius: 12px;
      text-align: center; padding: 20px 10px; box-sizing: border-box;box-shadow: 0 0 0 rgba(0,0,0,0);
" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 12px 24px rgba(242, 233, 233, 0.3)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0 0 rgba(0,0,0,0)'">
                    <a href="watch.php" style="text-decoration: none; color: #fff; display: block;">
                        <img src="img/Watch_link.png" alt="Watch"
                            style="max-width: 100%; height: auto; margin: 0 auto 10px; display: block;">
                        <p style="font-weight: bold;">Watch</p>
                    </a>
                </li>

                <!-- Tai nghe, loa -->
                <li style="width: 200px; height: 250px; background-color: #323232; border-radius: 12px;
      text-align: center; padding: 20px 10px; box-sizing: border-box;box-shadow: 0 0 0 rgba(0,0,0,0);
" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 12px 24px rgba(242, 233, 233, 0.3)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0 0 rgba(242, 233, 233, 0.3)'">
                    <a href="tainghe.php" style="text-decoration: none; color: #fff; display: ">
                        <img src="img/Speaker_link.png" alt="Tai nghe, loa"
                            style="max-width: 100%; height: auto; margin: 0 auto 10px; display: block;">
                        <p style="font-weight: bold;">Tai nghe, loa</p>
                    </a>
                </li>

                <!-- Phụ kiện -->
                <li style="width: 200px; height: 250px; background-color: #323232; border-radius: 12px;
      text-align: center; padding: 20px 10px; box-sizing: border-box;box-shadow: 0 0 0 rgba(0,0,0,0);
" onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 12px 24px rgba(242, 233, 233, 0.3)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 0 0 rgba(0,0,0,0)'">
                    <a href="phukien.php" style="text-decoration: none; color: #fff; display: block;">
                        <img src="img/Phukien_link.png" alt="Phụ kiện"
                            style="max-width: 100%; height: auto; margin: 0 auto 10px; display: block;">
                        <p style="font-weight: bold;">Phụ kiện</p>
                    </a>
                </li>

            </ul>
        </div>
    </section>



    <!-- iphone----------------------------------------------------------- -->
    <?php
include 'connect.php'; // Kết nối CSDL

$sql = "
    SELECT sp.id, sp.ten_san_pham, sp.gia AS gia_goc, sp.phan_tram_giam,
           ROUND(sp.gia * (100 - sp.phan_tram_giam) / 100) AS gia,
           ha.ten_file
    FROM san_pham sp
    LEFT JOIN hinh_anh_san_pham ha ON ha.san_pham_id = sp.id
    WHERE sp.loai_id = 1
    GROUP BY sp.id
";


$result = $conn->query($sql); // ✅ Đã sửa

if (!$result) {
    die("Lỗi truy vấn SQL: " . $connect->error);
}

$products = [];
while ($sp = $result->fetch_assoc()) {
    $products[] = $sp;
}


?>

    <section style="background-color: #2c2c2c; padding: 70px 0;">
        <h2 style="color: white; font-size: 38px; text-align: center; margin-bottom: 30px;">
            <a href="iphone.php" style="text-decoration: none; color: white;">
                <img src="/webphone/img/apple-icon.png" alt="apple"
                    style="width: 60px; margin-right: -16px; vertical-align: middle;">
                iPhone
            </a>
        </h2>
        <div class="slider-wrapper" style="position: relative; max-width: 1240px; margin: auto;">
            <!-- Container cố định max-width -->
            <div class="slider-container" style="overflow: hidden;">
                <div id="slider-track" style="display: flex; gap: 30px; transition: transform 0.4s ease;">
                    <?php foreach ($products as $sp): ?>
                    <a href="chi_tiet_san_pham.php?id=<?php echo $sp['id']; ?>
  " style="text-decoration: none; color: inherit;">
                        <div style="width: 285px; flex-shrink: 0; background-color: #323232; border-radius: 16px; padding: 20px; text-align: center; min-height: 480px;"
                            onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.3)'"
                            onmouseout="this.style.transform='none'; this.style.boxShadow='none'">
                            <img src="/webphone/img/<?php echo htmlspecialchars($sp['ten_file']); ?>"
                                alt="<?php echo htmlspecialchars($sp['ten_san_pham']); ?>"
                                style="width: 100%; height: 210px; object-fit: contain;">
                            <p style="color: white; font-size: 15px; margin-top: 10px;">
                                <?php echo $sp['ten_san_pham']; ?></p>
                            <p style="color: white; font-weight: bold; font-size: 18px; margin: 6px 0;">
                                <?php echo number_format($sp['gia'], 0, ',', '.'); ?>₫</p>
                            <?php if (!empty($sp['gia_goc'])): ?>
                            <p style="color: #ccc; font-size: 13px; text-decoration: line-through;">
                                <?php echo number_format($sp['gia_goc'], 0, ',', '.'); ?>₫</p>
                            <?php endif; ?>
                            <?php if (!empty($sp['giam_phan_tram'])): ?>
                            <p style="color: orange; font-size: 13px;">-<?php echo $sp['giam_phan_tram']; ?>%</p>
                            <?php endif; ?>
                            <p style="color: orange; font-size: 14px;">Online giá rẻ quá</p>
                        </div>
                    </a>
                    <?php endforeach; ?>

                </div>
            </div>

            <!-- Nút điều hướng -->
            <button onclick="prevSlide()" id="btn-prev" style="
      position: absolute;
      left: -20px;
      top: 50%;
      transform: translateY(-50%);
      background-color: #1e1e1e;
      border: none;
      border-radius: 50%;
      width: 48px;
      height: 48px;
      color: white;
      font-size: 22px;
      cursor: pointer;
      z-index: 10;">←</button>

            <button onclick="nextSlide()" id="btn-next" style="
      position: absolute;
      right: -20px;
      top: 50%;
      transform: translateY(-50%);
      background-color: #1e1e1e;
      border: none;
      border-radius: 50%;
      width: 48px;
      height: 48px;
      color: white;
      font-size: 22px;
      cursor: pointer;
      z-index: 10;">→</button>
        </div>

        <script>
        let pos = 0;
        const track = document.getElementById('slider-track');
        const total = <?php echo count($products); ?>;
        const cardWidth = 285 + 30; // width + gap
        const visible = 4;

        const btnPrev = document.getElementById("btn-prev");
        const btnNext = document.getElementById("btn-next");

        function updateSlider() {
            const maxPos = Math.ceil(total / visible) - 1;
            const shift = pos * cardWidth;

            track.style.transform = `translateX(-${shift}px)`;

            btnPrev.disabled = pos === 0;
            btnNext.disabled = pos >= maxPos;

            btnPrev.style.opacity = btnPrev.disabled ? "0.4" : "1";
            btnNext.style.opacity = btnNext.disabled ? "0.4" : "1";
        }

        function nextSlide() {
            const maxPos = Math.ceil(total / visible) - 1;
            if (pos < maxPos) {
                pos++;
                updateSlider();
            }
        }

        function prevSlide() {
            if (pos > 0) {
                pos--;
                updateSlider();
            }
        }

        window.addEventListener("resize", updateSlider);
        updateSlider();
        </script>
    </section>
    <?php include 'home_mac.php'; 
    include 'home_ipad.php';
    include 'home_watch.php';
    include 'home_amthanh.php';
    include 'home_phukien.php';
    include 'footer.php';
    ?>

    <!-- mac----------------------------------------------------------- -->
    <?php
    $connect = new mysqli("localhost", "root", "", "webmobile1022");
$connect->set_charset("utf8");

// Lấy sản phẩm loại Mac
$sql = "
    SELECT sp.id, sp.ten_san_pham, sp.gia AS gia_goc, sp.phan_tram_giam,
           ROUND(sp.gia * (100 - sp.phan_tram_giam) / 100) AS gia,
           ha.ten_file
    FROM san_pham sp
    LEFT JOIN hinh_anh_san_pham ha ON ha.san_pham_id = sp.id
    WHERE sp.loai_id = 3
    GROUP BY sp.id
";

$result = $connect->query($sql); // ✅ Đã sửa

if (!$result) {
    die("Lỗi truy vấn SQL: " . $connect->error); // ✅ Bắt lỗi để debug
}

$products = [];
while ($sp = $result->fetch_assoc()) {
    $products[] = $sp;
}

?>
    <section style="background-color: #2c2c2c; padding-top: 70px 0;">
        <h2 style="color: white; font-size: 38px; text-align: center; margin-bottom: 30px;">
            <a href="Macbook.php" style="text-decoration: none; color: white;">
                <img src="/webphone/img/apple-icon.png" alt="apple"
                    style="width: 60px; margin-right: -16px; vertical-align: middle;">
                MacBook
            </a>
        </h2>


        <div class="slider-wrapper" style="position: relative; max-width: 1240px; margin: auto;">
            <!-- Container cố định max-width -->
            <div class="slider-container" style="overflow: hidden;">
                <div id="slider-track-mac" style="display: flex; gap: 30px; transition: transform 0.4s ease;">
                    <?php foreach ($products as $sp): ?>
                    <a href="chi_tiet_san_pham.php?id=<?php echo $sp['id']; ?>"
                        style="text-decoration: none; color: inherit;">
                        <div style="width: 285px; flex-shrink: 0; background-color: #323232; border-radius: 16px; padding: 20px; text-align: center; min-height: 480px;"
                            onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.3)'"
                            onmouseout="this.style.transform='none'; this.style.boxShadow='none'">
                            <img src="/webphone/img/<?php echo htmlspecialchars($sp['ten_file']); ?>"
                                alt="<?php echo htmlspecialchars($sp['ten_san_pham']); ?>"
                                style="width: 100%; height: 210px; object-fit: contain;">
                            <p style="color: white; font-size: 15px; margin-top: 10px;">
                                <?php echo $sp['ten_san_pham']; ?></p>
                            <p style="color: white; font-weight: bold; font-size: 18px; margin: 6px 0;">
                                <?php echo number_format($sp['gia'], 0, ',', '.'); ?>₫</p>
                            <?php if (!empty($sp['gia_goc'])): ?>
                            <p style="color: #ccc; font-size: 13px; text-decoration: line-through;">
                                <?php echo number_format($sp['gia_goc'], 0, ',', '.'); ?>₫</p>
                            <?php endif; ?>
                            <?php if (!empty($sp['giam_phan_tram'])): ?>
                            <p style="color: orange; font-size: 13px;">-<?php echo $sp['giam_phan_tram']; ?>%</p>
                            <?php endif; ?>
                            <p style="color: orange; font-size: 14px;">Online giá rẻ quá</p>
                        </div>
                    </a>
                    <?php endforeach; ?>

                </div>
            </div>

            <!-- Nút điều hướng -->
            <button onclick="prevSlideMac()" id="btn-prev-mac" style="
  position: absolute;
  left: -20px;
  top: 50%;
  transform: translateY(-50%);
  background-color: #1e1e1e;
  border: none;
  border-radius: 50%;
  width: 48px;
  height: 48px;
  color: white;
  font-size: 22px;
  cursor: pointer;
  z-index: 10;">←</button>

            <button onclick="nextSlideMac()" id="btn-next-mac" style="
  position: absolute;
  right: -20px;
  top: 50%;
  transform: translateY(-50%);
  background-color: #1e1e1e;
  border: none;
  border-radius: 50%;
  width: 48px;
  height: 48px;
  color: white;
  font-size: 22px;
  cursor: pointer;
  z-index: 10;">→</button>
        </div>

        <script>
        let posMac = 0;
        const trackMac = document.getElementById('slider-track-mac');
        const totalMac = <?php echo count($products); ?>;
        const cardWidthMac = 285 + 30;
        const visibleMac = 4;

        const btnPrevMac = document.getElementById("btn-prev-mac");
        const btnNextMac = document.getElementById("btn-next-mac");

        function updateSliderMac() {
            const maxPosMac = Math.ceil(totalMac / visibleMac) - 1;
            const shiftMac = posMac * cardWidthMac;
            trackMac.style.transform = `translateX(-${shiftMac}px)`;

            btnPrevMac.disabled = posMac === 0;
            btnNextMac.disabled = posMac >= maxPosMac;
            btnPrevMac.style.opacity = btnPrevMac.disabled ? "0.4" : "1";
            btnNextMac.style.opacity = btnNextMac.disabled ? "0.4" : "1";
        }

        function nextSlideMac() {
            const maxPosMac = Math.ceil(totalMac / visibleMac) - 1;
            if (posMac < maxPosMac) {
                posMac++;
                updateSliderMac();
            }
        }

        function prevSlideMac() {
            if (posMac > 0) {
                posMac--;
                updateSliderMac();
            }
        }

        window.addEventListener("resize", updateSliderMac);
        updateSliderMac(); // Init
        </script>

    </section>

    <!-- ipad---------------------------------------------------------- -->


    <?php
  $connect = new mysqli("localhost", "root", "", "webmobile1022");
$connect->set_charset("utf8");

// Lấy sản phẩm loại ipad
$sql = "
    SELECT sp.id, sp.ten_san_pham, sp.gia AS gia_goc, sp.phan_tram_giam,
           ROUND(sp.gia * (100 - sp.phan_tram_giam) / 100) AS gia,
           ha.ten_file
    FROM san_pham sp
    LEFT JOIN hinh_anh_san_pham ha ON ha.san_pham_id = sp.id
    WHERE sp.loai_id = 2
    GROUP BY sp.id
";

$result = $connect->query($sql); // ✅ Đã sửa

if (!$result) {
    die("Lỗi truy vấn SQL: " . $connect->error); // ✅ Bắt lỗi để debug
}

$products = [];
while ($sp = $result->fetch_assoc()) {
    $products[] = $sp;
}
?>
    <section style="background-color: #2c2c2c; padding: 70px 0;">
        <h2 style="color: white; font-size: 38px; text-align: center; margin-bottom: 30px;">
            <a href="ipad.php" style="text-decoration: none; color: white;">
                <img src="/webphone/img/apple-icon.png" alt="apple"
                    style="width: 60px; margin-right: -16px; vertical-align: middle;">
                Ipad
            </a>
        </h2>


        <div class="slider-wrapper" style="position: relative; max-width: 1240px; margin: auto;">
            <!-- Container cố định max-width -->
            <div class="slider-container" style="overflow: hidden;">
                <div id="slider-track-ipad" style="display: flex; gap: 30px; transition: transform 0.4s ease;">
                    <?php foreach ($products as $sp): ?>
                    <a href="chi_tiet_san_pham.php?id=<?php echo $sp['id']; ?>"
                        style="text-decoration: none; color: inherit;">
                        <div style="width: 285px; flex-shrink: 0; background-color: #323232; border-radius: 16px; padding: 20px; text-align: center; min-height: 480px;"
                            onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.3)'"
                            onmouseout="this.style.transform='none'; this.style.boxShadow='none'">
                            <img src="/webphone/img/<?php echo htmlspecialchars($sp['ten_file']); ?>"
                                alt="<?php echo htmlspecialchars($sp['ten_san_pham']); ?>"
                                style="width: 100%; height: 210px; object-fit: contain;">
                            <p style="color: white; font-size: 15px; margin-top: 10px;">
                                <?php echo $sp['ten_san_pham']; ?></p>
                            <p style="color: white; font-weight: bold; font-size: 18px; margin: 6px 0;">
                                <?php echo number_format($sp['gia'], 0, ',', '.'); ?>₫</p>
                            <?php if (!empty($sp['gia_goc'])): ?>
                            <p style="color: #ccc; font-size: 13px; text-decoration: line-through;">
                                <?php echo number_format($sp['gia_goc'], 0, ',', '.'); ?>₫</p>
                            <?php endif; ?>
                            <?php if (!empty($sp['giam_phan_tram'])): ?>
                            <p style="color: orange; font-size: 13px;">-<?php echo $sp['giam_phan_tram']; ?>%</p>
                            <?php endif; ?>
                            <p style="color: orange; font-size: 14px;">Online giá rẻ quá</p>
                        </div>
                    </a>
                    <?php endforeach; ?>

                </div>
            </div>

            <!-- Nút điều hướng -->
            <button onclick="prevSlideIpad()" id="btn-prev-ipad" style="
  position: absolute;
  left: -20px;
  top: 50%;
  transform: translateY(-50%);
  background-color: #1e1e1e;
  border: none;
  border-radius: 50%;
  width: 48px;
  height: 48px;
  color: white;
  font-size: 22px;
  cursor: pointer;
  z-index: 10;">←</button>

            <button onclick="nextSlideIpad()" id="btn-next-ipad" style="
  position: absolute;
  right: -20px;
  top: 50%;
  transform: translateY(-50%);
  background-color: #1e1e1e;
  border: none;
  border-radius: 50%;
  width: 48px;
  height: 48px;
  color: white;
  font-size: 22px;
  cursor: pointer;
  z-index: 10;">→</button>
        </div>

        <script>
        let posIpad = 0;
        const trackIpad = document.getElementById('slider-track-ipad');
        const totalIpad = <?php echo count($products); ?>;
        const cardWidthIpad = 285 + 30; // card width + gap
        const visibleIpad = 4;

        const btnPrevIpad = document.getElementById("btn-prev-ipad");
        const btnNextIpad = document.getElementById("btn-next-ipad");

        function updateSliderIpad() {
            const maxPosIpad = Math.ceil(totalIpad / visibleIpad) - 1;
            const shiftIpad = posIpad * cardWidthIpad;
            trackIpad.style.transform = `translateX(-${shiftIpad}px)`;

            btnPrevIpad.disabled = posIpad === 0;
            btnNextIpad.disabled = posIpad >= maxPosIpad;

            btnPrevIpad.style.opacity = btnPrevIpad.disabled ? "0.4" : "1";
            btnNextIpad.style.opacity = btnNextIpad.disabled ? "0.4" : "1";
        }

        function nextSlideIpad() {
            const maxPosIpad = Math.ceil(totalIpad / visibleIpad) - 1;
            if (posIpad < maxPosIpad) {
                posIpad++;
                updateSliderIpad();
            }
        }

        function prevSlideIpad() {
            if (posIpad > 0) {
                posIpad--;
                updateSliderIpad();
            }
        }

        window.addEventListener("resize", updateSliderIpad);
        updateSliderIpad(); // khởi tạo ban đầu
        </script>

    </section>

    <!-- watch---------------------------------------------------------- -->
    <?php
       $connect = new mysqli("localhost", "root", "", "webmobile1022");
$connect->set_charset("utf8");

// Lấy sản phẩm loại applewatch
$sql = "
    SELECT sp.id, sp.ten_san_pham, sp.gia AS gia_goc, sp.phan_tram_giam,
           ROUND(sp.gia * (100 - sp.phan_tram_giam) / 100) AS gia,
           ha.ten_file
    FROM san_pham sp
    LEFT JOIN hinh_anh_san_pham ha ON ha.san_pham_id = sp.id
    WHERE sp.loai_id = 4
    GROUP BY sp.id
";

$result = $connect->query($sql); // ✅ Đã sửa

if (!$result) {
    die("Lỗi truy vấn SQL: " . $connect->error); // ✅ Bắt lỗi để debug
}

$products = [];
while ($sp = $result->fetch_assoc()) {
    $products[] = $sp;
}
?>
    <section style="background-color: #2c2c2c; padding-top: 70px 0;">
        <h2 style="color: white; font-size: 38px; text-align: center; margin-bottom: 30px;">
            <a href="watch.php" style="text-decoration: none; color: white;">
                <img src="/webphone/img/apple-icon.png" alt="apple"
                    style="width: 60px; margin-right: -16px; vertical-align: middle;">
                WATCH
            </a>
        </h2>

        <div class="slider-wrapper" style="position: relative; max-width: 1240px; margin: auto;">
            <div class="slider-container" style="overflow: hidden;">
                <div id="slider-track-watch" style="display: flex; gap: 30px; transition: transform 0.4s ease;">
                    <?php foreach ($products as $sp): ?>
                    <a href="chi_tiet_san_pham.php?id=<?php echo $sp['id']; ?>"
                        style="text-decoration: none; color: inherit;">
                        <div style="width: 285px; flex-shrink: 0; background-color: #323232; border-radius: 16px; padding: 20px; text-align: center; min-height: 480px;"
                            onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.3)'"
                            onmouseout="this.style.transform='none'; this.style.boxShadow='none'">
                            <img src="/webphone/img/<?php echo htmlspecialchars($sp['ten_file']); ?>"
                                alt="<?php echo htmlspecialchars($sp['ten_san_pham']); ?>"
                                style="width: 100%; height: 210px; object-fit: contain;">
                            <p style="color: white; font-size: 15px; margin-top: 10px;">
                                <?php echo $sp['ten_san_pham']; ?></p>
                            <p style="color: white; font-weight: bold; font-size: 18px; margin: 6px 0;">
                                <?php echo number_format($sp['gia'], 0, ',', '.'); ?>₫</p>
                            <?php if (!empty($sp['gia_goc'])): ?>
                            <p style="color: #ccc; font-size: 13px; text-decoration: line-through;">
                                <?php echo number_format($sp['gia_goc'], 0, ',', '.'); ?>₫</p>
                            <?php endif; ?>
                            <?php if (!empty($sp['giam_phan_tram'])): ?>
                            <p style="color: orange; font-size: 13px;">-<?php echo $sp['giam_phan_tram']; ?>%</p>
                            <?php endif; ?>
                            <p style="color: orange; font-size: 14px;">Online giá rẻ quá</p>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Navigation buttons -->
            <button onclick="prevSlideWatch()" id="btn-prev-watch" style="
      position: absolute;
      left: -20px;
      top: 50%;
      transform: translateY(-50%);
      background-color: #1e1e1e;
      border: none;
      border-radius: 50%;
      width: 48px;
      height: 48px;
      color: white;
      font-size: 22px;
      cursor: pointer;
      z-index: 10;">←</button>

            <button onclick="nextSlideWatch()" id="btn-next-watch" style="
      position: absolute;
      right: -20px;
      top: 50%;
      transform: translateY(-50%);
      background-color: #1e1e1e;
      border: none;
      border-radius: 50%;
      width: 48px;
      height: 48px;
      color: white;
      font-size: 22px;
      cursor: pointer;
      z-index: 10;">→</button>
        </div>

        <script>
        let posWatch = 0;
        const trackWatch = document.getElementById('slider-track-watch');
        const totalWatch = <?php echo count($products); ?>;
        const cardWidthWatch = 285 + 30;
        const visibleWatch = 4;

        const btnPrevWatch = document.getElementById("btn-prev-watch");
        const btnNextWatch = document.getElementById("btn-next-watch");

        function updateSliderWatch() {
            const maxPosWatch = Math.ceil(totalWatch / visibleWatch) - 1;
            const shiftWatch = posWatch * cardWidthWatch;
            trackWatch.style.transform = `translateX(-${shiftWatch}px)`;

            btnPrevWatch.disabled = posWatch === 0;
            btnNextWatch.disabled = posWatch >= maxPosWatch;
            btnPrevWatch.style.opacity = btnPrevWatch.disabled ? "0.4" : "1";
            btnNextWatch.style.opacity = btnNextWatch.disabled ? "0.4" : "1";
        }

        function nextSlideWatch() {
            const maxPosWatch = Math.ceil(totalWatch / visibleWatch) - 1;
            if (posWatch < maxPosWatch) {
                posWatch++;
                updateSliderWatch();
            }
        }

        function prevSlideWatch() {
            if (posWatch > 0) {
                posWatch--;
                updateSliderWatch();
            }
        }

        window.addEventListener("resize", updateSliderWatch);
        updateSliderWatch(); // Init
        </script>
    </section>
    <!-- ariport---------------------------------------------------------- -->
    <?php
       $connect = new mysqli("localhost", "root", "", "webmobile1022");
$connect->set_charset("utf8");

// Lấy sản phẩm loại ipods
$sql = "
    SELECT sp.id, sp.ten_san_pham, sp.gia AS gia_goc, sp.phan_tram_giam,
           ROUND(sp.gia * (100 - sp.phan_tram_giam) / 100) AS gia,
           ha.ten_file
    FROM san_pham sp
    LEFT JOIN hinh_anh_san_pham ha ON ha.san_pham_id = sp.id
    WHERE sp.loai_id = 5
    GROUP BY sp.id
";

$result = $connect->query($sql); // ✅ Đã sửa

if (!$result) {
    die("Lỗi truy vấn SQL: " . $connect->error); // ✅ Bắt lỗi để debug
}

$products = [];
while ($sp = $result->fetch_assoc()) {
    $products[] = $sp;
}
?>
    <section style="background-color: #2c2c2c; padding-top: 70px 0;">
        <h2 style="color: white; font-size: 38px; text-align: center; margin-bottom: 30px;">
            <a href="am-thanh.php" style="text-decoration: none; color: white;">
                <img src="/webphone/img/apple-icon.png" alt="apple"
                    style="width: 60px; margin-right: -16px; vertical-align: middle;">
                Tai nghe, Loa
            </a>
        </h2>

        <div class="slider-wrapper" style="position: relative; max-width: 1240px; margin: auto;">
            <div class="slider-container" style="overflow: hidden;">
                <div id="slider-track-airport" style="display: flex; gap: 30px; transition: transform 0.4s ease;">
                    <?php foreach ($products as $sp): ?>
                    <a href="chi_tiet_san_pham.php?id=<?php echo $sp['id']; ?>"
                        style="text-decoration: none; color: inherit;">
                        <div style="width: 285px; flex-shrink: 0; background-color: #323232; border-radius: 16px; padding: 20px; text-align: center; min-height: 480px;"
                            onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.3)'"
                            onmouseout="this.style.transform='none'; this.style.boxShadow='none'">
                            <img src="/webphone/img/<?php echo htmlspecialchars($sp['ten_file']); ?>"
                                alt="<?php echo htmlspecialchars($sp['ten_san_pham']); ?>"
                                style="width: 100%; height: 210px; object-fit: contain;">
                            <p style="color: white; font-size: 15px; margin-top: 10px;">
                                <?php echo $sp['ten_san_pham']; ?></p>
                            <p style="color: white; font-weight: bold; font-size: 18px; margin: 6px 0;">
                                <?php echo number_format($sp['gia'], 0, ',', '.'); ?>₫</p>
                            <?php if (!empty($sp['gia_goc'])): ?>
                            <p style="color: #ccc; font-size: 13px; text-decoration: line-through;">
                                <?php echo number_format($sp['gia_goc'], 0, ',', '.'); ?>₫</p>
                            <?php endif; ?>
                            <?php if (!empty($sp['giam_phan_tram'])): ?>
                            <p style="color: orange; font-size: 13px;">-<?php echo $sp['giam_phan_tram']; ?>%</p>
                            <?php endif; ?>
                            <p style="color: orange; font-size: 14px;">Online giá rẻ quá</p>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Navigation buttons -->
            <button onclick="prevSlideAirport()" id="btn-prev-airport" style="
      position: absolute;
      left: -20px;
      top: 50%;
      transform: translateY(-50%);
      background-color: #1e1e1e;
      border: none;
      border-radius: 50%;
      width: 48px;
      height: 48px;
      color: white;
      font-size: 22px;
      cursor: pointer;
      z-index: 10;">←</button>

            <button onclick="nextSlideAirport()" id="btn-next-airport" style="
      position: absolute;
      right: -20px;
      top: 50%;
      transform: translateY(-50%);
      background-color: #1e1e1e;
      border: none;
      border-radius: 50%;
      width: 48px;
      height: 48px;
      color: white;
      font-size: 22px;
      cursor: pointer;
      z-index: 10;">→</button>
        </div>

        <script>
        let posAirport = 0;
        const trackAirport = document.getElementById('slider-track-airport');
        const totalAirport = <?php echo count($products); ?>;
        const cardWidthAirport = 285 + 30;
        const visibleAirport = 4;

        const btnPrevAirport = document.getElementById("btn-prev-airport");
        const btnNextAirport = document.getElementById("btn-next-airport");

        function updateSliderAirport() {
            const maxPosAirport = Math.ceil(totalAirport / visibleAirport) - 1;
            const shiftAirport = posAirport * cardWidthAirport;
            trackAirport.style.transform = `translateX(-${shiftAirport}px)`;

            btnPrevAirport.disabled = posAirport === 0;
            btnNextAirport.disabled = posAirport >= maxPosAirport;
            btnPrevAirport.style.opacity = btnPrevAirport.disabled ? "0.4" : "1";
            btnNextAirport.style.opacity = btnNextAirport.disabled ? "0.4" : "1";
        }

        function nextSlideAirport() {
            const maxPosAirport = Math.ceil(totalAirport / visibleAirport) - 1;
            if (posAirport < maxPosAirport) {
                posAirport++;
                updateSliderAirport();
            }
        }

        function prevSlideAirport() {
            if (posAirport > 0) {
                posAirport--;
                updateSliderAirport();
            }
        }

        window.addEventListener("resize", updateSliderAirport);
        updateSliderAirport(); // Init
        </script>
    </section>
    <!-- phukien---------------------------------------------------------- -->
    <?php
  $connect = new mysqli("localhost", "root", "", "webmobile1022");
$connect->set_charset("utf8");

$sql = "
    SELECT sp.id, sp.ten_san_pham, sp.gia AS gia_goc, sp.phan_tram_giam,
           ROUND(sp.gia * (100 - sp.phan_tram_giam) / 100) AS gia,
           ha.ten_file
    FROM san_pham sp
    LEFT JOIN hinh_anh_san_pham ha ON ha.san_pham_id = sp.id
    WHERE sp.loai_id = 6
    GROUP BY sp.id
";

$result = $connect->query($sql); // ✅ Đã sửa

if (!$result) {
    die("Lỗi truy vấn SQL: " . $connect->error); // ✅ Bắt lỗi để debug
}

$products = [];
while ($sp = $result->fetch_assoc()) {
    $products[] = $sp;
}
?>
    <section style="background-color: #2c2c2c; padding: 70px 0;">
        <a href="ipad.php" style="text-decoration: none; color: white;">
            <h2 style="color: white; font-size: 38px; text-align: center; margin-bottom: 30px;">
                <img src="/webphone/img/apple-icon.png" alt="apple"
                    style="width: 60px; margin-right: -16px; vertical-align: middle;">
                Phụ kiện
        </a>
        </h2>

        <div class="slider-wrapper" style="position: relative; max-width: 1240px; margin: auto;">
            <div class="slider-container" style="overflow: hidden;">
                <div id="slider-track-phukien" style="display: flex; gap: 30px; transition: transform 0.4s ease;">
                    <?php foreach ($products as $sp): ?>
                    <a href="chi_tiet_san_pham.php?id=<?php echo $sp['id']; ?>"
                        style="text-decoration: none; color: inherit;">
                        <div style="width: 285px; flex-shrink: 0; background-color: #323232; border-radius: 16px; padding: 20px; text-align: center; min-height: 480px;"
                            onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.3)'"
                            onmouseout="this.style.transform='none'; this.style.boxShadow='none'">
                            <img src="/webphone/img/<?php echo htmlspecialchars($sp['ten_file']); ?>"
                                alt="<?php echo htmlspecialchars($sp['ten_san_pham']); ?>"
                                style="width: 100%; height: 210px; object-fit: contain;">
                            <p style="color: white; font-size: 15px; margin-top: 10px;">
                                <?php echo $sp['ten_san_pham']; ?></p>
                            <p style="color: white; font-weight: bold; font-size: 18px; margin: 6px 0;">
                                <?php echo number_format($sp['gia'], 0, ',', '.'); ?>₫</p>
                            <?php if (!empty($sp['gia_goc'])): ?>
                            <p style="color: #ccc; font-size: 13px; text-decoration: line-through;">
                                <?php echo number_format($sp['gia_goc'], 0, ',', '.'); ?>₫</p>
                            <?php endif; ?>
                            <?php if (!empty($sp['giam_phan_tram'])): ?>
                            <p style="color: orange; font-size: 13px;">-<?php echo $sp['giam_phan_tram']; ?>%</p>
                            <?php endif; ?>
                            <p style="color: orange; font-size: 14px;">Online giá rẻ quá</p>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Nút điều hướng -->
            <button onclick="prevSlidePhukien()" id="btn-prev-phukien" style="
      position: absolute;
      left: -20px;
      top: 50%;
      transform: translateY(-50%);
      background-color: #1e1e1e;
      border: none;
      border-radius: 50%;
      width: 48px;
      height: 48px;
      color: white;
      font-size: 22px;
      cursor: pointer;
      z-index: 10;">←</button>

            <button onclick="nextSlidePhukien()" id="btn-next-phukien" style="
      position: absolute;
      right: -20px;
      top: 50%;
      transform: translateY(-50%);
      background-color: #1e1e1e;
      border: none;
      border-radius: 50%;
      width: 48px;
      height: 48px;
      color: white;
      font-size: 22px;
      cursor: pointer;
      z-index: 10;">→</button>
        </div>

        <script>
        let posPhukien = 0;
        const trackPhukien = document.getElementById('slider-track-phukien');
        const totalPhukien = <?php echo count($products); ?>;
        const cardWidthPhukien = 285 + 30;
        const visiblePhukien = 4;

        const btnPrevPhukien = document.getElementById("btn-prev-phukien");
        const btnNextPhukien = document.getElementById("btn-next-phukien");

        function updateSliderPhukien() {
            const maxPosPhukien = Math.ceil(totalPhukien / visiblePhukien) - 1;
            const shiftPhukien = posPhukien * cardWidthPhukien;
            trackPhukien.style.transform = `translateX(-${shiftPhukien}px)`;

            btnPrevPhukien.disabled = posPhukien === 0;
            btnNextPhukien.disabled = posPhukien >= maxPosPhukien;
            btnPrevPhukien.style.opacity = btnPrevPhukien.disabled ? "0.4" : "1";
            btnNextPhukien.style.opacity = btnNextPhukien.disabled ? "0.4" : "1";
        }

        function nextSlidePhukien() {
            const maxPosPhukien = Math.ceil(totalPhukien / visiblePhukien) - 1;
            if (posPhukien < maxPosPhukien) {
                posPhukien++;
                updateSliderPhukien();
            }
        }

        function prevSlidePhukien() {
            if (posPhukien > 0) {
                posPhukien--;
                updateSliderPhukien();
            }
        }

        window.addEventListener("resize", updateSliderPhukien);
        updateSliderPhukien(); // Init
        </script>
    </section>




    <!-- video---------------------------------------------------------- -->

    <section class="hero-video-wrapper position-relative overflow-hidden">
        <video autoplay muted loop playsinline class="hero-video w-100 h-100 object-fit-cover">
            <source src="https://cdnv2.tgdd.vn/webmwg/2024/tz/video/Gt-Topzone.mp4" type="video/mp4">
            Trình duyệt của bạn không hỗ trợ video.
        </video>

        <!-- Gradient overlay mờ dần xuống đen -->
        <div class="gradient-overlay position-absolute top-0 start-0 w-100 h-100"></div>

        <!-- Nội dung trên video -->
        <div class="hero-content position-absolute top-50 start-50 translate-middle text-white text-center px-3">
            <img src="img/logo-topzone-removebg-preview.png" class="mb-4" alt="TopZone" style="opacity: 0.5;">

            <p class="fs-5 fw-normal" style="opacity: 0.5;">
                Tại TopZone, khách hàng yêu mến hệ sinh thái Apple sẽ tìm thấy đầy đủ và đa dạng nhất các sản phẩm như
                <br>
                iPhone, iPad, Apple Watch, MacBook và các phụ kiện Apple... với không gian mua sắm đẳng cấp, hiện đại.
            </p>
            <a href="#" class="btn btn-primary rounded-3">Đọc thêm</a>
        </div>
    </section>
    <?php
include 'footer.php'; 
?>
</body>

</html>