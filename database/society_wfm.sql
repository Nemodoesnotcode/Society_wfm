-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2025 at 07:42 AM
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
-- Database: `society_wfm`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `worker_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `status` enum('Present','Absent','OnLeave') DEFAULT 'Present',
  `hours_worked` decimal(5,2) DEFAULT 0.00,
  `recorded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `worker_id`, `date`, `status`, `hours_worked`, `recorded_at`) VALUES
(1, 201, '2025-11-20', 'Present', 8.00, '2025-12-16 13:58:26'),
(2, 201, '2025-11-21', 'Absent', 0.00, '2025-12-16 13:58:26'),
(3, 202, '2025-11-20', 'Present', 8.00, '2025-12-16 13:58:26'),
(4, 202, '2025-11-21', 'Present', 8.00, '2025-12-16 13:58:26'),
(5, 203, '2025-11-20', 'OnLeave', 0.00, '2025-12-16 13:58:26'),
(6, 203, '2025-11-21', 'Present', 8.00, '2025-12-16 13:58:26'),
(7, 204, '2025-11-20', 'Present', 8.00, '2025-12-16 13:58:26'),
(8, 204, '2025-11-21', 'OnLeave', 0.00, '2025-12-16 13:58:26'),
(9, 205, '2025-11-20', 'Absent', 0.00, '2025-12-16 13:58:26'),
(10, 205, '2025-11-21', 'Present', 8.00, '2025-12-16 13:58:26'),
(12, 210, '2025-12-16', 'Present', 2.00, '2025-12-16 14:45:39'),
(13, 221, '2025-12-16', 'Present', 6.00, '2025-12-16 14:47:04'),
(14, 214, '2025-12-16', 'Present', 4.00, '2025-12-16 14:47:25'),
(15, 225, '2025-12-16', 'Present', 4.00, '2025-12-16 14:47:52'),
(16, 222, '2025-12-16', 'Present', 1.00, '2025-12-16 14:54:12'),
(17, 233, '2025-12-16', 'Absent', 0.00, '2025-12-16 14:55:50'),
(18, 236, '2025-12-16', 'Present', 1.00, '2025-12-16 14:59:42'),
(19, 220, '2025-12-16', 'Present', 1.00, '2025-12-16 15:01:36'),
(20, 223, '2025-12-16', 'OnLeave', 0.00, '2025-12-16 15:16:06'),
(21, 228, '2025-12-16', 'OnLeave', 0.00, '2025-12-16 15:16:26'),
(22, 215, '2025-12-17', 'Present', 6.00, '2025-12-17 09:35:42'),
(23, 234, '2025-12-17', 'Present', 2.00, '2025-12-17 09:39:15'),
(24, 208, '2025-12-17', 'Present', 1.00, '2025-12-17 11:06:35');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `request_id`, `resident_id`, `rating`, `comments`, `created_at`) VALUES
(6001, 5001, 2011, 4, 'Plumber fixed the sink quickly and efficiently.', '2025-11-21 05:30:00'),
(6002, 5002, 2023, 5, 'Electrician installed fan perfectly.', '2025-11-21 06:00:00'),
(6003, 5003, 2035, 3, 'Cook prepared food but it arrived late.', '2025-11-22 07:00:00'),
(6004, 5004, 2047, 4, 'Maid cleaned well, very satisfied.', '2025-11-22 08:00:00'),
(6005, 5005, 2059, 5, 'Plumber repaired water heater efficiently.', '2025-11-23 04:45:00'),
(6006, 5006, 2071, 2, 'Electrician arrived late, but work done.', '2025-11-23 05:15:00'),
(6007, 5007, 2084, 4, 'Cook made tasty meals, timely service.', '2025-11-24 09:20:00'),
(6008, 5008, 2096, 5, 'Maid did excellent laundry and cleaning.', '2025-11-24 10:00:00'),
(6009, 5009, 2108, 4, 'Plumber fixed tap well, satisfied.', '2025-11-25 11:00:00'),
(6010, 5010, 2120, 3, 'Electrician work done, but took longer than expected.', '2025-11-26 06:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `worker_id` int(11) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `month` varchar(20) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT 'Cash'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `worker_id`, `amount`, `payment_date`, `month`, `payment_method`) VALUES
(8001, 201, 1500.00, '2025-11-21', 'November', 'Cash'),
(8002, 202, 1200.00, '2025-10-21', 'October', 'Cash'),
(8003, 203, 40000.00, '2025-02-22', 'February', 'Cash'),
(8004, 204, 500.00, '2025-03-22', 'March', 'Cash'),
(8005, 202, 1600.00, '2025-04-23', 'April', 'Cash'),
(8006, 201, 1550.00, '2025-05-23', 'May', 'Cash'),
(8007, 207, 42000.00, '2025-06-24', 'June', 'Cash'),
(8008, 208, 550.00, '2025-07-24', 'July', 'Cash'),
(8009, 202, 1250.00, '2025-11-25', 'November', 'Cash'),
(8010, 201, 1580.00, '2025-08-26', 'August', 'Cash'),
(8011, 223, 4000.00, '2025-12-17', NULL, 'Online Transfer');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `request_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `worker_category` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('Pending','InProgress','Completed') DEFAULT 'Pending',
  `request_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `preferred_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`request_id`, `resident_id`, `worker_category`, `description`, `status`, `request_date`, `created_at`, `preferred_time`) VALUES
(5001, 2011, 'Plumber', 'Leaking sink in kitchen', 'Completed', '2025-11-20', '2025-12-17 12:54:51', '2025-12-17 18:13:45'),
(5002, 2023, 'Electrician', 'Fan installation in bedroom', 'Completed', '2025-11-21', '2025-12-17 12:54:51', '2025-12-17 18:13:45'),
(5003, 2035, 'Cook', 'Prepare special dinner', 'Completed', '2025-11-22', '2025-12-17 12:54:51', '2025-12-17 18:13:45'),
(5004, 2047, 'Maid', 'Deep cleaning of apartment', 'Completed', '2025-11-22', '2025-12-17 12:54:51', '2025-12-17 18:13:45'),
(5005, 2059, 'Plumber', 'Repair water heater', 'Completed', '2025-11-23', '2025-12-17 12:54:51', '2025-12-17 18:13:45'),
(5006, 2071, 'Electrician', 'Fix wiring in living room', 'Completed', '2025-11-23', '2025-12-17 12:54:51', '2025-12-17 18:13:45'),
(5007, 2084, 'Cook', 'Birthday party catering', 'Completed', '2025-11-24', '2025-12-17 12:54:51', '2025-12-17 18:13:45'),
(5008, 2096, 'Maid', 'Laundry and cleaning', 'Completed', '2025-11-24', '2025-12-17 12:54:51', '2025-12-17 18:13:45'),
(5009, 2108, 'Plumber', 'Tap replacement in bathroom', 'Completed', '2025-11-25', '2025-12-17 12:54:51', '2025-12-17 18:13:45'),
(5010, 2120, 'Electrician', 'Repair AC unit', 'Completed', '2025-11-26', '2025-12-17 12:54:51', '2025-12-17 18:13:45'),
(5011, 2128, 'Plumber', 'Tap leaking', 'Completed', NULL, '2025-12-17 13:51:21', '2025-12-17 19:00:00'),
(5012, 2142, 'Electrician', 'Fuse box fix', 'Completed', NULL, '2025-12-17 15:03:56', '2025-12-17 21:00:00'),
(5013, 2132, 'Maid', 'Cook 3 italian dishes(pasta,pizza,speghatti)', 'Completed', NULL, '2025-12-17 16:12:50', '2025-12-18 11:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `residents`
--

CREATE TABLE `residents` (
  `resident_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(300) DEFAULT NULL,
  `block` varchar(100) DEFAULT NULL,
  `apartment_no` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `residents`
--

INSERT INTO `residents` (`resident_id`, `user_id`, `address`, `block`, `apartment_no`) VALUES
(2011, 1011, 'Street 4, Green Villas', 'Green Villas', 'A-101'),
(2023, 1023, 'Street 3, Green Villas', 'Green Villas', 'B-202'),
(2035, 1035, 'Street 5, Green Villas', 'Green Villas', 'C-303'),
(2047, 1047, 'Street 7, Green Villas', 'Green Villas', 'D-404'),
(2059, 1059, 'Street 1, Green Villas', 'Green Villas', 'A-105'),
(2071, 1071, 'Street 3, Green Villas', 'Green Villas', 'B-118'),
(2084, 1084, 'Street 6, Green Villas', 'Green Villas', 'C-220'),
(2096, 1096, 'Street 8, Green Villas', 'Green Villas', 'D-115'),
(2108, 1108, 'Street 1, Green Villas', 'Green Villas', 'A-133'),
(2120, 1120, 'Street 4, Green Villas', 'Green Villas', 'E-301'),
(2121, 1637, 'Street 1, Green Villas', 'Green Villas', 'A-400'),
(2122, 1638, 'Street 2, Green Villas', 'Green Villas', 'A-401'),
(2123, 1639, 'Street 3, Green Villas', 'Green Villas', 'A-402'),
(2124, 1640, 'Street 4, Green Villas', 'Green Villas', 'A-403'),
(2125, 1641, 'Street 5, Green Villas', 'Green Villas', 'A-404'),
(2126, 1642, 'Street 6, Green Villas', 'Green Villas', 'A-405'),
(2127, 1643, 'Street 7, Green Villas', 'Green Villas', 'A-406'),
(2128, 1644, 'Street 8, Green Villas', 'Green Villas', 'A-407'),
(2129, 1645, 'Street 9, Green Villas', 'Green Villas', 'A-408'),
(2130, 1646, 'Street 10, Green Villas', 'Green Villas', 'A-409'),
(2131, 1647, 'Street 1, Green Villas', 'Green Villas', 'A-410'),
(2132, 1648, 'Street 2, Green Villas', 'Green Villas', 'A-411'),
(2133, 1649, 'Street 3, Green Villas', 'Green Villas', 'A-412'),
(2134, 1650, 'Street 4, Green Villas', 'Green Villas', 'A-413'),
(2135, 1651, 'Street 5, Green Villas', 'Green Villas', 'A-414'),
(2136, 1652, 'Street 6, Green Villas', 'Green Villas', 'A-415'),
(2137, 1653, 'Street 7, Green Villas', 'Green Villas', 'A-416'),
(2138, 1654, 'Street 8, Green Villas', 'Green Villas', 'A-417'),
(2139, 1655, 'Street 9, Green Villas', 'Green Villas', 'A-418'),
(2140, 1656, 'Street 10, Green Villas', 'Green Villas', 'A-419'),
(2141, 1657, 'Street 1, Green Villas', 'Green Villas', 'A-420'),
(2142, 1658, 'Street 2, Green Villas', 'Green Villas', 'A-421'),
(2143, 1659, 'Street 3, Green Villas', 'Green Villas', 'A-422'),
(2144, 1660, 'Street 4, Green Villas', 'Green Villas', 'A-423'),
(2145, 1661, 'Street 5, Green Villas', 'Green Villas', 'A-424'),
(2146, 1662, 'Street 6, Green Villas', 'Green Villas', 'A-425'),
(2147, 1663, 'Street 7, Green Villas', 'Green Villas', 'A-426'),
(2148, 1664, 'Street 8, Green Villas', 'Green Villas', 'A-427'),
(2149, 1665, 'Street 9, Green Villas', 'Green Villas', 'A-428'),
(2150, 1666, 'Street 10, Green Villas', 'Green Villas', 'A-429'),
(2151, 1667, 'Street 1, Green Villas', 'Green Villas', 'A-430'),
(2152, 1668, 'Street 2, Green Villas', 'Green Villas', 'A-431'),
(2153, 1669, 'Street 3, Green Villas', 'Green Villas', 'A-432'),
(2154, 1670, 'Street 4, Green Villas', 'Green Villas', 'A-433'),
(2155, 1671, 'Street 5, Green Villas', 'Green Villas', 'A-434'),
(2156, 1672, 'Street 6, Green Villas', 'Green Villas', 'A-435'),
(2157, 1673, 'Street 7, Green Villas', 'Green Villas', 'A-436'),
(2158, 1674, 'Street 8, Green Villas', 'Green Villas', 'A-437'),
(2159, 1675, 'Street 9, Green Villas', 'Green Villas', 'A-438'),
(2160, 1676, 'Street 10, Green Villas', 'Green Villas', 'A-439'),
(2161, 1677, 'Street 1, Green Villas', 'Green Villas', 'A-440'),
(2162, 1678, 'Street 2, Green Villas', 'Green Villas', 'A-441'),
(2163, 1679, 'Street 3, Green Villas', 'Green Villas', 'A-442'),
(2164, 1680, 'Street 4, Green Villas', 'Green Villas', 'A-443'),
(2165, 1681, 'Street 5, Green Villas', 'Green Villas', 'A-444'),
(2166, 1682, 'Street 6, Green Villas', 'Green Villas', 'A-445'),
(2167, 1683, 'Street 7, Green Villas', 'Green Villas', 'A-446'),
(2168, 1684, 'Street 8, Green Villas', 'Green Villas', 'A-447'),
(2169, 1685, 'Street 9, Green Villas', 'Green Villas', 'A-448'),
(2170, 1686, 'Street 10, Green Villas', 'Green Villas', 'A-449');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `worker_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `task_date` datetime DEFAULT NULL,
  `status` enum('Pending','Completed') DEFAULT 'Pending',
  `completion_date` datetime DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `worker_id`, `request_id`, `description`, `task_date`, `status`, `completion_date`, `notes`, `amount`) VALUES
(7001, 202, 5001, 'Fixed leaking sink', '2025-11-20 17:00:00', 'Completed', NULL, NULL, 1200.00),
(7002, 201, 5002, 'Installed fan', '2025-11-21 22:00:00', 'Completed', NULL, NULL, 1500.00),
(7003, 203, 5003, 'Prepared dinner', '2025-11-22 11:00:00', 'Completed', NULL, NULL, 2000.00),
(7004, 204, 5004, 'Deep cleaned apartment', '2025-11-22 00:00:00', 'Completed', NULL, NULL, 300.00),
(7005, 202, 5005, 'Repaired water heater', '2025-11-23 10:00:00', 'Completed', NULL, NULL, 550.00),
(7006, 201, 5006, 'Fixed wiring', '2025-11-23 00:00:00', 'Completed', NULL, NULL, 1500.00),
(7007, 207, 5007, 'Catering for party', '2025-11-24 00:00:00', 'Completed', NULL, NULL, 2500.00),
(7008, 208, 5008, 'Laundry and cleaning', '2025-11-24 00:00:00', 'Completed', NULL, NULL, 1000.00),
(7009, 202, 5009, 'Replaced tap', '2025-11-25 00:00:00', 'Completed', NULL, NULL, 1000.00),
(7010, 201, 5010, 'Repaired AC', '2025-11-26 00:00:00', 'Completed', NULL, NULL, 2500.00),
(7012, 201, 5012, NULL, '2025-12-17 20:00:00', 'Completed', NULL, NULL, 2500.00),
(7013, 211, 5013, NULL, '2025-12-17 22:00:00', 'Completed', '2025-12-17 21:33:05', '\nCompleted via simplified dashboard', 3000.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `cnic` varchar(20) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `role` enum('admin','resident','worker') NOT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `cnic`, `phone`, `email`, `role`, `password_hash`, `created_at`) VALUES
(1011, 'Ali Khan', '35201-1111111-1', '03001230011', 'ali.khan@gmail.com', 'resident', 'hash1011', '2025-12-16 13:58:25'),
(1023, 'Ayesha Noor', '35201-2222222-2', '03004562023', 'ayesha.noor@gmail.com', 'resident', 'hash1023', '2025-12-16 13:58:25'),
(1035, 'Hamza Malik', '35201-3333333-3', '03006789035', 'hamza.malik@gmail.com', 'resident', 'hash1035', '2025-12-16 13:58:25'),
(1047, 'Sana Ahmed', '35201-4444444-4', '03005551047', 'sana.ahmed@gmail.com', 'resident', 'hash1047', '2025-12-16 13:58:25'),
(1059, 'Imran Ali', '35201-5555555-5', '03003456059', 'imran.ali@gmail.com', 'resident', 'hash1059', '2025-12-16 13:58:25'),
(1071, 'Maryam Raza', '35201-6666666-6', '03001111771', 'maryam.raza@gmail.com', 'resident', 'hash1071', '2025-12-16 13:58:25'),
(1084, 'Usman Tariq', '35201-7777777-7', '03004488784', 'usman.tariq@gmail.com', 'resident', 'hash1084', '2025-12-16 13:58:25'),
(1096, 'Hina Qureshi', '35201-8888888-8', '03007890096', 'hina.qureshi@gmail.com', 'resident', 'hash1096', '2025-12-16 13:58:25'),
(1108, 'Bilal Hussain', '35201-9999999-9', '03006666108', 'bilal.hussain@gmail.com', 'resident', 'hash1108', '2025-12-16 13:58:25'),
(1120, 'Sara Khalid', '35201-1010101-0', '03005555120', 'sara.khalid@gmail.com', 'resident', 'hash1120', '2025-12-16 13:58:25'),
(1132, 'Admin One', '35201-2020202-1', '03009999132', 'admin.one@greenvillas.pk', 'admin', 'naa123', '2025-12-16 13:58:25'),
(1144, 'Admin Two', '35201-3030303-2', '03008888144', 'admin.two@greenvillas.pk', 'admin', 'naa321', '2025-12-16 13:58:25'),
(1156, 'Kamran Electrician', '35201-4040404-3', '03001234556', 'kamran.electrician@gmail.com', 'worker', 'hash1156', '2025-12-16 13:58:25'),
(1168, 'Shahid Plumber', '35201-5050505-4', '03002345668', 'shahid.plumber@gmail.com', 'worker', 'hash1168', '2025-12-16 13:58:25'),
(1180, 'Farhan Cook', '35201-6060606-5', '03003456780', 'farhan.cook@gmail.com', 'worker', 'hash1180', '2025-12-16 13:58:25'),
(1192, 'Naveed Maid', '35201-7070707-6', '03004567892', 'naveed.house@gmail.com', 'worker', 'hash1192', '2025-12-16 13:58:25'),
(1204, 'Zeeshan Electrician', '35201-8080808-7', '03005678904', 'zeeshan.electric@gmail.com', 'worker', 'hash1204', '2025-12-16 13:58:25'),
(1216, 'Rizwan Plumber', '35201-9090909-8', '03006789016', 'rizwan.plumber@gmail.com', 'worker', 'hash1216', '2025-12-16 13:58:25'),
(1228, 'Junaid Cook', '35201-1111222-9', '03007890128', 'junaid.cook@gmail.com', 'worker', 'hash1228', '2025-12-16 13:58:25'),
(1240, 'Adnan Maid', '35201-1212333-0', '03008901240', 'adnan.maid@gmail.com', 'worker', 'hash1240', '2025-12-16 13:58:25'),
(1252, 'Salman Electrician', '35201-1313444-1', '03001239852', 'salman.electric@gmail.com', 'worker', 'hash1252', '2025-12-16 13:58:25'),
(1264, 'Arif Plumber', '35201-1414555-2', '03002349864', 'arif.plumber@gmail.com', 'worker', 'hash1264', '2025-12-16 13:58:25'),
(1276, 'Majid Cook', '35201-1515666-3', '03003459876', 'majid.cook@gmail.com', 'worker', 'hash1276', '2025-12-16 13:58:25'),
(1288, 'Faisal Maid', '35201-1616777-4', '03004569888', 'faisal.maid@gmail.com', 'worker', 'hash1288', '2025-12-16 13:58:25'),
(1300, 'Waqar Electrician', '35201-1717888-5', '03005679800', 'waqar.electric@gmail.com', 'worker', 'hash1300', '2025-12-16 13:58:25'),
(1312, 'Tahir Plumber', '35201-1818999-6', '03006789812', 'tahir.plumber@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1324, 'Ahmad Cook', '35201-1919000-7', '03007899824', 'ahmad.cook@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1336, 'Irfan Maid', '35201-2020111-8', '03008909836', 'irfan.maid@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1348, 'Saad Electrician', '35201-2121222-9', '03001111948', 'saad.electric@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1360, 'Rashid Electrician', '35201-2323232-3', '03001234560', 'rashid.electric2@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1372, 'Tariq Plumber', '35201-2424242-4', '03002345672', 'tariq.plumber2@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1384, 'Sameer Cook', '35201-2525252-5', '03003456784', 'sameer.cook@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1396, 'Laiba Maid', '35201-2626262-6', '03004567896', 'laiba.maid@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1408, 'Ahmed Electric', '35201-2727272-7', '03005678908', 'ahmed.electric2@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1420, 'Bilal Plumber', '35201-2828282-8', '03006789020', 'bilal.plumber2@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1432, 'Kashif Cook', '35201-2929292-9', '03007890132', 'kashif.cook@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1444, 'Sobia Maid', '35201-3030303-0', '03008901244', 'sobia.maid@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1456, 'Moiz Electric', '35201-3131313-1', '03001111356', 'moiz.elec@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1468, 'Danish Plumber', '35201-3232323-2', '03002222468', 'danish.plumb@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1480, 'Hira Cook', '35201-3333333-4', '03003333580', 'hira.cook@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1492, 'Zara Maid', '35201-3434343-5', '03004444692', 'zara.maid@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1504, 'Jahanzaib Electric', '35201-3535353-6', '03005555704', 'jahanzaib.electric@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1516, 'Rehan Plumber', '35201-3636363-7', '03006666816', 'rehan.plumb@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1528, 'Maria Cook', '35201-3737373-8', '03007777928', 'maria.cook@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1540, 'Amina Maid', '35201-3838383-9', '03008888040', 'amina.maid@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1552, 'Aslam Electric', '35201-3939393-0', '03009999152', 'aslam.electric@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1564, 'Jamal Plumber', '35201-4040404-1', '03001111264', 'jamal.plumber@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1576, 'Danish Cook', '35201-4141414-2', '03002222376', 'danish.cook@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1588, 'Ghazal Maid', '35201-4242424-3', '03003333488', 'ghazal.maid@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1600, 'Talha Electric', '35201-4343434-4', '03004444500', 'talha.electric@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1612, 'Adeel Plumber', '35201-4444444-5', '03005555612', 'adeel.plumb@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1624, 'Sofia Cook', '35201-4545454-6', '03006666724', 'sofia.cook@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1636, 'Areesha Maid', '35201-4646464-7', '03007777836', 'areesha.maid@gmail.com', 'worker', '$2y$10$SMuSOV4evW09mLuOhu6TBuG/BRZ.zPivl4YNGgQgb6WVjvKPiYdFC', '2025-12-16 13:58:25'),
(1637, 'Ayesha Imbisat', '35202-51000000-1', '0300700000', 'ayesha.imbisat@gmail.com', 'resident', 'res1hash', '2025-12-16 13:58:26'),
(1638, 'Abdullah Sheikh', '35202-51000001-1', '0300700001', 'abdullah.sheikh@gmail.com', 'resident', 'res2hash', '2025-12-16 13:58:26'),
(1639, 'Fatima Malik', '35202-51000002-1', '0300700002', 'fatima.malik@gmail.com', 'resident', 'res3hash', '2025-12-16 13:58:26'),
(1640, 'Hassan Ahmed', '35202-51000003-1', '0300700003', 'hassan.ahmed@gmail.com', 'resident', 'res4hash', '2025-12-16 13:58:26'),
(1641, 'Mahnoor Qasim', '35202-51000004-1', '0300700004', 'mahnoor.qasim@gmail.com', 'resident', 'res5hash', '2025-12-16 13:58:26'),
(1642, 'Hamza Ali', '35202-51000005-1', '0300700005', 'hamza.ali@gmail.com', 'resident', 'res6hash', '2025-12-16 13:58:26'),
(1643, 'Samina Farooq', '35202-51000006-1', '0300700006', 'samina.farooq@gmail.com', 'resident', 'res7hash', '2025-12-16 13:58:26'),
(1644, 'Abdullah Niaz', '35202-51000007-1', '0300700007', 'abdullah.niaz@gmail.com', 'resident', 'res8hash', '2025-12-16 13:58:26'),
(1645, 'Zainab Arif', '35202-51000008-1', '0300700008', 'zainab.arif@gmail.com', 'resident', 'res9hash', '2025-12-16 13:58:26'),
(1646, 'Usman Baig', '35202-51000009-1', '0300700009', 'usman.baig@gmail.com', 'resident', 'res10hash', '2025-12-16 13:58:26'),
(1647, 'Maryam Junaid', '35202-51000010-1', '0300700010', 'maryam.junaid@gmail.com', 'resident', 'res11hash', '2025-12-16 13:58:26'),
(1648, 'Adan Irfan', '35202-51000011-1', '0300700011', 'adan.irfan@gmail.com', 'resident', 'res12hash', '2025-12-16 13:58:26'),
(1649, 'Hira Aslam', '35202-51000012-1', '0300700012', 'hira.aslam@gmail.com', 'resident', 'res13hash', '2025-12-16 13:58:26'),
(1650, 'Saad Qureshi', '35202-51000013-1', '0300700013', 'saad.qureshi@gmail.com', 'resident', 'res14hash', '2025-12-16 13:58:26'),
(1651, 'Anum Shakeel', '35202-51000014-1', '0300700014', 'anum.shakeel@gmail.com', 'resident', 'res15hash', '2025-12-16 13:58:26'),
(1652, 'Omar Javed', '35202-51000015-1', '0300700015', 'omar.javed@gmail.com', 'resident', 'res16hash', '2025-12-16 13:58:26'),
(1653, 'Nimra Butt', '35202-51000016-1', '0300700016', 'nimra.butt@gmail.com', 'resident', 'res17hash', '2025-12-16 13:58:26'),
(1654, 'Ahmed Faraz', '35202-51000017-1', '0300700017', 'ahmed.faraz@gmail.com', 'resident', 'res18hash', '2025-12-16 13:58:26'),
(1655, 'Khadija Rizvi', '35202-51000018-1', '0300700018', 'khadija.rizvi@gmail.com', 'resident', 'res19hash', '2025-12-16 13:58:26'),
(1656, 'Taha Siddiqui', '35202-51000019-1', '0300700019', 'taha.siddiqui@gmail.com', 'resident', 'res20hash', '2025-12-16 13:58:26'),
(1657, 'Hiba Danish', '35202-51000020-1', '0300700020', 'hiba.danish@gmail.com', 'resident', 'res21hash', '2025-12-16 13:58:26'),
(1658, 'Shahid Mehmood', '35202-51000021-1', '0300700021', 'shahid.mehmood@gmail.com', 'resident', 'res22hash', '2025-12-16 13:58:26'),
(1659, 'Iqra Habib', '35202-51000022-1', '0300700022', 'iqra.habib@gmail.com', 'resident', 'res23hash', '2025-12-16 13:58:26'),
(1660, 'Moiz Khan', '35202-51000023-1', '0300700023', 'moiz.khan@gmail.com', 'resident', 'res24hash', '2025-12-16 13:58:26'),
(1661, 'Areeba Sami', '35202-51000024-1', '0300700024', 'areeba.sami@gmail.com', 'resident', 'res25hash', '2025-12-16 13:58:26'),
(1662, 'Waleed Noor', '35202-51000025-1', '0300700025', 'waleed.noor@gmail.com', 'resident', 'res26hash', '2025-12-16 13:58:26'),
(1663, 'Laiba Ahsan', '35202-51000026-1', '0300700026', 'laiba.ahsan@gmail.com', 'resident', 'res27hash', '2025-12-16 13:58:26'),
(1664, 'Rayan Zafar', '35202-51000027-1', '0300700027', 'rayan.zafar@gmail.com', 'resident', 'res28hash', '2025-12-16 13:58:26'),
(1665, 'Hania Arshad', '35202-51000028-1', '0300700028', 'hania.arshad@gmail.com', 'resident', 'res29hash', '2025-12-16 13:58:26'),
(1666, 'Imran Saeed', '35202-51000029-1', '0300700029', 'imran.saeed@gmail.com', 'resident', 'res30hash', '2025-12-16 13:58:26'),
(1667, 'Aiman Yousaf', '35202-51000030-1', '0300700030', 'aiman.yousaf@gmail.com', 'resident', 'res31hash', '2025-12-16 13:58:26'),
(1668, 'Aila Kanwal', '35202-51000031-1', '0300700031', 'aila.kanwal@gmail.com', 'resident', 'res32hash', '2025-12-16 13:58:26'),
(1669, 'Zoya Ansari', '35202-51000032-1', '0300700032', 'zoya.ansari@gmail.com', 'resident', 'res33hash', '2025-12-16 13:58:26'),
(1670, 'Shoaib Malik', '35202-51000033-1', '0300700033', 'shoaib.malik@gmail.com', 'resident', 'res34hash', '2025-12-16 13:58:26'),
(1671, 'Aiman Fatima', '35202-51000034-1', '0300700034', 'aiman.fatima@gmail.com', 'resident', 'res35hash', '2025-12-16 13:58:26'),
(1672, 'Haris Munir', '35202-51000035-1', '0300700035', 'haris.munir@gmail.com', 'resident', 'res36hash', '2025-12-16 13:58:26'),
(1673, 'Rida Murtaza', '35202-51000036-1', '0300700036', 'rida.murtaza@gmail.com', 'resident', 'res37hash', '2025-12-16 13:58:26'),
(1674, 'Usama Tariq', '35202-51000037-1', '0300700037', 'usama.tariq@gmail.com', 'resident', 'res38hash', '2025-12-16 13:58:26'),
(1675, 'Maham Afzal', '35202-51000038-1', '0300700038', 'maham.afzal@gmail.com', 'resident', 'res39hash', '2025-12-16 13:58:26'),
(1676, 'Talha Ramzan', '35202-51000039-1', '0300700039', 'talha.ramzan@gmail.com', 'resident', 'res40hash', '2025-12-16 13:58:26'),
(1677, 'Areej Hassan', '35202-51000040-1', '0300700040', 'areej.hassan@gmail.com', 'resident', 'res41hash', '2025-12-16 13:58:26'),
(1678, 'Yasir Khan', '35202-51000041-1', '0300700041', 'yasir.khan@gmail.com', 'resident', 'res42hash', '2025-12-16 13:58:26'),
(1679, 'Mehwish Asad', '35202-51000042-1', '0300700042', 'mehwish.asad@gmail.com', 'resident', 'res43hash', '2025-12-16 13:58:26'),
(1680, 'Saif Ullah', '35202-51000043-1', '0300700043', 'saif.ullah@gmail.com', 'resident', 'res44hash', '2025-12-16 13:58:26'),
(1681, 'Sana Rauf', '35202-51000044-1', '0300700044', 'sana.rauf@gmail.com', 'resident', 'res45hash', '2025-12-16 13:58:26'),
(1682, 'Furqan Ali', '35202-51000045-1', '0300700045', 'furqan.ali@gmail.com', 'resident', 'res46hash', '2025-12-16 13:58:26'),
(1683, 'Nida Javed', '35202-51000046-1', '0300700046', 'nida.javed@gmail.com', 'resident', 'res47hash', '2025-12-16 13:58:26'),
(1684, 'Rafay Noman', '35202-51000047-1', '0300700047', 'rafay.noman@gmail.com', 'resident', 'res48hash', '2025-12-16 13:58:26'),
(1685, 'Malaika Noor', '35202-51000048-1', '0300700048', 'malaika.noor@gmail.com', 'resident', 'res49hash', '2025-12-16 13:58:26'),
(1686, 'Daniyal Sheikh', '35202-51000049-1', '0300700049', 'daniyal.sheikh@gmail.com', 'resident', 'res50hash', '2025-12-16 13:58:26');

-- --------------------------------------------------------

--
-- Table structure for table `workers`
--

CREATE TABLE `workers` (
  `worker_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `payment_type` enum('PER_TASK','PER_DAY','SALARY') NOT NULL DEFAULT 'PER_TASK',
  `salary_per` decimal(10,2) DEFAULT 0.00,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `hired_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workers`
--

INSERT INTO `workers` (`worker_id`, `user_id`, `category`, `payment_type`, `salary_per`, `status`, `hired_date`, `notes`) VALUES
(201, 1156, 'Electrician', 'PER_TASK', 1500.00, 'Active', '2025-01-10', 'Experienced in wiring, 5 years experience'),
(202, 1168, 'Plumber', 'PER_TASK', 1200.00, 'Active', '2025-01-12', 'Expert in pipe repairs, certified plumber'),
(203, 1180, 'Cook', 'SALARY', 40000.00, 'Active', '2025-01-15', 'Skilled in continental cooking, 7 years experience'),
(204, 1192, 'Maid', 'PER_DAY', 500.00, 'Active', '2025-01-18', 'Housekeeping and cleaning, speaks English'),
(205, 1204, 'Electrician', 'PER_TASK', 1600.00, 'Active', '2025-01-20', 'Good at troubleshooting, industrial electrician'),
(206, 1216, 'Plumber', 'PER_TASK', 1300.00, 'Active', '2025-01-22', 'Quick in fixing leaks, available 24/7'),
(207, 1228, 'Cook', 'SALARY', 42000.00, 'Active', '2025-01-25', 'Specializes in desserts, pastry chef'),
(208, 1240, 'Maid', 'PER_DAY', 550.00, 'Active', '2025-01-28', 'Efficient and punctual, good with kids'),
(209, 1252, 'Electrician', 'PER_TASK', 1550.00, 'Active', '2025-02-01', 'Repairs appliances, AC specialist'),
(210, 1264, 'Plumber', 'PER_TASK', 1250.00, 'Active', '2025-02-03', 'Handles emergencies, water heater expert'),
(211, 1276, 'Cook', 'SALARY', 41000.00, 'Active', '2025-02-05', 'Specializes in Asian cuisine, 10 years experience'),
(212, 1288, 'Maid', 'PER_DAY', 580.00, 'Active', '2025-02-08', 'Expert in gardening and cleaning, multitasker'),
(213, 1300, 'Electrician', 'PER_TASK', 1580.00, 'Active', '2025-02-10', 'Handles wiring and appliances, reliable'),
(214, 1312, 'Plumber', 'PER_TASK', 1350.00, 'Active', '2025-02-12', 'Skilled in water supply systems, pipe fitting'),
(215, 1324, 'Cook', 'SALARY', 43000.00, 'Active', '2025-02-15', 'Famous for desserts, wedding specialist'),
(216, 1336, 'Maid', 'PER_DAY', 600.00, 'Active', '2025-02-18', 'Housekeeping and laundry expert, organized'),
(217, 1348, 'Electrician', 'PER_TASK', 1620.00, 'Active', '2025-02-20', 'Handles maintenance efficiently, safety certified'),
(218, 1360, 'Electrician', 'PER_TASK', 1650.00, 'Active', '2025-02-25', 'Commercial electrician, licensed'),
(219, 1372, 'Plumber', 'PER_DAY', 1500.00, 'Active', '2025-02-26', 'Drain cleaning specialist'),
(220, 1384, 'Cook', 'SALARY', 38000.00, 'Active', '2025-02-28', 'Vegetarian cuisine expert'),
(221, 1396, 'Maid', 'PER_DAY', 520.00, 'Active', '2025-03-01', 'Deep cleaning specialist'),
(222, 1408, 'Electrician', 'PER_TASK', 1700.00, 'Active', '2025-03-03', 'Solar panel installation expert'),
(223, 1420, 'Plumber', 'PER_TASK', 1400.00, 'Active', '2025-03-05', 'Bathroom renovation specialist'),
(224, 1432, 'Cook', 'SALARY', 45000.00, 'Active', '2025-03-08', 'BBQ and grilling expert'),
(225, 1444, 'Maid', 'PER_DAY', 620.00, 'Active', '2025-03-10', 'Elderly care specialist'),
(226, 1456, 'Electrician', 'PER_DAY', 1800.00, 'Active', '2025-03-12', 'Home automation specialist'),
(227, 1468, 'Plumber', 'SALARY', 35000.00, 'Active', '2025-03-15', 'Maintenance plumber, full-time'),
(228, 1480, 'Cook', 'PER_DAY', 2000.00, 'Active', '2025-03-18', 'Event catering specialist'),
(229, 1492, 'Maid', 'SALARY', 25000.00, 'Active', '2025-03-20', 'Full-time housekeeper'),
(230, 1504, 'Electrician', 'PER_TASK', 1750.00, 'Active', '2025-03-22', 'Emergency electrical repairs'),
(231, 1516, 'Plumber', 'PER_TASK', 1450.00, 'Active', '2025-03-25', 'Gas line specialist'),
(232, 1528, 'Cook', 'SALARY', 42000.00, 'Inactive', '2025-03-28', 'On leave until June'),
(233, 1540, 'Maid', 'PER_DAY', 650.00, 'Active', '2025-04-01', 'Office cleaning specialist'),
(234, 1552, 'Electrician', 'SALARY', 48000.00, 'Active', '2025-04-03', 'Factory maintenance electrician'),
(235, 1564, 'Plumber', 'PER_DAY', 1600.00, 'Active', '2025-04-05', 'Swimming pool plumber'),
(236, 1576, 'Cook', 'PER_TASK', 2500.00, 'Active', '2025-04-08', 'Private chef for events'),
(237, 1588, 'Maid', 'PER_DAY', 700.00, 'Active', '2025-04-10', 'Move-in/move-out cleaning'),
(238, 1600, 'Electrician', 'PER_TASK', 1800.00, 'Active', '2025-04-12', 'Smart home installation'),
(239, 1612, 'Plumber', 'SALARY', 38000.00, 'Inactive', '2025-04-15', 'Left for vacation'),
(240, 1624, 'Cook', 'SALARY', 46000.00, 'Active', '2025-04-18', 'International cuisine chef');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `worker_id` (`worker_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `resident_id` (`resident_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `worker_id` (`worker_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `resident_id` (`resident_id`);

--
-- Indexes for table `residents`
--
ALTER TABLE `residents`
  ADD PRIMARY KEY (`resident_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `worker_id` (`worker_id`),
  ADD KEY `request_id` (`request_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `cnic` (`cnic`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`worker_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6011;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8012;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5014;

--
-- AUTO_INCREMENT for table `residents`
--
ALTER TABLE `residents`
  MODIFY `resident_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2171;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7014;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1687;

--
-- AUTO_INCREMENT for table `workers`
--
ALTER TABLE `workers`
  MODIFY `worker_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`worker_id`) REFERENCES `workers` (`worker_id`) ON DELETE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `requests` (`request_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`resident_id`) REFERENCES `residents` (`resident_id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`worker_id`) REFERENCES `workers` (`worker_id`) ON DELETE CASCADE;

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `residents` (`resident_id`) ON DELETE CASCADE;

--
-- Constraints for table `residents`
--
ALTER TABLE `residents`
  ADD CONSTRAINT `residents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`worker_id`) REFERENCES `workers` (`worker_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`request_id`) REFERENCES `requests` (`request_id`) ON DELETE CASCADE;

--
-- Constraints for table `workers`
--
ALTER TABLE `workers`
  ADD CONSTRAINT `workers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
