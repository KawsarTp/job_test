-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2021 at 06:01 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `job_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `appoint_date` date NOT NULL,
  `fee` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `order_id`, `doctor_id`, `day_id`, `schedule_id`, `appoint_date`, `fee`, `created_at`, `updated_at`) VALUES
(1, '20210725102523', 1, 1, 1, '2021-07-31', '5', '2021-07-13 18:37:28', '2021-07-13 18:37:28'),
(2, '20210725102523', 2, 6, 11, '2021-07-29', '7', '2021-07-13 18:37:28', '2021-07-14 16:26:27');

-- --------------------------------------------------------

--
-- Table structure for table `days`
--

CREATE TABLE `days` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `day` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `days`
--

INSERT INTO `days` (`id`, `day`, `created_at`, `updated_at`) VALUES
(1, 'Saturday', '2021-07-15 02:27:30', '2021-07-15 02:27:30'),
(2, 'Sunday', '2021-07-15 02:27:35', '2021-07-15 02:27:35'),
(3, 'Monday', '2021-07-15 02:27:39', '2021-07-15 02:27:39'),
(4, 'Tuesday', '2021-07-15 02:27:45', '2021-07-15 02:27:45'),
(5, 'Wednesday', '2021-07-15 02:27:49', '2021-07-15 02:27:49'),
(6, 'Thursday', '2021-07-15 02:27:53', '2021-07-15 02:27:53'),
(7, 'Friday', '2021-07-15 02:27:58', '2021-07-15 02:27:58');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Neurology', '2021-07-13 16:17:19', '2021-07-13 17:28:45'),
(2, 'Cardiology', '2021-07-13 16:17:41', '2021-07-13 16:17:41'),
(3, 'Pediatric', '2021-07-13 16:18:29', '2021-07-13 16:18:29'),
(4, 'Radiology', '2021-07-13 16:18:50', '2021-07-13 16:18:50');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fee` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `fee`, `department_id`, `created_at`, `updated_at`) VALUES
(1, 'Dr. Tommy Shank', 5, 1, '2021-07-13 17:31:21', '2021-07-14 15:55:33'),
(2, 'Dr. Aaron Bemis', 7, 2, '2021-07-13 17:35:27', '2021-07-14 10:06:10');

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`id`, `doctor_id`, `date`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-08-07', '2021-07-15 02:31:33', '2021-07-15 02:31:33'),
(2, 2, '2021-08-05', '2021-07-15 02:31:33', '2021-07-15 02:31:33');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2021_07_26_135436_create_temp_orders_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patient_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `patient_mobile` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid_amount` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fee_amount` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `net_amount` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `transaction_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `patient_name`, `patient_mobile`, `paid_amount`, `fee_amount`, `net_amount`, `payment_status`, `transaction_id`, `created_at`, `updated_at`) VALUES
(1, '20210725102523', 'Arefin', '01912721070', '12', '2.50', '9.50', 'Completed', 'PAYID-MDV23AY53140771GK6394993', '2021-07-13 18:37:28', '2021-07-14 03:16:57'),
(5, '20210727064312', 'test', '123465', '21', '2.5', '18.5', '', '', '2021-07-27 09:31:01', '2021-07-27 09:31:01'),
(6, '20210727064312', 'test', '123456', '7', '2.5', '4.5', '', '', '2021-07-27 09:50:15', '2021-07-27 09:50:15'),
(7, '20210727064312', 'test', '123456', '5', '2.5', '2.5', '', '', '2021-07-27 09:59:05', '2021-07-27 09:59:05');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `day_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `start_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `maximum_patient` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `day_id`, `doctor_id`, `start_time`, `end_time`, `maximum_patient`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '9:00 AM', '10:00 AM', 2, '2021-07-13 18:08:37', '2021-07-13 18:08:37'),
(2, 1, 1, '3:00 PM', '4:00 PM', 3, '2021-07-13 18:08:53', '2021-07-13 18:08:53'),
(3, 2, 1, '10:00 AM', '11:00 AM', 2, '2021-07-13 18:09:03', '2021-07-13 18:09:03'),
(4, 2, 1, '3:00 PM', '4:00 PM', 3, '2021-07-13 18:09:15', '2021-07-13 18:09:15'),
(5, 3, 1, '10:00 AM', '11:00 AM', 2, '2021-07-13 18:09:24', '2021-07-13 18:09:24'),
(6, 3, 1, '3:00 PM', '4:00 PM', 3, '2021-07-13 18:09:15', '2021-07-13 18:09:15'),
(7, 4, 2, '10:30 AM', '11:30 AM', 4, '2021-07-13 18:08:37', '2021-07-13 18:08:37'),
(8, 4, 2, '5:00 PM', '6:00 PM', 5, '2021-07-13 18:08:53', '2021-07-13 18:08:53'),
(9, 5, 2, '10:30 AM', '11:00 AM', 4, '2021-07-13 18:09:03', '2021-07-13 18:09:03'),
(10, 5, 2, '5:00 PM', '6:00 PM', 5, '2021-07-13 18:09:15', '2021-07-13 18:09:15'),
(11, 6, 2, '10:30 AM', '11:00 AM', 4, '2021-07-13 18:09:24', '2021-07-13 18:09:24'),
(12, 6, 2, '5:00 PM', '6:00 PM', 5, '2021-07-13 18:09:15', '2021-07-13 18:09:15');

-- --------------------------------------------------------

--
-- Table structure for table `temp_orders`
--

CREATE TABLE `temp_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `schedule_id` bigint(20) UNSIGNED NOT NULL,
  `order_date` date NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `temp_trx` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `days`
--
ALTER TABLE `days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_orders`
--
ALTER TABLE `temp_orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `days`
--
ALTER TABLE `days`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `temp_orders`
--
ALTER TABLE `temp_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
