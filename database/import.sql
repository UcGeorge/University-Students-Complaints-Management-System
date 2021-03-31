-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2021 at 10:00 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

GRANT ALL PRIVILEGES ON *.* TO `cms_admin`@`localhost` IDENTIFIED BY PASSWORD '*CBF32DF521F22EBA706151F2FB62CF88CCE6AECC' WITH GRANT OPTION;

GRANT ALL PRIVILEGES ON `cms`.* TO `cms_admin`@`localhost`;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

DROP TABLE IF EXISTS `faculty`;
CREATE TABLE `faculty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`name`) VALUES
('General'),
('Science');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
CREATE TABLE `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `faculty` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `study_years` int(11),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`faculty`) REFERENCES `faculty`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`faculty`, `name`, `study_years`) VALUES
(1, 'General', NULL),
(2, 'Computer Science', 5);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE `course` (
  `course_code` varchar(50) NOT NULL,
  `department` int(11) NOT NULL,
  `course_title` varchar(50) NOT NULL,
  `year` int(11),
  PRIMARY KEY (`course_code`),
  FOREIGN KEY (`department`) REFERENCES `department`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_code`, `department`, `course_title`, `year`) VALUES
('GEN000', 1, 'General', NULL),
('CSC422', 2, 'Data Communications', 4);

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

DROP TABLE IF EXISTS `lecturer`;
CREATE TABLE `lecturer` (
  `lec_no` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `department` int(11) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`lec_no`),
  FOREIGN KEY (`department`) REFERENCES `department`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lecturer`
--

INSERT INTO `lecturer` (`lec_no`, `name`, `department`, `password`) VALUES
('000000000', 'Admin', 1, 'Admin@123'),
('100805513', 'Ebunoluwa Philip Fashina', 2, 'Test@123');

-- --------------------------------------------------------

--
-- Table structure for table `lecturer-course`
--

DROP TABLE IF EXISTS `lecturer-course`;
CREATE TABLE `lecturer-course` (
  `lecturer` varchar(50) NOT NULL,
  `course` varchar(50) NOT NULL,
  FOREIGN KEY (`lecturer`) REFERENCES `lecturer`(`lec_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`course`) REFERENCES `course`(`course_code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lecturer-course`
--

INSERT INTO `lecturer-course` (`lecturer`, `course`) VALUES
('000000000', 'GEN000'),
('100805513', 'CSC422');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `mat_no` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `department` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`mat_no`),
  FOREIGN KEY (`department`) REFERENCES `department`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`mat_no`, `name`, `department`, `year`, `password`) VALUES
('170805513', 'Uche-Umeh George Uche', 2, 4, 'Test@123'),
('170805500', 'Alfred Lee', 2, 4, 'Test@123'),
('170805501', 'Logan Blue', 2, 4, 'Test@123'),
('170805502', 'Collin Grey', 2, 4, 'Test@123'),
('170805503', 'Jason Durell', 2, 4, 'Test@123'),
('170805504', 'Blue Rose', 2, 4, 'Test@123');

-- --------------------------------------------------------

--
-- Table structure for table `student-course`
--

DROP TABLE IF EXISTS `student-course`;
CREATE TABLE `student-course` (
  `student` varchar(50) NOT NULL,
  `course` varchar(50) NOT NULL,
  FOREIGN KEY (`student`) REFERENCES `student`(`mat_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`course`) REFERENCES `course`(`course_code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student-course`
--

INSERT INTO `student-course` (`student`, `course`) VALUES
('170805513', 'CSC422'),
('170805513', 'GEN000'),
('170805500', 'CSC422'),
('170805500', 'GEN000'),
('170805501', 'CSC422'),
('170805501', 'GEN000'),
('170805502', 'CSC422'),
('170805502', 'GEN000'),
('170805503', 'CSC422'),
('170805503', 'GEN000'),
('170805504', 'CSC422'),
('170805504', 'GEN000');

-- --------------------------------------------------------

--
-- Table structure for table `complaint`
--

DROP TABLE IF EXISTS `complaint`;
CREATE TABLE `complaint` (
  `id` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `status` enum('open', 'close') DEFAULT 'open',
  `title` varchar(50) NOT NULL,
  `description` longtext,
  `dateadded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`author`) REFERENCES `student`(`mat_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`category`) REFERENCES `course`(`course_code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `complaint`
--

INSERT INTO `complaint` (`id`, `author`, `category`, `title`, `description`) VALUES
('#00001', '170805513', 'CSC422', 'Test complaint 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
('#00002', '170805500', 'CSC422', 'Test complaint 2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
('#00003', '170805501', 'CSC422', 'Test complaint 3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
('#00004', '170805502', 'CSC422', 'Test complaint 4', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
('#00005', '170805503', 'CSC422', 'Test complaint 5', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
('#00006', '170805513', 'GEN000', 'General test complaint 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`category`) REFERENCES `course`(`course_code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`name`, `category`) VALUES
('comprehension', 'CSC422'),
('lecturer', 'CSC422'),
('continous assessment', 'CSC422'),
('registration', 'CSC422'),
('exam', 'CSC422'),
('project', 'CSC422'),
('general test tag 1', 'GEN000'),
('general test tag 2', 'GEN000'),
('general test tag 3', 'GEN000'),
('general test tag 4', 'GEN000');

-- --------------------------------------------------------

--
-- Table structure for table `tag-complaint`
--

DROP TABLE IF EXISTS `tag-complaint`;
CREATE TABLE `tag-complaint` (
  `tag` int(11) NOT NULL,
  `complaint` varchar(50) NOT NULL,
  FOREIGN KEY (`tag`) REFERENCES `tag`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`complaint`) REFERENCES `complaint`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tag-complaint`
--

INSERT INTO `tag-complaint` (`tag`, `complaint`) VALUES
(1, '#00001'),
(2, '#00001'),
(4, '#00001'),
(6, '#00001'),
(1, '#00002'),
(5, '#00002'),
(6, '#00002'),
(3, '#00003'),
(4, '#00003'),
(2, '#00004'),
(3, '#00004'),
(5, '#00004'),
(6, '#00004'),
(1, '#00005'),
(3, '#00005'),
(5, '#00005'),
(6, '#00005'),
(7, '#00006'),
(8, '#00006'),
(9, '#00006'),
(10, '#00006');

-- --------------------------------------------------------

--
-- Table structure for table `student-complaint`
--

DROP TABLE IF EXISTS `student-complaint`;
CREATE TABLE `student-complaint` (
  `student` varchar(50) NOT NULL,
  `complaint` varchar(50) NOT NULL,
  FOREIGN KEY (`student`) REFERENCES `student`(`mat_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`complaint`) REFERENCES `complaint`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student-complaint`
--

INSERT INTO `student-complaint` (`student`, `complaint`) VALUES
('170805500', '#00001'),
('170805501', '#00001'),
('170805502', '#00001'),
('170805504', '#00001'),
('170805513', '#00002'),
('170805501', '#00002'),
('170805503', '#00002'),
('170805513', '#00003'),
('170805502', '#00003'),
('170805513', '#00004'),
('170805500', '#00004'),
('170805502', '#00004'),
('170805504', '#00004'),
('170805513', '#00005'),
('170805500', '#00005'),
('170805503', '#00005'),
('170805504', '#00005'),
('170805501', '#00006'),
('170805503', '#00006'),
('170805504', '#00006'),
('170805502', '#00006');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author-s` varchar(50),
  `author-r` varchar(50),
  `complaint` varchar(50) NOT NULL,
  `text` longtext,
  `dateadded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`author-s`) REFERENCES `student`(`mat_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`author-r`) REFERENCES `lecturer`(`lec_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`complaint`) REFERENCES `complaint`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
