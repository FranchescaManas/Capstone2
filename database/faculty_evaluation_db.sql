-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2023 at 03:02 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `faculty_evaluation_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `admin_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE `form` (
  `form_id` int(11) NOT NULL,
  `form_name` varchar(50) NOT NULL,
  `form_description` varchar(150) NOT NULL,
  `form_type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form`
--

INSERT INTO `form` (`form_id`, `form_name`, `form_description`, `form_type`) VALUES
(1, 'Faculty Evaluation Form', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur sint veniam fuga inventore tempora numquam omnis esse natus cupiditate, id rerum! Vel', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `form_page`
--

CREATE TABLE `form_page` (
  `page_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `page_sequence` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_page`
--

INSERT INTO `form_page` (`page_id`, `form_id`, `page_sequence`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `form_permission`
--

CREATE TABLE `form_permission` (
  `permission_id` int(11) NOT NULL,
  `superadmin_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `can_access` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_question`
--

CREATE TABLE `form_question` (
  `question_id` int(11) NOT NULL,
  `section_id` int(11) DEFAULT NULL,
  `question_text` varchar(150) NOT NULL,
  `question_type` varchar(50) NOT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `question_order` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_question`
--

INSERT INTO `form_question` (`question_id`, `section_id`, `question_text`, `question_type`, `options`, `question_order`, `form_id`, `page_id`) VALUES
(1, 1, 'sample paragraph question', 'paragraph', NULL, 3, 1, 1),
(2, 1, 'Sample question choice', 'choice', '{\"option1\": \"Sample Choice 1\", \"option2\": \"Sample Choice 2\", \"option3\": \"Sample Choice 3\"}', 2, 1, 1),
(3, 1, 'sample date', 'date', NULL, 1, 1, 1),
(4, 2, 'time', 'time', NULL, 4, 1, 1),
(5, 1, 'sample dropdown', 'dropdown', '{\"option1\": \"Sample dropdown 1\", \"option2\": \"Sample dropdown 2\", \"option3\": \"Sample dropdown 3\"}', 5, 1, 1),
(6, 2, 'Sample scale ', 'scale', '{\r\n  \"scale-labels\": {\r\n    \"label1\": \"labeloption1\",\r\n    \"label2\": \"labeloption2\",\r\n    \"label3\": \"labeloption3\",\r\n    \"label4\": \"labeloption4\",\r\n    \"label5\": \"labeloption5\"\r\n  },\r\n  \"scale-statement\": {\r\n    \"statement1\": \"sample statement1\",\r\n    \"statement2\": \"sample statement2\",\r\n    \"sample3\": \"sample statement 3\"\r\n  }\r\n}\r\n', 6, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `form_section`
--

CREATE TABLE `form_section` (
  `section_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `section_name` varchar(50) NOT NULL,
  `section_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_section`
--

INSERT INTO `form_section` (`section_id`, `form_id`, `section_name`, `section_order`) VALUES
(1, 1, 'Sample Section 1', 1),
(2, 1, 'Sample Section 2', 2);

-- --------------------------------------------------------

--
-- Table structure for table `superadmin`
--

CREATE TABLE `superadmin` (
  `superadmin_id` int(11) NOT NULL,
  `firstname` varchar(150) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `superadmin`
--

INSERT INTO `superadmin` (`superadmin_id`, `firstname`, `lastname`, `user_id`) VALUES
(1, 'superadmin', 'test', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `firstname` varchar(150) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `role` varchar(50) NOT NULL,
  `photo` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `firstname`, `lastname`, `email`, `role`, `photo`) VALUES
(1, 'superadmin', '$2y$10$rn7I3MrlMcKmKYDEyfQrbO9yiKCc2bY58x5iLI2OY0pq6uGJvKKYi', 'superadmin', 'test', 'superadmin@test.com', 'superadmin', 0x6e756c6c),
(2, 'admin', '$2y$10$rn7I3MrlMcKmKYDEyfQrbO9yiKCc2bY58x5iLI2OY0pq6uGJvKKYi', 'admin', 'test', 'admin@test.com', 'admin', 0x6e756c6c),
(3, 'faculty', '$2y$10$rn7I3MrlMcKmKYDEyfQrbO9yiKCc2bY58x5iLI2OY0pq6uGJvKKYi', 'faculty', 'test', 'faculty@test.com', 'faculty', 0x6e756c6c),
(4, 'student', '$2y$10$rn7I3MrlMcKmKYDEyfQrbO9yiKCc2bY58x5iLI2OY0pq6uGJvKKYi', 'student', 'test', 'student@test.com', 'student', 0x6e756c6c);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `form`
--
ALTER TABLE `form`
  ADD PRIMARY KEY (`form_id`);

--
-- Indexes for table `form_page`
--
ALTER TABLE `form_page`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `form_permission`
--
ALTER TABLE `form_permission`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `form_question`
--
ALTER TABLE `form_question`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `form_section`
--
ALTER TABLE `form_section`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `superadmin`
--
ALTER TABLE `superadmin`
  ADD PRIMARY KEY (`superadmin_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form`
--
ALTER TABLE `form`
  MODIFY `form_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `form_page`
--
ALTER TABLE `form_page`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `form_permission`
--
ALTER TABLE `form_permission`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_question`
--
ALTER TABLE `form_question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `form_section`
--
ALTER TABLE `form_section`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `superadmin`
--
ALTER TABLE `superadmin`
  MODIFY `superadmin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
