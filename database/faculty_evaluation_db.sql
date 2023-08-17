-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2023 at 08:11 AM
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
  `admin_level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `user_id`, `admin_level`) VALUES
(1, 2, 'Dean'),
(2, 6, 'Chair');

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
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `user_id` int(11) NOT NULL,
  `faculty_id` int(50) NOT NULL,
  `firstname` varchar(150) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`user_id`, `faculty_id`, `firstname`, `lastname`, `data`) VALUES
(0, 1, 'John', 'Doe', '{\"courses\": [\n    {\n      \"course_code\": \"MATH101\",\n      \"course_name\": \"Introduction to Mathematics\",\n\"program\": \"BSIT\",\n\"year_level\": \"4\",\n\"section\":\"BSIT4A\",\n      \"schedule\": [\n        {\n          \"day\": \"Monday\",\n          \"time\": \"10:00 AM - 11:30 AM\"\n        },\n        {\n          \"day\": \"Wednesday\",\n          \"time\": \"10:00 AM - 11:30 AM\"\n        }\n      ]\n    }\n  ]\n}'),
(0, 5, 'Jane', 'Smith', '{\"courses\":[\r\n    {\r\n      \"course_code\": \"PHYS201\",\r\n      \"course_name\": \"Physics Fundamentals\",\r\n      \"program\": \"BSIT\",\r\n      \"year_level\": \"4\",\r\n      \"section\": \"BSIT4A\",\r\n      \"schedule\": [\r\n        {\r\n          \"day\": \"Tuesday\",\r\n          \"time\": \"9:00 AM - 10:30 AM\"\r\n        },\r\n        {\r\n          \"day\": \"Thursday\",\r\n          \"time\": \"9:00 AM - 10:30 AM\"\r\n        }\r\n      ]\r\n    }\r\n  ]\r\n}'),
(0, 6, 'David', 'Smith', '{\"courses\":[\r\n    {\r\n      \"course_code\": \"CS200\",\r\n      \"course_name\": \"Introduction to Programming\",\r\n      \"program\": \"BSIT\",\r\n      \"year_level\": \"4\",\r\n      \"section\": \"BSIT4A\",\r\n      \"schedule\": [\r\n        {\r\n          \"day\": \"Monday\",\r\n          \"time\": \"2:00 PM - 3:30 PM\"\r\n        },\r\n        {\r\n          \"day\": \"Wednesday\",\r\n          \"time\": \"2:00 PM - 3:30 PM\"\r\n        }\r\n      ]\r\n    }\r\n  ]\r\n}'),
(0, 7, 'Emily', 'White', '{\"courses\":[\r\n    {\r\n      \"course_code\": \"ART110\",\r\n      \"course_name\": \"Introduction to Art\",\r\n      \"program\": \"BSIT\",\r\n      \"year_level\": \"4\",\r\n      \"section\": \"BSIT4A\",\r\n      \"schedule\": [\r\n        {\r\n          \"day\": \"Tuesday\",\r\n          \"time\": \"3:00 PM - 4:30 PM\"\r\n        },\r\n        {\r\n          \"day\": \"Thursday\",\r\n          \"time\": \"3:00 PM - 4:30 PM\"\r\n        }\r\n      ]\r\n    }\r\n  ]\r\n}');

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
(1, 'Faculty Evaluation Form', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur sint veniam fuga inventore tempora numquam omnis esse natus cupiditate, id rerum! Vel', NULL),
(2, 'Observation Sheet', 'observation sheet sample text observation sheet sample text observation sheet sample text observation sheet sample text observation sheet sample text ', NULL);

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
  `user_id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  `form_id` int(11) NOT NULL,
  `can_access` tinyint(1) NOT NULL,
  `can_modify` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_permission`
--

INSERT INTO `form_permission` (`permission_id`, `user_id`, `role`, `form_id`, `can_access`, `can_modify`) VALUES
(1, 0, 'student', 1, 1, 0),
(2, 0, 'students', 2, 1, 0),
(3, 0, 'faculty', 1, 1, 0),
(4, 0, 'admin', 1, 1, 0),
(5, 6, 'admin', 1, 1, 1);

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
(6, 2, 'Sample scale ', 'scale', '{\n  \"scale-labels\": {\n    \"label1\": \"labeloption1\",\n    \"label2\": \"labeloption2\",\n    \"label3\": \"labeloption3\",\n    \"label4\": \"labeloption4\",\n    \"label5\": \"labeloption5\"\n  },\n  \"scale-statement\": {\n    \"statement1\": \"sample statement1\",\n    \"statement2\": \"sample statement2\",\n    \"sample3\": \"sample statement 3\"\n  }\n}\n', 6, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `form_response`
--

CREATE TABLE `form_response` (
  `response_id` int(11) NOT NULL,
  `form_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `response_value` varchar(255) DEFAULT NULL,
  `response_type` enum('text','choice','date') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_response`
--

INSERT INTO `form_response` (`response_id`, `form_id`, `user_id`, `section_id`, `question_id`, `response_value`, `response_type`) VALUES
(157, 1, 1, 1, 3, '2023-08-25', 'date'),
(158, 1, 1, 1, 2, 'Sample Choice 2', 'choice'),
(159, 1, 1, 1, 1, 'fadfa', ''),
(160, 1, 1, 1, 5, 'Sample dropdown 2', ''),
(161, 1, 1, 2, 4, '01:08', ''),
(162, 1, 1, 2, 6, '{\"sample statement1\":\"labeloption1\",\"sample statement2\":\"labeloption1\",\"sample statement 3\":\"labeloption1\"}', '');

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
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(50) NOT NULL,
  `firstname` varchar(150) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `year_level` int(11) NOT NULL,
  `course` varchar(150) NOT NULL,
  `section` varchar(50) NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `firstname`, `lastname`, `year_level`, `course`, `section`, `data`, `user_id`) VALUES
(2018200836, 'Gabriel', 'Gepte', 4, 'BSIT', 'BSIT4A', '{\n  \"courses\": [\n    {\n      \"course_code\": \"MATH101\",\n      \"course_name\": \"Introduction to Mathematics\",\n      \"professor\": \"John Doe\",\n      \"schedule\": [\n        {\n          \"day\": \"Monday\",\n          \"time\": \"10:00 AM - 11:30 AM\"\n        },\n        {\n          \"day\": \"Wednesday\",\n          \"time\": \"10:00 AM - 11:30 AM\"\n        }\n      ]\n    },\n    {\n      \"course_code\": \"PHYS201\",\n      \"course_name\": \"Physics Fundamentals\",\n      \"professor\": \"Jane Smith\",\n      \"schedule\": [\n        {\n          \"day\": \"Tuesday\",\n          \"time\": \"9:00 AM - 10:30 AM\"\n        },\n        {\n          \"day\": \"Thursday\",\n          \"time\": \"9:00 AM - 10:30 AM\"\n        }\n      ]\n    },\n{\n      \"course_code\": \"CS200\",\n      \"course_name\": \"Introduction to Programming\",\n      \"professor\": \"David Smith\",\n      \"schedule\": [\n        {\n          \"day\": \"Monday\",\n          \"time\": \"2:00 PM - 3:30 PM\"\n        },\n        {\n          \"day\": \"Wednesday\",\n          \"time\": \"2:00 PM - 3:30 PM\"\n        }\n      ]\n    },\n    {\n      \"course_code\": \"ART110\",\n      \"course_name\": \"Introduction to Art\",\n      \"professor\": \"Emily White\",\n      \"schedule\": [\n        {\n          \"day\": \"Tuesday\",\n          \"time\": \"3:00 PM - 4:30 PM\"\n        },\n        {\n          \"day\": \"Thursday\",\n          \"time\": \"3:00 PM - 4:30 PM\"\n        }\n      ]\n    }\n  ]\n}', 4);

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
(4, 'student', '$2y$10$rn7I3MrlMcKmKYDEyfQrbO9yiKCc2bY58x5iLI2OY0pq6uGJvKKYi', 'student', 'test', 'student@test.com', 'student', 0x6e756c6c),
(5, 'jane', '$2y$10$rn7I3MrlMcKmKYDEyfQrbO9yiKCc2bY58x5iLI2OY0pq6uGJvKKYi', 'Jane', 'Smith', 'janesmith@sample.com', 'faculty', NULL),
(6, 'david', '$2y$10$rn7I3MrlMcKmKYDEyfQrbO9yiKCc2bY58x5iLI2OY0pq6uGJvKKYi', 'david', 'smith', 'davidsmith@sample.com', 'faculty', NULL),
(7, 'emily', '$2y$10$rn7I3MrlMcKmKYDEyfQrbO9yiKCc2bY58x5iLI2OY0pq6uGJvKKYi', 'emily', 'white', 'emilywhite@sample.com', 'faculty', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`);

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
-- Indexes for table `form_response`
--
ALTER TABLE `form_response`
  ADD PRIMARY KEY (`response_id`);

--
-- Indexes for table `form_section`
--
ALTER TABLE `form_section`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `form`
--
ALTER TABLE `form`
  MODIFY `form_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `form_page`
--
ALTER TABLE `form_page`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `form_permission`
--
ALTER TABLE `form_permission`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `form_question`
--
ALTER TABLE `form_question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `form_response`
--
ALTER TABLE `form_response`
  MODIFY `response_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `form_section`
--
ALTER TABLE `form_section`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2018200837;

--
-- AUTO_INCREMENT for table `superadmin`
--
ALTER TABLE `superadmin`
  MODIFY `superadmin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
