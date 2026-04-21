-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2026 at 05:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sd`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('admin', 'admin123'),
('admin', 'admin123'),
('admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `section_management`
--

CREATE TABLE `section_management` (
  `section_id` int(11) NOT NULL,
  `course_name` varchar(50) DEFAULT NULL,
  `section_name` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section_management`
--

INSERT INTO `section_management` (`section_id`, `course_name`, `section_name`) VALUES
(25, 'BCA', 'A'),
(26, 'BCA', 'B'),
(27, 'BCA', 'C'),
(32, 'BCA', 'D');

-- --------------------------------------------------------

--
-- Table structure for table `semester_management`
--

CREATE TABLE `semester_management` (
  `semester_id` int(11) NOT NULL,
  `semester_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semester_management`
--

INSERT INTO `semester_management` (`semester_id`, `semester_name`) VALUES
(38, '3'),
(39, '5'),
(48, '1');

-- --------------------------------------------------------

--
-- Table structure for table `staff_management`
--

CREATE TABLE `staff_management` (
  `staff_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date_of_joining` date NOT NULL,
  `department` varchar(100) NOT NULL,
  `email_id` varchar(150) NOT NULL,
  `contact_number` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_management`
--

INSERT INTO `staff_management` (`staff_id`, `name`, `date_of_joining`, `department`, `email_id`, `contact_number`) VALUES
(11, 'vidya', '2025-11-18', 'BCA', 'v@gmail.com', '11223344566'),
(12, 'inchara', '2026-04-15', 'BSc', 'ssssssssssss@aaaa', '2345678901'),
(13, 'shreeya', '2026-03-13', 'BCA', 'shree@gmail.com', '11223344566');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `course` varchar(50) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `subject_name` varchar(100) DEFAULT NULL,
  `subject_code` varchar(50) DEFAULT NULL,
  `hours_per_week` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `course`, `semester`, `subject_name`, `subject_code`, `hours_per_week`) VALUES
(37, 'BCA', 1, 'maths', '101', 4),
(38, 'BCA', 1, 'cs', '102', 5),
(39, 'BCA', 3, 'history', '103', 5);

-- --------------------------------------------------------

--
-- Table structure for table `subject_allocation`
--

CREATE TABLE `subject_allocation` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `section_name` varchar(50) DEFAULT NULL,
  `allocated_hours` int(11) DEFAULT NULL,
  `semester` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject_allocation`
--

INSERT INTO `subject_allocation` (`id`, `staff_id`, `subject_id`, `section_name`, `allocated_hours`, `semester`) VALUES
(45, 13, 37, 'A', 3, '1'),
(46, 12, 37, 'A', 1, '1'),
(50, 11, 37, 'D', 4, '3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `section_management`
--
ALTER TABLE `section_management`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `semester_management`
--
ALTER TABLE `semester_management`
  ADD PRIMARY KEY (`semester_id`);

--
-- Indexes for table `staff_management`
--
ALTER TABLE `staff_management`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `email_id` (`email_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_allocation`
--
ALTER TABLE `subject_allocation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `section_management`
--
ALTER TABLE `section_management`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `semester_management`
--
ALTER TABLE `semester_management`
  MODIFY `semester_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `staff_management`
--
ALTER TABLE `staff_management`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `subject_allocation`
--
ALTER TABLE `subject_allocation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subject_allocation`
--
ALTER TABLE `subject_allocation`
  ADD CONSTRAINT `subject_allocation_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff_management` (`staff_id`),
  ADD CONSTRAINT `subject_allocation_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
