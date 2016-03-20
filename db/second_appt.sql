-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 20, 2016 at 03:57 PM
-- Server version: 5.1.73
-- PHP Version: 5.3.29

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ppds_burdwan`
--

-- --------------------------------------------------------

--
-- Table structure for table `second_appt`
--

CREATE TABLE IF NOT EXISTS `second_appt` (
  `slno` bigint(7) NOT NULL DEFAULT '0',
  `pers_off` char(10) DEFAULT NULL,
  `per_poststat` char(2) DEFAULT NULL,
  `groupid` char(4) DEFAULT NULL,
  `block_muni_cd` char(6) DEFAULT NULL,
  `block_muni_name` varchar(50) DEFAULT NULL,
  `assembly` char(3) DEFAULT NULL,
  `assembly_name` varchar(30) DEFAULT NULL,
  `mem_no` int(4) DEFAULT NULL,
  `pccd` char(2) DEFAULT NULL,
  `subdivcd` char(4) NOT NULL,
  `pcname` varchar(30) DEFAULT NULL,
  `pr_personcd` char(11) DEFAULT NULL,
  `p1_personcd` char(11) DEFAULT NULL,
  `p2_personcd` char(11) DEFAULT NULL,
  `p3_personcd` char(11) DEFAULT NULL,
  `pa_personcd` char(11) DEFAULT NULL,
  `pb_personcd` char(11) DEFAULT NULL,
  `mo_personcd` char(11) DEFAULT NULL,
  `pr_name` varchar(50) DEFAULT NULL,
  `p1_name` varchar(50) DEFAULT NULL,
  `p2_name` varchar(50) DEFAULT NULL,
  `p3_name` varchar(50) DEFAULT NULL,
  `pa_name` varchar(50) DEFAULT NULL,
  `pb_name` varchar(50) DEFAULT NULL,
  `mo_name` varchar(50) DEFAULT NULL,
  `pr_designation` varchar(50) DEFAULT NULL,
  `p1_designation` varchar(50) DEFAULT NULL,
  `p2_designation` varchar(50) DEFAULT NULL,
  `p3_designation` varchar(50) DEFAULT NULL,
  `pa_designation` varchar(50) DEFAULT NULL,
  `pb_designation` varchar(50) DEFAULT NULL,
  `mo_designation` varchar(50) DEFAULT NULL,
  `pr_status` char(2) DEFAULT NULL,
  `p1_status` char(2) DEFAULT NULL,
  `p2_status` char(2) DEFAULT NULL,
  `p3_status` char(2) DEFAULT NULL,
  `pa_status` char(2) DEFAULT NULL,
  `pb_status` char(2) DEFAULT NULL,
  `mo_status` char(2) DEFAULT NULL,
  `pr_post_stat` varchar(28) DEFAULT NULL,
  `p1_post_stat` varchar(28) DEFAULT NULL,
  `p2_post_stat` varchar(28) DEFAULT NULL,
  `p3_post_stat` varchar(28) DEFAULT NULL,
  `pa_post_stat` varchar(28) DEFAULT NULL,
  `pb_post_stat` varchar(28) DEFAULT NULL,
  `mo_post_stat` varchar(28) DEFAULT NULL,
  `pr_officecd` char(10) DEFAULT NULL,
  `p1_officecd` char(10) DEFAULT NULL,
  `p2_officecd` char(10) DEFAULT NULL,
  `p3_officecd` char(10) DEFAULT NULL,
  `pa_officecd` char(10) DEFAULT NULL,
  `pb_officecd` char(10) DEFAULT NULL,
  `mo_officecd` char(10) DEFAULT NULL,
  `pr_officename` varchar(50) DEFAULT NULL,
  `p1_officename` varchar(50) DEFAULT NULL,
  `p2_officename` varchar(50) DEFAULT NULL,
  `p3_officename` varchar(50) DEFAULT NULL,
  `pa_officename` varchar(50) DEFAULT NULL,
  `pb_officename` varchar(50) DEFAULT NULL,
  `mo_officename` varchar(50) DEFAULT NULL,
  `mo_officeaddress` varchar(100) DEFAULT NULL,
  `pr_officeaddress` varchar(100) DEFAULT NULL,
  `p1_officeaddress` varchar(100) DEFAULT NULL,
  `p2_officeaddress` varchar(100) DEFAULT NULL,
  `p3_officeaddress` varchar(100) DEFAULT NULL,
  `pa_officeaddress` varchar(100) DEFAULT NULL,
  `pb_officeaddress` varchar(100) DEFAULT NULL,
  `pr_postoffice` varchar(40) DEFAULT NULL,
  `p1_postoffice` varchar(40) DEFAULT NULL,
  `p2_postoffice` varchar(40) DEFAULT NULL,
  `p3_postoffice` varchar(40) DEFAULT NULL,
  `pa_postoffice` varchar(40) DEFAULT NULL,
  `pb_postoffice` varchar(40) DEFAULT NULL,
  `mo_postoffice` varchar(40) DEFAULT NULL,
  `mo_subdivision` varchar(30) DEFAULT NULL,
  `pr_subdivision` varchar(30) DEFAULT NULL,
  `p1_subdivision` varchar(30) DEFAULT NULL,
  `p2_subdivision` varchar(30) DEFAULT NULL,
  `p3_subdivision` varchar(30) DEFAULT NULL,
  `pa_subdivision` varchar(30) DEFAULT NULL,
  `pb_subdivision` varchar(30) DEFAULT NULL,
  `pr_policestn` varchar(30) DEFAULT NULL,
  `p1_policestn` varchar(30) DEFAULT NULL,
  `p2_policestn` varchar(30) DEFAULT NULL,
  `p3_policestn` varchar(30) DEFAULT NULL,
  `pa_policestn` varchar(30) DEFAULT NULL,
  `pb_policestn` varchar(30) DEFAULT NULL,
  `mo_policestn` varchar(30) DEFAULT NULL,
  `mo_block` char(30) DEFAULT NULL,
  `pr_block` char(6) DEFAULT NULL,
  `p1_block` char(6) DEFAULT NULL,
  `p2_block` char(6) DEFAULT NULL,
  `p3_block` char(6) DEFAULT NULL,
  `pa_block` char(6) DEFAULT NULL,
  `pb_block` char(6) DEFAULT NULL,
  `district` varchar(20) DEFAULT NULL,
  `pr_pincode` char(6) DEFAULT NULL,
  `p1_pincode` char(6) DEFAULT NULL,
  `p2_pincode` char(6) DEFAULT NULL,
  `p3_pincode` char(6) DEFAULT NULL,
  `pa_pincode` char(6) DEFAULT NULL,
  `pb_pincode` char(6) DEFAULT NULL,
  `mo_pincode` char(6) DEFAULT NULL,
  `mo_mobno` char(12) NOT NULL DEFAULT '0',
  `pr_mobno` char(12) NOT NULL DEFAULT '0',
  `p1_mobno` char(12) NOT NULL DEFAULT '0',
  `p2_mobno` char(12) NOT NULL DEFAULT '0',
  `p3_mobno` char(12) NOT NULL DEFAULT '0',
  `pa_mobno` char(12) NOT NULL DEFAULT '0',
  `pb_mobno` char(12) NOT NULL DEFAULT '0',
  `dc_venue` varchar(45) DEFAULT NULL,
  `dc_address` varchar(45) DEFAULT NULL,
  `dc_date` char(10) DEFAULT NULL,
  `dc_time` char(15) DEFAULT NULL,
  `rc_venue` varchar(45) DEFAULT NULL,
  `traingcode` char(9) DEFAULT NULL,
  `training_venue` varchar(50) DEFAULT NULL,
  `venuecode` char(6) DEFAULT NULL,
  `venue_addr1` varchar(50) DEFAULT NULL,
  `venue_addr2` varchar(50) DEFAULT NULL,
  `training_date` date DEFAULT NULL,
  `training_time` varchar(20) DEFAULT NULL,
  `polldate` date DEFAULT NULL,
  `polltime` varchar(20) DEFAULT NULL,
  `dcrcgrp` char(6) DEFAULT NULL,
  KEY `groupid` (`groupid`,`assembly`,`traingcode`,`venuecode`,`dcrcgrp`),
  KEY `per_asm_gd` (`groupid`,`assembly`),
  KEY `sec_post_ofc_cd` (`pr_officecd`,`p1_officecd`,`p2_officecd`,`p3_officecd`,`pa_officecd`,`pb_officecd`),
  KEY `sec_post_sub_cd` (`pr_subdivision`,`p1_subdivision`,`p3_subdivision`,`pa_subdivision`,`pb_subdivision`,`p2_subdivision`,`subdivcd`),
  KEY `groupid_2` (`groupid`,`assembly`),
  KEY `slno` (`slno`),
  KEY `block_muni_cd` (`block_muni_cd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
