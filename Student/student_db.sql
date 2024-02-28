-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 28, 2024 at 07:51 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `course_ID` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_name` varchar(30) NOT NULL,
  `course_description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `course_hours` smallint UNSIGNED NOT NULL,
  PRIMARY KEY (`course_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_ID`, `course_name`, `course_description`, `course_hours`) VALUES
(1, 'php', 'good', 20),
(2, 'php', 'php fundamentals', 20),
(3, 'C#', 'C# fundamentals', 50),
(4, 'C++', 'C++ fundamentals', 20),
(5, 'C', 'C fundamentals', 40),
(6, 'Java', 'intro to java course', 12);

-- --------------------------------------------------------

--
-- Table structure for table `courses_session`
--

DROP TABLE IF EXISTS `courses_session`;
CREATE TABLE IF NOT EXISTS `courses_session` (
  `session_ID` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_ID` smallint UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY (`session_ID`),
  KEY `session_course_id_fk` (`course_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `courses_session`
--

INSERT INTO `courses_session` (`session_ID`, `course_ID`, `start_date`, `end_date`) VALUES
(1, 3, '2024-02-24', '2024-02-25'),
(2, 1, '2024-02-23', '2024-02-24'),
(3, 1, '2024-02-24', '2024-02-26'),
(4, 4, '2024-02-23', '2024-02-24'),
(5, 5, '2024-02-24', '2024-02-25'),
(8, 3, '2024-02-29', '2024-03-07');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `employee_ID` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `gender` char(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `address` varchar(150) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `birthdate` date NOT NULL,
  `photo` varchar(10000) NOT NULL,
  `role` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`employee_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_ID`, `first_name`, `last_name`, `gender`, `address`, `phone`, `birthdate`, `photo`, `role`, `username`, `password`) VALUES
(2, 'Abdullah', 'Alaswani', 'Male', 'Sana\'a Taiz roundabout', '773992604', '2003-10-20', '', 'Admin', 'admin', 'admin'),
(3, 'Abdullah', 'Alaswani', 'Male', 'yemen', '0773992604', '2024-02-15', '', 'Admin', 'admin', '000'),
(4, 'ali', 'ali', 'Male', 'sana\'a', '773992604', '2001-02-15', '', 'Admin', 'a', '000'),
(5, 'Ali', 'ahmed', 'Male', 'yemen', '0773992604', '2000-11-12', '', 'Admin', 'ali', '123'),
(6, 'sara', 'ahmed', 'Female', ' yemen  ', '0773992604', '2000-06-17', '', 'Registration', 'ali11', '000'),
(10, 'Abdullah', 'Alaswani', 'Male', 'yemen', '0773992604', '1999-12-27', '', 'Admin', 'ali', '000'),
(11, 'Abdullah', 'Alaswani', 'Male', 'yemen', '0773992604', '1999-12-27', '', 'Admin', 'ali', '000'),
(12, 'Abdullah', 'Alaswani', 'Male', ' yemen  ', '0773992604', '2000-01-20', '', 'Admin', 'admin', '000'),
(13, 'Abdullah', 'Alaswani', 'Male', ' yemen  ', '0773992604', '2000-01-20', '', 'Admin', 'admin', '111'),
(14, 'Abdullah', 'Alaswani', 'Male', 'yemen', '0773992604', '2000-01-20', '', 'Admin', 'admin', '222'),
(15, 'Abdullah', 'Alaswani', 'Male', 'yemen', '0773992604', '2000-01-20', '', 'Admin', 'admin', '222'),
(16, 'sara', 'ahmed', 'Male', 'yemen', '0773992604', '2000-01-20', '', 'Controller', 'admin', '000'),
(17, 'sara', 'ahmed', 'Male', 'yemen', '0773992604', '2000-01-20', '', 'Controller', 'admin', '000'),
(18, 'sara', 'ahmed', 'Female', 'yemen', '0773992604', '2000-05-14', '', 'Controller', 'ali', '000'),
(19, 'sara', 'ahmed', 'Female', 'yemen', '0773992604', '2000-05-14', '', 'Controller', 'ali', '000'),
(20, 'sara', 'ahmed', 'Female', 'yemen', '0773992604', '2000-01-20', '', 'Controller', 'ali', '000'),
(21, 'sara', 'ahmed', 'Female', 'yemen', '0773992604', '2000-01-20', '', 'Controller', 'ali', '000'),
(22, 'sara', 'ahmed', 'Female', 'yemen', '0773992604', '2000-01-20', '', 'Controller', 'ali', '000'),
(23, 'sara', 'ahmed', 'Female', 'yemen', '0773992604', '2000-01-20', '', 'Controller', 'ali', '000'),
(24, 'sara', 'ahmed', 'Male', 'yemen', '0773992604', '2000-06-06', '', 'Controller', 'ali', '000'),
(25, 'Abdullah', 'Alaswani', 'Male', 'yemen', '0773992604', '2001-09-20', '', 'Controller', 'admin', '000'),
(26, 'Abdullah', 'Alaswani', 'Male', 'yemen', '0773992604', '2000-06-13', '', 'Registration', 'admin', '111'),
(27, 'Abdullah', 'Alaswani', 'Male', 'yemen', '0773992604', '1999-12-26', '', 'Registration', 'admin', '000'),
(28, 'Abdullah', 'Alaswani', 'Male', 'yemen', '0773992604', '2001-10-16', '', 'Registration', 'admin', '000'),
(29, 'Abdullah', 'Alaswani', 'Male', 'yemen', '0773992604', '2000-05-08', '', 'Admin', 'admin', '111'),
(30, 'Abdullah', 'Alaswani', 'Male', 'yemen', '0773992604', '2000-06-06', '', 'Registration', 'admin', '000'),
(31, 'ali', 'ali', 'Male', 'yemen', '773992604', '2000-02-20', '', 'Registration', 'admin', '000'),
(32, 'ali', 'ali', 'Male', 'yemen', '773992604', '2000-02-20', '', 'Registration', 'admin', '000'),
(33, 'Ahmed', 'Ali', 'Male', ' yemen 1 ', '0773992604', '2000-06-06', '', 'Controller', 'asa', '000'),
(34, 'ahmed', 'salah', 'Male', 'yemen', '0773109020', '2000-06-06', '', 'Registration', 'aaa', '111'),
(35, 'Abdullah', 'Alaswani', 'Male', 'yemen', '0773992604', '2001-06-12', '', 'Admin', 'dula', '202cb962ac59075b964b07152d234b70'),
(36, 'Abdullah', 'Alaswani', 'Male', 'yemen', '0773992604', '2001-06-13', '', 'Admin', 'mula', '1552c03e78d38d5005d4ce7b8018addf');

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

DROP TABLE IF EXISTS `marks`;
CREATE TABLE IF NOT EXISTS `marks` (
  `mark_ID` mediumint UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_ID` smallint UNSIGNED NOT NULL,
  `course_ID` smallint UNSIGNED NOT NULL,
  `mark` tinyint NOT NULL,
  `description` varchar(50) NOT NULL,
  PRIMARY KEY (`mark_ID`),
  KEY `student_id_fk` (`student_ID`),
  KEY `course_id_fk` (`course_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`mark_ID`, `student_ID`, `course_ID`, `mark`, `description`) VALUES
(1, 32, 4, 70, 'good'),
(2, 32, 3, 80, 'nice');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question` varbinary(200) NOT NULL,
  `answer` varbinary(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `answer`) VALUES
(1, 0xd53c0f389b969ea199eba4bab894f9e328b246001994a3d6bc758db4acfcb5d3, 0x634a9e480585b5ff29e06f6530f91207),
(2, 0xb5353a572db69d27d7de14b7fe1c14676f4157f174290c4209c027596b7eda79, 0xb8601701c3728600dd3a6dc7fecc1ce6),
(3, 0x2f6bedf8dd21cd3cf81b6c996834d62d8ac3af3b1f2001c29bb74d5341e31149, 0xabba7436ed5ef0ec1b72d81b61470785),
(4, 0x5bbbb6536c73b2024213d7ed8feff709d96543da4136468117517c37e1c5bc3d, 0xb2254e32caf74cc9eaeb667c8d5198c4);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `student_ID` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` char(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `phone` varchar(15) NOT NULL,
  `parentNumber` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `address` varchar(150) NOT NULL,
  `photo` varchar(1000) NOT NULL,
  PRIMARY KEY (`student_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_ID`, `first_name`, `last_name`, `birthdate`, `gender`, `phone`, `parentNumber`, `address`, `photo`) VALUES
(1, 'Abdullah', 'Alaswani', '2002-10-20', 'Ma', '0773992604', '735378545', 'yemen', ''),
(2, 'Abdullah', 'Alaswani', '2002-10-20', 'Male', '0773992604', '735378545', 'yemen', ''),
(3, 'Abdullah', 'Alaswani', '2009-05-20', 'Male', '0773992604', '775998545', 'yemen', ''),
(4, 'Abdullah', 'Alaswani', '2009-05-20', 'Male', '0773992604', '775998545', 'yemen', ''),
(5, 'Abdullah', 'Alaswani', '2009-05-20', 'Male', '0773992604', '775998545', 'yemen', ''),
(6, 'Abdullah', 'Alaswani', '2009-05-20', 'Male', '0773992604', '775998545', 'yemen', ''),
(7, 'Abdullah', 'Alaswani', '2010-02-20', 'Male', '0773992604', '775998545', 'yemen', ''),
(8, 'Abdullah', 'Alaswani', '2010-02-20', 'Male', '0773992604', '775998545', 'yemen', ''),
(9, 'Abdullah1', 'Alaswani', '2005-09-20', 'Male', '773992604', '7775998545', 'yemen', ''),
(10, 'Abdullah', 'Alaswani', '2008-08-10', 'Male', '773992604', '7775998545', 'yemen', ''),
(11, 'ali', 'ali', '2004-01-27', 'Male', '773992604', '775998545', 'Yemen', ''),
(12, 'ali', 'ahmed', '2004-02-21', 'Male', '773992604', '775998545', 'Yemen', ''),
(13, 'ali', 'ahmed', '2004-02-21', 'Male', '773992604', '775998545', 'Yemen', ''),
(14, 'sara', 'ali', '2008-02-21', 'Female', '773992604', '775998545', 'Taiz', ''),
(15, 'Ahmed', 'Ali', '2004-10-12', 'Male', '773109020', '7775998545', 'yemen', ''),
(16, 'Ahmed', 'Ali', '2006-10-24', 'Male', '0773992604', '7775998545', 'yemen', ''),
(17, 'Abdullah', 'Alaswani', '2004-01-05', 'Male', '0773992604', '7775998545', 'yemen', ''),
(18, 'Abdullah', 'Alaswani', '2004-01-05', 'Male', '0773992604', '7775998545', 'yemen', ''),
(19, 'Abdullah', 'Alaswani', '2004-01-05', 'Male', '0773992604', '7775998545', 'yemen', ''),
(20, 'Abdullah', 'Alaswani', '2004-05-04', 'Male', '0773992604', '7775998545', 'yemen', ''),
(21, 'Abdullah', 'Alaswani', '2003-06-10', 'Male', '0773992604', '7775998545', 'yemen', ''),
(22, 'Abdullah', 'Alaswani', '2003-11-12', 'Male', '0773992604', '7775998545', 'yemen', ''),
(23, 'Abdullah', 'Alaswani', '2003-05-13', 'Male', '0773992604', '7775998545', 'yemen', ''),
(24, 'Abdullah', 'Alaswani', '2003-05-13', 'Male', '0773992604', '7775998545', 'yemen', ''),
(25, 'Abdullah', 'Alaswani', '2003-05-13', 'Male', '0773992604', '7775998545', 'yemen', ''),
(26, 'Abdullah', 'Alaswani', '2003-05-13', 'Male', '0773992604', '7775998545', 'yemen', ''),
(27, 'Abdullah', 'Alaswani', '2005-06-27', 'Male', '0773992604', '7775998545', 'yemen', ''),
(28, 'Abdullah', 'Alaswani', '2005-06-07', 'Male', '0773992604', '7775998545', 'yemen', ''),
(29, 'Abdullah', 'Alaswani', '2007-06-12', 'Male', '0773992604', '7775998545', 'yemen', ''),
(30, 'Abdullah', 'Alaswani', '2002-10-27', 'Male', '0773992604', '7775998545', 'yemen', ''),
(31, 'Abdullah', 'Alaswani', '2004-06-08', 'Male', '0773992604', '7775998545', 'yemen', ''),
(32, 'Ahmed', 'Salah', '2003-06-17', 'Male', '773109020', '7775998545', 'yemen', '');

-- --------------------------------------------------------

--
-- Table structure for table `student_course_association`
--

DROP TABLE IF EXISTS `student_course_association`;
CREATE TABLE IF NOT EXISTS `student_course_association` (
  `student_association_ID` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_ID` smallint UNSIGNED NOT NULL,
  `session_ID` smallint UNSIGNED NOT NULL,
  `course_ID` smallint UNSIGNED NOT NULL,
  PRIMARY KEY (`student_association_ID`),
  KEY `association_student_id_fk` (`student_ID`),
  KEY `association_session_id_fk` (`session_ID`),
  KEY `association_course_id` (`course_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student_course_association`
--

INSERT INTO `student_course_association` (`student_association_ID`, `student_ID`, `session_ID`, `course_ID`) VALUES
(1, 14, 4, 4),
(2, 10, 1, 3),
(3, 5, 8, 3),
(4, 32, 4, 4),
(5, 16, 4, 4),
(6, 32, 1, 3);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses_session`
--
ALTER TABLE `courses_session`
  ADD CONSTRAINT `courses_session_ibfk_1` FOREIGN KEY (`course_ID`) REFERENCES `courses` (`course_ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `marks`
--
ALTER TABLE `marks`
  ADD CONSTRAINT `marks_ibfk_1` FOREIGN KEY (`course_ID`) REFERENCES `courses` (`course_ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `marks_ibfk_2` FOREIGN KEY (`student_ID`) REFERENCES `students` (`student_ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `student_course_association`
--
ALTER TABLE `student_course_association`
  ADD CONSTRAINT `student_course_association_ibfk_1` FOREIGN KEY (`session_ID`) REFERENCES `courses_session` (`session_ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `student_course_association_ibfk_2` FOREIGN KEY (`student_ID`) REFERENCES `students` (`student_ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `student_course_association_ibfk_3` FOREIGN KEY (`course_ID`) REFERENCES `courses` (`course_ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
