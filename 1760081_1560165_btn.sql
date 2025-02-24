-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 27, 2019 at 03:48 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `1760081_1560165_btn`
--

-- --------------------------------------------------------

--
-- Table structure for table `banbe`
--

DROP TABLE IF EXISTS `banbe`;
CREATE TABLE IF NOT EXISTS `banbe` (
  `ban1` int(11) NOT NULL,
  `ban2` int(11) NOT NULL,
  `tinhtrang` int(11) NOT NULL DEFAULT '0' COMMENT '0: mới gửi lời mời, 1: đã kết bạn',
  PRIMARY KEY (`ban1`,`ban2`),
  UNIQUE KEY `ban1` (`ban1`,`ban2`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `binhluan`
--

DROP TABLE IF EXISTS `binhluan`;
CREATE TABLE IF NOT EXISTS `binhluan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `matt` int(11) NOT NULL,
  `binhluancha` int(11) DEFAULT NULL,
  `thoigianthuchien` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ngbinhluanid` int(11) NOT NULL,
  `noidung` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `luotthich`
--

DROP TABLE IF EXISTS `luotthich`;
CREATE TABLE IF NOT EXISTS `luotthich` (
  `mand` int(11) NOT NULL,
  `matt` int(11) NOT NULL,
  `thoigianthuchien` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `macmt` int(11) DEFAULT NULL,
  UNIQUE KEY `mand` (`mand`,`matt`,`macmt`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nguoidung`
--

DROP TABLE IF EXISTS `nguoidung`;
CREATE TABLE IF NOT EXISTS `nguoidung` (
  `ma` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `sdt` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `hoten` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `namsinh` char(4) COLLATE utf8_unicode_ci NOT NULL,
  `matkhau` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` longblob,
  `avatar_img` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sendMainNotifi` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ma`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `theodoi`
--

DROP TABLE IF EXISTS `theodoi`;
CREATE TABLE IF NOT EXISTS `theodoi` (
  `nddangid` int(11) NOT NULL,
  `ndbiid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thongbao`
--

DROP TABLE IF EXISTS `thongbao`;
CREATE TABLE IF NOT EXISTS `thongbao` (
  `ma` int(11) NOT NULL AUTO_INCREMENT,
  `noidung` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `thoigianthuchien` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ndnhanid` int(11) NOT NULL,
  `daxem` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ma`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trangthai`
--

DROP TABLE IF EXISTS `trangthai`;
CREATE TABLE IF NOT EXISTS `trangthai` (
  `ma` int(11) NOT NULL AUTO_INCREMENT,
  `nguoidang` int(11) NOT NULL,
  `thoigiandang` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `riengtu` int(11) NOT NULL DEFAULT '1' COMMENT '0: only me; 1: bạn bè; 2: công khai',
  `noidung` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ma`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trangthaidinhkem`
--

DROP TABLE IF EXISTS `trangthaidinhkem`;
CREATE TABLE IF NOT EXISTS `trangthaidinhkem` (
  `matt` int(11) NOT NULL,
  `anhdinhkem` longblob,
  `anhdinhkem_img` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trochuyen`
--

DROP TABLE IF EXISTS `trochuyen`;
CREATE TABLE IF NOT EXISTS `trochuyen` (
  `ma` int(11) NOT NULL AUTO_INCREMENT,
  `ndtaoid` int(11) NOT NULL,
  `ten` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ma`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trochuyenlichsu`
--

DROP TABLE IF EXISTS `trochuyenlichsu`;
CREATE TABLE IF NOT EXISTS `trochuyenlichsu` (
  `ma` int(11) NOT NULL AUTO_INCREMENT,
  `ndgui` int(11) NOT NULL,
  `thoaima` int(11) NOT NULL,
  `thoigiangui` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `noidung` text COLLATE utf8_unicode_ci NOT NULL,
  `an` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ma`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trochuyenthamgia`
--

DROP TABLE IF EXISTS `trochuyenthamgia`;
CREATE TABLE IF NOT EXISTS `trochuyenthamgia` (
  `hoithoaima` int(11) NOT NULL,
  `ndtgma` int(11) NOT NULL,
  `ngayxemcuoicung` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `an` tinyint(1) NOT NULL DEFAULT '0',
  `daguimail` tinyint(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `hoithoaima` (`hoithoaima`,`ndtgma`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
