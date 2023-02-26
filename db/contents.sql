-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 26, 2023 at 09:58 AM
-- Server version: 5.7.32
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `core_lite`
--

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `content_id` bigint(20) NOT NULL,
  `content_type` varchar(40) DEFAULT 'blog',
  `content_title` varchar(300) NOT NULL,
  `content_category` varchar(200) DEFAULT NULL,
  `content_format` varchar(200) DEFAULT NULL,
  `content_author` bigint(20) NOT NULL,
  `content_editor` bigint(20) DEFAULT NULL,
  `content_post` longtext,
  `content_tag` varchar(2000) DEFAULT NULL,
  `content_control` varchar(5000) DEFAULT NULL,
  `content_seo` varchar(8000) DEFAULT NULL,
  `content_show` varchar(20) DEFAULT 'public',
  `content_created` datetime NOT NULL,
  `content_updated` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `content_details` longtext,
  `content_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `content_default` varchar(25) DEFAULT 'yes',
  `content_flg` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
