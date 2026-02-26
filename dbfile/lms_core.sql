-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2026 at 10:18 AM
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
-- Database: `lms_core`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `whatsapp_number` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin') DEFAULT 'admin',
  `is_super` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `whatsapp_number`, `username`, `password`, `role`, `is_super`, `created_at`) VALUES
(6, 'Super Admin', 'admin@lmscore.com', '0123456789', 'admin', '$2y$10$odgDoaI9huqX8jl75T0agO9ibGF523pHvJ.NdgoRRPfbn3HICXUaC', 'admin', 0, '2026-02-17 15:44:22'),
(7, 'piyumak', 'admin@gmail.com', '0705765890', 'admin123', '$2y$10$7q5ukVI2AMS0joF2JzsOD.iKPgAuVZ8m1Gl/LUhhj7qhiTHIWcVN2', 'admin', 0, '2026-02-26 08:55:30');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `image`, `title`, `subtitle`, `display_order`, `created_at`) VALUES
(11, 'uploads/banners/banner_69972d72898443.47019461.jpg', NULL, NULL, 2, '2026-02-19 15:34:10'),
(12, 'uploads/banners/banner_69972d8d7ab997.64875764.jpg', NULL, NULL, 1, '2026-02-19 15:34:37');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `class_title` varchar(150) NOT NULL,
  `short_description` varchar(255) NOT NULL,
  `full_description` text NOT NULL,
  `instructor` varchar(100) NOT NULL,
  `duration` varchar(50) NOT NULL,
  `location` varchar(150) NOT NULL,
  `class_date` date NOT NULL,
  `class_time` time NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_title` varchar(150) NOT NULL,
  `instructor` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `duration` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `video_zip` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_title`, `instructor`, `description`, `duration`, `price`, `image`, `video_zip`, `created_at`) VALUES
(3, 'physic', 'Kumar', 'This the physics class for grade 10', '5 hourse', 10000.00, 'uploads/course_images/img_69957891dfc5e4.72572388.jpg', '[\"uploads\\/course_videos\\/vid_699619b122c819.96355494.zip\"]', '2026-02-18 08:30:09'),
(4, 'ssss', 'ssssss', 'sssssssssssssssssss', '5 hourse', 2000.00, 'uploads/course_images/img_699728818d04e0.73533258.jpg', '[\"uploads\\/course_videos\\/vid_69970ff2aa7374.36820903_0.zip\",\"uploads\\/course_videos\\/vid_69970ff2acc3d0.34550840_1.zip\",\"uploads\\/course_videos\\/vid_69970ff2ad7213.07703749_2.zip\"]', '2026-02-19 13:28:18'),
(6, 'Physics', 'piyumal', 'this is also need', '15 min', 15000.00, 'uploads/course_images/img_699fe6ab0aabc8.33648661.jpeg', '[{\"path\":\"uploads\\/course_videos\\/vid_699fe6ab0b4ac3.40767244_0.zip\",\"name\":\"Video 1.zip\"}]', '2026-02-26 06:22:35');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `payment_receipt` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `user_id`, `course_id`, `phone`, `payment_receipt`, `status`, `created_at`) VALUES
(3, 5, 3, '0705765890', 'uploads/receipts/receipt_5_3_1771404142.pdf', 'approved', '2026-02-18 08:42:22'),
(4, 6, 3, '0705765890', 'uploads/receipts/receipt_6_3_1771445048.png', 'approved', '2026-02-18 20:04:08'),
(5, 6, 4, '0705765890', 'uploads/receipts/receipt_6_4_1771507809.jpg', 'approved', '2026-02-19 13:30:09'),
(6, 2, 4, '0705765890', 'uploads/receipts/receipt_2_4_1771515094.jpg', 'approved', '2026-02-19 15:31:34'),
(8, 7, 6, '0705765890', 'uploads/receipts/receipt_7_6_1772086980.jpeg', 'approved', '2026-02-26 06:23:00');

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE `timetable` (
  `id` int(11) NOT NULL,
  `class_title` varchar(150) NOT NULL,
  `short_description` varchar(255) NOT NULL,
  `full_description` text NOT NULL,
  `instructor` varchar(150) NOT NULL,
  `location` varchar(150) NOT NULL,
  `day_name` varchar(20) NOT NULL,
  `class_time` time NOT NULL,
  `duration` varchar(50) NOT NULL,
  `class_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timetable`
--

INSERT INTO `timetable` (`id`, `class_title`, `short_description`, `full_description`, `instructor`, `location`, `day_name`, `class_time`, `duration`, `class_image`, `created_at`) VALUES
(7, 'Grade 10 Ol', 'aaaaaaaa', 'aaaaaaaaaaaaaaa', 'aaaaaaaaaaa', 'kandy', 'Saturday', '20:25:00', '5 hourse', 'uploads/timetable/699729e3c4ff1.jpg', '2026-02-19 15:18:59'),
(8, 'Grade 10 Ol', 'aaaaaaaa', 'aaaaaaaaaaaaaaa', 'aaaaaaaaaaa', 'jaffna', 'Thursday', '08:48:00', '5 hourse', 'uploads/timetable/699729e3c4ff1.jpg', '2026-02-19 15:18:59'),
(9, 'aaaaaaaa', 'aaaaaaaaaaaa', 'aaaaaaaaaaaaaaaa', 'aaaaaaaaaaaa', 'kandy', 'Saturday', '21:02:00', '2a', 'uploads/timetable/69972d47c3de9.jpg', '2026-02-19 15:33:27'),
(10, 'aaaaaaaa', 'aaaaaaaaaaaa', 'aaaaaaaaaaaaaaaa', 'aaaaaaaaaaaa', 'Matale', 'Thursday', '23:03:00', '2a', 'uploads/timetable/69972d47c3de9.jpg', '2026-02-19 15:33:27'),
(11, 'aaaaaaaa', 'aaaaaaaaaaaa', 'aaaaaaaaaaaaaaaa', 'aaaaaaaaaaaa', 'zzzzzzzzzzzz', 'Thursday', '12:03:00', '2a', 'uploads/timetable/69972d47c3de9.jpg', '2026-02-19 15:33:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `whatsapp_number` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin') DEFAULT 'student',
  `is_super` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `whatsapp_number`, `username`, `password`, `role`, `is_super`, `created_at`) VALUES
(2, 'Piyumal Shalinda Bandaranayake', 'piyumalbandaranayake24790@gmail.com', '0705765890', 'piyumal19', '$2y$10$x86AmyzcJbnuI77kOPh.OuCFa3CyKKSe4oAWZ7rY1.RhtEpucEBBW', 'student', 0, '2026-02-17 14:59:38'),
(4, 'Super Admin', 'admin@lmscore.com', '0123456789', 'admin', '$2y$10$odgDoaI9huqX8jl75T0agO9ibGF523pHvJ.NdgoRRPfbn3HICXUaC', 'admin', 1, '2026-02-17 15:44:22'),
(5, 'piyumal shlainda', 'piyumalshalinda24790@gmail.com', '0705765890', 'piyumal28', '$2y$10$0ECiDdm.nSCxVojRRMhjq.zdZl576MgRWYo/WDHcEAG5ZpVlzvOQ6', 'student', 0, '2026-02-18 08:28:04'),
(6, 'piyumal shalinda', 'piyumal@gmail.com', '0705765890', 'piyumal22', '$2y$10$Ehs9yqz29xTsIOxGJsSARuNhdMPw4lldAcMfE/vnwEfn888Pwlomu', 'student', 0, '2026-02-18 20:02:38'),
(7, 'Piyumal Shalinda Bandaranayake', 'piyumalshalinda@gmail.com', '0705765890', 'piyumal20', '$2y$10$Labw80Pve.A3kInLn5r0ketgr3Mfi.CaSP3JpGVYP2RSbidoXsIlG', 'student', 0, '2026-02-26 05:25:35'),
(11, 'piyumak', 'admin@gmail.com', '0705765890', 'admin123', '$2y$10$7q5ukVI2AMS0joF2JzsOD.iKPgAuVZ8m1Gl/LUhhj7qhiTHIWcVN2', 'admin', 0, '2026-02-26 08:55:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `registrations_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
