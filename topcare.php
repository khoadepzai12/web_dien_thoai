    <?php include 'header.php'; ?>

    <style>
body {
    background-color: black;
    color: white;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

h2 {
    font-weight: bold;
    text-align: center;
    margin-bottom: 30px;
}

.icon i {
    color: #333;
}

.icon-circle {
    width: 80px;
    height: 80px;
    background-color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
}

.icon-process {
    width: 60px;
    height: 60px;
    object-fit: contain;
}

section.bg-grey-light {
    background-color: #f1f1f1;
}

@media (max-width: 768px) {
    .row {
        text-align: center;
    }
}

h1 {
    font-weight: bold;
    text-align: center;
    margin-bottom: 30px;
}

h2 {
    font-size: 40px;
    margin-bottom: 20px;
}

.logo img {
    max-width: 200px;
}

.intro {
    max-width: 800px;
    margin: auto;
    text-align: center;
    font-size: 1.1rem;
}

.gallery-wrapper {
    overflow: hidden;
    padding: 20px 0;
    position: relative;
}

.gallery {
    display: flex;
    gap: 20px;
    width: max-content;
    animation: scrollGallery 30s linear infinite;
}

.gallery img {
    border-radius: 20px;
    width: 100%;
    max-width: 500px;
    height: auto;
    flex-shrink: 0;
    box-shadow: 0 4px 10px rgba(255, 255, 255, 0.2);
}

@keyframes scrollGallery {
    0% {
        transform: translateX(0);
    }

    100% {
        transform: translateX(-50%);
    }
}

@media (max-width: 768px) {
    .gallery img {
        max-width: 200px;
    }
}

@media (max-width: 480px) {
    .gallery {
        animation: scrollGallery 20s linear infinite;
    }

    .gallery img {
        max-width: 150px;
    }
}

section.locations {
    margin-top: 40px;
    display: flex;
    justify-content: left;
    align-items: flex-start;
    margin-bottom: 20px;
}

.locations-content {
    text-align: left;
    max-width: 900px;
    margin-left: 5%;
}

.locations-content ul {
    list-style: none;
    padding: 0;
}

.locations-content li {
    margin: 8px 0;
    font-size: 20px;
}

.phone {
    color: #107efc;
    font-size: 20px;
}

.locations-content p {
    font-size: 20px;
}

.title {
    text-align: center;
    margin-bottom: 40px;
    font-size: 28px;
    font-weight: bold;
}

.rowsection {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 30px;
    margin-bottom: 40px;
}

.service-box {
    width: 300px;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    transition: box-shadow 0.3s;
}

.service-box:hover {
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.service-box img {
    width: 100px;
    height: auto;
    margin-bottom: 15px;
}

.service-box h2 {
    font-size: 18px;
    color: #222;
    margin-bottom: 10px;
}

.service-box p {
    font-size: 14px;
    color: #555;
    min-height: 50px;
    margin-bottom: 10px;
}

.service-box a {
    text-decoration: none;
    color: #0071e3;
    font-weight: bold;
    cursor: pointer;
}

.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-color: rgba(0, 0, 0, 0.4);
    backdrop-filter: blur(2px);
    z-index: 999;
    justify-content: center;
    align-items: center;
    overflow-y: auto;
}

.modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 90%;
    max-width: 700px;
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    padding: 16px;
    max-height: 90vh;
    overflow: hidden;
}

.modal-content {
    max-height: 400px;
    overflow-y: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

td,
th {
    padding: 10px;
    border-bottom: 1px solid #eee;
    font-size: 14px;
}

th {
    background-color: #f0f0f0;
}

.close-btn {
    float: right;
    font-size: 24px;
    background: none;
    border: none;
    cursor: pointer;
}

.tabs {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin: 16px 0;
}

.tab-button {
    padding: 8px 16px;
    border: 1px solid #ccc;
    border-radius: 12px;
    background-color: #fff;
    cursor: pointer;
    font-size: 12px;
}

.tab-button.active {
    border: 1px solid #007aff;
    color: #007aff;
    background-color: #f9f9f9;
}

.tab-content {
    display: none;
    margin-top: 16px;
}

.tab-content.active {
    display: block;
    overflow-y: auto;
    max-height: 400px;
}

.note {
    font-size: 14px;
    color: #444;
    text-align: center;
}
    </style>
    <section class="py-5 bg-grey-light text-dark" style="background-color: white;">
        <h1 class="title">Dịch vụ sửa chữa TopCare</h1>

        <div class="rowsection">
            <div class="service-box">
                <img src="Images/Iphone.png" alt="iPhone" />
                <h2>Sửa chữa điện thoại iPhone</h2>
                <p>Gửi đi xưởng sửa chữa Apple | Màn hình iPhone | Pin iPhone</p>
                <a class="open-modal" data-modal="iphoneModal">Sửa chữa tại TopCare</a>
            </div>

            <div class="service-box">
                <img src="Images/Ipad.png" alt="iPad" />
                <h2>Sửa chữa iPad</h2>
                <p>Đổi máy iPad</p>
                <a class="open-modal" data-modal="ipadModal">Sửa chữa tại TopCare</a>
            </div>

            <div class="service-box">
                <img src="Images/Macbook.png" alt="MacBook" />
                <h2>Sửa chữa MacBook</h2>
                <p>Logic Board MacBook | Pin MacBook | Màn hình MacBook</p>
                <a class="open-modal" data-modal="macbookModal">Sửa chữa tại TopCare</a>
            </div>
        </div>

        <div class="rowsection">
            <div class="service-box">
                <img src="Images/Watch.png" alt="Watch" />
                <h2>Sửa chữa Watch</h2>
                <p>Đổi máy Watch</p>
                <a class="open-modal" data-modal="watchModal">Sửa chữa tại TopCare</a>
            </div>

            <div class="service-box">
                <img src="Images/Airpod.png" alt="AirPods" />
                <h2>Sửa chữa AirPods</h2>
                <p>Đổi máy AirPods</p>
                <a class="open-modal" data-modal="airpodsModal">Sửa chữa tại TopCare</a>
            </div>
        </div>

        <!-- Modal iPhone -->
        <div class="modal-overlay" id="iphoneModal">
            <div class="modal">
                <button class="close-btn close-modal" data-modal="iphoneModal">
                    ×
                </button>
                <h2 align="center">Bảng giá Sửa chữa iPhone</h2>

                <div class="tabs">
                    <button class="tab-button active" data-tab="apple">
                        Gửi đi xưởng sửa chữa Apple
                    </button>
                    <button class="tab-button" data-tab="screen">
                        Màn hình iPhone và Kính lưng iPhone
                    </button>
                    <button class="tab-button" data-tab="battery">Pin iPhone</button>
                    <button class="tab-button" data-tab="camera">Camera</button>
                </div>
                <p class="note" align="center">
                    Thiết bị của quý khách sẽ được chuyển đến xưởng sửa chữa Apple để
                    được kiểm tra, báo giá phù hợp và có thể sửa chữa hoặc không sửa
                    được phải trả lại thiết bị. Kết quả sửa chữa hoàn toàn phụ thuộc vào
                    Apple và khách hàng sẽ được cập nhật thông tin ngay khi thiết bị
                    được sửa chữa hoàn tất.
                </p>
                <div class="tab-content active" id="tab-apple">
                    <table>
                        <tr>
                            <th>Dòng máy</th>
                            <th>Chi phí</th>
                        </tr>
                        <tr>
                            <td>iPhone 16 Pro Max - Đổi cả máy</td>
                            <td>23.300.000₫</td>
                        </tr>
                        <tr>
                            <td>iPhone 16 Pro Max - Thay cụm thân máy</td>
                            <td>17.100.000₫</td>
                        </tr>
                        <tr>
                            <td>iPhone 16 Pro Max - Thay màn hình</td>
                            <td>11.900.000₫</td>
                        </tr>
                        <tr>
                            <td>iPhone 16 Pro Max - Thay Camera trước</td>
                            <td>7.300.000₫</td>
                        </tr>
                        <tr>
                            <td>iPhone 16 Pro Max - Thay Camera sau</td>
                            <td>7.300.000₫</td>
                        </tr>
                        <tr>
                            <td>iPhone 16 Pro - Đổi cả máy</td>
                            <td>20.700.000₫</td>
                        </tr>
                        <tr>
                            <td>iPhone 16 Pro - Thay cụm thân máy</td>
                            <td>17.100.000₫</td>
                        </tr>
                        <tr>
                            <td>iPhone 16 Pro - Thay màn hình</td>
                            <td>11.900.000₫</td>
                        </tr>
                        <tr>
                            <td>iPhone 16 Pro - Camera trước</td>
                            <td>7.300.000₫</td>
                        </tr>
                        <tr>
                            <td>iPhone 16 Pro - Camera sau</td>
                            <td>7.300.000₫</td>
                        </tr>
                    </table>
                </div>

                <div class="tab-content" id="tab-screen">
                    <table>
                        <tr>
                            <th>Dòng máy</th>
                            <th>Chi phí</th>
                        </tr>
                        <tr>
                            <td>iPhone 15 Pro - Thay màn hình</td>
                            <td>10.200.000₫</td>
                        </tr>
                        <tr>
                            <td>iPhone 14 - Thay kính lưng</td>
                            <td>1.200.000₫</td>
                        </tr>
                    </table>
                </div>

                <div class="tab-content" id="tab-battery">
                    <table>
                        <tr>
                            <th>Dòng máy</th>
                            <th>Chi phí</th>
                        </tr>
                        <tr>
                            <td>iPhone 13 - Thay pin</td>
                            <td>1.100.000₫</td>
                        </tr>
                        <tr>
                            <td>iPhone 11 - Thay pin</td>
                            <td>900.000₫</td>
                        </tr>
                    </table>
                </div>

                <div class="tab-content" id="tab-camera">
                    <table>
                        <tr>
                            <th>Dòng máy</th>
                            <th>Chi phí</th>
                        </tr>
                        <tr>
                            <td>iPhone 13 Pro - Thay camera sau</td>
                            <td>5.200.000₫</td>
                        </tr>
                        <tr>
                            <td>iPhone 12 - Camera trước</td>
                            <td>3.000.000₫</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal iPad -->
        <div class="modal-overlay" id="ipadModal">
            <div class="modal">
                <button class="close-btn close-modal" data-modal="ipadModal">
                    ×
                </button>
                <h2 align="center">Bảng giá Sửa chữa iPad</h2>
                <div style="text-align: center; margin-bottom: 12px">
                    <button style="
                padding: 6px 16px;
                border: 1px solid #0071e3;
                background-color: white;
                border-radius: 8px;
                color: #0071e3;
                font-weight: bold;
                cursor: pointer;
              ">
                        Đổi máy iPad
                    </button>
                </div>
                <div class="modal-content">
                    <table>
                        <tr>
                            <th>Dòng máy</th>
                            <th>Chi phí</th>
                        </tr>
                        <tr>
                            <td>iPad Pro 13-inch (M4) Wi-Fi + Cellular</td>
                            <td>32.000.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 13-inch (M4) Wi-Fi</td>
                            <td>30.500.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 11-inch (M4) Wi-Fi + Cellular</td>
                            <td>27.400.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 11-inch (M4) Wi-Fi</td>
                            <td>25.900.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 12.9-inch thế hệ 6 Wi-Fi + Cellular</td>
                            <td>24.600.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 12.9-inch thế hệ 5 Wi-Fi + Cellular</td>
                            <td>24.600.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 12.9-inch thế hệ 6 Wi-Fi</td>
                            <td>22.700.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 12.9-inch thế hệ 5 Wi-Fi</td>
                            <td>22.700.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 11-inch thế hệ 4 Wi-Fi + Cellular</td>
                            <td>18.500.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 11-inch thế hệ 3 Wi-Fi + Cellular</td>
                            <td>18.500.000₫</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal MacBook -->
        <div class="modal-overlay" id="macbookModal">
            <div class="modal">
                <button class="close-btn close-modal" data-modal="macbookModal">
                    ×
                </button>
                <h2 align="center">Bảng giá Sửa chữa MacBook</h2>
                <div class="tabs">
                    <button class="tab-button active" data-tab="apple">
                        Gửi đi xưởng sửa chữa Apple
                    </button>
                    <button class="tab-button" data-tab="screen">
                        Màn hình iPhone và Kính lưng iPhone
                    </button>
                    <button class="tab-button" data-tab="battery">Pin iPhone</button>
                    <button class="tab-button" data-tab="camera">Camera</button>
                </div>
                <p class="note" align="center">
                    Thiết bị của quý khách sẽ được chuyển đến xưởng sửa chữa Apple để
                    được kiểm tra, báo giá phù hợp và có thể sửa chữa hoặc không sửa
                    được phải trả lại thiết bị. Kết quả sửa chữa hoàn toàn phụ thuộc vào
                    Apple và khách hàng sẽ được cập nhật thông tin ngay khi thiết bị
                    được sửa chữa hoàn tất.
                </p>
                <div class="tab-content active" id="tab-apple">
                    <table>
                        <tr>
                            <th>Dòng máy</th>
                            <th>Chi phí</th>
                        </tr>
                        <tr>
                            <td>iPhone 16 Pro Max - Đổi cả máy</td>
                            <td>23.300.000₫</td>
                        </tr>
                        <tr>
                            <td>iPhone 16 Pro Max - Thay cụm thân máy</td>
                            <td>17.100.000₫</td>
                        </tr>
                        <tr>
                            <td>iPhone 16 Pro Max - Thay màn hình</td>
                            <td>11.900.000₫</td>
                        </tr>
                        <tr>
                            <td>iPhone 16 Pro Max - Thay Camera trước</td>
                            <td>7.300.000₫</td>
                        </tr>
                        <tr>
                            <td>iPhone 16 Pro Max - Thay Camera sau</td>
                            <td>7.300.000₫</td>
                        </tr>
                        <tr>
                            <td>iPhone 16 Pro - Đổi cả máy</td>
                            <td>20.700.000₫</td>
                        </tr>
                        <tr>
                            <td>iPhone 16 Pro - Thay cụm thân máy</td>
                            <td>17.100.000₫</td>
                        </tr>
                        <tr>
                            <td>iPhone 16 Pro - Thay màn hình</td>
                            <td>11.900.000₫</td>
                        </tr>
                        <tr>
                            <td>iPhone 16 Pro - Camera trước</td>
                            <td>7.300.000₫</td>
                        </tr>
                        <tr>
                            <td>iPhone 16 Pro - Camera sau</td>
                            <td>7.300.000₫</td>
                        </tr>
                    </table>
                </div>

                <div class="tab-content" id="tab-screen">
                    <table>
                        <tr>
                            <th>Dòng máy</th>
                            <th>Chi phí</th>
                        </tr>
                        <tr>
                            <td>iPhone 15 Pro - Thay màn hình</td>
                            <td>10.200.000₫</td>
                        </tr>
                        <tr>
                            <td>iPhone 14 - Thay kính lưng</td>
                            <td>1.200.000₫</td>
                        </tr>
                    </table>
                </div>

                <div class="tab-content" id="tab-battery">
                    <table>
                        <tr>
                            <th>Dòng máy</th>
                            <th>Chi phí</th>
                        </tr>
                        <tr>
                            <td>iPhone 13 - Thay pin</td>
                            <td>1.100.000₫</td>
                        </tr>
                        <tr>
                            <td>iPhone 11 - Thay pin</td>
                            <td>900.000₫</td>
                        </tr>
                    </table>
                </div>

                <div class="tab-content" id="tab-camera">
                    <table>
                        <tr>
                            <th>Dòng máy</th>
                            <th>Chi phí</th>
                        </tr>
                        <tr>
                            <td>iPhone 13 Pro - Thay camera sau</td>
                            <td>5.200.000₫</td>
                        </tr>
                        <tr>
                            <td>iPhone 12 - Camera trước</td>
                            <td>3.000.000₫</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Watch -->
        <div class="modal-overlay" id="watchModal">
            <div class="modal">
                <button class="close-btn close-modal" data-modal="watchModal">
                    ×
                </button>
                <h2 align="center">Bảng giá Sửa chữa Apple Watch</h2>
                <div style="text-align: center; margin-bottom: 12px">
                    <button style="
                padding: 6px 16px;
                border: 1px solid #0071e3;
                background-color: white;
                border-radius: 8px;
                color: #0071e3;
                font-weight: bold;
                cursor: pointer;
              ">
                        Đổi máy Watch
                    </button>
                </div>
                <div class="modal-content">
                    <table>
                        <tr>
                            <th>Dòng máy</th>
                            <th>Chi phí</th>
                        </tr>
                        <tr>
                            <td>iPad Pro 13-inch (M4) Wi-Fi + Cellular</td>
                            <td>32.000.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 13-inch (M4) Wi-Fi</td>
                            <td>30.500.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 11-inch (M4) Wi-Fi + Cellular</td>
                            <td>27.400.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 11-inch (M4) Wi-Fi</td>
                            <td>25.900.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 12.9-inch thế hệ 6 Wi-Fi + Cellular</td>
                            <td>24.600.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 12.9-inch thế hệ 5 Wi-Fi + Cellular</td>
                            <td>24.600.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 12.9-inch thế hệ 6 Wi-Fi</td>
                            <td>22.700.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 12.9-inch thế hệ 5 Wi-Fi</td>
                            <td>22.700.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 11-inch thế hệ 4 Wi-Fi + Cellular</td>
                            <td>18.500.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 11-inch thế hệ 3 Wi-Fi + Cellular</td>
                            <td>18.500.000₫</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal AirPods -->
        <div class="modal-overlay" id="airpodsModal">
            <div class="modal">
                <button class="close-btn close-modal" data-modal="airpodsModal">
                    ×
                </button>
                <h2 align="center">Bảng giá Sửa chữa AirPods</h2>
                <div style="text-align: center; margin-bottom: 12px">
                    <button style="
                padding: 6px 16px;
                border: 1px solid #0071e3;
                background-color: white;
                border-radius: 8px;
                color: #0071e3;
                font-weight: bold;
                cursor: pointer;
              ">
                        Đổi máy AirPods
                    </button>
                </div>
                <div class="modal-content">
                    <table>
                        <tr>
                            <th>Dòng máy</th>
                            <th>Chi phí</th>
                        </tr>
                        <tr>
                            <td>iPad Pro 13-inch (M4) Wi-Fi + Cellular</td>
                            <td>32.000.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 13-inch (M4) Wi-Fi</td>
                            <td>30.500.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 11-inch (M4) Wi-Fi + Cellular</td>
                            <td>27.400.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 11-inch (M4) Wi-Fi</td>
                            <td>25.900.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 12.9-inch thế hệ 6 Wi-Fi + Cellular</td>
                            <td>24.600.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 12.9-inch thế hệ 5 Wi-Fi + Cellular</td>
                            <td>24.600.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 12.9-inch thế hệ 6 Wi-Fi</td>
                            <td>22.700.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 12.9-inch thế hệ 5 Wi-Fi</td>
                            <td>22.700.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 11-inch thế hệ 4 Wi-Fi + Cellular</td>
                            <td>18.500.000₫</td>
                        </tr>
                        <tr>
                            <td>iPad Pro 11-inch thế hệ 3 Wi-Fi + Cellular</td>
                            <td>18.500.000₫</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script>
// Xử lý modal
const modals = document.querySelectorAll(".modal-overlay");
const openModalButtons = document.querySelectorAll(".open-modal");
const closeModalButtons = document.querySelectorAll(".close-modal");

openModalButtons.forEach((button) => {
    button.addEventListener("click", () => {
        const modalId = button.getAttribute("data-modal");
        const modal = document.getElementById(modalId);
        modal.style.display = "flex";
    });
});

closeModalButtons.forEach((button) => {
    button.addEventListener("click", () => {
        const modalId = button.getAttribute("data-modal");
        const modal = document.getElementById(modalId);
        modal.style.display = "none";
    });
});

modals.forEach((modal) => {
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
});

// Xử lý tab
const tabButtons = document.querySelectorAll(".tab-button");
tabButtons.forEach((button) => {
    button.addEventListener("click", () => {
        const tab = button.getAttribute("data-tab");
        const modal = button.closest(".modal");
        const tabContents = modal.querySelectorAll(".tab-content");
        const tabButtons = modal.querySelectorAll(".tab-button");

        tabButtons.forEach((btn) => btn.classList.remove("active"));
        tabContents.forEach((content) => content.classList.remove("active"));

        button.classList.add("active");
        modal.querySelector(`#tab-${tab}`).classList.add("active");
    });
});
    </script>

    <!-- LÝ DO CHỌN TOPCARE -->
    <section class="py-5 bg-grey-light text-dark">
        <div class="container">
            <h2 class="fw-bold mb-5 text-center">Lý do lựa chọn TopCare</h2>
            <div class="row g-4">
                <div class="col-12 col-md-4">
                    <div class="icon mb-3"><i class="bi bi-apple fs-1"></i></div>
                    <h5 class="fw-bold">Chính hãng Apple</h5>
                    <p>
                        TopCare là trung tâm dịch vụ ủy quyền chính thức của Apple. Tất cả
                        linh kiện sửa chữa tại TopCare đều do Apple cung cấp chính hãng.
                    </p>
                </div>
                <div class="col-12 col-md-4">
                    <div class="icon mb-3"><i class="bi bi-award fs-1"></i></div>
                    <h5 class="fw-bold">Chứng chỉ Apple</h5>
                    <p>
                        100% đội ngũ chuyên viên và kỹ thuật viên của TopCare được đào tạo
                        và cấp chứng chỉ bởi Apple.
                    </p>
                </div>
                <div class="col-12 col-md-4">
                    <div class="icon mb-3"><i class="bi bi-lock-fill fs-1"></i></div>
                    <h5 class="fw-bold">Bảo mật tuyệt đối</h5>
                    <p>
                        Thông tin khách hàng cung cấp được bảo vệ nghiêm ngặt theo tiêu
                        chuẩn kiểm soát cao nhất.
                    </p>
                </div>
                <div class="col-12 col-md-4">
                    <div class="icon mb-3"><i class="bi bi-star-fill fs-1"></i></div>
                    <h5 class="fw-bold">Dịch vụ đẳng cấp</h5>
                    <p>
                        TopCare cam kết mang đến chất lượng phục vụ vượt trội dành cho
                        khách hàng.
                    </p>
                </div>
                <div class="col-12 col-md-4">
                    <div class="icon mb-3">
                        <i class="bi bi-piggy-bank-fill fs-1"></i>
                    </div>
                    <h5 class="fw-bold">Tiết kiệm</h5>
                    <p>
                        TopCare thường xuyên có các chương trình ưu đãi giúp khách hàng
                        tiết kiệm hơn khi sửa chữa sản phẩm.
                    </p>
                </div>
            </div>
        </div>
    </section>


    <!-- PHỤ KIỆN APPLE -->
    <section class="py-5 bg-white text-center text-dark">
        <div class="container">
            <h2 class="fw-bold mb-5">Phụ kiện chính hãng Apple tại TopCare</h2>
            <div class="row row-cols-2 row-cols-md-4 g-4">
                <div class="col">
                    <img class="img-fluid"
                        src="https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MQD83"
                        alt="Tai nghe" />
                    <p class="mt-2">Tai nghe</p>
                </div>
                <div class="col">
                    <img class="img-fluid" src="https://cdnv2.tgdd.vn/webmwg/2024/tz/images/topcare/accessory/img_2.png"
                        alt="Cáp | Sạc" />
                    <p class="mt-2">Cáp | Sạc</p>
                </div>
                <div class="col">
                    <img class="img-fluid" src="https://cdnv2.tgdd.vn/webmwg/2024/tz/images/topcare/accessory/img_3.png"
                        alt="Ốp lưng | Bao da" />
                    <p class="mt-2">Ốp lưng | Bao da</p>
                </div>
                <div class="col">
                    <img class="img-fluid" src="https://cdnv2.tgdd.vn/webmwg/2024/tz/images/topcare/accessory/img_4.png"
                        alt="Dây Apple Watch" />
                    <p class="mt-2">Dây Apple Watch</p>
                </div>
                <div class="col">
                    <img class="img-fluid" src="https://cdnv2.tgdd.vn/webmwg/2024/tz/images/topcare/accessory/img_5.png"
                        alt="AirTag" />
                    <p class="mt-2">AirTag</p>
                </div>
                <div class="col">
                    <img class="img-fluid" src="https://cdnv2.tgdd.vn/webmwg/2024/tz/images/topcare/accessory/img_6.png"
                        alt="Chuột | Trackpad" />
                    <p class="mt-2">Chuột | Trackpad</p>
                </div>
                <div class="col">
                    <img class="img-fluid" src="https://cdnv2.tgdd.vn/webmwg/2024/tz/images/topcare/accessory/img_7.png"
                        alt="Apple TV" />
                    <p class="mt-2">Apple TV</p>
                </div>
                <div class="col">
                    <img class="img-fluid" src="https://cdnv2.tgdd.vn/webmwg/2024/tz/images/topcare/accessory/img_8.png"
                        alt="Bàn phím" />
                    <p class="mt-2">Bàn phím</p>
                </div>
            </div>
        </div>
    </section>
    <!-- QUY TRÌNH BẢO HÀNH -->
    <section class="py-5 bg-grey-light text-center text-dark">
        <div class="container">
            <h2 class="fw-bold mb-4">Quy trình bảo hành TopCare</h2>
            <div class="row row-cols-2 row-cols-md-5 g-4">
                <div class="col">
                    <div class="icon-circle">
                        <img src="https://cdnv2.tgdd.vn/webmwg/2024/tz/images/topcare/warranty/icon_1.png"
                            alt="Kiểm tra trước" class="icon-process" />
                    </div>
                    <p>1. Kiểm tra tổng quan trước sửa chữa</p>
                </div>
                <div class="col">
                    <div class="icon-circle">
                        <img src="https://cdnv2.tgdd.vn/webmwg/2024/tz/images/topcare/warranty/icon_2.png"
                            alt="Đặt linh kiện" class="icon-process" />
                    </div>
                    <p>2. Đặt linh kiện</p>
                </div>
                <div class="col">
                    <div class="icon-circle">
                        <img src="https://cdnv2.tgdd.vn/webmwg/2024/tz/images/topcare/warranty/icon_3.png"
                            alt="Sửa chữa | Thay thế" class="icon-process" />
                    </div>
                    <p>3. Sửa chữa | Thay thế</p>
                </div>
                <div class="col">
                    <div class="icon-circle">
                        <img src="https://cdnv2.tgdd.vn/webmwg/2024/tz/images/topcare/warranty/icon_4.png"
                            alt="Kiểm tra sau" class="icon-process" />
                    </div>
                    <p>4. Kiểm tra tổng quan sau sửa chữa</p>
                </div>
                <div class="col">
                    <div class="icon-circle">
                        <img src="https://cdnv2.tgdd.vn/webmwg/2024/tz/images/topcare/warranty/icon_5.png"
                            alt="Trả sản phẩm" class="icon-process" />
                    </div>
                    <p>5. Trả sản phẩm</p>
                </div>
            </div>
            <p class="mt-4 text-muted">
                Điều khoản bảo hành sửa chữa Apple toàn cầu:
                <a href="#" class="text-decoration-none">Pháp lý</a> |
                <a href="#" class="text-decoration-none">Sửa chữa</a>
            </p>
        </div>
    </section>
    <!-- TRUNG TÂM BẢO HÀNH -->
    <section class="py-5 text-white" style="background-color: black">
        <div class="container">
            <h1 class="fw-bold text-center mb-4">
                Trung tâm bảo hành TopCare - Đẳng cấp khác biệt
            </h1>
            <div class="logo text-center mb-3">
                <img src="images/logo.png" alt="TopCare Logo" />
            </div>
            <div class="intro text-center">
                <p>
                    Tại Trung tâm bảo hành TopCare, khách hàng yêu mến hệ sinh thái
                    Apple sẽ trải nghiệm đầy đủ và đa dạng nhất các dịch vụ bảo hành
                    chính hãng Apple từ iPhone, iPad đến những chiếc tai nghe AirPods...
                    trong một không gian đẳng cấp và hiện đại.
                </p>
            </div>

            <div class="gallery-wrapper mt-4">
                <div class="gallery" id="gallery">
                    <img src="images/img_1-min.jpg" alt="Center 1" />
                    <img src="images/img_2-min.jpg" alt="Center 2" />
                    <img src="images/img_3-min.jpg" alt="Center 3" />
                    <img src="images/img_4-min.jpg" alt="Center 4" />
                    <img src="images/img_5-min.jpg" alt="Center 5" />
                    <img src="images/img_6-min.jpg" alt="Center 6" />
                    <img src="images/img_7-min.jpg" alt="Center 7" />
                    <img src="images/img_8-min.jpg" alt="Center 8" />
                    <img src="images/img_9-min.jpg" alt="Center 9" />
                    <img src="images/img_10-min.jpg" alt="Center 10" />
                    <img src="images/img_11-min.jpg" alt="Center 11" />
                </div>
            </div>

            <section class="locations mt-5">
                <div class="locations-content">
                    <h2 style="font-size: 40px">Trung tâm bảo hành TopCare</h2>
                    <ul>
                        <li>
                            <i class="fas fa-map-marker-alt"></i> 179 Nguyễn Văn Cừ, Phường
                            2, Quận 5, TP. Hồ Chí Minh.
                            <a href="#" class="phone" style="text-decoration: none">Xem chỉ đường</a>
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt"></i> 759 Cách Mạng Tháng Tám,
                            Phường 6, Quận Tân Bình, TP. Hồ Chí Minh.
                            <a href="#" class="phone" style="text-decoration: none">Xem chỉ đường</a>
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt"></i> 09 Giải Phóng, Phường Đồng
                            Tâm, Quận Hai Bà Trưng, Hà Nội.
                            <a href="#" class="phone" style="text-decoration: none">Xem chỉ đường</a>
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt"></i> 174 Lý Tự Trọng, An Cư,
                            Ninh Kiều, Cần Thơ.
                            <a href="#" class="phone" style="text-decoration: none">Xem chỉ đường</a>
                        </li>
                    </ul>
                    <p style="font-size: 20px">
                        <i class="fas fa-clock"></i> HCM & Cần Thơ: Từ 8:00 - 17:00 từ thứ
                        2 đến thứ 7 (không nghỉ trưa), CN không làm việc
                    </p>
                    <p style="font-size: 20px">
                        <i class="fas fa-clock"></i> Hà Nội: Từ 8:00 - 20:00 từ thứ 2 đến
                        Chủ nhật (không nghỉ trưa)
                    </p>
                    <p style="font-size: 20px">
                        <i class="fas fa-phone"></i>
                        <a class="phone" href="tel:1900232463" style="text-decoration: none">1900 232 463</a>
                    </p>
                </div>
            </section>
        </div>
    </section>
    <?php include 'footer.php'; ?>