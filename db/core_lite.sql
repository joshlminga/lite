-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 16, 2022 at 03:48 PM
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
-- Table structure for table `autofields`
--

CREATE TABLE `autofields` (
  `autofield_id` bigint(20) NOT NULL,
  `autofield_title` varchar(200) NOT NULL,
  `autofield_select` varchar(5000) DEFAULT NULL,
  `autofield_data` longtext NOT NULL,
  `autofield_details` longtext,
  `autofield_stamp` datetime NOT NULL,
  `autofield_default` varchar(5) DEFAULT 'yes',
  `autofield_flg` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `autofields`
--

INSERT INTO `autofields` (`autofield_id`, `autofield_title`, `autofield_select`, `autofield_data`, `autofield_details`, `autofield_stamp`, `autofield_default`, `autofield_flg`) VALUES
(1, 'auto_field', NULL, '{\"add_item_1\":\"Item 1 Value\",\"add_item_2\":\"Item 2 Value\"}', '{\"autofield_title\":\"auto_field\",\"autofield_data\":\"{\\\"add_item_1\\\":\\\"Item 1 Value\\\",\\\"add_item_2\\\":\\\"Item 2 Value\\\"}\",\"autofield_stamp\":\"2019-01-29 16:03:20\",\"autofield_flg\":1}', '2019-01-29 16:03:20', 'yes', 1);

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `blog_id` bigint(20) NOT NULL,
  `blog_category` varchar(200) DEFAULT 'post',
  `blog_title` varchar(200) NOT NULL,
  `blog_url` varchar(200) DEFAULT NULL,
  `blog_post` longtext,
  `blog_control` varchar(2000) DEFAULT NULL,
  `blog_tag` varchar(1000) DEFAULT NULL,
  `blog_format` varchar(100) DEFAULT 'none',
  `blog_show` varchar(10) DEFAULT 'public',
  `blog_author` varchar(20) NOT NULL,
  `blog_seo` longtext,
  `blog_data` longtext,
  `blog_createdat` datetime NOT NULL,
  `blog_editor` varchar(20) DEFAULT NULL,
  `blog_editedat` datetime DEFAULT NULL,
  `blog_details` longtext NOT NULL,
  `blog_stamp` datetime NOT NULL,
  `blog_default` varchar(5) DEFAULT 'yes',
  `blog_flg` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`blog_id`, `blog_category`, `blog_title`, `blog_url`, `blog_post`, `blog_control`, `blog_tag`, `blog_format`, `blog_show`, `blog_author`, `blog_seo`, `blog_data`, `blog_createdat`, `blog_editor`, `blog_editedat`, `blog_details`, `blog_stamp`, `blog_default`, `blog_flg`) VALUES
(1, 'uncategorised', 'Welcome To Core', 'welcome-to-core', '<p>Welcome to core blog</p>', '{\"thumbnail\":\"[\\\"assets\\\\\\/media\\\\\\/2019\\\\\\/06\\\\\\/04\\\\\\/e7de94e294ec2c6d23ee957a93ba4145.png\\\"]\"}', '', 'default', 'public', 'admin', NULL, NULL, '2019-03-21 19:55:27', NULL, NULL, '{\"blog_title\":\"Welcome To Core\",\"blog_post\":\"<p>Welcome to core blog<\\/p>\",\"blog_category\":\"uncategorised\",\"blog_show\":\"public\",\"blog_format\":\"default\",\"blog_control\":\"{\\\"thumbnail\\\":\\\"[\\\\\\\"assets\\\\\\\\\\\\\\/media\\\\\\\\\\\\\\/2019\\\\\\\\\\\\\\/06\\\\\\\\\\\\\\/04\\\\\\\\\\\\\\/e7de94e294ec2c6d23ee957a93ba4145.png\\\\\\\"]\\\"}\",\"blog_tag\":\"\",\"blog_stamp\":\"2019-06-04 20:48:34\",\"blog_createdat\":\"2019-03-21 19:55:27\",\"blog_author\":\"admin\",\"blog_flg\":1,\"blog_url\":\"welcome-to-core\"}', '2019-06-04 20:48:34', 'yes', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customfields`
--

CREATE TABLE `customfields` (
  `customfield_id` bigint(20) NOT NULL,
  `customfield_title` varchar(500) NOT NULL,
  `customfield_required` varchar(2000) DEFAULT NULL,
  `customfield_optional` longtext,
  `customfield_filters` longtext,
  `customfield_show` longtext,
  `customfield_details` longtext,
  `customfield_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `customfield_default` varchar(5) DEFAULT 'no',
  `customfield_flg` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customfields`
--

INSERT INTO `customfields` (`customfield_id`, `customfield_title`, `customfield_required`, `customfield_optional`, `customfield_filters`, `customfield_show`, `customfield_details`, `customfield_stamp`, `customfield_default`, `customfield_flg`) VALUES
(1, 'member', '[\"Name\",\"Email\"]', '[\"Gender\",\"Mobile\"]', '[\"email\"]', NULL, '{\"customfield_title\":\"Member\",\"customfield_required\":\"[\\\"Name\\\",\\\"Email\\\"]\",\"customfield_optional\":\"[\\\"Gender\\\",\\\"Mobile\\\"]\",\"customfield_stamp\":\"2022-05-23 21:15:52\",\"customfield_flg\":1,\"customfield_filters\":\"[\\\"email\\\"]\",\"customfield_default\":\"yes\",\"customfield_show\":null}', '2022-05-23 18:15:52', 'yes', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE `fields` (
  `field_id` bigint(20) NOT NULL,
  `field_title` varchar(500) NOT NULL,
  `field_filters` varchar(2000) DEFAULT NULL,
  `field_data` longtext,
  `field_show` longtext,
  `field_details` longtext,
  `field_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `field_default` varchar(5) DEFAULT 'yes',
  `field_flg` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`field_id`, `field_title`, `field_filters`, `field_data`, `field_show`, `field_details`, `field_stamp`, `field_default`, `field_flg`) VALUES
(1, 'member', '{\"email\":\"johndoe@core.com\"}', '{\"name\":\"John Doe\",\"email\":\"johndoe@core.com\",\"mobile\":\"0700000000\",\"gender\":\"3\"}', 'public', '{\"field_data\":\"{\\\"name\\\":\\\"John Doe\\\",\\\"email\\\":\\\"johndoe@core.com\\\",\\\"mobile\\\":\\\"0700000000\\\",\\\"gender\\\":\\\"3\\\"}\",\"field_filters\":\"{\\\"email\\\":\\\"johndoe@core.com\\\"}\",\"field_title\":\"member\"}', '2021-07-22 10:39:16', 'yes', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inheritances`
--

CREATE TABLE `inheritances` (
  `inheritance_id` bigint(20) NOT NULL,
  `inheritance_type` varchar(100) NOT NULL,
  `inheritance_parent` bigint(20) DEFAULT '0',
  `inheritance_title` varchar(500) NOT NULL,
  `inheritance_url` varchar(120) DEFAULT NULL,
  `inheritance_details` longtext,
  `inheritance_stamp` datetime NOT NULL,
  `inheritance_default` varchar(5) DEFAULT 'yes',
  `inheritance_flg` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inheritances`
--

INSERT INTO `inheritances` (`inheritance_id`, `inheritance_type`, `inheritance_parent`, `inheritance_title`, `inheritance_url`, `inheritance_details`, `inheritance_stamp`, `inheritance_default`, `inheritance_flg`) VALUES
(1, 'category', 0, 'Uncategorised', NULL, '{\"inheritance_type\":\"default\",\"inheritance_parent\":\"1\",\"inheritance_title\":\"Parent 2\",\"inheritance_stamp\":\"2019-01-28 13:25:59\",\"inheritance_flg\":1}', '2019-01-28 13:25:59', 'yes', 1),
(2, 'tag', 0, 'Blog', NULL, '{\"inheritance_type\":\"default\",\"inheritance_parent\":\"0\",\"inheritance_title\":\"home\",\"inheritance_stamp\":\"2019-02-01 16:06:29\",\"inheritance_flg\":1}', '2019-02-01 16:06:29', 'yes', 1),
(3, 'gender', 0, 'Male', NULL, '{\"inheritance_type\":\"gender\",\"inheritance_parent\":\"0\",\"inheritance_title\":\"Male\",\"inheritance_stamp\":\"2021-07-22 12:47:03\",\"inheritance_flg\":1}', '2021-07-22 12:47:03', 'yes', 1),
(4, 'gender', 0, 'Female', NULL, '{\"inheritance_type\":\"gender\",\"inheritance_parent\":\"0\",\"inheritance_title\":\"Female\",\"inheritance_stamp\":\"2021-07-22 12:47:09\",\"inheritance_flg\":1}', '2021-07-22 12:47:09', 'yes', 1);

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `level_id` bigint(20) NOT NULL,
  `level_name` varchar(20) NOT NULL,
  `level_module` longtext NOT NULL,
  `level_details` longtext,
  `level_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `level_default` varchar(5) DEFAULT 'yes',
  `level_flg` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`level_id`, `level_name`, `level_module`, `level_details`, `level_stamp`, `level_default`, `level_flg`) VALUES
(1, 'admin', 'main,blog,page,autofield,control,inheritance,customfield,user,level,setting,profile,member,customer', '{\"level_module\":\"main,blog,page,autofield,control,inheritance,customfield,user,level,setting,profile,member,customer\",\"level_stamp\":\"2022-01-07 14:49:21\",\"level_default\":\"yes\",\"level_flg\":1}', '2022-01-07 11:49:21', 'yes', 1),
(2, 'user', 'main,control,setting,profile', '{\"level_module\":\"main,control,setting,profile\",\"level_stamp\":\"2022-01-07 14:49:21\",\"level_default\":\"yes\",\"level_flg\":1}', '2022-01-07 11:49:21', 'yes', 1),
(3, 'author', 'main,blog,page,autofield,control,inheritance,setting,profile', '{\"level_module\":\"main,blog,page,autofield,control,inheritance,setting,profile\",\"level_stamp\":\"2022-01-07 14:49:21\",\"level_default\":\"yes\",\"level_flg\":1}', '2022-01-07 11:49:21', 'yes', 1),
(4, 'customer', 'main,profile', '{\"level_module\":\"main,profile\",\"level_stamp\":\"2022-01-07 14:49:21\",\"level_default\":\"no\",\"level_flg\":1}', '2022-01-07 11:49:21', 'no', 1);

-- --------------------------------------------------------

--
-- Table structure for table `metaterms`
--

CREATE TABLE `metaterms` (
  `metaterm_id` bigint(20) NOT NULL,
  `metaterm_module` varchar(200) NOT NULL,
  `metaterm_type` varchar(100) DEFAULT NULL,
  `metaterm_typeid` bigint(20) NOT NULL,
  `metaterm_url` varchar(500) DEFAULT NULL,
  `metaterm_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `metaterm_flg` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `metaterms`
--

INSERT INTO `metaterms` (`metaterm_id`, `metaterm_module`, `metaterm_type`, `metaterm_typeid`, `metaterm_url`, `metaterm_stamp`, `metaterm_flg`) VALUES
(1, 'autofields', 'auto_field', 2, 'auto-field', '2022-06-16 11:41:01', 1),
(2, 'blogs', 'blog', 1, 'welcome-to-core', '2022-06-16 08:47:04', 1),
(3, 'inheritances', 'category', 1, 'uncategorised', '2022-06-16 09:36:53', 1),
(4, 'inheritances', 'tag', 2, 'blog', '2022-06-16 09:37:51', 1),
(5, 'inheritances', 'gender', 3, 'male', '2022-06-16 10:35:56', 1),
(6, 'inheritances', 'gender', 4, 'female', '2022-06-16 10:36:03', 1),
(7, 'pages', 'page', 1, 'home-page', '2019-03-21 13:55:27', 1),
(8, 'levels', 'level', 1, 'admin', '2022-06-16 10:55:20', 1),
(9, 'levels', 'level', 2, 'user', '2022-06-16 10:55:48', 1),
(10, 'levels', 'level', 3, 'author', '2022-06-16 10:55:48', 1),
(11, 'levels', 'level', 4, 'customer', '2022-06-16 10:56:39', 1),
(12, 'users', 'user', 1, 'admin', '2022-06-16 11:32:22', 1),
(13, 'users', 'user', 2, 'janedoe', '2022-06-16 11:32:22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `page_id` bigint(20) NOT NULL,
  `page_title` varchar(200) NOT NULL,
  `page_url` varchar(200) DEFAULT NULL,
  `page_post` longtext,
  `page_control` varchar(2000) DEFAULT NULL,
  `page_show` varchar(10) DEFAULT 'public',
  `page_author` varchar(20) NOT NULL,
  `page_seo` longtext,
  `page_data` longtext,
  `page_createdat` datetime NOT NULL,
  `page_editor` varchar(20) DEFAULT NULL,
  `page_editedat` datetime DEFAULT NULL,
  `page_details` longtext NOT NULL,
  `page_stamp` datetime NOT NULL,
  `page_default` varchar(5) DEFAULT 'yes',
  `page_flg` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`page_id`, `page_title`, `page_url`, `page_post`, `page_control`, `page_show`, `page_author`, `page_seo`, `page_data`, `page_createdat`, `page_editor`, `page_editedat`, `page_details`, `page_stamp`, `page_default`, `page_flg`) VALUES
(1, 'Home Page', 'home-page', '<p>Core CMS home page</p>', '{\"thumbnail\":null}', 'public', 'admin', NULL, NULL, '2019-03-21 19:55:57', NULL, NULL, '{\"page_title\":\"Home Page\",\"page_post\":\"<p>Core CMS home page<\\/p>\",\"page_show\":\"public\",\"page_control\":\"{\\\"thumbnail\\\":null}\",\"page_stamp\":\"2019-03-21 19:55:57\",\"page_createdat\":\"2019-03-21 19:55:57\",\"page_author\":\"admin\",\"page_flg\":1}', '2019-03-21 19:55:57', 'yes', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_id` bigint(20) NOT NULL,
  `setting_title` varchar(200) NOT NULL,
  `setting_value` longtext,
  `setting_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `setting_default` varchar(25) DEFAULT 'yes',
  `setting_flg` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `setting_title`, `setting_value`, `setting_stamp`, `setting_default`, `setting_flg`) VALUES
(1, 'site_title', 'Core CMS Lite', '2020-12-07 15:15:13', 'yes', 1),
(2, 'site_slogan', 'Develop Faster, Easier and Modular ', '2018-11-23 11:19:36', 'yes', 1),
(3, 'theme_title', 'starter', '2018-11-23 11:19:36', 'yes', 1),
(4, 'site_status', 'online', '2018-12-17 05:52:06', 'yes', 1),
(5, 'offline_message', 'We are offline', '2018-12-17 05:50:58', 'yes', 1),
(6, 'current_url', 'title', '2018-12-17 14:54:02', 'yes', 1),
(7, 'mail_protocol', 'mail', '2019-09-21 08:34:13', 'yes', 1),
(8, 'smtp_host', '', '2018-12-17 12:24:08', 'yes', 1),
(9, 'smtp_user', '', '2018-12-17 12:24:29', 'yes', 1),
(10, 'smtp_pass', '', '2018-12-17 12:24:29', 'yes', 1),
(11, 'smtp_port', '25', '2018-12-17 12:27:45', 'yes', 1),
(12, 'smtp_timeout', '5', '2018-12-17 12:27:21', 'yes', 1),
(13, 'smtp_crypto', '', '2018-12-17 12:25:41', 'yes', 1),
(14, 'wordwrap', 'TRUE', '2018-12-17 12:27:10', 'yes', 1),
(15, 'wrapchars', '76', '2018-12-17 12:27:03', 'yes', 1),
(16, 'mailtype', 'text', '2018-12-17 12:26:56', 'yes', 1),
(17, 'charset', 'UTF-8', '2018-12-17 12:26:34', 'yes', 1),
(18, 'home_display', 'blog', '2018-12-17 14:24:53', 'yes', 1),
(19, 'home_post', 'latest_post', '2019-03-21 14:09:47', 'yes', 1),
(20, 'home_page', '', '2018-12-17 13:03:08', 'yes', 1),
(21, 'post_per_page', '10', '2018-12-17 13:11:11', 'yes', 1),
(22, 'page_pagination', '4', '2018-12-17 13:11:11', 'yes', 1),
(23, 'post_show', 'summary', '2019-03-21 13:53:57', 'yes', 1),
(24, 'seo_visibility', 'noindex, nofollow', '2019-03-18 13:26:50', 'yes', 1),
(25, 'seo_global', 'any', '2019-03-18 13:37:13', 'yes', 1),
(26, 'seo_description', '', '2019-06-22 05:06:09', 'yes', 1),
(27, 'seo_keywords', '', '2018-12-17 14:30:41', 'yes', 1),
(28, 'seo_meta_data', '', '2018-12-17 13:10:23', 'yes', 1),
(29, 'inheritance_data', 'default,category,tag,gender', '2021-07-22 06:44:17', 'yes', 1),
(30, 'module_list', 'main,blog,page,autofield,control,inheritance,customfield,user,level,setting,profile,member,customer', '2021-07-22 06:32:48', 'yes', 1),
(31, 'assets', 'assets/admin', '2019-06-08 12:22:55', 'yes', 1),
(32, 'ext_dir', 'extend/', '2019-06-11 04:54:39', 'yes', 1),
(33, 'ext_assets', 'assets/extend', '2019-06-08 14:25:52', 'yes', 1),
(34, 'theme_name', 'starter', '2020-01-15 09:28:43', 'theme', 1),
(35, 'theme_dir', 'themes/starter', '2019-06-11 04:54:50', 'theme', 1),
(36, 'theme_assets', 'assets/themes/starter', '2019-06-08 15:30:02', 'theme', 1),
(37, 'child_theme', '', '2019-06-08 15:30:26', 'theme', 1),
(38, 'child_theme_dir', '', '2019-06-08 15:30:29', 'theme', 1),
(39, 'child_theme_assets', '', '2019-06-08 15:30:34', 'theme', 1),
(40, 'site_url', 'http://localhost:8888/CoreCMS/CoreLite/', '2021-07-22 06:28:40', 'yes', 1),
(41, 'api_url', 'http://localhost:8888/CoreCMS/CoreLite/', '2021-04-09 14:19:07', 'yes', 1),
(42, 'string_variable', '#\\#{\\[(.*?)\\]\\}#', '2020-02-05 05:55:11', 'keys', 1),
(43, 'session_key', '4OaXTFypxh', '2022-06-16 15:36:31', 'keys', 1),
(44, 'token_name', 'Token', '2021-07-22 06:01:55', 'keys', 1),
(45, 'token_length', '25', '2021-07-22 06:01:55', 'keys', 1),
(46, 'token_use', '3', '2021-07-22 06:01:55', 'keys', 1),
(47, 'token_time', '300', '2021-07-22 06:01:55', 'keys', 1),
(48, 'currency', 'Ksh', '2021-07-22 06:01:55', 'locale', 1),
(49, 'country', 'Kenya', '2021-07-22 06:01:55', 'locale', 1),
(50, 'city', 'Nairobi', '2021-07-22 06:01:55', 'locale', 1),
(51, 'country_code', '+254', '2021-07-22 06:01:55', 'locale', 1),
(52, 'country_timezone', 'Africa/Nairobi', '2021-07-22 06:01:55', 'locale', 1),
(53, 'field_menu', '{\"menu_path\":\"member/menu\",\"route\":{\"member\":\"Field/Members/index\",\"member/new\":\"Field/Members/open/add\", \"member/edit\":\"Field/Members/edit/edit\",\"member/save\":\"Field/Members/valid/save\",\"member/update\":\"Field/Members/valid/update\",\"member/delete\":\"Field/Members/valid/delete\", \"member/multiple\":\"Field/Members/valid/bulk\"}\r\n}', '2022-06-16 15:42:34', 'route', 1),
(54, 'extension_menu', '{\"menu_path\":\"customer/menu\",\"route\":{\"customer\":\"Extension/Customers/index\",\"customer/new\":\"Extension/Customers/open/add\", \"customer/edit\":\"Extension/Customers/edit/edit\",\"customer/save\":\"Extension/Customers/valid/save\",\"customer/update\":\"Extension/Customers/valid/update\",\"customer/delete\":\"Extension/Customers/valid/delete\", \"customer/multiple\":\"Extension/Customers/valid/bulk\"}\r\n}', '2022-06-16 15:43:27', 'route', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `token_id` bigint(20) NOT NULL,
  `token_type` varchar(10) COLLATE utf8mb4_swedish_ci DEFAULT 'session' COMMENT 'api = a powerful type for api usage, does not expire unless flg = 0 or deleted | session = won''t be visible for editing /update /delete | access = for simple task has expiry datetime',
  `token_key` varchar(51) COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `token_value` varchar(5000) COLLATE utf8mb4_swedish_ci NOT NULL,
  `token_owner` varchar(500) COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `token_access` varchar(20) COLLATE utf8mb4_swedish_ci DEFAULT NULL COMMENT 'Match access level name ',
  `token_limit` int(1) NOT NULL DEFAULT '1' COMMENT '1 = This token can expire | 0 = permanent token ',
  `token_created` datetime NOT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `token_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `token_count` int(11) NOT NULL DEFAULT '0' COMMENT 'times token has been accessed',
  `token_flg` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`token_id`, `token_type`, `token_key`, `token_value`, `token_owner`, `token_access`, `token_limit`, `token_created`, `token_expiry`, `token_stamp`, `token_count`, `token_flg`) VALUES
(1, 'api', 'MDBMuRrW', '5113d39b5abf2602b0852c8dad2d7d99a076b930d40f976c3757d391ba74f604690541e1767e02e459e265eed82ddadc68398aab578df643320475b33c736394HxApLhFxIuFn3bj8k80iZxbygANo54ljzgecybFe4P0=', NULL, NULL, 0, '2022-05-24 17:50:33', NULL, '2022-05-24 14:50:33', 0, 1),
(2, 'api', 'gUGYH8PtVNSqZjACb9sfcWq33', '2f2cca6ab7acdb93b55fb4f2746ca921b5aac4df996af88bfb32c2cbb01079dd804ae2ae05c3934e573fa36a91cc7b3a8f202002fc9003ddee9e3de1cb299c48cj6ucjjIKKjiRc6pZFkfernOwBXM5klt+spdXjCDwep7rYnOECaizAYhe5Z+MJsp', NULL, NULL, 0, '2022-05-24 17:52:22', NULL, '2022-05-24 14:52:22', 0, 1),
(3, 'api', 'VfbWyOuqcP4gQ6QWpdKgXu8DUBkYhpugkAT2dwV85mnlQ8haP1', '0d667207df6b3c98939579ff7e8f59626ae8764bad4b0c6abc17c42cfc21a6ee3225640dd723a57c726e9d385e7053861524ca7cd4f1eb2940160d271f042c28hE3F2TT37EXiZCsOKte0x1HFuyGwNNh7RAERtBoZb4L4Qj0im5q7xnamaXWkPvlEAgixSNVJGdp1E4OXDsCZ2riDDOrStzlVb1PWj2VIsE8=', NULL, NULL, 0, '2022-05-24 17:52:55', NULL, '2022-05-24 14:52:55', 0, 1),
(4, 'access', 't9FCwq8dff', '925f3f8a781ea2fa9a2179d13306752a571ad5ccfb3886580e93756ba058c839a3eda2af0a1dd98a0ac63f0dd96cd2a059752de49102e83bbe37bdc2adebba1d6oKiFHZ7QN78gXylmddrE+tllfILJUDra0H873yOrtQ=', NULL, NULL, 1, '2022-05-24 17:54:08', '2022-05-24 17:55:08', '2022-05-24 14:55:05', 0, 1),
(5, 'access', '6uOJuVSov83n8K1', '22ad34e0f2290ba7b76d2df84da7f85bfbe3802028f015d33f2f3bcb221149c64f89b55edd7b99ef881d95bcda709b83301d58ec31129869bd776db462610e22vfjs7OAVTL2R3wQ8ykGzd1OEPuXNVXHwH198ENhmjE8=', NULL, NULL, 1, '2022-05-24 17:54:25', '2022-05-24 17:55:25', '2022-05-24 14:54:58', 0, 1),
(6, 'access', 'mIDIkcji8LfaYPRDaB76DLAnD', 'ade2ce41fad8564ea8f8cc48b449dfccf48b844345652e3cd366f1e119bdf1d5702a031c6d4112a2063f199747854d4f1f32f9902169a5644497c1a80409ef1c7unaWLF8S6CkRWXiZqey03/EJ4y389xQE2KT9ua94vhTl5TPcP554fOHmDnEJ6sJ', NULL, NULL, 1, '2022-05-24 17:54:34', '2022-05-24 17:55:34', '2022-05-24 14:55:00', 0, 1),
(7, 'access', 'D17HBjOrUk3ObkYACLrkGz7n7', '95179b2e0387b23b0ee879a123c8e447ed7c4b1619348676cea6c590f9eaa23e3bbe0049a8454c4155acd60108b7417192887ffb80d5fa5aa499065817e5551722DSnrUNXIqufiNgAQCrLoPMAft4hyfCYcawi2KsseAQmrCn24NSJGoSloWL+aEP', NULL, NULL, 1, '2022-05-24 17:57:58', '2022-05-24 17:58:58', '2022-05-24 14:59:11', 0, 1),
(8, 'access', 'et3aWhPJD3ghDvdOKtQ75RdJm', '60214ce2ce124d17d9757ef359851c2a724f6ab39f1b9e171a24b65ce6e7e47bb136d849dd0c46b08ee7d2e6446212f6a320c789d5ca08fd949977591dffc349t+bJGqnfquRRYcTwT1Ei78WZwkzDqfcbdgOJhxiX5MRljkq0EuC+ysfULZ3KXwf4', NULL, NULL, 1, '2022-05-24 17:59:01', '2022-05-24 18:00:01', '2022-05-24 14:59:01', 0, 1),
(9, 'session', 'OnTUCUyqq8avXS95yH68H7JiQ', 'caa7e19db4c404292b56b1e833d90bb6c2821d5b25218963a4b6f9602365996b7d192addc32f092d01d2bdca1a0158c5f87af459b1da7d7cd316d37fbe6aaba34up1soL2Q7FJn12Rl/9nb44ZlZgm2Yv1Nn/IzbKRHCJh1tRFIFXpQsrCNhIF17oh', NULL, NULL, 1, '2022-05-24 17:59:47', '2022-05-24 18:00:47', '2022-05-24 14:59:47', 0, 1),
(10, 'session', 'MDBMuRrW', 'ca2a441e0db830608e59631b5f03427aa1a501b0e44669642a7b74cf7247421c5ec5ec712622ead19e31dc1ca73904d1701024d3f480e4eb0da2a88de1ad12121S8sRpFC7rwq2FL40fXxQ5CCgKjkJozMtaX9DlKzU+I=', NULL, NULL, 1, '2022-05-26 15:07:00', '2022-05-26 15:08:00', '2022-05-26 12:07:00', 0, 1),
(11, 'session', 'kimanga', '70dbe11e98d80204b3171f2eaeea2aef483c35ea668cd2cec96b2929d30fe07d22c1724f92a14cb26b43f92b5cab398f212666b141c01a6a84528e4df1d749b4desktDUZxPVFng7Co0DABnt7u1vLJOsi53RpYSEcNu8=', NULL, NULL, 1, '2022-05-26 15:22:10', '2022-05-26 15:23:10', '2022-05-26 12:22:10', 0, 1),
(12, 'session', 'kimanga', '7e8a300e063f78c38ad89fcf29b5951d4192d53f1963345ba24a21a1687cd9044eefdf998adde2be7714eb5dfd59660a873336dfa6d67c5971f50045c0895fe1wznqhpWLztvA5nA0K98RTJZjMoLMqPSI0IcY0Wzl4cA=', NULL, NULL, 1, '2022-05-26 15:22:14', '2022-05-26 15:23:14', '2022-05-26 12:22:14', 0, 1),
(13, 'session', 'kimanga', 'a387d98840edecfb4357aa9adaf8db3ed48081042028076fd223dd9b30e40c768943f42cea97ce03c407ea96671b2ca0459ee7be52852ff2e3149b02ed0d8933NJ4/5t1GHDzgbQC4t/Z9OTGDX237MlDQfW75i4pBVp4=', NULL, NULL, 1, '2022-05-26 15:22:16', '2022-05-26 15:23:16', '2022-05-26 12:22:16', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) NOT NULL,
  `user_level` varchar(50) NOT NULL,
  `user_logname` varchar(50) NOT NULL,
  `user_password` varchar(500) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_email` varchar(50) DEFAULT NULL,
  `user_details` longtext,
  `user_stamp` datetime NOT NULL,
  `user_default` varchar(5) DEFAULT 'yes',
  `user_flg` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_level`, `user_logname`, `user_password`, `user_name`, `user_email`, `user_details`, `user_stamp`, `user_default`, `user_flg`) VALUES
(1, 'admin', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'John Doe', 'johndoe@core.com', '{\"user_name\":\"John Doe\",\"user_email\":\"johndoe@core.com\",\"user_level\":\"admin\",\"user_password\":\"d033e22ae348aeb5660fc2140aec35850c4da997\",\"user_stamp\":\"2021-07-22 13:41:26\",\"user_flg\":1,\"user_logname\":\"admin\"}', '2021-07-22 13:41:26', 'yes', 1),
(2, 'customer', 'janedoe', '06d213088a72f4c1ac947c6f3d9ddd321650ebfb', 'Jane Doe', 'janedoe@core.com', '{\"user_name\":\"Jane Doe\",\"user_email\":\"janedoe@core.com\",\"user_level\":\"customer\",\"user_logname\":\"janedoe\",\"user_password\":\"06d213088a72f4c1ac947c6f3d9ddd321650ebfb\",\"user_default\":\"no\",\"user_stamp\":\"2022-01-07 14:25:11\",\"user_flg\":1}', '2022-01-07 14:25:11', 'no', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `autofields`
--
ALTER TABLE `autofields`
  ADD PRIMARY KEY (`autofield_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`blog_id`);

--
-- Indexes for table `customfields`
--
ALTER TABLE `customfields`
  ADD PRIMARY KEY (`customfield_id`),
  ADD UNIQUE KEY `customfield_title` (`customfield_title`);

--
-- Indexes for table `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`field_id`);

--
-- Indexes for table `inheritances`
--
ALTER TABLE `inheritances`
  ADD PRIMARY KEY (`inheritance_id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`level_id`);

--
-- Indexes for table `metaterms`
--
ALTER TABLE `metaterms`
  ADD PRIMARY KEY (`metaterm_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`token_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_level` (`user_level`),
  ADD KEY `user_logname` (`user_logname`),
  ADD KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `autofields`
--
ALTER TABLE `autofields`
  MODIFY `autofield_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `blog_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customfields`
--
ALTER TABLE `customfields`
  MODIFY `customfield_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fields`
--
ALTER TABLE `fields`
  MODIFY `field_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inheritances`
--
ALTER TABLE `inheritances`
  MODIFY `inheritance_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `level_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `metaterms`
--
ALTER TABLE `metaterms`
  MODIFY `metaterm_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `token_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
