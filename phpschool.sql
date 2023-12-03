-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2022 at 01:46 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpschool`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `school_id` bigint(20) NOT NULL DEFAULT 0,
  `f_name` varchar(255) DEFAULT NULL,
  `l_name` varchar(255) DEFAULT NULL,
  `active_status` int(11) NOT NULL DEFAULT 1,
  `password` varchar(500) DEFAULT NULL,
  `about` varchar(1000) DEFAULT NULL,
  `profile` varchar(300) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `birthday` varchar(255) DEFAULT NULL,
  `gender` varchar(40) DEFAULT NULL,
  `last_session_id` varchar(200) DEFAULT NULL,
  `last_log_in` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `school_id`, `f_name`, `l_name`, `active_status`, `password`, `about`, `profile`, `address`, `birthday`, `gender`, `last_session_id`, `last_log_in`) VALUES
(102, 101, 'Sheryll', 'Duque', 1, '$2y$10$CXpnjO/YyuuhXwxNfUAiIekNDq3NKtAl0bCrjgvP0Ydikuagzuvj.', 'ADMINS 2022', '../Admin_module/profile_pics/admin_profile_b44500bc381e23deb061fc1aecd665c1c7ca2e011275ce90e81b16cd3f3881aa.png', 'Tarlac', 'October 31, 1962', 'Female', '2022-01-29 10:18:02', '2022-01-29 10:19:38'),
(182, 102, 'Adryn Paul', 'Galleon', 1, '$2y$10$CXpnjO/YyuuhXwxNfUAiIekNDq3NKtAl0bCrjgvP0Ydikuagzuvj.', 'ADMIN', NULL, NULL, NULL, NULL, NULL, '2021-12-11 16:42:49');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notification`
--

CREATE TABLE `admin_notification` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'unread',
  `date_given` datetime DEFAULT NULL,
  `type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_notification`
--

INSERT INTO `admin_notification` (`id`, `admin_id`, `status`, `date_given`, `type`) VALUES
(264, 102, 'unread', '2022-01-15 21:40:48', 4),
(265, 102, 'unread', '2022-01-29 10:20:49', 1),
(267, 102, 'unread', '2022-01-29 10:22:21', 2),
(268, 102, 'unread', '2022-01-29 10:23:52', 3),
(273, 182, 'unread', '2022-01-15 21:40:48', 4),
(274, 182, 'unread', '2022-01-29 10:20:49', 1),
(275, 182, 'unread', '2022-01-29 10:22:21', 2),
(276, 182, 'unread', '2022-01-29 10:23:52', 3);

-- --------------------------------------------------------

--
-- Table structure for table `advisory`
--

CREATE TABLE `advisory` (
  `id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `advisory`
--

INSERT INTO `advisory` (`id`, `class_id`, `teacher_id`) VALUES
(1, 70, 0),
(2, 77, 0),
(3, 92, 0),
(4, 75, 0),
(5, 83, 0),
(6, 85, 0),
(7, 76, 0),
(8, 80, 0),
(9, 82, 0),
(10, 78, 0),
(11, 79, 0),
(12, 84, 0);

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcement_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `texts` varchar(5000) DEFAULT NULL,
  `upload` datetime NOT NULL,
  `deadline` datetime NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announcement_id`, `title`, `texts`, `upload`, `deadline`, `admin_id`) VALUES
(12, 'Hello Students!!!', 'Hello Students! We are here to announce our most anticipated event, which is the Tango! Celebrate with us at Palm Plaza, 4:30pm. Mabuhay!', '2021-10-16 22:12:35', '2021-10-30 22:12:00', 102),
(13, 'tyrty', 'rtyrt', '2021-10-25 21:01:10', '2021-10-25 23:00:00', 102),
(15, 'CONVENTION', 'We want to invite everyone to watch our students and their performances on Dec 20 2021', '2021-10-31 17:24:29', '2022-12-20 23:00:00', 102);

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL,
  `section_code` varchar(255) NOT NULL,
  `class_name` varchar(100) DEFAULT NULL,
  `grade` int(11) NOT NULL DEFAULT 0,
  `ste` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `section_code`, `class_name`, `grade`, `ste`) VALUES
(1, 'GRADE 11', 'GRADE 11', 100, 0),
(70, 'STE', 'STE 7', 7, 1),
(75, 'STE', 'STE 8', 8, 1),
(76, 'STE', 'STE 9', 9, 1),
(77, 'LEOS', 'LEOS 7', 7, 0),
(78, 'STE', 'STE 10', 10, 1),
(79, 'DIAMOND', 'DIAMOND 10', 10, 0),
(80, 'GOLD', 'GOLD 9', 9, 0),
(82, 'PLATINUM', 'PLATINUM 9', 9, 0),
(83, 'LOVE', 'LOVE 8', 8, 0),
(84, 'RUBY', 'RUBY 10', 10, 0),
(85, 'FAITH', 'FAITH 8', 8, 0),
(92, 'SAMPGUITA            ', 'SAMPGUITA 7', 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `exam_id` int(11) NOT NULL,
  `teacher_class_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `exam_title` varchar(300) DEFAULT NULL,
  `exam_description` varchar(3000) DEFAULT NULL,
  `upload_date` varchar(200) DEFAULT NULL,
  `deadline_date` datetime DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `published` int(11) NOT NULL COMMENT ' 1 = yes, 0 = no',
  `max_attempt` int(100) DEFAULT NULL,
  `timer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `exam_question`
--

CREATE TABLE `exam_question` (
  `exam_question_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `exam_question_txt` varchar(3000) NOT NULL,
  `exam_type_id` int(11) NOT NULL,
  `date_added` varchar(100) DEFAULT NULL,
  `date_edited` varchar(100) DEFAULT NULL,
  `answer_1` varchar(200) DEFAULT NULL,
  `answer_a_2` varchar(200) DEFAULT NULL,
  `answer_b_3` varchar(200) DEFAULT NULL,
  `answer_c_4` varchar(200) DEFAULT NULL,
  `answer_d_5` varchar(200) DEFAULT NULL,
  `points_1` int(11) DEFAULT NULL,
  `points_2` int(11) DEFAULT NULL,
  `points_3` int(11) DEFAULT NULL,
  `points_4` int(11) DEFAULT NULL,
  `points_5` int(11) DEFAULT NULL,
  `enum_sum` int(11) DEFAULT NULL,
  `case_sensitive` varchar(50) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `exam_type`
--

CREATE TABLE `exam_type` (
  `exam_type_id` int(11) NOT NULL,
  `type_title` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exam_type`
--

INSERT INTO `exam_type` (`exam_type_id`, `type_title`) VALUES
(1, 'True or False'),
(2, 'Multiple Choice'),
(3, 'Enumeration'),
(4, 'Identification'),
(5, 'Essay');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `file_id` int(11) NOT NULL,
  `file_loc` varchar(500) NOT NULL,
  `file_date` varchar(100) NOT NULL,
  `teacher_class_id` int(100) NOT NULL,
  `class_id` int(100) NOT NULL,
  `teacher_id` int(100) NOT NULL,
  `file_name` varchar(300) DEFAULT NULL,
  `uploaded_by` varchar(100) DEFAULT NULL,
  `file_desc` varchar(3000) DEFAULT NULL,
  `downloads` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `grading`
--

CREATE TABLE `grading` (
  `id` int(11) NOT NULL,
  `quarter` varchar(100) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'locked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grading`
--

INSERT INTO `grading` (`id`, `quarter`, `status`) VALUES
(1, 'First', 'unlocked'),
(2, 'Second', 'unlocked'),
(3, 'Third', 'unlocked'),
(4, 'Fourth', 'unlocked');

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `parent_id` int(11) NOT NULL,
  `f_name` varchar(255) DEFAULT NULL,
  `l_name` varchar(255) DEFAULT NULL,
  `password` varchar(500) DEFAULT NULL,
  `about` varchar(1000) DEFAULT NULL,
  `profile` varchar(300) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `birthday` varchar(255) DEFAULT NULL,
  `gender` varchar(40) DEFAULT NULL,
  `religion` varchar(200) DEFAULT NULL,
  `last_session_id` varchar(200) DEFAULT NULL,
  `last_log_in` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `parent_student`
--

CREATE TABLE `parent_student` (
  `parent_student_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `quiz_id` int(11) NOT NULL,
  `teacher_class_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `quiz_title` varchar(300) DEFAULT NULL,
  `quiz_description` varchar(1600) DEFAULT NULL,
  `upload_date` varchar(100) DEFAULT NULL,
  `deadline_date` datetime DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `max_attempt` int(11) DEFAULT NULL,
  `published` int(11) NOT NULL COMMENT '1 = yes 0 = no',
  `timer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_question`
--

CREATE TABLE `quiz_question` (
  `quiz_question_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `quiz_question_txt` varchar(1000) NOT NULL,
  `quiz_type_id` int(11) NOT NULL,
  `date_added` varchar(100) DEFAULT NULL,
  `date_edited` varchar(100) DEFAULT NULL,
  `answer_1` varchar(200) NOT NULL,
  `answer_a_2` varchar(200) DEFAULT NULL,
  `answer_b_3` varchar(200) DEFAULT NULL,
  `answer_c_4` varchar(200) DEFAULT NULL,
  `answer_d_5` varchar(200) DEFAULT NULL,
  `points_1` int(11) NOT NULL,
  `points_2` int(11) DEFAULT NULL,
  `points_3` int(11) DEFAULT NULL,
  `points_4` int(11) DEFAULT NULL,
  `points_5` int(11) DEFAULT NULL,
  `enum_sum` int(11) DEFAULT NULL,
  `case_sensitive` varchar(50) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_type`
--

CREATE TABLE `quiz_type` (
  `quiz_type_id` int(11) NOT NULL,
  `type_title` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_type`
--

INSERT INTO `quiz_type` (`quiz_type_id`, `type_title`) VALUES
(1, 'True or False'),
(2, 'Multiple Choice'),
(3, 'Enumeration'),
(4, 'Identification');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `school_id` bigint(20) NOT NULL DEFAULT 0,
  `active_status` int(11) NOT NULL DEFAULT 1 COMMENT '0 = inactive, 1 = active',
  `dropped` int(11) NOT NULL DEFAULT 1 COMMENT 'dropped = 0 else = 1',
  `transferred` int(11) NOT NULL DEFAULT 1 COMMENT 'transferred = 0 else = 1',
  `repeater` int(11) NOT NULL DEFAULT 0,
  `date_promoted` varchar(200) DEFAULT NULL,
  `f_name` varchar(100) DEFAULT NULL,
  `l_name` varchar(100) DEFAULT NULL,
  `class_id` int(100) DEFAULT NULL,
  `seven` int(11) NOT NULL DEFAULT 0,
  `eight` int(11) NOT NULL DEFAULT 0,
  `nine` int(11) NOT NULL DEFAULT 0,
  `ten` int(11) NOT NULL DEFAULT 0,
  `previous_ste` int(11) NOT NULL DEFAULT 0,
  `password` varchar(400) NOT NULL,
  `about` varchar(500) DEFAULT NULL,
  `profile` varchar(300) DEFAULT NULL,
  `adress` varchar(500) NOT NULL,
  `birthday` varchar(100) NOT NULL,
  `gender` varchar(40) NOT NULL,
  `last_session_id` varchar(200) DEFAULT NULL,
  `last_log_in` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student_assignment`
--

CREATE TABLE `student_assignment` (
  `student_assignment_id` int(11) NOT NULL,
  `teacher_assignment_id` int(11) DEFAULT NULL,
  `teacher_class_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `max_attempt` int(11) DEFAULT NULL,
  `used_attempt` int(11) NOT NULL,
  `deadline_date` varchar(100) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `submit_date` datetime DEFAULT NULL,
  `assignment_title` varchar(300) DEFAULT NULL,
  `assignment_description` varchar(3000) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `max_score` int(11) NOT NULL DEFAULT 1,
  `submission_text` varchar(5000) DEFAULT NULL,
  `submission_file` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student_exam`
--

CREATE TABLE `student_exam` (
  `student_exam_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `teacher_class_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `max_attempt` int(11) NOT NULL,
  `used_attempt` int(11) NOT NULL,
  `deadline_date` datetime DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `start_time` varchar(100) DEFAULT NULL,
  `submit_date` varchar(100) DEFAULT NULL,
  `exam_title` varchar(300) NOT NULL,
  `exam_description` varchar(3000) NOT NULL,
  `published` int(11) NOT NULL,
  `timer` int(11) NOT NULL,
  `question_score` int(11) NOT NULL,
  `essay_score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student_exam_answer`
--

CREATE TABLE `student_exam_answer` (
  `answer_id` int(11) NOT NULL,
  `exam_question_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `exam_type_id` int(11) DEFAULT NULL,
  `answer_1` varchar(200) DEFAULT NULL,
  `answer_a_2` varchar(200) DEFAULT NULL,
  `answer_b_3` varchar(200) DEFAULT NULL,
  `answer_c_4` varchar(200) DEFAULT NULL,
  `answer_d_5` varchar(200) DEFAULT NULL,
  `points_1` int(11) DEFAULT NULL,
  `points_2` int(11) DEFAULT NULL,
  `points_3` int(11) DEFAULT NULL,
  `points_4` int(11) DEFAULT NULL,
  `points_5` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `essay_score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student_notification`
--

CREATE TABLE `student_notification` (
  `id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `teacher_class_id` int(11) DEFAULT NULL,
  `admin_id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'unread',
  `date_given` datetime DEFAULT NULL,
  `published` int(11) NOT NULL DEFAULT 1,
  `type` varchar(100) DEFAULT NULL,
  `module_id` int(11) NOT NULL DEFAULT 0,
  `exam_id` int(11) NOT NULL DEFAULT 0,
  `quiz_id` int(11) NOT NULL DEFAULT 0,
  `assignment_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student_quiz`
--

CREATE TABLE `student_quiz` (
  `student_quiz_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `teacher_class_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `max_attempt` int(11) NOT NULL,
  `used_attempt` int(11) NOT NULL,
  `deadline_date` datetime NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `start_time` varchar(100) DEFAULT NULL,
  `submit_date` varchar(100) DEFAULT NULL,
  `quiz_title` varchar(300) DEFAULT NULL,
  `quiz_description` varchar(3000) DEFAULT NULL,
  `published` int(11) NOT NULL,
  `timer` int(11) NOT NULL,
  `total_score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student_quiz_answer`
--

CREATE TABLE `student_quiz_answer` (
  `answer_id` int(11) NOT NULL,
  `quiz_question_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `quiz_type_id` int(11) DEFAULT NULL,
  `answer_1` varchar(200) DEFAULT NULL,
  `answer_a_2` varchar(200) DEFAULT NULL,
  `answer_b_3` varchar(200) DEFAULT NULL,
  `answer_c_4` varchar(200) DEFAULT NULL,
  `answer_d_5` varchar(200) DEFAULT NULL,
  `points_1` int(11) DEFAULT NULL,
  `points_2` int(11) DEFAULT NULL,
  `points_3` int(11) DEFAULT NULL,
  `points_4` int(11) DEFAULT NULL,
  `points_5` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `stu_grade`
--

CREATE TABLE `stu_grade` (
  `stu_grade_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `teacher_class_id` int(11) DEFAULT NULL,
  `subject_id` int(11) NOT NULL,
  `first` float NOT NULL,
  `second` float NOT NULL,
  `third` float NOT NULL,
  `fourth` float NOT NULL,
  `final` float NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject_code` varchar(300) DEFAULT NULL,
  `subject_title` varchar(300) DEFAULT NULL,
  `grade` int(11) NOT NULL DEFAULT 0,
  `ste` int(11) NOT NULL DEFAULT 0,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_title`, `grade`, `ste`, `year`) VALUES
(174, 'RESEARCH-1', 'RESEARCH-1 9', 9, 1, 0),
(175, 'ICT', 'ICT 8', 8, 1, 0),
(176, 'MATH', 'MATH 9', 9, 0, 0),
(178, 'MATH', 'MATH 7', 7, 0, 0),
(180, 'RESEARCH-2', 'RESEARCH-2 10', 10, 1, 0),
(181, 'ENGLISH', 'ENGLISH 10', 10, 0, 0),
(188, 'ICT', 'ICT 7', 7, 1, 0),
(189, 'FILIPINO', 'FILIPINO 8', 8, 0, 0),
(195, 'FILIPINO', 'FILIPINO 7', 7, 0, 0),
(196, 'MATH', 'MATH 8', 8, 0, 0),
(197, 'FILIPINO', 'FILIPINO 9', 9, 0, 0),
(198, 'MATH', 'MATH 10', 10, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `school_id` bigint(20) NOT NULL DEFAULT 0,
  `f_name` varchar(100) DEFAULT NULL,
  `l_name` varchar(100) DEFAULT NULL,
  `active_status` int(11) NOT NULL DEFAULT 1,
  `password` varchar(500) DEFAULT NULL,
  `about` varchar(1000) DEFAULT NULL,
  `profile` varchar(300) DEFAULT NULL,
  `t_adress` varchar(500) NOT NULL,
  `birthday` varchar(100) NOT NULL,
  `gender` varchar(40) NOT NULL,
  `last_session_id` varchar(200) DEFAULT NULL,
  `last_log_in` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_assignments`
--

CREATE TABLE `teacher_assignments` (
  `teacher_assignment_id` int(11) NOT NULL,
  `teacher_class_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `ass_loc` varchar(500) DEFAULT NULL,
  `ass_desc` varchar(3000) DEFAULT NULL,
  `ass_title` varchar(300) DEFAULT NULL,
  `upload_date` varchar(100) DEFAULT NULL,
  `deadline_date` datetime DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `sub_attempt` int(11) DEFAULT NULL,
  `published` int(11) NOT NULL DEFAULT 0 COMMENT '1 = yes 0 = no',
  `max_score` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_class`
--

CREATE TABLE `teacher_class` (
  `teacher_class_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher_class`
--

INSERT INTO `teacher_class` (`teacher_class_id`, `teacher_id`, `class_id`, `subject_id`) VALUES
(305, 0, 70, 178),
(306, 0, 70, 188),
(307, 0, 75, 175),
(308, 0, 75, 189),
(309, 0, 76, 174),
(310, 0, 76, 176),
(311, 0, 78, 180),
(312, 0, 78, 181),
(313, 0, 92, 178),
(314, 0, 70, 195),
(315, 0, 75, 196),
(316, 0, 76, 197),
(317, 0, 78, 198),
(318, 0, 83, 189),
(319, 0, 83, 196),
(320, 0, 80, 176),
(321, 0, 80, 197);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_notification`
--

CREATE TABLE `teacher_notification` (
  `id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `teacher_class_id` int(11) DEFAULT NULL,
  `admin_id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'unread',
  `date_given` datetime DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `exam_id` int(11) NOT NULL DEFAULT 0,
  `quiz_id` int(11) NOT NULL DEFAULT 0,
  `assignment_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `school_id` (`school_id`);

--
-- Indexes for table `admin_notification`
--
ALTER TABLE `admin_notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `advisory`
--
ALTER TABLE `advisory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`exam_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `exam_ibfk_1` (`teacher_class_id`);

--
-- Indexes for table `exam_question`
--
ALTER TABLE `exam_question`
  ADD PRIMARY KEY (`exam_question_id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `exam_type`
--
ALTER TABLE `exam_type`
  ADD PRIMARY KEY (`exam_type_id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`file_id`),
  ADD UNIQUE KEY `file_loc` (`file_loc`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `grading`
--
ALTER TABLE `grading`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`parent_id`);

--
-- Indexes for table `parent_student`
--
ALTER TABLE `parent_student`
  ADD PRIMARY KEY (`parent_student_id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quiz_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `quiz_ibfk_1` (`teacher_class_id`);

--
-- Indexes for table `quiz_question`
--
ALTER TABLE `quiz_question`
  ADD PRIMARY KEY (`quiz_question_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quiz_type`
--
ALTER TABLE `quiz_type`
  ADD PRIMARY KEY (`quiz_type_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `school_id` (`school_id`);

--
-- Indexes for table `student_assignment`
--
ALTER TABLE `student_assignment`
  ADD PRIMARY KEY (`student_assignment_id`),
  ADD KEY `teacher_assignment_id` (`teacher_assignment_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `student_exam`
--
ALTER TABLE `student_exam`
  ADD PRIMARY KEY (`student_exam_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `student_exam_answer`
--
ALTER TABLE `student_exam_answer`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `exam_question_id` (`exam_question_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `student_notification`
--
ALTER TABLE `student_notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `student_quiz`
--
ALTER TABLE `student_quiz`
  ADD PRIMARY KEY (`student_quiz_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `student_quiz_answer`
--
ALTER TABLE `student_quiz_answer`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `quiz_question_id` (`quiz_question_id`),
  ADD KEY `student_quiz_answer_ibfk_1` (`student_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `stu_grade`
--
ALTER TABLE `stu_grade`
  ADD PRIMARY KEY (`stu_grade_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD UNIQUE KEY `school_id` (`school_id`);

--
-- Indexes for table `teacher_assignments`
--
ALTER TABLE `teacher_assignments`
  ADD PRIMARY KEY (`teacher_assignment_id`),
  ADD UNIQUE KEY `ass_loc` (`ass_loc`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `teacher_assignments_ibfk_1` (`teacher_class_id`);

--
-- Indexes for table `teacher_class`
--
ALTER TABLE `teacher_class`
  ADD PRIMARY KEY (`teacher_class_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `teacher_class_ibfk_1` (`class_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `teacher_notification`
--
ALTER TABLE `teacher_notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT for table `admin_notification`
--
ALTER TABLE `admin_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=277;

--
-- AUTO_INCREMENT for table `advisory`
--
ALTER TABLE `advisory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `exam_question`
--
ALTER TABLE `exam_question`
  MODIFY `exam_question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=295;

--
-- AUTO_INCREMENT for table `exam_type`
--
ALTER TABLE `exam_type`
  MODIFY `exam_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=350;

--
-- AUTO_INCREMENT for table `grading`
--
ALTER TABLE `grading`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `parent_student`
--
ALTER TABLE `parent_student`
  MODIFY `parent_student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=409;

--
-- AUTO_INCREMENT for table `quiz_question`
--
ALTER TABLE `quiz_question`
  MODIFY `quiz_question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=422;

--
-- AUTO_INCREMENT for table `quiz_type`
--
ALTER TABLE `quiz_type`
  MODIFY `quiz_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=308;

--
-- AUTO_INCREMENT for table `student_assignment`
--
ALTER TABLE `student_assignment`
  MODIFY `student_assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `student_exam`
--
ALTER TABLE `student_exam`
  MODIFY `student_exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `student_exam_answer`
--
ALTER TABLE `student_exam_answer`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `student_notification`
--
ALTER TABLE `student_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=677;

--
-- AUTO_INCREMENT for table `student_quiz`
--
ALTER TABLE `student_quiz`
  MODIFY `student_quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `student_quiz_answer`
--
ALTER TABLE `student_quiz_answer`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `stu_grade`
--
ALTER TABLE `stu_grade`
  MODIFY `stu_grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=955;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1314;

--
-- AUTO_INCREMENT for table `teacher_assignments`
--
ALTER TABLE `teacher_assignments`
  MODIFY `teacher_assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;

--
-- AUTO_INCREMENT for table `teacher_class`
--
ALTER TABLE `teacher_class`
  MODIFY `teacher_class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=322;

--
-- AUTO_INCREMENT for table `teacher_notification`
--
ALTER TABLE `teacher_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=442;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_notification`
--
ALTER TABLE `admin_notification`
  ADD CONSTRAINT `admin_notification_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam`
--
ALTER TABLE `exam`
  ADD CONSTRAINT `exam_ibfk_1` FOREIGN KEY (`teacher_class_id`) REFERENCES `teacher_class` (`teacher_class_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam_question`
--
ALTER TABLE `exam_question`
  ADD CONSTRAINT `exam_question_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parent_student`
--
ALTER TABLE `parent_student`
  ADD CONSTRAINT `parent_student_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`parent_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `parent_student_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`teacher_class_id`) REFERENCES `teacher_class` (`teacher_class_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quiz_question`
--
ALTER TABLE `quiz_question`
  ADD CONSTRAINT `quiz_question_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_exam`
--
ALTER TABLE `student_exam`
  ADD CONSTRAINT `student_exam_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_exam_answer`
--
ALTER TABLE `student_exam_answer`
  ADD CONSTRAINT `student_exam_answer_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_notification`
--
ALTER TABLE `student_notification`
  ADD CONSTRAINT `student_notification_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_quiz`
--
ALTER TABLE `student_quiz`
  ADD CONSTRAINT `student_quiz_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_quiz_answer`
--
ALTER TABLE `student_quiz_answer`
  ADD CONSTRAINT `student_quiz_answer_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teacher_assignments`
--
ALTER TABLE `teacher_assignments`
  ADD CONSTRAINT `teacher_assignments_ibfk_1` FOREIGN KEY (`teacher_class_id`) REFERENCES `teacher_class` (`teacher_class_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teacher_notification`
--
ALTER TABLE `teacher_notification`
  ADD CONSTRAINT `teacher_notification_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
