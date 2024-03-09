-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2024 at 12:20 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `imsdb`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `login_check` (IN `uname` VARCHAR(255), IN `userpassword` VARCHAR(255))   BEGIN
    SELECT * FROM users WHERE username = uname AND user_password = userpassword;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `stud_profile_add` (IN `studNo` VARCHAR(20), IN `fname` VARCHAR(100), IN `gender` VARCHAR(10), IN `course` VARCHAR(20), IN `yearLevel` INT(11), IN `bdate` DATE, IN `address` VARCHAR(500), IN `mobNo` VARCHAR(20), IN `email` VARCHAR(100), IN `birthplace` VARCHAR(500), IN `stat` VARCHAR(20))   BEGIN
    INSERT INTO stud_profile (
        stud_regNo,
        stud_fullname,
        stud_gender,
        stud_course,
        stud_yrlevel,
        stud_birth_date,
        stud_address,
        stud_mobileNo,
        stud_email,
        stud_birthplace,
        stud_display_status
    )
    VALUES (
        studNo,
        fname,
        gender,
        course,
        yearLevel,
        bdate,
        address,
        mobNo,
        email,
        birthplace,
        stat
    );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `stud_visit_add` (IN `p_student_no` VARCHAR(20), IN `p_purpose` VARCHAR(100), IN `p_details` TEXT)   BEGIN
    DECLARE last_code VARCHAR(50);
    DECLARE numeric_part INT;
    DECLARE new_code VARCHAR(50);
    DECLARE code_exists INT;

    -- Find the last visit code
    SELECT visitcode INTO last_code FROM stud_visit ORDER BY stud_visitId DESC LIMIT 1;

    -- Extract the numeric part before the hyphen from the last visit code
    SET numeric_part = CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(last_code, '-', 1), 'VS0', -1) AS UNSIGNED) + 1;

    -- Create a new unique visit code
    SET new_code = CONCAT('VS0', numeric_part, '-23/24');

    -- Check if the new visit code already exists
    SELECT COUNT(*) INTO code_exists FROM stud_visit WHERE visitcode = new_code;

    -- If the visitCode exists, generate a new unique code by incrementing the numeric part
    WHILE code_exists > 0 DO
        SET numeric_part = numeric_part + 1;
        SET new_code = CONCAT('VS0', numeric_part, '-23/24');
        SELECT COUNT(*) INTO code_exists FROM stud_visit WHERE visitcode = new_code;
    END WHILE;

    -- Insert the record with the unique visitCode
    INSERT INTO stud_visit (visitcode, visitdate, stud_regno, visit_purpose, visit_details)
    VALUES (new_code, NOW(), p_student_no, p_purpose, p_details);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `active_academic_year`
--

CREATE TABLE `active_academic_year` (
  `yrId` int(11) NOT NULL,
  `acadbatch_yr` varchar(50) NOT NULL,
  `isActive` enum('1','0') NOT NULL DEFAULT '1',
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `date_mod` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `active_academic_year`
--

INSERT INTO `active_academic_year` (`yrId`, `acadbatch_yr`, `isActive`, `date_add`, `date_mod`) VALUES
(1, '2023-2024', '1', '2023-10-24 10:44:38', '2023-10-24 10:44:38');

-- --------------------------------------------------------

--
-- Table structure for table `active_semester`
--

CREATE TABLE `active_semester` (
  `sem_id` int(11) NOT NULL,
  `activesem_name` varchar(50) NOT NULL,
  `sem_isactive` enum('1','0') NOT NULL DEFAULT '1',
  `sem_date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `sem_date_mod` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `active_semester`
--

INSERT INTO `active_semester` (`sem_id`, `activesem_name`, `sem_isactive`, `sem_date_add`, `sem_date_mod`) VALUES
(1, 'Semester One', '0', '2023-10-24 10:44:38', '2023-10-24 10:44:38'),
(2, 'Semester Two', '1', '2023-12-19 17:48:35', '2023-12-19 17:48:35');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(30) NOT NULL,
  `stud_regNo` varchar(20) NOT NULL,
  `date_sched` datetime NOT NULL,
  `couns_issue` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `stud_regNo`, `date_sched`, `couns_issue`, `status`, `date_created`) VALUES
(1, 'C027-01-0823/2020', '2024-01-17 11:49:00', 'Academic Issues', 0, '2024-01-10 11:52:54'),
(2, 'C027-01-0836/2020', '2024-01-12 12:00:00', 'Academic Issues', 0, '2024-01-10 12:08:36'),
(3, 'C027-01-0836/2020', '2024-01-15 08:30:00', 'Financial Issues', 1, '2024-01-10 12:24:36'),
(4, 'C027-01-0836/2020', '2024-02-12 16:29:00', 'Academic Issues', 1, '2024-02-10 16:29:38'),
(5, 'C027-01-0836/2020', '2024-03-08 10:40:00', 'Academic Issues', 0, '2024-03-07 12:42:27');

-- --------------------------------------------------------

--
-- Table structure for table `batch_details`
--

CREATE TABLE `batch_details` (
  `batchId` int(11) NOT NULL,
  `batch_code` varchar(20) NOT NULL,
  `batch_yr` varchar(20) NOT NULL,
  `batch_display_stat` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `batch_details`
--

INSERT INTO `batch_details` (`batchId`, `batch_code`, `batch_yr`, `batch_display_stat`) VALUES
(1, '23-24', '2023-2024', 'Active'),
(2, '20-21', '2020-2021', 'Active'),
(3, '21-22', '2021-2022', 'Active'),
(4, '22-23', '2022-2023', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `batch_group`
--

CREATE TABLE `batch_group` (
  `batch_id` int(11) NOT NULL,
  `batch_approach` varchar(50) NOT NULL,
  `batch_bg` text DEFAULT NULL,
  `batch_goals` text DEFAULT NULL,
  `batch_comments` text DEFAULT NULL,
  `batch_recomm` text DEFAULT NULL,
  `batch_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `batch_group`
--

INSERT INTO `batch_group` (`batch_id`, `batch_approach`, `batch_bg`, `batch_goals`, `batch_comments`, `batch_recomm`, `batch_date`) VALUES
(28, 'Cognitive Therapy', 'Test', 'Test', 'Test', 'Test', '2024-02-06 08:19:32');

-- --------------------------------------------------------

--
-- Table structure for table `counseling`
--

CREATE TABLE `counseling` (
  `couns_Id` int(11) NOT NULL,
  `couns_code` varchar(20) NOT NULL,
  `apprcode` int(11) NOT NULL,
  `stud_regNo` varchar(20) NOT NULL,
  `visitId_Ref` int(11) NOT NULL,
  `couns_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `couns_acadYr` varchar(50) NOT NULL,
  `couns_sem` varchar(50) NOT NULL,
  `counseling_type` varchar(50) NOT NULL,
  `couns_appmnType` varchar(25) NOT NULL,
  `nature_of_case` int(11) NOT NULL,
  `couns_background` text DEFAULT NULL,
  `couns_goals` text DEFAULT NULL,
  `couns_comment` text DEFAULT NULL,
  `couns_recommendation` text DEFAULT NULL,
  `counselor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `counseling`
--

INSERT INTO `counseling` (`couns_Id`, `couns_code`, `apprcode`, `stud_regNo`, `visitId_Ref`, `couns_date`, `couns_acadYr`, `couns_sem`, `counseling_type`, `couns_appmnType`, `nature_of_case`, `couns_background`, `couns_goals`, `couns_comment`, `couns_recommendation`, `counselor_id`) VALUES
(1, 'CC001-23/24', 1, 'C027-01-0836/2020', 1, '2020-08-01 07:44:37', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 1, 'Difficulty coping with coursework.', 'Develop study strategies.', 'Ongoing academic support recommended.', 'Further assistance suggested for improvement.', 1),
(2, 'CC002-23/224', 3, 'C025-01-0629/2020', 2, '2023-11-15 06:30:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Scheduled Appointment', 12, 'Personal trauma experiences that need processing.', 'Establishing coping mechanisms.', 'Acknowledged progress.', 'Further sessions recommended for ongoing support.', 1),
(3, 'CC003-23/224', 2, 'C027-01-2677/2020', 3, '2023-11-15 07:00:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Scheduled Appointment', 5, 'Struggling with anxiety and depression.', 'Develop coping strategies.', 'Significant progress observed.', 'Follow-up sessions recommended.', 1),
(4, 'CC004-23/224', 1, 'B012-01-0001/2021', 4, '2023-11-15 08:30:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Scheduled Appointment', 1, 'Difficulty coping with coursework.', 'Develop study strategies.', 'Ongoing academic support recommended.', 'Further assistance suggested for improvement.', 1),
(5, 'CC005-23/224', 4, 'B011-01-0832/2022', 5, '2023-11-15 09:00:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Scheduled Appointment', 13, 'Dealing with interpersonal conflicts.', 'Mediation and resolution strategies.', 'Progress in 13.', 'Follow-up for positive relationship building.', 1),
(6, 'CC006-23/224', 3, 'B011-01-0833/2023', 6, '2023-11-15 10:30:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 10, 'Navigating 10 concerns.', 'Education on safe practices.', 'Further guidance and education suggested.', 'Continued support and check-ins.', 1),
(7, 'CC007-23/224', 2, 'B012-01-0836/2023', 7, '2023-11-15 12:00:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Scheduled Appointment', 8, 'Dealing with financial challenges.', 'Budgeting and financial planning.', 'Improved financial management.', 'Ongoing financial guidance.', 1),
(8, 'CC008-23/224', 1, 'C027-01-0781/2020', 8, '2023-11-15 13:30:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Scheduled Appointment', 7, 'Dealing with 7.', 'Recovery and sobriety plan.', 'Progress in rehabilitation.', 'Continued support and follow-up.', 1),
(9, 'CC009-23/224', 3, 'C027-01-0826/2020', 9, '2023-11-16 11:00:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Scheduled Appointment', 9, 'Difficulties in social adaptation.', 'Building social skills.', 'Positive social interactions.', 'Continued social engagement encouraged.', 1),
(10, 'CC010-23/224', 2, 'C027-01-2556/2020', 10, '2023-11-17 06:30:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 4, 'Seeking personal growth.', 'Identifying personal strengths.', 'Acknowledged personal growth.', 'Continued self-improvement recommended.', 4),
(11, 'CC011-23/224', 4, 'C026-01-0837/2021', 11, '2023-11-18 08:00:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Scheduled Appointment', 11, 'Difficulties adapting to university.', 'Support and coping mechanisms.', 'Improved adjustment.', 'Continuous support for university transition.', 1),
(12, 'CC012-23/224', 1, 'C026-01-0839/2023', 12, '2023-11-19 10:30:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Scheduled Appointment', 2, 'Uncertainty in career direction.', 'Exploring interests and strengths.', 'Clarity in career goals.', 'Follow-up for career planning.', 1),
(13, 'CC013-23/224', 3, 'E021-01-0850/2022', 13, '2023-11-20 12:00:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Scheduled Appointment', 2, 'Seeking career advice.', 'Exploring career options.', 'Insight into career path.', 'Continued career exploration.', 1),
(14, 'CC014-23/224', 4, 'C026-01-0001/2016', 14, '2023-11-20 12:30:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Scheduled Appointment', 4, 'Addressing cognitive patterns.', 'Techniques for cognitive restructuring.', 'Progress in cognitive reprogramming.', 'Continued therapy for reinforcement.', 1),
(15, 'CC015-23/224', 2, 'C026-01-0005/2016', 3, '2023-11-21 07:00:00', '2023-2024', 'Semester One', 'Group Counseling', 'Scheduled Appointment', 4, 'Fostering self-acceptance.', 'Promoting self-exploration.', 'Positive self-perception.', 'Continued group therapy for reinforcement.', 1),
(16, 'CC016-23/224', 3, 'C025-01-0009/2016', 4, '2023-11-21 08:00:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 12, 'Addressing past experiences.', 'Developing coping mechanisms.', 'Emotional healing.', 'Continued therapy sessions for support.', 1),
(17, 'CC017-23/224', 1, 'E021-01-0015/2016', 5, '2023-11-22 09:00:00', '2023-2024', 'Semester One', 'Group Counseling', 'Scheduled Appointment', 1, 'Career planning strategies.', 'Setting career objectives.', 'Career progression.', 'Follow-up for career development.', 1),
(18, 'CC018-23/224', 4, 'C026-01-0002/2017', 6, '2023-11-22 10:00:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 5, 'Managing stress.', 'Enhancing emotional well-being.', 'Emotional stability.', 'Continued counseling sessions for support.', 1),
(19, 'CC019-23/24', 2, 'C025-01-0006/2017', 7, '2023-11-22 11:00:00', '2023-2024', 'Semester One', 'Group Counseling', 'Scheduled Appointment', 6, 'Addressing family conflicts.', 'Improving family relationships.', 'Family harmony.', 'Follow-up sessions for family counseling.', 1),
(20, 'CC020-23/24', 1, 'C025-01-0010/2017', 8, '2023-11-23 12:00:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Scheduled Appointment', 8, 'Managing financial pressure.', 'Developing financial strategies.', 'Financial stability.', 'Continued counseling for financial guidance.', 1),
(42, 'CC021-23/24', 3, 'E021-01-0011/2016', 0, '2023-11-27 04:32:09', '', '', '', '', 4, 'test', 'test', 'test', 'test', 1),
(43, 'CC022-23/24', 3, 'B011-01-0833/2023', 0, '2023-11-27 04:36:13', '', '', '', 'Scheduled Appointment', 6, 'test', 'test', 'test', 'test', 1),
(44, 'CC023-23/24', 1, 'C026-01-0846/2023', 0, '2023-11-27 04:47:04', '2023-2024', 'Semester One', 'Individual Counseling', 'walk-in', 2, 'test', 'test', 'test', 'test', 1),
(45, 'CC024-23/24', 1, 'B012-01-0834/2021', 0, '2023-11-27 05:19:47', '2023-2024', 'Semester One', 'Individual Counseling', 'Scheduled Appointment', 1, 'test', 'test', 'test', 'test', 1),
(46, 'CC025-23/24', 3, 'C027-01-0781/2020', 0, '2023-11-27 05:22:10', '2023-2024', 'Semester One', 'Individual Counseling', 'Scheduled Appointment', 4, '', 'test', 'test', 'test', 1),
(47, 'CC026-23/24', 3, 'E024-01-0826/2021', 44, '2023-11-20 07:00:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 4, 'Addressing past experiences', 'Developing coping mechanisms', 'Emotional healing', 'Continued therapy sessions for support', 1),
(48, 'CC027-23/24', 1, 'E024-01-0827/2021', 45, '2023-11-20 08:30:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 7, 'Building self-confidence', 'Exploring self-care techniques', 'Encouraging positive lifestyle changes', 'Follow-up sessions for progress assessment', 1),
(49, 'CC028-23/24', 4, 'E024-01-0833/2022', 46, '2023-11-21 06:45:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 11, 'Developing stress management strategies', 'Implementing behavior change techniques', 'Supporting resilience building', 'Scheduled sessions for monitoring progress', 1),
(50, 'CC029-23/24', 2, 'E033-01-0826/2020', 47, '2023-11-21 11:00:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 5, 'Academic guidance', 'Career exploration', 'Supporting decision-making', 'Goal-setting and achievement plan', 1),
(51, 'CC030-23/24', 1, 'E033-01-0528/2022', 48, '2023-11-22 06:30:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 8, 'Financial stress management', 'Budgeting and planning', 'Financial resources exploration', 'Follow-up sessions for financial wellness', 1),
(52, 'CC031-23/24', 4, 'E022-01-0826/2020', 49, '2023-11-22 08:45:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 12, 'Trauma recovery', 'Grief processing', 'Coping strategies', 'Continued therapy support', 1),
(53, 'CC032-23/24', 3, 'E022-01-0946/2021', 50, '2023-11-23 07:15:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 3, 'Health and wellness exploration', 'Health behavior change', 'Health improvement strategies', 'Regular health monitoring and development', 1),
(54, 'CC033-23/24', 2, 'E023-01-0826/2020', 51, '2023-11-23 10:00:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 10, 'Adjustment to university life', 'Social integration strategies', 'Community involvement opportunities', 'Continued sessions for adaptation', 1),
(55, 'CC034-23/24', 1, 'E023-01-0621/2021', 52, '2023-11-23 12:45:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 6, 'Personal development exploration', 'Self-improvement techniques', 'Personal growth plan', 'Follow-up sessions for personal growth assessment', 1),
(56, 'CC035-23/24', 4, 'E023-01-0920/2021', 53, '2023-12-04 09:30:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 9, 'Substance abuse management', 'Recovery strategies', 'Substance-free lifestyle development', 'Ongoing support and recovery plan', 1),
(57, 'CC036-23/24', 4, 'E029-01-0826/2020', 54, '2023-11-25 06:00:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 7, 'Family relationship support', 'Communication improvement strategies', 'Family harmony planning', 'Follow-up sessions for family dynamics', 1),
(58, 'CC037-23/24', 3, 'E029-01-0721/2022', 55, '2023-11-25 07:30:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 4, 'Personal growth exploration', 'Motivation enhancement', 'Personal goal-setting', 'Follow-up sessions for personal development', 1),
(59, 'CC038-23/24', 2, 'E028-01-0826/2020', 56, '2023-11-25 10:15:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 1, 'Academic performance improvement', 'Study techniques enhancement', 'Academic goal-setting', 'Regular academic progress monitoring', 1),
(60, 'CC039-23/24', 1, 'E028-01-0776/2022', 57, '2023-11-25 11:45:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 11, 'Conflict resolution strategies', 'Mediation techniques', 'Conflict resolution plan', 'Follow-up sessions for conflict management', 1),
(61, 'CC040-23/24', 4, 'E028-01-0829/2021', 58, '2023-11-27 13:00:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 13, 'Goal-setting and motivation strategies', 'Achievement plans', 'Goal achievement tracking', 'Ongoing goal-setting support', 1),
(62, 'CC041-23/24', 1, 'E033-01-0528/2022', 59, '2023-11-27 14:30:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 2, 'Career path exploration', 'Professional development strategies', 'Career growth planning', 'Career development guidance', 1),
(63, 'CC042-23/24', 3, 'E033-01-2821/2021', 60, '2023-11-29 08:00:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 9, 'Substance abuse recovery', 'Recovery plans', 'Substance-free lifestyle development', 'Follow-up sessions for recovery progress', 1),
(64, 'CC043-23/24', 4, 'E034-01-0747/2022', 61, '2023-12-01 09:00:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 12, 'Trauma recovery sessions', 'Grief processing techniques', 'Coping mechanisms', 'Continued therapy support', 1),
(65, 'CC044-23/24', 2, 'E020-01-0787/2021', 62, '2023-12-04 11:00:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 6, 'Personal development exploration', 'Self-improvement techniques', 'Personal growth plan', 'Follow-up sessions for personal growth assessment', 1),
(66, 'CC045-23/24', 1, 'E020-01-0826/2020', 63, '2023-12-04 12:00:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 8, 'Financial stress management', 'Budgeting and planning', 'Financial resources exploration', 'Follow-up sessions for financial wellness', 1),
(67, 'CC046-23/24', 4, 'T056-01-0826/2020', 64, '2023-12-04 13:00:00', '2023-2024', 'Semester One', 'Individual Counseling', 'Walk-in', 5, 'Academic guidance', 'Career exploration', 'Supporting decision-making', 'Goal-setting and achievement plan', 1),
(68, 'CC047-23/24', 2, 'C027-01-0823/2020', 0, '2024-02-10 13:33:41', '2023-2024', 'Semester Two', 'Individual Counseling', 'walk-in', 15, 'Test', 'Test', 'Test', 'Test', 1),
(69, 'CC048-23/24', 3, 'C027-01-2677/2020', 0, '2024-02-16 06:18:12', '2023-2024', 'Semester Two', 'Individual Counseling', 'walk-in', 7, 'Test', 'Test', 'Test', 'Test', 1),
(70, 'CC049-23/24', 3, 'T056-01-0888/2022', 0, '2024-02-16 06:42:30', '2023-2024', 'Semester Two', 'Individual Counseling', 'walk-in', 6, 'Test', 'Test', 'Test', 'Test', 1),
(71, 'CC050-23/24', 3, 'B011-01-0832/2022', 0, '2024-02-16 06:52:59', '2023-2024', 'Semester Two', 'Individual Counseling', 'Scheduled Appointment', 5, 'Test', 'Test', 'Test', 'Test', 1),
(72, 'CC051-23/24', 2, 'E028-01-0898/2021', 0, '2024-02-16 06:59:55', '2023-2024', 'Semester Two', 'Individual Counseling', 'Scheduled Appointment', 9, 'Test', 'Test', 'Test', 'Test', 4),
(73, 'CC052-23/24', 2, 'C025-01-0848/2023', 0, '2024-02-20 14:47:02', '2023-2024', 'Semester Two', 'Individual Counseling', 'walk-in', 12, 'Testing ', 'Testing ', 'Testing ', 'Testing ', 4),
(74, 'CC053-23/24', 1, 'C025-01-0007/2018', 0, '2024-02-20 14:51:37', '2023-2024', 'Semester Two', 'Individual Counseling', 'walk-in', 1, 'Pass this coming exams', 'Pass CATS\r\nMake a timetable', 'Study more often', 'Study more often', 4),
(75, 'CC054-23/24', 3, 'C027-01-0836/2020', 0, '2024-02-20 15:16:20', '2023-2024', 'Semester Two', 'Individual Counseling', 'walk-in', 6, 'Personal relationship with family members is not great', 'Mend the relationships', 'Put in the work', 'Make phone calls reaching out to family', 4),
(76, 'CC055-23/24', 3, 'T056-01-0888/2022', 0, '2024-03-09 11:14:49', '2023-2024', 'Semester Two', 'Individual Counseling', 'walk-in', 2, 'Testing the counselor ID', 'Testing the counselor ID', 'Testing the counselor ID', 'Testing the counselor ID', 4);

-- --------------------------------------------------------

--
-- Table structure for table `counseling_group`
--

CREATE TABLE `counseling_group` (
  `grp_counseling_id` int(11) NOT NULL,
  `grp_stud_regno` varchar(100) NOT NULL,
  `grp_stud_name` varchar(100) NOT NULL,
  `grp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `counseling_group`
--

INSERT INTO `counseling_group` (`grp_counseling_id`, `grp_stud_regno`, `grp_stud_name`, `grp_id`) VALUES
(30, 'C027-01-0836/2020 ', 'Isaya Onyango Opiyo', 28),
(31, 'C025-01-0629/2020', 'Janet Victoria Odalo', 28);

-- --------------------------------------------------------

--
-- Table structure for table `couns_appointmentype`
--

CREATE TABLE `couns_appointmentype` (
  `appmnid` int(11) NOT NULL,
  `appmntype` varchar(25) NOT NULL,
  `appmnstat` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `couns_appointmentype`
--

INSERT INTO `couns_appointmentype` (`appmnid`, `appmntype`, `appmnstat`) VALUES
(1, 'Walk-in', 'Active'),
(2, 'Scheduled Appointment', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `couns_approach`
--

CREATE TABLE `couns_approach` (
  `appr_id` int(11) NOT NULL,
  `couns_apprcode` varchar(50) NOT NULL,
  `couns_appr` varchar(50) NOT NULL,
  `approach_desc` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `couns_approach`
--

INSERT INTO `couns_approach` (`appr_id`, `couns_apprcode`, `couns_appr`, `approach_desc`) VALUES
(1, 'CA-001', 'Academic and Career Counseling', 'They focus on helping students with academic and career-related decisions'),
(2, 'CA-002', 'Trauma-Informed Therapy', 'Given that university students may have experienced trauma in their lives, a trauma-informed approach can be valuable in supporting those with trauma-related issues'),
(3, 'CA-003', 'Person-Centered Therapy', 'This approach can help students explore personal growth, self-awareness, and identity development, which are essential during the university years'),
(4, 'CA-004', 'Cognitive-Behavioral Therapy', 'Cognitive-Behavioral Therapy  is useful in addressing issues like test anxiety, stress management, time management, and study skills improvement, which are common concerns among university students');

-- --------------------------------------------------------

--
-- Table structure for table `couns_details`
--

CREATE TABLE `couns_details` (
  `counsId_ref` int(11) NOT NULL,
  `stud_regNo` varchar(20) NOT NULL,
  `couns_remarks` varchar(50) DEFAULT NULL,
  `couns_remarks_details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `couns_type`
--

CREATE TABLE `couns_type` (
  `couns_type_id` int(11) NOT NULL,
  `couns_type` varchar(50) NOT NULL,
  `couns_type_stat` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `couns_type`
--

INSERT INTO `couns_type` (`couns_type_id`, `couns_type`, `couns_type_stat`) VALUES
(1, 'Individual Counseling', 'Active'),
(2, 'Group Counseling', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_code` varchar(20) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `course_desc` varchar(100) NOT NULL DEFAULT 'Course Description',
  `course_curyr` varchar(20) DEFAULT NULL,
  `course_date_mod` datetime NOT NULL DEFAULT current_timestamp(),
  `course_date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `course_display_stat` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_code`, `course_name`, `course_desc`, `course_curyr`, `course_date_mod`, `course_date_add`, `course_display_stat`) VALUES
(1, 'BBIT', 'Bachelor of Business Information Technology', 'Course Description', '2023-2024', '2023-10-24 11:12:45', '2023-10-24 11:12:45', 'Active'),
(2, 'BIT', 'Bachelor of Science in Information Technology', 'Course Description', '2023-2024', '2023-10-24 11:13:45', '2023-10-24 11:13:45', 'Active'),
(3, 'BSCS', 'Bachelor of Science in Computer Science', 'Course Description', '2023-2024', '2023-10-24 11:14:45', '2023-10-24 11:14:45', 'Active'),
(4, 'BsCE', 'Bachelor of Science in Civil Engineering', 'Course Description', '2023-2024', '2023-10-24 11:13:45', '2023-10-24 11:13:45', 'Active'),
(5, 'EEE', 'Bachelor of Science in Electrical & Electronic Engineering', 'Course Description', '2023-2024', '2023-10-24 11:13:45', '2023-10-24 11:13:45', 'Active'),
(6, 'Bcom', 'Bachelor of Commerce', 'Course Description', '2023-2024', '2023-10-24 11:12:45', '2023-10-24 11:12:45', 'Active'),
(7, 'BBA', 'Bachelor of Business Administration ', 'Course Description', '2023-2024', '2023-10-24 11:12:45', '2023-10-24 11:12:45', 'Active'),
(8, 'BPSM', 'Bachelor of Purchasing and Supplies Management ', 'Course Description', '2023-2024', '2023-10-24 11:12:45', '2023-10-24 11:12:45', 'Active'),
(9, 'BScCiv', 'Bachelor of Science in Civil Engineering', 'Course Description', '2023-2024', '2023-10-24 11:12:45', '2023-10-24 11:12:45', 'Active'),
(10, 'BEDCiv', 'Bachelor of Education in Civil Engineering', 'Course Description', '2023-2024', '2023-10-24 11:12:45', '2023-10-24 11:12:45', 'Active'),
(11, 'BScCHEM', 'Bachelor of Science in Chemical Engineering', 'Course Description', '2023-2024', '2023-10-24 11:12:45', '2023-10-24 11:12:45', 'Active'),
(12, 'BScMECH', 'Bachelor of Science in Mechatronics Engineering', 'Course Description', '2023-2024', '2023-10-24 11:12:45', '2023-10-24 11:12:45', 'Active'),
(13, 'BScELE', 'Bachelor of Science in Electrical Engineering', 'Course Description', '2023-2024', '2023-10-24 11:12:45', '2023-10-24 11:12:45', 'Active'),
(14, 'BScMEC', 'Bachelor of Science in Mechanical Engineering', 'Course Description', '2023-2024', '2023-10-24 11:12:45', '2023-10-24 11:12:45', 'Active'),
(15, 'BEDMEC', 'Bachelor of Education in Mechanical Engineering', 'Course Description', '2023-2024', '2023-10-24 11:12:45', '2023-10-24 11:12:45', 'Active'),
(16, 'BScTIE', 'Bachelor of Science in Technology and Industrial Entrepreneurship', 'Course Description', '2023-2024', '2023-10-24 11:12:45', '2023-10-24 11:12:45', 'Active'),
(17, 'BEDEE', 'Bachelor of Education in Electrical Engineering', 'Course Description', '2023-2024', '2023-10-24 11:12:45', '2023-10-24 11:12:45', 'Active'),
(18, 'BTEBC', 'Bachelor of Technology in Building Construction', 'Course Description', '2023-2024', '2023-10-24 11:12:45', '2023-10-24 11:12:45', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `marital_stat`
--

CREATE TABLE `marital_stat` (
  `marital_status_id` int(11) NOT NULL,
  `marital_status` varchar(20) NOT NULL,
  `marital_status_stat` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `marital_stat`
--

INSERT INTO `marital_stat` (`marital_status_id`, `marital_status`, `marital_status_stat`) VALUES
(1, 'Single', 'Active'),
(2, 'In a relationship', 'Active'),
(3, 'married', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `nature_of_case`
--

CREATE TABLE `nature_of_case` (
  `case_id` int(11) NOT NULL,
  `case_name` varchar(50) NOT NULL,
  `case_stat` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `nature_of_case`
--

INSERT INTO `nature_of_case` (`case_id`, `case_name`, `case_stat`) VALUES
(1, 'Academic Challenges', 'Active'),
(2, 'Career Guidance', 'Active'),
(3, 'Health and Wellness', 'Active'),
(4, 'Personal Development', 'Active'),
(5, 'Mental Health Concerns', 'Active'),
(6, 'Family Issues', 'Active'),
(7, 'Substance Abuse', 'Active'),
(8, 'Financial Stress', 'Active'),
(9, 'Social Integration', 'Active'),
(10, 'Sexual Health', 'Active'),
(11, 'Adjustment to University Life', 'Active'),
(12, 'Trauma and Grief', 'Active'),
(13, 'Conflict Resolution', 'Active'),
(14, 'Goal Setting and Motivation', 'Active'),
(15, 'Other', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `remarks`
--

CREATE TABLE `remarks` (
  `remarks_id` int(11) NOT NULL,
  `remarks_type` varchar(50) NOT NULL,
  `remarks_desc` text DEFAULT NULL,
  `remarks_stat` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `sem_id` int(11) NOT NULL,
  `sem_code` varchar(20) NOT NULL,
  `sem_name` varchar(50) NOT NULL,
  `sem_date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `sem_date_mod` datetime NOT NULL DEFAULT current_timestamp(),
  `sem_display_stat` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`sem_id`, `sem_code`, `sem_name`, `sem_date_add`, `sem_date_mod`, `sem_display_stat`) VALUES
(1, 'Sem01', 'Semester One', '2023-10-24 10:44:38', '2023-10-24 10:44:38', 'Active'),
(2, 'Sem02', 'Semester Two', '2023-10-24 10:45:38', '2023-10-24 10:45:48', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `stud_profile`
--

CREATE TABLE `stud_profile` (
  `stud_Id` int(11) NOT NULL,
  `stud_regNo` varchar(20) NOT NULL,
  `stud_fullname` varchar(100) NOT NULL,
  `stud_gender` enum('Male','Female') NOT NULL DEFAULT 'Male',
  `stud_course` varchar(20) NOT NULL,
  `stud_yrlevel` int(11) NOT NULL DEFAULT 1,
  `stud_birth_date` date NOT NULL,
  `stud_hometown` varchar(50) NOT NULL,
  `stud_address` varchar(500) NOT NULL DEFAULT 'Not Specify',
  `stud_mobileNo` varchar(20) NOT NULL DEFAULT 'None',
  `stud_email` varchar(100) NOT NULL,
  `stud_birthplace` varchar(500) DEFAULT NULL,
  `stud_modDate` datetime NOT NULL DEFAULT current_timestamp(),
  `stud_addDate` datetime NOT NULL DEFAULT current_timestamp(),
  `stud_date_deactivate` datetime DEFAULT NULL,
  `stud_display_status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `stud_profile`
--

INSERT INTO `stud_profile` (`stud_Id`, `stud_regNo`, `stud_fullname`, `stud_gender`, `stud_course`, `stud_yrlevel`, `stud_birth_date`, `stud_hometown`, `stud_address`, `stud_mobileNo`, `stud_email`, `stud_birthplace`, `stud_modDate`, `stud_addDate`, `stud_date_deactivate`, `stud_display_status`) VALUES
(1, 'C027-01-0759/2020', 'Hannah Nyambura Muiruri', 'Female', 'BBIT', 4, '2001-08-05', 'Nyeri', '345 Nyeri', '0718968805', 'nyambura.hannah20@students.dkut.ac.ke', 'Nyeri General Hospital', '2020-08-01 10:44:32', '2020-08-01 10:44:32', '0000-00-00 00:00:00', 'Active'),
(2, 'C027-01-0760/2020', 'Rose Muthoni Muiruri', 'Female', 'BBIT', 4, '2001-08-05', 'Nyeri', '345 Nyeri', '0742098214', 'muthoni.rose20@students.dkut.ac.ke', 'Nyeri General Hospital', '2020-08-01 10:44:34', '2020-08-01 10:44:34', '0000-00-00 00:00:00', 'Active'),
(3, 'C027-01-0836/2020', 'Isaya Onyango Opiyo', 'Male', 'BBIT', 4, '2002-02-09', 'Kisumu', '711 Kisumu', '0750273715', 'onyango.isaya20@students.dkut.ac.ke', 'Marie Stopes', '2020-08-01 10:44:37', '2020-08-01 10:44:37', '0000-00-00 00:00:00', 'Active'),
(4, 'C027-01-2719/2020', 'Ephantus  Njogu Gatuu', 'Male', 'BBIT', 4, '2001-11-25', 'Nanyuki', '189 Nanyuki', '0746590260', 'gatuu.ephantus20@students.dkut.ac.ke', 'Nanyuki General Hospital', '2020-08-01 10:44:38', '2020-08-01 10:44:38', '0000-00-00 00:00:00', 'Active'),
(5, 'C027-01-0826/2020', 'John Muturi Kibocha', 'Male', 'BBIT', 4, '2001-10-08', 'Kirinyaga', '147 Mabuyuni', '0714547767', 'kibocha.john20@students.dkut.ac.ke', 'Kirinyaga General Hospital', '2020-08-01 10:44:38', '2020-08-01 10:44:38', '0000-00-00 00:00:00', 'Active'),
(6, 'C027-01-0823/2020', 'Janice Wairimu Kinyua', 'Female', 'BBIT', 4, '2001-07-02', 'Nairobi', '243 Parklands', '0786224063', 'wairimu.janice20@students.dkut.ac.ke', 'Metropolitan Hospital', '2020-08-01 10:44:38', '2020-08-01 10:44:38', '0000-00-00 00:00:00', 'Active'),
(7, 'C027-01-0781/2020', 'Yvonne Muthoni Maina', 'Female', 'BBIT', 4, '2002-06-03', 'Nairobi', '043 Kilimani', '0736490696', 'maina.yvonne20@students.dkut.ac.ke', 'Aga Khan Hospital', '2020-08-01 10:44:38', '2020-08-01 10:44:38', '0000-00-00 00:00:00', 'Active'),
(8, 'C027-01-2556/2020', 'Michael Samuel Mwenja Kamau', 'Female', 'BBIT', 4, '2002-11-23', 'Nakuru', '486 Milimani', '0718623742', 'michael.kamau20@students.dkut.ac.ke', 'Nakuru Hospital', '2020-08-01 10:44:38', '2020-08-01 10:44:38', '0000-00-00 00:00:00', 'Active'),
(9, 'C027-01-2677/2020', 'DOREEN NYAWIRA KINYUA', 'Female', 'BBIT', 4, '2000-04-24', 'Kirinyaga', '019 Kerugoya', '0725421289', 'doreen.kinyua20@students.dkut.ac.ke', 'Kirinyaga General Hospital', '2020-08-01 10:44:38', '2020-08-01 10:44:38', '0000-00-00 00:00:00', 'Active'),
(10, 'C027-01-0807/2020', 'BENJAMIN MUTHEE MARIGA', 'Male', 'BBIT', 4, '2001-08-19', 'Kakamega', '007 Kakamega', '0707892598', 'mariga.benjamin20@students.dkut.ac.ke', 'Nala Maternity & Nursing Home', '2020-08-01 10:44:38', '2020-08-01 10:44:38', '0000-00-00 00:00:00', 'Active'),
(11, 'C025-01-0629/2020', 'JANET VICTORIA ODALO', 'Female', 'BIT', 4, '2001-01-06', 'Eldoret', '629 Milimani', '0794292065', 'odalo.janet20@students.dekut.ac.ke', 'Elgonview Hospital', '2020-08-01 10:44:38', '2020-08-01 10:44:38', '0000-00-00 00:00:00', 'Active'),
(12, 'B010-01-1234/2023', 'Mary Wanjiru', 'Female', 'BCom', 1, '2004-05-15', 'Nairobi', '123 Kilimall', '0712345678', 'mary.wanjiru23@students.dkut.ac.ke', 'Nairobi Hospital', '2022-11-17 09:00:00', '2022-11-17 09:00:00', NULL, 'Active'),
(13, 'B011-01-5678/2020', 'Joseph Otieno', 'Male', 'BPSM', 2, '1999-08-20', 'Kisumu', '456 Kondele', '0723456789', 'joseph.otieno@students.dkut.ac.ke', 'Kisumu Hospital', '2022-11-17 09:00:00', '2022-11-17 09:00:00', NULL, 'Active'),
(14, 'B012-01-0001/2021', 'Alice Brown', 'Female', 'BBA', 3, '2001-01-10', 'Mombasa', '101 Beach Road Mombasa', '0745678901', 'alice.brown21@students.dkut.ac.ke', 'Mombasa Hospital', '2023-11-18 00:00:00', '2023-11-18 00:00:00', NULL, 'Active'),
(15, 'B010-01-0826/2020', 'Grace Kinyua', 'Female', 'BCom', 4, '2000-07-15', 'Nyeri', '123 Skuta', '0723456789', 'grace.kinyua20@students.dkut.ac.ke', 'Nyeri General Hospital', '2020-08-02 09:30:00', '2020-08-02 09:30:00', '0000-00-00 00:00:00', 'Active'),
(16, 'B010-01-0827/2021', 'Peter Maina', 'Male', 'BCom', 3, '2002-04-20', 'Kiambu', '456 Riverside', '0712345678', 'peter.maina21@students.dkut.ac.ke', 'Kiambu District Hospital', '2021-09-10 11:15:00', '2021-09-10 11:15:00', '0000-00-00 00:00:00', 'Active'),
(17, 'B010-01-0828/2022', 'Sarah Wanjiku', 'Female', 'BCom', 2, '2003-01-05', 'Muranga', '789 Kilimani', '0701234567', 'sarah.wanjiku22@students.dkut.ac.ke', 'Muranga Hospital', '2022-06-05 14:20:00', '2022-06-05 14:20:00', '0000-00-00 00:00:00', 'Active'),
(18, 'B011-01-0829/2020', 'James Kamau', 'Male', 'BPSM', 4, '2000-11-30', 'Thika', '234 Parklands', '0756789012', 'james.kamau20@students.dkut.ac.ke', 'Thika Level 5 Hospital', '2020-08-03 10:00:00', '2020-08-03 10:00:00', '0000-00-00 00:00:00', 'Active'),
(19, 'B012-01-0830/2020', 'Mary Nduta', 'Female', 'BBA', 4, '1999-09-25', 'Embu', '567 Westlands', '0790123456', 'mary.nduta20@students.dkut.ac.ke', 'Embu Teaching and Referral Hospital', '2020-08-04 09:45:00', '2020-08-04 09:45:00', '0000-00-00 00:00:00', 'Active'),
(20, 'B011-01-0831/2021', 'Evelyn Wairimu', 'Female', 'BPSM', 3, '2002-08-12', 'Nairobi', '890 Valley Road', '0765432109', 'evelyn.wairimu21@students.dkut.ac.ke', 'Nairobi Hospital', '2021-10-15 10:30:00', '2021-10-15 10:30:00', '0000-00-00 00:00:00', 'Active'),
(21, 'B011-01-0832/2022', 'Daniel Mwangi', 'Male', 'BPSM', 2, '2003-05-17', 'Machakos', '123 Kitengela', '0745678901', 'daniel.mwangi22@students.dkut.ac.ke', 'Machakos General Hospital', '2022-12-20 09:15:00', '2022-12-20 09:15:00', '0000-00-00 00:00:00', 'Active'),
(22, 'B011-01-0833/2023', 'Alice Chebet', 'Female', 'BPSM', 1, '2004-02-22', 'Eldoret', '456 Eldoret Town', '0732109876', 'alice.chebet23@students.dkut.ac.ke', 'Eldoret Referral Hospital', '2023-07-05 11:00:00', '2023-07-05 11:00:00', '0000-00-00 00:00:00', 'Active'),
(23, 'B012-01-0834/2021', 'Mercy Akinyi', 'Female', 'BBA', 3, '2002-09-28', 'Kisumu', '678 Kisumu Central', '0721098765', 'mercy.akinyi21@students.dkut.ac.ke', 'Kisumu County Hospital', '2021-11-30 12:45:00', '2021-11-30 12:45:00', '0000-00-00 00:00:00', 'Active'),
(24, 'B012-01-0835/2022', 'Joseph Njoroge', 'Male', 'BBA', 2, '2003-06-23', 'Nakuru', '901 Nakuru West', '0710987654', 'joseph.njoroge22@students.dkut.ac.ke', 'Nakuru General Hospital', '2022-02-25 13:30:00', '2022-02-25 13:30:00', '0000-00-00 00:00:00', 'Active'),
(25, 'B012-01-0836/2023', 'Ann Wangari', 'Female', 'BBA', 1, '2004-03-15', 'Mombasa', '234 Mombasa Island', '0709876543', 'ann.wangari23@students.dkut.ac.ke', 'Coast General Hospital', '2023-08-10 14:15:00', '2023-08-10 14:15:00', '0000-00-00 00:00:00', 'Active'),
(26, 'C026-01-0837/2021', 'Alice Kamau', 'Female', 'BSCS', 3, '2002-08-12', 'Nairobi', '890 Valley Road', '0765432109', 'alice.kamau21@students.dkut.ac.ke', 'Nairobi Hospital', '2021-10-15 10:30:00', '2021-10-15 10:30:00', '0000-00-00 00:00:00', 'Active'),
(27, 'C026-01-0838/2022', 'Brian Mwangi', 'Male', 'BSCS', 2, '2003-05-17', 'Machakos', '123 Kitengela', '0745678901', 'brian.mwangi22@students.dkut.ac.ke', 'Machakos General Hospital', '2022-12-20 09:15:00', '2022-12-20 09:15:00', '0000-00-00 00:00:00', 'Active'),
(28, 'C026-01-0839/2023', 'Catherine Chebet', 'Female', 'BSCS', 1, '2004-02-22', 'Eldoret', '456 Eldoret Town', '0732109876', 'catherine.chebet23@students.dkut.ac.ke', 'Eldoret Referral Hospital', '2023-07-05 11:00:00', '2023-07-05 11:00:00', '0000-00-00 00:00:00', 'Active'),
(29, 'C025-01-0840/2021', 'David Oyoo', 'Male', 'BIT', 3, '2002-09-28', 'Kisumu', '678 Kisumu Central', '0721098765', 'david.oyoo21@students.dkut.ac.ke', 'Kisumu County Hospital', '2021-11-30 12:45:00', '2021-11-30 12:45:00', '0000-00-00 00:00:00', 'Active'),
(30, 'C025-01-0841/2022', 'Esther Wangari', 'Female', 'BIT', 2, '2003-06-23', 'Nakuru', '901 Nakuru West', '0710987654', 'esther.wangari22@students.dkut.ac.ke', 'Nakuru General Hospital', '2022-02-25 13:30:00', '2022-02-25 13:30:00', '0000-00-00 00:00:00', 'Active'),
(31, 'E021-01-0842/2021', 'Faith Wairimu', 'Female', 'EEE', 3, '2002-08-12', 'Nairobi', '890 Valley Road', '0765432109', 'faith.wairimu21@students.dkut.ac.ke', 'Nairobi Hospital', '2021-10-15 10:30:00', '2021-10-15 10:30:00', '0000-00-00 00:00:00', 'Active'),
(32, 'E021-01-0843/2022', 'George Kamau', 'Male', 'EEE', 2, '2003-05-17', 'Machakos', '123 Kitengela', '0745678901', 'george.kamau22@students.dkut.ac.ke', 'Machakos General Hospital', '2022-12-20 09:15:00', '2022-12-20 09:15:00', '0000-00-00 00:00:00', 'Active'),
(33, 'C026-01-0844/2022', 'Emily Njeri', 'Female', 'BSCS', 2, '2003-07-20', 'Nyeri', '456 Karatina', '0723456789', 'emily.njeri22@students.dkut.ac.ke', 'Nyeri General Hospital', '2022-06-20 10:00:00', '2022-06-20 10:00:00', '0000-00-00 00:00:00', 'Active'),
(34, 'C026-01-0845/2023', 'Kevin Otieno', 'Male', 'BSCS', 1, '2004-04-15', 'Kisii', '789 Kisii Town', '0712345678', 'kevin.otieno23@students.dkut.ac.ke', 'Kisii Teaching and Referral Hospital', '2023-09-05 11:45:00', '2023-09-05 11:45:00', '0000-00-00 00:00:00', 'Active'),
(35, 'C026-01-0846/2023', 'Grace Muthoni', 'Female', 'BSCS', 1, '2004-03-10', 'Muranga', '012 Muranga North', '0701234567', 'grace.muthoni23@students.dkut.ac.ke', 'Muranga County Hospital', '2023-08-20 09:30:00', '2023-08-20 09:30:00', '0000-00-00 00:00:00', 'Active'),
(36, 'C025-01-0847/2022', 'Brian Otieno', 'Male', 'BIT', 2, '2003-08-25', 'Kakamega', '234 Kakamega Central', '0756789012', 'brian.otieno22@students.dkut.ac.ke', 'Kakamega General Hospital', '2022-07-10 11:30:00', '2022-07-10 11:30:00', '0000-00-00 00:00:00', 'Active'),
(37, 'C025-01-0848/2023', 'Susan Wambui', 'Female', 'BIT', 1, '2004-05-18', 'Meru', '567 Meru Town', '0745678901', 'susan.wambui23@students.dkut.ac.ke', 'Meru Level 5 Hospital', '2023-10-15 12:15:00', '2023-10-15 12:15:00', '0000-00-00 00:00:00', 'Active'),
(38, 'C025-01-0849/2023', 'Daniel Kimani', 'Male', 'BIT', 1, '2004-04-12', 'Kiambu', '890 Kiambu West', '0732109876', 'daniel.kimani23@students.dkut.ac.ke', 'Kiambu District Hospital', '2023-09-25 13:00:00', '2023-09-25 13:00:00', '0000-00-00 00:00:00', 'Active'),
(39, 'E021-01-0850/2022', 'Lilian Atieno', 'Female', 'EEE', 2, '2003-09-30', 'Siaya', '678 Ugenya', '0721098765', 'lilian.atieno22@students.dkut.ac.ke', 'Embu Teaching Hospital', '2022-08-20 14:30:00', '2022-08-20 14:30:00', '0000-00-00 00:00:00', 'Active'),
(40, 'E021-01-0851/2023', 'Paul Ngugi', 'Male', 'EEE', 1, '2004-06-25', 'Nakuru', '901 Nakuru West', '0710987654', 'paul.ngugi23@students.dkut.ac.ke', 'Nakuru General Hospital', '2023-01-05 15:15:00', '2023-01-05 15:15:00', '0000-00-00 00:00:00', 'Active'),
(41, 'E021-01-0852/2023', 'Joyce Aluoch', 'Female', 'EEE', 1, '2004-05-20', 'Homa Bay', '234 Kendu Bay', '0709876543', 'joyce.aluoch23@students.dkut.ac.ke', 'Kisumu County Hospital', '2023-05-15 16:00:00', '2023-05-15 16:00:00', '0000-00-00 00:00:00', 'Active'),
(42, 'C026-01-0001/2016', 'James Kamau', 'Male', 'BSCS', 4, '1998-06-15', 'Nairobi', '123 Parklands', '0712345678', 'james.kamau16@students.dkut.ac.ke', 'Nairobi Hospital', '2016-08-01 10:00:00', '2016-08-01 10:00:00', NULL, 'Inactive'),
(43, 'C026-01-0002/2017', 'Grace Njeri', 'Female', 'BSCS', 4, '1999-04-20', 'Kiambu', '456 Thika Road', '0723456789', 'grace.njeri17@students.dkut.ac.ke', 'Kiambu District Hospital', '2017-09-15 09:30:00', '2017-09-15 09:30:00', NULL, 'Active'),
(44, 'B010-01-0003/2018', 'Peter Omondi', 'Male', 'BCom', 4, '2000-03-25', 'Kisumu', '789 Kisumu Central', '0734567890', 'peter.omondi18@students.dkut.ac.ke', 'Kisumu Teaching Hospital', '2018-07-05 11:45:00', '2018-07-05 11:45:00', NULL, 'Active'),
(45, 'C026-01-0005/2016', 'Kevin Kimani', 'Male', 'BSCS', 4, '1998-08-05', 'Eldoret', '345 Eldoret East', '0756789012', 'kevin.kimani16@students.dkut.ac.ke', 'Eldoret County Hospital', '2016-10-10 14:30:00', '2016-10-10 14:30:00', NULL, 'Active'),
(46, 'C025-01-0006/2017', 'Lilian Kiprop', 'Female', 'BIT', 4, '1999-07-18', 'Nairobi', '123 Ngara', '0712008236', 'lilian.kiprop17@students.dkut.ac.ke', 'Nairobi Hospital', '2017-12-01 10:00:00', '2017-12-01 10:00:00', NULL, 'Active'),
(47, 'C025-01-0007/2018', 'John Ndungu', 'Male', 'BIT', 4, '2000-06-22', 'Mombasa', '456 Mombasa Central', '072375801', 'john.ndungu18@students.dkut.ac.ke', 'Coast General Hospital', '2018-03-15 09:30:00', '2018-03-15 09:30:00', NULL, 'Active'),
(48, 'BBA-01-0008/2019', 'Mary Auma', 'Female', 'BBA', 4, '2001-05-28', 'Kisumu', '789 Kisumu West', '0738618023', 'mary.auma19@students.dkut.ac.ke', 'Kisumu Teaching Hospital', '2019-06-05 11:45:00', '2019-06-05 11:45:00', NULL, 'Active'),
(49, 'C025-01-0009/2016', 'George Ochieng', 'Male', 'BIT', 4, '1997-09-30', 'Eldoret', '012 Eldoret North', '0745679444', 'george.ochieng16@students.dkut.ac.ke', 'Eldoret County Hospital', '2016-08-20 14:30:00', '2016-08-20 14:30:00', NULL, 'Inactive'),
(50, 'C025-01-0010/2017', 'Alice Chebet', 'Female', 'BIT', 4, '1998-11-14', 'Nakuru', '345 Nakuru Central', '0759742375', 'alice.chebet17@students.dkut.ac.ke', 'Nakuru General Hospital', '2017-10-05 12:15:00', '2017-10-05 12:15:00', NULL, 'Active'),
(51, 'E021-01-0011/2016', 'Josephine Wanjiku', 'Female', 'EEE', 4, '1998-12-20', 'Nairobi', '123 Karen', '0716524906', 'josephine.wanjiku16@students.dkut.ac.ke', 'Nairobi Hospital', '2016-11-30 10:00:00', '2016-11-30 10:00:00', NULL, 'Active'),
(52, 'E021-01-0012/2017', 'Samuel Kimutai', 'Male', 'EEE', 4, '1999-10-12', 'Mombasa', '456 Likoni', '0727097640', 'samuel.kimutai17@students.dkut.ac.ke', 'Coast General Hospital', '2017-04-15 09:30:00', '2017-04-15 09:30:00', NULL, 'Active'),
(53, 'B011-01-0013/2018', 'Emily Nyambura', 'Female', 'BPSM', 4, '2000-08-25', 'Kisumu', '789 Kondele', '0738275015', 'emily.nyambura18@students.dkut.ac.ke', 'Kisumu Teaching Hospital', '2018-09-05 11:45:00', '2018-09-05 11:45:00', NULL, 'Active'),
(54, 'E021-01-0014/2019', 'David Kiptoo', 'Male', 'EEE', 4, '2001-07-09', 'Eldoret', '012 Langas', '0749222086', 'david.kiptoo19@students.dkut.ac.ke', 'Eldoret County Hospital', '2019-10-20 14:30:00', '2019-10-20 14:30:00', NULL, 'Active'),
(55, 'E021-01-0015/2016', 'Hannah Wairimu', 'Female', 'EEE', 4, '1998-09-15', 'Nakuru', '345 Free Area', '0750622697', 'hannah.wairimu16@students.dkut.ac.ke', 'Nakuru General Hospital', '2016-12-05 12:15:00', '2016-12-05 12:15:00', NULL, 'Inactive'),
(56, 'C026-01-0004/2019', 'Sarah Wambui', 'Female', 'BSCS', 4, '2001-02-10', 'Nakuru', '012 Nakuru West', '0745678901', 'sarah.wambui19@students.dkut.ac.ke', 'Nakuru General Hospital', '2019-11-20 12:15:00', '2019-11-20 12:15:00', NULL, 'Active'),
(57, 'E024-01-0826/2021', 'David Odhiambo Ochieng', 'Male', 'BScCiv', 3, '2002-05-15', 'Siaya', '223 Karatina', '0712345678', 'david.odhiambo21@students.dkut.ac.ke', 'Siaya County Hospital', '2021-08-02 09:30:45', '2021-08-02 09:30:45', NULL, 'Active'),
(58, 'E024-01-0826/2020', 'Daniel Njoroge Mugo', 'Male', 'BScCE', 4, '2001-09-15', 'Nyeri', '263 Gatitu', '0712345678', 'mugo.daniel20@students.dkut.ac.ke', 'Nyeri Hospital', '2020-08-02 10:44:38', '2020-08-02 10:44:38', NULL, 'Active'),
(59, 'E033-01-0826/2020', 'Esther Wanjiru Kimani', 'Female', 'BEDCE', 4, '2001-05-20', 'Muranga', '39 Kagunduini', '0723456789', 'kimani.esther20@students.dkut.ac.ke', 'Murang\'a Clinic', '2020-08-03 10:44:38', '2020-08-03 10:44:38', NULL, 'Active'),
(60, 'E022-01-0826/2020', 'Josephat Gitau Maina', 'Male', 'BScMECH', 4, '2001-03-10', 'Thika', '12345 Gatitu', '0734567890', 'maina.josephat20@students.dkut.ac.ke', 'Thika General Hospital', '2020-08-04 10:44:38', '2020-08-04 10:44:38', NULL, 'Active'),
(61, 'E023-01-0826/2020', 'Grace Muthoni Njoroge', 'Female', 'BScMEC', 4, '2001-07-18', 'Kerugoya', '6789 Gatitu', '0745678901', 'njoroge.grace20@students.dkut.ac.ke', 'Kerugoya Hospital', '2020-08-05 10:44:38', '2020-08-05 10:44:38', NULL, 'Active'),
(62, 'E029-01-0826/2020', 'Moses Njenga Kariuki', 'Male', 'BEDMEC', 4, '2001-11-25', 'Nanyuki', '9876 Estate Way', '0756789012', 'kariuki.moses20@students.dkut.ac.ke', 'Nanyuki General Hospital', '2020-08-06 10:44:38', '2020-08-06 10:44:38', NULL, 'Active'),
(63, 'E020-01-0826/2020', 'Mary Wangari Nyambura', 'Female', 'BScTIE', 4, '2001-12-30', 'Meru', '7654 Forest Walk', '0767890123', 'nyambura.mary20@students.dkut.ac.ke', 'Meru Hospital', '2020-08-07 10:44:38', '2020-08-07 10:44:38', NULL, 'Active'),
(64, 'E028-01-0826/2020', 'Paul Ngugi Kamau', 'Male', 'BEDEE', 4, '2001-08-05', 'Mutunduri', '5432 Siakago', '0778901234', 'kamau.paul20@students.dkut.ac.ke', 'Embu Clinic', '2020-08-08 10:44:38', '2020-08-08 10:44:38', NULL, 'Active'),
(65, 'T056-01-0826/2020', 'Sarah Wambui Njeri', 'Female', 'BTEBC', 4, '2001-06-12', 'Embu', '2345 Gatitu', '0789012345', 'njeri.sarah20@students.dkut.ac.ke', 'Embu Hospital', '2020-08-09 10:44:38', '2020-08-09 10:44:38', NULL, 'Active'),
(66, 'E034-01-0826/2020', 'David Githinji Muchiri', 'Male', 'BScCHEM', 4, '2001-02-18', 'Nairobi', '4567 Ruiru', '0790123456', 'muchiri.david20@students.dkut.ac.ke', 'Nairobi General Hospital', '2020-08-10 10:44:38', '2020-08-10 10:44:38', NULL, 'Active'),
(67, 'E024-01-0827/2021', 'Eunice Wanjiku Ndungu', 'Female', 'BScCE', 3, '2002-11-20', 'Nyeri', '1234 Embassy', '0712345678', 'ndungu.eunice21@students.dkut.ac.ke', 'Nyeri General Hospital', '2021-08-02 10:44:38', '2021-08-02 10:44:38', NULL, 'Active'),
(68, 'E029-01-0721/2022', 'Peter Kipchirchir Koech', 'Male', 'BEDMEC', 2, '2003-11-28', 'Uasin Gishu', '567 Nakuru', '0756789012', 'peter.kipchirchir22@students.dkut.ac.ke', 'Uasin Gishu County Hospital', '2022-08-06 16:30:35', '2022-08-06 16:30:35', NULL, 'Active'),
(69, 'E022-01-0946/2021', 'Jane Njeri Wanjiru', 'Female', 'BScMECH', 3, '2002-03-05', 'Thika', '7890 Gatitu', '0734567890', 'wanjiru.jane21@students.dkut.ac.ke', 'Thika General Hospital', '2021-08-04 10:44:38', '2021-08-04 10:44:38', NULL, 'Active'),
(70, 'E023-01-0621/2021', 'Peter Gitau Ngugi', 'Male', 'BScMEC', 3, '2002-07-18', 'Kerugoya', '0987 Gatitu', '0745678901', 'ngugi.peter21@students.dkut.ac.ke', 'Kerugoya Hospital', '2021-08-05 10:44:38', '2021-08-05 10:44:38', NULL, 'Active'),
(71, 'E033-01-0528/2022', 'Daniel Kiprop Cheruiyot', 'Male', 'BEDCiv', 2, '2003-02-20', 'Bomet', '112 Bomet', '0723456789', 'daniel.kiprop22@students.dkut.ac.ke', 'Nandi Hills District Hospital', '2022-08-03 11:15:30', '2022-08-03 11:15:30', NULL, 'Active'),
(72, 'E020-01-0787/2021', 'Pauline Nyambura Gichuru', 'Female', 'BScTIE', 3, '2002-01-30', 'Meru', '4321 Gatitu', '0767890123', 'gichuru.pauline21@students.dkut.ac.ke', 'Meru Hospital', '2021-08-07 10:44:38', '2021-08-07 10:44:38', NULL, 'Active'),
(73, 'E028-01-0829/2021', 'Mark Njenga Kamau', 'Male', 'BEDEE', 3, '2002-08-05', 'Gatundu', '5678 Gatundu South', '0778901234', 'kamau.mark21@students.dkut.ac.ke', 'Gatundu General Hospital', '2021-08-08 10:44:38', '2021-08-08 10:44:38', NULL, 'Active'),
(74, 'T056-01-0620/2022', 'Joyce Chepkorir Kimutai', 'Female', 'BTEBC', 2, '2003-06-25', 'Elgeyo-Marakwet', '901 Elgeyo', '0701234567', 'joyce.chepkorir22@students.dkut.ac.ke', 'Elgeyo-Marakwet County Hospital', '2022-08-09 22:30:25', '2022-08-09 22:30:25', NULL, 'Active'),
(75, 'E034-01-0724/2021', 'David Githinji Muchiri', 'Male', 'BScCHEM', 3, '2002-02-18', 'Limuru', '7890 Escarpment', '0790123456', 'muchiri.david21@students.dkut.ac.ke', 'Limuru General Hospital', '2021-08-10 10:44:38', '2021-08-10 10:44:38', NULL, 'Active'),
(76, 'E024-01-0621/2021', 'Alice Atieno Auma', 'Female', 'BScCE', 3, '2002-09-25', 'Kisumu', '3456 Beach Rd', '0701122334', 'auma.alice21@students.dkut.ac.ke', 'Kisumu Hospital', '2021-08-11 10:44:38', '2021-08-11 10:44:38', NULL, 'Active'),
(77, 'E033-01-2821/2021', 'Daniel Odhiambo Omondi', 'Male', 'BEDCE', 3, '2002-11-11', 'Mombasa', '6789 Coastline St', '0712233445', 'omondi.daniel21@students.dkut.ac.ke', 'Mombasa Clinic', '2021-08-12 10:44:38', '2021-08-12 10:44:38', NULL, 'Active'),
(78, 'E022-01-2323/2021', 'Grace Akinyi Adhiambo', 'Female', 'BScMECH', 3, '2002-10-30', 'Kisumu', '8901 Lakeview St', '0723344556', 'adhiambo.grace21@students.dkut.ac.ke', 'Kisumu General Hospital', '2021-08-13 10:44:38', '2021-08-13 10:44:38', NULL, 'Active'),
(79, 'E023-01-0920/2021', 'Brian Ochieng Otieno', 'Male', 'BScMEC', 3, '2002-12-12', 'Kisii', '0123 Highlands St', '0734455667', 'otieno.brian21@students.dkut.ac.ke', 'Kisii Hospital', '2021-08-14 10:44:38', '2021-08-14 10:44:38', NULL, 'Active'),
(80, 'E029-01-0649/2021', 'Lucy Anyango Achieng', 'Female', 'BEDMEC', 3, '2002-08-05', 'Homabay', '2345 Bayview Rd', '0745566778', 'achieng.lucy21@students.dkut.ac.ke', 'Homabay Clinic', '2021-08-15 10:44:38', '2021-08-15 10:44:38', NULL, 'Active'),
(81, 'E020-01-0729/2021', 'Samuel Barasa Were', 'Male', 'BScTIE', 3, '2002-06-23', 'Kakamega', '4567 Forest St', '0756677889', 'were.samuel21@students.dkut.ac.ke', 'Kakamega Hospital', '2021-08-16 10:44:38', '2021-08-16 10:44:38', NULL, 'Active'),
(82, 'E028-01-0898/2021', 'Mercy Adhiambo Masika', 'Female', 'BEDEE', 3, '2002-04-17', 'Garissa', '6789 Desert St', '0767788990', 'masika.mercy21@students.dkut.ac.ke', 'Garissa Clinic', '2021-08-17 10:44:38', '2021-08-17 10:44:38', NULL, 'Active'),
(83, 'T056-01-0860/2021', 'Kevin Otieno Omondi', 'Male', 'BTEBC', 3, '2002-02-14', 'Isiolo', '8901 Savannah St', '0779869201', 'omondi.kevin21@students.dkut.ac.ke', 'Isiolo Hospital', '2021-08-18 10:44:38', '2021-08-18 10:44:38', NULL, 'Active'),
(84, 'E034-01-0813/2021', 'Catherine Akoth Atieno', 'Female', 'BScCHEM', 3, '2002-01-06', 'Kwale', '0123 Beachside St', '0728994012', 'atieno.catherine21@students.dkut.ac.ke', 'Kwale Hospital', '2021-08-19 10:44:38', '2021-08-19 10:44:38', NULL, 'Active'),
(85, 'E024-01-0833/2022', 'Fatuma Fatima Abdi', 'Female', 'BScCE', 2, '2003-07-28', 'Malindi', '3456 Beach Rd', '0790405112', 'odhiambo.grace22@students.dkut.ac.ke', 'Malindi Clinic', '2022-08-20 10:44:38', '2022-08-20 10:44:38', NULL, 'Active'),
(86, 'E033-01-0846/2022', 'Michael Onyango Otieno', 'Male', 'BEDCE', 2, '2003-05-18', 'Lamu', '6789 Coastline St', '0791346922', 'otieno.michael22@students.dkut.ac.ke', 'Lamu Hospital', '2022-08-21 10:44:38', '2022-08-21 10:44:38', NULL, 'Active'),
(87, 'E022-01-0857/2022', 'Mary Auma Atieno', 'Female', 'BScMECH', 2, '2003-09-15', 'Homabay', '8901 Lakeview St', '0792247383', 'atieno.mary22@students.dkut.ac.ke', 'Homabay Clinic', '2022-08-22 10:44:38', '2022-08-22 10:44:38', NULL, 'Active'),
(88, 'E023-01-0869/2022', 'David Ochieng Onyango', 'Male', 'BScMEC', 2, '2003-06-25', 'Kisii', '0123 Highlands St', '0793734624', 'onyango.david22@students.dkut.ac.ke', 'Kisii Hospital', '2022-08-23 10:44:38', '2022-08-23 10:44:38', NULL, 'Active'),
(89, 'E029-01-0878/2022', 'Jane Anyango Atieno', 'Female', 'BEDMEC', 2, '2003-04-17', 'Mombasa', '2345 Bayview Rd', '0794445725', 'atieno.jane22@students.dkut.ac.ke', 'Mombasa General Hospital', '2022-08-24 10:44:38', '2022-08-24 10:44:38', NULL, 'Active'),
(90, 'E020-01-0766/2022', 'John Were Gichuru', 'Male', 'BScTIE', 2, '2003-01-30', 'Kakamega', '4567 Forest St', '0796152674', 'gichuru.john22@students.dkut.ac.ke', 'Kakamega Hospital', '2022-08-25 10:44:38', '2022-08-25 10:44:38', NULL, 'Active'),
(91, 'E028-01-0776/2022', 'Lucy Akinyi Wanjiru', 'Female', 'BEDEE', 2, '2003-08-05', 'Garissa', '6789 Desert St', '0796502745', 'wanjiru.lucy22@students.dkut.ac.ke', 'Garissa Clinic', '2022-08-26 10:44:38', '2022-08-26 10:44:38', NULL, 'Active'),
(92, 'T056-01-0888/2022', 'James Otieno Were', 'Male', 'BTEBC', 2, '2003-02-14', 'Nanyuki', '8901 Savannah St', '0797365388', 'were.james22@students.dkut.ac.ke', 'Nanyuki Hospital', '2022-08-27 10:44:38', '2022-08-27 10:44:38', NULL, 'Active'),
(93, 'E034-01-0747/2022', 'Rebecca Anyango Akoth', 'Female', 'BScCHEM', 2, '2003-11-06', 'Kwale', '0123 Beachside St', '0798286934', 'akoth.rebecca22@students.dkut.ac.ke', 'Kwale Hospital', '2022-08-28 10:44:38', '2022-08-28 10:44:38', NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `stud_visit`
--

CREATE TABLE `stud_visit` (
  `stud_visitId` int(11) NOT NULL,
  `visitcode` varchar(20) NOT NULL,
  `visitdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `stud_regno` varchar(20) NOT NULL,
  `visit_purpose` varchar(50) NOT NULL,
  `visit_details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `stud_visit`
--

INSERT INTO `stud_visit` (`stud_visitId`, `visitcode`, `visitdate`, `stud_regno`, `visit_purpose`, `visit_details`) VALUES
(1, 'VS001-23/24', '2023-10-24 08:13:45', 'C027-01-0836/2020', 'Counseling', 'Social awkwardness and struggles '),
(2, 'VS002-23/24', '2023-11-15 06:30:00', 'C025-01-0629/2020', 'Counseling', 'Seeking counseling due to past traumatic experiences.'),
(3, 'VS003-23/24', '2023-11-15 07:00:00', 'C027-01-2677/2020', 'Counseling', 'Seeking counseling for mental health concerns.'),
(4, 'VS004-23/24', '2023-11-15 08:30:00', 'B012-01-0001/2021', 'Counseling', 'Seeking counseling for academic challenges.'),
(5, 'VS005-23/24', '2023-11-15 09:00:00', 'B011-01-0832/2022', 'Counseling', 'Seeking counseling for conflict resolution.'),
(6, 'VS006-23/24', '2023-11-15 10:30:00', 'B011-01-0833/2023', 'Counseling', 'Seeking counseling for sexual health concerns.'),
(7, 'VS007-23/24', '2023-11-15 12:00:00', 'B012-01-0836/2023', 'Counseling', 'Seeking counseling for financial stress.'),
(8, 'VS008-23/24', '2023-11-15 13:30:00', 'C027-01-0781/2020', 'Counseling', 'Seeking counseling for substance abuse.'),
(9, 'VS009-23/24', '2023-11-16 11:00:00', 'C027-01-0826/2020', 'Counseling', 'Seeking counseling for social integration.'),
(10, 'VS010-23/24', '2023-11-17 06:30:00', 'C027-01-2556/2020', 'Counseling', 'Seeking counseling for personal development.'),
(11, 'VS011-23/24', '2023-11-18 08:00:00', 'C026-01-0837/2021', 'Counseling', 'Seeking counseling for adjustment to university life.'),
(12, 'VS012-23/24', '2023-11-19 10:30:00', 'C026-01-0839/2023', 'Counseling', 'Seeking counseling for career guidance.'),
(13, 'VS013-23/24', '2023-11-20 12:00:00', 'E021-01-0850/2022', 'Counseling', 'Seeking counseling for career guidance.'),
(14, 'VS014-23/24', '2023-11-20 12:30:00', 'C026-01-0001/2016', 'Signing of Clearance', 'N/A'),
(15, 'VS015-23/24', '2023-11-21 07:00:00', 'C026-01-0005/2016', 'Signing of Clearance', 'N/A'),
(16, 'VS016-23/24', '2023-11-21 08:00:00', 'C025-01-0009/2016', 'Signing of Clearance', 'N/A'),
(17, 'VS017-23/24', '2023-11-22 09:00:00', 'E021-01-0015/2016', 'Signing of Clearance', 'N/A'),
(18, 'VS018-23/24', '2023-11-22 10:00:00', 'C026-01-0002/2017', 'Signing of Clearance', 'N/A'),
(19, 'VS019-23/24', '2023-11-22 11:00:00', 'C025-01-0006/2017', 'Signing of Clearance', 'N/A'),
(20, 'VS020-23/24', '2023-11-23 12:00:00', 'C025-01-0010/2017', 'Signing of Clearance', 'N/A'),
(29, 'VS022-23/24', '2023-11-24 09:48:05', 'BBA-01-0008/2019', 'Counseling', ''),
(30, 'VS023-23/24', '2023-11-24 09:57:32', 'B010-01-1234/2023', 'Counseling', 'Mental Health, we need to dive deeper'),
(31, 'VS024-23/24', '2023-11-24 10:15:32', 'C027-01-0823/2020', 'Counseling', 'Needs help with making the next step as she looks forward to leaving school'),
(32, 'VS025-23/24', '2023-11-24 10:22:42', 'B010-01-0826/2020', 'Excuse', 'She needs to visit a hospital'),
(33, 'VS026-23/24', '2023-11-24 10:36:27', 'C027-01-0760/2020', 'Counseling', 'Example'),
(34, 'VS027-23/24', '2023-11-24 10:37:05', 'C027-01-0781/2020', 'Excuse', 'Exuse 101'),
(35, 'VS028-23/24', '2023-11-24 10:51:22', 'C027-01-0836/2020', 'Counseling', 'Xoxo'),
(36, 'VS029-23/24', '2023-11-24 10:56:10', 'B011-01-0832/2022', 'Counseling', 'sampling'),
(37, 'VS030-23/24', '2023-11-24 11:02:13', 'E021-01-0851/2023', 'Counseling', 'Sampling'),
(38, 'VS031-23/24', '2023-11-24 11:04:16', 'C025-01-0009/2016', 'CoC', 'Clearing'),
(39, 'VS032-23/24', '2023-11-24 11:19:00', 'C025-01-0009/2016', 'Signing of Clearance', 'The student has finished his course work'),
(40, 'VS033-23/24', '2023-11-24 11:20:48', 'C027-01-2556/2020', 'Counseling', 'In of help'),
(41, 'VS034-23/24', '2023-11-24 11:33:16', 'C027-01-0823/2020', 'Counseling', 'sampling'),
(42, 'VS035-23/24', '2023-11-24 12:14:10', 'C027-01-2556/2020', 'Counseling', 'Really needs help'),
(43, 'VS036-23/24', '2023-11-27 05:21:34', 'C027-01-0781/2020', 'Counseling', 'Needs help with making the next step as she looks forward to leaving school'),
(44, 'VS037-23/24', '2023-11-20 07:00:00', 'E024-01-0826/2021', 'Counseling', 'Social confidence and wellness improvement'),
(45, 'VS038-23/24', '2023-11-20 08:30:00', 'E024-01-0827/2021', 'Counseling', 'Emotional well-being and growth'),
(46, 'VS039-23/24', '2023-11-21 06:45:00', 'E024-01-0833/2022', 'Counseling', 'Stress management and resilience development'),
(47, 'VS040-23/24', '2023-11-21 11:00:00', 'E033-01-0826/2020', 'Counseling', 'Academic and personal guidance'),
(48, 'VS041-23/24', '2023-11-22 06:30:00', 'E033-01-0528/2022', 'Counseling', 'Financial wellness and planning'),
(49, 'VS042-23/24', '2023-11-22 08:45:00', 'E022-01-0826/2020', 'Counseling', 'Trauma recovery and support'),
(50, 'VS043-23/24', '2023-11-23 07:15:00', 'E022-01-0946/2021', 'Counseling', 'Health and lifestyle improvement'),
(51, 'VS044-23/24', '2023-11-23 10:00:00', 'E023-01-0826/2020', 'Counseling', 'University life adaptation strategies'),
(52, 'VS045-23/24', '2023-11-23 12:45:00', 'E023-01-0621/2021', 'Counseling', 'Personal growth and development'),
(53, 'VS046-23/24', '2023-12-04 09:30:00', 'E023-01-0920/2021', 'Counseling', 'Substance abuse recovery and support'),
(54, 'VS047-23/24', '2023-11-25 06:00:00', 'E029-01-0826/2020', 'Counseling', 'Family relationship support and improvement'),
(55, 'VS048-23/24', '2023-11-25 07:30:00', 'E029-01-0721/2022', 'Counseling', 'Personal growth and motivation enhancement'),
(56, 'VS049-23/24', '2023-11-25 10:15:00', 'E028-01-0826/2020', 'Counseling', 'Academic performance improvement strategies'),
(57, 'VS050-23/24', '2023-11-25 11:45:00', 'E028-01-0776/2022', 'Counseling', 'Conflict resolution and management techniques'),
(58, 'VS051-23/24', '2023-11-27 13:00:00', 'E028-01-0829/2021', 'Counseling', 'Goal-setting and motivation enhancement'),
(59, 'VS052-23/24', '2023-11-27 14:30:00', 'E033-01-0528/2022', 'Counseling', 'Career development and guidance'),
(60, 'VS053-23/24', '2023-11-29 08:00:00', 'E033-01-2821/2021', 'Counseling', 'Substance abuse recovery and support'),
(61, 'VS054-23/24', '2023-12-01 09:00:00', 'E034-01-0747/2022', 'Counseling', 'Trauma recovery and grief processing'),
(62, 'VS055-23/24', '2023-12-04 11:00:00', 'E020-01-0787/2021', 'Counseling', 'Personal development exploration'),
(63, 'VS056-23/24', '2023-12-04 12:00:00', 'E020-01-0826/2020', 'Counseling', 'Financial stress management and planning'),
(64, 'VS057-23/24', '2023-12-04 13:00:00', 'T056-01-0826/2020', 'Counseling', 'Academic and career guidance'),
(65, 'VS058-23/24', '2024-02-18 16:37:56', 'C027-01-0759/2020', 'Counseling', ''),
(66, 'VS059-23/24', '2024-02-20 14:49:26', 'C025-01-0007/2018', 'Counseling', ''),
(67, 'VS060-23/24', '2024-02-20 15:16:20', 'C027-01-0836/2020', 'Counseling Session', 'Additional details for the counseling session'),
(68, 'VS061-23/24', '2024-03-09 11:14:49', 'T056-01-0888/2022', 'Counseling Session', 'Additional details for the counseling session');

-- --------------------------------------------------------

--
-- Table structure for table `sub_nature_of_case`
--

CREATE TABLE `sub_nature_of_case` (
  `sub_case_id` int(11) NOT NULL,
  `sub_nature` varchar(50) NOT NULL,
  `case_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sub_nature_of_case`
--

INSERT INTO `sub_nature_of_case` (`sub_case_id`, `sub_nature`, `case_id`) VALUES
(1, 'Poor academic performance', 1),
(2, 'Time management and study skills', 1),
(3, 'Test anxiety and exam preparation', 1),
(4, 'Career exploration and decision-making', 2),
(5, 'Resume building and job search strategies', 2),
(6, 'Internship and job placement support', 2),
(7, 'Nutrition and fitness counseling', 3),
(8, 'Sleep hygiene and well-being', 3),
(9, 'Chronic illness management', 3),
(10, 'Self-esteem and self-confidence', 4),
(11, 'Identity exploration', 4),
(12, 'Interpersonal skills and relationship issues', 4),
(13, 'Stress management', 5),
(14, 'Anxiety and depression', 5),
(15, 'Coping with life transitions', 5),
(16, 'Parental expectations and pressure', 6),
(17, 'Family conflicts and dynamics', 6),
(18, 'Adjusting to being away from home', 6),
(19, 'Counseling for substance abuse issues', 7),
(20, 'Education on the risks and consequences of substan', 7),
(21, 'Budgeting and financial planning', 8),
(22, 'Managing student loans', 8),
(23, 'Coping with financial challenges', 8),
(24, 'Making friends and building a social support netwo', 9),
(25, 'Coping with loneliness or isolation', 9),
(26, 'Peer relationship issues', 9),
(27, 'Education on sexual health and relationships', 10),
(28, 'Support for issues related to sexuality', 10),
(29, 'Transitioning to college life', 11),
(30, 'Homesickness and adjustment issues', 11),
(31, 'Balancing academic and social life', 11),
(32, 'Coping with loss or grief', 12),
(33, 'Support for students who have experienced trauma', 12),
(34, 'Mediation for conflicts with roommates or peers', 13),
(35, 'Developing conflict resolution skills', 13),
(36, 'Setting personal and academic goals', 14),
(37, 'Maintaining motivation and focus', 14);

-- --------------------------------------------------------

--
-- Table structure for table `upload`
--

CREATE TABLE `upload` (
  `upload_file_id` int(11) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `upload_user` varchar(20) NOT NULL,
  `upload_filename` varchar(200) NOT NULL,
  `upload_category` varchar(100) NOT NULL,
  `upload_type` varchar(20) NOT NULL,
  `upload_filetype` varchar(100) NOT NULL,
  `upload_filepath` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `upload_category`
--

CREATE TABLE `upload_category` (
  `upload_category_id` int(11) NOT NULL,
  `upload_file_category` varchar(100) NOT NULL,
  `upload_category_stat` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `useroles`
--

CREATE TABLE `useroles` (
  `userole_id` int(11) NOT NULL,
  `userole` varchar(100) NOT NULL,
  `userole_stat` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `useroles`
--

INSERT INTO `useroles` (`userole_id`, `userole`, `userole_stat`) VALUES
(1, 'System Administrator', 'Active'),
(2, 'Counsellor', 'Active'),
(3, 'Peer Counsellor', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `user_fname` varchar(255) NOT NULL,
  `user_lname` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `user_referenced` varchar(20) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `reset_link_token` varchar(255) DEFAULT NULL,
  `exp_date` date DEFAULT NULL,
  `user_role` enum('System Administrator','Guidance Counselor','student','Peer counselor') NOT NULL,
  `user_date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `user_date_mod` datetime NOT NULL DEFAULT current_timestamp(),
  `user_display_stat` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `user_fname`, `user_lname`, `username`, `user_referenced`, `user_email`, `user_password`, `reset_link_token`, `exp_date`, `user_role`, `user_date_add`, `user_date_mod`, `user_display_stat`) VALUES
(1, 'Godfrin', 'Kamau', 'Isayah', '', 'isayaopiyo0@gmail.com', '$2y$10$iiBchRBKX3BSpQ44dkgRReM.xHDqDOSxp19y0.A8y4uJ0.DOMAV7m', '', '0000-00-00', 'Peer counselor', '2023-10-24 10:08:38', '2023-10-24 10:08:38', 'Active'),
(3, 'Janet', 'Atieno', 'Tester00', '', '', 'Bav1er@039', NULL, NULL, 'Peer counselor', '2023-10-24 10:12:41', '2023-10-24 10:12:41', 'Active'),
(4, 'Lucy', 'Mutunga', 'Tester007', '', '', 'Bav1er@039', NULL, NULL, 'Guidance Counselor', '2023-10-24 10:28:09', '2023-10-24 10:28:09', 'Active'),
(5, '', '', 'SysAdmin', '', '', 'Bav1er@039', NULL, NULL, 'System Administrator', '2023-10-24 17:51:26', '2023-10-24 17:51:26', 'Active'),
(6, '', '', 'Shadrack', '', '', 'Testingthething', NULL, NULL, 'Peer counselor', '2023-12-20 11:33:20', '2023-12-20 11:33:20', 'Active'),
(7, 'IVY', 'MBUGUA', 'IvyTest', '', 'nyagithima.ivy21@students.dkut.ac.ke', 'BetaTesting', NULL, NULL, 'Peer counselor', '2024-02-16 08:41:34', '2024-02-16 08:41:34', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `visit`
--

CREATE TABLE `visit` (
  `visitId` int(11) NOT NULL,
  `visit_type` varchar(50) NOT NULL,
  `visit_desc` text DEFAULT NULL,
  `visitype_stat` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `visit`
--

INSERT INTO `visit` (`visitId`, `visit_type`, `visit_desc`, `visitype_stat`) VALUES
(1, 'Signing of Clearance', NULL, 'Active'),
(2, 'Counseling', '', 'Active'),
(3, 'Certificate of Candidacy', NULL, 'Active'),
(4, 'Excuse Letter', NULL, 'Active');

-- --------------------------------------------------------

--
-- Stand-in structure for view `visitrecord`
-- (See below for the actual view)
--
CREATE TABLE `visitrecord` (
`visitcode` varchar(20)
,`visitdate` timestamp
,`stud_regno` varchar(20)
,`student` varchar(100)
,`course` varchar(32)
,`visit_purpose` varchar(50)
,`visit_details` text
);

-- --------------------------------------------------------

--
-- Structure for view `visitrecord`
--
DROP TABLE IF EXISTS `visitrecord`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `visitrecord`  AS SELECT `v`.`visitcode` AS `visitcode`, `v`.`visitdate` AS `visitdate`, `s`.`stud_regNo` AS `stud_regno`, `s`.`stud_fullname` AS `student`, concat(`s`.`stud_course`,' ',`s`.`stud_yrlevel`) AS `course`, `v`.`visit_purpose` AS `visit_purpose`, `v`.`visit_details` AS `visit_details` FROM (`stud_visit` `v` join `stud_profile` `s` on(`s`.`stud_regNo` = `v`.`stud_regno`)) ORDER BY `v`.`visitdate` DESC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active_academic_year`
--
ALTER TABLE `active_academic_year`
  ADD PRIMARY KEY (`yrId`) USING BTREE,
  ADD KEY `FK_acadbatch_yr` (`acadbatch_yr`) USING BTREE;

--
-- Indexes for table `active_semester`
--
ALTER TABLE `active_semester`
  ADD PRIMARY KEY (`sem_id`) USING BTREE,
  ADD KEY `FK_activeSem_sem_name` (`activesem_name`) USING BTREE;

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batch_details`
--
ALTER TABLE `batch_details`
  ADD PRIMARY KEY (`batchId`),
  ADD UNIQUE KEY `unq_Batch_yr` (`batch_yr`);

--
-- Indexes for table `batch_group`
--
ALTER TABLE `batch_group`
  ADD PRIMARY KEY (`batch_id`),
  ADD KEY `batch_approach` (`batch_approach`);

--
-- Indexes for table `counseling`
--
ALTER TABLE `counseling`
  ADD PRIMARY KEY (`couns_Id`),
  ADD UNIQUE KEY `couns_code` (`couns_code`),
  ADD KEY `FK_cnslngvstidrfrnc` (`visitId_Ref`),
  ADD KEY `FK_C_CREFERENCE` (`counseling_type`),
  ADD KEY `FK_cnslngcnsppntmnttyp` (`couns_appmnType`),
  ADD KEY `FK_cnslngntrfcsrfrnc` (`nature_of_case`),
  ADD KEY `FK_cnslngcdmcyrrfrnc` (`couns_acadYr`),
  ADD KEY `FK_cnslngstdnofrnc` (`stud_regNo`),
  ADD KEY `FK_cnslngapprcd` (`apprcode`),
  ADD KEY `FK_cnslngsmstrrfrnc` (`couns_sem`),
  ADD KEY `fk_counselor_id` (`counselor_id`);

--
-- Indexes for table `counseling_group`
--
ALTER TABLE `counseling_group`
  ADD PRIMARY KEY (`grp_counseling_id`),
  ADD KEY `grp_id` (`grp_id`);

--
-- Indexes for table `couns_appointmentype`
--
ALTER TABLE `couns_appointmentype`
  ADD PRIMARY KEY (`appmnid`),
  ADD UNIQUE KEY `appmnType` (`appmntype`);

--
-- Indexes for table `couns_approach`
--
ALTER TABLE `couns_approach`
  ADD PRIMARY KEY (`appr_id`),
  ADD UNIQUE KEY `couns_appr` (`couns_appr`);

--
-- Indexes for table `couns_details`
--
ALTER TABLE `couns_details`
  ADD KEY `FK_CnsIDrfrnc` (`counsId_ref`),
  ADD KEY `FK_cnslngstdnrfrnc` (`stud_regNo`),
  ADD KEY `FK_cnsdtlscnsrmrksrfrnc` (`couns_remarks`);

--
-- Indexes for table `couns_type`
--
ALTER TABLE `couns_type`
  ADD PRIMARY KEY (`couns_type_id`),
  ADD UNIQUE KEY `couns_type` (`couns_type`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD UNIQUE KEY `UNQ_course_code` (`course_code`),
  ADD KEY `FK_course_curyr` (`course_curyr`);

--
-- Indexes for table `marital_stat`
--
ALTER TABLE `marital_stat`
  ADD PRIMARY KEY (`marital_status_id`),
  ADD UNIQUE KEY `marital_status` (`marital_status`);

--
-- Indexes for table `nature_of_case`
--
ALTER TABLE `nature_of_case`
  ADD PRIMARY KEY (`case_id`),
  ADD UNIQUE KEY `case_name` (`case_name`);

--
-- Indexes for table `remarks`
--
ALTER TABLE `remarks`
  ADD PRIMARY KEY (`remarks_id`),
  ADD UNIQUE KEY `remarks_type` (`remarks_type`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`sem_id`),
  ADD UNIQUE KEY `UNQ_sem_name` (`sem_name`);

--
-- Indexes for table `stud_profile`
--
ALTER TABLE `stud_profile`
  ADD PRIMARY KEY (`stud_Id`),
  ADD UNIQUE KEY `PK_studNo` (`stud_regNo`),
  ADD KEY `FK_course` (`stud_course`);

--
-- Indexes for table `stud_visit`
--
ALTER TABLE `stud_visit`
  ADD PRIMARY KEY (`stud_visitId`),
  ADD UNIQUE KEY `visitCode` (`visitcode`),
  ADD KEY `FK_vsSTUD_NO` (`stud_regno`),
  ADD KEY `FK_stdvstprps_vstrfrnc` (`visit_purpose`);

--
-- Indexes for table `sub_nature_of_case`
--
ALTER TABLE `sub_nature_of_case`
  ADD PRIMARY KEY (`sub_case_id`),
  ADD KEY `case_id` (`case_id`);

--
-- Indexes for table `upload`
--
ALTER TABLE `upload`
  ADD PRIMARY KEY (`upload_file_id`),
  ADD KEY `FK_pldctgryrfrnc` (`upload_category`);

--
-- Indexes for table `upload_category`
--
ALTER TABLE `upload_category`
  ADD PRIMARY KEY (`upload_category_id`),
  ADD UNIQUE KEY `upload_file_category` (`upload_file_category`);

--
-- Indexes for table `useroles`
--
ALTER TABLE `useroles`
  ADD PRIMARY KEY (`userole_id`),
  ADD UNIQUE KEY `userole` (`userole`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `UNQ_users_userName` (`username`);

--
-- Indexes for table `visit`
--
ALTER TABLE `visit`
  ADD PRIMARY KEY (`visitId`),
  ADD UNIQUE KEY `visitype` (`visit_type`),
  ADD UNIQUE KEY `visit_type` (`visit_type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `active_academic_year`
--
ALTER TABLE `active_academic_year`
  MODIFY `yrId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `active_semester`
--
ALTER TABLE `active_semester`
  MODIFY `sem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `batch_details`
--
ALTER TABLE `batch_details`
  MODIFY `batchId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `batch_group`
--
ALTER TABLE `batch_group`
  MODIFY `batch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `counseling`
--
ALTER TABLE `counseling`
  MODIFY `couns_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `counseling_group`
--
ALTER TABLE `counseling_group`
  MODIFY `grp_counseling_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `couns_appointmentype`
--
ALTER TABLE `couns_appointmentype`
  MODIFY `appmnid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `couns_approach`
--
ALTER TABLE `couns_approach`
  MODIFY `appr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `couns_type`
--
ALTER TABLE `couns_type`
  MODIFY `couns_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `marital_stat`
--
ALTER TABLE `marital_stat`
  MODIFY `marital_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nature_of_case`
--
ALTER TABLE `nature_of_case`
  MODIFY `case_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `remarks`
--
ALTER TABLE `remarks`
  MODIFY `remarks_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `sem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stud_profile`
--
ALTER TABLE `stud_profile`
  MODIFY `stud_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `stud_visit`
--
ALTER TABLE `stud_visit`
  MODIFY `stud_visitId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `sub_nature_of_case`
--
ALTER TABLE `sub_nature_of_case`
  MODIFY `sub_case_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `upload`
--
ALTER TABLE `upload`
  MODIFY `upload_file_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `upload_category`
--
ALTER TABLE `upload_category`
  MODIFY `upload_category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `useroles`
--
ALTER TABLE `useroles`
  MODIFY `userole_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `visit`
--
ALTER TABLE `visit`
  MODIFY `visitId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `active_academic_year`
--
ALTER TABLE `active_academic_year`
  ADD CONSTRAINT `FK_acadbatch_yr` FOREIGN KEY (`acadbatch_yr`) REFERENCES `batch_details` (`batch_yr`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `active_semester`
--
ALTER TABLE `active_semester`
  ADD CONSTRAINT `FK_activeSem_name` FOREIGN KEY (`activesem_name`) REFERENCES `semester` (`sem_name`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `counseling`
--
ALTER TABLE `counseling`
  ADD CONSTRAINT `FK_cnslngapprcd` FOREIGN KEY (`apprcode`) REFERENCES `couns_approach` (`appr_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cnslngntrfcsrfrnc` FOREIGN KEY (`nature_of_case`) REFERENCES `nature_of_case` (`case_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_counselor_id` FOREIGN KEY (`counselor_id`) REFERENCES `users` (`userId`);

--
-- Constraints for table `counseling_group`
--
ALTER TABLE `counseling_group`
  ADD CONSTRAINT `counseling_group_ibfk_1` FOREIGN KEY (`grp_id`) REFERENCES `batch_group` (`batch_id`);

--
-- Constraints for table `couns_details`
--
ALTER TABLE `couns_details`
  ADD CONSTRAINT `FK_CnsIDrfrnc` FOREIGN KEY (`counsId_ref`) REFERENCES `counseling` (`couns_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cnsdtlscnsrmrksrfrnc` FOREIGN KEY (`couns_remarks`) REFERENCES `remarks` (`remarks_type`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cnslngstdnrfrnc` FOREIGN KEY (`stud_regNo`) REFERENCES `stud_profile` (`stud_regNo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sub_nature_of_case`
--
ALTER TABLE `sub_nature_of_case`
  ADD CONSTRAINT `sub_nature_of_case_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `nature_of_case` (`case_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
