-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 06, 2020 lúc 10:15 AM
-- Phiên bản máy phục vụ: 10.4.14-MariaDB
-- Phiên bản PHP: 7.2.33

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
-- Cấu trúc bảng cho bảng `baitap`
--

CREATE TABLE `baitap` (
  `idBaiTap` char(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `IdLop` char(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TieuDe` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `NoiDung` varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Deadline` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment`
--

CREATE TABLE `comment` (
  `IdComment` char(10) NOT NULL,
  `IdUser` varchar(10) NOT NULL,
  `IdPost` char(10) CHARACTER SET ucs2 COLLATE ucs2_unicode_ci NOT NULL,
  `NoiDung` varchar(1024) NOT NULL,
  `FileDinhKem` char(255) NOT NULL,
  `NgayTao` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hocvien`
--

CREATE TABLE `hocvien` (
  `IdUser` char(10) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `Password` char(255) NOT NULL,
  `NamSinh` int(11) NOT NULL,
  `Email` char(255) NOT NULL,
  `Sdt` char(15) NOT NULL,
  `HoTen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lophoc`
--

CREATE TABLE `lophoc` (
  `IdLop` char(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TenLop` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Phong` char(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `MoTa` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `AnhDaiDien` text CHARACTER SET ucs2 COLLATE ucs2_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lop_user`
--

CREATE TABLE `lop_user` (
  `IdLop` char(10) CHARACTER SET ucs2 COLLATE ucs2_unicode_ci NOT NULL,
  `IdUser` char(10) CHARACTER SET ucs2 COLLATE ucs2_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post`
--

CREATE TABLE `post` (
  `IdPost` char(10) CHARACTER SET ucs2 COLLATE ucs2_unicode_ci NOT NULL,
  `IdUser` char(10) CHARACTER SET ucs2 COLLATE ucs2_unicode_ci NOT NULL,
  `IdLop` char(10) CHARACTER SET ucs2 COLLATE ucs2_unicode_ci NOT NULL,
  `NoiDung` varchar(1024) CHARACTER SET ucs2 COLLATE ucs2_unicode_ci NOT NULL,
  `FileDinhKem` char(255) CHARACTER SET ucs2 COLLATE ucs2_unicode_ci NOT NULL,
  `NgayTao` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`IdComment`);

--
-- Chỉ mục cho bảng `hocvien`
--
ALTER TABLE `hocvien`
  ADD PRIMARY KEY (`IdUser`);

--
-- Chỉ mục cho bảng `lophoc`
--
ALTER TABLE `lophoc`
  ADD PRIMARY KEY (`IdLop`);

--
-- Chỉ mục cho bảng `lop_user`
--
ALTER TABLE `lop_user`
  ADD PRIMARY KEY (`IdLop`,`IdUser`);

--
-- Chỉ mục cho bảng `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`IdPost`,`IdUser`,`IdLop`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
