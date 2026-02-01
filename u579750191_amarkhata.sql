-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 01, 2026 at 05:28 PM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u579750191_amarkhata`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `initial_balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `current_balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `account_number` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0 COMMENT 'ডিফল্ট অ্যাকাউন্ট কিনা'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `user_id`, `name`, `type`, `initial_balance`, `current_balance`, `account_number`, `bank_name`, `branch`, `description`, `created_at`, `updated_at`, `is_default`) VALUES
(1, 1, 'Cash In Hand', 'Cash', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-11 04:58:45', '2025-05-11 04:58:45', 1),
(2, 1, 'My Bank', 'Bank', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-11 04:58:45', '2025-05-11 04:58:45', 0),
(3, 1, 'bKash', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-11 04:58:45', '2025-05-11 04:58:45', 0),
(4, 1, 'Nagad', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-11 04:58:45', '2025-05-11 04:58:45', 0),
(5, 1, 'Rocket', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-11 04:58:45', '2025-05-11 04:58:45', 0),
(6, 1, 'Others', 'Other', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-11 04:58:45', '2025-05-11 04:58:45', 0),
(19, 4, 'Cash In Hand (হাতে)', 'Cash', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-11 16:10:19', '2025-05-11 16:10:19', 1),
(20, 4, 'My Bank', 'Bank', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-11 16:10:19', '2025-05-11 16:10:19', 1),
(21, 4, 'বিকাশ', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-11 16:10:19', '2025-05-11 16:10:19', 1),
(22, 4, 'Nagad', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-11 16:10:19', '2025-05-11 16:10:19', 1),
(23, 4, 'Rocket', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-11 16:10:19', '2025-05-11 16:10:19', 1),
(24, 4, 'Others', 'Other', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-11 16:10:19', '2025-05-11 16:10:19', 1),
(25, 5, 'Cash In Hand (হাতে)', 'Cash', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-11 17:12:24', '2025-05-11 17:12:24', 1),
(26, 5, 'My Bank', 'Bank', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-11 17:12:24', '2025-05-11 17:12:24', 1),
(31, 6, 'Cash In Hand (হাতে)', 'Cash', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-11 20:20:35', '2025-05-11 20:20:35', 1),
(32, 6, 'My Bank', 'Bank', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-11 20:20:35', '2025-05-11 20:20:35', 1),
(33, 6, 'বিকাশ', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-11 20:20:35', '2025-05-11 20:20:35', 1),
(34, 6, 'Nagad', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-11 20:20:35', '2025-05-11 20:20:35', 1),
(35, 6, 'Rocket', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-11 20:20:35', '2025-05-11 20:20:35', 1),
(36, 6, 'Others', 'Other', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-11 20:20:35', '2025-05-11 20:20:35', 1),
(37, 7, 'Cash In Hand (হাতে)', 'Cash', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-12 09:15:22', '2025-05-12 09:15:22', 1),
(38, 7, 'My Bank', 'Bank', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-12 09:15:22', '2025-05-12 09:15:22', 1),
(39, 7, 'বিকাশ', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-12 09:15:22', '2025-05-12 09:15:22', 1),
(40, 7, 'Nagad', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-12 09:15:22', '2025-05-12 09:15:22', 1),
(41, 7, 'Rocket', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-12 09:15:22', '2025-05-12 09:15:22', 1),
(42, 7, 'Others', 'Other', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-12 09:15:22', '2025-05-12 09:15:22', 1),
(43, 8, 'Cash In Hand (হাতে)', 'Cash', 0.00, 700.00, NULL, NULL, NULL, NULL, '2025-05-13 16:56:30', '2025-05-13 16:58:01', 1),
(44, 8, 'My Bank', 'Bank', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-13 16:56:30', '2025-05-13 16:56:30', 1),
(45, 8, 'বিকাশ', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-13 16:56:30', '2025-05-13 16:56:30', 1),
(46, 8, 'Nagad', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-13 16:56:30', '2025-05-13 16:56:30', 1),
(47, 8, 'Rocket', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-13 16:56:30', '2025-05-13 16:56:30', 1),
(48, 8, 'Others', 'Other', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-13 16:56:30', '2025-05-13 16:56:30', 1),
(49, 5, 'জমা টাকা', 'Cash', 0.00, 26618.00, NULL, NULL, NULL, NULL, '2025-05-13 18:45:21', '2025-05-13 19:20:54', 0),
(51, 9, 'Cash In Hand (হাতে)', 'Cash', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-14 18:29:07', '2025-05-14 18:29:07', 1),
(52, 9, 'My Bank', 'Bank', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-14 18:29:07', '2025-05-14 18:29:07', 1),
(53, 9, 'বিকাশ', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-14 18:29:07', '2025-05-14 18:29:07', 1),
(54, 9, 'Nagad', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-14 18:29:07', '2025-05-14 18:29:07', 1),
(55, 9, 'Rocket', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-14 18:29:07', '2025-05-14 18:29:07', 1),
(56, 9, 'Others', 'Other', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-14 18:29:07', '2025-05-14 18:29:07', 1),
(57, 10, 'Cash In Hand (হাতে)', 'Cash', 0.00, 7355.00, NULL, NULL, NULL, NULL, '2025-05-18 15:10:01', '2025-05-19 18:05:20', 1),
(58, 10, 'My Bank', 'Bank', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-18 15:10:01', '2025-05-18 15:10:01', 1),
(59, 10, 'বিকাশ', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-18 15:10:01', '2025-05-18 15:10:01', 1),
(60, 10, 'Nagad', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-18 15:10:01', '2025-05-18 15:10:01', 1),
(61, 10, 'Rocket', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-18 15:10:01', '2025-05-18 15:10:01', 1),
(62, 10, 'Others', 'Other', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-18 15:10:01', '2025-05-18 15:10:01', 1),
(63, 11, 'Cash In Hand (হাতে)', 'Cash', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-24 09:53:13', '2025-05-24 09:53:13', 1),
(64, 11, 'My Bank', 'Bank', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-24 09:53:13', '2025-05-24 09:53:13', 1),
(65, 11, 'বিকাশ', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-24 09:53:13', '2025-05-24 09:53:13', 1),
(66, 11, 'Nagad', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-24 09:53:13', '2025-05-24 09:53:13', 1),
(67, 11, 'Rocket', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-24 09:53:13', '2025-05-24 09:53:13', 1),
(68, 11, 'Others', 'Other', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-24 09:53:13', '2025-05-24 09:53:13', 1),
(69, 12, 'Cash In Hand (হাতে)', 'Cash', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-25 07:18:12', '2025-05-25 07:18:12', 1),
(70, 12, 'My Bank', 'Bank', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-25 07:18:12', '2025-05-25 07:18:12', 1),
(71, 12, 'বিকাশ', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-25 07:18:12', '2025-05-25 07:18:12', 1),
(72, 12, 'Nagad', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-25 07:18:12', '2025-05-25 07:18:12', 1),
(73, 12, 'Rocket', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-25 07:18:12', '2025-05-25 07:18:12', 1),
(74, 12, 'Others', 'Other', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-05-25 07:18:12', '2025-05-25 07:18:12', 1),
(75, 13, 'Cash In Hand (হাতে)', 'Cash', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-06-09 18:15:13', '2025-06-09 18:15:13', 1),
(76, 13, 'My Bank', 'Bank', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-06-09 18:15:13', '2025-06-09 18:15:13', 1),
(77, 13, 'বিকাশ', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-06-09 18:15:13', '2025-06-09 18:15:13', 1),
(78, 13, 'Nagad', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-06-09 18:15:13', '2025-06-09 18:15:13', 1),
(79, 13, 'Rocket', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-06-09 18:15:13', '2025-06-09 18:15:13', 1),
(80, 13, 'Others', 'Other', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-06-09 18:15:13', '2025-06-09 18:15:13', 1),
(81, 14, 'Cash In Hand (হাতে)', 'Cash', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-06-10 10:43:39', '2025-06-10 10:43:39', 1),
(82, 14, 'My Bank', 'Bank', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-06-10 10:43:39', '2025-06-10 10:43:39', 1),
(83, 14, 'বিকাশ', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-06-10 10:43:39', '2025-06-10 10:43:39', 1),
(84, 14, 'Nagad', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-06-10 10:43:39', '2025-06-10 10:43:39', 1),
(85, 14, 'Rocket', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-06-10 10:43:39', '2025-06-10 10:43:39', 1),
(86, 14, 'Others', 'Other', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-06-10 10:43:39', '2025-06-10 10:43:39', 1),
(87, 15, 'Cash In Hand (হাতে)', 'Cash', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-08-15 05:53:37', '2025-08-15 05:53:37', 1),
(88, 15, 'My Bank', 'Bank', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-08-15 05:53:37', '2025-08-15 05:53:37', 1),
(89, 15, 'বিকাশ', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-08-15 05:53:37', '2025-08-15 05:53:37', 1),
(90, 15, 'Nagad', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-08-15 05:53:37', '2025-08-15 05:53:37', 1),
(91, 15, 'Rocket', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-08-15 05:53:37', '2025-08-15 05:53:37', 1),
(92, 15, 'Others', 'Other', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-08-15 05:53:37', '2025-08-15 05:53:37', 1),
(93, 16, 'Cash In Hand (হাতে)', 'Cash', 0.00, 5888.00, NULL, NULL, NULL, NULL, '2025-09-03 17:13:54', '2025-09-04 19:50:37', 1),
(94, 16, 'My Bank', 'Bank', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-09-03 17:13:54', '2025-09-03 17:13:54', 1),
(95, 16, 'বিকাশ', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-09-03 17:13:54', '2025-09-03 17:13:54', 1),
(96, 16, 'Nagad', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-09-03 17:13:54', '2025-09-03 17:13:54', 1),
(97, 16, 'Rocket', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-09-03 17:13:54', '2025-09-03 17:13:54', 1),
(98, 16, 'Others', 'Other', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-09-03 17:13:54', '2025-09-03 17:13:54', 1),
(99, 17, 'Cash In Hand (হাতে)', 'Cash', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-09-12 23:10:57', '2025-09-12 23:10:57', 1),
(100, 17, 'My Bank', 'Bank', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-09-12 23:10:57', '2025-09-12 23:10:57', 1),
(101, 17, 'বিকাশ', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-09-12 23:10:57', '2025-09-12 23:10:57', 1),
(102, 17, 'Nagad', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-09-12 23:10:57', '2025-09-12 23:10:57', 1),
(103, 17, 'Rocket', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-09-12 23:10:57', '2025-09-12 23:10:57', 1),
(104, 17, 'Others', 'Other', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-09-12 23:10:57', '2025-09-12 23:10:57', 1),
(105, 18, 'Cash In Hand (হাতে)', 'Cash', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-09-14 13:27:50', '2025-09-14 13:27:50', 1),
(106, 18, 'My Bank', 'Bank', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-09-14 13:27:50', '2025-09-14 13:27:50', 1),
(107, 18, 'বিকাশ', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-09-14 13:27:50', '2025-09-14 13:27:50', 1),
(108, 18, 'Nagad', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-09-14 13:27:50', '2025-09-14 13:27:50', 1),
(109, 18, 'Rocket', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-09-14 13:27:50', '2025-09-14 13:27:50', 1),
(110, 18, 'Others', 'Other', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-09-14 13:27:50', '2025-09-14 13:27:50', 1),
(111, 19, 'Cash In Hand (হাতে)', 'Cash', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-10-06 22:35:25', '2025-10-06 22:35:25', 1),
(112, 19, 'My Bank', 'Bank', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-10-06 22:35:25', '2025-10-06 22:35:25', 1),
(113, 19, 'বিকাশ', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-10-06 22:35:25', '2025-10-06 22:35:25', 1),
(114, 19, 'Nagad', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-10-06 22:35:25', '2025-10-06 22:35:25', 1),
(115, 19, 'Rocket', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-10-06 22:35:25', '2025-10-06 22:35:25', 1),
(116, 19, 'Others', 'Other', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-10-06 22:35:25', '2025-10-06 22:35:25', 1),
(117, 20, 'Cash In Hand (হাতে)', 'Cash', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-10-21 07:38:37', '2025-10-21 07:38:37', 1),
(118, 20, 'My Bank', 'Bank', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-10-21 07:38:37', '2025-10-21 07:38:37', 1),
(119, 20, 'বিকাশ', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-10-21 07:38:37', '2025-10-21 07:38:37', 1),
(120, 20, 'Nagad', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-10-21 07:38:37', '2025-10-21 07:38:37', 1),
(121, 20, 'Rocket', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-10-21 07:38:37', '2025-10-21 07:38:37', 1),
(122, 20, 'Others', 'Other', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-10-21 07:38:37', '2025-10-21 07:38:37', 1),
(123, 21, 'Cash In Hand (হাতে)', 'Cash', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-11-06 23:12:58', '2025-11-06 23:12:58', 1),
(124, 21, 'My Bank', 'Bank', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-11-06 23:12:58', '2025-11-06 23:12:58', 1),
(125, 21, 'বিকাশ', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-11-06 23:12:58', '2025-11-06 23:12:58', 1),
(126, 21, 'Nagad', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-11-06 23:12:58', '2025-11-06 23:12:58', 1),
(127, 21, 'Rocket', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-11-06 23:12:58', '2025-11-06 23:12:58', 1),
(128, 21, 'Others', 'Other', 0.00, 0.00, NULL, NULL, NULL, NULL, '2025-11-06 23:12:58', '2025-11-06 23:12:58', 1),
(129, 22, 'Cash In Hand (হাতে)', 'Cash', 0.00, 0.00, NULL, NULL, NULL, NULL, '2026-01-18 18:56:38', '2026-01-18 18:56:38', 1),
(130, 22, 'My Bank', 'Bank', 0.00, 0.00, NULL, NULL, NULL, NULL, '2026-01-18 18:56:38', '2026-01-18 18:56:38', 1),
(131, 22, 'বিকাশ', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2026-01-18 18:56:38', '2026-01-18 18:56:38', 1),
(132, 22, 'Nagad', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2026-01-18 18:56:38', '2026-01-18 18:56:38', 1),
(133, 22, 'Rocket', 'Mobile Banking', 0.00, 0.00, NULL, NULL, NULL, NULL, '2026-01-18 18:56:38', '2026-01-18 18:56:38', 1),
(134, 22, 'Others', 'Other', 0.00, 0.00, NULL, NULL, NULL, NULL, '2026-01-18 18:56:38', '2026-01-18 18:56:38', 1),
(135, 3, 'Bongo BaaT', 'Cash', 2.00, 2.00, NULL, NULL, NULL, NULL, '2026-01-26 15:14:06', '2026-01-26 15:14:06', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('amarkhata_cache_0ade7c2cf97f75d009975f4d720d1fa6c19f4897', 'i:1;', 1747247410),
('amarkhata_cache_0ade7c2cf97f75d009975f4d720d1fa6c19f4897:timer', 'i:1747247410;', 1747247410),
('amarkhata_cache_1574bddb75c78a6fd2251d61e2993b5146201319', 'i:1;', 1763466770),
('amarkhata_cache_1574bddb75c78a6fd2251d61e2993b5146201319:timer', 'i:1763466770;', 1763466770),
('amarkhata_cache_472b07b9fcf2c2451e8781e944bf5f77cd8457c8', 'i:2;', 1762470842),
('amarkhata_cache_472b07b9fcf2c2451e8781e944bf5f77cd8457c8:timer', 'i:1762470842;', 1762470842),
('amarkhata_cache_77de68daecd823babbb58edb1c8e14d7106e83bb', 'i:2;', 1746994156),
('amarkhata_cache_77de68daecd823babbb58edb1c8e14d7106e83bb:timer', 'i:1746994156;', 1746994156),
('amarkhata_cache_7b52009b64fd0a2a49e6d8a939753077792b0554', 'i:1;', 1748164508),
('amarkhata_cache_7b52009b64fd0a2a49e6d8a939753077792b0554:timer', 'i:1748164508;', 1748164508),
('amarkhata_cache_ac3478d69a3c81fa62e60f5c3696165a4e5e6ac4', 'i:4;', 1746990082),
('amarkhata_cache_ac3478d69a3c81fa62e60f5c3696165a4e5e6ac4:timer', 'i:1746990082;', 1746990082),
('amarkhata_cache_translation_bn_Dashboard', 's:9:\"Dashboard\";', 1769526705);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `user_id`, `name`, `type`, `color`, `icon`, `is_default`, `created_at`, `updated_at`) VALUES
(2, 1, 'Freelancing', 'income', '#337DFF', 'fa-laptop', 1, '2025-05-11 04:58:32', '2025-05-11 04:58:32'),
(4, 1, 'Transportation', 'expense', '#337DFF', 'fa-car', 1, '2025-05-11 04:58:32', '2025-05-11 04:58:32'),
(5, 1, 'Salary', 'income', '#28a745', 'fas fa-money-bill-wave', 1, '2025-05-11 04:58:45', '2025-05-11 04:58:45'),
(6, 1, 'Bonus', 'income', '#17a2b8', 'fas fa-gift', 1, '2025-05-11 04:58:45', '2025-05-11 04:58:45'),
(7, 1, 'Rent', 'income', '#6610f2', 'fas fa-home', 1, '2025-05-11 04:58:45', '2025-05-11 04:58:45'),
(8, 1, 'Sales', 'income', '#fd7e14', 'fas fa-shopping-cart', 1, '2025-05-11 04:58:45', '2025-05-11 04:58:45'),
(9, 1, 'Profit', 'income', '#20c997', 'fas fa-chart-line', 1, '2025-05-11 04:58:45', '2025-05-11 04:58:45'),
(10, 1, 'Others', 'income', '#6c757d', 'fas fa-ellipsis-h', 1, '2025-05-11 04:58:45', '2025-05-11 04:58:45'),
(11, 1, 'Food', 'expense', '#dc3545', 'fas fa-utensils', 1, '2025-05-11 04:58:45', '2025-05-11 04:58:45'),
(12, 1, 'Transport', 'expense', '#fd7e14', 'fas fa-bus', 1, '2025-05-11 04:58:45', '2025-05-11 04:58:45'),
(13, 1, 'Bills', 'expense', '#6610f2', 'fas fa-file-invoice', 1, '2025-05-11 04:58:45', '2025-05-11 04:58:45'),
(14, 1, 'Medical', 'expense', '#17a2b8', 'fas fa-pills', 1, '2025-05-11 04:58:45', '2025-05-11 04:58:45'),
(15, 1, 'Clothing', 'expense', '#20c997', 'fas fa-tshirt', 1, '2025-05-11 04:58:45', '2025-05-11 04:58:45'),
(16, 1, 'Education', 'expense', '#28a745', 'fas fa-graduation-cap', 1, '2025-05-11 04:58:45', '2025-05-11 04:58:45'),
(17, 1, 'Entertainment', 'expense', '#e83e8c', 'fas fa-film', 1, '2025-05-11 04:58:45', '2025-05-11 04:58:45'),
(18, 1, 'Others', 'expense', '#6c757d', 'fas fa-ellipsis-h', 1, '2025-05-11 04:58:45', '2025-05-11 04:58:45'),
(47, 4, 'বেতন', 'income', '#4CAF50', 'fa-money-bill', 1, '2025-05-11 16:10:19', '2025-05-11 16:10:19'),
(48, 4, 'বোনাস', 'income', '#8BC34A', 'fa-gift', 1, '2025-05-11 16:10:19', '2025-05-11 16:10:19'),
(49, 4, 'বিক্রয়', 'income', '#009688', 'fa-shopping-cart', 1, '2025-05-11 16:10:19', '2025-05-11 16:10:19'),
(50, 4, 'অন্যান্য আয়', 'income', '#607D8B', 'fa-plus-circle', 1, '2025-05-11 16:10:19', '2025-05-11 16:10:19'),
(51, 4, 'খাবার', 'expense', '#F44336', 'fa-utensils', 1, '2025-05-11 16:10:19', '2025-05-11 16:10:19'),
(52, 4, 'পরিবহন', 'expense', '#FF9800', 'fa-bus', 1, '2025-05-11 16:10:19', '2025-05-11 16:10:19'),
(53, 4, 'শিক্ষা', 'expense', '#3F51B5', 'fa-book', 1, '2025-05-11 16:10:19', '2025-05-11 16:10:19'),
(54, 4, 'অন্যান্য ব্যয়', 'expense', '#9C27B0', 'fa-minus-circle', 1, '2025-05-11 16:10:19', '2025-05-11 16:10:19'),
(55, 5, 'বেতন', 'income', '#4CAF50', 'fa-money-bill', 1, '2025-05-11 17:12:24', '2025-05-11 17:12:24'),
(56, 5, 'বোনাস', 'income', '#8BC34A', 'fa-gift', 1, '2025-05-11 17:12:24', '2025-05-11 17:12:24'),
(57, 5, 'বিক্রয়', 'income', '#009688', 'fa-shopping-cart', 1, '2025-05-11 17:12:24', '2025-05-11 17:12:24'),
(58, 5, 'অন্যান্য আয়', 'income', '#607D8B', 'fa-plus-circle', 1, '2025-05-11 17:12:24', '2025-05-11 17:12:24'),
(59, 5, 'খাবার', 'expense', '#F44336', 'fa-utensils', 1, '2025-05-11 17:12:24', '2025-05-11 17:12:24'),
(60, 5, 'পরিবহন', 'expense', '#FF9800', 'fa-bus', 1, '2025-05-11 17:12:24', '2025-05-11 17:12:24'),
(61, 5, 'শিক্ষা', 'expense', '#3F51B5', 'fa-book', 1, '2025-05-11 17:12:24', '2025-05-11 17:12:24'),
(62, 5, 'অন্যান্য ব্যয়', 'expense', '#9C27B0', 'fa-minus-circle', 1, '2025-05-11 17:12:24', '2025-05-11 17:12:24'),
(63, 6, 'বেতন', 'income', '#4CAF50', 'fa-money-bill', 1, '2025-05-11 20:20:35', '2025-05-11 20:20:35'),
(64, 6, 'বোনাস', 'income', '#8BC34A', 'fa-gift', 1, '2025-05-11 20:20:35', '2025-05-11 20:20:35'),
(65, 6, 'বিক্রয়', 'income', '#009688', 'fa-shopping-cart', 1, '2025-05-11 20:20:35', '2025-05-11 20:20:35'),
(66, 6, 'অন্যান্য আয়', 'income', '#607D8B', 'fa-plus-circle', 1, '2025-05-11 20:20:35', '2025-05-11 20:20:35'),
(67, 6, 'খাবার', 'expense', '#F44336', 'fa-utensils', 1, '2025-05-11 20:20:35', '2025-05-11 20:20:35'),
(68, 6, 'পরিবহন', 'expense', '#FF9800', 'fa-bus', 1, '2025-05-11 20:20:35', '2025-05-11 20:20:35'),
(69, 6, 'শিক্ষা', 'expense', '#3F51B5', 'fa-book', 1, '2025-05-11 20:20:35', '2025-05-11 20:20:35'),
(70, 6, 'অন্যান্য ব্যয়', 'expense', '#9C27B0', 'fa-minus-circle', 1, '2025-05-11 20:20:35', '2025-05-11 20:20:35'),
(71, 7, 'বেতন', 'income', '#4CAF50', 'fa-money-bill', 1, '2025-05-12 09:15:22', '2025-05-12 09:15:22'),
(72, 7, 'বোনাস', 'income', '#8BC34A', 'fa-gift', 1, '2025-05-12 09:15:22', '2025-05-12 09:15:22'),
(73, 7, 'বিক্রয়', 'income', '#009688', 'fa-shopping-cart', 1, '2025-05-12 09:15:22', '2025-05-12 09:15:22'),
(74, 7, 'অন্যান্য আয়', 'income', '#607D8B', 'fa-plus-circle', 1, '2025-05-12 09:15:22', '2025-05-12 09:15:22'),
(75, 7, 'খাবার', 'expense', '#F44336', 'fa-utensils', 1, '2025-05-12 09:15:22', '2025-05-12 09:15:22'),
(76, 7, 'পরিবহন', 'expense', '#FF9800', 'fa-bus', 1, '2025-05-12 09:15:22', '2025-05-12 09:15:22'),
(77, 7, 'শিক্ষা', 'expense', '#3F51B5', 'fa-book', 1, '2025-05-12 09:15:22', '2025-05-12 09:15:22'),
(78, 7, 'অন্যান্য ব্যয়', 'expense', '#9C27B0', 'fa-minus-circle', 1, '2025-05-12 09:15:22', '2025-05-12 09:15:22'),
(80, 8, 'বেতন', 'income', '#4CAF50', 'fa-money-bill', 1, '2025-05-13 16:56:30', '2025-05-13 16:56:30'),
(81, 8, 'বোনাস', 'income', '#8BC34A', 'fa-gift', 1, '2025-05-13 16:56:30', '2025-05-13 16:56:30'),
(82, 8, 'বিক্রয়', 'income', '#009688', 'fa-shopping-cart', 1, '2025-05-13 16:56:30', '2025-05-13 16:56:30'),
(83, 8, 'অন্যান্য আয়', 'income', '#607D8B', 'fa-plus-circle', 1, '2025-05-13 16:56:30', '2025-05-13 16:56:30'),
(84, 8, 'খাবার', 'expense', '#F44336', 'fa-utensils', 1, '2025-05-13 16:56:30', '2025-05-13 16:56:30'),
(85, 8, 'পরিবহন', 'expense', '#FF9800', 'fa-bus', 1, '2025-05-13 16:56:30', '2025-05-13 16:56:30'),
(86, 8, 'শিক্ষা', 'expense', '#3F51B5', 'fa-book', 1, '2025-05-13 16:56:30', '2025-05-13 16:56:30'),
(87, 8, 'অন্যান্য ব্যয়', 'expense', '#9C27B0', 'fa-minus-circle', 1, '2025-05-13 16:56:30', '2025-05-13 16:56:30'),
(88, 5, 'Student', 'income', '#e4be06', 'fa-graduation-cap', 0, '2025-05-13 18:48:05', '2025-05-13 18:48:05'),
(93, 9, 'বেতন', 'income', '#4CAF50', 'fa-money-bill', 1, '2025-05-14 18:29:07', '2025-05-14 18:29:07'),
(94, 9, 'বোনাস', 'income', '#8BC34A', 'fa-gift', 1, '2025-05-14 18:29:07', '2025-05-14 18:29:07'),
(95, 9, 'বিক্রয়', 'income', '#009688', 'fa-shopping-cart', 1, '2025-05-14 18:29:07', '2025-05-14 18:29:07'),
(96, 9, 'অন্যান্য আয়', 'income', '#607D8B', 'fa-plus-circle', 1, '2025-05-14 18:29:07', '2025-05-14 18:29:07'),
(97, 9, 'খাবার', 'expense', '#F44336', 'fa-utensils', 1, '2025-05-14 18:29:07', '2025-05-14 18:29:07'),
(98, 9, 'পরিবহন', 'expense', '#FF9800', 'fa-bus', 1, '2025-05-14 18:29:07', '2025-05-14 18:29:07'),
(99, 9, 'শিক্ষা', 'expense', '#3F51B5', 'fa-book', 1, '2025-05-14 18:29:07', '2025-05-14 18:29:07'),
(100, 9, 'অন্যান্য ব্যয়', 'expense', '#9C27B0', 'fa-minus-circle', 1, '2025-05-14 18:29:07', '2025-05-14 18:29:07'),
(101, 10, 'বেতন', 'income', '#4CAF50', 'fa-money-bill', 1, '2025-05-18 15:10:01', '2025-05-18 15:10:01'),
(102, 10, 'বোনাস', 'income', '#8BC34A', 'fa-gift', 1, '2025-05-18 15:10:01', '2025-05-18 15:10:01'),
(103, 10, 'বিক্রয়', 'income', '#009688', 'fa-shopping-cart', 1, '2025-05-18 15:10:01', '2025-05-18 15:10:01'),
(104, 10, 'অন্যান্য আয়', 'income', '#607D8B', 'fa-plus-circle', 1, '2025-05-18 15:10:01', '2025-05-18 15:10:01'),
(105, 10, 'খাবার', 'expense', '#F44336', 'fa-utensils', 1, '2025-05-18 15:10:01', '2025-05-18 15:10:01'),
(106, 10, 'পরিবহন', 'expense', '#FF9800', 'fa-bus', 1, '2025-05-18 15:10:01', '2025-05-18 15:10:01'),
(107, 10, 'শিক্ষা', 'expense', '#3F51B5', 'fa-book', 1, '2025-05-18 15:10:01', '2025-05-18 15:10:01'),
(108, 10, 'অন্যান্য ব্যয়', 'expense', '#9C27B0', 'fa-minus-circle', 1, '2025-05-18 15:10:01', '2025-05-18 15:10:01'),
(109, 11, 'বেতন', 'income', '#4CAF50', 'fa-money-bill', 1, '2025-05-24 09:53:13', '2025-05-24 09:53:13'),
(110, 11, 'বোনাস', 'income', '#8BC34A', 'fa-gift', 1, '2025-05-24 09:53:13', '2025-05-24 09:53:13'),
(111, 11, 'বিক্রয়', 'income', '#009688', 'fa-shopping-cart', 1, '2025-05-24 09:53:13', '2025-05-24 09:53:13'),
(112, 11, 'অন্যান্য আয়', 'income', '#607D8B', 'fa-plus-circle', 1, '2025-05-24 09:53:13', '2025-05-24 09:53:13'),
(113, 11, 'খাবার', 'expense', '#F44336', 'fa-utensils', 1, '2025-05-24 09:53:13', '2025-05-24 09:53:13'),
(114, 11, 'পরিবহন', 'expense', '#FF9800', 'fa-bus', 1, '2025-05-24 09:53:13', '2025-05-24 09:53:13'),
(115, 11, 'শিক্ষা', 'expense', '#3F51B5', 'fa-book', 1, '2025-05-24 09:53:13', '2025-05-24 09:53:13'),
(116, 11, 'অন্যান্য ব্যয়', 'expense', '#9C27B0', 'fa-minus-circle', 1, '2025-05-24 09:53:13', '2025-05-24 09:53:13'),
(117, 12, 'বেতন', 'income', '#4CAF50', 'fa-money-bill', 1, '2025-05-25 07:18:12', '2025-05-25 07:18:12'),
(118, 12, 'বোনাস', 'income', '#8BC34A', 'fa-gift', 1, '2025-05-25 07:18:12', '2025-05-25 07:18:12'),
(119, 12, 'বিক্রয়', 'income', '#009688', 'fa-shopping-cart', 1, '2025-05-25 07:18:12', '2025-05-25 07:18:12'),
(120, 12, 'অন্যান্য আয়', 'income', '#607D8B', 'fa-plus-circle', 1, '2025-05-25 07:18:12', '2025-05-25 07:18:12'),
(121, 12, 'খাবার', 'expense', '#F44336', 'fa-utensils', 1, '2025-05-25 07:18:12', '2025-05-25 07:18:12'),
(122, 12, 'পরিবহন', 'expense', '#FF9800', 'fa-bus', 1, '2025-05-25 07:18:12', '2025-05-25 07:18:12'),
(123, 12, 'শিক্ষা', 'expense', '#3F51B5', 'fa-book', 1, '2025-05-25 07:18:12', '2025-05-25 07:18:12'),
(124, 12, 'অন্যান্য ব্যয়', 'expense', '#9C27B0', 'fa-minus-circle', 1, '2025-05-25 07:18:12', '2025-05-25 07:18:12'),
(125, 13, 'বেতন', 'income', '#4CAF50', 'fa-money-bill', 1, '2025-06-09 18:15:13', '2025-06-09 18:15:13'),
(126, 13, 'বোনাস', 'income', '#8BC34A', 'fa-gift', 1, '2025-06-09 18:15:13', '2025-06-09 18:15:13'),
(127, 13, 'বিক্রয়', 'income', '#009688', 'fa-shopping-cart', 1, '2025-06-09 18:15:13', '2025-06-09 18:15:13'),
(128, 13, 'অন্যান্য আয়', 'income', '#607D8B', 'fa-plus-circle', 1, '2025-06-09 18:15:13', '2025-06-09 18:15:13'),
(129, 13, 'খাবার', 'expense', '#F44336', 'fa-utensils', 1, '2025-06-09 18:15:13', '2025-06-09 18:15:13'),
(130, 13, 'পরিবহন', 'expense', '#FF9800', 'fa-bus', 1, '2025-06-09 18:15:13', '2025-06-09 18:15:13'),
(131, 13, 'শিক্ষা', 'expense', '#3F51B5', 'fa-book', 1, '2025-06-09 18:15:13', '2025-06-09 18:15:13'),
(132, 13, 'অন্যান্য ব্যয়', 'expense', '#9C27B0', 'fa-minus-circle', 1, '2025-06-09 18:15:13', '2025-06-09 18:15:13'),
(133, 14, 'বেতন', 'income', '#4CAF50', 'fa-money-bill', 1, '2025-06-10 10:43:39', '2025-06-10 10:43:39'),
(134, 14, 'বোনাস', 'income', '#8BC34A', 'fa-gift', 1, '2025-06-10 10:43:39', '2025-06-10 10:43:39'),
(135, 14, 'বিক্রয়', 'income', '#009688', 'fa-shopping-cart', 1, '2025-06-10 10:43:39', '2025-06-10 10:43:39'),
(136, 14, 'অন্যান্য আয়', 'income', '#607D8B', 'fa-plus-circle', 1, '2025-06-10 10:43:39', '2025-06-10 10:43:39'),
(137, 14, 'খাবার', 'expense', '#F44336', 'fa-utensils', 1, '2025-06-10 10:43:39', '2025-06-10 10:43:39'),
(138, 14, 'পরিবহন', 'expense', '#FF9800', 'fa-bus', 1, '2025-06-10 10:43:39', '2025-06-10 10:43:39'),
(139, 14, 'শিক্ষা', 'expense', '#3F51B5', 'fa-book', 1, '2025-06-10 10:43:39', '2025-06-10 10:43:39'),
(140, 14, 'অন্যান্য ব্যয়', 'expense', '#9C27B0', 'fa-minus-circle', 1, '2025-06-10 10:43:39', '2025-06-10 10:43:39'),
(141, 15, 'বেতন', 'income', '#4CAF50', 'fa-money-bill', 1, '2025-08-15 05:53:37', '2025-08-15 05:53:37'),
(142, 15, 'বোনাস', 'income', '#8BC34A', 'fa-gift', 1, '2025-08-15 05:53:37', '2025-08-15 05:53:37'),
(143, 15, 'বিক্রয়', 'income', '#009688', 'fa-shopping-cart', 1, '2025-08-15 05:53:37', '2025-08-15 05:53:37'),
(144, 15, 'অন্যান্য আয়', 'income', '#607D8B', 'fa-plus-circle', 1, '2025-08-15 05:53:37', '2025-08-15 05:53:37'),
(145, 15, 'খাবার', 'expense', '#F44336', 'fa-utensils', 1, '2025-08-15 05:53:37', '2025-08-15 05:53:37'),
(146, 15, 'পরিবহন', 'expense', '#FF9800', 'fa-bus', 1, '2025-08-15 05:53:37', '2025-08-15 05:53:37'),
(147, 15, 'শিক্ষা', 'expense', '#3F51B5', 'fa-book', 1, '2025-08-15 05:53:37', '2025-08-15 05:53:37'),
(148, 15, 'অন্যান্য ব্যয়', 'expense', '#9C27B0', 'fa-minus-circle', 1, '2025-08-15 05:53:37', '2025-08-15 05:53:37'),
(149, 16, 'বেতন', 'income', '#4CAF50', 'fa-money-bill', 1, '2025-09-03 17:13:54', '2025-09-03 17:13:54'),
(150, 16, 'বোনাস', 'income', '#8BC34A', 'fa-gift', 1, '2025-09-03 17:13:54', '2025-09-03 17:13:54'),
(151, 16, 'বিক্রয়', 'income', '#009688', 'fa-shopping-cart', 1, '2025-09-03 17:13:54', '2025-09-03 17:13:54'),
(152, 16, 'অন্যান্য আয়', 'income', '#607D8B', 'fa-plus-circle', 1, '2025-09-03 17:13:54', '2025-09-03 17:13:54'),
(153, 16, 'খাবার', 'expense', '#F44336', 'fa-utensils', 1, '2025-09-03 17:13:54', '2025-09-03 17:13:54'),
(154, 16, 'পরিবহন', 'expense', '#FF9800', 'fa-bus', 1, '2025-09-03 17:13:54', '2025-09-03 17:13:54'),
(155, 16, 'শিক্ষা', 'expense', '#3F51B5', 'fa-book', 1, '2025-09-03 17:13:54', '2025-09-03 17:13:54'),
(156, 16, 'অন্যান্য ব্যয়', 'expense', '#9C27B0', 'fa-minus-circle', 1, '2025-09-03 17:13:54', '2025-09-03 17:13:54'),
(157, 16, 'Ccc', 'income', '#4CAF50', 'fa-money-bill', 0, '2025-09-04 19:50:37', '2025-09-04 19:50:37'),
(158, 17, 'বেতন', 'income', '#4CAF50', 'fa-money-bill', 1, '2025-09-12 23:10:57', '2025-09-12 23:10:57'),
(159, 17, 'বোনাস', 'income', '#8BC34A', 'fa-gift', 1, '2025-09-12 23:10:57', '2025-09-12 23:10:57'),
(160, 17, 'বিক্রয়', 'income', '#009688', 'fa-shopping-cart', 1, '2025-09-12 23:10:57', '2025-09-12 23:10:57'),
(161, 17, 'অন্যান্য আয়', 'income', '#607D8B', 'fa-plus-circle', 1, '2025-09-12 23:10:57', '2025-09-12 23:10:57'),
(162, 17, 'খাবার', 'expense', '#F44336', 'fa-utensils', 1, '2025-09-12 23:10:57', '2025-09-12 23:10:57'),
(163, 17, 'পরিবহন', 'expense', '#FF9800', 'fa-bus', 1, '2025-09-12 23:10:57', '2025-09-12 23:10:57'),
(164, 17, 'শিক্ষা', 'expense', '#3F51B5', 'fa-book', 1, '2025-09-12 23:10:57', '2025-09-12 23:10:57'),
(165, 17, 'অন্যান্য ব্যয়', 'expense', '#9C27B0', 'fa-minus-circle', 1, '2025-09-12 23:10:57', '2025-09-12 23:10:57'),
(166, 18, 'বেতন', 'income', '#4CAF50', 'fa-money-bill', 1, '2025-09-14 13:27:50', '2025-09-14 13:27:50'),
(167, 18, 'বোনাস', 'income', '#8BC34A', 'fa-gift', 1, '2025-09-14 13:27:50', '2025-09-14 13:27:50'),
(168, 18, 'বিক্রয়', 'income', '#009688', 'fa-shopping-cart', 1, '2025-09-14 13:27:50', '2025-09-14 13:27:50'),
(169, 18, 'অন্যান্য আয়', 'income', '#607D8B', 'fa-plus-circle', 1, '2025-09-14 13:27:50', '2025-09-14 13:27:50'),
(170, 18, 'খাবার', 'expense', '#F44336', 'fa-utensils', 1, '2025-09-14 13:27:50', '2025-09-14 13:27:50'),
(171, 18, 'পরিবহন', 'expense', '#FF9800', 'fa-bus', 1, '2025-09-14 13:27:50', '2025-09-14 13:27:50'),
(172, 18, 'শিক্ষা', 'expense', '#3F51B5', 'fa-book', 1, '2025-09-14 13:27:50', '2025-09-14 13:27:50'),
(173, 18, 'অন্যান্য ব্যয়', 'expense', '#9C27B0', 'fa-minus-circle', 1, '2025-09-14 13:27:50', '2025-09-14 13:27:50'),
(174, 19, 'বেতন', 'income', '#4CAF50', 'fa-money-bill', 1, '2025-10-06 22:35:25', '2025-10-06 22:35:25'),
(175, 19, 'বোনাস', 'income', '#8BC34A', 'fa-gift', 1, '2025-10-06 22:35:25', '2025-10-06 22:35:25'),
(176, 19, 'বিক্রয়', 'income', '#009688', 'fa-shopping-cart', 1, '2025-10-06 22:35:25', '2025-10-06 22:35:25'),
(177, 19, 'অন্যান্য আয়', 'income', '#607D8B', 'fa-plus-circle', 1, '2025-10-06 22:35:25', '2025-10-06 22:35:25'),
(178, 19, 'খাবার', 'expense', '#F44336', 'fa-utensils', 1, '2025-10-06 22:35:25', '2025-10-06 22:35:25'),
(179, 19, 'পরিবহন', 'expense', '#FF9800', 'fa-bus', 1, '2025-10-06 22:35:25', '2025-10-06 22:35:25'),
(180, 19, 'শিক্ষা', 'expense', '#3F51B5', 'fa-book', 1, '2025-10-06 22:35:25', '2025-10-06 22:35:25'),
(181, 19, 'অন্যান্য ব্যয়', 'expense', '#9C27B0', 'fa-minus-circle', 1, '2025-10-06 22:35:25', '2025-10-06 22:35:25'),
(182, 20, 'বেতন', 'income', '#4CAF50', 'fa-money-bill', 1, '2025-10-21 07:38:37', '2025-10-21 07:38:37'),
(183, 20, 'বোনাস', 'income', '#8BC34A', 'fa-gift', 1, '2025-10-21 07:38:37', '2025-10-21 07:38:37'),
(184, 20, 'বিক্রয়', 'income', '#009688', 'fa-shopping-cart', 1, '2025-10-21 07:38:37', '2025-10-21 07:38:37'),
(185, 20, 'অন্যান্য আয়', 'income', '#607D8B', 'fa-plus-circle', 1, '2025-10-21 07:38:37', '2025-10-21 07:38:37'),
(186, 20, 'খাবার', 'expense', '#F44336', 'fa-utensils', 1, '2025-10-21 07:38:37', '2025-10-21 07:38:37'),
(187, 20, 'পরিবহন', 'expense', '#FF9800', 'fa-bus', 1, '2025-10-21 07:38:37', '2025-10-21 07:38:37'),
(188, 20, 'শিক্ষা', 'expense', '#3F51B5', 'fa-book', 1, '2025-10-21 07:38:37', '2025-10-21 07:38:37'),
(189, 20, 'অন্যান্য ব্যয়', 'expense', '#9C27B0', 'fa-minus-circle', 1, '2025-10-21 07:38:37', '2025-10-21 07:38:37'),
(190, 21, 'বেতন', 'income', '#4CAF50', 'fa-money-bill', 1, '2025-11-06 23:12:58', '2025-11-06 23:12:58'),
(191, 21, 'বোনাস', 'income', '#8BC34A', 'fa-gift', 1, '2025-11-06 23:12:58', '2025-11-06 23:12:58'),
(192, 21, 'বিক্রয়', 'income', '#009688', 'fa-shopping-cart', 1, '2025-11-06 23:12:58', '2025-11-06 23:12:58'),
(193, 21, 'অন্যান্য আয়', 'income', '#607D8B', 'fa-plus-circle', 1, '2025-11-06 23:12:58', '2025-11-06 23:12:58'),
(194, 21, 'খাবার', 'expense', '#F44336', 'fa-utensils', 1, '2025-11-06 23:12:58', '2025-11-06 23:12:58'),
(195, 21, 'পরিবহন', 'expense', '#FF9800', 'fa-bus', 1, '2025-11-06 23:12:58', '2025-11-06 23:12:58'),
(196, 21, 'শিক্ষা', 'expense', '#3F51B5', 'fa-book', 1, '2025-11-06 23:12:58', '2025-11-06 23:12:58'),
(197, 21, 'অন্যান্য ব্যয়', 'expense', '#9C27B0', 'fa-minus-circle', 1, '2025-11-06 23:12:58', '2025-11-06 23:12:58'),
(198, 22, 'বেতন', 'income', '#4CAF50', 'fa-money-bill', 1, '2026-01-18 18:56:38', '2026-01-18 18:56:38'),
(199, 22, 'বোনাস', 'income', '#8BC34A', 'fa-gift', 1, '2026-01-18 18:56:38', '2026-01-18 18:56:38'),
(200, 22, 'বিক্রয়', 'income', '#009688', 'fa-shopping-cart', 1, '2026-01-18 18:56:38', '2026-01-18 18:56:38'),
(201, 22, 'অন্যান্য আয়', 'income', '#607D8B', 'fa-plus-circle', 1, '2026-01-18 18:56:38', '2026-01-18 18:56:38'),
(202, 22, 'খাবার', 'expense', '#F44336', 'fa-utensils', 1, '2026-01-18 18:56:38', '2026-01-18 18:56:38'),
(203, 22, 'পরিবহন', 'expense', '#FF9800', 'fa-bus', 1, '2026-01-18 18:56:38', '2026-01-18 18:56:38'),
(204, 22, 'শিক্ষা', 'expense', '#3F51B5', 'fa-book', 1, '2026-01-18 18:56:38', '2026-01-18 18:56:38'),
(205, 22, 'অন্যান্য ব্যয়', 'expense', '#9C27B0', 'fa-minus-circle', 1, '2026-01-18 18:56:38', '2026-01-18 18:56:38');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `person_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `remaining` decimal(10,2) NOT NULL DEFAULT 0.00,
  `due_date` date DEFAULT NULL,
  `note` text DEFAULT NULL,
  `is_settled` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `user_id`, `person_name`, `type`, `amount`, `remaining`, `due_date`, `note`, `is_settled`, `created_at`, `updated_at`) VALUES
(2, 8, 'Robin', 'Given', 50.00, 0.00, '2025-05-13', NULL, 0, '2025-05-13 16:58:32', '2025-05-13 16:58:32'),
(3, 9, 'Amin', 'Given', 200.00, 0.00, NULL, NULL, 0, '2025-05-14 18:32:00', '2025-05-14 18:32:00'),
(4, 12, 'Arafat', 'Taken', 6000.00, 0.00, NULL, NULL, 0, '2025-05-25 09:17:24', '2025-05-25 09:17:24');

-- --------------------------------------------------------

--
-- Table structure for table `loan_payments`
--

CREATE TABLE `loan_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_05_05_155951_create_accounts_table', 1),
(5, '2025_05_05_160002_create_transactions_table', 1),
(6, '2025_05_05_160015_create_categories_table', 1),
(7, '2025_05_05_160023_create_loans_table', 1),
(8, '2025_05_05_160031_create_languages_table', 1),
(9, '2025_05_06_141813_create_categories_test_table', 1),
(10, '2025_05_10_072851_update_categories_to_bangla', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('21imranbd@gmail.com', '$2y$12$o139DCYJKfbGkKjNR.zPB.WGpSNYfmA7VRdBYI4lQXcnxWHralUA6', '2025-05-11 20:08:46');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('65jrbelxv6ji0WCkTZlzI5MNXc1DLTCPOpGWUi1v', NULL, '66.249.68.134', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSE5Zb2RBNnpFRWU3ZnZzc2hlWGVUOTdjVnk3SjVqS280ZWhFMzRmaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vYW1hcmtoYXRhLmJsb2cvcHJpdmFjeS1wb2xpY3kiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1769941632),
('BoXjp467Lt9Hv4qV7YbEIxvvfxSDY6DqM97NDeSp', NULL, '66.249.68.35', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVWlBdlhZR3JORm9VY3FVZVVobkxtWWxLZWFPeGRuVjRPU2VaSnhOYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vd3d3LmFtYXJraGF0YS5ibG9nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1769953640),
('IvhJV7TqnVDhwYG5xwvuopkUgVYVp6AYZzRlf5W1', NULL, '2001:41d0:a:4429::1', 'Mozilla/5.0 (compatible; OpenEASM/1.0)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR2Q0bkhJczVwd3kwS1drRnhhRlpoOTN2ZWNDNWFYcmwwalY5WVJYeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vYW1hcmtoYXRhLmJsb2ciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1769925232),
('M6ukkuo5TKEM8ZNsJnMO7KGyOVi4DZCBxryoqnbX', NULL, '202.76.141.25', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.2.15) Gecko/20110303 Ubuntu/10.04 (lucid) Firefox/3.6.15 FirePHP/0.5', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidzZxcVF6Y1ZZdVJJTDFHTmxrZldnUXNTMzJqWGFlMWtFcTFLZGRGWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vYW1hcmtoYXRhLmJsb2ciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1769937782),
('Oeb1RxvT8VYWJn0uyb8UnY1S3ZDAeZ9eHqf4FyTJ', NULL, '138.197.137.54', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ2RQQXF4VDdBcmpmWWhUYjVTWjhhN3FCSFhzRElLT0UxUWx4RzNxdyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vYW1hcmtoYXRhLmJsb2ciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1769910534),
('Ten27Tt3aJMHtWNoMb06oB9RmYx0TNU7RudU1vOK', NULL, '66.249.68.35', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMllsYmFJdmRIemlGazhQeGVWU0ZJMGRQNXJhaHRmZnNESjJOTm54VyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vd3d3LmFtYXJraGF0YS5ibG9nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1769950198),
('wlkOGLvLyrDdWvwPfNyIMhqObfL4V4NvSjrwtKed', NULL, '2a02:4780:3:1::3', 'Go-http-client/2.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiR2xaRnU2SVE1b0VJMkZVZU9TM0ZvbDYxdGVPZHNwb0ZPbUpHVDluUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1769908445);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `type` varchar(255) NOT NULL,
  `transfer_to_account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `note` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `account_id`, `category_id`, `amount`, `type`, `transfer_to_account_id`, `date`, `note`, `attachment`, `created_at`, `updated_at`) VALUES
(3, 8, 43, 80, 700.00, 'income', NULL, '2025-05-13', NULL, NULL, '2025-05-13 16:58:01', '2025-05-13 16:58:01'),
(4, 5, 49, 58, 110150.00, 'income', NULL, '2025-05-14', 'Bank er maddhome', NULL, '2025-05-13 18:46:09', '2025-05-13 18:46:09'),
(10, 5, 49, 62, 100582.00, 'expense', NULL, '2025-05-14', '3may tarkh obdi sokol taka', NULL, '2025-05-13 19:04:48', '2025-05-13 19:04:48'),
(11, 5, 49, 62, 20000.00, 'expense', NULL, '2025-05-14', 'Aunty k taka pathaichi', NULL, '2025-05-13 19:06:59', '2025-05-13 19:06:59'),
(12, 5, 49, 62, 250.00, 'expense', NULL, '2025-05-14', 'Himeler bow er MB', NULL, '2025-05-13 19:09:34', '2025-05-13 19:09:34'),
(13, 5, 49, 62, 6200.00, 'expense', NULL, '2025-05-14', 'Boi kenar jonne', NULL, '2025-05-13 19:09:53', '2025-05-13 19:09:53'),
(14, 5, 49, 62, 1500.00, 'expense', NULL, '2025-05-14', 'Ads fee', NULL, '2025-05-13 19:10:10', '2025-05-13 19:10:10'),
(15, 5, 49, 62, 1000.00, 'expense', NULL, '2025-05-14', 'Jihad Gift', NULL, '2025-05-13 19:10:37', '2025-05-13 19:10:37'),
(16, 5, 49, 62, 8000.00, 'expense', NULL, '2025-05-14', 'Basa Vara advance', NULL, '2025-05-13 19:11:55', '2025-05-13 19:11:55'),
(18, 5, 49, 62, 2000.00, 'expense', NULL, '2025-05-14', 'Sir er beton 2000 ekhon mot beton', NULL, '2025-05-13 19:15:23', '2025-05-13 19:15:23'),
(19, 5, 49, 88, 56000.00, 'income', NULL, '2025-05-14', 'student er kache theke prapto taka 14 tarikh obdi', NULL, '2025-05-13 19:20:54', '2025-05-13 19:20:54'),
(22, 10, 57, 104, 4000.00, 'income', NULL, '2025-05-19', 'Junayed', NULL, '2025-05-19 12:06:16', '2025-05-19 12:06:16'),
(23, 10, 57, 104, 2800.00, 'income', NULL, '2025-05-20', 'Rohan', NULL, '2025-05-19 18:04:16', '2025-05-19 18:04:16'),
(24, 10, 57, 104, 555.00, 'income', NULL, '2025-05-20', 'Imran', NULL, '2025-05-19 18:05:20', '2025-05-19 18:05:20'),
(25, 16, 93, 157, 5888.00, 'income', NULL, '2025-09-05', 'Ccc', NULL, '2025-09-04 19:50:37', '2025-09-04 19:50:37');

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_key` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `language` varchar(255) NOT NULL DEFAULT 'bn',
  `currency_format` varchar(255) NOT NULL DEFAULT 'bn_BD',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `language`, `currency_format`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@example.com', NULL, '$2y$12$.Mf5fwV18ycKupNc65XNquknudrPm1lJFWJs6ZnaWupL1d6/fyWqG', NULL, 'bn', 'bn_BD', NULL, '2025-05-11 04:58:32', '2025-05-11 04:58:32'),
(3, 'Al Imran', '21imranbd@gmail.com', '2025-05-11 20:08:32', '$2y$12$kyISaDAS3toTr2Kb7zA37u76OgB/sJY3oBeuk7TJ3CjU2Id..CiV6', 'alimrangub@gmail.com', 'bn', 'bn_BD', 'S7gC0w2MlJv9H6a0ldwVLTPLCaWZ0oRM9PG6s2Zbne8Cm0LUKYMH77zhpQO1', '2025-05-11 05:16:06', '2025-05-11 20:08:32'),
(4, 'Al Imran', 'alimrandmc@gmail.com', NULL, '$2y$12$/vKnsEDHQoHGOWajdwflQe8rUVyu9/w2yMgIDCYwNGftFa/3.HtiC', '+8801726930728', 'bn', 'bn_BD', NULL, '2025-05-11 16:10:19', '2025-05-11 16:10:19'),
(5, 'Sakib Hossain', 'sakib.green.cse@gmail.com', NULL, '$2y$12$vL1UK1s1w/Gqt/NQGAh1Mu3xcRHE8cS2waFEuPqbKHaw6qVi4NHp.', NULL, 'bn', 'bn_BD', 'mn9bn2LAIKHorjaC7Et9Fdae9QicBf9UEt8xhf7HSee16Syaj0OFtZaREKF9', '2025-05-11 17:12:24', '2025-05-11 17:12:24'),
(6, 'Al Imran', '22imranbd@gmail.com', NULL, '$2y$12$UBr5cdwqsQeLXurkYC5sceH0hSSx6ryF5sxaFY8u8nU2MCH7ct5Ey', '+8801726930728', 'bn', 'bn_BD', NULL, '2025-05-11 20:20:35', '2025-05-11 20:20:35'),
(7, 'Junayed', 'junayedprodan95@gmail.com', NULL, '$2y$12$uWUQRcdGECLJO.rcd.AGcOCCvnA4ottJ27Qd9xE7kYxFnC7pDVOf6', '01633595148', 'bn', 'bn_BD', NULL, '2025-05-12 09:15:22', '2025-05-12 09:15:22'),
(8, 'ESTIAK', 'mahmudul101588@gmail.com', NULL, '$2y$12$g3HLeJQJ131qvXAQuny5QujGYZA/KgPUv..uSvaqFWAwensSv.lXC', '01782785000', 'bn', 'bn_BD', NULL, '2025-05-13 16:56:30', '2025-05-13 16:56:30'),
(9, 'Shiuly', 'shiulyimran7@gmail.com', NULL, '$2y$12$hYePVw0wDVrZ7UWhuGtYQ.RYfunbMbH2edfh5O.BumcrbONcN/zUK', '+8801305618493', 'bn', 'bn_BD', NULL, '2025-05-14 18:29:07', '2025-05-14 18:29:07'),
(10, 'Md. Toriqul Islam', 'toriqulislam819@gmail.com', NULL, '$2y$12$R0frYycYdKZZ8geHx9p1YeFHrdTdlV9FQG.hdSxAs5gjYZ5vN.dzK', '01679549878', 'bn', 'bn_BD', NULL, '2025-05-18 15:10:01', '2025-05-18 15:10:01'),
(11, 'Abdur Rahman.RH', 'arh15100@gmail.com', NULL, '$2y$12$VXkOiSZqKGlKd/QG.7oooOJmW0i77GMv61VFux8GLXrk1bw8WvUJW', NULL, 'bn', 'bn_BD', NULL, '2025-05-24 09:53:13', '2025-05-24 09:53:13'),
(12, 'Mijanur Rahman', 'citsc.contact@gmail.com', '2025-05-25 09:15:39', '$2y$12$XAz/I96K1AI5JAImM1QyfOWgDvMXLHVtqKxETWZI1Q8HGHW0vH0Sm', NULL, 'bn', 'bn_BD', 'pUzfHgv8nJnr7baRZ4ocv1dtT8FthkDovQAJgrsrzpTylkpNbF5qGWyR5gG3', '2025-05-25 07:18:12', '2025-05-25 09:15:39'),
(13, 'NARYTHY3987431NERTHRTYHR', 'asoaldqa@streetwormail.com', NULL, '$2y$12$yfmqMURXefatptuZm60zd.y/hm5R5QF..u9UYSP4ULGfUaR0QjKCK', '86811353552', 'bn', 'bn_BD', NULL, '2025-06-09 18:15:12', '2025-06-09 18:15:12'),
(14, 'Dr Rohomot', 'rohomot6394@gmail.com', NULL, '$2y$12$5557zk.2m1sIj.lWpkqcIuW1UJlOwJLq/k1VjJZLzDriPlpDB7VOG', '01306930764', 'bn', 'bn_BD', NULL, '2025-06-10 10:43:39', '2025-06-10 10:43:39'),
(15, '<a href=https://suprr.cc/ac?y=abcde>hLook here please amarkhata.blog</a>  https://suprr.cc/ac Look here please', 'second@suprr.cc', NULL, '$2y$12$W9wGqSnyzT1CjDwgThNeIO1b311.xjCCJumixq9JLKOm6oQIr0L1G', '81325659585', 'bn', 'bn_BD', NULL, '2025-08-15 05:53:37', '2025-08-15 05:53:37'),
(16, 'Md Nayeem', 'nayeemasw@gmail.com', '2025-11-18 11:58:33', '$2y$12$l5sFuOSSRnekz1Lwga0HlOSIZ/hQYL4fBdYuVjEx3ZFnQQPHj6y9W', NULL, 'bn', 'bn_BD', '0I0bI9vceXUfE985cFBW68GjJ2aYmEQfrzvKoq46625w33xrkddvPPCDDcbv', '2025-09-03 17:13:53', '2025-11-18 11:58:33'),
(17, 'adminxp', 'adminxp@gmail.com', NULL, '$2y$12$OnJl8gKGPBV.OySju/fH3eikWW2Lqyu5k2ciKKaj2h2bAFlVwk/B6', NULL, 'bn', 'bn_BD', NULL, '2025-09-12 23:10:57', '2025-09-12 23:10:57'),
(18, 'NAERTERHTE1003732NERTHRTYHR', 'cfcvcdlj@ronaldofmail.com', NULL, '$2y$12$qL5Vsf0V0vt/ZUUSeJt3muWq8AFnpPnDDQrEubvfyNTQk1p2yz0v2', '88821998854', 'bn', 'bn_BD', NULL, '2025-09-14 13:27:50', '2025-09-14 13:27:50'),
(19, 'Lopoloifhidwjdwfefee fjedwjdwj ijwhfwdj wfiefwjdwd hwidjwidhwfhwidjiwj hjfhefjhwifhewfiwejj hfiwhfqwjhfqwiefgwiej amarkhata.blog', 'nomin.momin+274x5@mail.ru', NULL, '$2y$12$/0Eg4tDZ9nF9NQb1z2C9JemygngHOzDHiRgo.GfhG47NgCXv1Q6J6', '85972722669', 'bn', 'bn_BD', NULL, '2025-10-06 22:35:25', '2025-10-06 22:35:25'),
(20, 'Farhan', 'Habiburahmanmamun27@gmail.com', NULL, '$2y$12$sd/E/JL2HOpkMzjAdCzKY.gGm7JslkaBjg4/E4rEh.h3klE5I1Wk.', '018197607897', 'bn', 'bn_BD', NULL, '2025-10-21 07:38:37', '2025-10-21 07:38:37'),
(21, '01864568607', 'Rjdudraj1@gmail.com', NULL, '$2y$12$.ZdypLUnJkXazp3trmFlj.C8/VCl5KZ7bCH7h9R1ASVRKQemN6Ajq', NULL, 'bn', 'bn_BD', NULL, '2025-11-06 23:12:58', '2025-11-06 23:12:58'),
(22, 'Nour', 'nourcmh9@gmail.com', NULL, '$2y$12$z6NNJfVmeipuJWoF8We.7.1sWt6YH7Lw4tk78Ke8TW.1pGTKQNfhe', '33758023768', 'bn', 'bn_BD', NULL, '2026-01-18 18:56:38', '2026-01-18 18:56:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accounts_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loans_user_id_foreign` (`user_id`);

--
-- Indexes for table `loan_payments`
--
ALTER TABLE `loan_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_id` (`loan_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`),
  ADD KEY `transactions_account_id_foreign` (`account_id`),
  ADD KEY `transactions_category_id_foreign` (`category_id`),
  ADD KEY `transactions_transfer_to_account_id_foreign` (`transfer_to_account_id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `translations_language_key_key_unique` (`language_key`,`key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `loan_payments`
--
ALTER TABLE `loan_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loan_payments`
--
ALTER TABLE `loan_payments`
  ADD CONSTRAINT `loan_payments_ibfk_1` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transactions_transfer_to_account_id_foreign` FOREIGN KEY (`transfer_to_account_id`) REFERENCES `accounts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
