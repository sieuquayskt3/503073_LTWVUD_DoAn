-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2020 at 04:47 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `classroom`
--
CREATE DATABASE IF NOT EXISTS `classroom` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `classroom`;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `IdAccount` int(10) NOT NULL,
  `HoTen` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `UserName` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `Email` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `Pass` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `Sdt` char(12) COLLATE utf8_unicode_ci NOT NULL,
  `NamSinh` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `Quyen` char(12) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`IdAccount`, `HoTen`, `UserName`, `Email`, `Pass`, `Sdt`, `NamSinh`, `Quyen`) VALUES
(10, 'Quản Lí', 'admin', 'sieuquayskt3@gmail.com', '$2y$10$xFjSd/QYsk258f0nOjwkQO8RVbqmqV8GHdN6gj/p6/NGEDrXFUC5.', '0123123123', '2000', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

DROP TABLE IF EXISTS `assignment`;
CREATE TABLE `assignment` (
  `IdBaiTap` int(10) NOT NULL,
  `IdLop` int(10) NOT NULL,
  `TieuDe` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `NoiDung` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `Deadline` varchar(12) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
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

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `IdComment` int(10) NOT NULL,
  `IdAccount` int(10) NOT NULL,
  `IdPost` int(10) NOT NULL,
  `NoiDung` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `File` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `NgayTao` varchar(12) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detailclass`
--

DROP TABLE IF EXISTS `detailclass`;
CREATE TABLE `detailclass` (
  `IdAccount` int(10) NOT NULL,
  `IdLop` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `IdPost` int(10) NOT NULL,
  `IdAccount` int(10) NOT NULL,
  `IdLop` int(10) NOT NULL,
  `NoiDung` varchar(1024) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `File` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `NgayTao` varchar(12) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`IdAccount`);

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`IdBaiTap`),
  ADD KEY `IdLop` (`IdLop`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`IdLop`),
  ADD KEY `IdAccount` (`IdAccount`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`IdComment`),
  ADD KEY `IdAccount` (`IdAccount`),
  ADD KEY `IdPost` (`IdPost`);

--
-- Indexes for table `detailclass`
--
ALTER TABLE `detailclass`
  ADD PRIMARY KEY (`IdAccount`,`IdLop`),
  ADD KEY `IdLop` (`IdLop`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`IdPost`),
  ADD KEY `IdAccount` (`IdAccount`),
  ADD KEY `IdLop` (`IdLop`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `IdAccount` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `IdBaiTap` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `IdLop` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `IdComment` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `IdPost` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignment`
--
ALTER TABLE `assignment`
  ADD CONSTRAINT `assignment_ibfk_1` FOREIGN KEY (`IdLop`) REFERENCES `class` (`IdLop`) ON DELETE CASCADE;

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `class_ibfk_1` FOREIGN KEY (`IdAccount`) REFERENCES `account` (`IdAccount`) ON DELETE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`IdAccount`) REFERENCES `account` (`IdAccount`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`IdPost`) REFERENCES `post` (`IdPost`) ON DELETE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`IdAccount`) REFERENCES `account` (`IdAccount`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`IdLop`) REFERENCES `class` (`IdLop`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
