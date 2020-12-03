-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 25, 2020 lúc 05:20 AM
-- Phiên bản máy phục vụ: 10.4.14-MariaDB
-- Phiên bản PHP: 7.2.33

CREATE DATABASE classroom;
USE classroom;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `classroom`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `IdAccount` int(10) NOT NULL,
  `HoTen` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `UserName` char(100) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `Email` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `Pass` char(100) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `Sdt` char(12) COLLATE utf8_unicode_ci NOT NULL,
  `NamSinh` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `Quyen` char(12) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`IdAccount`, `HoTen`, `UserName`, `Email`, `Pass`, `Sdt`, `NamSinh`, `Quyen`) VALUES
(7, 'Nguyễn Thị Huyền Trang', 'trangnguyen', 'trangnguyen9b2013@gmail.com', '$2y$10$h1J0CJUzoIyPcxLW/LRLo.YM549Hrclybps.NwRaKeiC15mmYftcK', '0167 754 255', '2000', 'Teacher'),
(8, 'Huyền Trang', 'huyentrang', 'nguyentrang9b2013@gmail.com', '$2y$10$knDPrDAm.kZ6dYNDjUNurOA5ZMpQB5fMVsCqwKJDEB5EAJLqZ0e9q', '0377542554', '2000', 'Teacher'),
(9, 'hoàng thanh tùng', 'admin', '51800825@student.tdtu.edu.vn', '$2y$10$X8kvB69uAhVqveiasWkiDey6MM3whR1uiVek.Px.w655J8FpEM0m6', '0377542554', '2000', 'Admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `assignment`
--

CREATE TABLE `assignment` (
  `IdBaiTap` int(10) NOT NULL,
  `IdLop` int(10) NOT NULL,
  `TieuDe` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `NoiDung` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `Deadline` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `class`
--

CREATE TABLE `class` (
  `IdLop` int(10) NOT NULL,
  `IdAccount` int(10) NOT NULL,
  `TenLop` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `TenGv` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Phong` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `MoTa` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `AnhDaiDien` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `MaLop` char(8) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `class`
--

INSERT INTO `class` (`IdLop`, `IdAccount`, `TenLop`, `TenGv`, `Phong`, `MoTa`, `AnhDaiDien`, `MaLop`) VALUES
(54, 7, 'Lập trình di Android', 'Nguyễn Thị Huyền Trang', 'A601', 'Thứ 5 ca 1', 'images/đồi chè.jpg', 'uhpL9166'),
(55, 7, 'Toán tổ hợp', 'Nguyễn Thị Huyền Trang', 'C201', 'Thứ 5 ca 1', 'images/ky.jpg', 'nkMo6324'),
(56, 7, 'Phương pháp tính', 'Nguyễn Thị Huyền Trang', 'B505', 'Thứ 2 ca 1', 'images/nắng cf.jpg', 'yTzk8277');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment`
--

CREATE TABLE `comment` (
  `IdComment` int(10) NOT NULL,
  `IdAccount` int(10) NOT NULL,
  `IdPost` int(10) NOT NULL,
  `NoiDung` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `File` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `NgayTao` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `detailclass`
--

CREATE TABLE `detailclass` (
  `IdAccount` int(10) NOT NULL,
  `IdLop` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `detailclass`
--

INSERT INTO `detailclass` (`IdAccount`, `IdLop`) VALUES
(7, 54),
(7, 55),
(7, 56);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post`
--

CREATE TABLE `post` (
  `IdPost` int(10) NOT NULL,
  `IdAccount` int(10) NOT NULL,
  `IdLop` int(10) NOT NULL,
  `NoiDung` varchar(1024) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `File` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `NgayTao` char(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `post`
--

INSERT INTO `post` (`IdPost`, `IdAccount`, `IdLop`, `NoiDung`, `File`, `NgayTao`) VALUES
(3, 7, 54, 'Asc', 'uploads/template.docx', '0000-00-00'),
(4, 7, 54, 'ssad', 'uploads/51800825_51800803_51800775_BaoCao.docx', '24/11/2020'),
(5, 7, 54, 'sdsdf', 'uploads/template.docx', '24/11/2020'),
(6, 7, 54, 'dsaS', 'uploads/51800825_51800803_51800775_BaoCao.docx', '24/11/2020'),
(7, 7, 54, 'adfds', 'uploads/template.docx', '24/11/2020'),
(8, 7, 54, 'xgbh', 'uploads/51800825_NguyenThiHuyenTrang-51800775_TranThuHong-51800803_NguyenVanPhuoc .pptx', '24/11/2020');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`IdAccount`);

--
-- Chỉ mục cho bảng `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`IdBaiTap`),
  ADD KEY `IdLop` (`IdLop`);

--
-- Chỉ mục cho bảng `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`IdLop`);

--
-- Chỉ mục cho bảng `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`IdComment`),
  ADD KEY `IdAccount` (`IdAccount`),
  ADD KEY `IdPost` (`IdPost`);

--
-- Chỉ mục cho bảng `detailclass`
--
ALTER TABLE `detailclass`
  ADD PRIMARY KEY (`IdAccount`,`IdLop`),
  ADD KEY `IdLop` (`IdLop`);

--
-- Chỉ mục cho bảng `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`IdPost`),
  ADD KEY `IdAccount` (`IdAccount`),
  ADD KEY `IdLop` (`IdLop`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `account`
--
ALTER TABLE `account`
  MODIFY `IdAccount` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `assignment`
--
ALTER TABLE `assignment`
  MODIFY `IdBaiTap` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `class`
--
ALTER TABLE `class`
  MODIFY `IdLop` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT cho bảng `comment`
--
ALTER TABLE `comment`
  MODIFY `IdComment` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `post`
--
ALTER TABLE `post`
  MODIFY `IdPost` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `assignment`
--
ALTER TABLE `assignment`
  ADD CONSTRAINT `assignment_ibfk_1` FOREIGN KEY (`IdLop`) REFERENCES `class` (`IdLop`);

--
-- Các ràng buộc cho bảng `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`IdAccount`) REFERENCES `account` (`IdAccount`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`IdPost`) REFERENCES `post` (`IdPost`);

--
-- Các ràng buộc cho bảng `detailclass`
--
ALTER TABLE `detailclass`
  ADD CONSTRAINT `detailclass_ibfk_1` FOREIGN KEY (`IdAccount`) REFERENCES `account` (`IdAccount`),
  ADD CONSTRAINT `detailclass_ibfk_2` FOREIGN KEY (`IdLop`) REFERENCES `class` (`IdLop`);

--
-- Các ràng buộc cho bảng `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`IdAccount`) REFERENCES `account` (`IdAccount`),
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`IdLop`) REFERENCES `class` (`IdLop`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
