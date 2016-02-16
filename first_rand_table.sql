-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2016 at 10:52 AM
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
-- Table structure for table `first_rand_table`
--

CREATE TABLE IF NOT EXISTS `first_rand_table` (
`id` int(11) NOT NULL,
  `officer_name` varchar(50) DEFAULT NULL,
  `person_desig` varchar(50) DEFAULT NULL,
  `personcd` char(11) DEFAULT NULL,
  `office` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `block_muni` char(6) DEFAULT NULL,
  `block_muni_name` varchar(50) DEFAULT NULL,
  `postoffice` varchar(30) DEFAULT NULL,
  `subdivision` varchar(30) DEFAULT NULL,
  `policestation` varchar(30) DEFAULT NULL,
  `pc_code` char(2) DEFAULT NULL,
  `pc_name` char(35) DEFAULT NULL,
  `district` char(20) DEFAULT NULL,
  `pin` char(6) DEFAULT NULL,
  `officecd` char(10) DEFAULT NULL,
  `poststatus` char(20) DEFAULT NULL,
  `mob_no` char(16) DEFAULT NULL,
  `training_desc` char(20) DEFAULT NULL,
  `venuename` varchar(50) DEFAULT NULL,
  `venueaddress` varchar(100) DEFAULT NULL,
  `training_dt` char(20) DEFAULT NULL,
  `training_time` char(20) DEFAULT NULL,
  `epic` varchar(30) DEFAULT NULL,
  `acno` char(3) DEFAULT NULL,
  `partno` char(10) DEFAULT NULL,
  `slno` char(10) DEFAULT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `branch` varchar(50) DEFAULT NULL,
  `bank_accno` varchar(20) DEFAULT NULL,
  `ifsc` varchar(20) DEFAULT NULL,
  `forsubdivision` char(4) DEFAULT NULL,
  `token` char(13) DEFAULT NULL,
  `sl_no` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `first_rand_table`
--
ALTER TABLE `first_rand_table`
 ADD PRIMARY KEY (`id`), ADD KEY `forsubdivision` (`forsubdivision`), ADD KEY `sub_sl_no` (`block_muni`,`officecd`,`personcd`,`poststatus`,`person_desig`), ADD KEY `sl_no` (`sl_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `first_rand_table`
--
ALTER TABLE `first_rand_table`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
