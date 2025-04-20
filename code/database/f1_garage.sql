-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2025 at 09:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `f1_garage`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `assignment_date` date NOT NULL,
  `completion_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `teacher_id`, `member_id`, `assignment_date`, `completion_date`) VALUES
(6, 1, 1, '2025-04-20', NULL),
(7, 6, 8, '2025-04-20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `expertise` varchar(100) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `availability` int(11) NOT NULL DEFAULT 0,
  `category` enum('Driving Skill','Race Strategy','Engineering') DEFAULT 'Engineering'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `expertise`, `code`, `availability`, `category`) VALUES
(1, 'Adrian Newey', 'Aerodynamic Engineering', 'TEACH001', 8, 'Engineering'),
(2, 'James Allison', 'Mechanical Systems', 'TEACH002', 2, 'Driving Skill'),
(3, 'Hannah Schmitz', 'Race Strategy', 'TEACH003', 4, 'Race Strategy'),
(4, 'Andrea Stella', 'Performance Engineering', 'TEACH004', 2, 'Driving Skill'),
(5, 'Peter Bonnington', 'Driver Coaching', 'TEACH005', 5, 'Driving Skill'),
(6, 'Toto', 'Gambling', 'TEACH008', 4, 'Driving Skill');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `role` enum('Driver','Engineer','Mechanic') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `name`, `email`, `phone`, `role`) VALUES
(1, 'Lando Norris', 'lando.norris@mclarenf1.com', '08123456789', 'Driver'),
(2, 'Oscar Piastri', 'oscar.piastri@mclarenf1.com', '08123456790', 'Driver'),
(3, 'Max Verstappen', 'max.verstappen@redbullracing.com', '08123456791', 'Driver'),
(4, 'George Russell', 'george.russell@mercedesamgf1.com', '08123456792', 'Driver'),
(5, 'Charles Leclerc', 'charles.leclerc@ferrari.com', '08123456793', 'Driver'),
(6, 'Kimi Antonelli', 'kimi.antonelli@mercedesamgf1.com', '08123456794', 'Driver'),
(7, 'Lewis Hamilton', 'lewis.hamilton@ferrari.com', '08123456795', 'Driver'),
(8, 'Alexander Albon', 'alex.albon@williamsf1.com', '08123456796', 'Driver'),
(9, 'Esteban Ocon', 'esteban.ocon@haasf1team.com', '08123456797', 'Driver'),
(10, 'Lance Stroll', 'lance.stroll@astonmartinf1.com', '08123456798', 'Driver');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`),
  ADD CONSTRAINT `assignments_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `team_members` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
