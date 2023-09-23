-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Sep 23, 2023 at 08:20 AM
-- Server version: 10.10.2-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fyp`
--

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('yaojun12345678910@gmail.com', '$2y$10$W1dMT2a4rim0FZosk1XUNO2/RU/1Gjr9GZ4c9C4zUNvosjd3C7E5y', '2023-09-01 12:45:31');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL,
  `package_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
CREATE TABLE IF NOT EXISTS `plans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(25) DEFAULT NULL,
  `price` varchar(50) DEFAULT NULL,
  `detail` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `type`, `price`, `detail`, `created_at`, `updated_at`) VALUES
(1, 'FREE', '0', '2,5,5', '2023-09-06 16:00:00', '2023-09-19 03:23:06'),
(2, 'BASIC', '10.99', '10,100,10', '2023-09-06 16:00:00', '2023-09-19 03:23:06'),
(3, 'STANDARD', '19.99', '20,1000,-1', '2023-09-06 16:00:00', '2023-09-19 03:23:06'),
(4, 'PREMIUM', '29.99', '50,-1,-1', '2023-09-09 17:18:45', '2023-09-19 03:23:06');

-- --------------------------------------------------------

--
-- Table structure for table `portfolios`
--

DROP TABLE IF EXISTS `portfolios`;
CREATE TABLE IF NOT EXISTS `portfolios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `num_of_transactions` int(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `portfolios`
--

INSERT INTO `portfolios` (`id`, `user_id`, `type`, `num_of_transactions`, `created_at`, `updated_at`) VALUES
(18, 4, 'Other', 3, '2023-09-18 04:34:37', '2023-09-17 20:34:37'),
(19, 4, 'QM', 2, '2023-09-18 04:51:04', '2023-09-17 20:51:04');

-- --------------------------------------------------------

--
-- Table structure for table `portfolio_transaction`
--

DROP TABLE IF EXISTS `portfolio_transaction`;
CREATE TABLE IF NOT EXISTS `portfolio_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `portfolio_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `portfolio_transaction`
--

INSERT INTO `portfolio_transaction` (`id`, `portfolio_id`, `transaction_id`, `created_at`, `updated_at`) VALUES
(38, 18, 36, '2023-09-18 12:34:37', NULL),
(39, 18, 47, '2023-09-18 12:34:37', NULL),
(40, 18, 48, '2023-09-18 12:34:37', NULL),
(41, 19, 7, '2023-09-18 12:51:04', NULL),
(42, 19, 39, '2023-09-18 12:51:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `downpayment` varchar(50) DEFAULT NULL,
  `gold_price` varchar(50) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `convert_percent` varchar(50) DEFAULT NULL,
  `management_fee_percent` varchar(50) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `terminate_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `downpayment`, `gold_price`, `type`, `convert_percent`, `management_fee_percent`, `created_at`, `terminate_at`) VALUES
(5, 1, '2496.37', '50', 'QM', NULL, NULL, '2023-08-28', NULL),
(6, 1, '1000', '62', 'QM', NULL, NULL, '2023-07-25', NULL),
(7, 4, '800.00', '64.00', 'QM', NULL, NULL, '2023-07-25', NULL),
(8, 1, '1000', '50', 'QM', NULL, NULL, '2023-08-08', NULL),
(9, 1, '5677.74', '60.296', 'QM', NULL, NULL, '2023-02-06', NULL),
(10, 1, '9999', '50', 'QM', NULL, NULL, '2023-09-03', NULL),
(34, 1, '5677.74', '60.00', 'QM', NULL, NULL, '2023-09-07', NULL),
(36, 4, '1000.00', '50.00', 'Other', '85', '3.5', '2023-09-07', NULL),
(39, 4, '5677.74', '58.41', 'QM', NULL, NULL, '2022-06-08', NULL),
(41, 4, '1000.00', '50.00', 'QM', NULL, NULL, '2023-09-08', NULL),
(42, 4, '1000.00', '50.00', 'QM', NULL, NULL, '2023-09-08', NULL),
(45, 4, '1000.00', '50.00', 'QM', NULL, NULL, '2023-09-08', NULL),
(47, 4, '1006.99', '10.76', 'Other', '90', '3.7', '2023-09-03', NULL),
(48, 4, '1000.00', '60.00', 'Other', '88', '8', '2023-09-05', NULL),
(50, 4, '1000.00', '50.00', 'QM', NULL, NULL, '2023-09-09', NULL),
(51, 4, '1000.00', '50.00', 'Other', '90', '2', '2023-09-09', NULL),
(52, 4, '1000.00', '59.90', 'Other', '90', '3', '2023-09-09', NULL),
(53, 4, '1000.00', '50.00', 'Other', '60', '2', '2023-09-09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `plan_id` int(11) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_admin`, `plan_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$10$HIzY1mw1nBdEi8JgPYvbXuXzNQbKU34bWC0KB6XvcNcpLVAKg1ROy', 1, 1, NULL, '2023-07-06 01:35:15', '2023-09-09 10:26:00'),
(4, 'cyj', 'yaojun12345678910@gmail.com', '2023-07-24 10:23:19', '$2y$10$bfDZFu.EIIMOb7UT70eNn.mlzJ0u3SRFfb7OP0uH5RXKFHsAOyLuW', 0, 2, NULL, '2023-07-24 10:07:28', '2023-09-18 19:22:01'),
(6, 'cyj2', 'yaojun12345678910@1utar.my', '2023-09-18 19:23:58', '$2y$10$dsPcHYjYYyk2.tNVF8cy1etdP4SGd0zvJ.O9SFiXTcEqgmvH3nID6', 0, 1, NULL, '2023-07-24 10:27:24', '2023-09-18 19:23:58'),
(7, 'Sugumaran', 'devsugu@yahoo.com', '2023-07-29 04:56:53', '$2y$10$ybcsugultEp8v1Kiv4tTjujQlJKwZ4S8U6XdeOhcetBEuekNDbfbm', 0, 1, NULL, '2023-07-29 04:56:33', '2023-07-29 04:56:53');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
