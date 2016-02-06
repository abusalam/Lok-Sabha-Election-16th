-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 22, 2016 at 04:27 PM
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
-- Table structure for table `assembly`
--

CREATE TABLE IF NOT EXISTS `assembly` (
  `assemblycd` char(3) CHARACTER SET utf8 NOT NULL,
  `pccd` char(2) CHARACTER SET utf8 NOT NULL,
  `assemblyname` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `districtcd` char(2) CHARACTER SET utf8 NOT NULL,
  `subdivisioncd` char(4) CHARACTER SET utf8 DEFAULT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`assemblycd`),
  KEY `pccd` (`pccd`),
  KEY `districtcd` (`districtcd`),
  KEY `subdivisioncd` (`subdivisioncd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assembly_party`
--

CREATE TABLE IF NOT EXISTS `assembly_party` (
  `assemblycd` char(3) CHARACTER SET utf8 NOT NULL,
  `no_of_member` smallint(6) NOT NULL,
  `pccd` char(2) CHARACTER SET utf8 NOT NULL,
  `start_sl` smallint(6) DEFAULT '0',
  `no_party` smallint(6) DEFAULT NULL,
  `subdivisioncd` char(4) CHARACTER SET utf8 DEFAULT NULL,
  `rand_status` char(1) NOT NULL DEFAULT 'N',
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`assemblycd`,`no_of_member`),
  KEY `subdivisioncd` (`subdivisioncd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE IF NOT EXISTS `bank` (
  `bank_cd` char(5) CHARACTER SET utf8 NOT NULL,
  `bank_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `distcd` char(2) NOT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`bank_cd`),
  KEY `distcd` (`distcd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `block_muni`
--

CREATE TABLE IF NOT EXISTS `block_muni` (
  `blockminicd` char(6) CHARACTER SET utf8 NOT NULL,
  `subdivisioncd` char(4) CHARACTER SET utf8 NOT NULL,
  `blockmuni` varchar(50) CHARACTER SET utf8 NOT NULL,
  `block_or_muni` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `districtcd` char(2) CHARACTER SET utf8 DEFAULT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`blockminicd`),
  KEY `subdivisioncd` (`subdivisioncd`),
  KEY `districtcd` (`districtcd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE IF NOT EXISTS `branch` (
  `branchcd` char(3) CHARACTER SET utf8 NOT NULL,
  `bank_cd` char(5) CHARACTER SET utf8 NOT NULL,
  `branch_name` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `address` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `ifsc_code` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`branchcd`,`bank_cd`),
  KEY `fk_bank` (`bank_cd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dcrcmaster`
--

CREATE TABLE IF NOT EXISTS `dcrcmaster` (
  `dcrcgrp` char(6) CHARACTER SET utf8 NOT NULL,
  `assemblycd` char(3) CHARACTER SET utf8 NOT NULL,
  `no_of_member` smallint(6) DEFAULT NULL,
  `dc_venue` varchar(45) CHARACTER SET utf8 NOT NULL,
  `dc_addr` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `rcvenue` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `rc_addr` varchar(45) NOT NULL,
  `districtcd` char(2) CHARACTER SET utf8 NOT NULL,
  `subdivisioncd` char(4) CHARACTER SET utf8 NOT NULL,
  `usercode` int(11) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`dcrcgrp`),
  KEY `asm_cd_fk` (`assemblycd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dcrc_party`
--

CREATE TABLE IF NOT EXISTS `dcrc_party` (
  `assemblycd` char(3) CHARACTER SET utf8 NOT NULL,
  `number_of_member` smallint(6) DEFAULT NULL,
  `partyindcrc` smallint(6) DEFAULT NULL,
  `dcrcgrp` char(6) CHARACTER SET utf8 NOT NULL,
  `subdivisioncd` char(4) CHARACTER SET utf8 DEFAULT NULL,
  `forpc` char(2) NOT NULL,
  `dc_date` datetime NOT NULL,
  `dc_time` char(15) NOT NULL,
  `usercode` int(11) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE IF NOT EXISTS `designation` (
  `desgcd` char(4) CHARACTER SET utf8 NOT NULL,
  `designation` varchar(50) DEFAULT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE IF NOT EXISTS `district` (
  `districtcd` char(2) CHARACTER SET utf8 NOT NULL,
  `district` varchar(20) CHARACTER SET utf8 NOT NULL,
  `subdsl` smallint(6) DEFAULT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`districtcd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`districtcd`, `district`, `subdsl`, `usercode`, `posted_date`) VALUES
('01', 'COOCHBIHAR', NULL, 1, '2016-01-08 09:53:18'),
('02', 'JALPAIGURI', NULL, 1, '2016-01-08 09:53:18'),
('03', 'DARJEELING', NULL, 1, '2016-01-08 09:54:30'),
('04', 'UTTAR DINAJPUR', NULL, 1, '2016-01-08 09:54:30'),
('05', 'DAKSHIN DINAJPUR ', NULL, 1, '2016-01-08 09:55:29'),
('06', 'MALDA', NULL, 1, '2016-01-08 09:55:29'),
('07', 'MURSHIDABAD', NULL, 1, '2016-01-08 09:56:21'),
('08', 'NADIA', NULL, 1, '2016-01-08 09:56:21'),
('09', 'UTTAR 24 PARGANA', NULL, 1, '2016-01-08 09:59:38'),
('10', 'DAKSHIN 24 PARGANA', NULL, 1, '2016-01-08 09:59:38'),
('11', 'KOLKATA', NULL, 1, '2016-01-08 10:00:09'),
('12', 'HOWRAH', NULL, 1, '2016-01-08 10:00:09'),
('13', 'HOOGHLY', NULL, 1, '2016-01-08 10:01:41'),
('14', 'PURBA MIDNAPORE', NULL, 1, '2016-01-08 10:01:41'),
('15', 'PASCHIM MIDNAPORE', NULL, 1, '2016-01-08 10:03:25'),
('16', 'PURULIA', NULL, 1, '2016-01-08 10:03:25'),
('17', 'BANKURA', NULL, 1, '2016-01-08 10:04:02'),
('18', 'BURDWAN', NULL, 1, '2016-01-08 10:04:02'),
('19', 'BIRBHUM', NULL, 1, '2016-01-08 10:04:45'),
('20', 'ALIPURDUAR', NULL, 1, '2016-01-08 10:04:45');

-- --------------------------------------------------------

--
-- Table structure for table `environment`
--

CREATE TABLE IF NOT EXISTS `environment` (
  `env_cd` int(2) NOT NULL AUTO_INCREMENT,
  `environment` varchar(50) NOT NULL,
  `dist_cd` char(2) NOT NULL,
  `distnm_sml` varchar(30) DEFAULT NULL,
  `distnm_cap` varchar(30) DEFAULT NULL,
  `apt1_orderno` varchar(25) DEFAULT NULL,
  `apt1_date` date DEFAULT NULL,
  `apt2_orderno` varchar(25) DEFAULT NULL,
  `apt2_date` date DEFAULT NULL,
  PRIMARY KEY (`env_cd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `first_rand_table`
--

CREATE TABLE IF NOT EXISTS `first_rand_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `officer_name` varchar(50) DEFAULT NULL,
  `person_desig` varchar(50) DEFAULT NULL,
  `personcd` char(11) DEFAULT NULL,
  `office` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `block_muni` char(6) DEFAULT NULL,
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
  `sl_no` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `forsubdivision` (`forsubdivision`),
  KEY `sub_sl_no` (`block_muni`,`officecd`,`personcd`,`poststatus`,`person_desig`),
  KEY `sl_no` (`sl_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `govtcategory`
--

CREATE TABLE IF NOT EXISTS `govtcategory` (
  `govt` char(2) CHARACTER SET utf8 NOT NULL,
  `govt_description` varchar(30) CHARACTER SET utf8 NOT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`govt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `govtcategory`
--

INSERT INTO `govtcategory` (`govt`, `govt_description`, `usercode`, `posted_date`) VALUES
('01', 'Central Government', 1, '2013-12-26 23:09:45'),
('02', 'State Government', 1, '2014-01-23 00:21:56'),
('03', 'Central Government Undertaking', 1, '2014-01-23 00:20:23'),
('04', 'State Government Undertaking', 1, '2014-01-23 00:20:23'),
('05', 'Local Bodies', 1, '2014-01-23 00:20:23'),
('06', 'Govt. Aided Organisation', 1, '2014-01-23 00:20:23'),
('07', 'Autonomous Body', 1, '2014-01-23 00:20:23'),
('08', 'Other', 1, '2014-01-23 00:20:23');

-- --------------------------------------------------------

--
-- Table structure for table `grp_dcrc`
--

CREATE TABLE IF NOT EXISTS `grp_dcrc` (
  `dcrccd` char(6) NOT NULL,
  `forsubdivision` char(4) DEFAULT NULL,
  `forpc` char(2) DEFAULT NULL,
  `forassembly` char(3) DEFAULT NULL,
  `groupid` smallint(6) DEFAULT NULL,
  `member` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `institute`
--

CREATE TABLE IF NOT EXISTS `institute` (
  `institutecd` char(2) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `institute` varchar(80) CHARACTER SET utf8 NOT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `institutecd` (`institutecd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `institute`
--

INSERT INTO `institute` (`institutecd`, `institute`, `usercode`, `posted_date`) VALUES
('01', 'Department/Directorate/Other subordinate Govt. Office', 1, '2013-12-26 23:14:00'),
('02', 'Railways', 1, '2014-01-23 00:41:40'),
('03', 'BSNL', 1, '2014-01-23 00:41:40'),
('04', 'Bank', 1, '2014-01-23 00:41:40'),
('05', 'LIC/GIC/Other Insurance Institution', 1, '2014-01-23 00:41:40'),
('06', 'Income Tax/Customs/Other Revenue Collection Authority', 1, '2014-01-23 00:41:40'),
('07', 'Primary School', 1, '2014-01-23 00:41:40'),
('08', 'Secondary/Higher Secondary School', 1, '2014-01-23 00:41:40'),
('09', 'College', 1, '2014-01-23 00:41:40'),
('10', 'University', 1, '2014-01-23 00:41:40'),
('11', 'Water/Electricity Supply', 1, '2014-01-23 00:41:40'),
('12', 'Panchayat Body', 1, '2014-01-23 00:41:40'),
('13', 'Municipal Body', 1, '2014-01-23 00:41:40'),
('14', 'Other', 1, '2014-01-23 00:41:40');

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `languagecd` char(2) CHARACTER SET utf8 NOT NULL,
  `language` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`languagecd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`languagecd`, `language`, `usercode`, `posted_date`) VALUES
('01', 'Hindi', 1, '2013-12-31 21:16:55'),
('02', 'Nepali', 1, '2013-12-26 19:19:44'),
('99', 'None', 1, '2014-01-28 00:08:06');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `menu_cd` int(2) NOT NULL,
  `menu` varchar(20) NOT NULL,
  `link` varchar(30) DEFAULT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`menu_cd`)
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
(10, 'Data Manager', NULL, 1, '2015-12-16 09:49:57');

-- --------------------------------------------------------

--
-- Table structure for table `office`
--

CREATE TABLE IF NOT EXISTS `office` (
  `officecd` char(10) CHARACTER SET utf8 NOT NULL,
  `ddocode` char(20) NOT NULL,
  `officer_desg` varchar(50) NOT NULL,
  `office` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `address1` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `address2` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `postoffice` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `pin` char(6) CHARACTER SET utf8 DEFAULT NULL,
  `blockormuni_cd` char(6) NOT NULL,
  `policestn_cd` char(6) NOT NULL,
  `govt` char(2) CHARACTER SET utf8 NOT NULL,
  `email` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `phone` varchar(14) CHARACTER SET utf8 DEFAULT NULL,
  `mobile` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
  `fax` varchar(14) CHARACTER SET utf8 DEFAULT NULL,
  `tot_staff` smallint(6) DEFAULT NULL,
  `male_staff` smallint(6) DEFAULT NULL,
  `female_staff` smallint(6) DEFAULT NULL,
  `assemblycd` char(3) CHARACTER SET utf8 DEFAULT NULL,
  `pccd` char(2) CHARACTER SET utf8 DEFAULT NULL,
  `subdivisioncd` char(4) CHARACTER SET utf8 NOT NULL,
  `districtcd` char(2) CHARACTER SET utf8 NOT NULL,
  `institutecd` char(2) CHARACTER SET utf8 NOT NULL,
  `officetype` char(2) CHARACTER SET utf8 DEFAULT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`officecd`),
  KEY `fk_govt` (`govt`),
  KEY `fk_institute` (`districtcd`,`institutecd`),
  KEY `fk_assemblycd` (`assemblycd`),
  KEY `fk_pco` (`pccd`,`subdivisioncd`),
  KEY `blockormuni_cd` (`blockormuni_cd`,`policestn_cd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `password`
--

CREATE TABLE IF NOT EXISTS `password` (
  `randomise` char(6) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` char(6) NOT NULL,
  `subdivisioncd` char(4) NOT NULL,
  `usercode` int(11) DEFAULT NULL,
  `posted_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`randomise`,`subdivisioncd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pc`
--

CREATE TABLE IF NOT EXISTS `pc` (
  `pccd` char(2) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `pcname` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `district` char(2) CHARACTER SET utf8 NOT NULL,
  `subdivisioncd` char(4) CHARACTER SET utf8 NOT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pccd`,`subdivisioncd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pers`
--

CREATE TABLE IF NOT EXISTS `pers` (
  `personcd` char(11) DEFAULT NULL,
  `forpc` char(2) DEFAULT NULL,
  `forassembly` char(3) DEFAULT NULL,
  `selected` char(1) DEFAULT NULL,
  `poststat` char(2) DEFAULT NULL,
  `assembly_temp` char(3) DEFAULT NULL,
  `assembly_off` char(3) DEFAULT NULL,
  `assembly_perm` char(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `personnel`
--

CREATE TABLE IF NOT EXISTS `personnel` (
  `personcd` char(11) CHARACTER SET utf8 NOT NULL,
  `officecd` char(10) CHARACTER SET utf8 NOT NULL,
  `officer_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `off_desg` varchar(50) NOT NULL,
  `present_addr1` varchar(50) CHARACTER SET utf8 NOT NULL,
  `present_addr2` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `perm_addr1` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `perm_addr2` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `dateofbirth` datetime DEFAULT NULL,
  `gender` char(6) CHARACTER SET utf8 DEFAULT NULL,
  `scale` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `basic_pay` int(6) DEFAULT NULL,
  `grade_pay` int(6) DEFAULT NULL,
  `workingstatus` char(3) NOT NULL,
  `email` varchar(30) DEFAULT NULL,
  `resi_no` char(14) DEFAULT NULL,
  `mob_no` char(12) NOT NULL,
  `qualificationcd` char(2) CHARACTER SET utf8 NOT NULL,
  `languagecd` char(2) CHARACTER SET utf8 NOT NULL,
  `epic` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `acno` char(3) DEFAULT NULL,
  `slno` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
  `partno` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
  `poststat` char(2) CHARACTER SET utf8 NOT NULL,
  `assembly_temp` char(3) CHARACTER SET utf8 DEFAULT NULL,
  `assembly_off` char(3) CHARACTER SET utf8 DEFAULT NULL,
  `assembly_perm` char(3) CHARACTER SET utf8 DEFAULT NULL,
  `districtcd` char(2) CHARACTER SET utf8 DEFAULT NULL,
  `subdivisioncd` char(4) CHARACTER SET utf8 DEFAULT NULL,
  `bank_acc_no` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `bank_cd` char(5) CHARACTER SET utf8 DEFAULT NULL,
  `branchcd` char(3) CHARACTER SET utf8 DEFAULT NULL,
  `remarks` varchar(2) CHARACTER SET utf8 NOT NULL,
  `pgroup` varchar(20) DEFAULT NULL,
  `upload_file` varchar(50) NOT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `f_cd` int(11) DEFAULT NULL,
  PRIMARY KEY (`personcd`),
  KEY `officecd` (`officecd`),
  KEY `per_sub_cd_fk` (`subdivisioncd`),
  KEY `per_dist_cd_fk` (`districtcd`),
  KEY `per_bank_cd_fk` (`bank_cd`),
  KEY `per_branch_cd_fk` (`branchcd`),
  KEY `fk_post_stat_cd` (`poststat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `personnela`
--

CREATE TABLE IF NOT EXISTS `personnela` (
  `personcd` char(11) CHARACTER SET utf8 NOT NULL,
  `officecd` char(10) CHARACTER SET utf8 NOT NULL,
  `officer_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `off_desg` varchar(50) CHARACTER SET utf8 NOT NULL,
  `present_addr1` varchar(50) CHARACTER SET utf8 NOT NULL,
  `present_addr2` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `perm_addr1` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `perm_addr2` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `dateofbirth` datetime DEFAULT NULL,
  `gender` char(6) CHARACTER SET utf8 DEFAULT NULL,
  `scale` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `basic_pay` int(6) DEFAULT NULL,
  `grade_pay` int(6) DEFAULT NULL,
  `workingstatus` char(3) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `resi_no` char(14) DEFAULT NULL,
  `mob_no` char(12) NOT NULL,
  `qualificationcd` char(2) CHARACTER SET utf8 NOT NULL,
  `languagecd` char(2) CHARACTER SET utf8 NOT NULL,
  `epic` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `acno` char(3) DEFAULT NULL,
  `slno` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
  `partno` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
  `poststat` char(2) CHARACTER SET utf8 NOT NULL,
  `assembly_temp` char(3) CHARACTER SET utf8 DEFAULT NULL,
  `assembly_off` char(3) CHARACTER SET utf8 DEFAULT NULL,
  `assembly_perm` char(3) CHARACTER SET utf8 DEFAULT NULL,
  `forsubdivision` char(4) CHARACTER SET utf8 DEFAULT NULL,
  `forpc` char(2) CHARACTER SET utf8 DEFAULT NULL,
  `forassembly` char(3) CHARACTER SET utf8 DEFAULT NULL,
  `groupid` smallint(6) DEFAULT NULL,
  `booked` char(1) DEFAULT '',
  `dcrccd` char(6) DEFAULT NULL,
  `selected` int(1) NOT NULL DEFAULT '0',
  `rand_numb` smallint(6) DEFAULT NULL,
  `edcpb` char(1) DEFAULT NULL,
  `districtcd` char(2) CHARACTER SET utf8 DEFAULT NULL,
  `subdivisioncd` char(4) CHARACTER SET utf8 DEFAULT NULL,
  `bank_acc_no` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `bank_cd` char(5) CHARACTER SET utf8 DEFAULT NULL,
  `branchcd` char(3) CHARACTER SET utf8 DEFAULT NULL,
  `remarks` char(2) CHARACTER SET utf8 DEFAULT NULL,
  `pgroup` varchar(20) DEFAULT NULL,
  `upload_file` varchar(50) DEFAULT NULL,
  `usercode` int(5) DEFAULT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `training2_sch` char(9) DEFAULT NULL,
  `ttrgschcopy` char(9) DEFAULT NULL,
  PRIMARY KEY (`personcd`),
  KEY `fk_officecd` (`officecd`),
  KEY `fk_poststat` (`poststat`),
  KEY `fk_qualification_cd` (`qualificationcd`),
  KEY `fk_language_cd` (`languagecd`),
  KEY `fk_lbank_cd` (`bank_cd`),
  KEY `fk_branch_cd` (`branchcd`),
  KEY `fk_asm_tmp_cd` (`assembly_temp`),
  KEY `fk_asm_off_cd` (`assembly_off`),
  KEY `fk_asm_perm_cd` (`assembly_perm`),
  KEY `forsubdivision` (`forsubdivision`,`forassembly`,`groupid`),
  KEY `rand_numb` (`rand_numb`),
  KEY `booked` (`booked`,`selected`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `per_test`
--

CREATE TABLE IF NOT EXISTS `per_test` (
  `personcd` char(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `policestation`
--

CREATE TABLE IF NOT EXISTS `policestation` (
  `policestationcd` char(6) CHARACTER SET utf8 NOT NULL,
  `subdivisioncd` char(4) CHARACTER SET utf8 NOT NULL,
  `policestation` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `districtcd` char(2) CHARACTER SET utf8 NOT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`policestationcd`),
  KEY `sub_cd_fk` (`subdivisioncd`),
  KEY `district_cd_fk` (`districtcd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pollingstation`
--

CREATE TABLE IF NOT EXISTS `pollingstation` (
  `code` int(6) NOT NULL AUTO_INCREMENT,
  `psno` smallint(6) NOT NULL,
  `psfix` varchar(5) DEFAULT NULL,
  `forsubdivision` char(4) DEFAULT NULL,
  `forpc` char(3) DEFAULT NULL,
  `forassembly` char(3) NOT NULL DEFAULT '',
  `dcrccd` char(6) NOT NULL,
  `groupid` smallint(6) DEFAULT NULL,
  `member` smallint(6) DEFAULT NULL,
  `psname` varchar(150) NOT NULL,
  `rand_numb` int(6) DEFAULT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `poll_table`
--

CREATE TABLE IF NOT EXISTS `poll_table` (
  `pc_cd` char(2) NOT NULL,
  `poll_date` datetime NOT NULL,
  `poll_time` char(20) NOT NULL,
  `usercode` int(11) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `assembly_cd` char(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `poststat`
--

CREATE TABLE IF NOT EXISTS `poststat` (
  `post_stat` char(2) CHARACTER SET utf8 NOT NULL,
  `poststatus` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_stat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `poststat`
--

INSERT INTO `poststat` (`post_stat`, `poststatus`, `usercode`, `posted_date`) VALUES
('MO', 'Micro Observer', 1, '2014-03-11 04:44:57'),
('P1', '1st Polling Officer', 1, '2013-12-26 15:29:54'),
('P2', '2nd Polling Officer', 1, '2013-12-30 18:57:56'),
('P3', '3rd Polling Officer', 1, '2013-12-30 18:58:10'),
('PA', 'Addl.-P2(1)', 1, '2014-04-11 23:51:48'),
('PB', 'Addl.-P2(2)', 1, '2014-04-11 23:51:48'),
('PR', 'Presiding Officer', 1, '2014-01-17 14:35:56');

-- --------------------------------------------------------

--
-- Table structure for table `poststatorder`
--

CREATE TABLE IF NOT EXISTS `poststatorder` (
  `memberparty` int(1) NOT NULL,
  `membno` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `poststat` char(2) CHARACTER SET utf8 DEFAULT NULL,
  `amount` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `poststatorder`
--

INSERT INTO `poststatorder` (`memberparty`, `membno`, `poststat`, `amount`) VALUES
(4, '1', 'PR', '1100+300'),
(4, '2', 'P1', '800'),
(4, '3', 'P2', '800'),
(4, '4', 'P3', '800'),
(6, '1', 'PR', '1100+300'),
(6, '2', 'P1', '800'),
(6, '3', 'P2', '1100+300'),
(6, '4', 'PA', '800'),
(6, '5', 'PB', '1100+300'),
(6, '6', 'P3', '800'),
(5, '1', 'PR', '0'),
(5, '2', 'P1', '0'),
(5, '3', 'P2', '0'),
(5, '4', 'PA', '0'),
(5, '5', 'P3', '0');

-- --------------------------------------------------------

--
-- Table structure for table `po_ed`
--

CREATE TABLE IF NOT EXISTS `po_ed` (
  `personcd` char(9) NOT NULL,
  `pccd` char(2) NOT NULL,
  `ed_pb` char(2) DEFAULT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `qualification`
--

CREATE TABLE IF NOT EXISTS `qualification` (
  `qualificationcd` char(2) CHARACTER SET utf8 NOT NULL,
  `qualification` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`qualificationcd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qualification`
--

INSERT INTO `qualification` (`qualificationcd`, `qualification`, `usercode`, `posted_date`) VALUES
('01', 'CLASS 8 PASSED', 1, '2013-12-26 13:42:41'),
('02', 'MADHYAMIK', 1, '2013-12-26 13:42:58'),
('03', 'HIGHER SECONDARY', 1, '2013-12-26 13:43:19'),
('04', 'GRADUATE', 1, '2013-12-26 13:43:35'),
('05', 'POST GRADUATE', 1, '2013-12-26 13:43:52'),
('99', 'Other', 1, '2014-01-27 18:41:27');

-- --------------------------------------------------------

--
-- Table structure for table `reference`
--

CREATE TABLE IF NOT EXISTS `reference` (
  `districtcd` char(2) DEFAULT NULL,
  `subdivisioncd` char(4) DEFAULT NULL,
  `offcurrent` char(10) DEFAULT NULL,
  `perscurrent` char(11) DEFAULT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `relpacement_log`
--

CREATE TABLE IF NOT EXISTS `relpacement_log` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `old_personnel` char(11) NOT NULL,
  `new_personnel` char(11) NOT NULL,
  `assemblycd` char(3) NOT NULL,
  `groupid` smallint(6) DEFAULT NULL,
  `usercode` int(5) NOT NULL,
  `posteddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `relpacement_log_reserve`
--

CREATE TABLE IF NOT EXISTS `relpacement_log_reserve` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `old_personnel` char(11) NOT NULL,
  `new_personnel` char(11) NOT NULL,
  `assemblycd` char(3) NOT NULL,
  `groupid` smallint(6) DEFAULT NULL,
  `usercode` int(5) NOT NULL,
  `posteddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `remarks`
--

CREATE TABLE IF NOT EXISTS `remarks` (
  `remarks_cd` char(2) NOT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`remarks_cd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `remarks`
--

INSERT INTO `remarks` (`remarks_cd`, `remarks`) VALUES
('01', 'Head of Office'),
('02', 'Night Guard'),
('03', 'Armed Guard'),
('04', 'Sweeper'),
('05', 'Key holder'),
('06', 'Peoples'' Representative'),
('07', 'Physically Challenged'),
('08', 'Driver'),
('09', 'BLO'),
('99', 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `replacement_log_pregroup`
--

CREATE TABLE IF NOT EXISTS `replacement_log_pregroup` (
  `code` int(6) NOT NULL,
  `old_personnel` char(11) NOT NULL,
  `new_personnel` char(11) NOT NULL,
  `forassembly` char(3) NOT NULL,
  `forpc` char(2) NOT NULL,
  `reason` varchar(30) DEFAULT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reserve`
--

CREATE TABLE IF NOT EXISTS `reserve` (
  `forassembly` char(3) CHARACTER SET utf8 NOT NULL,
  `number_of_member` smallint(6) NOT NULL DEFAULT '0',
  `poststat` char(2) CHARACTER SET utf8 NOT NULL,
  `no_or_pc` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `numb` smallint(6) DEFAULT NULL,
  `forsubdivision` char(4) CHARACTER SET utf8 DEFAULT NULL,
  `forpc` char(2) CHARACTER SET utf8 DEFAULT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`forassembly`,`number_of_member`,`poststat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `second_appt`
--

CREATE TABLE IF NOT EXISTS `second_appt` (
  `slno` bigint(7) NOT NULL DEFAULT '0',
  `pers_off` char(10) DEFAULT NULL,
  `per_poststat` char(2) DEFAULT NULL,
  `groupid` char(4) DEFAULT NULL,
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
  `pr_name` varchar(50) DEFAULT NULL,
  `p1_name` varchar(50) DEFAULT NULL,
  `p2_name` varchar(50) DEFAULT NULL,
  `p3_name` varchar(50) DEFAULT NULL,
  `pa_name` varchar(50) DEFAULT NULL,
  `pb_name` varchar(50) DEFAULT NULL,
  `pr_designation` varchar(50) DEFAULT NULL,
  `p1_designation` varchar(50) DEFAULT NULL,
  `p2_designation` varchar(50) DEFAULT NULL,
  `p3_designation` varchar(50) DEFAULT NULL,
  `pa_designation` varchar(50) DEFAULT NULL,
  `pb_designation` varchar(50) DEFAULT NULL,
  `pr_status` char(2) DEFAULT NULL,
  `p1_status` char(2) DEFAULT NULL,
  `p2_status` char(2) DEFAULT NULL,
  `p3_status` char(2) DEFAULT NULL,
  `pa_status` char(2) DEFAULT NULL,
  `pb_status` char(2) DEFAULT NULL,
  `pr_post_stat` varchar(28) DEFAULT NULL,
  `p1_post_stat` varchar(28) DEFAULT NULL,
  `p2_post_stat` varchar(28) DEFAULT NULL,
  `p3_post_stat` varchar(28) DEFAULT NULL,
  `pa_post_stat` varchar(28) DEFAULT NULL,
  `pb_post_stat` varchar(28) DEFAULT NULL,
  `pr_officecd` char(10) DEFAULT NULL,
  `p1_officecd` char(10) DEFAULT NULL,
  `p2_officecd` char(10) DEFAULT NULL,
  `p3_officecd` char(10) DEFAULT NULL,
  `pa_officecd` char(10) DEFAULT NULL,
  `pb_officecd` char(10) DEFAULT NULL,
  `pr_officename` varchar(50) DEFAULT NULL,
  `p1_officename` varchar(50) DEFAULT NULL,
  `p2_officename` varchar(50) DEFAULT NULL,
  `p3_officename` varchar(50) DEFAULT NULL,
  `pa_officename` varchar(50) DEFAULT NULL,
  `pb_officename` varchar(50) DEFAULT NULL,
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
  `district` varchar(20) DEFAULT NULL,
  `pr_pincode` char(6) DEFAULT NULL,
  `p1_pincode` char(6) DEFAULT NULL,
  `p2_pincode` char(6) DEFAULT NULL,
  `p3_pincode` char(6) DEFAULT NULL,
  `pa_pincode` char(6) DEFAULT NULL,
  `pb_pincode` char(6) DEFAULT NULL,
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
  KEY `groupid` (`groupid`,`assembly`,`traingcode`,`venuecode`,`dcrcgrp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `second_rand_table`
--

CREATE TABLE IF NOT EXISTS `second_rand_table` (
  `code` bigint(20) NOT NULL,
  `groupid` char(4) DEFAULT NULL,
  `assembly` varchar(30) DEFAULT NULL,
  `pcname` varchar(30) DEFAULT NULL,
  `personcd` char(11) DEFAULT NULL,
  `person_name` varchar(50) DEFAULT NULL,
  `person_designation` varchar(50) DEFAULT NULL,
  `post_status` char(2) DEFAULT NULL,
  `officecd` char(10) DEFAULT NULL,
  `office_name` varchar(50) DEFAULT NULL,
  `office_address` varchar(100) DEFAULT NULL,
  `post_office` varchar(40) DEFAULT NULL,
  `subdivision` varchar(30) DEFAULT NULL,
  `police_stn` varchar(30) DEFAULT NULL,
  `district` varchar(20) DEFAULT NULL,
  `pincode` char(6) DEFAULT NULL,
  `dc_venue` varchar(45) DEFAULT NULL,
  `dc_address` varchar(45) DEFAULT NULL,
  `dc_date` char(10) DEFAULT NULL,
  `dc_time` char(15) DEFAULT NULL,
  `rc_venue` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `second_rand_table_reserve`
--

CREATE TABLE IF NOT EXISTS `second_rand_table_reserve` (
  `slno` bigint(20) NOT NULL DEFAULT '0',
  `groupid` int(6) DEFAULT NULL,
  `assembly` varchar(30) DEFAULT NULL,
  `pcname` varchar(30) DEFAULT NULL,
  `personcd` char(11) DEFAULT NULL,
  `person_name` varchar(50) DEFAULT NULL,
  `person_designation` varchar(50) DEFAULT NULL,
  `post_status` char(2) DEFAULT NULL,
  `post_stat` varchar(28) DEFAULT NULL,
  `officecd` char(10) DEFAULT NULL,
  `office_name` varchar(50) DEFAULT NULL,
  `office_address` varchar(100) DEFAULT NULL,
  `post_office` varchar(40) DEFAULT NULL,
  `subdivision` varchar(30) DEFAULT NULL,
  `police_stn` varchar(30) DEFAULT NULL,
  `district` varchar(20) DEFAULT NULL,
  `pincode` char(6) DEFAULT NULL,
  `dc_venue` varchar(45) DEFAULT NULL,
  `dc_address` varchar(45) DEFAULT NULL,
  `dc_date` date DEFAULT NULL,
  `dc_time` char(15) DEFAULT NULL,
  `rc_venue` varchar(45) DEFAULT NULL,
  `traingcode` char(9) DEFAULT NULL,
  `training_venue` varchar(50) DEFAULT NULL,
  `venuecode` char(6) DEFAULT NULL,
  `venue_addr1` varchar(50) DEFAULT NULL,
  `venue_addr2` varchar(50) DEFAULT NULL,
  `training_date` date DEFAULT NULL,
  `training_time` varchar(15) DEFAULT NULL,
  `polldate` date DEFAULT NULL,
  `polltime` varchar(20) DEFAULT NULL,
  `pccd` char(2) NOT NULL,
  `assemblycd` char(3) NOT NULL,
  `dcrccd` char(6) NOT NULL,
  `training_schd` char(9) NOT NULL,
  `districtcd` char(2) NOT NULL,
  `subdivisioncd` char(4) NOT NULL,
  KEY `traingcode` (`traingcode`,`venuecode`,`assemblycd`,`dcrccd`,`training_schd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `second_training`
--

CREATE TABLE IF NOT EXISTS `second_training` (
  `schedule_cd` char(9) NOT NULL,
  `for_pc` char(2) NOT NULL,
  `for_subdiv` char(4) NOT NULL,
  `assembly` char(3) NOT NULL,
  `party_reserve` char(1) NOT NULL,
  `start_sl` int(11) NOT NULL,
  `end_sl` int(11) NOT NULL,
  `training_venue` char(6) NOT NULL,
  `training_dt` datetime NOT NULL,
  `training_time` char(20) NOT NULL,
  `usercode` int(11) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subdivision`
--

CREATE TABLE IF NOT EXISTS `subdivision` (
  `subdivisioncd` char(4) CHARACTER SET utf8 NOT NULL,
  `districtcd` char(2) CHARACTER SET utf8 NOT NULL,
  `subdivision` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`subdivisioncd`),
  KEY `districtcd` (`districtcd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `submenu`
--

CREATE TABLE IF NOT EXISTS `submenu` (
  `submenu_cd` int(4) NOT NULL,
  `menu_cd` int(2) NOT NULL,
  `submenu` varchar(50) NOT NULL,
  `link` varchar(50) DEFAULT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`submenu_cd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `submenu`
--

INSERT INTO `submenu` (`submenu_cd`, `menu_cd`, `submenu`, `link`, `usercode`, `posted_date`) VALUES
(1, 2, 'Subdivision', 'subdivision-master.php', 1, '2013-12-23 04:28:24'),
(3, 4, 'Add Personnel', 'add-personnel.php', 1, '2013-12-23 04:28:24'),
(4, 4, 'List Personnel (Edit)', 'list-personnel.php', 1, '2013-12-23 04:28:24'),
(5, 3, 'Add Details', 'office-details.php', 1, '2013-12-25 23:38:03'),
(6, 3, 'Office Details List (Edit)', 'list-office-details.php', 1, '2013-12-25 23:39:54'),
(7, 4, 'BLO (Edit)', 'bloupdate.php', 1, '2014-01-02 17:15:13'),
(8, 3, 'Office Report (Chek List)', 'office-report.php', 1, '2014-01-02 17:15:32'),
(9, 4, 'Personnel Report (Chek List)', 'personnel-report.php', 1, '2014-01-02 22:02:46'),
(10, 2, 'Block/ Municipality', 'block-muni-master.php', 1, '2014-01-13 02:01:56'),
(11, 6, 'First Training Requirement', 'training-requirement.php', 1, '2014-01-14 02:31:39'),
(12, 6, 'First Training Venue', 'trainingvenue.php', 1, '2014-01-14 18:20:36'),
(13, 4, 'Polling Personnel Query (Count)', 'personnel1-report.php', 1, '2014-01-14 18:24:22'),
(14, 6, 'First Training Venue List', 'training_venue_list.php', 1, '2014-01-14 18:37:30'),
(15, 2, 'Police Station', 'police_station_master.php', 1, '2014-01-17 20:55:07'),
(16, 6, 'First Training Allocation', 'training-allocation1.php', 1, '2014-01-18 14:56:15'),
(17, 4, 'Gender Wise Personnel Report', 'genderwise_personnel_report.php', 1, '2014-01-19 00:20:54'),
(18, 5, 'Pre-Group Replacement', 'single-personnel-replacement.php', 1, '2014-01-19 00:30:20'),
(19, 5, 'Pre-Group Cancellation', 'pre-group-cancellation.php', 1, '2014-01-19 00:30:47'),
(20, 9, 'First App. Letter (Personnel Id Wise)', 'first-appointment-letter.php', 1, '2014-01-19 00:33:32'),
(21, 9, 'First App. Letter (Office Wise)', 'first-appointment-letter2.php', 1, '2014-01-20 20:39:15'),
(22, 9, 'First App. Letter (Subdivision Wise)', 'first-appointment-letter3-print.php', 1, '2014-01-22 00:29:15'),
(23, 9, 'Office Wise PP List', 'office-wise-list.php', 1, '2014-01-22 00:33:36'),
(24, 9, 'Venue Wise List', 'venue-wise-list.php', 1, '2014-01-27 21:17:31'),
(25, 6, 'First Training Allocation List', 'training-allocation-list.php', 1, '2014-01-28 20:53:10'),
(26, 4, 'Office Category against Post Status', 'govt-category-ag-poststat.php', 1, '2014-01-28 20:54:34'),
(27, 2, 'Bank', 'bank-master.php', 1, '2014-01-29 17:42:22'),
(28, 2, 'Branch', 'branch-master.php', 1, '2014-01-29 17:42:22'),
(29, 2, 'Parliament', 'pcmaster.php', 1, '2014-01-29 22:50:26'),
(30, 2, 'Assembly Constituency', 'assembly_master.php', 1, '2014-01-29 22:50:26'),
(31, 2, 'Assembly Party', 'assembly-party.php', 1, '2014-01-30 01:42:58'),
(32, 4, 'Office Category Wise Report', 'personnel-report-in-govt-category.php', 1, '2014-01-30 03:31:15'),
(33, 4, 'Termination', 'termination-details.php', 1, '2014-02-01 00:27:15'),
(34, 2, 'Assembly Party List  (Delete)', 'assembly-party-list.php', 1, '2014-02-02 00:54:17'),
(35, 6, 'Special Training (Pre-Group Replacement)', 'special-training.php', 1, '2014-02-04 04:44:29'),
(36, 2, 'DCRC Master', 'dcrc-master.php', 1, '2014-02-05 03:31:26'),
(37, 6, 'First Training Assign', 'training_assign_m.php', 1, '2014-02-05 05:57:21'),
(38, 9, 'Subdivision Wise PP List', 'subdiv-wise-pp.php', 1, '2014-02-05 07:32:43'),
(39, 8, 'First Randomisation', 'first-randomisation.php', 1, '2014-02-07 01:37:51'),
(40, 6, 'First Training Attendance', 'training-attendance.php', 1, '2016-01-16 03:59:21'),
(41, 8, 'Second Randomisation', 'second-randomisation.php', 1, '2014-02-07 01:40:06'),
(42, 8, 'Third Randomisation', 'third-randomisation.php', 1, '2014-02-07 01:40:06'),
(43, 4, 'Termination List', 'list-termination.php', 1, '2014-02-07 01:40:36'),
(44, 9, 'Second App. Letter (Subdiv or Assembly Wise)', 'second-appointment-letter.php', 1, '2014-02-14 22:28:56'),
(45, 2, 'DCRC Master List (Edit)', 'dcrc-master-list.php', 1, '2014-02-14 23:03:24'),
(46, 2, 'Training Type', 'training-type-master.php', 1, '2014-02-15 06:35:12'),
(47, 9, 'Second App. Letter (Office Wise)', 'second-app-letter_ofcwise.php', 1, '2014-02-16 10:18:37'),
(48, 9, 'Second App. Letter (Reserve)', 'second-appointment-letter-reserve.php', 1, '2014-02-16 14:24:08'),
(49, 10, 'Party PS List', 'party-ps-list.php', 1, '2014-02-17 11:24:30'),
(50, 10, 'Bulk Report', 'bulk-record.php', 1, '2014-02-17 21:52:49'),
(51, 9, 'Scroll/ Master Roll Report', 'pp-scroll-master-roll-report.php', 1, '2014-02-19 01:04:51'),
(52, 2, 'Polling Station', 'polling-station.php', 1, '2014-02-19 19:24:15'),
(53, 9, 'Master Roll Report - Reserve', 'reserve-master-roll-report.php', 1, '2014-02-19 22:32:46'),
(54, 7, 'Save SMS for PP', 'save-sms.php', 1, '2014-02-20 06:35:04'),
(55, 5, 'Post-Group Replacement (New PP)', 'emp-replacement.php', 1, '2014-02-26 03:14:17'),
(56, 4, 'Termination Report', 'termination_report.php', 1, '2014-03-05 03:51:46'),
(57, 8, 'First App Letter Populate', 'first-appointment-letter3.php', 1, '2014-03-06 18:38:47'),
(58, 6, 'Second Training Venue', 'training-venue2.php', 1, '2014-03-06 18:38:47'),
(59, 7, 'Send SMS', 'send-sms.php', 1, '2014-03-11 01:10:43'),
(60, 6, 'Second Training Allocation', 'second-training-allocation.php', 1, '2014-03-11 21:24:27'),
(61, 6, 'Token From District', 'token-creation-dist.php', 1, '2014-03-11 21:26:11'),
(62, 10, 'Unbooked Personnel Report', 'reports/subdiv-wise-unbooked-stat.php', 1, '2014-03-28 21:43:50'),
(63, 6, 'Token', 'token-creation.php', 1, '2014-03-29 00:31:10'),
(65, 8, '2nd App. Letter Populate', 'second-appointment-letter-populate.php', 1, '2014-03-29 00:31:10'),
(66, 8, '2nd App. Letter Populate (Reserve)', 'second-appointment-letter-populate-reserve.php', 1, '2014-03-29 00:31:10'),
(67, 9, '2nd App. Letter2', 'second-appointment-letter2.php', 1, '2014-03-29 00:31:10'),
(68, 9, '2nd App. Letter2 (6 member)', 'second-appointment-letter2-6mem.php', 1, '2014-03-29 00:31:10'),
(69, 9, '2nd App. Letter2 (Reserve)', 'second-appointment-letter2-reserve.php', 1, '2014-03-29 00:31:10'),
(70, 5, 'Post-Group Replacement (Reserve PP)', 'emp-replacement-reserve.php', 1, '2014-03-29 00:31:10'),
(71, 5, 'Post-Group Replacement (Post Status)', 'post-status-replacement.php', 1, '2014-03-29 00:31:10'),
(72, 5, 'Reserve PP Replacement (New PP)', 'reserve-replacement.php', 1, '2014-03-29 00:31:10'),
(74, 7, 'Save SMS (Second Training)', 'save-sms2.php', 1, '2014-04-20 19:29:03'),
(75, 7, 'Send SMS (Second Training)', 'send-sms2.php', 1, '2014-04-20 19:29:03'),
(76, 3, 'Gender Wise Query', 'office1-report.php', 1, '2015-10-27 23:28:29'),
(77, 4, 'Swapping', 'swapping.php', 1, '2015-10-27 23:28:29'),
(79, 10, 'Office/Personnel Validation', 'personnelvalidation.php', 1, '2015-11-16 20:13:49'),
(80, 4, 'Reverse Swapping', 'anti-swapping.php', 1, '2015-11-18 18:38:49'),
(81, 4, 'Personnel WBSLA16 List (Edit)', 'list-personnel_ls14.php', 1, '2015-11-22 06:22:03'),
(82, 10, 'Validation Before First Randomisation', 'validation-before-first-rando.php', 1, '2015-11-22 06:22:03'),
(83, 10, 'Validation Before Second Randomisation', 'validation-before-second-rando.php', 1, '2015-12-17 10:40:25'),
(84, 9, 'Booth Tagging List', '3rd-app-letter.php', 1, '2015-12-19 10:26:03'),
(86, 2, 'Polling Station List (Edit)', 'polling-station-list.php', 1, '2015-12-28 16:24:48'),
(87, 5, 'Reserve PP Cancellation', 'reserve-cancellation.php', 1, '2016-01-13 12:05:43');

-- --------------------------------------------------------

--
-- Table structure for table `sub_submenu`
--

CREATE TABLE IF NOT EXISTS `sub_submenu` (
  `sub_submenu_cd` int(6) NOT NULL,
  `submenu_cd` int(4) NOT NULL,
  `sub_submenu` varchar(20) NOT NULL,
  `link` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblsms`
--

CREATE TABLE IF NOT EXISTS `tblsms` (
  `name` varchar(50) NOT NULL,
  `phone_no` char(12) NOT NULL,
  `message` varchar(320) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblsms2`
--

CREATE TABLE IF NOT EXISTS `tblsms2` (
  `name` varchar(50) NOT NULL,
  `phone_no` char(12) NOT NULL,
  `message` varchar(320) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `termination`
--

CREATE TABLE IF NOT EXISTS `termination` (
  `termination_id` int(9) NOT NULL AUTO_INCREMENT,
  `personal_id` char(11) CHARACTER SET utf8 NOT NULL,
  `termination_cause` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `termination_date` datetime NOT NULL,
  `remarks` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `users_id` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`termination_id`),
  KEY `personal_cd_fk` (`personal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `personcd` char(11) NOT NULL,
  `acno` char(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `testpp`
--

CREATE TABLE IF NOT EXISTS `testpp` (
  `personcd` char(11) CHARACTER SET utf8 NOT NULL,
  `officecd` char(10) CHARACTER SET utf8 NOT NULL,
  `officer_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `off_desg` varchar(50) CHARACTER SET utf8 NOT NULL,
  `present_addr1` varchar(50) CHARACTER SET utf8 NOT NULL,
  `present_addr2` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `perm_addr1` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `perm_addr2` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `dateofbirth` datetime DEFAULT NULL,
  `gender` char(6) CHARACTER SET utf8 DEFAULT NULL,
  `scale` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `basic_pay` smallint(6) DEFAULT NULL,
  `grade_pay` smallint(6) DEFAULT NULL,
  `workingstatus` char(3) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `resi_no` char(14) DEFAULT NULL,
  `mob_no` char(12) NOT NULL,
  `qualificationcd` char(2) CHARACTER SET utf8 NOT NULL,
  `languagecd` char(2) CHARACTER SET utf8 NOT NULL,
  `epic` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `acno` char(3) DEFAULT NULL,
  `slno` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
  `partno` varchar(5) CHARACTER SET utf8 DEFAULT NULL,
  `poststat` char(2) CHARACTER SET utf8 NOT NULL,
  `assembly_temp` char(3) CHARACTER SET utf8 DEFAULT NULL,
  `assembly_off` char(3) CHARACTER SET utf8 DEFAULT NULL,
  `assembly_perm` char(3) CHARACTER SET utf8 DEFAULT NULL,
  `forsubdivision` char(4) CHARACTER SET utf8 DEFAULT NULL,
  `forpc` char(2) CHARACTER SET utf8 DEFAULT NULL,
  `forassembly` char(3) CHARACTER SET utf8 DEFAULT NULL,
  `groupid` smallint(6) DEFAULT NULL,
  `booked` char(1) DEFAULT '',
  `dcrccd` char(6) DEFAULT NULL,
  `selected` int(1) NOT NULL DEFAULT '0',
  `rand_numb` smallint(6) DEFAULT NULL,
  `edcpb` char(1) DEFAULT NULL,
  `districtcd` char(2) CHARACTER SET utf8 DEFAULT NULL,
  `subdivisioncd` char(4) CHARACTER SET utf8 DEFAULT NULL,
  `bank_acc_no` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `bank_cd` char(5) CHARACTER SET utf8 DEFAULT NULL,
  `branchcd` char(3) CHARACTER SET utf8 DEFAULT NULL,
  `remarks` char(2) CHARACTER SET utf8 DEFAULT NULL,
  `pgroup` varchar(20) DEFAULT NULL,
  `upload_file` varchar(50) DEFAULT NULL,
  `usercode` int(5) DEFAULT NULL,
  `posted_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `training2_sch` char(9) DEFAULT NULL,
  `ttrgschcopy` char(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_app_let`
--

CREATE TABLE IF NOT EXISTS `tmp_app_let` (
  `per_code` char(11) NOT NULL,
  `usercode` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `training_pp`
--

CREATE TABLE IF NOT EXISTS `training_pp` (
  `per_code` char(11) NOT NULL,
  `per_name` varchar(50) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `training_type` char(2) NOT NULL,
  `training_sch` char(9) DEFAULT NULL,
  `post_stat` char(2) NOT NULL,
  `training_booked` char(1) DEFAULT NULL,
  `training_attended` char(1) DEFAULT NULL,
  `training_showcause` char(1) DEFAULT NULL,
  `subdivision` char(4) NOT NULL,
  `for_subdivision` char(4) NOT NULL,
  `for_pc` char(2) DEFAULT NULL,
  `assembly_temp` char(3) NOT NULL,
  `assembly_off` char(3) NOT NULL,
  `assembly_perm` char(3) NOT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `token` int(5) DEFAULT NULL,
  KEY `per_code` (`per_code`,`training_type`,`training_sch`,`post_stat`,`subdivision`,`for_subdivision`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `training_schedule`
--

CREATE TABLE IF NOT EXISTS `training_schedule` (
  `schedule_code` char(9) NOT NULL,
  `training_venue` char(6) NOT NULL,
  `training_type` char(2) NOT NULL,
  `training_dt` datetime NOT NULL,
  `training_time` char(20) NOT NULL,
  `post_status` char(2) NOT NULL,
  `no_pp` int(6) NOT NULL,
  `no_used` int(6) DEFAULT '0',
  `choice_type` char(1) DEFAULT NULL,
  `choice_area` char(4) DEFAULT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`schedule_code`),
  KEY `training_venue` (`training_venue`,`training_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `training_venue`
--

CREATE TABLE IF NOT EXISTS `training_venue` (
  `venue_cd` char(6) CHARACTER SET utf8 NOT NULL,
  `subdivisioncd` char(4) CHARACTER SET utf8 NOT NULL,
  `venuename` varchar(50) CHARACTER SET utf8 NOT NULL,
  `venueaddress1` varchar(50) CHARACTER SET utf8 NOT NULL,
  `venueaddress2` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `maximumcapacity` int(4) NOT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `assemblycd` char(3) NOT NULL,
  PRIMARY KEY (`venue_cd`,`subdivisioncd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `training_venue_2`
--

CREATE TABLE IF NOT EXISTS `training_venue_2` (
  `venue_cd` char(6) CHARACTER SET utf8 NOT NULL,
  `subdivisioncd` char(4) CHARACTER SET utf8 NOT NULL,
  `venuename` varchar(50) CHARACTER SET utf8 NOT NULL,
  `venueaddress1` varchar(50) CHARACTER SET utf8 NOT NULL,
  `venueaddress2` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`venue_cd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `code` int(5) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(10) NOT NULL,
  `password` varchar(16) NOT NULL,
  `category` varchar(16) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `districtcd` char(2) DEFAULT NULL,
  `subdivisioncd` char(4) DEFAULT NULL,
  `parliamentcd` char(2) DEFAULT NULL,
  `assemblycd` char(3) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`code`, `user_id`, `password`, `category`, `creation_date`, `districtcd`, `subdivisioncd`, `parliamentcd`, `assemblycd`) VALUES
(1, 'admin', 'nimda', 'Administrator', '2014-01-28 04:51:00', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_permission`
--

CREATE TABLE IF NOT EXISTS `user_permission` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `user_cd` int(5) NOT NULL,
  `menu_cd` char(2) NOT NULL,
  `submenu_cd` char(4) DEFAULT NULL,
  `sub_submenu_cd` char(6) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2011 ;

--
-- Dumping data for table `user_permission`
--

INSERT INTO `user_permission` (`code`, `user_cd`, `menu_cd`, `submenu_cd`, `sub_submenu_cd`) VALUES
(1952, 1, '1', '', NULL),
(1953, 1, '2', '1', NULL),
(1954, 1, '2', '10', NULL),
(1955, 1, '2', '15', NULL),
(1956, 1, '2', '27', NULL),
(1957, 1, '2', '28', NULL),
(1958, 1, '2', '29', NULL),
(1959, 1, '2', '30', NULL),
(1960, 1, '2', '31', NULL),
(1961, 1, '2', '34', NULL),
(1962, 1, '2', '36', NULL),
(1963, 1, '2', '45', NULL),
(1964, 1, '2', '46', NULL),
(1965, 1, '2', '52', NULL),
(1966, 1, '2', '86', NULL),
(1967, 1, '3', '5', NULL),
(1968, 1, '3', '6', NULL),
(1969, 1, '3', '8', NULL),
(1970, 1, '3', '76', NULL),
(1971, 1, '4', '3', NULL),
(1972, 1, '4', '4', NULL),
(1973, 1, '4', '7', NULL),
(1974, 1, '4', '9', NULL),
(1975, 1, '4', '13', NULL),
(1976, 1, '4', '17', NULL),
(1977, 1, '4', '26', NULL),
(1978, 1, '4', '32', NULL),
(1979, 1, '4', '33', NULL),
(1980, 1, '4', '43', NULL),
(1981, 1, '4', '56', NULL),
(1982, 1, '4', '77', NULL),
(1983, 1, '4', '80', NULL),
(1984, 1, '4', '81', NULL),
(1985, 1, '5', '18', NULL),
(1986, 1, '5', '19', NULL),
(1987, 1, '6', '11', NULL),
(1988, 1, '6', '12', NULL),
(1989, 1, '6', '14', NULL),
(1990, 1, '6', '16', NULL),
(1991, 1, '6', '25', NULL),
(1992, 1, '6', '35', NULL),
(1993, 1, '6', '37', NULL),
(1994, 1, '6', '40', NULL),
(1995, 1, '6', '63', NULL),
(1996, 1, '7', '54', NULL),
(1997, 1, '7', '59', NULL),
(1998, 1, '7', '74', NULL),
(1999, 1, '7', '75', NULL),
(2000, 1, '8', '39', NULL),
(2001, 1, '8', '57', NULL),
(2002, 1, '9', '20', NULL),
(2003, 1, '9', '21', NULL),
(2004, 1, '9', '22', NULL),
(2005, 1, '9', '23', NULL),
(2006, 1, '9', '24', NULL),
(2007, 1, '9', '38', NULL),
(2008, 1, '10', '79', NULL),
(2009, 1, '10', '82', NULL),
(2010, 1, '10', '83', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assembly`
--
ALTER TABLE `assembly`
  ADD CONSTRAINT `assembly_ibfk_1` FOREIGN KEY (`pccd`) REFERENCES `pc` (`pccd`),
  ADD CONSTRAINT `assembly_ibfk_2` FOREIGN KEY (`districtcd`) REFERENCES `district` (`districtcd`),
  ADD CONSTRAINT `assembly_ibfk_3` FOREIGN KEY (`districtcd`) REFERENCES `district` (`districtcd`),
  ADD CONSTRAINT `assembly_ibfk_4` FOREIGN KEY (`subdivisioncd`) REFERENCES `subdivision` (`subdivisioncd`);

--
-- Constraints for table `block_muni`
--
ALTER TABLE `block_muni`
  ADD CONSTRAINT `block_muni_ibfk_1` FOREIGN KEY (`subdivisioncd`) REFERENCES `subdivision` (`subdivisioncd`),
  ADD CONSTRAINT `block_muni_ibfk_10` FOREIGN KEY (`districtcd`) REFERENCES `district` (`districtcd`),
  ADD CONSTRAINT `block_muni_ibfk_11` FOREIGN KEY (`districtcd`) REFERENCES `district` (`districtcd`),
  ADD CONSTRAINT `block_muni_ibfk_12` FOREIGN KEY (`districtcd`) REFERENCES `district` (`districtcd`),
  ADD CONSTRAINT `block_muni_ibfk_2` FOREIGN KEY (`subdivisioncd`) REFERENCES `subdivision` (`subdivisioncd`),
  ADD CONSTRAINT `block_muni_ibfk_3` FOREIGN KEY (`subdivisioncd`) REFERENCES `subdivision` (`subdivisioncd`),
  ADD CONSTRAINT `block_muni_ibfk_4` FOREIGN KEY (`subdivisioncd`) REFERENCES `subdivision` (`subdivisioncd`),
  ADD CONSTRAINT `block_muni_ibfk_5` FOREIGN KEY (`districtcd`) REFERENCES `district` (`districtcd`),
  ADD CONSTRAINT `block_muni_ibfk_6` FOREIGN KEY (`districtcd`) REFERENCES `district` (`districtcd`),
  ADD CONSTRAINT `block_muni_ibfk_7` FOREIGN KEY (`districtcd`) REFERENCES `district` (`districtcd`),
  ADD CONSTRAINT `block_muni_ibfk_8` FOREIGN KEY (`districtcd`) REFERENCES `district` (`districtcd`),
  ADD CONSTRAINT `block_muni_ibfk_9` FOREIGN KEY (`districtcd`) REFERENCES `district` (`districtcd`);

--
-- Constraints for table `dcrcmaster`
--
ALTER TABLE `dcrcmaster`
  ADD CONSTRAINT `asm_cd_fk` FOREIGN KEY (`assemblycd`) REFERENCES `assembly` (`assemblycd`);

--
-- Constraints for table `office`
--
ALTER TABLE `office`
  ADD CONSTRAINT `fk_ofc_districtcd` FOREIGN KEY (`districtcd`) REFERENCES `district` (`districtcd`);

--
-- Constraints for table `personnel`
--
ALTER TABLE `personnel`
  ADD CONSTRAINT `fk_post_stat_cd` FOREIGN KEY (`poststat`) REFERENCES `poststat` (`post_stat`),
  ADD CONSTRAINT `per_bank_cd_fk` FOREIGN KEY (`bank_cd`) REFERENCES `bank` (`bank_cd`),
  ADD CONSTRAINT `per_branch_cd_fk` FOREIGN KEY (`branchcd`) REFERENCES `branch` (`branchcd`),
  ADD CONSTRAINT `per_dist_cd_fk` FOREIGN KEY (`districtcd`) REFERENCES `district` (`districtcd`),
  ADD CONSTRAINT `per_office_cd_fk` FOREIGN KEY (`officecd`) REFERENCES `office` (`officecd`),
  ADD CONSTRAINT `per_sub_cd_fk` FOREIGN KEY (`subdivisioncd`) REFERENCES `subdivision` (`subdivisioncd`);

--
-- Constraints for table `personnela`
--
ALTER TABLE `personnela`
  ADD CONSTRAINT `fk_asm_off_cd` FOREIGN KEY (`assembly_off`) REFERENCES `assembly` (`assemblycd`),
  ADD CONSTRAINT `fk_asm_perm_cd` FOREIGN KEY (`assembly_perm`) REFERENCES `assembly` (`assemblycd`),
  ADD CONSTRAINT `fk_asm_tmp_cd` FOREIGN KEY (`assembly_temp`) REFERENCES `assembly` (`assemblycd`),
  ADD CONSTRAINT `fk_branch_cd` FOREIGN KEY (`branchcd`) REFERENCES `branch` (`branchcd`),
  ADD CONSTRAINT `fk_language_cd` FOREIGN KEY (`languagecd`) REFERENCES `language` (`languagecd`),
  ADD CONSTRAINT `fk_lbank_cd` FOREIGN KEY (`bank_cd`) REFERENCES `bank` (`bank_cd`),
  ADD CONSTRAINT `fk_officecd` FOREIGN KEY (`officecd`) REFERENCES `office` (`officecd`),
  ADD CONSTRAINT `fk_poststat` FOREIGN KEY (`poststat`) REFERENCES `poststat` (`post_stat`),
  ADD CONSTRAINT `fk_qualification_cd` FOREIGN KEY (`qualificationcd`) REFERENCES `qualification` (`qualificationcd`);

--
-- Constraints for table `policestation`
--
ALTER TABLE `policestation`
  ADD CONSTRAINT `district_cd_fk` FOREIGN KEY (`districtcd`) REFERENCES `district` (`districtcd`),
  ADD CONSTRAINT `sub_cd_fk` FOREIGN KEY (`subdivisioncd`) REFERENCES `subdivision` (`subdivisioncd`);

--
-- Constraints for table `subdivision`
--
ALTER TABLE `subdivision`
  ADD CONSTRAINT `subdivision_ibfk_1` FOREIGN KEY (`districtcd`) REFERENCES `district` (`districtcd`),
  ADD CONSTRAINT `subdivision_ibfk_2` FOREIGN KEY (`districtcd`) REFERENCES `district` (`districtcd`);

--
-- Constraints for table `termination`
--
ALTER TABLE `termination`
  ADD CONSTRAINT `personal_cd_fk` FOREIGN KEY (`personal_id`) REFERENCES `personnel` (`personcd`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
