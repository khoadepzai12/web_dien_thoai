<?php
include 'connect.php';
include 'header.php';
// Hàm tính thời gian đăng
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    if ($diff->days > 7) return date('d/m', strtotime($datetime));
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = ['y' => 'năm','m' => 'tháng','w' => 'tuần','d' => 'ngày','h' => 'giờ','i' => 'phút','s' => 'giây'];
    foreach ($string as $k => &$v) {
        if ($diff->$k) $v = $diff->$k . ' ' . $v;
        else unset($string[$k]);
    }
    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' trước' : 'Vừa xong';
}

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$sql = "SELECT * FROM bai_viet WHERE slug = '$slug' AND hien_thi = 1 ORDER BY ngay_dang DESC";
$result = $conn->query($sql);
// BANNER: Lấy bài viết có ID 5,6,7
$sql_banner = "SELECT * FROM bai_viet 
        WHERE id IN (5,6,7) AND hien_thi = 1 
        ORDER BY FIELD(id, 5,6,7)";
$result_banner = $conn->query($sql_banner);
$banner_posts = [];
while ($row = $result_banner->fetch_assoc()) {
    $banner_posts[] = $row;
}

// MỚI NHẤT: Lấy bài mới nhất, không trùng với banner
$excluded_ids = array_column($banner_posts, 'id');

// Nếu mảng rỗng thì gán giá trị mặc định là '0' để tránh lỗi SQL
$excluded_ids_str = !empty($excluded_ids) ? implode(',', $excluded_ids) : '0';

$sql_latest = "SELECT * FROM bai_viet 
               WHERE loai_bai_viet = 'tin_tuc' 
               AND hien_thi = 1 
               AND id NOT IN ($excluded_ids_str)
               ORDER BY ngay_dang DESC 
               LIMIT 10";
$latest_result = $conn->query($sql_latest);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Bài viết - <?= htmlspecialchars($slug) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #333;
    }

    .card {
        overflow: hidden;
        border: none;
        border-radius: 8px;
    }

    .card-img {
        width: 100%;
        height: 400px;
        aspect-ratio: 16 / 9;
        object-fit: cover;
        margin-top: 0;
        padding-top: 0;
        transition: transform 0.3s ease;
    }

    .card-large {
        height: 400px;
        position: relative;
    }

    .card-large:hover .card-img {
        transform: scale(1.05);
    }

    .card-small {
        height: 170px;
        position: relative;
    }

    .card-small:hover .card-img {
        transform: scale(1.05);
    }

    .card-img-overlay {
        background: linear-gradient(to top, rgba(0, 0, 0, 0.65), transparent);
        padding: 1rem 1rem;
    }

    .card-title {
        font-size: 1rem;
        font-weight: bold;
        line-height: 1.4;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        display: -webkit-box;
        overflow: hidden;
    }


    /* MENU BOX */
    .menu-box {
        width: 100%;
        max-width: 400px;
        height: 60px;
        background-color: #2e2e2e;
        border-radius: 16px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
        color: #fff;
        text-align: left;
        padding: 20px 30px;
        font-weight: 500;
        font-size: 18px;
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        transform: perspective(500px) rotateX(2deg);
    }

    .menu-box:hover {
        transform: perspective(500px) rotateX(0deg) translateY(-3px);
        background-color: #3a3a3a;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
    }

    .menu-box img {
        width: 40px;
        height: 40px;
        filter: brightness(0) invert(1);
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .card-large {
            height: auto;
        }

        .card-small {
            height: auto;
        }

        .card-title {
            font-size: 0.95rem;
            -webkit-line-clamp: 2;
        }

        .card-img-overlay {
            padding: 0.75rem 1rem;
        }
    }

    @media (max-width: 576px) {
        .card-title {
            font-size: 0.9rem;
            -webkit-line-clamp: 2;
        }

        .card-img-overlay {
            padding: 0.5rem 0.75rem;
        }
    }
    </style>
</head>

<body>
    <div class="container py-4">
        <div class="row g-3">

            <?php if (count($banner_posts) >= 1): ?>
            <!-- Ảnh lớn bên trái -->
            <div class="col-12 col-md-8">
                <div class="card bg-dark text-white border-0">
                    <a href="chi_tiet_bai_viet.php?id=<?= $banner_posts[0]['id'] ?>" style="text-decoration: none;">
                        <div class="ratio ratio-16x9">
                            <img src="img/<?= $banner_posts[0]['thumbnail'] ?>" class="img-fluid rounded"
                                style="width: 100%; height: auto; aspect-ratio: 16/9; object-fit: cover;"
                                alt="Ảnh bài viết">
                        </div>
                        <div class="card-img-overlay d-flex align-items-end p-3"
                            style="background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);">
                            <h4 class="card-title fw-bold mb-0"><?= htmlspecialchars($banner_posts[0]['tieu_de']) ?>
                            </h4>
                        </div>
                    </a>
                </div>
            </div>
            <?php endif; ?>

            <?php if (count($banner_posts) >= 2): ?>
            <!-- Hai ảnh nhỏ bên phải -->
            <div class="col-12 col-md-4 d-flex flex-column gap-3">
                <?php for ($i = 1; $i < count($banner_posts); $i++): ?>
                <a href="chi_tiet_bai_viet.php?id=<?= $banner_posts[$i]['id'] ?>" style="text-decoration: none;">
                    <div class="card bg-dark text-white border-0">
                        <div class="ratio ratio-16x9">
                            <img src="img/<?= $banner_posts[$i]['thumbnail'] ?>" class="img-fluid rounded"
                                alt="Ảnh bài viết">
                        </div>
                        <div class="card-img-overlay d-flex align-items-end p-3"
                            style="background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);">
                            <h5 class="card-title fw-bold mb-0"><?= htmlspecialchars($banner_posts[$i]['tieu_de']) ?>
                            </h5>
                        </div>
                    </div>
                </a>
                <?php endfor; ?>
            </div>
            <?php endif; ?>

        </div>
    </div>
    <div class="container pb-4">
        <div class="row justify-content-center gx-3 gy-3">
            <?php
    $menu_items = [
      'iPhone' => ['icon' => 'icon-iphone.png', 'slug' => 'iphone'],
      'Mac' => ['icon' => 'icon-mac.png', 'slug' => 'mac'],
      'iPad' => ['icon' => 'icon-ipad.png', 'slug' => 'ipad'],
      'Watch' => ['icon' => 'icon-watch.png', 'slug' => 'watch'],
      'Âm thanh' => ['icon' => 'icon-audio.png', 'slug' => 'amthanh'],
      'Phụ kiện' => ['icon' => 'icon-accessory.png', 'slug' => 'phukien'],
      'Dịch vụ' => ['icon' => 'icon-tv.png', 'slug' => 'dichvu']
    ];

    foreach ($menu_items as $label => $item):
      $slug = $item['slug'];
      $icon = $item['icon'];
    ?>
            <div class="col-auto">
                <a href="bai_viet_theo_slug.php?slug=<?= $slug ?>" class="text-decoration-none">
                    <div class="menu-box">
                        <img src="img/<?= $icon ?>" alt="<?= $label ?>">
                        <div><?= $label ?></div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="container py-5 px-4">


        <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()):
      $img = 'img/' . htmlspecialchars($row['thumbnail']);
      $title = htmlspecialchars($row['tieu_de']);
      $timeAgo = time_elapsed_string($row['ngay_dang']);
      $link = 'chi_tiet_bai_viet.php?id=' . $row['id'];
    ?>
        <div class="d-flex mb-3" style="max-width: 100%;">
            <a href="<?= $link ?>" class="me-3">
                <img src="<?= $img ?>" class="img-fluid rounded" style="max-height: 200px; object-fit: cover;"
                    alt="<?= $title ?>">
            </a>
            <div class="text-start" style="flex: 1;">
                <a href="<?= $link ?>" class="text-decoration-none">
                    <h6 class="fw-bold mb-1 text-wrap" style="font-size: 25px; color: #ddd;"><?= $title ?></h6>
                </a>
                <small class="text-white-50"><?= $timeAgo ?></small>
            </div>
        </div>
        <div class="border-line"></div>
        <?php endwhile; ?>
        <?php else: ?>
        <p class="text-white-50">Không có bài viết nào trong chuyên mục này.</p>
        <?php endif; ?>
    </div>
</body>

</html>
<?php include 'fooder1.php'; ?>