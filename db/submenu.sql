-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 04, 2016 at 03:49 PM
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
-- Table structure for table `submenu`
--

CREATE TABLE IF NOT EXISTS `submenu` (
  `submenu_cd` int(4) NOT NULL AUTO_INCREMENT,
  `menu_cd` int(2) NOT NULL,
  `submenu` varchar(50) NOT NULL,
  `link` varchar(50) DEFAULT NULL,
  `usercode` int(5) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`submenu_cd`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=95 ;

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
(78, 4, 'Reverse Swapping', 'anti-swapping1.php', 1, '2016-03-04 10:18:54'),
(79, 10, 'Office/Personnel Validation', 'personnelvalidation.php', 1, '2015-11-16 20:13:49'),
(80, 4, 'Reverse Swapping (Extra)', 'anti-swapping.php', 1, '2015-11-18 18:38:49'),
(81, 4, 'Personnel WBSLA16 List (Edit)', 'list-personnel_ls14.php', 1, '2015-11-22 06:22:03'),
(82, 10, 'Validation Before First Randomisation', 'validation-before-first-rando.php', 1, '2015-11-22 06:22:03'),
(83, 10, 'Validation Before Second Randomisation', 'validation-before-second-rando.php', 1, '2015-12-17 10:40:25'),
(84, 9, 'Booth Tagging List', '3rd-app-letter.php', 1, '2015-12-19 10:26:03'),
(86, 2, 'Polling Station List (Edit)', 'polling-station-list.php', 1, '2015-12-28 16:24:48'),
(87, 5, 'Reserve PP Cancellation', 'reserve-cancellation.php', 1, '2016-01-13 12:05:43'),
(88, 11, 'Swapping', 'swapping-extra.php', 1, '2016-02-11 11:42:33'),
(89, 11, 'First Training Requirement', 'training-requirement-extra.php', 1, '2016-02-11 11:42:33'),
(90, 11, 'Training Allocation', 'training-allocation.php', 1, '2016-02-11 11:46:06'),
(91, 11, 'Token', 'token-creation-extra.php', 1, '2016-02-11 11:46:06'),
(92, 11, 'First App Letter Populate', 'first-appointment-letter3-extra.php', 1, '2016-02-11 11:48:13'),
(93, 10, 'Validation Before First Randomisation Populate', 'validation_1st_populate.php', 1, '2016-02-18 09:30:47'),
(94, 10, 'Bank Wise PP Report', 'bank_wise_pp_report.php', 1, '2016-02-18 09:30:47');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
