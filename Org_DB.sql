-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 07, 2024 at 06:37 AM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `orgdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` varchar(10) NOT NULL,
  `department_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`) VALUES
('CSC', 'CyberSecurity'),
('ICT', 'Information and Communications Technology'),
('NIS', 'Network Infrastructure'),
('RND', 'Research and Development');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `document_id` int(11) NOT NULL,
  `document_name` varchar(100) NOT NULL,
  `department_id` varchar(10) DEFAULT NULL,
  `confidentiality` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`document_id`, `document_name`, `department_id`, `confidentiality`) VALUES
(1, 'RND Level 1', 'RND', 1),
(2, 'RND Level 2', 'RND', 2),
(3, 'RND Level 3', 'RND', 3),
(4, 'RND Level 4', 'RND', 4),
(5, 'RND Level 5', 'RND', 5),
(6, 'ICT Level 1', 'ICT', 1),
(7, 'ICT Level 2', 'ICT', 2),
(8, 'ICT Level 3', 'ICT', 3),
(9, 'ICT Level 4', 'ICT', 4),
(10, 'ICT Level 5', 'ICT', 5),
(11, 'NIS Level 1', 'NIS', 1),
(12, 'NIS Level 2', 'NIS', 2),
(13, 'NIS Level 3', 'NIS', 3),
(14, 'NIS Level 4', 'NIS', 4),
(15, 'NIS Level 5', 'NIS', 5),
(16, 'CSC Level 1', 'CSC', 1),
(17, 'CSC Level 2', 'CSC', 2),
(18, 'CSC Level 3', 'CSC', 3),
(19, 'CSC Level 4', 'CSC', 4),
(20, 'CSC Level 5', 'CSC', 5),
(21, 'DEMO', 'CSC', 1),
(22, 'DEMO', 'CSC', 2),
(23, 'DEMO', 'CSC', 3),
(24, 'DEMO', 'CSC', 4),
(25, 'DEMO', 'CSC', 5);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `pwd` varchar(100) NOT NULL,
  `department_id` varchar(10) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `email`, `fullname`, `username`, `pwd`, `department_id`, `role_id`) VALUES
(1, 'admin', 'Punnachai Rodkaew', 'admin', '$2y$10$yA.UkJY2rzqBf03fXYY6aOM87I6w481oIbGAxLIyQV8VZeFtQD7SK', NULL, 5),
(2, 'director', 'Jane Smith', 'director', '$2y$10$Q4kYv1qxcVM7NaH453lVcONHd5.tp/yM1nit08euKDsaWd1mie9du', NULL, 4),
(3, 'manager', 'John Brown', 'manager', '$2y$10$Qcm25sHnrFcoWvw0uRSp7OJlkOPy8O9jQRqe0nfgtMaef4b5ZAQ1i', 'RND', 3),
(4, 'nisstaff', 'David Jones', 'nisstaff', '$2y$10$LNQt9vUi2GwiMgyvJDwIVeOAGJUggvn2KrKZsh11iTSxsO0O7dyAm', 'NIS', 2),
(5, 'rndstaff', 'Jonathan Wick', 'rndstaff', '$2y$10$9ikR1sI6asKT9.h1rBwNyehhVN75HeONho0Tz4EX9L2tQ3jbKHdIC', 'RND', 2),
(6, 'reporter', 'Oliver Miller', 'reporter', '$2y$10$ftUvHu0uVdRbr0nRFzROP.fSRNiit7JjHplaYfYvynWpZpUN9gq6i', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `iplog`
--

CREATE TABLE `iplog` (
  `log_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text,
  `category` varchar(10) DEFAULT NULL,
  `filename` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `title`, `description`, `category`, `filename`) VALUES
(1, 'news 1', 'test desc', 'int', 'ONE.pdf'),
(2, 'news 2', 'test desc', 'pub', 'TWO.pdf'),
(3, 'news 3', 'test desc', 'org', 'THREE.pdf'),
(4, 'news 4', 'test desc', 'int', 'FOUR.pdf'),
(5, 'news 5', 'test desc', 'pub', 'FIVE.pdf'),
(6, 'news 6', 'test desc', 'int', 'SIX.pdf'),
(7, 'news 7', 'test desc', 'pub', 'SEVEN.pdf'),
(8, 'news 8', 'test desc', 'org', 'EIGHT.pdf'),
(9, 'news 9', 'test desc', 'int', 'NINE.pdf'),
(10, 'news 10', 'test desc', 'pub', 'TEN.pdf'),
(11, 'news 11', 'test desc', 'int', 'ELEVEN.pdf'),
(12, 'news 12', 'test desc', 'pub', 'TWELVE.pdf'),
(13, 'news 13', 'test desc', 'org', 'THIRTEEN.pdf'),
(14, 'news 14', 'test desc', 'int', 'FOURTEEN.pdf'),
(15, 'news 15', 'test desc', 'pub', 'FIFTEEN.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(5, 'Admin'),
(4, 'Director'),
(3, 'Manager'),
(1, 'Reporter'),
(2, 'Staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`),
  ADD UNIQUE KEY `department_name` (`department_name`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`document_id`),
  ADD KEY `fk_doc_dept` (`department_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_emp_dept` (`department_id`),
  ADD KEY `fk_emp_role` (`role_id`);

--
-- Indexes for table `iplog`
--
ALTER TABLE `iplog`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `fk_log_emp` (`employee_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `iplog`
--
ALTER TABLE `iplog`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `fk_doc_dept` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `fk_emp_dept` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_emp_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `iplog`
--
ALTER TABLE `iplog`
  ADD CONSTRAINT `fk_log_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
