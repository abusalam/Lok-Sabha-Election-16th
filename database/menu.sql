-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2016 at 09:08 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ppds`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `menu_cd` int(2) NOT NULL,
  `menu` varchar(20) NOT NULL,
  `link` varchar(30) DEFAULT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_cd`, `menu`, `link`, `usercode`, `posted_date`) VALUES
(1, 'User Management', 'user-reg.php', 1, '2013-12-24 07:58:24'),
(2, 'Master Data', NULL, 1, '2014-01-20 03:56:01'),
(3, 'Office Details', NULL, 1, '2013-12-24 07:58:24'),
(4, 'Polling Personnel', NULL, 1, '2013-12-24 07:58:24'),
(5, 'Replacement', NULL, 1, '2013-12-24 07:58:24'),
(6, 'Training', NULL, 1, '2013-12-27 03:05:55'),
(7, 'Other Data', NULL, 1, '2014-01-03 20:27:06'),
(8, 'Randomisation', NULL, 1, '2014-01-15 05:59:56'),
(9, 'Reports', NULL, 1, '2014-01-20 03:45:57'),
(10, 'Data Manager', NULL, 1, '2015-12-16 09:49:57'),
(11, 'Extra PP', NULL, 1, '2016-02-11 11:37:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
 ADD PRIMARY KEY (`menu_cd`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
