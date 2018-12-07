-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2018 at 07:22 PM
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
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `company_id` bigint(20) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `company_details` longtext,
  `company_stamp` datetime NOT NULL,
  `company_default` varchar(5) DEFAULT 'yes',
  `company_flg` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customfields`
--

CREATE TABLE `customfields` (
  `customfield_id` bigint(20) NOT NULL,
  `customfield_type` varchar(100) NOT NULL,
  `customfield_parent` varchar(200) NOT NULL,
  `customfield_child` longtext,
  `customfield_details` longtext,
  `customfield_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `customfield_default` varchar(5) DEFAULT 'no',
  `customfield_flg` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customfields`
--

INSERT INTO `customfields` (`customfield_id`, `customfield_type`, `customfield_parent`, `customfield_child`, `customfield_details`, `customfield_stamp`, `customfield_default`, `customfield_flg`) VALUES
(2, 'Categories', 'Category Name', '{\"sub_child_0\":\"Sub Category\"}', '{\"customfield_type\":\"Categories\",\"customfield_parent\":\"Category Name\",\"customfield_child\":\"{\\\"sub_child_0\\\":\\\"Sub Category\\\"}\",\"customfield_stamp\":\"2018-11-26 19:35:17\",\"customfield_flg\":1}', '2018-11-28 11:14:35', 'yes', 1),
(3, 'Location', 'Country', '{\"sub_child_0\":\"City\"}', '{\"customfield_type\":\"Location\",\"customfield_parent\":\"Country\",\"customfield_child\":\"{\\\"sub_child_0\\\":\\\"City\\\"}\",\"customfield_stamp\":\"2018-11-29 18:57:16\",\"customfield_flg\":1}', '2018-11-29 15:57:16', 'no', 1),
(5, 'Lists Range', 'Range Name', '{\"sub_child_0\":\"Range List\"}', '{\"customfield_type\":\"Lists Range\",\"customfield_parent\":\"Range Name\",\"customfield_child\":\"{\\\"sub_child_0\\\":\\\"Range List\\\"}\",\"customfield_stamp\":\"2018-12-03 19:09:38\",\"customfield_flg\":1}', '2018-12-03 16:09:38', 'no', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fieldcustoms`
--

CREATE TABLE `fieldcustoms` (
  `fieldcustom_id` bigint(20) NOT NULL,
  `fieldcustom_group` varchar(200) NOT NULL,
  `fieldcustom_type` varchar(200) NOT NULL,
  `fieldcustom_parent` varchar(200) NOT NULL,
  `fieldcustom_child` longtext,
  `fieldcustom_details` longtext,
  `fieldcustom_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fieldcustom_default` varchar(5) DEFAULT 'yes',
  `fieldcustom_flg` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fieldcustoms`
--

INSERT INTO `fieldcustoms` (`fieldcustom_id`, `fieldcustom_group`, `fieldcustom_type`, `fieldcustom_parent`, `fieldcustom_child`, `fieldcustom_details`, `fieldcustom_stamp`, `fieldcustom_default`, `fieldcustom_flg`) VALUES
(13, 'Finace Category', 'Categories', 'Finance', '{\"sub_category\":[\"Mortage\",\"NGo\\\\\'s\",\"Pension\\\\r\\\\nKenya\"]}', '{\"fieldcustom_type\":\"Categories\",\"fieldcustom_group\":\"Finace Category\",\"fieldcustom_parent\":\"Finance\",\"fieldcustom_child\":\"{\\\"sub_category\\\":[\\\"Mortage\\\",\\\"NGo\\\\\\\\\'s\\\",\\\"Pension\\\\\\\\r\\\\\\\\nKenya\\\"]}\",\"fieldcustom_stamp\":\"2018-11-29 09:28:14\",\"fieldcustom_flg\":1}', '2018-11-29 06:28:14', 'yes', 1),
(14, 'Tradesmaship Category', 'Categories', 'Tradesmaship ', '{\"sub_category\":[\"Plumbing\",\"Handyman\",\"Rooding\"]}', '{\"fieldcustom_type\":\"Categories\",\"fieldcustom_group\":\"Tradesmaship Category\",\"fieldcustom_parent\":\"Tradesmaship \",\"fieldcustom_child\":\"{\\\"sub_category\\\":[\\\"Plumbing\\\",\\\"Handyman\\\",\\\"Rooding\\\"]}\",\"fieldcustom_stamp\":\"2018-11-29 09:15:05\",\"fieldcustom_flg\":1}', '2018-11-29 06:15:05', 'yes', 1),
(15, 'Kenya Location', 'Location', 'Kenya', '{\"city\":[\"Nairobi\",\"Mombasa\",\"Nakuru\",\"Kisii\"]}', '{\"fieldcustom_type\":\"Location\",\"fieldcustom_group\":\"Kenya Location\",\"fieldcustom_parent\":\"Kenya\",\"fieldcustom_child\":\"{\\\"city\\\":[\\\"Nairobi\\\",\\\"Mombasa\\\",\\\"Nakuru\\\",\\\"Kisii\\\"]}\",\"fieldcustom_stamp\":\"2018-11-29 19:22:25\",\"fieldcustom_flg\":1}', '2018-11-29 16:22:25', 'yes', 1),
(16, 'Employee Range', 'Lists Range', 'Employee', '{\"range\":[\"1-5\",\"6-10\",\"11-15\",\"16-20\",\"21-30\",\"30-35\",\"36-40\",\"41-45\",\"46-50\",\"50-100\",\"101-200\",\"201-500\",\"501-1000\",\"1001-5000\"]}', '{\"fieldcustom_type\":\"Lists Range\",\"fieldcustom_group\":\"Employee Range\",\"fieldcustom_parent\":\"Employee\",\"fieldcustom_child\":\"{\\\"range\\\":[\\\"1-5\\\",\\\"6-10\\\",\\\"11-15\\\",\\\"16-20\\\",\\\"21-30\\\",\\\"30-35\\\",\\\"36-40\\\",\\\"41-45\\\",\\\"46-50\\\",\\\"50-100\\\",\\\"101-200\\\",\\\"201-500\\\",\\\"501-1000\\\",\\\"1001-5000\\\"]}\",\"fieldcustom_stamp\":\"2018-12-03 19:04:24\",\"fieldcustom_flg\":1}', '2018-12-03 16:04:24', 'yes', 1);

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `level_id` bigint(20) NOT NULL,
  `level_name` varchar(20) NOT NULL,
  `level_module` varchar(500) NOT NULL,
  `level_details` longtext,
  `level_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `level_default` varchar(5) DEFAULT 'yes',
  `level_flg` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`level_id`, `level_name`, `level_module`, `level_details`, `level_stamp`, `level_default`, `level_flg`) VALUES
(1, 'admin', 'main,user,setting,company', NULL, '2018-11-28 11:40:40', 'yes', 1),
(2, 'customer', 'company', NULL, '2018-11-28 11:40:49', 'no', 1);

-- --------------------------------------------------------

--
-- Table structure for table `listinglists`
--

CREATE TABLE `listinglists` (
  `listinglist_id` bigint(20) NOT NULL,
  `listinglist_title` varchar(500) NOT NULL,
  `listinglist_filters` varchar(2000) DEFAULT NULL,
  `listinglist_data` longtext,
  `listinglist_show` varchar(500) DEFAULT 'public',
  `listinglist_details` longtext,
  `listinglist_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `listinglist_default` varchar(5) DEFAULT 'yes',
  `listinglist_flg` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `listinglists`
--

INSERT INTO `listinglists` (`listinglist_id`, `listinglist_title`, `listinglist_filters`, `listinglist_data`, `listinglist_show`, `listinglist_details`, `listinglist_stamp`, `listinglist_default`, `listinglist_flg`) VALUES
(7, 'Companies', '[\"categories\",\"sub_categories\"]', '{\"customer_name\":\"17\",\"company_name\":\"Smart Web Kenya LTD\",\"city\":\"0\",\"address\":\"View Park Towers 13th Floor Suite 5\",\"phone\":\"0712269110\",\"description\":\"We design Website, Android App and systems\",\"employees\":\"0\",\"establishment_year\":\"2013\",\"categories\":\"Finance\",\"mobile\":\"0708 549110\",\"fax\":\"\",\"website\":\"www.smartwebkenya.co.ke\",\"e_mail\":\"info@smartwebkenya.com\",\"registration_code\":\"\",\"vat_registration\":\"\",\"company_manager\":\"Dean Achesa\",\"week_days_working_hours\":\"7.00 am - 6.30 pm\",\"saturday_working_hours\":\"11.00 am - 3.00 pm\",\"sunday_working_hours\":\"Closed\",\"holidays_working_hours\":\"Closed\",\"keywords\":\"Web Design, Android App, Logo Design, System Design \",\"location\":\"0\"}', 'public', '{\"listinglist_data\":\"{\\\"customer_name\\\":\\\"17\\\",\\\"company_name\\\":\\\"Smart Web Kenya LTD\\\",\\\"city\\\":\\\"0\\\",\\\"address\\\":\\\"View Park Towers 13th Floor Suite 5\\\",\\\"phone\\\":\\\"0712269110\\\",\\\"description\\\":\\\"We design Website, Android App and systems\\\",\\\"employees\\\":\\\"0\\\",\\\"establishment_year\\\":\\\"2013\\\",\\\"categories\\\":\\\"Finance\\\",\\\"mobile\\\":\\\"0708 549110\\\",\\\"fax\\\":\\\"\\\",\\\"website\\\":\\\"www.smartwebkenya.co.ke\\\",\\\"e_mail\\\":\\\"info@smartwebkenya.com\\\",\\\"registration_code\\\":\\\"\\\",\\\"vat_registration\\\":\\\"\\\",\\\"company_manager\\\":\\\"Dean Achesa\\\",\\\"week_days_working_hours\\\":\\\"7.00 am - 6.30 pm\\\",\\\"saturday_working_hours\\\":\\\"11.00 am - 3.00 pm\\\",\\\"sunday_working_hours\\\":\\\"Closed\\\",\\\"holidays_working_hours\\\":\\\"Closed\\\",\\\"keywords\\\":\\\"Web Design, Android App, Logo Design, System Design \\\",\\\"location\\\":\\\"0\\\"}\",\"listinglist_filters\":\"[\\\"categories\\\",\\\"sub_categories\\\"]\",\"listinglist_title\":\"Companies\",\"listinglist_stamp\":\"2018-12-03 19:52:46\",\"listinglist_flg\":1}', '2018-12-03 16:52:46', 'yes', 1),
(8, 'Companies', '[\"categories\",\"sub_categories\"]', '{\"id\":\"8\",\"customer_name\":\"10\",\"company_name\":\"Ray Asparation\",\"city\":\"1\",\"address\":\"Chalinze Offices Suite 101\",\"phone\":\"0723889910\",\"description\":\"Asparation For Finance\",\"employees\":\"3\",\"establishment_year\":\"2018\",\"categories\":\"Tradesmaship\",\"sub_categories\":[\"Plumbing\",\"Rooding\"],\"mobile\":\"0720889123\",\"fax\":\"880-912-A01\",\"website\":\"www.ray.com\",\"e_mail\":\"info@ray.com\",\"registration_code\":\"809912\",\"vat_registration\":\"\",\"company_manager\":\"Ray Mkindo\",\"week_days_working_hours\":\"8.00 am - 8.00 pm\",\"saturday_working_hours\":\"Closed\",\"sunday_working_hours\":\"Closed\",\"holidays_working_hours\":\"Closed\",\"keywords\":\"Finance, Forex, Money, Crypto\",\"location\":\"1\"}', 'public', '{\"listinglist_data\":\"{\\\"id\\\":\\\"8\\\",\\\"customer_name\\\":\\\"10\\\",\\\"company_name\\\":\\\"Ray Asparation\\\",\\\"city\\\":\\\"1\\\",\\\"address\\\":\\\"Chalinze Offices Suite 101\\\",\\\"phone\\\":\\\"0723889910\\\",\\\"description\\\":\\\"Asparation For Finance\\\",\\\"employees\\\":\\\"3\\\",\\\"establishment_year\\\":\\\"2018\\\",\\\"categories\\\":\\\"Tradesmaship\\\",\\\"sub_categories\\\":[\\\"Plumbing\\\",\\\"Rooding\\\"],\\\"mobile\\\":\\\"0720889123\\\",\\\"fax\\\":\\\"880-912-A01\\\",\\\"website\\\":\\\"www.ray.com\\\",\\\"e_mail\\\":\\\"info@ray.com\\\",\\\"registration_code\\\":\\\"809912\\\",\\\"vat_registration\\\":\\\"\\\",\\\"company_manager\\\":\\\"Ray Mkindo\\\",\\\"week_days_working_hours\\\":\\\"8.00 am - 8.00 pm\\\",\\\"saturday_working_hours\\\":\\\"Closed\\\",\\\"sunday_working_hours\\\":\\\"Closed\\\",\\\"holidays_working_hours\\\":\\\"Closed\\\",\\\"keywords\\\":\\\"Finance, Forex, Money, Crypto\\\",\\\"location\\\":\\\"1\\\"}\",\"listinglist_filters\":\"[\\\"categories\\\",\\\"sub_categories\\\"]\",\"listinglist_title\":\"Companies\",\"listinglist_stamp\":\"2018-12-04 08:20:14\",\"listinglist_flg\":1}', '2018-12-04 05:20:14', 'yes', 1),
(9, 'Companies', '[\"categories\",\"sub_categories\"]', '{\"customer_name\":\"17\",\"company_name\":\"Smart Art Kenya\",\"city\":\"2\",\"address\":\"Kenya Arts\",\"phone\":\"0755234712\",\"description\":\"Kenya Art Center\",\"employees\":\"9\",\"establishment_year\":\"2010\",\"categories\":\"Tradesmaship\",\"sub_categories\":[\"Rooding\"],\"mobile\":\"\",\"fax\":\"\",\"website\":\"\",\"e_mail\":\"\",\"registration_code\":\"\",\"vat_registration\":\"\",\"company_manager\":\"\",\"week_days_working_hours\":\"\",\"saturday_working_hours\":\"\",\"sunday_working_hours\":\"\",\"holidays_working_hours\":\"\",\"keywords\":\"\",\"location\":\"2\"}', 'public', '{\"listinglist_data\":\"{\\\"customer_name\\\":\\\"17\\\",\\\"company_name\\\":\\\"Smart Art Kenya\\\",\\\"city\\\":\\\"2\\\",\\\"address\\\":\\\"Kenya Arts\\\",\\\"phone\\\":\\\"0755234712\\\",\\\"description\\\":\\\"Kenya Art Center\\\",\\\"employees\\\":\\\"9\\\",\\\"establishment_year\\\":\\\"2010\\\",\\\"categories\\\":\\\"Tradesmaship\\\",\\\"sub_categories\\\":[\\\"Rooding\\\"],\\\"mobile\\\":\\\"\\\",\\\"fax\\\":\\\"\\\",\\\"website\\\":\\\"\\\",\\\"e_mail\\\":\\\"\\\",\\\"registration_code\\\":\\\"\\\",\\\"vat_registration\\\":\\\"\\\",\\\"company_manager\\\":\\\"\\\",\\\"week_days_working_hours\\\":\\\"\\\",\\\"saturday_working_hours\\\":\\\"\\\",\\\"sunday_working_hours\\\":\\\"\\\",\\\"holidays_working_hours\\\":\\\"\\\",\\\"keywords\\\":\\\"\\\",\\\"location\\\":\\\"2\\\"}\",\"listinglist_filters\":\"[\\\"categories\\\",\\\"sub_categories\\\"]\",\"listinglist_title\":\"Companies\",\"listinglist_stamp\":\"2018-12-04 09:57:18\",\"listinglist_flg\":1}', '2018-12-04 06:57:18', 'yes', 1),
(10, 'Products', '[\"company\",\"product_name\",\"price\"]', '{\"id\":\"10\",\"company\":\"7\",\"product_name\":\"Web Design\",\"price\":\"4000 KSH\",\"description\":\"Design Logo With Ease 2\",\"photos\":\"[\\\"assets\\\\\\/admin\\\\\\/images\\\\\\/upload\\\\\\/listing\\\\\\/products\\\\\\/8d648ba165d748b17895ba0a73d58b7e.jpg\\\"]\"}', 'public', '{\"listinglist_data\":\"{\\\"id\\\":\\\"10\\\",\\\"company\\\":\\\"7\\\",\\\"product_name\\\":\\\"Web Design\\\",\\\"price\\\":\\\"4000 KSH\\\",\\\"description\\\":\\\"Design Logo With Ease 2\\\",\\\"photos\\\":\\\"[\\\\\\\"assets\\\\\\\\\\\\\\/admin\\\\\\\\\\\\\\/images\\\\\\\\\\\\\\/upload\\\\\\\\\\\\\\/listing\\\\\\\\\\\\\\/products\\\\\\\\\\\\\\/8d648ba165d748b17895ba0a73d58b7e.jpg\\\\\\\"]\\\"}\",\"listinglist_filters\":\"[\\\"company\\\",\\\"product_name\\\",\\\"price\\\"]\",\"listinglist_title\":\"Products\",\"listinglist_stamp\":\"2018-12-04 16:42:31\",\"listinglist_flg\":1}', '2018-12-04 13:42:31', 'yes', 1),
(11, 'Products', '[\"company\",\"product_name\",\"price\"]', '{\"id\":\"11\",\"company\":\"8\",\"product_name\":\"Book H2\",\"price\":\"15,000 KSH\",\"description\":\"Inspiration Book 55\",\"photos\":\"\\\"null\\\"\"}', 'public', '{\"listinglist_data\":\"{\\\"id\\\":\\\"11\\\",\\\"company\\\":\\\"8\\\",\\\"product_name\\\":\\\"Book H2\\\",\\\"price\\\":\\\"15,000 KSH\\\",\\\"description\\\":\\\"Inspiration Book 55\\\",\\\"photos\\\":\\\"\\\\\\\"null\\\\\\\"\\\"}\",\"listinglist_filters\":\"[\\\"company\\\",\\\"product_name\\\",\\\"price\\\"]\",\"listinglist_title\":\"Products\",\"listinglist_stamp\":\"2018-12-04 16:42:31\",\"listinglist_flg\":1}', '2018-12-04 13:42:31', 'yes', 1),
(12, 'Products', '[\"company\",\"product_name\",\"price\"]', '{\"company\":\"8\",\"product_name\":\"Hapa Hapa\",\"price\":\"800\",\"description\":\"Hapa kenya\",\"photos\":\"[\\\"assets\\\\\\/admin\\\\\\/images\\\\\\/upload\\\\\\/listing\\\\\\/products\\\\\\/d339c33276a5d3cc2c4c988134b10501.jpg\\\",\\\"assets\\\\\\/admin\\\\\\/images\\\\\\/upload\\\\\\/listing\\\\\\/products\\\\\\/8165348f051514b1342c11c3ba61f039.jpg\\\",\\\"assets\\\\\\/admin\\\\\\/images\\\\\\/upload\\\\\\/listing\\\\\\/products\\\\\\/f8336eb9aa2068f7c2286eb859788737.jpg\\\",\\\"assets\\\\\\/admin\\\\\\/images\\\\\\/upload\\\\\\/listing\\\\\\/products\\\\\\/9d9cf1f22314abef9250362a6edd9c47.jpg\\\"]\"}', 'public', '{\"listinglist_data\":\"{\\\"company\\\":\\\"8\\\",\\\"product_name\\\":\\\"Hapa Hapa\\\",\\\"price\\\":\\\"800\\\",\\\"description\\\":\\\"Hapa kenya\\\",\\\"photos\\\":\\\"[\\\\\\\"assets\\\\\\\\\\\\\\/admin\\\\\\\\\\\\\\/images\\\\\\\\\\\\\\/upload\\\\\\\\\\\\\\/listing\\\\\\\\\\\\\\/products\\\\\\\\\\\\\\/d339c33276a5d3cc2c4c988134b10501.jpg\\\\\\\",\\\\\\\"assets\\\\\\\\\\\\\\/admin\\\\\\\\\\\\\\/images\\\\\\\\\\\\\\/upload\\\\\\\\\\\\\\/listing\\\\\\\\\\\\\\/products\\\\\\\\\\\\\\/8165348f051514b1342c11c3ba61f039.jpg\\\\\\\",\\\\\\\"assets\\\\\\\\\\\\\\/admin\\\\\\\\\\\\\\/images\\\\\\\\\\\\\\/upload\\\\\\\\\\\\\\/listing\\\\\\\\\\\\\\/products\\\\\\\\\\\\\\/f8336eb9aa2068f7c2286eb859788737.jpg\\\\\\\",\\\\\\\"assets\\\\\\\\\\\\\\/admin\\\\\\\\\\\\\\/images\\\\\\\\\\\\\\/upload\\\\\\\\\\\\\\/listing\\\\\\\\\\\\\\/products\\\\\\\\\\\\\\/9d9cf1f22314abef9250362a6edd9c47.jpg\\\\\\\"]\\\"}\",\"listinglist_filters\":\"[\\\"company\\\",\\\"product_name\\\",\\\"price\\\"]\",\"listinglist_title\":\"Products\",\"listinglist_stamp\":\"2018-12-04 16:42:31\",\"listinglist_flg\":1}', '2018-12-04 13:42:31', 'yes', 1),
(16, 'Logos', '[\"company\"]', '{\"id\":\"16\",\"company\":\"8\",\"logo\":\"[\\\"assets\\\\\\/admin\\\\\\/images\\\\\\/upload\\\\\\/listing\\\\\\/logos\\\\\\/4fb96dc498d0f2d113c32fc25d709ba5.png\\\"]\"}', 'public', '{\"listinglist_data\":\"{\\\"id\\\":\\\"16\\\",\\\"company\\\":\\\"8\\\",\\\"logo\\\":\\\"[\\\\\\\"assets\\\\\\\\\\\\\\/admin\\\\\\\\\\\\\\/images\\\\\\\\\\\\\\/upload\\\\\\\\\\\\\\/listing\\\\\\\\\\\\\\/logos\\\\\\\\\\\\\\/4fb96dc498d0f2d113c32fc25d709ba5.png\\\\\\\"]\\\"}\",\"listinglist_filters\":\"[\\\"company\\\"]\",\"listinglist_title\":\"Logos\",\"listinglist_stamp\":\"2018-12-04 18:42:17\",\"listinglist_flg\":1}', '2018-12-04 15:42:17', 'yes', 1);

-- --------------------------------------------------------

--
-- Table structure for table `listings`
--

CREATE TABLE `listings` (
  `listing_id` bigint(20) NOT NULL,
  `listing_title` varchar(500) NOT NULL,
  `listing_required` varchar(2000) DEFAULT NULL,
  `listing_optional` longtext,
  `listing_filters` longtext,
  `listing_show` varchar(20) DEFAULT 'admin',
  `listing_details` longtext,
  `listing_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `listing_default` varchar(5) DEFAULT 'no',
  `listing_flg` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `listings`
--

INSERT INTO `listings` (`listing_id`, `listing_title`, `listing_required`, `listing_optional`, `listing_filters`, `listing_show`, `listing_details`, `listing_stamp`, `listing_default`, `listing_flg`) VALUES
(1, 'Companies', '[\"Customer Name\",\"Company Name\",\"City\",\"Address\",\"Phone \",\"Description\",\"Employees \",\"Establishment Year\",\"Categories\",\"Sub Categories\"]', '[\"Mobile\",\"Fax\",\"Website\",\"E-mail\",\"Registration code\",\"VAT Registration\",\"Company manager\",\"Week Days Working Hours\",\"Saturday Working Hours\",\"Sunday Working Hours\",\"Holidays Working Hours\",\"Keywords\",\"Location\"]', '[\"categories\",\"sub_categories\"]', 'admin', '{\"listing_title\":\"Companies Details\",\"listing_required\":\"[\\\"Customer Name\\\",\\\"Company Name\\\",\\\"City\\\",\\\"Address\\\",\\\"Phone \\\",\\\"Description\\\",\\\"Employees \\\",\\\"Establishment Year\\\",\\\"Categories\\\",\\\"Sub Categories\\\"]\",\"listing_optional\":\"[\\\"Mobile\\\",\\\"Fax\\\",\\\"Website\\\",\\\"E-mail\\\",\\\"Registration code\\\",\\\"VAT Registration\\\",\\\"Company manager\\\",\\\"Week Days Working Hours\\\",\\\"Saturday Working Hours\\\",\\\"Sunday Working Hours\\\",\\\"Holidays Working Hours\\\",\\\"Keywords\\\",\\\"Location\\\"]\",\"listing_stamp\":\"2018-11-29 18:32:15\",\"listing_flg\":1,\"listing_filters\":\"[\\\"categories\\\",\\\"sub_categories\\\"]\",\"listing_default\":\"yes\"}', '2018-11-29 15:32:15', 'yes', 1),
(2, 'Products', '[\"Company\",\" Product Name\",\"Price\"]', '[\"Description\",\"Photos\"]', '[\"company\",\"product_name\",\"price\"]', 'admin', '{\"listing_title\":\"Products\",\"listing_required\":\"[\\\"Company\\\",\\\" Product Name\\\",\\\"Price\\\"]\",\"listing_optional\":\"[\\\"Description\\\",\\\"Photos\\\"]\",\"listing_stamp\":\"2018-12-04 09:29:12\",\"listing_flg\":1,\"listing_filters\":\"[\\\"company\\\",\\\"product_name\\\",\\\"price\\\"]\",\"listing_default\":\"yes\"}', '2018-12-04 06:29:12', 'yes', 1),
(4, 'Employees', '[\"First Name\",\"Sir Name\",\"Job Title\"]', '[\"Email\",\"Phone\",\"Photo\"]', NULL, 'admin', '{\"listing_title\":\"Employees\",\"listing_required\":\"[\\\"First Name\\\",\\\"Sir Name\\\",\\\"Job Title\\\"]\",\"listing_optional\":\"[\\\"Email\\\",\\\"Phone\\\",\\\"Photo\\\"]\",\"listing_stamp\":\"2018-11-29 18:45:14\",\"listing_flg\":1}', '2018-11-29 15:45:14', 'no', 1),
(5, 'Jobs', '[\"Title\",\"Type\",\"Description\"]', '[\"Duties\",\"Skills\"]', NULL, 'admin', '{\"listing_title\":\"Jobs\",\"listing_required\":\"[\\\"Title\\\",\\\"Type\\\",\\\"Description\\\"]\",\"listing_optional\":\"[\\\"Duties\\\",\\\"Skills\\\"]\",\"listing_stamp\":\"2018-11-29 18:46:49\",\"listing_flg\":1}', '2018-11-29 15:46:49', 'no', 1),
(6, 'Logos', '[\"Company\",\"Logo\"]', '\"\"', '[\"company\"]', 'admin', '{\"listing_title\":\"Company Logo\",\"listing_required\":\"[\\\"Company\\\",\\\"Logo\\\"]\",\"listing_optional\":\"\\\"\\\"\",\"listing_stamp\":\"2018-12-04 19:40:58\",\"listing_flg\":1,\"listing_filters\":\"[\\\"company\\\"]\",\"listing_default\":\"yes\"}', '2018-12-04 16:40:58', 'yes', 1);

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
(1, 'site_title', 'Core Lite Version 1.0', '2018-11-23 14:19:36', 'yes', 1),
(2, 'site_slogan', 'Develop Faster, Easier and Modular ', '2018-11-23 14:19:36', 'yes', 1),
(3, 'theme_title', 'starter', '2018-11-23 14:19:36', 'yes', 1),
(4, 'site_status', 'online', '2018-11-23 14:19:36', 'yes', 1);

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
(1, 'admin', 'admin', '378590eaf2a7af7bddb831399b55824064d37f29', 'Apha 407', 'fastemail47@gmail.com', '{\"user_name\":\"Apha 407\",\"user_email\":\"fastemail47@gmail.com\",\"user_level\":\"admin\",\"user_password\":\"378590eaf2a7af7bddb831399b55824064d37f29\",\"user_stamp\":\"2018-11-28 18:53:36\",\"user_flg\":1}', '2018-11-28 18:53:36', 'yes', 1),
(2, 'admin', 'wayua', 'cfddcc5c0e6dfb1ccf18d32190c2e7e5a5f054de', 'Wayua', 'wayua@gmail.com', '{\"user_name\":\"Wayua\",\"user_email\":\"wayua@gmail.com\",\"user_level\":\"admin\",\"user_password\":\"cfddcc5c0e6dfb1ccf18d32190c2e7e5a5f054de\",\"user_stamp\":\"2018-11-23 16:25:29\"}', '2018-11-23 16:25:29', 'yes', 1),
(10, 'customer', 'mkindo', '378590eaf2a7af7bddb831399b55824064d37f29', 'Ray Mkindo ', 'mkindo2@gmail.com', '{\"user_name\":\"Ray Mkindo \",\"user_email\":\"mkindo2@gmail.com\",\"user_level\":\"customer\",\"user_logname\":\"mkindo\",\"user_password\":\"378590eaf2a7af7bddb831399b55824064d37f29\",\"user_stamp\":\"2018-11-23 18:30:35\",\"user_flg\":1}', '2018-11-23 18:30:35', 'yes', 1),
(17, 'customer', 'achesa', '378590eaf2a7af7bddb831399b55824064d37f29', 'achesa', 'achesac@gmail.com', '{\"user_name\":\"achesa\",\"user_email\":\"achesac@gmail.com\",\"user_level\":\"customer\",\"user_logname\":\"achesa\",\"user_password\":\"378590eaf2a7af7bddb831399b55824064d37f29\",\"user_stamp\":\"2018-11-29 12:12:35\",\"user_flg\":1}', '2018-11-29 12:12:35', 'yes', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `customfields`
--
ALTER TABLE `customfields`
  ADD PRIMARY KEY (`customfield_id`);

--
-- Indexes for table `fieldcustoms`
--
ALTER TABLE `fieldcustoms`
  ADD PRIMARY KEY (`fieldcustom_id`),
  ADD KEY `fieldcustom_group` (`fieldcustom_group`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`level_id`);

--
-- Indexes for table `listinglists`
--
ALTER TABLE `listinglists`
  ADD PRIMARY KEY (`listinglist_id`);

--
-- Indexes for table `listings`
--
ALTER TABLE `listings`
  ADD PRIMARY KEY (`listing_id`),
  ADD UNIQUE KEY `listing_title` (`listing_title`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`,`user_email`),
  ADD KEY `user_level` (`user_level`),
  ADD KEY `user_logname` (`user_logname`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `company_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customfields`
--
ALTER TABLE `customfields`
  MODIFY `customfield_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `fieldcustoms`
--
ALTER TABLE `fieldcustoms`
  MODIFY `fieldcustom_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `level_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `listinglists`
--
ALTER TABLE `listinglists`
  MODIFY `listinglist_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `listings`
--
ALTER TABLE `listings`
  MODIFY `listing_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
