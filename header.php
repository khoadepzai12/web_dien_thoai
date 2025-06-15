<?php // Kiểm tra xem session đã được khởi tạo chưa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
};
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>TopZone</title>
    <link rel="icon" href="img/logo-topzone-removebg-preview.png" type="image/x-icon" />
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

    /* tang so luong*/
    .circle-btn .badge {
        position: absolute;
        top: -6px;
        right: -6px;
        background-color: red;
        color: white;
        font-size: 12px;
        padding: 3px 6px;
        border-radius: 20px;
        min-width: 20px;
        text-align: center;
        line-height: 1;
    }

    /*của phần tìm kiếm*/
    /* Overlay mờ nền khi tìm kiếm */
    .search-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.88);
        z-index: 9999;
        justify-content: center;
        align-items: flex-start;
        padding-top: 30px;
    }

    /* Form tìm kiếm */
    .search-form-box {
        position: relative;
        width: 100%;
        max-width: 600px;
    }

    .search-input {
        width: 100%;
        padding: 8px 40px 8px 36px;
        font-size: 14px;
        border: none;
        background: transparent;
        border-bottom: 1px solid white;
        color: white;
        outline: none;
    }

    .search-icon {
        position: absolute;
        top: 50%;
        left: 10px;
        transform: translateY(-50%);
        color: white;
        font-size: 16px;
    }

    .close-search {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
    }
    </style>
</head>







<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$address = '';
if (isset($_SESSION['user_id'])) {
    include_once 'connect.php';
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT dia_chi FROM khach_hang WHERE id = $user_id LIMIT 1";
    $result = $conn->query($sql);
    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $address = $row['dia_chi'];
    }
}
?>

<body></body>
<header class="sticky-top bg-dark text-white py-2" style="background-color: #000;">
    <!-- Logo -->
    <div class="logo-area">
        <a href="home.php"><img src="img/logo-topzone-removebg-preview.png" alt="TopZone Logo" class="topzone-logo"></a>
        <a href="#"> <img src="img/tao1.png" alt="Apple Premium" class="apple-logo"></a>
    </div>

    <!-- Menu -->
    <ul class="menu">
        <li><a href="iphone.php">iPhone</a></li>
        <li><a href="Macbook.php">Mac</a></li>
        <li><a href="ipad.php">iPad</a></li>
        <li><a href="watch.php">Watch</a></li>
        <li><a href="am-thanh.php">AirPods</a></li>
        <li><a href="phukien.php">Phụ kiện</a></li>
        <li><a href="tekzone.php">Tek Zone</a></li>
        <li><a href="topcare.php">Top Care</a></li>

    </ul>

    <!-- Icons -->
    <div class="icon-area">
        <div class="circle-btn" id="search-icon">
            <i class="fas fa-search"></i>
        </div>
        <!-- Thay cái này bằng đoạn có chấm đỏ nhỏ -->
        <?php
      $has_items = isset($_SESSION['cart']) && count($_SESSION['cart']) > 0;
      ?>
        <a href="gio_hang.php" class="circle-btn position-relative text-decoration-none text-white">
            <i class="fas fa-bag-shopping"></i>
            <?php if ($has_items): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"></span>
            <?php endif; ?>
        </a>

        <?php if (isset($_SESSION['user_id'])): ?>
        <div class="circle-btn position-relative" id="user-icon" style="cursor:pointer;">
            <i class="fas fa-user"></i>
            <div id="user-dropdown"
                style="display:none; position:absolute; right:0; top:40px; background:#222; color:#fff; padding:10px; border-radius:8px; min-width:220px; z-index:1000;">
                <p
                    style="margin:0 0 8px 0; font-weight:bold; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    <a href="thong_tin_tai_khoan.php" style="color: white; text-decoration: none;">
                        <?= htmlspecialchars($_SESSION['user_name']) ?>
                    </a>
                </p>
                <p
                    style="margin:0 0 8px 0; font-size: 0.9em; color:#0dcaf0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; cursor:pointer;">
                    <a href="thong_tin_tai_khoan.php"
                        style="color: #f8f9fa; font-weight: 600; text-decoration: none;">Thông tin tài khoản</a>
                </p>
                <a href="logout.php" style="color:#f44336; text-decoration:none; font-weight:bold;">Đăng xuất</a>
            </div>
        </div>
        <?php else: ?>
        <a href="dangki.php">
            <div class="circle-btn">
                <i class="fas fa-user"></i>
            </div>
        </a>
        <?php endif; ?>

    </div>

    <script>
    const userIcon = document.getElementById('user-icon');
    const userDropdown = document.getElementById('user-dropdown');
    if (userIcon) {
        // Toggle dropdown on click
        userIcon.addEventListener('click', () => {
            if (userDropdown.style.display === 'block') {
                userDropdown.style.display = 'none';
            } else {
                userDropdown.style.display = 'block';
            }
        });

        // Close dropdown if clicking outside
        document.addEventListener('click', (event) => {
            if (!userIcon.contains(event.target) && !userDropdown.contains(event.target)) {
                userDropdown.style.display = 'none';
            }
        });
    }
    </script>


</header>

<!-- Overlay tìm kiếm -->
<!-- Overlay tìm kiếm -->
<div id="search-overlay" class="search-overlay">
    <form action="tim_kiem.php" method="GET" class="search-form-box">
        <i class="fas fa-search search-icon"></i>
        <input type="text" name="keyword" class="search-input" placeholder="Tìm kiếm sản phẩm..." />
        <button type="button" class="close-search" onclick="hideSearch()">
            <i class="fas fa-times"></i>
        </button>
    </form>
</div>


<!-- JS Điều Khiển Tìm Kiếm -->
<script>
const searchIcon = document.querySelector('.fa-search');
const overlay = document.getElementById('search-overlay');

searchIcon.addEventListener('click', () => {
    overlay.style.display = 'flex';
    setTimeout(() => overlay.querySelector('input').focus(), 100);
});

function hideSearch() {
    overlay.style.display = 'none';
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') hideSearch();
});
</script>