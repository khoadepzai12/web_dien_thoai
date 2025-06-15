-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 12, 2025 lúc 02:26 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `webmobile0906`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bai_viet`
--

CREATE TABLE `bai_viet` (
  `id` int(11) NOT NULL,
  `tieu_de` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `noi_dung` longtext DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `loai_bai_viet` enum('tin_tuc','thong_bao','khuyen_mai','dich_vu') DEFAULT 'tin_tuc',
  `hien_thi` tinyint(1) DEFAULT 1,
  `ngay_dang` datetime DEFAULT current_timestamp(),
  `tac_gia_admin_id` int(11) DEFAULT NULL,
  `tac_gia_text` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bai_viet`
--

INSERT INTO `bai_viet` (`id`, `tieu_de`, `slug`, `noi_dung`, `thumbnail`, `loai_bai_viet`, `hien_thi`, `ngay_dang`, `tac_gia_admin_id`, `tac_gia_text`) VALUES
(15, 'hello2 ggggggggg', 'iphone', 'ffffffffffffff', '6849c0585fa0c_tải xuống.jpg', 'tin_tuc', 1, '2025-06-12 00:33:15', 1, 'Ru Min'),
(18, '7', '7', '2', '6849c54e939e7_tải xuống (2).jpg', 'tin_tuc', 1, '2025-06-12 01:05:02', 1, '2'),
(19, 'iphone 4444444444444444444444444', 'iphone', 'rrrrrrrrrrrrrrrr', '6849c6d17dc10_tải xuống.jpg', 'tin_tuc', 1, '2025-06-12 01:11:29', 1, 'rumin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bai_viet_chi_tiet`
--

CREATE TABLE `bai_viet_chi_tiet` (
  `id` int(11) NOT NULL,
  `bai_viet_id` int(11) NOT NULL,
  `loai` enum('noi_dung','hinh_anh') NOT NULL,
  `noidung_hoac_hinh` text NOT NULL,
  `thu_tu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bai_viet_chi_tiet`
--

INSERT INTO `bai_viet_chi_tiet` (`id`, `bai_viet_id`, `loai`, `noidung_hoac_hinh`, `thu_tu`) VALUES
(15, 15, 'noi_dung', 'hello1', 1),
(16, 15, 'noi_dung', 'hello3', 3),
(17, 15, 'hinh_anh', '6849c081c5578_tải xuống (1).jpg', 2),
(23, 18, 'noi_dung', '2', 1),
(24, 18, 'hinh_anh', '6849c5727b686_images.jpg', 2),
(25, 18, 'hinh_anh', '6849c5e9973fb_images (1).jpg', 3),
(26, 18, 'hinh_anh', '6849c66e31d8a_images (1).jpg', 4),
(27, 19, 'noi_dung', '1', 1),
(28, 19, 'hinh_anh', '6849c6d17e2c4_images.jpg', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bao_hanh`
--

CREATE TABLE `bao_hanh` (
  `id` int(11) NOT NULL,
  `chi_tiet_don_hang_id` int(11) DEFAULT NULL,
  `ngay_bat_dau` date DEFAULT NULL,
  `ngay_ket_thuc` date DEFAULT NULL,
  `trang_thai` enum('con_han','het_han','da_bao_hanh') DEFAULT 'con_han',
  `ghi_chu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bao_hanh`
--

INSERT INTO `bao_hanh` (`id`, `chi_tiet_don_hang_id`, `ngay_bat_dau`, `ngay_ket_thuc`, `trang_thai`, `ghi_chu`) VALUES
(1, 1, '2025-06-08', '2026-06-08', 'con_han', 'Bảo hành chính hãng Apple');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_don_hang`
--

CREATE TABLE `chi_tiet_don_hang` (
  `id` int(11) NOT NULL,
  `don_hang_id` int(11) DEFAULT NULL,
  `san_pham_id` int(11) DEFAULT NULL,
  `so_luong` int(11) DEFAULT NULL,
  `gia` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chi_tiet_don_hang`
--

INSERT INTO `chi_tiet_don_hang` (`id`, `don_hang_id`, `san_pham_id`, `so_luong`, `gia`) VALUES
(1, 1, 1, 1, 33990000.00),
(2, 2, 2, 2, 16490000.00),
(3, 3, 2, 1, 35990000.00),
(4, 4, 3, 1, 38990000.00),
(5, 5, 3, 1, 38990000.00),
(6, 6, 3, 1, 38990000.00),
(13, 18, 2, 1, 35990000.00),
(14, 19, 5, 1, 28990000.00),
(15, 20, 4, 10, 16490000.00),
(16, 21, 4, 1, 16490000.00),
(17, 22, 2, 1, 35990000.00),
(18, 23, 4, 1, 16490000.00),
(19, 23, 1, 1, 33990000.00),
(20, 24, 8, 1, 12000000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danh_gia`
--

CREATE TABLE `danh_gia` (
  `id` int(11) NOT NULL,
  `khach_hang_id` int(11) DEFAULT NULL,
  `san_pham_id` int(11) DEFAULT NULL,
  `so_sao` int(11) DEFAULT NULL CHECK (`so_sao` between 1 and 5),
  `binh_luan` text DEFAULT NULL,
  `ngay_danh_gia` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `danh_gia`
--

INSERT INTO `danh_gia` (`id`, `khach_hang_id`, `san_pham_id`, `so_sao`, `binh_luan`, `ngay_danh_gia`) VALUES
(1, 1, 1, 5, 'Sản phẩm tuyệt vời!', '2025-06-08 17:19:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dia_chi_giao_hang`
--

CREATE TABLE `dia_chi_giao_hang` (
  `id` int(11) NOT NULL,
  `khach_hang_id` int(11) NOT NULL,
  `ten_nguoi_nhan` varchar(100) NOT NULL,
  `dia_chi` text NOT NULL,
  `so_dien_thoai` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `dia_chi_giao_hang`
--

INSERT INTO `dia_chi_giao_hang` (`id`, `khach_hang_id`, `ten_nguoi_nhan`, `dia_chi`, `so_dien_thoai`) VALUES
(2, 2, 'Nguyễn Văn B', '123 Đường ABCDÈ, Quận 2, TP. Hồ Chí Minh', '09123456999'),
(3, 3, 'Ru Min', 'HCM', '454777'),
(7, 4, 'Ru Min', 'jj', '67799');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `don_hang`
--

CREATE TABLE `don_hang` (
  `id` int(11) NOT NULL,
  `khach_hang_id` int(11) DEFAULT NULL,
  `ngay_dat` datetime DEFAULT current_timestamp(),
  `trang_thai` enum('cho_xu_ly','dang_giao','da_giao','huy') DEFAULT 'cho_xu_ly',
  `tong_tien` decimal(12,2) DEFAULT NULL,
  `hinh_thuc_thanh_toan` enum('COD','Chuyen_khoan','VNPay') DEFAULT 'COD',
  `trang_thai_thanh_toan` enum('chua_thanh_toan','da_thanh_toan') DEFAULT 'chua_thanh_toan',
  `ma_giam_gia_id` int(11) DEFAULT NULL,
  `dia_chi_giao_hang_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `don_hang`
--

INSERT INTO `don_hang` (`id`, `khach_hang_id`, `ngay_dat`, `trang_thai`, `tong_tien`, `hinh_thuc_thanh_toan`, `trang_thai_thanh_toan`, `ma_giam_gia_id`, `dia_chi_giao_hang_id`) VALUES
(1, 1, '2025-06-08 17:19:00', 'da_giao', 33990000.00, 'COD', 'da_thanh_toan', 1, 0),
(2, 2, '2025-06-08 17:19:00', 'dang_giao', 32980000.00, 'VNPay', 'chua_thanh_toan', 2, 0),
(3, 3, '2025-06-10 20:15:32', 'cho_xu_ly', 30591500.00, 'COD', 'chua_thanh_toan', 2, 0),
(4, 1, '2025-06-10 20:20:31', 'cho_xu_ly', 33141500.00, 'COD', 'chua_thanh_toan', 2, 0),
(5, 1, '2025-06-10 22:48:57', 'cho_xu_ly', 38210200.00, 'COD', 'chua_thanh_toan', NULL, 1),
(6, 1, '2025-06-10 22:50:16', 'cho_xu_ly', 38210200.00, 'COD', 'da_thanh_toan', NULL, 1),
(18, 1, '2025-06-11 00:13:14', 'cho_xu_ly', 35990000.00, 'COD', 'chua_thanh_toan', NULL, 0),
(19, 1, '2025-06-11 00:13:22', 'cho_xu_ly', 28990000.00, 'COD', 'chua_thanh_toan', NULL, 0),
(20, 4, '2025-06-11 09:01:39', 'dang_giao', 161618490.00, 'COD', 'da_thanh_toan', 1, 0),
(21, 4, '2025-06-11 15:24:01', 'cho_xu_ly', 16490000.00, 'Chuyen_khoan', 'da_thanh_toan', NULL, 0),
(22, 4, '2025-06-11 15:47:28', 'cho_xu_ly', 35990000.00, 'COD', 'chua_thanh_toan', NULL, 0),
(23, 4, '2025-06-11 20:12:17', 'cho_xu_ly', 49475448.00, 'COD', 'chua_thanh_toan', 1, 0),
(24, 4, '2025-06-12 01:14:42', 'cho_xu_ly', 11761200.00, 'Chuyen_khoan', 'chua_thanh_toan', 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `gio_hang`
--

CREATE TABLE `gio_hang` (
  `id` int(11) NOT NULL,
  `khach_hang_id` int(11) DEFAULT NULL,
  `san_pham_id` int(11) DEFAULT NULL,
  `so_luong` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `gio_hang`
--

INSERT INTO `gio_hang` (`id`, `khach_hang_id`, `san_pham_id`, `so_luong`) VALUES
(23, 1, 3, 2),
(43, 4, 26, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hinh_anh_san_pham`
--

CREATE TABLE `hinh_anh_san_pham` (
  `id` int(11) NOT NULL,
  `san_pham_id` int(11) DEFAULT NULL,
  `ten_file` varchar(255) DEFAULT NULL,
  `mo_ta_ngan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `hinh_anh_san_pham`
--

INSERT INTO `hinh_anh_san_pham` (`id`, `san_pham_id`, `ten_file`, `mo_ta_ngan`) VALUES
(14, 9, '../img/apple-watch-se-2023-gps-40mm-sport-loop-xanh-1-638671122940120069-650x650.jpg', 'dd'),
(15, 9, '../img/apple-watch-se-2023-gps-40mm-sport-loop-xanh-2-638671122947651845-650x650.jpg', 'ggg'),
(21, 10, '../img/iphone-16-pro-max-titan-sa-mac-thumbnew-650x650.png', '1'),
(22, 11, '../img/iphone-16-pro-max-titan-den-thumbnew-650x650.png', '2'),
(23, 11, '../img/iphone-16-pro-max-black-titan-9-638621795378633506-650x650.jpg', '2'),
(24, 11, '../img/iphone-16-pro-max-black-titan-10-638621795385311872-650x650.jpg', '9'),
(25, 11, '../img/Screenshot 2025-06-12 024147.png', 'logo'),
(26, 10, '../img/iphone-16-pro-max-titan-sa-mac-thumbnew-650x650.png', '9'),
(27, 10, '../img/iphone-16-pro-max-titan-sa-mac-3-638638962351331027-750x500.jpg', 'logo'),
(28, 10, '../img/iphone-16-pro-max-desert-titan-9-638621795626802491-200x200.jpg', 'logo'),
(29, 10, '../img/Screenshot 2025-06-12 024147.png', '9'),
(30, 12, '../img/iphone-16-pro-max-titan-sa-mac-thumbnew-650x650 (1).png', 'logo'),
(31, 12, '../img/iphone-16-pro-max-desert-titan-2-638621795820805902-650x650.jpg', 'logo'),
(32, 12, '../img/iphone-16-pro-max-desert-titan-6-638621795603626395-650x650.jpg', 'logo'),
(33, 12, '../img/iphone-16-pro-max-black-titan-10-638621795385311872-650x650.jpg', '2'),
(34, 13, '../img/iphone-16-pro-max-titan-trang-thumb-650x650.png', '2'),
(35, 13, '../img/iphone-16-pro-max-white-titan-1-638621796423794565-650x650.jpg', '9'),
(36, 13, '../img/iphone-16-pro-max-white-titan-3-638621796439271194-650x650.jpg', '9'),
(37, 13, '../img/iphone-16-pro-max-white-titan-4-638621796445992299-650x650.jpg', '2'),
(38, 13, '../img/iphone-16-pro-max-white-titan-9-638621796486897235-650x650.jpg', '2'),
(39, 13, '../img/Screenshot 2025-06-12 033323.png', '9'),
(40, 1, '../img/iphone-15-pro-max-blue-1-2-650x650.png', '9'),
(41, 1, '../img/iphone-15-pro-max-blue-titan-2-650x650.jpg', '2'),
(42, 1, '../img/iphone-15-pro-max-blue-titan-1-650x650.jpg', 'logo'),
(43, 1, '../img/iphone-15-pro-max-blue-titan-3-650x650.jpg', '2'),
(44, 1, '../img/iphone-15-pro-max-blue-titan-4-650x650.jpg', '2'),
(45, 1, '../img/iphone-15-pro-max-blue-titan-4-650x650.jpg', '2'),
(46, 1, '../img/iphone-15-pro-max-blue-titan-5-650x650.jpg', '9'),
(47, 1, '../img/iphone-15-pro-max-blue-titan-6-650x650.jpg', '2'),
(48, 2, '../img/iphone-15-pro-max-gold-1-2-650x650.png', 'e'),
(49, 2, '../img/iphone-15-pro-max-natural-titan-1-650x650.jpg', '2'),
(50, 2, '../img/iphone-15-pro-max-natural-titan-2-650x650.jpg', '3'),
(51, 2, '../img/iphone-15-pro-max-natural-titan-3-650x650.jpg', 'mô tả ảnh'),
(52, 2, '../img/iphone-15-pro-max-natural-titan-4-650x650.jpg', '2'),
(53, 2, '../img/iphone-15-pro-max-natural-titan-5-650x650.jpg', '2'),
(54, 2, '../img/iphone-15-pro-max-natural-titan-7-650x650.jpg', '2'),
(55, 2, '../img/iphone-15-pro-max-natural-titan-9-650x650.jpg', '2'),
(56, 2, '../img/Screenshot 2025-06-12 034255.png', ''),
(57, 3, '../img/iphone-15-yellow-650x650.png', 'mô tả ảnh'),
(58, 3, '../img/iphone-15-yellow-2-650x650.jpg', 'r'),
(59, 3, '../img/iphone-15-yellow-3-650x650.jpg', 'r'),
(60, 3, '../img/iphone-15-yellow-9-650x650.jpg', 'r'),
(61, 3, '../img/iphone-15-yellow-10-650x650.jpg', 'r'),
(62, 8, '../img/iphone-13-white-1-2-3-650x650.png', '2'),
(63, 8, '../img/iphone-13-trang-1-650x650.jpg', '2'),
(64, 8, '../img/iphone-13-trang-2-650x650.jpg', '2'),
(65, 8, '../img/iphone-13-trang-3-650x650.jpg', '1'),
(66, 8, '../img/iphone-13-trang-3-650x650.jpg', 'mô tả ảnh'),
(67, 8, '../img/iphone-13-trang-7-650x650.jpg', '2'),
(68, 8, '../img/iphone-13-trang-4-650x650.jpg', '1'),
(69, 5, '../img/Mac-Air-13-M2-vang-1-650x650.png', 'ơ'),
(70, 5, '../img/Mac-Air-13-M2-vang-1-650x650.png', ''),
(71, 14, '../img/macbook-air-15-inch-m4-thumb-xanh-da-troi-650x650.png', 'logo'),
(72, 14, '../img/macbook-air-15-inch-m4-topzone-1-638772017494704923-650x650.jpg', '2'),
(73, 14, '../img/macbook-air-15-inch-m4-topzone-2-638772017500736849-650x650.jpg', '1'),
(74, 14, '../img/macbook-air-15-inch-m4-topzone-3-638772017507363970-650x650.jpg', '1'),
(75, 14, '../img/macbook-air-15-inch-m4-topzone-4-638772017513700170-650x650.jpg', 't'),
(76, 14, '../img/macbook-air-15-inch-m4-topzone-6-638772017534231810-650x650.jpg', '9'),
(77, 14, '../img/macbook-air-15-inch-m4-topzone-8-638772017548947458-650x650.jpg', '1'),
(78, 14, '../img/macbook-air-15-inch-m4-topzone-10-638772017572675222-650x650.jpg', 'mô tả ảnh'),
(79, 15, '../img/macbook-pro-16-inch-m4-den-thumb-650x650.png', '8'),
(80, 15, '../img/macbook-pro-16-nano-m4-pro-24-512-den-topzone-1-638682329977021423-650x650.jpg', '8'),
(81, 15, '../img/macbook-pro-16-nano-m4-pro-24-512-den-topzone-4-638682330000736221-650x650.jpg', 'i'),
(82, 15, '../img/macbook-pro-16-nano-m4-pro-24-512-den-topzone-5-638682330009271799-650x650.jpg', 'i'),
(83, 15, '../img/macbook-pro-16-nano-m4-pro-24-512-den-topzone-6-638682330019643256-650x650.jpg', 'i'),
(84, 15, '../img/macbook-pro-16-nano-m4-pro-24-512-den-topzone-7-638682330033914144-650x650.jpg', 'i'),
(85, 16, '../img/imac-24-inch-m4-24gb-256gb-thumb-6-650x650.png', 'y'),
(86, 16, '../img/imac-24-inch-m4-24gb-256gb-tim-site-16-1-638765966497912802-650x650.jpg', 'j'),
(87, 16, '../img/imac-24-inch-m4-24gb-256gb-tim-site-16-2-638765966489702582-650x650.jpg', 'j'),
(88, 16, '../img/imac-24-inch-m4-24gb-256gb-tim-site-16-3-638765966482044063-650x650.jpg', 'j'),
(89, 16, '../img/imac-24-inch-m4-24gb-256gb-tim-site-16-3-638765966482044063-650x650.jpg', 'j'),
(90, 16, '../img/imac-24-inch-m4-24gb-256gb-tim-site-16-5-638765966461710264-650x650.jpg', 'j'),
(91, 16, '../img/imac-24-inch-m4-24gb-256gb-tim-site-16-6-638765966450854796-650x650.jpg', 'j'),
(92, 4, '../img/ipad-air-m2-11-inch-wifi-cellular-blue-thumb-650x650.png', 't'),
(93, 4, '../img/ipad-air-m2-11-inch-wifi-cellular-xanh-1-650x650.jpg', 't'),
(94, 4, '../img/ipad-air-m2-11-inch-wifi-cellular-xanh-3-650x650.jpg', 't'),
(95, 4, '../img/ipad-air-m2-11-inch-wifi-cellular-xanh-4-650x650.jpg', '6'),
(96, 4, '../img/ipad-air-m2-11-inch-wifi-cellular-xanh-8-650x650.jpg', 'ư'),
(97, 4, '../img/ipad-air-m2-11-inch-wifi-cellular-xanh-9-650x650.jpg', 'ư'),
(98, 4, '../img/ipad-air-m2-11-inch-wifi-cellular-xanh-10-650x650.jpg', 'ư'),
(99, 17, '../img/ipad-11-wifi-pink-thumb-650x650.png', 'u'),
(100, 17, '../img/ipad-11-wifi-pink-1-638769376041616979-650x650.jpg', 'u'),
(101, 17, '../img/ipad-11-wifi-pink-2-638769376051723382-650x650.jpg', 'u'),
(102, 17, '../img/ipad-11-wifi-pink-5-638769376075377031-650x650.jpg', 'u'),
(103, 17, '../img/ipad-11-wifi-pink-7-638769376092466068-650x650.jpg', 'u'),
(104, 17, '../img/ipad-11-wifi-pink-8-638769376102021955-650x650.jpg', 'u'),
(105, 18, '../img/ipad-pro-11-inch-5g-black-thumb-650x650.png', 'i'),
(106, 18, '../img/ipad-pro-m4-11-inch-5g-black-1-650x650.jpg', 'i'),
(107, 18, '../img/ipad-pro-m4-11-inch-5g-black-3-650x650.jpg', 'l'),
(108, 18, '../img/ipad-pro-m4-11-inch-5g-black-4-650x650.jpg', 'l'),
(109, 18, '../img/ipad-pro-m4-11-inch-5g-black-4-650x650.jpg', 'l'),
(110, 18, '../img/ipad-pro-m4-11-inch-5g-black-5-650x650.jpg', 'l'),
(111, 18, '../img/ipad-pro-m4-11-inch-5g-black-6-650x650.jpg', 'l'),
(112, 18, '../img/ipad-pro-m4-11-inch-5g-black-9-650x650.jpg', 'l'),
(113, 18, '../img/ipad-pro-m4-11-inch-5g-black-10-650x650.jpg', 'l'),
(114, 19, '../img/ipad-mini-7-5g-starlight-thumbtz-650x650.png', 't'),
(115, 19, '../img/ipad-mini-7-5g-starlight-1-638652073236525840-650x650.jpg', 'h'),
(116, 19, '../img/ipad-mini-7-5g-starlight-2-638652073243216098-650x650.jpg', 'h'),
(117, 19, '../img/ipad-mini-7-5g-starlight-3-638652073252310504-650x650.jpg', 'h'),
(118, 19, '../img/ipad-mini-7-5g-starlight-4-638652073259894962-650x650.jpg', 'h'),
(119, 19, '../img/ipad-mini-7-5g-starlight-7-638652073275996542-650x650.jpg', 'h'),
(120, 19, '../img/ipad-mini-7-5g-starlight-9-638652073287430356-650x650.jpg', 'h'),
(121, 22, '../img/apple-watch-s10-den-tb-650x650.png', 's'),
(122, 26, '../img/apple-watch-series-10-lte-42mm-day-vai-xanh-nhat-tb-650x650.png', 's'),
(123, 27, '../img/tách nền site 16 (2)-650x650.png', 'd'),
(124, 28, '../img/apple-watch-ultra-2-gps-cellular-49mm-vien-titanium-day-alpine-xanh-den-650x650.png', 'd'),
(125, 29, '../img/apple-watch-series-10-lte-42mm-day-vai-den-tb-650x650.png', 'd'),
(126, 30, '../img/apple-watch-series-10-lte-42mm-day-vai-xanh-nhat-tb-650x650.png', 'd'),
(127, 31, '../img/tách nền site 16 (1)-650x650.png', 'd'),
(128, 32, '../img/apple-watch-series-10-lte-42mm-day-vai-xanh-nhat-tb-650x650.png', 'f'),
(129, 32, '../img/tách nền site 16 (2)-650x650.png', 'f'),
(130, 33, '../img/apple-watch-s10-den-tb-650x650.png', 'c'),
(131, 6, '../img/airpods-3-hop-sac-khong-day-thumb-650x650.png', ''),
(132, 20, '../img/tai-nghe-bluetooth-airpods-pro-2nd-gen-usb-c-charge-apple-thumb-12-1-650x650.png', '9'),
(134, 38, '../img/tai-nghe-co-day-apple-mtjy3-thumb-650x650.png', 'rt'),
(135, 39, '../img/loa-bluetooth-marshall-emberton-iii-den-1-638614953620315289-650x650.jpg', 'd'),
(136, 40, '../img/loa-bluetooth-marshall-emberton-iii-xam-2-638614954046087163-650x650.jpg', 'd'),
(137, 41, '../img/loa-bluetooth-sony-srs-ult10-den-1-650x650.jpg', 'ư'),
(138, 42, '../img/loa-bluetooth-sony-srs-ult10-cam-1-650x650.jpg', 'ư'),
(139, 43, '../img/adapter-sac-type-c-20w-cho-iphone-ipad-apple-mhje3-101021-023343-650x650.png', ''),
(140, 37, '../img/tai-nghe-co-day-apple-mtjy3-thumb-650x650.png', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khach_hang`
--

CREATE TABLE `khach_hang` (
  `id` int(11) NOT NULL,
  `ho_ten` varchar(100) DEFAULT NULL,
  `sdt` varchar(20) DEFAULT NULL,
  `dia_chi` text DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mat_khau` varchar(255) DEFAULT NULL,
  `vai_tro_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khach_hang`
--

INSERT INTO `khach_hang` (`id`, `ho_ten`, `sdt`, `dia_chi`, `email`, `mat_khau`, `vai_tro_id`) VALUES
(1, 'Nguyễn Văn A', '0912345678', 'Hà Nội', 'a.nguyen@example.com', 'matkhau123', 1),
(2, 'Trần Thị B', '0987654321', 'TP. HCM', 'b.tran@example.com', '12345678', 1),
(3, 'Lê Minh C', '0961234567', 'Đà Nẵng', 'c.le@example.com', 'matkhau321', 1),
(4, 'MIN NGUYEN', '0352999205', 'THẠNH THỚI, VĨNH HỰU, GÒ CÔNG TÂY, TIỀN GIANG', 'axezmin@gmail.com', '123@Abcd', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loai_san_pham`
--

CREATE TABLE `loai_san_pham` (
  `id` int(11) NOT NULL,
  `ten_loai` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `loai_san_pham`
--

INSERT INTO `loai_san_pham` (`id`, `ten_loai`) VALUES
(1, 'iPhone'),
(2, 'iPad'),
(3, 'MacBook'),
(4, 'Apple Watch'),
(5, 'AirPods'),
(6, 'Phụ kiện');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ma_giam_gia`
--

CREATE TABLE `ma_giam_gia` (
  `id` int(11) NOT NULL,
  `ma_code` varchar(50) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `giam_phan_tram` int(11) DEFAULT NULL CHECK (`giam_phan_tram` between 1 and 100),
  `gia_tri_toi_thieu` decimal(12,2) DEFAULT 0.00,
  `so_lan_su_dung` int(11) DEFAULT 1,
  `da_su_dung` int(11) DEFAULT 0,
  `ngay_bat_dau` date DEFAULT NULL,
  `ngay_ket_thuc` date DEFAULT NULL,
  `trang_thai` enum('kich_hoat','het_hieu_luc','tam_khoa') DEFAULT 'kich_hoat'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `ma_giam_gia`
--

INSERT INTO `ma_giam_gia` (`id`, `ma_code`, `mo_ta`, `giam_phan_tram`, `gia_tri_toi_thieu`, `so_lan_su_dung`, `da_su_dung`, `ngay_bat_dau`, `ngay_ket_thuc`, `trang_thai`) VALUES
(1, 'SALE10', 'Giảm 10% cho đơn hàng từ 1 triệu', 1, 1000000.00, 100, 10, '2025-05-01', '2025-12-31', 'kich_hoat'),
(2, 'FREESHIP', 'Giảm 15% cho khách mới', 2, 0.00, 50, 5, '2025-05-01', '2025-07-01', 'kich_hoat'),
(3, 'VIP20', 'Ưu đãi riêng cho khách VIP', 1, 3000000.00, 20, 2, '2025-01-01', '2025-12-31', 'kich_hoat');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhan_vien`
--

CREATE TABLE `nhan_vien` (
  `id` int(11) NOT NULL,
  `quan_tri_vien_id` int(11) DEFAULT NULL,
  `ho_ten` varchar(100) DEFAULT NULL,
  `email_cong_ty` varchar(100) DEFAULT NULL,
  `sdt` varchar(20) DEFAULT NULL,
  `ngay_vao_lam` date DEFAULT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `loai_nhan_vien` enum('ban_hang','ke_toan','kho') DEFAULT 'ban_hang'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhan_vien`
--

INSERT INTO `nhan_vien` (`id`, `quan_tri_vien_id`, `ho_ten`, `email_cong_ty`, `sdt`, `ngay_vao_lam`, `mat_khau`, `loai_nhan_vien`) VALUES
(1, 2, 'Lê Thị Nhân Viên', 'nhanvien01@shop.vn', '0901234567', '2024-01-10', '123456', 'ban_hang');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quan_tri_vien`
--

CREATE TABLE `quan_tri_vien` (
  `id` int(11) NOT NULL,
  `ten_dang_nhap` varchar(50) DEFAULT NULL,
  `mat_khau` varchar(255) DEFAULT NULL,
  `vai_tro_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `quan_tri_vien`
--

INSERT INTO `quan_tri_vien` (`id`, `ten_dang_nhap`, `mat_khau`, `vai_tro_id`) VALUES
(1, 'admin@topzone.vn', 'f865b53623b121fd34ee5426c792e5c33af8c227', 3),
(2, 'nhanvien01@topzone.vn', 'f865b53623b121fd34ee5426c792e5c33af8c227', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `san_pham`
--

CREATE TABLE `san_pham` (
  `id` int(11) NOT NULL,
  `ma_san_pham` varchar(50) DEFAULT NULL,
  `ten_san_pham` varchar(255) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `gia` decimal(12,2) NOT NULL,
  `so_luong` int(11) DEFAULT 0,
  `loai_id` int(11) DEFAULT NULL,
  `dung_luong` varchar(50) DEFAULT NULL,
  `mau_sac` varchar(50) DEFAULT NULL,
  `ma_mau` varchar(50) DEFAULT NULL,
  `phan_tram_giam` int(11) DEFAULT NULL CHECK (`phan_tram_giam` between 0 and 100),
  `tao_boi_admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `san_pham`
--

INSERT INTO `san_pham` (`id`, `ma_san_pham`, `ten_san_pham`, `mo_ta`, `gia`, `so_luong`, `loai_id`, `dung_luong`, `mau_sac`, `ma_mau`, `phan_tram_giam`, `tao_boi_admin_id`) VALUES
(1, 'iphone15promax', 'iPhone 15 Pro Max 128GB', 'Chip A17 Pro, Super Retina XDR OLED...', 33990000.00, 20, 1, '128GB', 'Đen Titan', '#000000', 10, 1),
(2, 'iphone15promax', 'iPhone 15 Pro Max 256GB', 'Chip A17 Pro, Super Retina XDR OLED...', 35990000.00, 15, 1, '256GB', 'Titan tự nhiên', 'iphone15titan', 15, 1),
(3, 'iphone15pro', 'iPhone 15 512GB', 'Chip A17 Pro, Super Retina XDR OLED...', 38990000.00, 10, 1, '512GB', 'Xanh dương', 'iphone15blue', 20, 1),
(4, 'ipadair2022', 'iPad Air 6 M2 11 inch 5G', 'Chip M1, màn hình Liquid Retina 10.9 inch...', 16490000.00, 10, 2, '64GB', 'Trắng', 'ipadairwhite', 5, 2),
(5, 'macbookairm2', 'MacBook Air M2 2022', 'Chip M2, SSD 256GB, màn hình Retina 13.3 inch...', 28990000.00, 5, 3, '256GB', 'Bạc', 'macbookairsilver', 10, 2),
(6, 'airpodspro', 'AirPods Pro 2', 'Chống ồn chủ động, âm thanh không gian.', 6190000.00, 25, 5, 'N/A', 'Trắng', 'airpodsprowhite', 10, 2),
(8, 'iphone13', 'iPhone 13 128GB', 'Trong thế giới công nghệ phát triển không ngừng, iPhone 16 Pro Max khẳng định Apple là biểu tượng đổi mới và tiên phong. Với công nghệ tiên tiến, thiết kế tinh tế và hiệu năng mạnh mẽ, thiết bị này trở thành công cụ hỗ trợ đẳng cấp và phụ kiện thời thượng trong cuộc sống.\r\niPhone 16 series mang đến nhiều nâng cấp quan trọng so với iPhone 15 series, từ hiệu năng, camera, đến các tính năng tiên tiến khác. Được trang bị chip A18 mạnh mẽ hơn, iPhone 16 mang lại hiệu suất vượt trội so với iPhone 15 với chip A16, giúp cải thiện khả năng xử lý đồ họa và tiết kiệm năng lượng tốt hơn​.\r\n\r\niPhone 16 mang đến sự đột phá với camera \"Fusion\" 48 MP, giúp tạo ra những bức ảnh rõ nét, đặc biệt khi thiếu sáng. Tính năng quay video không gian và chụp ảnh macro biến những khoảnh khắc thành ảnh và video 3D sống động. Nổi bật không kém là nút Camera Control, hỗ trợ thao tác nhanh chóng và điều khiển cảm ứng, đồng thời tương thích với nhiều ứng dụng bên thứ ba.\r\n\r\nMàn hình của iPhone 16 series tiếp tục sử dụng công nghệ Dynamic Island từ iPhone 15, cùng với các cải tiến về True Tone, màu sắc rộng P3 và Haptic Touch, mang lại trải nghiệm hình ảnh sống động và mượt mà. Đặc biệt, các phiên bản iPhone 16 Pro và Pro Max hỗ trợ tần số làm mới 120Hz với ProMotion, giúp hiển thị mượt mà hơn​.\r\n\r\nVề thời lượng pin, iPhone 16 Plus và Pro Max cung cấp thời lượng sử dụng lâu hơn, với MagSafe hỗ trợ sạc không dây nhanh hơn ở công suất 25W, so với 15W trên iPhone 15. Tổng quan, iPhone 16 series thực sự mang đến những bước tiến lớn trong việc cải thiện hiệu suất, camera và trải nghiệm người dùng, đáng để nâng cấp từ iPhone 15​.\r\n\r\nTổng quan về iPhone 16 Pro Max và iPhone 16 Pro\r\niPhone 16 Pro và iPhone 16 Pro Max có nhiều điểm chung nhưng cũng tồn tại một số khác biệt quan trọng. Cả hai đều sử dụng khung viền titan với mặt kính nhám và hỗ trợ kháng nước IP68. Về màu sắc, cả hai phiên bản có bốn lựa chọn: Natural Titanium, White Titanium, Black Titanium và Desert Titanium.\r\n\r\nCả hai mẫu đều được trang bị nút Action Button và có nút chức năng Camera Control giúp điều khiển nhanh camera. Màn hình của iPhone 16 Pro Max là Super Retina XDR OLED 6.9 inch, lớn hơn so với màn hình 6.3 inch của iPhone 16 Pro. Hai máy đều có độ sáng tối đa 2000 nits và dùng chip A18 Pro cho hiệu năng mạnh mẽ.\r\n\r\nThời lượng pin của iPhone 16 Pro Max tốt hơn với 33 giờ xem video, trong khi iPhone 16 Pro là 27 giờ. Bộ nhớ của iPhone 16 Pro Max bắt đầu từ 256 GB, trong khi iPhone 16 Pro có thêm tùy chọn 128 GB.', 12000000.00, 10, 1, '128GB', 'Trắng', '#FFFFFF', 1, 1),
(9, 'AppleWatchSE2GPS ', 'Apple Watch SE 2 GPS 40mm viền nhôm dây vải', 'ghggggggggggggggg', 5020000.00, 200, 4, '12GB', 'Đen', '#hhhh', 2, 1),
(10, 'iphone16promax', 'Điện thoại iPhone 16 Pro Max 256GB', 'Trong thế giới công nghệ phát triển không ngừng, iPhone 16 Pro Max khẳng định Apple là biểu tượng đổi mới và tiên phong. Với công nghệ tiên tiến, thiết kế tinh tế và hiệu năng mạnh mẽ, thiết bị này trở thành công cụ hỗ trợ đẳng cấp và phụ kiện thời thượng trong cuộc sống.\r\niPhone 16 series mang đến nhiều nâng cấp quan trọng so với iPhone 15 series, từ hiệu năng, camera, đến các tính năng tiên tiến khác. Được trang bị chip A18 mạnh mẽ hơn, iPhone 16 mang lại hiệu suất vượt trội so với iPhone 15 với chip A16, giúp cải thiện khả năng xử lý đồ họa và tiết kiệm năng lượng tốt hơn​.\r\n\r\niPhone 16 mang đến sự đột phá với camera \"Fusion\" 48 MP, giúp tạo ra những bức ảnh rõ nét, đặc biệt khi thiếu sáng. Tính năng quay video không gian và chụp ảnh macro biến những khoảnh khắc thành ảnh và video 3D sống động. Nổi bật không kém là nút Camera Control, hỗ trợ thao tác nhanh chóng và điều khiển cảm ứng, đồng thời tương thích với nhiều ứng dụng bên thứ ba.\r\n\r\nMàn hình của iPhone 16 series tiếp tục sử dụng công nghệ Dynamic Island từ iPhone 15, cùng với các cải tiến về True Tone, màu sắc rộng P3 và Haptic Touch, mang lại trải nghiệm hình ảnh sống động và mượt mà. Đặc biệt, các phiên bản iPhone 16 Pro và Pro Max hỗ trợ tần số làm mới 120Hz với ProMotion, giúp hiển thị mượt mà hơn​.\r\n\r\nVề thời lượng pin, iPhone 16 Plus và Pro Max cung cấp thời lượng sử dụng lâu hơn, với MagSafe hỗ trợ sạc không dây nhanh hơn ở công suất 25W, so với 15W trên iPhone 15. Tổng quan, iPhone 16 series thực sự mang đến những bước tiến lớn trong việc cải thiện hiệu suất, camera và trải nghiệm người dùng, đáng để nâng cấp từ iPhone 15​.\r\n\r\nTổng quan về iPhone 16 Pro Max và iPhone 16 Pro\r\niPhone 16 Pro và iPhone 16 Pro Max có nhiều điểm chung nhưng cũng tồn tại một số khác biệt quan trọng. Cả hai đều sử dụng khung viền titan với mặt kính nhám và hỗ trợ kháng nước IP68. Về màu sắc, cả hai phiên bản có bốn lựa chọn: Natural Titanium, White Titanium, Black Titanium và Desert Titanium.\r\n\r\nCả hai mẫu đều được trang bị nút Action Button và có nút chức năng Camera Control giúp điều khiển nhanh camera. Màn hình của iPhone 16 Pro Max là Super Retina XDR OLED 6.9 inch, lớn hơn so với màn hình 6.3 inch của iPhone 16 Pro. Hai máy đều có độ sáng tối đa 2000 nits và dùng chip A18 Pro cho hiệu năng mạnh mẽ.\r\n\r\nThời lượng pin của iPhone 16 Pro Max tốt hơn với 33 giờ xem video, trong khi iPhone 16 Pro là 27 giờ. Bộ nhớ của iPhone 16 Pro Max bắt đầu từ 256 GB, trong khi iPhone 16 Pro có thêm tùy chọn 128 GB.', 30590000.00, 10, 1, '256GB', 'Vàng', '#FFFF00', 2, 1),
(11, 'iphone16promax', 'iPhone 16 Pro Max 256GB', 'Iphone 16 pro max', 30490000.00, 10, 1, '256GB', 'Đen', '#000000', 11, 1),
(12, 'iphone16promax', 'iPhone 16 Pro Max 512GB', 'Trong thế giới công nghệ phát triển không ngừng, iPhone 16 Pro Max khẳng định Apple là biểu tượng đổi mới và tiên phong. Với công nghệ tiên tiến, thiết kế tinh tế và hiệu năng mạnh mẽ, thiết bị này trở thành công cụ hỗ trợ đẳng cấp và phụ kiện thời thượng trong cuộc sống.\r\niPhone 16 series mang đến nhiều nâng cấp quan trọng so với iPhone 15 series, từ hiệu năng, camera, đến các tính năng tiên tiến khác. Được trang bị chip A18 mạnh mẽ hơn, iPhone 16 mang lại hiệu suất vượt trội so với iPhone 15 với chip A16, giúp cải thiện khả năng xử lý đồ họa và tiết kiệm năng lượng tốt hơn​.\r\n\r\niPhone 16 mang đến sự đột phá với camera \"Fusion\" 48 MP, giúp tạo ra những bức ảnh rõ nét, đặc biệt khi thiếu sáng. Tính năng quay video không gian và chụp ảnh macro biến những khoảnh khắc thành ảnh và video 3D sống động. Nổi bật không kém là nút Camera Control, hỗ trợ thao tác nhanh chóng và điều khiển cảm ứng, đồng thời tương thích với nhiều ứng dụng bên thứ ba.\r\n\r\nMàn hình của iPhone 16 series tiếp tục sử dụng công nghệ Dynamic Island từ iPhone 15, cùng với các cải tiến về True Tone, màu sắc rộng P3 và Haptic Touch, mang lại trải nghiệm hình ảnh sống động và mượt mà. Đặc biệt, các phiên bản iPhone 16 Pro và Pro Max hỗ trợ tần số làm mới 120Hz với ProMotion, giúp hiển thị mượt mà hơn​.\r\n\r\nVề thời lượng pin, iPhone 16 Plus và Pro Max cung cấp thời lượng sử dụng lâu hơn, với MagSafe hỗ trợ sạc không dây nhanh hơn ở công suất 25W, so với 15W trên iPhone 15. Tổng quan, iPhone 16 series thực sự mang đến những bước tiến lớn trong việc cải thiện hiệu suất, camera và trải nghiệm người dùng, đáng để nâng cấp từ iPhone 15​.\r\n\r\nTổng quan về iPhone 16 Pro Max và iPhone 16 Pro\r\niPhone 16 Pro và iPhone 16 Pro Max có nhiều điểm chung nhưng cũng tồn tại một số khác biệt quan trọng. Cả hai đều sử dụng khung viền titan với mặt kính nhám và hỗ trợ kháng nước IP68. Về màu sắc, cả hai phiên bản có bốn lựa chọn: Natural Titanium, White Titanium, Black Titanium và Desert Titanium.\r\n\r\nCả hai mẫu đều được trang bị nút Action Button và có nút chức năng Camera Control giúp điều khiển nhanh camera. Màn hình của iPhone 16 Pro Max là Super Retina XDR OLED 6.9 inch, lớn hơn so với màn hình 6.3 inch của iPhone 16 Pro. Hai máy đều có độ sáng tối đa 2000 nits và dùng chip A18 Pro cho hiệu năng mạnh mẽ.\r\n\r\nThời lượng pin của iPhone 16 Pro Max tốt hơn với 33 giờ xem video, trong khi iPhone 16 Pro là 27 giờ. Bộ nhớ của iPhone 16 Pro Max bắt đầu từ 256 GB, trong khi iPhone 16 Pro có thêm tùy chọn 128 GB.', 36790000.00, 20, 1, '512GB', 'Titan Sa Mạc', '#EEE8AA', 10, 1),
(13, 'iphone16promax', 'Điện thoại iPhone 16 Pro Max 512GB', 'Trong thế giới công nghệ phát triển không ngừng, iPhone 16 Pro Max khẳng định Apple là biểu tượng đổi mới và tiên phong. Với công nghệ tiên tiến, thiết kế tinh tế và hiệu năng mạnh mẽ, thiết bị này trở thành công cụ hỗ trợ đẳng cấp và phụ kiện thời thượng trong cuộc sống.\r\niPhone 16 series mang đến nhiều nâng cấp quan trọng so với iPhone 15 series, từ hiệu năng, camera, đến các tính năng tiên tiến khác. Được trang bị chip A18 mạnh mẽ hơn, iPhone 16 mang lại hiệu suất vượt trội so với iPhone 15 với chip A16, giúp cải thiện khả năng xử lý đồ họa và tiết kiệm năng lượng tốt hơn​.\r\n\r\niPhone 16 mang đến sự đột phá với camera \"Fusion\" 48 MP, giúp tạo ra những bức ảnh rõ nét, đặc biệt khi thiếu sáng. Tính năng quay video không gian và chụp ảnh macro biến những khoảnh khắc thành ảnh và video 3D sống động. Nổi bật không kém là nút Camera Control, hỗ trợ thao tác nhanh chóng và điều khiển cảm ứng, đồng thời tương thích với nhiều ứng dụng bên thứ ba.\r\n\r\nMàn hình của iPhone 16 series tiếp tục sử dụng công nghệ Dynamic Island từ iPhone 15, cùng với các cải tiến về True Tone, màu sắc rộng P3 và Haptic Touch, mang lại trải nghiệm hình ảnh sống động và mượt mà. Đặc biệt, các phiên bản iPhone 16 Pro và Pro Max hỗ trợ tần số làm mới 120Hz với ProMotion, giúp hiển thị mượt mà hơn​.\r\n\r\nVề thời lượng pin, iPhone 16 Plus và Pro Max cung cấp thời lượng sử dụng lâu hơn, với MagSafe hỗ trợ sạc không dây nhanh hơn ở công suất 25W, so với 15W trên iPhone 15. Tổng quan, iPhone 16 series thực sự mang đến những bước tiến lớn trong việc cải thiện hiệu suất, camera và trải nghiệm người dùng, đáng để nâng cấp từ iPhone 15​.\r\n\r\nTổng quan về iPhone 16 Pro Max và iPhone 16 Pro\r\niPhone 16 Pro và iPhone 16 Pro Max có nhiều điểm chung nhưng cũng tồn tại một số khác biệt quan trọng. Cả hai đều sử dụng khung viền titan với mặt kính nhám và hỗ trợ kháng nước IP68. Về màu sắc, cả hai phiên bản có bốn lựa chọn: Natural Titanium, White Titanium, Black Titanium và Desert Titanium.\r\n\r\nCả hai mẫu đều được trang bị nút Action Button và có nút chức năng Camera Control giúp điều khiển nhanh camera. Màn hình của iPhone 16 Pro Max là Super Retina XDR OLED 6.9 inch, lớn hơn so với màn hình 6.3 inch của iPhone 16 Pro. Hai máy đều có độ sáng tối đa 2000 nits và dùng chip A18 Pro cho hiệu năng mạnh mẽ.\r\n\r\nThời lượng pin của iPhone 16 Pro Max tốt hơn với 33 giờ xem video, trong khi iPhone 16 Pro là 27 giờ. Bộ nhớ của iPhone 16 Pro Max bắt đầu từ 256 GB, trong khi iPhone 16 Pro có thêm tùy chọn 128 GB.', 36990000.00, 33, 1, '512GB', 'Titan trắng', '#FFFFFF', 9, 1),
(14, 'macbookair15', 'MacBook Air 15 inch M4 32GB/1TB', 'Trong thế giới công nghệ phát triển không ngừng, iPhone 16 Pro Max khẳng định Apple là biểu tượng đổi mới và tiên phong. Với công nghệ tiên tiến, thiết kế tinh tế và hiệu năng mạnh mẽ, thiết bị này trở thành công cụ hỗ trợ đẳng cấp và phụ kiện thời thượng trong cuộc sống.\r\niPhone 16 series mang đến nhiều nâng cấp quan trọng so với iPhone 15 series, từ hiệu năng, camera, đến các tính năng tiên tiến khác. Được trang bị chip A18 mạnh mẽ hơn, iPhone 16 mang lại hiệu suất vượt trội so với iPhone 15 với chip A16, giúp cải thiện khả năng xử lý đồ họa và tiết kiệm năng lượng tốt hơn​.\r\n\r\niPhone 16 mang đến sự đột phá với camera \"Fusion\" 48 MP, giúp tạo ra những bức ảnh rõ nét, đặc biệt khi thiếu sáng. Tính năng quay video không gian và chụp ảnh macro biến những khoảnh khắc thành ảnh và video 3D sống động. Nổi bật không kém là nút Camera Control, hỗ trợ thao tác nhanh chóng và điều khiển cảm ứng, đồng thời tương thích với nhiều ứng dụng bên thứ ba.\r\n\r\nMàn hình của iPhone 16 series tiếp tục sử dụng công nghệ Dynamic Island từ iPhone 15, cùng với các cải tiến về True Tone, màu sắc rộng P3 và Haptic Touch, mang lại trải nghiệm hình ảnh sống động và mượt mà. Đặc biệt, các phiên bản iPhone 16 Pro và Pro Max hỗ trợ tần số làm mới 120Hz với ProMotion, giúp hiển thị mượt mà hơn​.\r\n\r\nVề thời lượng pin, iPhone 16 Plus và Pro Max cung cấp thời lượng sử dụng lâu hơn, với MagSafe hỗ trợ sạc không dây nhanh hơn ở công suất 25W, so với 15W trên iPhone 15. Tổng quan, iPhone 16 series thực sự mang đến những bước tiến lớn trong việc cải thiện hiệu suất, camera và trải nghiệm người dùng, đáng để nâng cấp từ iPhone 15​.\r\n\r\nTổng quan về iPhone 16 Pro Max và iPhone 16 Pro\r\niPhone 16 Pro và iPhone 16 Pro Max có nhiều điểm chung nhưng cũng tồn tại một số khác biệt quan trọng. Cả hai đều sử dụng khung viền titan với mặt kính nhám và hỗ trợ kháng nước IP68. Về màu sắc, cả hai phiên bản có bốn lựa chọn: Natural Titanium, White Titanium, Black Titanium và Desert Titanium.\r\n\r\nCả hai mẫu đều được trang bị nút Action Button và có nút chức năng Camera Control giúp điều khiển nhanh camera. Màn hình của iPhone 16 Pro Max là Super Retina XDR OLED 6.9 inch, lớn hơn so với màn hình 6.3 inch của iPhone 16 Pro. Hai máy đều có độ sáng tối đa 2000 nits và dùng chip A18 Pro cho hiệu năng mạnh mẽ.\r\n\r\nThời lượng pin của iPhone 16 Pro Max tốt hơn với 33 giờ xem video, trong khi iPhone 16 Pro là 27 giờ. Bộ nhớ của iPhone 16 Pro Max bắt đầu từ 256 GB, trong khi iPhone 16 Pro có thêm tùy chọn 128 GB.', 51890000.00, 123, 3, '1TB', 'Xanh da trời', '#4876FF', 1, 1),
(15, 'macbookpro16', 'MacBook Pro 16 inch Nano M4 Max 36GB/1TB', 'Macbook', 92790000.00, 30, 3, '1TB', 'Đen', '#000000', 1, 1),
(16, 'imac24', 'iMac 24 inch M4 24GB - 256GB', 'Macbook', 39490000.00, 60, 3, '256GB', 'Tím', '#6A5ACD', 1, 1),
(17, 'ipada16', 'iPad A16 WiFi', 'Ipad A16 ', 16690000.00, 23, 2, '512GB', 'Hồng', '#FF6A6A', 1, 1),
(18, 'ipadprom411', 'iPad Pro M4 11 inch 5G', 'Ipad', 56990000.00, 45, 2, '2TB', 'Đen', '#000000', 4, 1),
(19, 'ipadmini7', 'iPad mini 7 5G', 'Ipad', 15790000.00, 2, 2, '128GB', 'Trắng Starlight', '#F5FFFA', 2, 1),
(20, 'airpodspro', 'AirPods Pro 2', 'Chống ồn chủ động, âm thanh không gian.', 6190000.00, 25, 5, 'N/A', 'Trắng', '#FFFFFF', 10, 2),
(21, 'iphone13', 'iphone13 pro max', 'sdffffffffffffffffffffffffff', 12000000.00, 10, 1, '128GB', 'Đen', '#hhhh', 1, 1),
(22, 'AppleWatchSE2GPS ', 'Apple Watch SE 2 GPS 40mm viền nhôm dây vải', 'ok', 5020000.00, 200, 4, '12GB', 'Đen', '#FFFFFF', 2, 1),
(23, 'iphone16promax', 'Điện thoại iPhone 16 Pro Max 256GB', 'Trong thế giới công nghệ phát triển không ngừng, iPhone 16 Pro Max khẳng định Apple là biểu tượng đổi mới và tiên phong. Với công nghệ tiên tiến, thiết kế tinh tế và hiệu năng mạnh mẽ, thiết bị này trở thành công cụ hỗ trợ đẳng cấp và phụ kiện thời thượng trong cuộc sống.\r\niPhone 16 series mang đến nhiều nâng cấp quan trọng so với iPhone 15 series, từ hiệu năng, camera, đến các tính năng tiên tiến khác. Được trang bị chip A18 mạnh mẽ hơn, iPhone 16 mang lại hiệu suất vượt trội so với iPhone 15 với chip A16, giúp cải thiện khả năng xử lý đồ họa và tiết kiệm năng lượng tốt hơn​.\r\n\r\niPhone 16 mang đến sự đột phá với camera \"Fusion\" 48 MP, giúp tạo ra những bức ảnh rõ nét, đặc biệt khi thiếu sáng. Tính năng quay video không gian và chụp ảnh macro biến những khoảnh khắc thành ảnh và video 3D sống động. Nổi bật không kém là nút Camera Control, hỗ trợ thao tác nhanh chóng và điều khiển cảm ứng, đồng thời tương thích với nhiều ứng dụng bên thứ ba.\r\n\r\nMàn hình của iPhone 16 series tiếp tục sử dụng công nghệ Dynamic Island từ iPhone 15, cùng với các cải tiến về True Tone, màu sắc rộng P3 và Haptic Touch, mang lại trải nghiệm hình ảnh sống động và mượt mà. Đặc biệt, các phiên bản iPhone 16 Pro và Pro Max hỗ trợ tần số làm mới 120Hz với ProMotion, giúp hiển thị mượt mà hơn​.\r\n\r\nVề thời lượng pin, iPhone 16 Plus và Pro Max cung cấp thời lượng sử dụng lâu hơn, với MagSafe hỗ trợ sạc không dây nhanh hơn ở công suất 25W, so với 15W trên iPhone 15. Tổng quan, iPhone 16 series thực sự mang đến những bước tiến lớn trong việc cải thiện hiệu suất, camera và trải nghiệm người dùng, đáng để nâng cấp từ iPhone 15​.\r\n\r\nTổng quan về iPhone 16 Pro Max và iPhone 16 Pro\r\niPhone 16 Pro và iPhone 16 Pro Max có nhiều điểm chung nhưng cũng tồn tại một số khác biệt quan trọng. Cả hai đều sử dụng khung viền titan với mặt kính nhám và hỗ trợ kháng nước IP68. Về màu sắc, cả hai phiên bản có bốn lựa chọn: Natural Titanium, White Titanium, Black Titanium và Desert Titanium.\r\n\r\nCả hai mẫu đều được trang bị nút Action Button và có nút chức năng Camera Control giúp điều khiển nhanh camera. Màn hình của iPhone 16 Pro Max là Super Retina XDR OLED 6.9 inch, lớn hơn so với màn hình 6.3 inch của iPhone 16 Pro. Hai máy đều có độ sáng tối đa 2000 nits và dùng chip A18 Pro cho hiệu năng mạnh mẽ.\r\n\r\nThời lượng pin của iPhone 16 Pro Max tốt hơn với 33 giờ xem video, trong khi iPhone 16 Pro là 27 giờ. Bộ nhớ của iPhone 16 Pro Max bắt đầu từ 256 GB, trong khi iPhone 16 Pro có thêm tùy chọn 128 GB.', 30590000.00, 10, 1, '256GB', 'Đen', '#000000', 2, 1),
(24, 'iphone12', 'iPhone 12 64GB', 'Hiệu năng vượt xa mọi giới hạn\r\nApple đã trang bị con chip mới nhất của hãng (tính đến 11/2020) cho iPhone 12 đó là A14 Bionic, được sản xuất trên tiến trình 5 nm với hiệu suất ổn định hơn so với chip A13 được trang bị trên phiên bản tiền nhiệm iPhone 11.', 9990000.00, 20, 1, '64GB', 'Tím', '#FF00FF', 16, 1),
(25, 'iphone12', 'iPhone 12 128GB', 'ip12 128G', 10999000.00, 20, 1, '128GB', 'Đen', '#000000', 16, 1),
(26, 'applewatchse2', 'Apple Watch SE 2 GPS 40mm viền nhôm dây vải', 'Đặc điểm nổi bật của Apple Watch SE 2 GPS 40mm viền nhôm dây thể thao:\r\nKhung viền nhôm sang trọng, bền bỉ\r\nChất liệu dây silicon, độ đàn hồi cao\r\nChống nước ở độ sâu 50 mét\r\nTheo dõi giấc ngủ, sức khỏe tim mạch\r\nHỗ trợ tập luyện, theo dõi hoạt động hàng ngày\r\nTự động phát hiện té ngã\r\nLoa tích hợp mới\r\nThời lượng sử dụng lâu dài', 5020000.00, 100, 4, '40mm', 'Bạc', '#C0C0C0	', 16, 1),
(27, 'applewatchse2', 'Apple Watch SE 2 GPS 40mm viền nhôm dây vải', 'Đặc điểm nổi bật của Apple Watch SE 2 GPS 40mm viền nhôm dây thể thao:\r\nKhung viền nhôm sang trọng, bền bỉ\r\nChất liệu dây silicon, độ đàn hồi cao\r\nChống nước ở độ sâu 50 mét\r\nTheo dõi giấc ngủ, sức khỏe tim mạch\r\nHỗ trợ tập luyện, theo dõi hoạt động hàng ngày\r\nTự động phát hiện té ngã\r\nLoa tích hợp mới\r\nThời lượng sử dụng lâu dài', 5220000.00, 50, 4, '40mm', 'Trắng', '#F8F9EC', 16, 1),
(28, 'applewatchse2', 'Apple Watch SE 2 GPS 40mm viền nhôm dây vải', 'Đặc điểm nổi bật của Apple Watch SE 2 GPS 40mm viền nhôm dây thể thao:\r\nKhung viền nhôm sang trọng, bền bỉ\r\nChất liệu dây silicon, độ đàn hồi cao\r\nChống nước ở độ sâu 50 mét\r\nTheo dõi giấc ngủ, sức khỏe tim mạch\r\nHỗ trợ tập luyện, theo dõi hoạt động hàng ngày\r\nTự động phát hiện té ngã\r\nLoa tích hợp mới\r\nThời lượng sử dụng lâu dài', 5222000.00, 40, 4, '40mm', 'Xanh', '#020216', 16, 1),
(29, 'applewatchseries10', 'Apple Watch Series 10 42mm viền nhôm dây thể thao', 'Màn hình Retina LTPO3 Luôn Bật\r\nOLED góc rộng\r\nSáng hơn lên đến 40% khi nhìn từ góc nghiêng\r\nĐộ sáng tối đa lên đến 2000 nit', 8480000.00, 40, 4, '42mm', 'Đen', '#000000', 22, 1),
(30, 'applewatchseries10', 'Apple Watch SE 2 GPS 40mm viền nhôm dây vải', 'Màn hình Retina LTPO3 Luôn Bật\r\nOLED góc rộng\r\nSáng hơn lên đến 40% khi nhìn từ góc nghiêng\r\nĐộ sáng tối đa lên đến 2000 nit', 8480000.00, 20, 4, '42mm', 'Bạc', '#C0C0C0', 22, 1),
(31, 'applewatchseries10', 'Apple Watch Series 10 42mm viền nhôm dây thể thao', 'Màn hình Retina LTPO3 Luôn Bật\r\nOLED góc rộng\r\nSáng hơn lên đến 40% khi nhìn từ góc nghiêng\r\nĐộ sáng tối đa lên đến 2000 nit', 9280000.00, 20, 4, '46mm', 'Đen', '#000000', 21, 1),
(32, 'applewatchseries10', 'Apple Watch Series 10 42mm viền nhôm dây thể thao', 'Màn hình Retina LTPO3 Luôn Bật\r\nOLED góc rộng\r\nSáng hơn lên đến 40% khi nhìn từ góc nghiêng\r\nĐộ sáng tối đa lên đến 2000 nit', 9080000.00, 20, 4, '46mm', 'Bạc', '#C0C0C0', 21, 1),
(33, 'applewatchseries10GPS', 'Apple Watch Series 10 GPS + Cellular 42mm viền nhôm dây vải', '	\r\nMàn hình Retina LTPO3 Luôn Bật\r\nOLED góc rộng\r\nSáng hơn lên đến 40% khi nhìn từ góc nghiêng\r\nĐộ sáng tối đa lên đến 2000 nit', 13090000.00, 20, 4, '42mm', 'Đen', '#000000', 10, 1),
(34, 'applewatchseries10GPS', 'Apple Watch Series 10 GPS + Cellular 42mm viền nhôm dây vải', '	\r\nMàn hình Retina LTPO3 Luôn Bật\r\nOLED góc rộng\r\nSáng hơn lên đến 40% khi nhìn từ góc nghiêng\r\nĐộ sáng tối đa lên đến 2000 nit', 13090000.00, 20, 4, '42mm', 'Bạc', '#C0C0C0', 10, 1),
(35, 'applewatchseries10GPS', 'Apple Watch Series 10 GPS + Cellular 42mm viền nhôm dây vải', '	\r\nMàn hình Retina LTPO3 Luôn Bật\r\nOLED góc rộng\r\nSáng hơn lên đến 40% khi nhìn từ góc nghiêng\r\nĐộ sáng tối đa lên đến 2000 nit', 13999000.00, 20, 4, '46mm', 'Đen', '#000000', 20, 1),
(36, 'applewatchseries10GPS', 'Apple Watch Series 10 GPS + Cellular 42mm viền nhôm dây vải', '	\r\nMàn hình Retina LTPO3 Luôn Bật\r\nOLED góc rộng\r\nSáng hơn lên đến 40% khi nhìn từ góc nghiêng\r\nĐộ sáng tối đa lên đến 2000 nit', 13990000.00, 20, 4, '46mm', 'Bạc', '#C0C0C0', 10, 1),
(37, 'earpods', 'EarPods jack cắm USB-C', 'Tổng Quan\r\n• Không giống như tai nghe nhét tai tròn truyền thống, EarPods được thiết kế theo hình dạng của tai. Nhờ đó tai nghe này giúp nhiều người thấy dễ chịu hơn các loại tai nghe nhét tai khác.\r\n\r\n• Loa bên trong EarPods được thiết kế để tối đa hóa đầu ra âm thanh, mang đến cho bạn âm thanh chất lượng cao.\r\n\r\n• EarPods (USB-C) cũng có điều khiển cài sẵn cho phép bạn điều chỉnh âm lượng, điều khiển việc phát nhạc và video, cũng như trả lời hoặc kết thúc cuộc gọi bằng thao tác nhấn vào điều khiển.\r\n\r\nĐiểm nổi bật\r\n• Do chính Apple thiết kế.\r\n\r\n• Âm trầm hơn, phong phú hơn.\r\n\r\n• Bảo vệ chống thấm nước và mồ hôi tuyệt vời.\r\n\r\n• Điều khiển phát nhạc và video.\r\n\r\n• Trả lời và kết thúc cuộc gọi.', 550000.00, 20, 5, 'có dây', 'Trắng', '#FFFFFF', 0, 1),
(38, 'airPods3 ', 'AirPods 3 sạc Lightning', 'Nội dung tính năng\r\nGiới thiệu AirPods hoàn toàn mới. Sở hữu tính năng âm thanh không gian đưa âm nhạc đến quanh bạn,1 EQ thích ứng điều chỉnh nhạc hướng vào tai bạn và thời lượng pin lâu hơn.2 Tai nghe có khả năng chống mồ hôi và chống nước, mang đến cho bạn trải nghiệm tuyệt vời.3\r\n\r\nTính năng nổi bật\r\n• Chế độ âm thanh không gian với tính năng theo dõi chuyển động của đầu đưa âm thanh đến quanh bạn1.\r\n\r\n• EQ thích ứng sẽ tự động điều chỉnh nhạc hướng vào tai bạn.\r\n\r\n• Thiết kế có đường viền hoàn toàn mới.\r\n\r\n• Cảm biến lực giúp bạn dễ dàng điều khiển chương trình giải trí, trả lời hoặc kết thúc cuộc gọi, và thực hiện nhiều tác vụ khác.\r\n\r\n• Chống mồ hôi và chống nước3.\r\n\r\n• Thời gian nghe lên đến 6 giờ với một lần sạc2.\r\n\r\n• Tổng thời gian nghe lên đến 30 giờ với Hộp Sạc2.\r\n\r\n• Thiết lập dễ dàng, có khả năng nhận biết khi đeo, và tự động chuyển đổi để mang lại trải nghiệm tuyệt vời4.\r\n\r\n• Dễ dàng chia sẻ âm thanh giữa hai bộ AirPods trên iPhone, iPad, iPod touch hoặc Apple TV.\r\n\r\nPháp lý\r\n1Chế độ âm thanh không gian phù hợp để xem phim, TV và video trên các ứng dụng được hỗ trợ. Cần có iPhone hoặc iPad.\r\n\r\n2Thời lượng pin khác nhau tùy theo cách sử dụng và cấu hình. Truy cập apple.com/batteries để biết thêm thông tin.\r\n\r\n3AirPods (thế hệ thứ 3) có khả năng chống mồ hôi và chống nước, có thể sử dụng trong các môn thể thao và luyện tập không liên quan đến nước. AirPods (thế hệ thứ 3) đã qua kiểm nghiệm trong điều kiện phòng thí nghiệm có kiểm soát và đạt mức IPX4 theo tiêu chuẩn IEC 60529. Khả năng chống mồ hôi và chống nước không phải là các điều kiện vĩnh viễn, và khả năng này có thể giảm do hao mòn thông thường. Không sạc pin khi AirPods (thế hệ thứ 3) đang bị ướt. Vui lòng tham khảo https://support.apple.com/kb/HT210711 để biết cách lau sạch và làm khô sản phẩm.\r\n\r\n4Cần có tài khoản iCloud và macOS 15.1, iOS 15.1, iPadOS, watchOS 8.1, hoặc tvOS 15.1 trở lên.', 3490000.00, 20, 5, 'không dây', 'Trắng', '#FFFFFF', 22, 1),
(39, ' MarshallEmberton', 'Loa Bluetooth Marshall Emberton III', 'MFI\r\nChế độ Stack Mode\r\nSạc nhanh\r\nChống nước, chống bụi IP67\r\nCó micro đàm thoại\r\nKết nối không dây nhiều loa cùng lúc', 4850000.00, 20, 5, 'loa', 'Đen', '#C0C0C0', 10, 1),
(40, 'marshallEnberton', 'Loa Bluetooth Marshall Emberton II', 'MFI\r\nChế độ Stack Mode\r\nSạc nhanh\r\nChống nước, chống bụi IP67\r\nCó micro đàm thoại\r\nKết nối không dây nhiều loa cùng lúc', 4850000.00, 20, 5, 'loa', 'Trắng', '#FFFFFF', 10, 1),
(41, 'LoaBluetoothSony', 'Loa Bluetooth Sony SRS-ULT10', 'Có tay xách\r\nKết nối nhiều loa\r\nSạc nhanh\r\nChống nước, chống bụi IP67\r\nCó micro đàm thoại', 2390000.00, 10, 5, 'loa', 'Đen', '#FFFFFF', 20, 1),
(42, 'LoaBluetoothSony', 'Loa Bluetooth Sony SRS-ULT10', 'Có tay xách\r\nKết nối nhiều loa\r\nSạc nhanh\r\nChống nước, chống bụi IP67\r\nCó micro đàm thoại', 2390000.00, 20, 5, 'loa', 'Vàng', '#FFFF00', 20, 1),
(43, 'adaptersacapple', 'Adapter sạc Apple USB-C 20W', 'Bộ Sạc Apple USB-C 20W giúp sạc nhanh và hiệu quả tại nhà, trong văn phòng hoặc khi đang di chuyển. Mặc dù bộ sạc này tương thích với mọi thiết bị có cổng sạc USB‑C, Apple khuyên bạn nên sử dụng phụ kiện này với iPad Pro và iPad Air để đạt hiệu quả sạc tối ưu. Bạn cũng có thể sử dụng với iPhone 8 hoặc các phiên bản cao hơn để tận dụng tính năng sạc nhanh. \r\n\r\nKhông bán kèm cáp sạc.', 550000.00, 100, 6, 'sạc', 'Trắng', '#FFFFFF', 0, 1),
(44, 'applewatchultra2gps', 'Apple Watch Ultra 2 GPS + Cellular 49mm viền Titanium đen dây Alpine', 'Chế độ luyện tập, Theo dõi giấc ngủ, Đo nhịp tim, Đo lượng oxy trong máu, Đếm bước chân, Tính calo tiêu thụ, Tính quãng đường chạy, Đo mức độ stress, Cảm biến nhiệt độ, Phát hiện té ngã, Cảnh báo nhịp tim bất thường, Đo điện tâm đồ, Đo VO2 max (Đo lượng tiêu thụ oxy tối đa), Theo dõi chu kỳ', 22290000.00, 20, 4, 'Dây Alpine', 'Đen', '#000000', 0, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vai_tro`
--

CREATE TABLE `vai_tro` (
  `id` int(11) NOT NULL,
  `ten_vai_tro` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `vai_tro`
--

INSERT INTO `vai_tro` (`id`, `ten_vai_tro`) VALUES
(3, 'admin'),
(1, 'khach_hang'),
(2, 'nhan_vien');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bai_viet`
--
ALTER TABLE `bai_viet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tac_gia_admin_id` (`tac_gia_admin_id`);

--
-- Chỉ mục cho bảng `bai_viet_chi_tiet`
--
ALTER TABLE `bai_viet_chi_tiet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bai_viet_id` (`bai_viet_id`);

--
-- Chỉ mục cho bảng `bao_hanh`
--
ALTER TABLE `bao_hanh`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chi_tiet_don_hang_id` (`chi_tiet_don_hang_id`);

--
-- Chỉ mục cho bảng `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `don_hang_id` (`don_hang_id`),
  ADD KEY `san_pham_id` (`san_pham_id`);

--
-- Chỉ mục cho bảng `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `khach_hang_id` (`khach_hang_id`),
  ADD KEY `san_pham_id` (`san_pham_id`);

--
-- Chỉ mục cho bảng `dia_chi_giao_hang`
--
ALTER TABLE `dia_chi_giao_hang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `khach_hang_id` (`khach_hang_id`);

--
-- Chỉ mục cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `khach_hang_id` (`khach_hang_id`),
  ADD KEY `ma_giam_gia_id` (`ma_giam_gia_id`);

--
-- Chỉ mục cho bảng `gio_hang`
--
ALTER TABLE `gio_hang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `khach_hang_id` (`khach_hang_id`),
  ADD KEY `san_pham_id` (`san_pham_id`);

--
-- Chỉ mục cho bảng `hinh_anh_san_pham`
--
ALTER TABLE `hinh_anh_san_pham`
  ADD PRIMARY KEY (`id`),
  ADD KEY `san_pham_id` (`san_pham_id`);

--
-- Chỉ mục cho bảng `khach_hang`
--
ALTER TABLE `khach_hang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `vai_tro_id` (`vai_tro_id`);

--
-- Chỉ mục cho bảng `loai_san_pham`
--
ALTER TABLE `loai_san_pham`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ma_giam_gia`
--
ALTER TABLE `ma_giam_gia`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_code` (`ma_code`);

--
-- Chỉ mục cho bảng `nhan_vien`
--
ALTER TABLE `nhan_vien`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `quan_tri_vien_id` (`quan_tri_vien_id`);

--
-- Chỉ mục cho bảng `quan_tri_vien`
--
ALTER TABLE `quan_tri_vien`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ten_dang_nhap` (`ten_dang_nhap`),
  ADD KEY `vai_tro_id` (`vai_tro_id`);

--
-- Chỉ mục cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loai_id` (`loai_id`),
  ADD KEY `tao_boi_admin_id` (`tao_boi_admin_id`);

--
-- Chỉ mục cho bảng `vai_tro`
--
ALTER TABLE `vai_tro`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ten_vai_tro` (`ten_vai_tro`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bai_viet`
--
ALTER TABLE `bai_viet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `bai_viet_chi_tiet`
--
ALTER TABLE `bai_viet_chi_tiet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `bao_hanh`
--
ALTER TABLE `bao_hanh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `danh_gia`
--
ALTER TABLE `danh_gia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `dia_chi_giao_hang`
--
ALTER TABLE `dia_chi_giao_hang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `gio_hang`
--
ALTER TABLE `gio_hang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT cho bảng `hinh_anh_san_pham`
--
ALTER TABLE `hinh_anh_san_pham`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT cho bảng `khach_hang`
--
ALTER TABLE `khach_hang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `loai_san_pham`
--
ALTER TABLE `loai_san_pham`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `ma_giam_gia`
--
ALTER TABLE `ma_giam_gia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `nhan_vien`
--
ALTER TABLE `nhan_vien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `quan_tri_vien`
--
ALTER TABLE `quan_tri_vien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT cho bảng `vai_tro`
--
ALTER TABLE `vai_tro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bai_viet`
--
ALTER TABLE `bai_viet`
  ADD CONSTRAINT `bai_viet_ibfk_1` FOREIGN KEY (`tac_gia_admin_id`) REFERENCES `quan_tri_vien` (`id`);

--
-- Các ràng buộc cho bảng `bai_viet_chi_tiet`
--
ALTER TABLE `bai_viet_chi_tiet`
  ADD CONSTRAINT `bai_viet_chi_tiet_ibfk_1` FOREIGN KEY (`bai_viet_id`) REFERENCES `bai_viet` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `bao_hanh`
--
ALTER TABLE `bao_hanh`
  ADD CONSTRAINT `bao_hanh_ibfk_1` FOREIGN KEY (`chi_tiet_don_hang_id`) REFERENCES `chi_tiet_don_hang` (`id`);

--
-- Các ràng buộc cho bảng `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  ADD CONSTRAINT `chi_tiet_don_hang_ibfk_1` FOREIGN KEY (`don_hang_id`) REFERENCES `don_hang` (`id`),
  ADD CONSTRAINT `chi_tiet_don_hang_ibfk_2` FOREIGN KEY (`san_pham_id`) REFERENCES `san_pham` (`id`);

--
-- Các ràng buộc cho bảng `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD CONSTRAINT `danh_gia_ibfk_1` FOREIGN KEY (`khach_hang_id`) REFERENCES `khach_hang` (`id`),
  ADD CONSTRAINT `danh_gia_ibfk_2` FOREIGN KEY (`san_pham_id`) REFERENCES `san_pham` (`id`);

--
-- Các ràng buộc cho bảng `dia_chi_giao_hang`
--
ALTER TABLE `dia_chi_giao_hang`
  ADD CONSTRAINT `dia_chi_giao_hang_ibfk_1` FOREIGN KEY (`khach_hang_id`) REFERENCES `khach_hang` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  ADD CONSTRAINT `don_hang_ibfk_1` FOREIGN KEY (`khach_hang_id`) REFERENCES `khach_hang` (`id`),
  ADD CONSTRAINT `don_hang_ibfk_2` FOREIGN KEY (`ma_giam_gia_id`) REFERENCES `ma_giam_gia` (`id`);

--
-- Các ràng buộc cho bảng `gio_hang`
--
ALTER TABLE `gio_hang`
  ADD CONSTRAINT `gio_hang_ibfk_1` FOREIGN KEY (`khach_hang_id`) REFERENCES `khach_hang` (`id`),
  ADD CONSTRAINT `gio_hang_ibfk_2` FOREIGN KEY (`san_pham_id`) REFERENCES `san_pham` (`id`);

--
-- Các ràng buộc cho bảng `hinh_anh_san_pham`
--
ALTER TABLE `hinh_anh_san_pham`
  ADD CONSTRAINT `hinh_anh_san_pham_ibfk_1` FOREIGN KEY (`san_pham_id`) REFERENCES `san_pham` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `khach_hang`
--
ALTER TABLE `khach_hang`
  ADD CONSTRAINT `khach_hang_ibfk_1` FOREIGN KEY (`vai_tro_id`) REFERENCES `vai_tro` (`id`);

--
-- Các ràng buộc cho bảng `nhan_vien`
--
ALTER TABLE `nhan_vien`
  ADD CONSTRAINT `nhan_vien_ibfk_1` FOREIGN KEY (`quan_tri_vien_id`) REFERENCES `quan_tri_vien` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `quan_tri_vien`
--
ALTER TABLE `quan_tri_vien`
  ADD CONSTRAINT `quan_tri_vien_ibfk_1` FOREIGN KEY (`vai_tro_id`) REFERENCES `vai_tro` (`id`);

--
-- Các ràng buộc cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  ADD CONSTRAINT `san_pham_ibfk_1` FOREIGN KEY (`loai_id`) REFERENCES `loai_san_pham` (`id`),
  ADD CONSTRAINT `san_pham_ibfk_2` FOREIGN KEY (`tao_boi_admin_id`) REFERENCES `quan_tri_vien` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
