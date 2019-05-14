-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2019 at 11:49 AM
-- Server version: 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `core_cms_lite_v1`
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
(1, 'uncategorised', 'Welcome To Core', 'welcome-to-core', '<p>Welcome to core blog</p>', '{\"thumbnail\":\"[\\\"assets\\\\\\/admin\\\\\\/images\\\\\\/upload\\\\\\/media\\\\\\/e146b95b2a62b136fa2a07432482d393.png\\\"]\"}', '', 'default', 'public', 'admin', NULL, NULL, '2019-03-21 19:55:27', NULL, NULL, '{\"blog_title\":\"Welcome To Core\",\"blog_post\":\"<p>Welcome to core blog<\\/p>\",\"blog_category\":\"uncategorised\",\"blog_show\":\"public\",\"blog_format\":\"default\",\"blog_control\":\"{\\\"thumbnail\\\":\\\"[\\\\\\\"assets\\\\\\\\\\\\\\/admin\\\\\\\\\\\\\\/images\\\\\\\\\\\\\\/upload\\\\\\\\\\\\\\/media\\\\\\\\\\\\\\/e146b95b2a62b136fa2a07432482d393.png\\\\\\\"]\\\"}\",\"blog_tag\":\"\",\"blog_stamp\":\"2019-03-21 19:55:27\",\"blog_createdat\":\"2019-03-21 19:55:27\",\"blog_author\":\"admin\",\"blog_flg\":1}', '2019-03-21 19:55:27', 'yes', 1);

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
  `customfield_show` varchar(20) DEFAULT 'admin',
  `customfield_details` longtext,
  `customfield_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `customfield_default` varchar(5) DEFAULT 'no',
  `customfield_flg` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customfields`
--

INSERT INTO `customfields` (`customfield_id`, `customfield_title`, `customfield_required`, `customfield_optional`, `customfield_filters`, `customfield_show`, `customfield_details`, `customfield_stamp`, `customfield_default`, `customfield_flg`) VALUES
(1, 'userdata', '[\"User Name\",\"User Email\"]', '[\"User Gender\",\"User Mobile\",\"\"]', '[\"user_name\",\"user_email\"]', 'admin', '{\"customfield_title\":\"User Data\",\"customfield_required\":\"[\\\"User Name\\\",\\\"User Email\\\"]\",\"customfield_optional\":\"[\\\"User Gender\\\",\\\"User Mobile\\\",\\\"\\\"]\",\"customfield_stamp\":\"2019-04-12 16:53:52\",\"customfield_flg\":1,\"customfield_filters\":\"[\\\"user_name\\\",\\\"user_email\\\"]\",\"customfield_default\":\"yes\"}', '2019-04-12 13:53:52', 'yes', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE `fields` (
  `field_id` bigint(20) NOT NULL,
  `field_title` varchar(500) NOT NULL,
  `field_filters` varchar(2000) DEFAULT NULL,
  `field_data` longtext,
  `field_show` varchar(500) DEFAULT 'public',
  `field_details` longtext,
  `field_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `field_default` varchar(5) DEFAULT 'yes',
  `field_flg` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`field_id`, `field_title`, `field_filters`, `field_data`, `field_show`, `field_details`, `field_stamp`, `field_default`, `field_flg`) VALUES
(1, 'userdata', '{\"user_name\":\"Andrew\",\"user_email\":\"njenga@gmail.com\"}', '{\"user_name\":\"Andrew\",\"user_email\":\"njenga@gmail.com\",\"user_gender\":\"male\",\"user_mobile\":\"070854960\"}', 'public', '{\"field_data\":\"{\\\"user_name\\\":\\\"Andrew\\\",\\\"user_email\\\":\\\"njenga@gmail.com\\\",\\\"user_gender\\\":\\\"male\\\",\\\"user_mobile\\\":\\\"070854960\\\"}\",\"field_filters\":\"{\\\"user_name\\\":\\\"Andrew\\\",\\\"user_email\\\":\\\"njenga@gmail.com\\\"}\",\"field_title\":\"userdata\",\"field_stamp\":\"2019-02-06 18:34:25\",\"field_flg\":1}', '2019-02-06 15:34:25', 'yes', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inheritances`
--

CREATE TABLE `inheritances` (
  `inheritance_id` bigint(20) NOT NULL,
  `inheritance_type` varchar(100) NOT NULL,
  `inheritance_parent` bigint(20) DEFAULT '0',
  `inheritance_title` varchar(500) NOT NULL,
  `inheritance_details` longtext,
  `inheritance_stamp` datetime NOT NULL,
  `inheritance_default` varchar(5) DEFAULT 'yes',
  `inheritance_flg` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inheritances`
--

INSERT INTO `inheritances` (`inheritance_id`, `inheritance_type`, `inheritance_parent`, `inheritance_title`, `inheritance_details`, `inheritance_stamp`, `inheritance_default`, `inheritance_flg`) VALUES
(1, 'category', 0, 'Uncategorised', '{\"inheritance_type\":\"default\",\"inheritance_parent\":\"1\",\"inheritance_title\":\"Parent 2\",\"inheritance_stamp\":\"2019-01-28 13:25:59\",\"inheritance_flg\":1}', '2019-01-28 13:25:59', 'yes', 1),
(2, 'tag', 0, 'Blog', '{\"inheritance_type\":\"default\",\"inheritance_parent\":\"0\",\"inheritance_title\":\"home\",\"inheritance_stamp\":\"2019-02-01 16:06:29\",\"inheritance_flg\":1}', '2019-02-01 16:06:29', 'yes', 1);

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
(1, 'admin', 'main,blog,page,autofield,control,inheritance,customfield,user,level,setting,profile,userdatas,customers', '{\"level_module\":\"main,blog,page,autofield,control,inheritance,customfield,user,level,setting,profile,userdatas,customers\",\"level_stamp\":\"2019-03-23 15:16:49\"}', '2019-03-23 12:16:49', 'yes', 1),
(2, 'user', 'main,control,setting,profile,customers', '{\"level_module\":\"main,control,setting,profile,customers\",\"level_stamp\":\"2019-03-23 15:18:50\"}', '2019-03-23 12:18:50', 'yes', 1),
(3, 'author', 'main,blog,page,autofield,control,inheritance,setting,profile', '{\"level_module\":\"main,blog,page,autofield,control,inheritance,setting,profile\",\"level_stamp\":\"2019-03-25 17:00:13\",\"level_default\":\"yes\"}', '2019-03-25 14:00:13', 'yes', 1),
(4, 'customer', 'main,profile', '{\"level_module\":\"main,profile\",\"level_stamp\":\"2019-03-23 15:20:19\"}', '2019-03-23 12:20:19', 'no', 1);

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
  `setting_value` longtext NOT NULL,
  `setting_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `setting_default` varchar(5) DEFAULT 'yes',
  `setting_flg` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `setting_title`, `setting_value`, `setting_stamp`, `setting_default`, `setting_flg`) VALUES
(1, 'site_title', 'Core CMS Lite', '2019-03-22 14:55:22', 'yes', 1),
(2, 'site_slogan', 'Develop Faster, Easier and Modular ', '2018-11-23 14:19:36', 'yes', 1),
(3, 'theme_title', 'starter', '2018-11-23 14:19:36', 'yes', 1),
(4, 'site_status', 'online', '2018-12-17 08:52:06', 'yes', 1),
(5, 'offline_message', 'We are offline', '2018-12-17 08:50:58', 'yes', 1),
(6, 'current_url', 'title', '2018-12-17 17:54:02', 'yes', 1),
(7, 'mail_protocol', 'mail', '2018-12-17 15:57:54', 'yes', 1),
(8, 'smtp_host', '', '2018-12-17 15:24:08', 'yes', 1),
(9, 'smtp_user', '', '2018-12-17 15:24:29', 'yes', 1),
(10, 'smtp_pass', '', '2018-12-17 15:24:29', 'yes', 1),
(11, 'smtp_port', '25', '2018-12-17 15:27:45', 'yes', 1),
(12, 'smtp_timeout', '5', '2018-12-17 15:27:21', 'yes', 1),
(13, 'smtp_crypto', '', '2018-12-17 15:25:41', 'yes', 1),
(14, 'wordwrap', 'TRUE', '2018-12-17 15:27:10', 'yes', 1),
(15, 'wrapchars', '76', '2018-12-17 15:27:03', 'yes', 1),
(16, 'mailtype', 'text', '2018-12-17 15:26:56', 'yes', 1),
(17, 'charset', 'UTF-8', '2018-12-17 15:26:34', 'yes', 1),
(18, 'home_display', 'blog', '2018-12-17 17:24:53', 'yes', 1),
(19, 'home_post', 'latest_post', '2019-03-21 17:09:47', 'yes', 1),
(20, 'home_page', '', '2018-12-17 16:03:08', 'yes', 1),
(21, 'post_per_page', '10', '2018-12-17 16:11:11', 'yes', 1),
(22, 'post_show', 'summary', '2019-03-21 16:53:57', 'yes', 1),
(23, 'seo_visibility', 'noindex, nofollow', '2019-03-18 16:26:50', 'yes', 1),
(24, 'seo_global', 'any', '2019-03-18 16:37:13', 'yes', 1),
(25, 'seo_description ', '', '2018-12-17 16:09:31', 'yes', 1),
(26, 'seo_keywords', '', '2018-12-17 17:30:41', 'yes', 1),
(27, 'seo_meta_data', '', '2018-12-17 16:10:23', 'yes', 1),
(28, 'inheritance_data', 'default,category,tag', '2019-02-22 17:52:44', 'yes', 1),
(29, 'module_list', 'main,blog,page,autofield,control,inheritance,customfield,user,level,setting,profile,userdatas,customers', '2019-03-23 12:14:32', 'yes', 1),
(30, 'extension_menu', '{\"menu_path\":\"customers/menu\"}', '2019-05-14 09:35:58', 'yes', 1),
(31, 'field_menu', '{\"menu_path\":\"userdata/menu\"}', '2019-05-14 09:40:37', 'yes', 1);

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
  `user_email` varchar(50) NOT NULL,
  `user_details` longtext,
  `user_stamp` datetime NOT NULL,
  `user_default` varchar(5) DEFAULT 'yes',
  `user_flg` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_level`, `user_logname`, `user_password`, `user_name`, `user_email`, `user_details`, `user_stamp`, `user_default`, `user_flg`) VALUES
(1, 'admin', 'admin', '378590eaf2a7af7bddb831399b55824064d37f29', 'Apha 407', 'fastemail47@gmail.com', '{\"user_name\":\"Apha 407\",\"user_email\":\"fastemail47@gmail.com\",\"user_level\":\"admin\",\"user_password\":\"378590eaf2a7af7bddb831399b55824064d37f29\",\"user_stamp\":\"2019-05-09 14:19:41\",\"user_flg\":1,\"user_logname\":\"admin\"}', '2019-05-09 14:19:41', 'yes', 1);

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
  MODIFY `inheritance_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `level_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
