-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2019 at 05:59 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `morawakazeo`
--

-- --------------------------------------------------------

--
-- Table structure for table `alert_category_tbl`
--

CREATE TABLE IF NOT EXISTS `alert_category_tbl` (
  `alert_cat_id` tinyint(5) NOT NULL AUTO_INCREMENT,
  `alert_category` varchar(256) COLLATE utf8_sinhala_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`alert_cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `alert_category_tbl`
--

INSERT INTO `alert_category_tbl` (`alert_cat_id`, `alert_category`, `date_added`, `date_updated`, `is_deleted`) VALUES
(1, 'Physical Resource', '2018-02-22 10:10:25', '2018-02-22 10:10:25', 0);

-- --------------------------------------------------------

--
-- Table structure for table `alert_tbl`
--

CREATE TABLE IF NOT EXISTS `alert_tbl` (
  `alert_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `alert_cat_id` tinyint(4) NOT NULL,
  `alert_desc` varchar(256) COLLATE utf8_sinhala_ci NOT NULL,
  `by_whom` varchar(256) COLLATE utf8_sinhala_ci NOT NULL,
  `to_whom` varchar(256) COLLATE utf8_sinhala_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `when_read` datetime NOT NULL,
  PRIMARY KEY (`alert_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `alert_tbl`
--

INSERT INTO `alert_tbl` (`alert_id`, `alert_cat_id`, `alert_desc`, `by_whom`, `to_whom`, `date_added`, `date_updated`, `is_deleted`, `is_read`, `when_read`) VALUES
(6, 1, '15 physical resource item details to be updated', 'System', '07065', '2018-03-28 09:04:38', '2019-12-02 23:34:45', 0, 1, '2019-10-30 07:37:23'),
(7, 1, '18 physical resource item details to be updated', 'System', '07002', '2018-03-28 10:16:44', '2019-12-02 23:34:44', 0, 0, '0000-00-00 00:00:00'),
(8, 1, '22 physical resource item details to be updated', 'System', '07017', '2018-03-28 10:16:44', '2019-12-02 23:34:45', 0, 0, '0000-00-00 00:00:00'),
(9, 1, '20 physical resource item details to be updated', 'System', '07041', '2018-03-28 10:16:44', '2019-12-02 23:34:45', 0, 0, '0000-00-00 00:00:00'),
(10, 1, '13 physical resource item details to be updated', 'System', '07027', '2018-03-28 10:16:44', '2019-12-02 23:34:45', 0, 1, '2019-11-04 00:25:04'),
(11, 1, '22 physical resource item details to be updated', 'System', '07029', '2018-03-28 10:16:44', '2019-12-02 23:34:45', 0, 0, '0000-00-00 00:00:00'),
(12, 1, '22 physical resource item details to be updated', 'System', '07057', '2018-03-28 10:16:44', '2019-12-02 23:34:45', 0, 0, '0000-00-00 00:00:00'),
(13, 1, '21 physical resource item details to be updated', 'System', '07004', '2018-03-28 10:16:44', '2019-12-02 23:34:44', 0, 1, '2018-03-29 12:53:27'),
(14, 1, '21 physical resource item details to be updated', 'System', '07001', '2018-03-28 10:16:44', '2019-12-02 23:34:45', 0, 0, '0000-00-00 00:00:00'),
(15, 1, '22 physical resource item details to be updated', 'System', '07407', '2018-03-28 10:16:44', '2019-12-02 23:34:45', 0, 0, '0000-00-00 00:00:00'),
(16, 1, '22 physical resource item details to be updated', 'System', '07022', '2018-03-28 10:16:44', '2019-12-02 23:34:45', 0, 0, '0000-00-00 00:00:00'),
(17, 1, '23 physical resource item details to be updated', 'System', '07055', '2018-03-28 10:16:44', '2019-12-02 23:34:45', 0, 0, '0000-00-00 00:00:00'),
(18, 1, '23 physical resource item details to be updated', 'System', '07058', '2018-03-28 10:16:44', '2019-12-02 23:34:45', 0, 0, '0000-00-00 00:00:00'),
(19, 1, '23 physical resource item details to be updated', 'System', '07064', '2018-10-14 17:22:03', '2019-12-02 23:34:45', 0, 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `building_category_floor_tbl`
--

CREATE TABLE IF NOT EXISTS `building_category_floor_tbl` (
  `b_cat_floor_id` int(11) NOT NULL AUTO_INCREMENT,
  `b_cat_id` int(3) NOT NULL,
  `b_floor_id` int(3) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`b_cat_floor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `building_category_floor_tbl`
--

INSERT INTO `building_category_floor_tbl` (`b_cat_floor_id`, `b_cat_id`, `b_floor_id`, `date_added`, `date_updated`, `is_deleted`) VALUES
(1, 1, 1, '2018-05-08 13:36:38', '2018-05-08 13:36:38', 0),
(2, 1, 2, '2018-05-08 13:36:38', '2018-05-08 13:36:38', 0),
(3, 1, 3, '2018-05-08 13:36:38', '2018-05-08 13:36:38', 0),
(4, 2, 1, '2018-05-08 13:36:38', '2018-05-08 13:36:38', 0),
(5, 2, 2, '2018-05-08 13:36:38', '2018-05-08 13:36:38', 0),
(6, 2, 3, '2018-05-08 13:36:38', '2018-05-08 13:36:38', 0);

-- --------------------------------------------------------

--
-- Table structure for table `building_category_tbl`
--

CREATE TABLE IF NOT EXISTS `building_category_tbl` (
  `b_cat_id` int(3) NOT NULL AUTO_INCREMENT,
  `b_cat_name` varchar(60) COLLATE utf8_sinhala_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`b_cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `building_category_tbl`
--

INSERT INTO `building_category_tbl` (`b_cat_id`, `b_cat_name`, `date_added`, `date_updated`, `is_deleted`) VALUES
(1, 'පංති කාමර ගොඩනැඟිලි', '2018-05-08 06:20:21', '2018-05-08 06:20:21', 0),
(2, 'විශේෂ ගොඩනැඟිලි', '2018-05-08 05:17:22', '2018-05-08 05:17:22', 0);

-- --------------------------------------------------------

--
-- Table structure for table `building_floor_tbl`
--

CREATE TABLE IF NOT EXISTS `building_floor_tbl` (
  `b_floor_id` int(3) NOT NULL AUTO_INCREMENT,
  `b_floor` varchar(15) COLLATE utf8_sinhala_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`b_floor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `building_floor_tbl`
--

INSERT INTO `building_floor_tbl` (`b_floor_id`, `b_floor`, `date_added`, `date_updated`, `is_deleted`) VALUES
(1, 'තනි මහල්', '2018-05-08 08:22:23', '2018-05-08 08:22:23', 0),
(2, 'දෙමහල්', '2018-05-08 05:26:31', '2018-05-08 05:26:31', 0),
(3, 'තෙමහල්', '2018-05-08 06:20:24', '2018-05-08 06:20:24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `building_info_tbl`
--

CREATE TABLE IF NOT EXISTS `building_info_tbl` (
  `b_info_id` int(11) NOT NULL AUTO_INCREMENT,
  `census_id` varchar(5) COLLATE utf8_sinhala_ci NOT NULL,
  `b_cat_floor_id` int(11) NOT NULL,
  `b_size_id` int(3) NOT NULL,
  `b_usage_id` int(3) NOT NULL,
  `donated_by` varchar(60) COLLATE utf8_sinhala_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`b_info_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=36 ;

--
-- Dumping data for table `building_info_tbl`
--

INSERT INTO `building_info_tbl` (`b_info_id`, `census_id`, `b_cat_floor_id`, `b_size_id`, `b_usage_id`, `donated_by`, `date_added`, `date_updated`, `is_deleted`) VALUES
(1, '07065', 1, 2, 3, 'අධ්‍යාපන අමාත්‍යාංශය', '2018-05-10 12:45:20', '2018-05-11 14:16:30', 0),
(3, '07065', 2, 0, 3, 'දක්ෂිණ පාය', '2018-05-10 13:53:12', '2018-05-11 14:29:46', 0),
(6, '07065', 4, 2, 2, '444444444', '2018-05-10 14:01:52', '2018-05-11 15:25:10', 0),
(8, '07065', 4, 4, 0, 'දකුණු පළාත් සභාව', '2018-05-11 11:28:54', '2018-05-11 11:28:54', 0),
(9, '07027', 3, 4, 0, 'olsdfsd', '2018-05-11 11:41:48', '2018-05-11 11:41:48', 0),
(10, '07065', 3, 4, 0, 'දකුණු පළාත් අධායපනපාරන්තුව', '2018-05-11 15:46:15', '2018-05-11 15:46:15', 0),
(14, '07065', 2, 4, 1, 'vvvvvv', '2018-05-11 16:01:58', '2018-05-11 16:01:58', 0),
(21, '07041', 3, 2, 3, 'ooooo', '2018-05-15 12:12:08', '2018-05-15 12:12:08', 0),
(27, '07017', 1, 2, 1, 'xdgvfvg', '2018-05-15 13:00:37', '2018-05-15 13:00:37', 0),
(28, '07065', 1, 2, 1, ',,,,,,,,,,', '2018-05-15 14:56:01', '2018-05-15 14:56:01', 0),
(29, '07065', 1, 2, 1, ',,,,,,,,,,', '2018-05-15 14:59:03', '2018-05-15 14:59:03', 0),
(30, '07065', 3, 2, 3, 'eeeeeeeeee', '2018-05-15 15:02:08', '2018-05-15 15:02:08', 0),
(31, '07065', 5, 2, 2, 'zzzzz', '2018-05-15 15:08:25', '2018-05-15 15:08:25', 0),
(32, '07065', 3, 3, 1, 'ttyrty', '2018-08-08 22:27:45', '2018-08-08 22:27:45', 0),
(33, '07027', 2, 2, 1, '23242', '2018-10-14 13:30:45', '2018-10-14 13:30:45', 0),
(34, '07027', 2, 3, 3, 'sddfg', '2018-10-14 13:31:21', '2018-10-14 13:31:21', 0),
(35, '07027', 4, 2, 1, '56557', '2018-10-14 13:35:37', '2018-10-14 13:35:37', 0);

-- --------------------------------------------------------

--
-- Table structure for table `building_repaired_tbl`
--

CREATE TABLE IF NOT EXISTS `building_repaired_tbl` (
  `b_repaired_id` int(11) NOT NULL AUTO_INCREMENT,
  `b_info_id` int(11) NOT NULL,
  `repaired_by` varchar(60) COLLATE utf8_sinhala_ci NOT NULL,
  `repaired_date` date NOT NULL,
  `description` text COLLATE utf8_sinhala_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`b_repaired_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `building_repaired_tbl`
--

INSERT INTO `building_repaired_tbl` (`b_repaired_id`, `b_info_id`, `repaired_by`, `repaired_date`, `description`, `date_added`, `date_updated`, `is_deleted`) VALUES
(1, 29, 'aaaaa', '2018-04-20', 'zszssdsdfs', '2018-05-15 14:59:03', '2018-05-15 14:59:03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `building_size_tbl`
--

CREATE TABLE IF NOT EXISTS `building_size_tbl` (
  `b_size_id` int(3) NOT NULL AUTO_INCREMENT,
  `length` float NOT NULL,
  `width` float NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`b_size_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `building_size_tbl`
--

INSERT INTO `building_size_tbl` (`b_size_id`, `length`, `width`, `date_added`, `date_updated`, `is_deleted`) VALUES
(1, 24.384, 6.096, '2018-05-08 13:44:27', '2018-05-08 13:44:27', 0),
(2, 24.384, 4.572, '2018-05-08 13:44:27', '2018-05-08 13:44:27', 0),
(3, 8, 6, '2018-05-11 11:19:58', '2018-05-11 11:19:58', 0),
(4, 30, 20, '2018-05-11 11:27:57', '2018-05-11 11:27:57', 0);

-- --------------------------------------------------------

--
-- Table structure for table `building_to_be_repaired_tbl`
--

CREATE TABLE IF NOT EXISTS `building_to_be_repaired_tbl` (
  `b_to_be_repaired_id` int(11) NOT NULL AUTO_INCREMENT,
  `b_info_id` int(11) NOT NULL,
  `repairable_part` varchar(225) COLLATE utf8_sinhala_ci NOT NULL,
  `description` text COLLATE utf8_sinhala_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`b_to_be_repaired_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `building_to_be_repaired_tbl`
--

INSERT INTO `building_to_be_repaired_tbl` (`b_to_be_repaired_id`, `b_info_id`, `repairable_part`, `description`, `date_added`, `date_updated`, `is_deleted`) VALUES
(1, 30, '', '', '2018-05-15 15:02:08', '2018-05-15 15:02:08', 0),
(2, 31, 'වහල', 'කැඩිලා', '2018-05-15 15:08:25', '2018-05-15 15:08:25', 0);

-- --------------------------------------------------------

--
-- Table structure for table `building_usage_tbl`
--

CREATE TABLE IF NOT EXISTS `building_usage_tbl` (
  `b_usage_id` int(3) NOT NULL AUTO_INCREMENT,
  `b_usage` varchar(60) COLLATE utf8_sinhala_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`b_usage_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `building_usage_tbl`
--

INSERT INTO `building_usage_tbl` (`b_usage_id`, `b_usage`, `date_added`, `date_updated`, `is_deleted`) VALUES
(1, 'පරිගණක විද්‍යාගාරය', '2018-05-11 13:03:29', '2018-05-11 13:33:15', 0),
(2, 'ගෘහ විද්‍යාගාරය', '2018-05-11 13:33:31', '2018-05-11 13:43:27', 0),
(3, 'පන්ති කාමර', '2018-05-11 13:48:10', '2018-05-11 13:48:10', 0);

-- --------------------------------------------------------

--
-- Table structure for table `computer_lab_resource_details_tbl`
--

CREATE TABLE IF NOT EXISTS `computer_lab_resource_details_tbl` (
  `com_lab_res_info_id` int(11) NOT NULL AUTO_INCREMENT,
  `census_id` varchar(5) COLLATE utf8_sinhala_ci NOT NULL,
  `com_lab_res_id` int(11) NOT NULL,
  `quantity` int(3) NOT NULL,
  `working` int(3) NOT NULL,
  `repairable` int(3) NOT NULL,
  `date_added` date NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`com_lab_res_info_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `computer_lab_resource_details_tbl`
--

INSERT INTO `computer_lab_resource_details_tbl` (`com_lab_res_info_id`, `census_id`, `com_lab_res_id`, `quantity`, `working`, `repairable`, `date_added`, `date_updated`, `is_deleted`) VALUES
(1, '07017', 1, 10, 5, 2, '2018-04-03', '2018-04-03 15:10:30', 0),
(2, '07017', 2, 5, 5, 0, '2018-04-03', '2018-04-03 15:17:36', 0),
(3, '07017', 3, 2, 2, 0, '2018-04-03', '2018-04-03 15:18:49', 0),
(4, '07065', 3, 1, 1, 0, '2018-04-03', '2018-04-03 15:36:06', 0),
(5, '07027', 1, 14, 10, 0, '2018-04-04', '2018-04-04 08:22:34', 0),
(6, '07027', 2, 2, 1, 1, '2018-04-04', '2018-04-23 09:19:29', 0),
(7, '07022', 4, 2, 1, 0, '2018-04-04', '2018-04-04 10:35:13', 0),
(8, '07004', 1, 5, 4, 1, '2018-04-04', '2018-04-04 12:33:54', 0),
(9, '07004', 2, 1, 0, 1, '2018-04-04', '2018-04-04 12:34:18', 0),
(10, '07004', 6, 1, 1, 0, '2018-04-04', '2018-04-04 12:35:05', 0),
(13, '07022', 1, 10, 6, 2, '2018-04-23', '2018-04-23 11:18:05', 0),
(14, '07022', 3, 2, 1, 1, '2018-04-23', '2018-04-23 11:21:03', 0),
(15, '07022', 10, 11, 11, 0, '2018-04-23', '2018-04-23 11:21:41', 0),
(16, '07027', 6, 3, 2, 0, '2018-04-23', '2018-04-23 14:11:11', 0),
(17, '07065', 4, 6, 4, 1, '2018-08-09', '2018-08-09 21:55:42', 0),
(18, '07027', 10, 7, 7, 0, '2018-10-15', '2018-10-15 11:28:48', 0),
(19, '07027', 11, 14, 13, 0, '2018-10-15', '2018-10-15 11:29:11', 0),
(20, '07027', 3, 1, 1, 0, '2018-10-15', '2018-10-15 11:29:28', 0);

-- --------------------------------------------------------

--
-- Table structure for table `computer_lab_resource_tbl`
--

CREATE TABLE IF NOT EXISTS `computer_lab_resource_tbl` (
  `com_lab_res_id` int(11) NOT NULL AUTO_INCREMENT,
  `com_lab_res_type` varchar(60) CHARACTER SET utf8 COLLATE utf8_sinhala_ci NOT NULL,
  `date_added` date NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`com_lab_res_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `computer_lab_resource_tbl`
--

INSERT INTO `computer_lab_resource_tbl` (`com_lab_res_id`, `com_lab_res_type`, `date_added`, `date_updated`, `is_deleted`) VALUES
(1, 'මේස පරිගණක (Desktop)', '2018-01-19', '2018-04-04 10:18:45', 0),
(2, 'උකුල් පරිගණක (Laptop)', '2018-01-19', '2018-04-04 10:11:53', 0),
(3, 'බහු මාධ්‍ය ප්‍රක්ෂේපණ යන්ත්‍ර', '2018-01-19', '2018-04-04 10:19:02', 0),
(4, 'ස්කෑනර් යන්ත්‍ර', '2018-04-03', '2018-04-04 10:20:03', 0),
(6, 'මුද්‍රණ යන්ත්‍ර', '2018-04-04', '2018-04-04 10:23:12', 0),
(7, 'රූපවාහිනී යන්ත්‍ර', '2018-04-04', '2018-04-04 10:23:32', 0),
(8, 'කැමරා', '2018-04-04', '2018-04-04 10:23:43', 0),
(9, 'ඡායා පිටපත් යන්ත්‍ර', '2018-04-04', '2018-04-04 10:23:55', 0),
(10, 'පරිගණක මේස', '2018-04-04', '2018-04-04 10:24:06', 0),
(11, 'පරිගණක පුටු', '2018-04-04', '2018-04-04 10:24:19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `edu_devision_tbl`
--

CREATE TABLE IF NOT EXISTS `edu_devision_tbl` (
  `edu_div_id` int(2) NOT NULL AUTO_INCREMENT,
  `div_name` varchar(11) COLLATE utf8_sinhala_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`edu_div_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `edu_devision_tbl`
--

INSERT INTO `edu_devision_tbl` (`edu_div_id`, `div_name`, `date_added`, `date_updated`, `is_deleted`) VALUES
(1, 'මොරවක', '2018-02-22 10:05:11', '2018-02-22 10:05:11', 0),
(2, 'කොටපොල', '2018-02-22 10:07:25', '2018-02-22 10:07:25', 0),
(3, 'පස්ගොඩ', '2018-02-22 10:10:25', '2018-02-22 10:10:25', 0);

-- --------------------------------------------------------

--
-- Table structure for table `furniture_item_count_tbl`
--

CREATE TABLE IF NOT EXISTS `furniture_item_count_tbl` (
  `fur_item_count_id` int(11) NOT NULL AUTO_INCREMENT,
  `census_id` varchar(5) COLLATE utf8_sinhala_ci NOT NULL,
  `fur_item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `usable` int(11) NOT NULL,
  `repairable` int(11) NOT NULL,
  `needed_more` int(11) NOT NULL,
  `date_added` date NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fur_item_count_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `furniture_item_count_tbl`
--

INSERT INTO `furniture_item_count_tbl` (`fur_item_count_id`, `census_id`, `fur_item_id`, `quantity`, `usable`, `repairable`, `needed_more`, `date_added`, `date_updated`, `is_deleted`) VALUES
(1, '07027', 1, 4, 0, 0, 0, '2018-08-31', '2018-08-31 15:16:27', 0),
(2, '07027', 2, 4, 0, 0, 0, '2018-08-31', '2018-08-31 23:17:32', 0),
(3, '07065', 2, 4, 4, 0, 0, '2018-09-05', '2018-09-05 22:48:51', 0),
(4, '07065', 1, 8, 7, 1, 0, '2018-09-05', '2018-09-05 22:55:40', 0);

-- --------------------------------------------------------

--
-- Table structure for table `furniture_item_status_tbl`
--

CREATE TABLE IF NOT EXISTS `furniture_item_status_tbl` (
  `fur_item_status_id` int(3) NOT NULL AUTO_INCREMENT,
  `fur_status_type` varchar(20) COLLATE utf8_sinhala_ci NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fur_item_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `furniture_item_status_tbl`
--

INSERT INTO `furniture_item_status_tbl` (`fur_item_status_id`, `fur_status_type`, `is_deleted`) VALUES
(1, 'usable', 0),
(2, 'repairable', 0),
(3, 'unusable', 0);

-- --------------------------------------------------------

--
-- Table structure for table `furniture_item_tbl`
--

CREATE TABLE IF NOT EXISTS `furniture_item_tbl` (
  `fur_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `fur_item` varchar(30) COLLATE utf8_sinhala_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`fur_item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `furniture_item_tbl`
--

INSERT INTO `furniture_item_tbl` (`fur_item_id`, `fur_item`, `date_added`, `date_updated`, `is_deleted`) VALUES
(1, 'අල්මාරි', '2018-08-27 13:20:04', '2018-08-27 13:20:04', 0),
(2, 'ගුරු පුටු', '2018-08-27 13:29:25', '2018-08-27 13:29:25', 0);

-- --------------------------------------------------------

--
-- Table structure for table `gender_tbl`
--

CREATE TABLE IF NOT EXISTS `gender_tbl` (
  `gender_id` int(2) NOT NULL AUTO_INCREMENT,
  `gender_name` varchar(10) COLLATE utf8_sinhala_ci NOT NULL,
  PRIMARY KEY (`gender_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `gender_tbl`
--

INSERT INTO `gender_tbl` (`gender_id`, `gender_name`) VALUES
(1, 'පුරුෂ'),
(2, 'ස්ත්‍රී');

-- --------------------------------------------------------

--
-- Table structure for table `gs_devision_tbl`
--

CREATE TABLE IF NOT EXISTS `gs_devision_tbl` (
  `gs_div_id` int(11) NOT NULL AUTO_INCREMENT,
  `gs_div_name` varchar(60) COLLATE utf8_sinhala_ci NOT NULL,
  `edu_div_id` int(2) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`gs_div_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=69 ;

--
-- Dumping data for table `gs_devision_tbl`
--

INSERT INTO `gs_devision_tbl` (`gs_div_id`, `gs_div_name`, `edu_div_id`, `date_added`, `date_updated`, `is_deleted`) VALUES
(1, 'අලපලාදෙනිය', 1, '2018-11-11 06:56:30', '2018-12-31 06:56:30', 0),
(2, 'ආඞාරදෙනිය', 1, '2018-11-11 06:56:30', '2018-11-11 06:56:30', 0),
(3, 'මොරවක', 1, '2018-11-11 06:56:30', '2018-11-11 06:56:30', 0),
(4, 'ඇහැළකන්ද', 1, '2018-11-11 06:56:30', '2018-11-11 06:56:30', 0),
(5, 'ඉලුක්පිටිය', 1, '2018-11-11 06:56:30', '2018-11-11 06:56:30', 0),
(6, 'ඊදඩුකිත නැගෙනහිර', 1, '2018-11-11 06:56:30', '2018-11-11 06:56:30', 0),
(7, 'උසමලගොඩ', 3, '2018-11-11 19:37:15', '2018-11-11 19:37:15', 0),
(8, 'එළමල්දෙනිය', 2, '2018-11-11 19:37:15', '2018-11-11 19:37:15', 0),
(9, 'කන්දිල්පාන', 2, '2018-11-11 19:37:15', '2018-11-11 19:37:15', 0),
(10, 'කඳුරුවාන', 2, '2018-11-11 19:37:15', '2018-11-11 19:37:15', 0),
(11, 'කළුගලහේන', 3, '2018-11-11 19:37:15', '2018-11-11 19:37:15', 0),
(12, 'කැකුන්දෙනිය', 3, '2018-11-11 19:37:15', '2018-11-11 19:37:15', 0),
(13, 'කැටවල', 1, '2018-11-11 19:37:15', '2018-11-11 19:37:15', 0),
(14, 'කිරිවලගම', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(15, 'කිරිවැල්කැලේ උතුර', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(16, 'කිරිවැල්දොළ', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(17, 'කීරිපිටිය බටහිර', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(18, 'කුඩගලහේන', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(19, 'කොටපොල උතුර ,දකුණ', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(20, 'කොඩිකාරගොඩ බටහිර', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(21, 'ගලබඩ', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(22, 'ගින්නලිය උතුර', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(23, 'ගින්නලිය දකුණ', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(24, 'ගොමිල', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(25, 'තලපෙකුඹුර', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(26, 'තැනිපිට', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(27, 'දංකොළුව', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(28, 'දංගල,නැගෙනහිර', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(29, 'දෑරංගල', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(30, 'දියදාව', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(31, 'දෙනියාය', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(32, 'පට්ටිගල', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(33, 'පනාකඩුව නැගෙනහිර', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(34, 'පරගල', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(35, 'පල්ලේගම උතුර', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(36, 'පස්ගොඩ', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(37, 'පැලවත්ත', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(38, 'පිටබැද්දර', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(39, 'පුවක්ගහහේන', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(40, 'පුස්සවෙල්ල', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(41, 'පොත්දෙනිය', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(42, 'බටයාය', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(43, 'බටාඳුර උතුර', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(44, 'බටාඳුර දකුණ', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(45, 'බානගල බටහිර', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(46, 'බෙංගමුව දකුණ', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(47, 'බෙන්ගමුව නැගෙනහිර', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(48, 'බෙරලපනාතර උතුර', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(49, 'මහපොතුවිල', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(50, 'මාවරල', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(51, 'මැකිලියතැන්න', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(52, 'මුගුණුමුල්ල', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(53, 'මෙදේරිපිටිය', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(54, 'මොරවක', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(55, 'මොලොග්ගමුව දකුණ', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(56, 'රඹුකන', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(57, 'රඹුකන බටහිර', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(58, 'රොටුඹ', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(59, 'රොටුඹ නැගෙනහිර', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(60, 'වතුරකුඹුර', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(61, 'වරල්ල', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(62, 'වැලිව', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(63, 'විහාරහේන', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(64, 'සියඹලාගොඩ බටහිර', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(65, 'හී ගොඩ', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(66, 'හුලංකන්ද', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(67, 'හොරගල නැගෙනහිර', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(68, 'හොරගල බටහිර', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `library_resource_details_tbl`
--

CREATE TABLE IF NOT EXISTS `library_resource_details_tbl` (
  `lib_res_details_id` int(11) NOT NULL AUTO_INCREMENT,
  `census_id` varchar(5) COLLATE utf8_sinhala_ci NOT NULL,
  `lib_res_id` int(11) NOT NULL,
  `quantity` int(3) NOT NULL,
  `date_added` date NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`lib_res_details_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `library_resource_details_tbl`
--

INSERT INTO `library_resource_details_tbl` (`lib_res_details_id`, `census_id`, `lib_res_id`, `quantity`, `date_added`, `date_updated`, `is_deleted`) VALUES
(1, '07065', 1, 20, '2018-04-24', '2018-04-24 12:47:48', 0),
(2, '07022', 3, 5, '2018-04-24', '2018-04-24 11:53:52', 0),
(3, '07065', 2, 25, '2018-04-24', '2018-04-24 12:43:10', 0),
(4, '07065', 3, 50, '2018-04-24', '2018-04-24 12:49:31', 0),
(7, '07027', 1, 25, '2018-04-27', '2018-04-27 12:59:50', 0),
(8, '07027', 3, 1, '2018-04-27', '2018-10-15 15:39:10', 0),
(9, '07027', 2, 10, '2018-10-15', '2018-10-15 15:39:41', 0),
(10, '07027', 4, 1, '2018-10-15', '2018-10-15 15:39:56', 0),
(11, '07027', 5, 7, '2018-10-15', '2018-10-15 15:40:13', 0),
(12, '07027', 6, 5, '2018-10-15', '2018-10-15 15:40:25', 0),
(13, '07027', 11, 670, '2018-10-15', '2018-10-15 15:40:49', 0),
(14, '07027', 12, 70, '2018-10-15', '2018-10-15 15:41:01', 0),
(15, '07027', 13, 150, '2018-10-15', '2018-10-15 15:41:15', 0);

-- --------------------------------------------------------

--
-- Table structure for table `library_resource_tbl`
--

CREATE TABLE IF NOT EXISTS `library_resource_tbl` (
  `lib_res_id` int(11) NOT NULL AUTO_INCREMENT,
  `lib_res_type` varchar(60) COLLATE utf8_sinhala_ci NOT NULL,
  `date_added` date NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`lib_res_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=19 ;

--
-- Dumping data for table `library_resource_tbl`
--

INSERT INTO `library_resource_tbl` (`lib_res_id`, `lib_res_type`, `date_added`, `date_updated`, `is_deleted`) VALUES
(1, 'පුස්තකාල පුටු', '2018-01-19', '2018-04-23 14:24:29', 0),
(2, 'පුස්තකාල මේස', '2018-04-27', '2018-10-15 15:33:55', 0),
(3, 'පුස්තකාලයාධිපති මේස', '2018-04-24', '2018-10-15 15:34:15', 0),
(4, 'පුස්තකාලයාධිපති පුටු', '2018-04-27', '2018-10-15 15:34:36', 0),
(5, 'පොත් අල්මාරි', '2018-10-15', '2018-10-15 15:34:51', 0),
(6, 'පොත් රාක්ක', '2018-10-15', '2018-10-15 15:35:14', 0),
(7, 'සඟරා රාක්ක', '2018-10-15', '2018-10-15 15:35:55', 0),
(8, 'පත්තර මේස', '2018-10-15', '2018-10-15 15:36:06', 0),
(9, 'පත්තර රාක්ක', '2018-10-15', '2018-10-15 15:36:16', 0),
(10, 'රූපවාහිනී තබන රාක්ක', '2018-10-15', '2018-10-15 15:36:31', 0),
(11, 'සිංහල මාධ්‍ය පොත්', '2018-10-15', '2018-10-15 15:36:47', 0),
(12, 'දෙමළ මාධ්‍ය පොත්', '2018-10-15', '2018-10-15 15:36:59', 0),
(13, 'ඉංග්‍රීසි මාධ්‍ය පොත්', '2018-10-15', '2018-10-15 15:37:19', 0),
(14, 'රූපවාහිනී', '2018-10-15', '2018-10-15 15:37:37', 0),
(15, 'රේඩියෝ', '2018-10-15', '2018-10-15 15:37:48', 0),
(16, 'කැසට් රෙකෝඩර්', '2018-10-15', '2018-10-15 15:38:21', 0),
(17, 'පරිගණක', '2018-10-15', '2018-10-15 15:38:29', 0),
(18, 'මුද්‍රණ යන්ත්‍ර', '2018-10-15', '2018-10-15 15:38:48', 0);

-- --------------------------------------------------------

--
-- Table structure for table `physical_res_category_tbl`
--

CREATE TABLE IF NOT EXISTS `physical_res_category_tbl` (
  `phy_res_cat_id` int(3) NOT NULL AUTO_INCREMENT,
  `phy_res_category` varchar(60) COLLATE utf8_sinhala_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`phy_res_cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=34 ;

--
-- Dumping data for table `physical_res_category_tbl`
--

INSERT INTO `physical_res_category_tbl` (`phy_res_cat_id`, `phy_res_category`, `date_added`, `date_updated`, `is_deleted`) VALUES
(11, 'විදුලිය', '2018-02-20 15:45:34', '2018-02-20 15:45:34', 0),
(12, 'දුරකථන පහසුකම්', '2018-02-20 15:45:48', '2018-02-20 15:45:48', 0),
(13, 'අන්තර්ජාල පහසුකම්', '2018-02-20 15:46:02', '2018-02-20 15:46:02', 0),
(14, 'ජල සැපයුම', '2018-02-20 15:46:23', '2018-02-20 15:46:23', 0),
(15, 'ජලය ලබාගන්නා ආකාරය', '2018-02-21 08:26:40', '2018-02-21 08:26:40', 0),
(16, 'ශිෂ්‍ය උපදේශන ඒකක', '2018-02-21 08:27:37', '2018-02-21 08:27:37', 0),
(17, 'ගුරු විවේකාගාර', '2018-02-21 08:32:10', '2018-02-21 08:32:10', 0),
(18, 'විදුහල්පති නිවාස', '2018-02-21 08:32:32', '2018-02-21 08:32:32', 0),
(19, 'ගුරු නිවාස', '2018-02-21 08:32:46', '2018-02-21 08:32:46', 0),
(20, 'ශිෂ්‍ය ක්‍රියාකාරකම් කාමර', '2018-02-21 08:33:00', '2018-02-21 08:33:00', 0),
(21, 'තාක්ෂණ විෂය අපොස සා/පෙළ තාක්ෂණ ඒකකයක්', '2018-02-21 08:40:44', '2018-02-21 08:40:44', 0),
(22, 'තාක්ෂණ පීඨය', '2018-02-21 08:41:03', '2018-02-21 08:41:03', 0),
(23, 'තාක්ෂණ පීඨයට විදුලි සැපයුම', '2018-02-21 08:41:18', '2018-02-21 08:41:18', 0),
(24, 'තාක්ෂණ පීඨයට ජල සැපයුම', '2018-02-21 08:41:36', '2018-02-21 08:41:36', 0),
(25, 'ගෘහ විද්‍යාගාර', '2018-02-21 08:41:51', '2018-02-21 08:41:51', 0),
(26, 'සෞන්දර්ය ඒකක', '2018-02-21 08:42:04', '2018-02-21 08:42:04', 0),
(27, 'බහුකාර්ය ඒකක', '2018-02-21 08:42:14', '2018-02-21 08:42:14', 0),
(28, 'සෙල්ලම් මිදුල', '2018-02-21 08:42:28', '2018-02-21 08:42:28', 0),
(29, 'පරිගණක විද්‍යාගාර', '2018-02-21 08:42:40', '2018-02-21 08:42:40', 0),
(30, 'පුස්තකාලය', '2018-02-21 08:42:52', '2018-02-21 08:42:52', 0),
(31, 'පාසල් ආපනශාලාව', '2018-02-21 08:43:02', '2018-02-21 08:43:02', 0),
(32, 'ක්‍රීඩා පිට්ටනිය', '2018-02-21 08:43:14', '2018-02-21 08:43:14', 0),
(33, 'ධාවන පථයේ ප්‍රමාණය', '2018-02-21 08:44:35', '2018-04-05 14:35:03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `physical_res_details_tbl`
--

CREATE TABLE IF NOT EXISTS `physical_res_details_tbl` (
  `phy_res_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `census_id` varchar(5) COLLATE utf8_sinhala_ci NOT NULL,
  `phy_res_cat_id` int(3) NOT NULL,
  `phy_res_status_id` int(2) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`phy_res_detail_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=53 ;

--
-- Dumping data for table `physical_res_details_tbl`
--

INSERT INTO `physical_res_details_tbl` (`phy_res_detail_id`, `census_id`, `phy_res_cat_id`, `phy_res_status_id`, `date_added`, `date_updated`, `is_deleted`) VALUES
(10, '07065', 11, 5, '2018-02-20 16:05:26', '2018-02-20 16:05:26', 0),
(11, '07065', 12, 6, '2018-02-20 16:06:12', '2018-02-20 16:06:12', 0),
(12, '07027', 13, 5, '2018-02-20 16:06:38', '2018-02-20 16:06:38', 0),
(13, '07027', 15, 13, '2018-02-21 10:16:44', '2018-02-21 10:16:44', 0),
(14, '07065', 15, 21, '2018-02-21 10:45:19', '2018-03-26 14:22:26', 0),
(15, '07027', 20, 7, '2018-02-21 11:16:57', '2018-02-21 11:16:57', 0),
(16, '07065', 19, 8, '2018-02-20 15:34:23', '2018-02-21 11:55:43', 0),
(23, '07027', 19, 8, '2018-02-21 11:35:37', '2018-03-23 09:47:20', 0),
(24, '07002', 11, 5, '2018-03-02 10:33:11', '2018-03-02 11:13:35', 0),
(25, '07002', 25, 7, '2018-03-02 11:13:18', '2018-03-02 11:13:18', 0),
(27, '07002', 14, 7, '2018-03-02 11:15:02', '2018-03-02 11:15:27', 0),
(28, '07002', 13, 6, '2018-03-02 12:43:29', '2018-03-02 12:43:29', 0),
(29, '07002', 33, 11, '2018-03-02 12:44:19', '2018-03-22 08:12:29', 0),
(30, '07065', 14, 5, '2018-03-26 14:17:19', '2018-03-26 14:17:19', 0),
(31, '07065', 26, 5, '2018-03-26 14:18:19', '2018-03-26 14:18:19', 0),
(32, '07029', 14, 7, '2018-03-26 16:37:21', '2018-10-15 16:04:26', 0),
(33, '07057', 14, 6, '2018-03-27 12:25:02', '2018-03-27 12:25:02', 0),
(34, '07065', 18, 6, '2018-03-27 16:38:35', '2018-03-27 16:38:35', 0),
(35, '07027', 22, 6, '2018-03-28 14:06:30', '2018-03-28 14:06:30', 0),
(37, '07041', 16, 6, '2018-03-28 16:16:02', '2018-03-28 16:16:02', 0),
(38, '07017', 29, 6, '2018-03-28 16:22:38', '2018-03-28 16:22:38', 0),
(39, '07407', 26, 6, '2018-03-28 16:28:50', '2018-03-28 16:28:50', 0),
(40, '07027', 11, 5, '2018-03-29 11:11:44', '2018-03-29 11:11:44', 0),
(41, '07027', 25, 5, '2018-03-29 11:14:06', '2018-03-29 11:14:06', 0),
(42, '07004', 11, 5, '2018-03-29 12:52:05', '2018-03-29 12:52:05', 0),
(43, '07004', 12, 6, '2018-03-29 12:53:16', '2018-03-29 12:53:16', 0),
(44, '07027', 14, 6, '2018-04-05 13:47:34', '2018-04-05 13:47:34', 0),
(45, '07041', 14, 6, '2018-04-05 13:48:59', '2018-04-05 13:48:59', 0),
(46, '07041', 15, 21, '2018-04-05 14:54:20', '2018-04-05 14:54:20', 0),
(47, '07065', 25, 5, '2018-04-05 15:02:00', '2018-04-05 15:02:00', 0),
(48, '07001', 18, 8, '2018-04-05 15:04:26', '2018-04-05 15:04:26', 0),
(49, '07022', 14, 5, '2018-04-23 10:35:33', '2018-04-23 10:35:33', 0),
(50, '07027', 23, 5, '2018-10-11 23:39:39', '2018-10-11 23:39:39', 0),
(51, '07001', 14, 9, '2018-10-15 16:05:01', '2018-10-15 16:05:01', 0),
(52, '07027', 28, 6, '2018-10-15 17:27:38', '2018-10-15 17:27:38', 0);

-- --------------------------------------------------------

--
-- Table structure for table `physical_res_status_tbl`
--

CREATE TABLE IF NOT EXISTS `physical_res_status_tbl` (
  `phy_res_status_id` int(2) NOT NULL AUTO_INCREMENT,
  `phy_res_status_type` varchar(60) COLLATE utf8_sinhala_ci NOT NULL,
  `status_group_id` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`phy_res_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=24 ;

--
-- Dumping data for table `physical_res_status_tbl`
--

INSERT INTO `physical_res_status_tbl` (`phy_res_status_id`, `phy_res_status_type`, `status_group_id`, `date_added`, `date_updated`, `is_deleted`) VALUES
(5, 'ඇත', 1, '2018-02-21 11:36:27', '2018-02-21 11:36:27', 0),
(6, 'නැත', 1, '2018-02-21 11:36:47', '2018-02-21 11:36:47', 0),
(7, 'ඇත, ප්‍රමාණවත් නැත', 2, '2018-02-20 14:47:44', '2018-02-20 15:33:57', 0),
(8, 'ප්‍රතිසංස්කරණය කළ යුතුය', 2, '2018-02-20 15:34:23', '2018-02-20 15:34:23', 0),
(9, 'ඇත, අඛණ්ඩව සැපයෙන්නේ නැත', 3, '2018-02-21 09:10:25', '2018-02-21 09:10:25', 0),
(10, 'මීටර් 100', 4, '2018-02-21 09:11:12', '2018-02-21 09:11:12', 0),
(11, 'මීටර් 200', 4, '2018-02-21 09:11:26', '2018-02-21 09:11:26', 0),
(12, 'මීටර් 400', 4, '2018-02-21 09:11:36', '2018-02-21 09:11:36', 0),
(13, 'පාසලේ ළිඳ / නල ළිඳ', 5, '2018-02-21 09:34:19', '2018-02-21 09:34:19', 0),
(14, 'ජලනල පහසුකම් (නගර සභා)', 5, '2018-02-21 09:34:37', '2018-02-21 09:34:37', 0),
(15, 'ජලනල පහසුකම් (ප්‍රාදේශීය සභා)', 5, '2018-02-21 09:34:51', '2018-02-21 09:34:51', 0),
(16, 'ජලනල පහසුකම් (ජල සම්පාදන මණ්ඩලය)', 5, '2018-02-21 09:35:07', '2018-02-21 09:35:07', 0),
(21, 'කඳුවල සිට ලබාගන්නා ජලය', 5, '2018-02-21 11:38:46', '2018-02-21 11:38:46', 0),
(22, 'බවුසර් මගින් බෙදා හරින ජලය', 5, '2018-02-21 11:39:00', '2018-02-21 11:39:00', 0),
(23, 'ධාවන පථයක් නොමැත', 4, '2018-04-05 10:48:49', '2018-04-05 10:48:49', 0);

-- --------------------------------------------------------

--
-- Table structure for table `response_person_tbl`
--

CREATE TABLE IF NOT EXISTS `response_person_tbl` (
  `response_person_id` int(10) NOT NULL AUTO_INCREMENT,
  `res_p_name` varchar(60) COLLATE utf8_sinhala_ci NOT NULL,
  `phone_no` varchar(10) COLLATE utf8_sinhala_ci NOT NULL,
  `occupation` varchar(60) COLLATE utf8_sinhala_ci NOT NULL,
  `relationship` varchar(30) COLLATE utf8_sinhala_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`response_person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `response_person_tbl`
--

INSERT INTO `response_person_tbl` (`response_person_id`, `res_p_name`, `phone_no`, `occupation`, `relationship`, `date_added`, `date_updated`, `is_deleted`) VALUES
(1, 'MG මිත්‍රපාල', '0715196623', 'කම්කරු', '', '2018-09-24 23:51:02', '2018-09-24 23:51:02', 0),
(2, 'EG පියසේන', '0718688444', 'කෘෂි කර්මාන්තය', 'තාත්තා', '2018-09-24 23:58:45', '2018-09-24 23:58:45', 0),
(3, 'අමරපාල', '', '', '', '2018-10-02 22:33:02', '2018-10-02 22:33:02', 0),
(4, 'H පාලිත', '', '', '', '2018-10-06 16:59:23', '2018-10-06 16:59:23', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sanitary_item_details_tbl`
--

CREATE TABLE IF NOT EXISTS `sanitary_item_details_tbl` (
  `san_item_details_id` int(11) NOT NULL AUTO_INCREMENT,
  `census_id` varchar(5) COLLATE utf8_sinhala_ci NOT NULL,
  `san_item_id` int(11) NOT NULL,
  `quantity` int(3) NOT NULL,
  `usable` int(3) NOT NULL,
  `repairable` int(3) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`san_item_details_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `sanitary_item_details_tbl`
--

INSERT INTO `sanitary_item_details_tbl` (`san_item_details_id`, `census_id`, `san_item_id`, `quantity`, `usable`, `repairable`, `date_added`, `date_updated`, `is_deleted`) VALUES
(2, '07065', 2, 10, 8, 2, '2018-04-27 12:01:37', '2018-04-27 12:01:37', 0),
(3, '07027', 2, 5, 6, 0, '2018-04-27 12:39:12', '2018-10-07 18:34:01', 0),
(4, '07027', 4, 5, 4, 1, '2018-04-27 12:41:27', '2018-11-12 00:19:29', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sanitary_item_tbl`
--

CREATE TABLE IF NOT EXISTS `sanitary_item_tbl` (
  `san_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `san_item_name` varchar(60) COLLATE utf8_sinhala_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`san_item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `sanitary_item_tbl`
--

INSERT INTO `sanitary_item_tbl` (`san_item_id`, `san_item_name`, `date_added`, `date_updated`, `is_deleted`) VALUES
(2, 'ගැහැණු සිසු වැසිකිලි', '2018-04-27 10:43:27', '2018-04-27 10:50:51', 0),
(4, 'පිරිමි සිසු වැසිකිලි', '2018-04-27 12:40:20', '2018-04-27 12:40:20', 0),
(5, 'ගුරු වැසිකිලි', '2018-11-12 00:13:26', '2018-11-12 00:13:26', 0);

-- --------------------------------------------------------

--
-- Table structure for table `school_belongs_tbl`
--

CREATE TABLE IF NOT EXISTS `school_belongs_tbl` (
  `belongs_to_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `belongs_to_name` varchar(30) COLLATE utf8_sinhala_ci NOT NULL,
  PRIMARY KEY (`belongs_to_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `school_belongs_tbl`
--

INSERT INTO `school_belongs_tbl` (`belongs_to_id`, `belongs_to_name`) VALUES
(1, 'පළාත් පාසලකි'),
(2, 'ජාතික පාසලකි');

-- --------------------------------------------------------

--
-- Table structure for table `school_details_tbl`
--

CREATE TABLE IF NOT EXISTS `school_details_tbl` (
  `census_id` varchar(5) NOT NULL,
  `exam_no` varchar(5) NOT NULL,
  `sch_name` varchar(60) CHARACTER SET utf8 COLLATE utf8_sinhala_ci NOT NULL,
  `address1` varchar(255) CHARACTER SET utf8 COLLATE utf8_sinhala_ci NOT NULL,
  `address2` varchar(255) CHARACTER SET utf8 COLLATE utf8_sinhala_ci NOT NULL,
  `contact_no` varchar(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `web_address` varchar(60) NOT NULL,
  `gs_div_id` int(2) NOT NULL,
  `edu_div_id` varchar(2) NOT NULL,
  `sch_type_id` int(3) NOT NULL,
  `belongs_to_id` tinyint(1) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`census_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `school_details_tbl`
--

INSERT INTO `school_details_tbl` (`census_id`, `exam_no`, `sch_name`, `address1`, `address2`, `contact_no`, `email`, `web_address`, `gs_div_id`, `edu_div_id`, `sch_type_id`, `belongs_to_id`, `user_id`, `date_added`, `date_updated`, `is_deleted`) VALUES
('07001', '53423', 'මාර/පිටබැද්දර ම.වි.', 'පිටබැද්දර', 'මාතර', '0912282334', 'pitamv@gmail.com', 'pitabeddamv.sch.lk', 0, '2', 3, 1, 20, '2018-02-22 11:13:27', '2018-03-05 13:11:33', 0),
('07002', '40045', 'මාර/මේධානන්ද ක.වි.', 'පිටබැද්දර', 'මාතර', '0412283346', 'pitamv@gmail.com', 'pitabeddamv.sch.lk', 0, '1', 1, 1, 2, '2018-02-22 10:10:25', '2018-02-23 12:51:50', 0),
('07004', '07004', 'මාර/රඹුකන කණිෂ්ඨ විද්‍යාලය', 'galle', 'matara', '0715196623', 'mgpprasan@g.com', '', 0, '1', 4, 1, 5, '2018-03-06 09:43:23', '2018-03-29 12:56:38', 0),
('07017', '40044', 'මාර/කීර්ති අබේවික්‍රම මධ්‍ය මහා විද්‍යාලය', 'මිල්ල ඇල', 'මොරවක', '0412222222', 'mkns@yahoo.com', '', 0, '2', 1, 2, 11, '2018-03-06 09:52:40', '2018-03-21 09:04:51', 0),
('07022', '', 'මාර/කළුබෝවිටියන මහා විද්‍යාලය', '', '', '', '', '', 0, '1', 0, 1, 6, '2018-03-06 09:45:12', '2018-03-06 09:45:12', 0),
('07027', '20024', 'මාර/මොරවක බෞද්ධ මහා විද්‍යාලය', 'වැලිව', 'මොරවක', '0712636761', 'mgpprasan@yahoo.com', '', 1, '1', 2, 1, 3, '0000-00-00 00:00:00', '2018-11-11 22:14:58', 0),
('07029', '40000', 'මාර/කොටපොල ජාතික පාසල', 'දෙනියාය පාර ', 'කොටපොල', '0702750062', 'kotapoalamv@gmail.com', '', 0, '2', 2, 2, 10, '2018-03-06 09:50:52', '2018-03-28 15:55:41', 0),
('07041', '40023', 'මාර/ඌරුබොක්ක මධ්‍ය මහා විද්‍යාලය', 'ඌරුබොක්ක', '', '0412256480', 'urubokkamv@gmail.com', '', 0, '2', 1, 1, 12, '2018-03-06 09:54:39', '2018-03-06 10:43:43', 0),
('07055', '', 'මාර/දෙනියාය මධ්‍ය මහා විද්‍යාලය', '', '', '', '', '', 0, '2', 0, 1, 9, '2018-03-06 09:49:50', '2018-03-06 09:49:50', 0),
('07057', '53423', 'මාර/දෙනියාය රාජපක්ෂ මහා විද්‍යාලය', 'විහාරහේන පාර', 'දෙනියාය', '0772546321', 'deniraja@gmail.com', '', 0, '2', 2, 1, 7, '2018-03-06 09:47:32', '2018-03-21 09:40:33', 0),
('07058', '', 'මාර/ශාන්ත මැතිව්ස් මහා විද්‍යාලය', '', '', '', '', '', 0, '2', 0, 1, 8, '2018-03-06 09:48:50', '2018-03-06 09:48:50', 0),
('07064', '23456', 'sdfsdf', 'පල්ලෙගම', '', '0412256789', 'mgpprasa@gmail.com', '', 8, '2', 1, 1, 15, '2018-10-14 17:22:02', '2018-11-11 23:07:29', 0),
('07065', '07065', 'මාර/පල්ලෙගම මහා විද්‍යාලය', 'පල්ලෙගම ', 'දෙනියාය', '0715196623', 'mgm.sdf@gmail.com', 'www.pallegama.sch.lk', 8, '2', 1, 1, 4, '0000-00-00 00:00:00', '2018-11-11 23:23:09', 0),
('07407', '', 'මාර/කීර්ති ශ්‍රී ප්‍රාථමික විද්‍යාලය', '', '', '', '', '', 0, '3', 4, 1, 13, '2018-03-06 09:55:40', '2018-03-06 09:55:40', 0);

-- --------------------------------------------------------

--
-- Table structure for table `school_type_tbl`
--

CREATE TABLE IF NOT EXISTS `school_type_tbl` (
  `sch_type_id` int(3) NOT NULL AUTO_INCREMENT,
  `sch_type` varchar(10) COLLATE utf8_sinhala_ci NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`sch_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `school_type_tbl`
--

INSERT INTO `school_type_tbl` (`sch_type_id`, `sch_type`, `is_deleted`) VALUES
(1, '1AB', 0),
(2, '1C', 0),
(3, '2', 0),
(4, '3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_classes_tbl`
--

CREATE TABLE IF NOT EXISTS `student_classes_tbl` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(5) COLLATE utf8_sinhala_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `student_classes_tbl`
--

INSERT INTO `student_classes_tbl` (`class_id`, `class_name`, `date_added`, `date_updated`, `is_deleted`) VALUES
(1, 'A', '2018-08-10 13:16:28', '2018-08-10 13:16:28', 0),
(2, 'B', '2018-08-10 13:16:28', '2018-08-10 13:16:28', 0),
(3, 'C', '2018-08-10 13:16:28', '2018-08-10 13:16:28', 0),
(4, 'D', '2018-08-10 13:16:28', '2018-08-10 13:16:28', 0),
(5, 'E', '2018-08-10 13:16:28', '2018-08-10 13:16:28', 0),
(6, 'F', '2018-08-10 07:35:45', '0000-00-00 00:00:00', 0),
(7, 'G', '2018-08-10 07:35:45', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_grades_tbl`
--

CREATE TABLE IF NOT EXISTS `student_grades_tbl` (
  `grade_id` int(3) NOT NULL AUTO_INCREMENT,
  `grade_name` varchar(15) COLLATE utf8_sinhala_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`grade_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `student_grades_tbl`
--

INSERT INTO `student_grades_tbl` (`grade_id`, `grade_name`, `date_added`, `date_updated`, `is_deleted`) VALUES
(1, '1 ශ්‍රේණිය', '2018-08-22 04:16:30', '2018-08-22 04:16:30', 0),
(2, '2 ශ්‍රේණිය', '2018-08-22 04:16:30', '2018-08-22 04:16:30', 0),
(3, '3 ශ්‍රේණිය', '2018-08-22 04:16:30', '2018-08-22 04:16:30', 0),
(4, '4 ශ්‍රේණිය', '2018-08-22 04:16:30', '2018-08-22 04:16:30', 0),
(5, '5 ශ්‍රේණිය', '2018-08-22 04:16:30', '2018-08-22 04:16:30', 0),
(6, '6 ශ්‍රේණිය', '2018-08-22 04:16:30', '2018-08-22 04:16:30', 0),
(7, '7 ශ්‍රේණිය', '2018-08-22 04:16:30', '2018-08-22 04:16:30', 0),
(8, '8 ශ්‍රේණිය', '2018-08-22 04:16:30', '2018-08-22 04:16:30', 0),
(9, '9 ශ්‍රේණිය', '2018-08-22 04:16:30', '2018-08-22 04:16:30', 0),
(10, '10 ශ්‍රේණිය', '2018-08-22 04:16:30', '2018-08-22 04:16:30', 0),
(11, '11 ශ්‍රේණිය', '2018-08-22 04:16:30', '2018-08-22 04:16:30', 0),
(12, '12 ශ්‍රේණිය', '2018-08-22 04:16:30', '2018-08-22 04:16:30', 0),
(13, '13 ශ්‍රේණිය', '2018-08-22 04:16:30', '2018-08-22 04:16:30', 0),
(14, '13 ශ්‍රේණිය OLD', '2018-08-22 04:16:30', '2018-08-22 04:16:30', 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_tbl`
--

CREATE TABLE IF NOT EXISTS `student_tbl` (
  `st_id` int(10) NOT NULL AUTO_INCREMENT,
  `index_no` varchar(10) COLLATE utf8_sinhala_ci NOT NULL,
  `fullname` varchar(256) COLLATE utf8_sinhala_ci NOT NULL,
  `name_with_initials` varchar(60) COLLATE utf8_sinhala_ci NOT NULL,
  `address1` varchar(255) COLLATE utf8_sinhala_ci NOT NULL,
  `address2` varchar(255) COLLATE utf8_sinhala_ci NOT NULL,
  `phone_no` varchar(10) COLLATE utf8_sinhala_ci NOT NULL,
  `dob` date NOT NULL,
  `gender_id` tinyint(1) NOT NULL,
  `d_o_admission` date NOT NULL,
  `census_id` varchar(7) COLLATE utf8_sinhala_ci NOT NULL,
  `grade_id` int(10) NOT NULL,
  `class_id` int(11) NOT NULL,
  `response_person_id` int(10) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`st_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `student_tbl`
--

INSERT INTO `student_tbl` (`st_id`, `index_no`, `fullname`, `name_with_initials`, `address1`, `address2`, `phone_no`, `dob`, `gender_id`, `d_o_admission`, `census_id`, `grade_id`, `class_id`, `response_person_id`, `date_added`, `date_updated`, `is_deleted`) VALUES
(1, '1000', 'මීපෙ ගමගේ පුබුදු ප්‍රසන්න', 'MGP ප්‍රසන්න', '', '', '', '0000-00-00', 1, '0000-00-00', '07027', 10, 4, 0, '2018-09-24 23:35:20', '2018-09-24 23:35:20', 0),
(3, '1001', 'මීපෙ ගමගේ පුබුදු ප්‍රසන්න', 'MGP ප්‍රසන්න', '', '', '', '0000-00-00', 1, '0000-00-00', '07027', 11, 1, 0, '2018-09-24 23:44:20', '2018-09-24 23:44:20', 0),
(4, '1002', 'මීපෙ ගමගේ පුබුදු ප්‍රසන්න', 'ප්‍රසන්න', '', '', '', '0000-00-00', 1, '0000-00-00', '07027', 11, 1, 0, '2018-09-24 23:49:01', '2018-09-24 23:49:01', 0),
(5, '1003', 'මීපෙ ගමගේ පුබුදු ප්‍රසන්න', 'ප්‍රසන්න', '', '', '', '0000-00-00', 1, '0000-00-00', '07027', 11, 3, 1, '2018-09-24 23:51:02', '2018-09-24 23:51:02', 0),
(6, '1004', 'එදිරිසිංහ ගමගේ සුනේත්‍රා මල්කාන්ති', 'EGS මල්කාන්ති', 'පුංචිදූව වත්ත, හරුමල', 'අඟුළුගහ', '0714552875', '0000-00-00', 2, '0000-00-00', '07027', 11, 1, 2, '2018-09-24 23:58:45', '2018-09-24 23:58:45', 0),
(7, '1007', 'අහංගම විතානගේ අමල් පෙරේරා', 'AV අමල් පෙරේරා', 'පිටබැද්දර', 'මොරවක', '', '0000-00-00', 1, '0000-00-00', '07027', 10, 4, 3, '2018-10-02 22:33:03', '2018-10-02 22:33:03', 0),
(8, '1005', 'halgasmull suranaga sandakelum', 'H Suranga Sandakelum', '', '', '', '0000-00-00', 2, '0000-00-00', '07027', 12, 1, 4, '2018-10-06 16:59:23', '2018-10-06 16:59:23', 0),
(14, '1015', 'එදිරිසිංහ ගමගේ ඉන්දික සම්පත්', 'EG ඉන්දික සම්පත්', '', '', '', '0000-00-00', 1, '0000-00-00', '07027', 1, 0, 0, '2018-10-14 17:46:09', '2018-10-14 17:46:09', 0),
(15, '100005', 'Edirisinghe Gamage Indika Sampath', 'EGI Sampath', '', '', '', '0000-00-00', 2, '0000-00-00', '07065', 10, 3, 0, '2019-11-12 23:57:01', '2019-11-12 23:57:01', 0),
(16, '1000089', 'Pilana Pathiranage Maheshika ', 'PP Maheshika', '', '', '', '0000-00-00', 1, '0000-00-00', '07065', 11, 1, 0, '2019-11-12 23:57:54', '2019-11-12 23:57:54', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_act_type_tbl`
--

CREATE TABLE IF NOT EXISTS `user_act_type_tbl` (
  `act_type_id` int(2) NOT NULL AUTO_INCREMENT,
  `act_type` varchar(30) COLLATE utf8_sinhala_ci NOT NULL,
  PRIMARY KEY (`act_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user_act_type_tbl`
--

INSERT INTO `user_act_type_tbl` (`act_type_id`, `act_type`) VALUES
(1, 'Login'),
(2, 'Insert'),
(3, 'Update'),
(4, 'Delete');

-- --------------------------------------------------------

--
-- Table structure for table `user_role_tbl`
--

CREATE TABLE IF NOT EXISTS `user_role_tbl` (
  `role_id` int(2) NOT NULL AUTO_INCREMENT,
  `roll_name` varchar(30) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `user_role_tbl`
--

INSERT INTO `user_role_tbl` (`role_id`, `roll_name`, `date_added`, `date_updated`, `is_deleted`) VALUES
(1, 'System Administrator', '2018-01-17 00:00:00', '2018-02-22 00:00:00', 0),
(2, 'School User', '2018-01-17 00:00:00', '2018-02-22 00:00:00', 0),
(3, 'Zonal User', '2018-01-17 09:36:28', '2018-01-17 09:36:28', 0),
(4, 'Department User', '2018-02-22 00:00:00', '2018-02-22 00:00:00', 0),
(5, 'Zonal Director', '2018-06-20 09:35:23', '2018-06-20 09:35:23', 0),
(6, 'Zonal Assistant Director', '2018-06-20 09:35:23', '2018-06-20 09:35:23', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_status_tbl`
--

CREATE TABLE IF NOT EXISTS `user_status_tbl` (
  `status_id` int(3) NOT NULL AUTO_INCREMENT,
  `status_type` varchar(20) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` date NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_status_tbl`
--

INSERT INTO `user_status_tbl` (`status_id`, `status_type`, `is_deleted`, `date_created`) VALUES
(1, 'active', 0, '2018-01-17'),
(2, 'inactive', 0, '2018-01-17');

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

CREATE TABLE IF NOT EXISTS `user_tbl` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(2) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL,
  `status_id` int(2) NOT NULL DEFAULT '2',
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`user_id`, `role_id`, `username`, `password`, `status_id`, `date_added`, `date_updated`, `is_deleted`) VALUES
(1, 1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, '2018-01-17 00:00:00', '0000-00-00 00:00:00', 0),
(2, 2, 'school_user', '0d8f46159d977540cc20b5fe7cf8ed01', 1, '2018-02-22 13:22:21', '2018-02-22 13:22:21', 0),
(3, 2, 'school_user', '042d3d1486902fd13217f6b8f7eace35', 1, '2018-01-17 00:00:00', '2018-11-24 21:24:12', 0),
(4, 2, 'school_user', 'a79a036baa7e49497a026ee72c5614d0', 1, '2018-03-06 09:42:04', '2018-03-06 09:42:04', 0),
(5, 2, 'school_user', '1c945f262235c458fc751da4cb9e6114', 1, '2018-03-06 09:43:23', '2018-03-06 09:43:23', 0),
(6, 2, 'school_user', '1a9b4dddd9221dd609aed8dcf5e101a3', 1, '2018-03-06 09:45:12', '2018-03-06 09:45:12', 0),
(7, 2, 'school_user', '1602a1bde516f3a4589ae4c770a38641', 1, '2018-03-06 09:47:32', '2018-03-06 09:47:32', 0),
(8, 2, 'school_user', '2f71eafd7eefba1bbafdf567d08c6c82', 1, '2018-03-06 09:48:50', '2018-03-06 09:48:50', 0),
(9, 2, 'school_user', 'ec0adfaa7c5c01a406374855517f1744', 1, '2018-03-06 09:49:50', '2018-03-06 09:49:50', 0),
(10, 2, 'school_user', '7c2cb5eb5f7118f15fd4d8f075cb891a', 1, '2018-03-06 09:50:52', '2018-03-06 09:50:52', 0),
(11, 2, 'school_user', 'e98fbfe954ceb9337af129d63210ba13', 1, '2018-03-06 09:52:40', '2018-03-06 09:52:40', 0),
(12, 2, 'school_user', '7713775c338ea5454d3666ad0005bd97', 1, '2018-03-06 09:54:39', '2018-03-06 09:54:39', 0),
(13, 2, 'school_user', '16ee8e55be5c1e9b4853248a39e7655b', 1, '2018-03-06 09:55:40', '2018-03-06 09:55:40', 0),
(14, 2, 'school_user', 'ba3531d63687a950909fc1eca7092199', 1, '2018-10-14 17:14:49', '2018-10-14 17:14:49', 0),
(15, 2, 'school_user', 'ba3531d63687a950909fc1eca7092199', 1, '2018-10-14 17:22:02', '2018-10-14 17:22:02', 0),
(16, 3, 'zonal_user', '22df16e66f959434f00faa387f4dddd8 ', 1, '2018-10-24 21:53:26', '2018-10-24 21:53:26', 0),
(17, 4, 'department_user', '6858b6f855ed65b79ac853ed07fa9318', 1, '2018-10-24 22:00:03', '2018-10-24 22:00:03', 0),
(18, 5, 'director', '3d4e992d8d8a7d848724aa26ed7f4176 ', 1, '2018-10-24 22:00:03', '2018-10-24 22:00:03', 0),
(19, 6, 'assdirector', 'd410a74ecd37310d4579bb54ec72b881', 1, '2018-10-24 22:06:03', '2018-10-24 22:06:03', 0),
(20, 2, 'school_user', 'a785de81f6d70e10f0c8fccc466afd3c', 1, '2018-11-11 21:16:37', '2018-11-11 21:16:37', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_track_tbl`
--

CREATE TABLE IF NOT EXISTS `user_track_tbl` (
  `user_track_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `key_on_row` varchar(10) COLLATE utf8_sinhala_ci NOT NULL,
  `tbl_name` varchar(60) COLLATE utf8_sinhala_ci NOT NULL,
  `act_type_id` int(2) NOT NULL,
  `note` varchar(255) COLLATE utf8_sinhala_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_track_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_sinhala_ci AUTO_INCREMENT=148 ;

--
-- Dumping data for table `user_track_tbl`
--

INSERT INTO `user_track_tbl` (`user_track_id`, `user_id`, `key_on_row`, `tbl_name`, `act_type_id`, `note`, `date_added`, `is_deleted`) VALUES
(1, 4, '07065', 'school_details_tbl', 3, 'School details updated', '2018-11-11 23:23:09', 0),
(2, 3, '', '', 1, 'Logged in to the system', '2018-11-11 23:23:39', 0),
(3, 3, '', 'sanitary_item_details_tbl', 2, 'Sanitary details inserted', '2018-11-12 00:14:23', 0),
(4, 3, '', 'sanitary_item_details_tbl', 3, 'Sanitary details updated', '2018-11-12 00:19:29', 0),
(5, 3, '', 'sanitary_item_details_tbl', 2, 'Sanitary details Inserted', '2018-11-12 00:22:27', 0),
(6, 3, '', 'sanitary_item_details_tbl', 4, 'Sanitary details deleted', '2018-11-12 00:22:39', 0),
(7, 1, '', '', 1, 'Logged in to the system', '2018-11-12 21:18:46', 0),
(8, 1, '', '', 1, 'Logged in to the system', '2018-11-12 23:39:14', 0),
(9, 1, '', '', 1, 'Logged in to the system', '2018-11-12 23:41:35', 0),
(10, 1, '', '', 1, 'Logged in to the system', '2018-11-13 00:08:13', 0),
(11, 1, '', '', 1, 'Logged in to the system', '2018-11-13 16:32:47', 0),
(12, 1, '', '', 1, 'Logged in to the system', '2018-11-13 23:09:21', 0),
(13, 1, '', '', 1, 'Logged in to the system', '2018-11-14 20:16:54', 0),
(14, 1, '', '', 1, 'Logged in to the system', '2018-11-15 21:08:34', 0),
(15, 3, '', '', 1, 'Logged in to the system', '2018-11-19 15:13:02', 0),
(16, 3, '', '', 1, 'Logged in to the system', '2018-11-19 17:03:43', 0),
(17, 3, '3', 'user_tbl', 3, 'Changed the username', '2018-11-19 17:13:58', 0),
(18, 3, '', '', 1, 'Logged in to the system', '2018-11-20 17:59:40', 0),
(19, 3, '', '', 1, 'Logged in to the system', '2018-11-22 21:50:36', 0),
(20, 3, '3', 'user_tbl', 3, 'Changed the password', '2018-11-22 22:26:41', 0),
(21, 3, '', '', 1, 'Logged in to the system', '2018-11-22 22:27:53', 0),
(22, 3, '3', 'user_tbl', 3, 'Changed the password', '2018-11-22 22:56:08', 0),
(23, 3, '3', 'user_tbl', 3, 'Changed the password', '2018-11-22 22:59:42', 0),
(24, 3, '3', 'user_tbl', 3, 'Changed the password', '2018-11-22 23:10:16', 0),
(25, 3, '3', 'user_tbl', 3, 'Changed the password', '2018-11-22 23:27:11', 0),
(26, 3, '3', 'user_tbl', 3, 'Changed the password', '2018-11-22 23:29:54', 0),
(27, 3, '3', 'user_tbl', 3, 'Changed the password', '2018-11-22 23:31:32', 0),
(28, 3, '3', 'user_tbl', 3, 'Changed the password', '2018-11-22 23:32:45', 0),
(29, 3, '3', 'user_tbl', 3, 'Changed the password', '2018-11-22 23:37:58', 0),
(30, 3, '3', 'user_tbl', 3, 'Changed the password', '2018-11-22 23:38:19', 0),
(31, 3, '', '', 1, 'Logged in to the system', '2018-11-23 23:29:22', 0),
(32, 3, '3', 'user_tbl', 3, 'Changed the password', '2018-11-23 23:37:33', 0),
(33, 3, '3', 'user_tbl', 3, 'Changed the password', '2018-11-23 23:42:12', 0),
(34, 3, '3', 'user_tbl', 3, 'Changed the password', '2018-11-23 23:46:05', 0),
(35, 3, '', '', 1, 'Logged in to the system', '2018-11-23 23:50:45', 0),
(36, 3, '3', 'user_tbl', 3, 'Changed the password', '2018-11-23 23:51:13', 0),
(37, 3, '3', 'user_tbl', 3, 'Changed the password', '2018-11-24 00:10:57', 0),
(38, 3, '3', 'user_tbl', 3, 'Changed the password', '2018-11-24 00:19:16', 0),
(39, 3, '', '', 1, 'Logged in to the system', '2018-11-24 19:55:31', 0),
(40, 3, '3', 'user_tbl', 3, 'Changed the password', '2018-11-24 19:55:50', 0),
(41, 3, '', '', 1, 'Logged in to the system', '2018-11-24 20:10:16', 0),
(42, 9, '', '', 1, 'Logged in to the system', '2018-12-14 20:45:29', 0),
(43, 4, '', '', 1, 'Logged in to the system', '2018-12-31 07:31:26', 0),
(44, 1, '', '', 1, 'Logged in to the system', '2018-12-31 07:32:43', 0),
(45, 3, '', '', 1, 'Logged in to the system', '2018-12-31 07:34:59', 0),
(46, 1, '', '', 1, 'Logged in to the system', '2019-10-24 00:14:41', 0),
(47, 1, '', '', 1, 'Logged in to the system', '2019-10-24 00:15:05', 0),
(48, 1, '', '', 1, 'Logged in to the system', '2019-10-24 00:15:30', 0),
(49, 1, '', '', 1, 'Logged in to the system', '2019-10-24 00:16:12', 0),
(50, 1, '', '', 1, 'Logged in to the system', '2019-10-24 00:17:21', 0),
(51, 2, '', '', 1, 'Logged in to the system', '2019-10-24 00:18:08', 0),
(52, 1, '', '', 1, 'Logged in to the system', '2019-10-24 00:18:49', 0),
(53, 1, '', '', 1, 'Logged in to the system', '2019-10-24 00:18:59', 0),
(54, 1, '', '', 1, 'Logged in to the system', '2019-10-24 00:21:12', 0),
(55, 1, '', '', 1, 'Logged in to the system', '2019-10-24 00:25:55', 0),
(56, 1, '', '', 1, 'Logged in to the system', '2019-10-27 23:21:02', 0),
(57, 1, '', '', 1, 'Logged in to the system', '2019-10-27 23:21:49', 0),
(58, 1, '', '', 1, 'Logged in to the system', '2019-10-27 23:35:42', 0),
(59, 1, '', '', 1, 'Logged in to the system', '2019-10-27 23:36:01', 0),
(60, 3, '', '', 1, 'Logged in to the system', '2019-10-27 23:38:44', 0),
(61, 1, '', '', 1, 'Logged in to the system', '2019-10-27 23:40:22', 0),
(62, 3, '', '', 1, 'Logged in to the system', '2019-10-27 23:40:39', 0),
(63, 3, '', '', 1, 'Logged in to the system', '2019-10-27 23:40:58', 0),
(64, 3, '', '', 1, 'Logged in to the system', '2019-10-27 23:48:01', 0),
(65, 3, '', '', 1, 'Logged in to the system', '2019-10-27 23:48:15', 0),
(66, 1, '', '', 1, 'Logged in to the system', '2019-10-27 23:48:28', 0),
(67, 1, '', '', 1, 'Logged in to the system', '2019-10-27 23:58:22', 0),
(68, 1, '', '', 1, 'Logged in to the system', '2019-10-27 23:58:35', 0),
(69, 1, '', '', 1, 'Logged in to the system', '2019-10-28 00:00:51', 0),
(70, 1, '', '', 1, 'Logged in to the system', '2019-10-28 00:01:00', 0),
(71, 1, '', '', 1, 'Logged in to the system', '2019-10-28 00:01:23', 0),
(72, 1, '', '', 1, 'Logged in to the system', '2019-10-28 00:02:28', 0),
(73, 1, '', '', 1, 'Logged in to the system', '2019-10-28 00:15:33', 0),
(74, 1, '', '', 1, 'Logged in to the system', '2019-10-28 00:16:49', 0),
(75, 1, '', '', 1, 'Logged in to the system', '2019-10-28 00:17:06', 0),
(76, 1, '', '', 1, 'Logged in to the system', '2019-10-28 00:34:42', 0),
(77, 1, '', '', 1, 'Logged in to the system', '2019-10-28 00:50:41', 0),
(78, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:00:03', 0),
(79, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:00:18', 0),
(80, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:00:50', 0),
(81, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:01:05', 0),
(82, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:02:07', 0),
(83, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:10:38', 0),
(84, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:15:08', 0),
(85, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:17:41', 0),
(86, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:24:55', 0),
(87, 3, '', '', 1, 'Logged in to the system', '2019-10-28 01:26:15', 0),
(88, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:27:08', 0),
(89, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:28:49', 0),
(90, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:29:37', 0),
(91, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:30:32', 0),
(92, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:31:38', 0),
(93, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:33:27', 0),
(94, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:33:40', 0),
(95, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:38:14', 0),
(96, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:38:29', 0),
(97, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:38:45', 0),
(98, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:38:53', 0),
(99, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:39:02', 0),
(100, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:48:32', 0),
(101, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:51:19', 0),
(102, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:55:29', 0),
(103, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:57:17', 0),
(104, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:57:28', 0),
(105, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:57:35', 0),
(106, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:57:59', 0),
(107, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:58:06', 0),
(108, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:58:17', 0),
(109, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:58:42', 0),
(110, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:58:52', 0),
(111, 1, '', '', 1, 'Logged in to the system', '2019-10-28 01:59:44', 0),
(112, 1, '', '', 1, 'Logged in to the system', '2019-10-28 02:00:14', 0),
(113, 1, '', '', 1, 'Logged in to the system', '2019-10-28 02:00:55', 0),
(114, 1, '', '', 1, 'Logged in to the system', '2019-10-28 02:01:19', 0),
(115, 1, '', '', 1, 'Logged in to the system', '2019-10-28 02:01:24', 0),
(116, 1, '', '', 1, 'Logged in to the system', '2019-10-28 02:01:42', 0),
(117, 1, '', '', 1, 'Logged in to the system', '2019-10-28 02:01:46', 0),
(118, 1, '', '', 1, 'Logged in to the system', '2019-10-28 02:02:08', 0),
(119, 1, '', '', 1, 'Logged in to the system', '2019-10-28 02:03:42', 0),
(120, 1, '', '', 1, 'Logged in to the system', '2019-10-28 02:03:46', 0),
(121, 1, '', '', 1, 'Logged in to the system', '2019-10-28 02:08:16', 0),
(122, 1, '', '', 1, 'Logged in to the system', '2019-10-28 21:26:34', 0),
(123, 1, '', '', 1, 'Logged in to the system', '2019-10-28 21:37:19', 0),
(124, 3, '', '', 1, 'Logged in to the system', '2019-10-28 21:49:11', 0),
(125, 1, '', '', 1, 'Logged in to the system', '2019-10-28 23:27:17', 0),
(126, 1, '', '', 1, 'Logged in to the system', '2019-10-29 16:06:05', 0),
(127, 3, '', '', 1, 'Logged in to the system', '2019-10-29 17:34:04', 0),
(128, 4, '', '', 1, 'Logged in to the system', '2019-10-30 07:36:59', 0),
(129, 1, '', '', 1, 'Logged in to the system', '2019-10-30 09:00:57', 0),
(130, 1, '', '', 1, 'Logged in to the system', '2019-10-31 23:46:04', 0),
(131, 3, '', '', 1, 'Logged in to the system', '2019-10-31 23:57:18', 0),
(132, 1, '', '', 1, 'Logged in to the system', '2019-11-02 07:17:22', 0),
(133, 4, '', '', 1, 'Logged in to the system', '2019-11-02 07:26:57', 0),
(134, 3, '', '', 1, 'Logged in to the system', '2019-11-02 07:34:32', 0),
(135, 1, '', '', 1, 'Logged in to the system', '2019-11-02 09:24:01', 0),
(136, 3, '', '', 1, 'Logged in to the system', '2019-11-03 22:28:53', 0),
(137, 1, '', '', 1, 'Logged in to the system', '2019-11-03 22:29:22', 0),
(138, 1, '', '', 1, 'Logged in to the system', '2019-11-05 09:13:18', 0),
(139, 1, '', '', 1, 'Logged in to the system', '2019-11-12 22:30:49', 0),
(140, 3, '', '', 1, 'Logged in to the system', '2019-11-12 22:40:59', 0),
(141, 9, '', '', 1, 'Logged in to the system', '2019-11-12 22:51:27', 0),
(142, 3, '', '', 1, 'Logged in to the system', '2019-11-12 23:40:02', 0),
(143, 4, '', '', 1, 'Logged in to the system', '2019-11-12 23:49:30', 0),
(144, 3, '', '', 1, 'Logged in to the system', '2019-11-12 23:50:32', 0),
(145, 4, '', '', 1, 'Logged in to the system', '2019-11-12 23:50:56', 0),
(146, 1, '', '', 1, 'Logged in to the system', '2019-12-02 23:28:33', 0),
(147, 4, '', '', 1, 'Logged in to the system', '2019-12-02 23:32:31', 0);

-- --------------------------------------------------------

--
-- Table structure for table `zonal_staff_tbl`
--

CREATE TABLE IF NOT EXISTS `zonal_staff_tbl` (
  `stf_id` int(11) NOT NULL AUTO_INCREMENT,
  `name_with_ini` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `nick_name` varchar(30) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `nic_no` varchar(12) NOT NULL,
  `dob` date NOT NULL,
  `gender_id` int(5) NOT NULL,
  `civil_status_id` int(5) NOT NULL,
  `ethnic_group_id` int(5) NOT NULL,
  `religion_id` int(2) NOT NULL,
  `phone_home` varchar(10) NOT NULL,
  `phone_mobile1` varchar(10) NOT NULL,
  `phone_mobile2` varchar(10) NOT NULL,
  `vehicle_no1` varchar(15) NOT NULL,
  `vehicle_no2` varchar(15) NOT NULL,
  `email` varchar(60) NOT NULL,
  `edu_q_id` int(2) NOT NULL,
  `prof_q_id` int(3) NOT NULL,
  `desig_id` int(5) NOT NULL,
  `serv_grd_id` int(5) NOT NULL,
  `zo_sec_id` int(5) NOT NULL,
  `stf_type_id` int(2) NOT NULL,
  `stf_status_id` int(2) NOT NULL,
  `first_app_dt` date NOT NULL,
  `zonal_dt` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`stf_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `zonal_staff_tbl`
--

INSERT INTO `zonal_staff_tbl` (`stf_id`, `name_with_ini`, `full_name`, `nick_name`, `address1`, `address2`, `nic_no`, `dob`, `gender_id`, `civil_status_id`, `ethnic_group_id`, `religion_id`, `phone_home`, `phone_mobile1`, `phone_mobile2`, `vehicle_no1`, `vehicle_no2`, `email`, `edu_q_id`, `prof_q_id`, `desig_id`, `serv_grd_id`, `zo_sec_id`, `stf_type_id`, `stf_status_id`, `first_app_dt`, `zonal_dt`, `user_id`, `date_added`, `date_updated`, `is_deleted`) VALUES
(1, '', '', '', '', '', '45', '0000-00-00', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, 0, 0, 0, 1, 0, '0000-00-00', '0000-00-00', 0, '2018-10-10 14:53:38', '2018-10-10 14:53:38', 0),
(2, '', '', '', '', '', '56', '0000-00-00', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, 0, 0, 0, 1, 0, '0000-00-00', '0000-00-00', 0, '2018-10-10 15:09:15', '2018-10-10 15:09:15', 0),
(4, '', '', '', '', '', '123', '0000-00-00', 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '0000-00-00', '0000-00-00', 0, '2018-10-12 08:15:51', '2018-10-12 08:15:51', 0),
(5, 'MGP Prasanna', 'Meepe Gamage Pubudu Prasanna', 'Pubudu', 'Pilana', 'Habaraduwa', '840503429V', '1984-02-19', 1, 1, 0, 0, '', '0715885993', '0772944505', 'SPXD-1727', '', 'mgpprasan@gmail.com', 3, 19, 4, 10, 2, 1, 1, '0000-00-00', '2018-07-26', 0, '2018-10-12 13:46:17', '2018-10-12 13:46:17', 0),
(6, 'WMP Ganga', '', '', '', '', '785603429V', '0000-00-00', 2, 0, 0, 0, '', '', '', '', '', '', 0, 0, 4, 0, 3, 1, 1, '0000-00-00', '0000-00-00', 0, '2018-10-16 14:04:50', '2018-10-16 14:04:50', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
