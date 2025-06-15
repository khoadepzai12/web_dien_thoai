<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>TekZone</title>
    <link rel="icon" href="img/logo-topzone-removebg-preview.png" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">

    <style>
    body {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background-color: white;
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

    /* --- RESPONSIVE --- */
    @media (max-width: 768px) {
        .menu {
            flex-direction: column;
            gap: 10px;
        }

        .menu li a {
            font-size: 14px;
        }

        .icon-area {
            flex-direction: column;
            gap: 12px;
        }

        .circle-btn {
            width: 40px;
            height: 40px;
        }
    }

    @media (max-width: 576px) {
        .menu li a {
            font-size: 12px;
        }

        .icon-area {
            gap: 8px;
        }

        .circle-btn {
            width: 30px;
            height: 30px;
        }
    }
    </style>
</head>

<body>

    <header class="sticky-top bg-dark text-white py-2">
        <!-- Logo -->
        <div class="logo-area">
            <a href="home.php"><img src="img/logo-topzone-removebg-preview.png" alt="TopZone Logo"
                    class="topzone-logo"></a>
            <a href="#"> <img src="img/tao1.png" alt="Apple Premium" class="apple-logo"></a>
        </div>

        <!-- Menu -->
        <ul class="menu">
            <li><a href="iphone.php">iPhone</a></li>
            <li><a href="Macbook.php">Mac</a></li>
            <li><a href="ipad.php">iPad</a></li>
            <li><a href="watch.php">Watch</a></li>
            <li><a href="am-thanh.php">Tai nghe, Loa</a></li>
            <li><a href="phukien.php">Phụ kiện</a></li>
            <li><a href="tekzone.php">TekZone</a></li>
            <li><a href="topcare.php">Top Care</a></li>
        </ul>

        <!-- Icons -->
        <div class="icon-area">
            <div class="circle-btn" id="search-icon">
                <i class="fas fa-search"></i>
            </div>
            <!-- Thay cái này bằng đoạn có số lượng -->
            <?php
      $so_luong = 0;
      if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $sl) $so_luong += $sl;
      }
      ?>
            <a href="gio_hang.php" class="circle-btn position-relative text-decoration-none text-white">
                <i class="fas fa-bag-shopping"></i>
                <?php if ($so_luong > 0): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?= $so_luong ?>
                </span>
                <?php endif; ?>
            </a>

            <div class="circle-btn"><i class="fas fa-user"></i></div>
        </div>
    </header>

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

</body>

</html>