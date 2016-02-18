-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 05, 2016 at 11:29 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ppds`
--

-- --------------------------------------------------------

--
-- Table structure for table `training_type`
--

CREATE TABLE IF NOT EXISTS `training_type` (
  `training_code` char(2) NOT NULL,
  `training_desc` varchar(20) CHARACTER SET utf8 NOT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `training_type`
--

INSERT INTO `training_type` (`training_code`, `training_desc`, `usercode`, `posted_date`) VALUES
('01', 'First Training', 1, '2014-02-24 07:09:11'),
('02', 'Second Training', 5, '2014-02-20 01:15:19'),
('03', 'Third Training', 1, '2014-01-29 21:43:11');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
