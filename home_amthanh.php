  <!-- iphone----------------------------------------------------------- -->
  <?php
include 'connect.php'; // Kết nối CSDL

$sql = "
    SELECT sp.id, sp.ten_san_pham, sp.gia AS gia_goc, sp.phan_tram_giam,
           ROUND(sp.gia * (100 - sp.phan_tram_giam) / 100) AS gia,
           ha.ten_file
    FROM san_pham sp
    LEFT JOIN hinh_anh_san_pham ha ON ha.san_pham_id = sp.id
    WHERE sp.loai_id = 5
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
              Airpods
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