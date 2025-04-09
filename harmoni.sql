-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 20, 2025 at 12:22 PM
-- Server version: 8.0.41-0ubuntu0.24.04.1
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `harmoni`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_master`
--

CREATE TABLE `admin_master` (
  `admin_id` int NOT NULL,
  `admin_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_phone` bigint NOT NULL,
  `admin_password` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_status` int NOT NULL DEFAULT '1' COMMENT '1=active, 0=inactive',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_master`
--

INSERT INTO `admin_master` (`admin_id`, `admin_name`, `admin_email`, `admin_phone`, `admin_password`, `admin_status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', 9316604045, '$2y$10$IDUDConL0T/fgYd1dbO1CeiCHrXA29L7LBt2vR4I0Bf8M4BdhSf/a', 1, '2025-03-11 04:04:32', '2025-03-11 04:04:32'),
(2, 'Akhtar Tarakwadiya', 'akhtar@gmail.com', 9316604045, '$2y$10$2eNdmlMKXXyJnMDOWprLaO5ssF2ZpnJkS1DmmXm1i0mTvRQyfgtI6', 1, '2025-03-11 04:04:51', '2025-03-11 04:04:51');

-- --------------------------------------------------------

--
-- Table structure for table `comments_master`
--

CREATE TABLE `comments_master` (
  `comment_id` int NOT NULL,
  `post_id` int NOT NULL,
  `user_id` int NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment_status` int NOT NULL DEFAULT '1' COMMENT '1=active, 0=inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments_master`
--

INSERT INTO `comments_master` (`comment_id`, `post_id`, `user_id`, `comment`, `created_at`, `updated_at`, `comment_status`) VALUES
(1, 42, 19, '1244', '2025-03-12 06:33:20', '2025-03-12 06:33:20', 1),
(2, 42, 19, 'hsksmskdk', '2025-03-12 06:33:24', '2025-03-12 06:33:24', 1),
(3, 41, 19, 'mmm', '2025-03-12 06:34:25', '2025-03-12 06:34:25', 1),
(4, 57, 19, 'hchchc', '2025-03-12 07:00:53', '2025-03-12 07:00:53', 1),
(5, 57, 19, 'jvj j', '2025-03-12 07:00:56', '2025-03-12 07:00:56', 1),
(6, 67, 19, 'ncjvj', '2025-03-12 10:04:01', '2025-03-12 10:04:01', 1),
(7, 70, 19, 'jaja', '2025-03-12 10:33:34', '2025-03-12 10:33:34', 1),
(8, 70, 19, 'shriyansh', '2025-03-12 10:33:40', '2025-03-12 10:33:40', 1),
(9, 71, 19, 'bsjjss', '2025-03-12 10:33:51', '2025-03-12 10:33:51', 1),
(10, 74, 19, 'vhnb', '2025-03-12 10:51:12', '2025-03-12 10:51:12', 1),
(11, 72, 19, 'ique', '2025-03-12 11:40:24', '2025-03-12 11:40:24', 1),
(12, 81, 19, 'jcjcj', '2025-03-13 03:26:15', '2025-03-13 04:00:48', 0),
(13, 81, 19, 'b jcj', '2025-03-13 03:26:18', '2025-03-13 04:01:07', 0),
(14, 1, 1, 'Nice Pic', '2025-03-13 03:30:00', '2025-03-13 03:30:00', 1),
(15, 84, 19, 'ivjvjv\nfg', '2025-03-13 04:15:26', '2025-03-13 04:18:49', 0),
(16, 84, 19, 'chchch\ncucu', '2025-03-13 04:15:32', '2025-03-13 04:19:53', 0),
(17, 78, 19, 'tttttttttttttttttttt', '2025-03-13 04:28:27', '2025-03-13 04:28:27', 1),
(18, 84, 19, 'kkkkkkk', '2025-03-13 04:28:48', '2025-03-13 04:28:48', 1),
(19, 84, 19, 'dfty', '2025-03-13 04:31:24', '2025-03-13 04:31:24', 1),
(20, 84, 19, 'cjcj j', '2025-03-13 04:32:39', '2025-03-13 04:32:39', 1),
(21, 84, 19, 'hsdg', '2025-03-13 04:33:13', '2025-03-13 04:33:13', 1),
(22, 84, 19, 'fufxu', '2025-03-13 04:34:19', '2025-03-13 04:34:19', 1),
(23, 81, 19, 'aaaaaa', '2025-03-13 04:37:14', '2025-03-13 04:37:14', 1),
(24, 87, 19, 'uvuv', '2025-03-13 05:05:16', '2025-03-19 09:15:53', 0),
(25, 87, 19, 'bzjzjzj', '2025-03-13 05:13:33', '2025-03-13 05:13:33', 1),
(26, 87, 19, 'bakkasnb', '2025-03-13 05:13:37', '2025-03-13 05:13:37', 1),
(27, 87, 19, 'jzjzjnz', '2025-03-13 05:17:08', '2025-03-13 05:17:08', 1),
(28, 87, 19, 'bzjzk', '2025-03-13 05:17:15', '2025-03-13 05:17:15', 1),
(29, 87, 19, 'hausj', '2025-03-13 05:17:21', '2025-03-13 05:17:21', 1),
(30, 87, 19, 'hzjzjsj', '2025-03-13 05:17:24', '2025-03-13 05:17:24', 1),
(31, 87, 19, 'hzjzjznj', '2025-03-13 05:17:29', '2025-03-13 05:17:29', 1),
(32, 87, 19, 'b hc', '2025-03-13 05:17:56', '2025-03-13 05:17:56', 1),
(33, 87, 32, 'hchccu', '2025-03-13 05:22:39', '2025-03-13 05:22:39', 1),
(34, 87, 32, 'jvjvjv', '2025-03-13 05:22:45', '2025-03-13 05:22:45', 1),
(35, 85, 19, 'kakkss', '2025-03-13 05:41:28', '2025-03-13 05:41:28', 1),
(36, 87, 19, 'I love you', '2025-03-13 06:03:31', '2025-03-13 06:03:31', 1),
(37, 92, 31, 'vjvjvjvj', '2025-03-13 06:11:54', '2025-03-13 06:11:54', 1),
(38, 92, 31, 'hchchcu', '2025-03-13 06:12:00', '2025-03-18 07:50:38', 0),
(39, 87, 31, 'jvjvjvvj', '2025-03-13 06:12:26', '2025-03-13 06:12:26', 1),
(40, 1, 1, 'Nice Picc', '2025-03-18 10:15:24', '2025-03-18 10:15:24', 1),
(41, 1, 1, 'Nice Picc', '2025-03-18 10:17:05', '2025-03-18 10:17:05', 1),
(42, 1, 1, 'Nice Picc', '2025-03-18 10:17:14', '2025-03-18 10:17:14', 1),
(43, 1, 1, 'Nice Picc', '2025-03-18 10:19:03', '2025-03-18 10:19:03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `follow_master`
--

CREATE TABLE `follow_master` (
  `id` int NOT NULL,
  `follower_id` int NOT NULL,
  `following_id` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `followed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `follow_master`
--

INSERT INTO `follow_master` (`id`, `follower_id`, `following_id`, `status`, `followed_at`) VALUES
(1, 1, 5, 1, '2025-03-18 11:24:54'),
(2, 1, 6, 1, '2025-03-05 04:06:33'),
(3, 5, 6, 0, '2025-03-05 06:27:41'),
(6, 5, 1, 1, '2025-03-05 04:12:44'),
(7, 32, 19, 1, '2025-03-13 05:44:15'),
(8, 32, 5, 1, '2025-03-13 05:23:32'),
(9, 19, 32, 0, '2025-03-13 05:51:08'),
(10, 33, 32, 1, '2025-03-13 05:31:58'),
(11, 35, 32, 0, '2025-03-13 07:03:31'),
(12, 35, 19, 1, '2025-03-13 06:14:18'),
(13, 32, 35, 1, '2025-03-13 06:37:53'),
(14, 35, 1, 1, '2025-03-13 07:01:11'),
(15, 35, 5, 0, '2025-03-13 07:03:46'),
(16, 19, 5, 0, '2025-03-17 10:23:26'),
(17, 36, 5, 1, '2025-03-17 10:39:31'),
(18, 36, 35, 0, '2025-03-17 10:39:36'),
(19, 36, 32, 1, '2025-03-17 10:39:38'),
(20, 37, 32, 0, '2025-03-17 10:50:05'),
(21, 32, 37, 1, '2025-03-17 10:50:26'),
(22, 37, 19, 1, '2025-03-17 10:51:27'),
(23, 19, 37, 1, '2025-03-17 10:51:50');

-- --------------------------------------------------------

--
-- Table structure for table `likes_master`
--

CREATE TABLE `likes_master` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `post_id` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `liked_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `likes_master`
--

INSERT INTO `likes_master` (`id`, `user_id`, `post_id`, `status`, `liked_at`) VALUES
(1, 1, 1, 0, '2025-03-10 05:30:24'),
(2, 1, 46, 1, '2025-03-06 04:18:26'),
(3, 5, 46, 1, '2025-03-06 04:20:42'),
(4, 6, 46, 1, '2025-03-06 04:20:42'),
(5, 1, 89, 0, '2025-03-10 06:13:09'),
(6, 1, 88, 0, '2025-03-10 06:05:48'),
(7, 1, 87, 1, '2025-03-10 05:05:44'),
(8, 1, 86, 1, '2025-03-10 05:05:48'),
(9, 1, 85, 0, '2025-03-10 05:07:50'),
(10, 19, 89, 1, '2025-03-10 07:12:16'),
(11, 19, 88, 1, '2025-03-13 05:41:14'),
(12, 19, 84, 1, '2025-03-13 04:28:56'),
(13, 19, 87, 1, '2025-03-13 05:41:16'),
(14, 19, 86, 0, '2025-03-13 06:04:28'),
(15, 1, 84, 1, '2025-03-10 05:55:56'),
(16, 1, 84, 1, '2025-03-10 05:55:56'),
(17, 1, 83, 1, '2025-03-10 05:58:29'),
(18, 1, 74, 1, '2025-03-10 06:02:48'),
(19, 1, 91, 1, '2025-03-10 06:51:10'),
(20, 19, 91, 0, '2025-03-10 07:09:15'),
(21, 19, 90, 1, '2025-03-10 07:08:12'),
(22, 19, 82, 1, '2025-03-13 04:29:00'),
(23, 19, 85, 0, '2025-03-13 05:41:23'),
(24, 5, 91, 1, '2025-03-10 06:51:19'),
(25, 6, 91, 1, '2025-03-18 12:20:12'),
(26, 19, 81, 1, '2025-03-13 04:29:07'),
(27, 19, 93, 1, '2025-03-13 05:46:27'),
(28, 19, 39, 1, '2025-03-12 05:10:09'),
(29, 19, 40, 1, '2025-03-12 05:27:18'),
(30, 19, 42, 1, '2025-03-12 06:25:37'),
(31, 19, 57, 0, '2025-03-12 07:01:24'),
(32, 19, 56, 0, '2025-03-12 07:01:33'),
(33, 19, 67, 1, '2025-03-12 10:03:42'),
(34, 19, 71, 0, '2025-03-13 05:47:04'),
(35, 19, 74, 0, '2025-03-13 05:46:43'),
(36, 19, 73, 1, '2025-03-13 05:46:57'),
(37, 19, 70, 1, '2025-03-12 10:33:21'),
(38, 19, 83, 1, '2025-03-13 04:28:58'),
(39, 32, 93, 1, '2025-03-13 05:48:04'),
(40, 32, 92, 1, '2025-03-13 05:45:51'),
(41, 32, 91, 0, '2025-03-13 05:46:03'),
(42, 32, 90, 0, '2025-03-13 05:46:00'),
(43, 32, 76, 1, '2025-03-13 05:46:06'),
(44, 32, 74, 1, '2025-03-13 05:46:10'),
(45, 32, 73, 1, '2025-03-13 05:46:11'),
(46, 32, 72, 0, '2025-03-13 05:46:25'),
(47, 19, 78, 1, '2025-03-13 05:46:30'),
(48, 19, 76, 1, '2025-03-13 05:46:34'),
(49, 19, 75, 1, '2025-03-13 05:46:36'),
(50, 31, 93, 1, '2025-03-13 06:11:38'),
(51, 31, 90, 1, '2025-03-13 06:11:42'),
(52, 31, 91, 1, '2025-03-13 06:11:43'),
(53, 31, 92, 1, '2025-03-13 06:11:45'),
(54, 32, 96, 0, '2025-03-13 07:02:40'),
(55, 19, 99, 1, '2025-03-17 10:31:56'),
(56, 1, 114, 1, '2025-03-19 09:30:40'),
(57, 6, 115, 1, '2025-03-20 11:39:22');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `sender_id` int DEFAULT NULL,
  `TYPE` int NOT NULL COMMENT '1=Follow, 2=Like, 3=Comment, 4=New Post, 5=Account Blocked, 6=Account Disabled',
  `post_id` int DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) DEFAULT '0' COMMENT '0=Unread, 1=Read',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `sender_id`, `TYPE`, `post_id`, `message`, `is_read`, `created_at`) VALUES
(1, 1, NULL, 1, NULL, 'Admin followed you.', 1, '2025-03-18 04:23:45'),
(2, 1, NULL, 2, 1, 'Admin liked your post.', 1, '2025-03-18 04:27:31'),
(3, 1, NULL, 2, 1, 'Admin liked your post.', 0, '2025-03-18 04:27:40'),
(4, 1, 5, 2, 1, 'Sohel_Khann liked your post.', 0, '2025-03-18 04:28:27'),
(5, 1, 1, 3, 1, 'User 1 commented on your post.', 0, '2025-03-18 10:19:03'),
(6, 1, 1, 3, 1, 'Ertugrul_IYI commented on your post.', 0, '2025-03-18 10:20:57'),
(7, 5, 1, 1, NULL, 'Ertugrul_IYI followed you.', 0, '2025-03-18 11:24:54'),
(8, 32, 6, 2, 91, 'User 6 liked your post.', 0, '2025-03-18 12:15:33'),
(9, 32, 6, 2, 91, 'User 6 liked your post.', 0, '2025-03-18 12:18:26'),
(10, 32, 6, 2, 91, 'sohelll@123 liked your post.', 0, '2025-03-18 12:20:12'),
(11, 5, NULL, 4, 107, '@ added a new post. <a href=\'http://192.168.4.220/Harmoni/showpost.php?id=107\'>Click here to view</a>', 1, '2025-03-19 04:41:54'),
(12, 1, NULL, 4, 108, '@Ertugrul_IYI added a new post. <a href=\'http://192.168.4.220/Harmoni/showpost.php?id=108\'>Click here to view</a>', 1, '2025-03-19 04:43:32'),
(13, 1, NULL, 4, 109, '@Ertugrul_IYI added a new post. <a href=\'http://192.168.4.220/Harmoni/showpost.php?id=109\'>Click here to view</a>', 1, '2025-03-19 04:48:05'),
(14, 1, NULL, 4, 110, '<a href=\'http://192.168.4.220/Harmoni/showpost.php?id=110\'>@Ertugrul_IYI added a new post</a>', 1, '2025-03-19 06:17:15'),
(15, 1, NULL, 4, 111, '     <a href=\'http://192.168.4.220/Harmoni/showpost.php?id=111\'>@Ertugrul_IYI added a new post</a>', 1, '2025-03-19 06:18:10'),
(16, 1, NULL, 4, 112, '@Ertugrul_IYI added a new post. <a href=\'http://192.168.4.220/Harmoni/showpost.php?id=112\'>Click here to view</a>', 1, '2025-03-19 07:47:33'),
(17, 1, NULL, 4, 113, ' <a href=\'http://192.168.4.220/Harmoni/showpost.php?id=113\'>@Ertugrul_IYI added a new post.</a>', 1, '2025-03-19 08:53:25'),
(18, 1, NULL, 4, 114, '@Ertugrul_IYI added a new post. <a href=\'http://192.168.4.220/Harmoni/showpost.php?id=114\'>Click here to view</a>', 1, '2025-03-19 08:54:34'),
(19, 1, NULL, 4, 115, '@Ertugrul_IYI added a new post. <a href=\'http://192.168.4.220/Harmoni/showpost.php?id=115\'>Click here to view</a>', 1, '2025-03-20 11:38:26'),
(20, 1, 6, 2, 115, 'sohelll@123 liked your post.', 0, '2025-03-20 11:39:22'),
(21, 124, NULL, 4, 116, '@demo added a new post. <a href=\'http://192.168.4.220/Harmoni/showpost.php?id=116\'>Click here to view</a>', 1, '2025-03-20 11:58:02');

-- --------------------------------------------------------

--
-- Table structure for table `otp_verification`
--

CREATE TABLE `otp_verification` (
  `otp_id` int NOT NULL,
  `user_id` int NOT NULL,
  `otp_code` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp_expiry` datetime NOT NULL,
  `is_verified` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `otp_verification`
--

INSERT INTO `otp_verification` (`otp_id`, `user_id`, `otp_code`, `otp_expiry`, `is_verified`, `created_at`) VALUES
(1, 5, '3923', '2025-03-18 06:27:08', 1, '2025-03-18 05:17:08'),
(2, 5, '9844', '2025-03-18 06:31:23', 1, '2025-03-18 05:21:23'),
(3, 5, '1150', '2025-03-18 06:38:39', 1, '2025-03-18 05:28:39'),
(4, 5, '7654', '2025-03-18 06:45:15', 1, '2025-03-18 05:35:15'),
(5, 5, '7381', '2025-03-18 06:49:17', 1, '2025-03-18 05:39:17'),
(6, 5, '4513', '2025-03-18 06:51:26', 1, '2025-03-18 05:41:26'),
(7, 5, '4513', '2025-03-18 07:01:01', 1, '2025-03-18 05:51:01'),
(8, 5, '9535', '2025-03-18 07:01:23', 1, '2025-03-18 05:51:23'),
(9, 5, '5419', '2025-03-18 07:04:26', 1, '2025-03-18 05:54:26'),
(10, 5, '2437', '2025-03-18 07:06:09', 1, '2025-03-18 05:56:09'),
(11, 5, '2080', '2025-03-18 11:38:48', 1, '2025-03-18 05:58:48'),
(12, 5, '1265', '2025-03-18 11:59:21', 1, '2025-03-18 06:19:21'),
(13, 5, '2152', '2025-03-18 12:02:52', 1, '2025-03-18 06:22:52'),
(14, 5, '7465', '2025-03-18 12:15:03', 1, '2025-03-18 06:35:03'),
(15, 5, '6774', '2025-03-18 12:16:07', 0, '2025-03-18 06:36:07'),
(16, 13, '3035', '2025-03-18 12:55:55', 1, '2025-03-18 07:15:55'),
(17, 13, '7832', '2025-03-18 12:56:22', 0, '2025-03-18 07:16:22'),
(18, 1, '1241', '2025-03-18 12:56:58', 2, '2025-03-18 07:16:58'),
(19, 1, '9350', '2025-03-18 13:00:15', 2, '2025-03-18 07:20:15'),
(20, 32, '9268', '2025-03-18 13:09:14', 1, '2025-03-18 07:29:14'),
(21, 32, '1568', '2025-03-18 13:09:19', 1, '2025-03-18 07:29:19'),
(22, 32, '9684', '2025-03-18 13:09:58', 0, '2025-03-18 07:29:58'),
(23, 7, '6738', '2025-03-18 13:14:20', 1, '2025-03-18 07:34:20'),
(24, 7, '8854', '2025-03-18 13:38:22', 1, '2025-03-18 07:58:22'),
(25, 7, '2432', '2025-03-18 13:40:39', 1, '2025-03-18 08:00:39'),
(26, 7, '7836', '2025-03-18 13:50:31', 1, '2025-03-18 08:10:31'),
(27, 7, '7956', '2025-03-18 13:58:52', 1, '2025-03-18 08:18:52'),
(28, 7, '6116', '2025-03-18 14:00:44', 1, '2025-03-18 08:20:44'),
(29, 7, '1354', '2025-03-18 14:00:58', 1, '2025-03-18 08:20:58'),
(30, 7, '7260', '2025-03-18 14:01:19', 0, '2025-03-18 08:21:19'),
(31, 1, '8513', '2025-03-19 15:02:40', 2, '2025-03-19 09:22:40');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int NOT NULL,
  `user_id` int NOT NULL,
  `post_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_status` int NOT NULL DEFAULT '1' COMMENT '1=active, 0=inactive',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `post_content`, `post_status`, `created_at`, `updated_at`) VALUES
(1, 1, 'lllllll', 0, '2025-03-11 07:02:30', '2025-03-17 05:32:17'),
(2, 1, 'hajska', 1, '2025-03-11 07:03:17', '2025-03-12 02:37:27'),
(3, 1, 'video', 1, '2025-03-11 07:03:38', '2025-03-12 02:37:27'),
(4, 1, 'vinay', 1, '2025-03-11 07:04:01', '2025-03-12 02:37:27'),
(5, 1, 'kkkkkkk', 1, '2025-03-11 07:09:15', '2025-03-12 02:37:27'),
(6, 1, 'tqttqtq', 1, '2025-03-11 07:11:10', '2025-03-12 02:37:27'),
(7, 1, 'videos', 1, '2025-03-11 07:17:03', '2025-03-12 02:37:27'),
(8, 1, 'hhhhh', 1, '2025-03-11 07:18:52', '2025-03-12 02:37:27'),
(9, 1, 'vinay', 1, '2025-03-11 07:21:16', '2025-03-12 02:37:27'),
(10, 1, 'other', 1, '2025-03-11 07:29:01', '2025-03-12 02:37:27'),
(11, 1, 'again', 1, '2025-03-11 07:32:02', '2025-03-12 02:37:27'),
(12, 1, 'five again', 1, '2025-03-11 07:32:17', '2025-03-12 02:37:27'),
(13, 1, 'vinayyyyy', 1, '2025-03-11 07:37:36', '2025-03-12 02:37:27'),
(14, 19, 'shies', 1, '2025-03-11 07:48:34', '2025-03-12 02:37:27'),
(15, 19, 'ggggg', 1, '2025-03-11 07:54:44', '2025-03-12 02:37:27'),
(16, 19, 'vvvvvv', 1, '2025-03-11 08:30:28', '2025-03-12 02:37:27'),
(17, 19, 'videoio', 1, '2025-03-11 08:32:40', '2025-03-12 02:37:27'),
(18, 1, 'vudeo', 1, '2025-03-11 08:35:03', '2025-03-12 02:37:27'),
(19, 1, 'vjjjj', 1, '2025-03-11 09:07:16', '2025-03-12 02:37:27'),
(20, 1, 'shoes 👟', 1, '2025-03-11 09:07:48', '2025-03-12 02:37:27'),
(21, 1, 'jaiidd', 1, '2025-03-11 09:11:31', '2025-03-12 02:37:27'),
(22, 1, 'vjahs', 1, '2025-03-11 09:19:15', '2025-03-12 02:37:27'),
(23, 1, 'shoeeeeeees', 1, '2025-03-11 09:21:06', '2025-03-12 02:37:27'),
(24, 1, 'dancing', 1, '2025-03-11 09:37:25', '2025-03-12 02:37:27'),
(25, 1, 'bcbcj', 1, '2025-03-12 04:01:11', '2025-03-12 04:01:11'),
(26, 1, 'bcbcj', 1, '2025-03-12 04:02:44', '2025-03-12 04:02:44'),
(27, 1, 'bcbcj', 1, '2025-03-12 04:02:55', '2025-03-12 04:02:55'),
(28, 1, 'bcbcj', 1, '2025-03-12 04:02:55', '2025-03-12 04:02:55'),
(29, 1, 'bcbcj', 1, '2025-03-12 04:02:56', '2025-03-12 04:02:56'),
(30, 1, 'bcbcj', 1, '2025-03-12 04:03:00', '2025-03-12 04:03:00'),
(31, 1, 'bcbcj', 0, '2025-03-12 04:03:22', '2025-03-12 04:15:44'),
(32, 1, 'videoios', 1, '2025-03-12 04:05:02', '2025-03-12 04:05:02'),
(33, 1, 'asdfghjkl', 0, '2025-03-12 04:08:42', '2025-03-12 04:13:41'),
(34, 1, 'kshhdd', 1, '2025-03-12 04:16:53', '2025-03-12 04:16:53'),
(35, 1, 'lalala', 1, '2025-03-12 04:17:28', '2025-03-12 04:17:28'),
(36, 1, 'hsjjs', 1, '2025-03-12 04:19:21', '2025-03-12 04:19:21'),
(37, 1, 'hchfufufuf', 1, '2025-03-12 04:42:08', '2025-03-12 04:42:08'),
(38, 5, 'This is From Sohel', 1, '2025-03-12 04:55:37', '2025-03-12 04:55:37'),
(39, 1, 'videooooi', 1, '2025-03-12 05:03:38', '2025-03-12 05:03:38'),
(40, 1, 'alskahhs', 1, '2025-03-12 05:04:03', '2025-03-12 05:04:03'),
(41, 1, 'new video', 1, '2025-03-12 05:52:42', '2025-03-12 05:52:42'),
(42, 1, 'new video', 1, '2025-03-12 05:53:01', '2025-03-12 05:53:01'),
(43, 1, 'hajkd', 1, '2025-03-12 06:34:15', '2025-03-12 06:34:15'),
(44, 1, 'hajkd', 1, '2025-03-12 06:34:25', '2025-03-12 06:34:25'),
(45, 1, 'vvvvv', 1, '2025-03-12 06:36:54', '2025-03-12 06:36:54'),
(46, 1, 'hello', 1, '2025-03-12 06:40:46', '2025-03-12 06:40:46'),
(47, 1, 'videooo', 1, '2025-03-12 06:41:07', '2025-03-12 06:41:07'),
(48, 19, 'hello', 1, '2025-03-12 06:41:08', '2025-03-12 06:41:08'),
(49, 1, 'hhshs', 1, '2025-03-12 06:41:21', '2025-03-12 06:41:21'),
(50, 1, 'najsjsja', 1, '2025-03-12 06:46:32', '2025-03-12 06:46:32'),
(51, 1, 'hwhehsh', 1, '2025-03-12 06:48:49', '2025-03-12 06:48:49'),
(52, 5, 'This is From Sohel', 1, '2025-03-12 06:53:49', '2025-03-12 06:53:49'),
(53, 1, 'jahdhhd', 1, '2025-03-12 06:55:40', '2025-03-12 06:55:40'),
(54, 1, 'jagdjsja', 1, '2025-03-12 06:57:42', '2025-03-12 06:57:42'),
(55, 19, 'vjjjkjh', 1, '2025-03-12 06:59:55', '2025-03-12 06:59:55'),
(56, 19, 'vjjjkjh', 1, '2025-03-12 07:00:20', '2025-03-12 07:00:20'),
(57, 19, 'vjjjkjh', 1, '2025-03-12 07:00:27', '2025-03-12 07:00:27'),
(58, 1, 'gjthff', 1, '2025-03-12 07:00:37', '2025-03-12 07:00:37'),
(59, 19, 'bsjsjs', 0, '2025-03-12 07:03:50', '2025-03-12 07:04:50'),
(60, 1, 'yrydyfyd', 1, '2025-03-12 07:03:59', '2025-03-12 07:03:59'),
(61, 1, 'yrydyfyd', 1, '2025-03-12 07:04:20', '2025-03-12 07:04:20'),
(62, 1, 'hahsia', 1, '2025-03-12 07:04:42', '2025-03-12 07:04:42'),
(63, 1, 'jahhsha', 1, '2025-03-12 07:05:06', '2025-03-12 07:05:06'),
(64, 1, 'jJjdbsh', 1, '2025-03-12 07:06:41', '2025-03-12 07:06:41'),
(65, 1, 'dhagysw', 1, '2025-03-12 09:56:34', '2025-03-12 09:56:34'),
(66, 1, 'haheiahe', 1, '2025-03-12 09:57:43', '2025-03-12 09:57:43'),
(67, 1, 'hseiahe', 1, '2025-03-12 09:57:55', '2025-03-12 09:57:55'),
(68, 1, 'xhxgcgc', 1, '2025-03-12 10:15:17', '2025-03-12 10:15:17'),
(69, 1, 'imggg', 1, '2025-03-12 10:15:57', '2025-03-12 10:15:57'),
(70, 1, 'imggg', 1, '2025-03-12 10:16:05', '2025-03-12 10:16:05'),
(71, 1, 'imggg', 1, '2025-03-12 10:16:12', '2025-03-12 10:16:12'),
(72, 1, 'ggggggg', 1, '2025-03-12 10:16:42', '2025-03-12 10:16:42'),
(73, 19, 'hcjcj', 1, '2025-03-12 10:19:11', '2025-03-12 10:19:11'),
(74, 19, 'hcjcj', 1, '2025-03-12 10:19:17', '2025-03-12 10:19:17'),
(75, 19, 'rentttt', 1, '2025-03-12 11:28:02', '2025-03-12 11:28:02'),
(76, 5, 'This is From Sohel', 1, '2025-03-12 11:42:53', '2025-03-12 11:42:53'),
(77, 19, '123456h', 1, '2025-03-12 11:46:11', '2025-03-12 11:46:11'),
(78, 5, 'This is From Sohellll', 1, '2025-03-12 11:56:18', '2025-03-12 11:56:18'),
(79, 5, 'This is From Sohellll', 1, '2025-03-12 11:58:08', '2025-03-12 11:58:08'),
(80, 20, 'This is From Sohellll', 1, '2025-03-12 11:58:21', '2025-03-12 11:58:21'),
(81, 5, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum hctronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2025-03-13 02:47:46', '2025-03-13 02:47:46'),
(82, 19, 'Laksjdhf', 1, '2025-03-13 04:06:42', '2025-03-13 04:06:42'),
(83, 19, 'Laksjdh', 1, '2025-03-13 04:06:49', '2025-03-13 04:06:49'),
(84, 19, 'jahsiao', 1, '2025-03-13 04:07:38', '2025-03-13 04:07:38'),
(85, 19, 'carrrrr', 1, '2025-03-13 04:35:58', '2025-03-13 04:35:58'),
(86, 19, 'Ragnarock', 1, '2025-03-13 04:36:23', '2025-03-13 04:36:23'),
(87, 19, 'ccccrrrr7777', 1, '2025-03-13 04:38:07', '2025-03-13 04:38:07'),
(88, 32, 'dddddd', 1, '2025-03-13 05:23:56', '2025-03-13 05:23:56'),
(89, 32, 'dddddd', 1, '2025-03-13 05:24:06', '2025-03-13 05:24:06'),
(90, 32, 'nnnnn', 1, '2025-03-13 05:44:45', '2025-03-13 05:44:45'),
(91, 32, 'nnnnn', 1, '2025-03-13 05:45:12', '2025-03-13 05:45:12'),
(92, 32, 'nnnnnyyy', 1, '2025-03-13 05:45:23', '2025-03-13 05:45:23'),
(93, 32, 'nnnnnyyy', 1, '2025-03-13 05:45:34', '2025-03-13 05:45:34'),
(94, 35, 'captionsss', 1, '2025-03-13 06:14:43', '2025-03-13 06:14:43'),
(95, 35, 'posttttt', 1, '2025-03-13 06:57:49', '2025-03-13 06:57:49'),
(96, 35, 'postttt', 1, '2025-03-13 06:58:01', '2025-03-13 06:58:01'),
(97, 5, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum hctronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2025-03-17 09:42:37', '2025-03-17 09:42:37'),
(98, 5, 'Testasdfghgjhd', 1, '2025-03-17 10:19:19', '2025-03-17 10:19:19'),
(99, 19, 'hjzznnz', 1, '2025-03-17 10:30:21', '2025-03-17 10:30:21'),
(100, 32, 'bbbbbb', 1, '2025-03-17 10:40:28', '2025-03-17 10:40:28'),
(101, 32, 'bbbbbb', 1, '2025-03-17 10:40:30', '2025-03-17 10:40:30'),
(102, 32, 'bbbbbb', 1, '2025-03-17 10:40:35', '2025-03-17 10:40:35'),
(103, 32, 'yiufufuffxyc', 1, '2025-03-17 10:40:56', '2025-03-17 10:40:56'),
(104, 37, 'ayushhh.', 1, '2025-03-17 10:49:56', '2025-03-17 10:49:56'),
(105, 5, 'Testing New Notification Feature', 1, '2025-03-19 04:37:21', '2025-03-19 04:37:21'),
(106, 5, 'Testing New Notification Feature', 1, '2025-03-19 04:39:36', '2025-03-19 04:39:36'),
(107, 5, 'Testing New Notification Features', 1, '2025-03-19 04:41:54', '2025-03-19 04:41:54'),
(108, 1, 'Testing New Notification Features', 1, '2025-03-19 04:43:32', '2025-03-19 04:43:32'),
(109, 1, 'Testing New Notification Features', 1, '2025-03-19 04:48:05', '2025-03-19 04:48:05'),
(110, 1, 'Just Checking', 1, '2025-03-19 06:17:15', '2025-03-19 06:17:15'),
(111, 1, 'Just Checking 1', 1, '2025-03-19 06:18:10', '2025-03-19 06:18:10'),
(112, 1, 'Just Checking 2', 1, '2025-03-19 07:47:33', '2025-03-19 07:47:33'),
(113, 1, 'Just Checking 4', 1, '2025-03-19 08:53:25', '2025-03-19 08:53:25'),
(114, 1, 'Just Checking 5', 1, '2025-03-19 08:54:34', '2025-03-19 08:54:34'),
(115, 1, 'Testing...', 1, '2025-03-20 11:38:26', '2025-03-20 11:38:26'),
(116, 124, 'demooo', 1, '2025-03-20 11:58:02', '2025-03-20 11:58:02');

-- --------------------------------------------------------

--
-- Table structure for table `posts_media_master`
--

CREATE TABLE `posts_media_master` (
  `media_id` int NOT NULL,
  `post_id` int NOT NULL,
  `media` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts_media_master`
--

INSERT INTO `posts_media_master` (`media_id`, `post_id`, `media`) VALUES
(27, 34, '1741753013_post_video_1741753010872.mp4'),
(28, 35, '1741753048_post_video_1741753045790.mp4'),
(29, 36, '1741753161_post_video_1741753158412.mp4'),
(30, 37, '1741754528_post_image_1741754528084.jpg'),
(31, 38, '1741755337_VID-20250307-WA0002.mp4'),
(32, 39, '1741755818_post_video_1741755815713.mp4'),
(33, 40, '1741755843_post_video_1741755840355.mp4'),
(34, 42, '1741758781_post_video_1741758779418.mp4'),
(35, 44, '1741761265_post_video_1741761263039.mp4'),
(36, 45, '1741761414_post_video_1741761411719.mp4'),
(37, 47, '1741761667_post_video_1741761664915.mp4'),
(38, 49, '1741761681_post_video_1741761678925.mp4'),
(39, 50, '1741761992_post_video_1741761988876.mp4'),
(40, 51, '1741762130_post_video_1741762127087.mp4'),
(41, 52, '1741762429_bank.jpg'),
(42, 53, '1741762540_post_video_1741762537043.mp4'),
(43, 54, '1741762662_post_video_1741762658990.mp4'),
(44, 55, '1741762795_post_media_1741762795178.jpeg'),
(45, 57, '1741762827_post_media_1741762826302.jpeg'),
(46, 58, '1741762837_post_video_1741762834537.mp4'),
(48, 62, '1741763082_post_image_1741763077773.jpg'),
(49, 63, '1741763106_post_video_1741763103226.mp4'),
(50, 64, '1741763201_post_image_1741763199658.jpg'),
(51, 65, '1741773394_post_video_1741773391664.mp4'),
(52, 67, '1741773475_post_video_1741773472627.mp4'),
(53, 68, '1741774517_post_video_1741774516779.mp4'),
(54, 71, '1741774572_post_image_1741774571765.jpg'),
(55, 72, '1741774602_post_video_1741774600191.mp4'),
(56, 74, '1741774757_post_image_1741774756779.jpg'),
(57, 75, '1741778882_post_image_1741778879532.jpg'),
(58, 76, '1741779773_VID-20250307-WA0002.mp4'),
(59, 76, '1741779773_default.jpg'),
(60, 76, '1741779773_login.jpeg'),
(61, 77, '1741779971_post_video_1741779968517.mp4'),
(62, 78, '1741780578_VID-20250307-WA0002.mp4'),
(63, 78, '1741780578_default.jpg'),
(64, 78, '1741780578_login.jpeg'),
(65, 81, '1741834067_VID-20250307-WA0002.mp4'),
(66, 81, '1741834067_default.jpg'),
(68, 84, '1741838858_post_image_1741838856322.jpg'),
(69, 86, '1741840583_post_video_1741840579947.mp4'),
(70, 87, '1741840687_post_image_1741840685153.jpg'),
(71, 89, '1741843446_post_image_1741843446809.jpg'),
(72, 93, '1741844734_post_image_1741844734939.jpg'),
(73, 94, '1741846483_post_image_1741846480493.jpg'),
(75, 97, '1742204557_VID-20250307-WA0002.mp4'),
(76, 97, '1742204557_default.jpg'),
(77, 97, '1742204557_login.jpeg'),
(78, 98, '1742206759_VID-20250307-WA0002.mp4'),
(79, 98, '1742206759_default.jpg'),
(80, 98, '1742206759_login.jpeg'),
(81, 99, '1742207421_post_image_1742207422185.jpg'),
(82, 102, '1742208035_post_image_1742208035732.jpg'),
(84, 105, '1742359041_VID-20250307-WA0002.mp4'),
(85, 105, '1742359041_default.jpg'),
(87, 106, '1742359176_VID-20250307-WA0002.mp4'),
(88, 106, '1742359176_default.jpg'),
(89, 106, '1742359176_login.jpeg'),
(90, 107, '1742359314_VID-20250307-WA0002.mp4'),
(91, 107, '1742359314_default.jpg'),
(92, 107, '1742359314_login.jpeg'),
(93, 108, '1742359412_VID-20250307-WA0002.mp4'),
(94, 108, '1742359412_default.jpg'),
(95, 108, '1742359412_login.jpeg'),
(96, 109, '1742359685_default.jpg'),
(97, 109, '1742359685_login.jpeg'),
(98, 110, '1742365035_default.jpg'),
(99, 110, '1742365035_login.jpeg'),
(100, 111, '1742365090_default.jpg'),
(101, 111, '1742365090_login.jpeg'),
(102, 112, '1742370453_default.jpg'),
(103, 112, '1742370453_login.jpeg'),
(105, 113, '1742374405_login.jpeg'),
(106, 114, '1742374474_default.jpg'),
(107, 114, '1742374474_login.jpeg'),
(108, 115, '1742470706_default.jpg'),
(109, 115, '1742470706_login.jpeg'),
(110, 116, '1742471882_post_image_1742471881153.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `save_posts_master`
--

CREATE TABLE `save_posts_master` (
  `save_post_id` int NOT NULL,
  `user_id` int NOT NULL,
  `post_id` int NOT NULL,
  `status` int NOT NULL DEFAULT '1' COMMENT '1=active, 0=inactive',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `save_posts_master`
--

INSERT INTO `save_posts_master` (`save_post_id`, `user_id`, `post_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 46, 1, '2025-03-06 05:18:19', '2025-03-20 04:06:28'),
(2, 1, 3, 1, '2025-03-06 06:33:58', '2025-03-06 06:33:58'),
(3, 32, 96, 0, '2025-03-13 07:00:45', '2025-03-13 07:01:05'),
(4, 19, 98, 1, '2025-03-17 10:24:06', '2025-03-17 10:24:06'),
(5, 19, 94, 1, '2025-03-17 10:24:26', '2025-03-17 10:24:26'),
(6, 32, 103, 1, '2025-03-17 10:40:58', '2025-03-17 10:40:58'),
(7, 32, 102, 1, '2025-03-17 10:40:59', '2025-03-17 10:40:59'),
(8, 32, 99, 1, '2025-03-17 10:42:22', '2025-03-17 10:42:22'),
(9, 124, 116, 0, '2025-03-20 11:58:26', '2025-03-20 12:06:58');

-- --------------------------------------------------------

--
-- Table structure for table `user_master`
--

CREATE TABLE `user_master` (
  `user_id` int NOT NULL,
  `user_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_phone_number` bigint NOT NULL,
  `user_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_profile_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_bio` text COLLATE utf8mb4_unicode_ci,
  `user_status` int NOT NULL DEFAULT '1' COMMENT '1=active, 0=inactive',
  `user_isblock` int NOT NULL DEFAULT '1' COMMENT '1=unblocked,0=blocked',
  `user_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_master`
--

INSERT INTO `user_master` (`user_id`, `user_name`, `user_full_name`, `user_email`, `user_phone_number`, `user_password`, `gender`, `user_profile_photo`, `user_bio`, `user_status`, `user_isblock`, `user_created_at`, `user_updated_at`) VALUES
(1, 'Ertugrul_IYI', 'Engin Altan', 'akhtar47tarakwadiya@gmail.com', 1234567895, '$2y$10$Yo7GnZhXbNgjLpEJByPi0.Gra5ovqvbyxkDTqmxpsIfpEk8lYlnTe', 'Male', '/uploads/profile3.webp', 'Ertugrul Gazi', 1, 1, '2025-03-04 06:34:05', '2025-03-20 09:53:11'),
(5, 'Sohel_Khann', 'Sohel Khannnnnnn', 'snohell@gmail.com', 1234567851, '$2y$10$x3Jiw0T75Qtb7xljebCcMeumhtf3wFlunfsUbKjhggTjnXLb.RkGe', 'Male', '/uploads/1742366293_media_20250214_154421_1606718656966059338.jpg', 'Sohel Khan', 1, 1, '2025-03-04 06:46:40', '2025-03-20 03:49:37'),
(6, 'sohelll@123', 'Sohel Khan', '1234@gmail.com', 7894563216, '$2y$10$DusRp4tCOj1vP4DHp0JJzeGcpO3JZgJBt8kHQ8S3t0TY/eBc2btDq', 'male', '/uploads/profile3.webp', '', 1, 1, '2025-03-04 06:55:34', '2025-03-19 10:43:48'),
(7, 'bshs', 'Bhakti Dalwadi', 'bhaktidalwadi09@gmail.com', 5764646646, '$2y$10$oY7ffhxagz5UwDgY19NVBuOlvgRZVEvqnPviQU4vpy/TjMdENdwtO', 'FEMALE', '/uploads/profile3.webp', '', 1, 1, '2025-03-04 09:32:13', '2025-03-19 09:52:50'),
(8, 'prashil', 'prashil pagal', 'p@gmail.com', 5466494946, '$2y$10$orqlc9zWXSXjqDkbi9zHDurCScSLsicK85h4yOzP10Websh0Jdc5i', 'MALE', '/uploads/profile3.webp', '', 1, 1, '2025-03-04 09:38:03', '2025-03-20 03:49:41'),
(9, 'patel', 'Sherry L pettway', 'patel@gmail.com', 7389720166, '$2y$10$1AMZrNazgYIH3x7u9Tmz/eagZeK6qKgsIQRZnFtvgjhO1Q7eD3B.i', 'MALE', '/uploads/profile3.webp', '', 1, 1, '2025-03-04 09:49:03', '2025-03-17 06:05:05'),
(10, 'a', 'a', 'a@gmail.com', 8454664466, '$2y$10$CmdocAyrmnKiiH/uywJ1h.yJn44yn4BzMW/p6LRjsFTjg19syYVT6', 'MALE', '/uploads/profile3.webp', '', 1, 1, '2025-03-04 09:52:54', '2025-03-12 10:37:22'),
(11, 'm', 'm', 'm@gmail.com', 5464646949, '$2y$10$6xodDlgbpQhIHFgxjSl7ReFZJ5Z/EBmXUkRS11d2N7hFzoTEM.Bmu', 'MALE', '/uploads/profile3.webp', '', 1, 1, '2025-03-04 10:37:41', '2025-03-12 10:37:22'),
(12, 's', 's', 's@gmail.com', 9464946676, '$2y$10$BqJCp0c5n94/mpQJBtVJ7eTYirnAchzTCl621IkCLN2ZJKlqXMNcy', 'FEMALE', '/uploads/profile3.webp', '', 1, 1, '2025-03-04 10:40:50', '2025-03-19 09:45:39'),
(13, 'k', 'Bhakti Dalwadi', 'k@gmail.com', 8686868683, '$2y$10$NDyR/hcrhNF5UFxQj34Sf.ce3WCZfcn1R1Z2fnR8fFP/VcPMd/juC', 'FEMALE', '/uploads/profile3.webp', '', 1, 1, '2025-03-04 11:01:31', '2025-03-20 06:46:50'),
(14, 'ss', 'ss', 'ss@gmail.com', 5464646464, '$2y$10$BHn2otIBaaB5QYSJuzR3KOsCOGtZCxwCF9oTARi6bIxC5A8jfkLde', 'MALE', '/uploads/profile3.webp', '', 0, 1, '2025-03-04 11:10:15', '2025-03-12 10:37:22'),
(15, 'sohel@1234', 'Sohel Khan', '1243@gmail.com', 7894563217, '$2y$10$0koag9zP4RMsRWmzS5GDR.OdTXJsM0ed4WLE4.zVm8MOZz0zB3.c.', 'male', '/uploads/profile3.webp', '', 1, 1, '2025-03-04 11:51:55', '2025-03-12 10:37:22'),
(16, 'dixit', 'Dixit', 'd@gmail.com', 5464646466, '$2y$10$HZ8mh4JNi7FJgn0XFJJ/A.VXMuKtVOCmmReHE36GuQe7QyOao2UY2', 'MALE', '/uploads/profile3.webp', '', 1, 1, '2025-03-05 05:37:50', '2025-03-12 10:37:22'),
(17, 'b', 'Bhakti Dalwadi', 'b@gmail.com', 8764646676, '$2y$10$c2Tzqvti.vhsq5c/zwgP/uwf/tNZquILbmjtWPUtgB84N7OTakv0u', 'FEMALE', '/uploads/profile3.webp', '', 1, 1, '2025-03-06 04:45:15', '2025-03-12 10:37:22'),
(18, 'bhakti', 'Bhakti Dalwadi', 'bb@gmail.com', 8767646646, '$2y$10$dnPl4E6Rs/lDEOWTWnJx2Opqm9N8DqDTaHu02gKS1ZclboNbAmSkK', 'FEMALE', '/uploads/profile3.webp', '', 1, 1, '2025-03-06 05:20:45', '2025-03-12 10:37:22'),
(19, 'asss', 'Bhakti Dalwadi', 'as@gmail.com', 9098686868, '$2y$10$QzyaYTaZPnYzRJP/WGQpQ.u4qq1/vT7viD8Fo45a4inPs8Qbo.k7y', 'MALE', '/uploads/profile3.webp', '', 1, 1, '2025-03-06 05:29:10', '2025-03-17 10:33:51'),
(20, 'shriyansh', 'shriyansh', 'shriyanshpatel25@gmail.com', 7389728111, '$2y$10$z4u.S0synsGQsuk05MIJbOuQDmEur7lxlCLQR9zAEYRo5SWI9sxZ6', 'MALE', '/uploads/profile3.webp', '', 1, 1, '2025-03-06 05:47:06', '2025-03-12 10:37:22'),
(21, 'qq', 'Bhakti Dalwadi', 'q@gmail.com', 6767967676, '$2y$10$nZaw0hudtFvMdMW/VaEtVOuW9brtDCX5A1UQ3wwxJul.LqmN4SAqO', 'MALE', '/uploads/profile3.webp', '', 1, 1, '2025-03-06 07:01:37', '2025-03-12 10:37:22'),
(22, 'xyz', 'xyz', 'xyz@gmail.com', 9464664646, '$2y$10$GkkAZS7TzwG9djco6Mmu0einK.LfMqjNy9vaeOaQa3Ajmq1ZkEA36', 'MALE', '/uploads/profile3.webp', '', 1, 1, '2025-03-06 07:51:02', '2025-03-12 10:37:22'),
(23, 'Me', 'Bhakti Dalwadi', 'bhakti@gmail.com', 9464946646, '$2y$10$w6sza62kEgGV6RprI1IWo.2Ku7Ugxf3H4HL5gcmADNE0T7GeBRr7e', 'FEMALE', '/uploads/profile3.webp', '', 1, 1, '2025-03-07 06:11:47', '2025-03-12 10:37:22'),
(24, 'shreya', 'Bhakti Dalwadi', 'sp@gmail.com', 9464964646, '$2y$10$GUejT0xMlZfWR9SYvM.G8uAhRZS.4HFtseehoVVVrCzrgHyVOzRSO', 'FEMALE', '/uploads/profile3.webp', '', 1, 1, '2025-03-07 07:02:10', '2025-03-12 10:37:22'),
(25, 'lk', 'Bhakti Dalwadi', 'lk@gmail.com', 9764946464, '$2y$10$5kjmSfCSQYZ46L4cG960AeGJWxPrycQthwJAfxNR44aoWiaon/aQi', 'MALE', '/uploads/profile3.webp', '', 1, 1, '2025-03-07 07:22:04', '2025-03-12 10:37:22'),
(26, 'sohel@123', 'Sohel Khan', '123@gmail.com', 7894563210, '$2y$10$kNyE1zReEcgp43/qZcjRc.fY1IM/yFkUUEDj.n0G0TvraLl7r0Moy', 'male', '/uploads/profile3.webp', '', 0, 1, '2025-03-07 07:47:13', '2025-03-12 10:37:22'),
(27, 'sohel@12', 'Sohel Khan', '123455@gmail.com', 7894563255, '$2y$10$2DBCFtGR/pOEhMJPCJApF.cW8kRWwehyQqAXlfaWRQh2NC0hRlKla', 'male', '/uploads/profile3.webp\n', '', 1, 1, '2025-03-12 10:24:15', '2025-03-12 10:38:18'),
(28, 'sohel@1255', 'Sohel Khan', '12365456455@gmail.com', 7854563255, '$2y$10$bKpTcgRa2ULI.jPwO854euGMvAVvaq0ajLUY8iwGqA.E6XOySlAhG', 'male', '/uploads/profile3.webp', '', 1, 1, '2025-03-12 10:27:17', '2025-03-12 10:27:17'),
(29, 'ayushi', 'bhakti', 'au@gmail.com', 8767997676, '$2y$10$H7ui02TjFGS6NGAl6XYpJuS41du1RrBtI2NVCqsCM2M1yezhQE5z2', 'FEMALE', '/uploads/profile3.webp', '', 1, 1, '2025-03-12 11:07:50', '2025-03-12 11:07:50'),
(30, 'aayushi', 'bhakti', 'aau@gmail.com', 5764946646, '$2y$10$H2rNw5kYYIX1jhut90QKVOPmAVlfyMOLLzBsUvYfnJWMZkHGunhpi', 'FEMALE', '/uploads/profile3.webp', '', 1, 1, '2025-03-12 11:10:24', '2025-03-12 11:10:24'),
(31, 'pshsjs', 'gshshsh', 'pa@gmail.com', 9764646466, '$2y$10$T8e0Rl4qfIiLzAwEdybY8OjC5CuhoRTHrqGkROJTZY/1HkWjKmUAm', 'MALE', '/uploads/profile3.webp', '', 1, 1, '2025-03-12 11:15:35', '2025-03-12 11:15:35'),
(32, 'kaushal', 'kaushal', 'kaushal@gmail.com', 9464946466, '$2y$10$TuBrHx3B9KPW0N4QqnTMGuuLzDehM0nUSk3PAZ.k7NZqC9l97kCby', 'MALE', '/uploads/1742379141_Screenshot_20250317_213522_Instagram.jpg', '', 1, 1, '2025-03-13 05:22:20', '2025-03-19 10:12:21'),
(33, 'sohel', 'sohel', 'so@gmail.com', 9767997676, '$2y$10$d29CDKi8cNOKPcqXgCGWbO/JUZcmO5TbOSwoFvCdi3V5J1U91BfNy', 'MALE', '/uploads/profile3.webp', '', 1, 1, '2025-03-13 05:28:01', '2025-03-13 05:28:01'),
(34, 'abcd', 'Bhakti Dalwadi', 'abc@yahoo.com', 6464946466, '$2y$10$fm52pYQ9xLwrjFYwCdhMSelApur04M3f0fW/PGqchg.4lTOa9jPJ.', 'MALE', '/uploads/profile3.webp', '', 0, 1, '2025-03-13 05:58:46', '2025-03-13 07:00:52'),
(35, 'ttttt', 'ttttt', 't@gmail.com', 3333333333, '$2y$10$nOuUYl6jA/O7k/MPaXwrauMaRyqRy41EOyZd8HWbs1RNDd0ekaWdy', 'MALE', '/uploads/profile3.webp', '', 1, 1, '2025-03-13 06:13:55', '2025-03-13 07:00:50'),
(36, 'pratham', 'pratham', 'pratham@gmail.com', 2134664979, '$2y$10$RC0sd3UJvx.bIAFIX9Mr9en0k8aa4/KgyOk0IdK0sUTfnZuMvPLHq', 'MALE', '/uploads/profile3.webp', '', 1, 1, '2025-03-17 10:39:08', '2025-03-17 10:39:08'),
(37, 'ayush', 'ayush', 'ayush@gmail.com', 5434676676, '$2y$10$ATA1TvYBY8Klrarr0qNfWOmpRXTyK4gwtcVt4L3jWCI/.ACia3YYS', 'MALE', '/uploads/profile3.webp', '', 1, 1, '2025-03-17 10:49:01', '2025-03-17 10:49:01'),
(98, 'user_jan1', 'John Doe', 'johndoe1@example.com', 9876543201, 'hashed_pass1', 'Male', '/uploads/profile3.webp', 'Bio for John', 1, 1, '2025-01-05 04:45:00', '2025-03-20 07:46:17'),
(99, 'user_jan2', 'Jane Smith', 'janesmith2@example.com', 9876543202, 'hashed_pass2', 'Female', '/uploads/profile3.webp', 'Bio for Jane', 1, 1, '2025-01-20 09:00:00', '2025-03-20 07:46:21'),
(100, 'user_feb1', 'Mike Johnson', 'mikejohnson3@example.com', 9876543203, 'hashed_pass3', 'Male', '/uploads/profile3.webp', 'Bio for Mike', 1, 1, '2025-02-07 04:15:00', '2025-03-20 07:46:26'),
(101, 'user_feb2', 'Emily Brown', 'emilybrown4@example.com', 9876543204, 'hashed_pass4', 'Female', '/uploads/profile3.webp', 'Bio for Emily', 1, 1, '2025-02-15 10:40:00', '2025-03-20 07:46:29'),
(102, 'user_feb3', 'Chris Wilson', 'chriswilson5@example.com', 9876543205, 'hashed_pass5', 'Male', '/uploads/profile3.webp', 'Bio for Chris', 1, 1, '2025-02-25 06:20:00', '2025-03-20 07:46:33'),
(103, 'user_mar1', 'Anna White', 'annawhite6@example.com', 9876543206, 'hashed_pass6', 'Female', '/uploads/profile3.webp', 'Bio for Anna', 1, 0, '2025-03-03 03:00:00', '2025-03-20 09:53:23'),
(104, 'user_mar2', 'Tom Harris', 'tomharris7@example.com', 9876543207, 'hashed_pass7', 'Male', '/uploads/profile3.webp', 'Bio for Tom', 1, 1, '2025-03-10 07:50:00', '2025-03-20 07:46:40'),
(105, 'user_mar3', 'Sophia Martinez', 'sophiamartinez8@example.com', 9876543208, 'hashed_pass8', 'Female', '/uploads/profile3.webp', 'Bio for Sophia', 1, 1, '2025-03-18 12:15:00', '2025-03-20 07:46:44'),
(106, 'user_mar4', 'Daniel Clark', 'danielclark9@example.com', 9876543209, 'hashed_pass9', 'Male', '/uploads/profile3.webp', 'Bio for Daniel', 1, 1, '2025-03-27 09:30:00', '2025-03-20 07:46:48'),
(107, 'user_apr1', 'Olivia Lewis', 'olivialewis10@example.com', 9876543210, 'hashed_pass10', 'Female', '/uploads/profile3.webp', 'Bio for Olivia', 1, 1, '2025-04-04 07:10:00', '2025-03-20 07:46:51'),
(108, 'user_apr2', 'Liam Walker', 'liamwalker11@example.com', 9876543211, 'hashed_pass11', 'Male', '/uploads/profile3.webp', 'Bio for Liam', 1, 1, '2025-04-12 03:40:00', '2025-03-20 07:46:54'),
(109, 'user_apr3', 'Emma Hall', 'emmahall12@example.com', 9876543212, 'hashed_pass12', 'Female', '/uploads/profile3.webp', 'Bio for Emma', 1, 1, '2025-04-19 09:25:00', '2025-03-20 07:46:57'),
(110, 'user_apr4', 'Noah Allen', 'noahallen13@example.com', 9876543213, 'hashed_pass13', 'Male', '/uploads/profile3.webp', 'Bio for Noah', 1, 1, '2025-04-24 11:00:00', '2025-03-20 07:47:00'),
(111, 'user_apr5', 'Ava Scott', 'avascott14@example.com', 9876543214, 'hashed_pass14', 'Female', '/uploads/profile3.webp', 'Bio for Ava', 1, 1, '2025-04-29 04:35:00', '2025-03-20 07:47:07'),
(112, 'user_dec1', 'Jack Brooks', 'jackbrooks56@example.com', 9876543256, 'hashed_pass56', 'Male', '/uploads/profile3.webp', 'Bio for Jack', 1, 1, '2025-12-01 04:30:00', '2025-03-20 07:47:13'),
(113, 'user_dec2', 'Isabella Russell', 'isabellarussell57@example.com', 9876543257, 'hashed_pass57', 'Female', '/uploads/profile3.webp', 'Bio for Isabella', 1, 1, '2025-12-03 06:00:00', '2025-03-20 07:47:17'),
(114, 'user_dec3', 'William Perry', 'williamperry58@example.com', 9876543258, 'hashed_pass58', 'Male', '/uploads/profile3.webp', 'Bio for William', 1, 1, '2025-12-06 04:20:00', '2025-03-20 07:47:22'),
(115, 'user_dec4', 'Sophie Price', 'sophieprice59@example.com', 9876543259, 'hashed_pass59', 'Female', '/uploads/profile3.webp', 'Bio for Sophie', 1, 1, '2025-12-10 07:50:00', '2025-03-20 07:47:25'),
(116, 'user_dec5', 'Michael Stewart', 'michaelstewart60@example.com', 9876543260, 'hashed_pass60', 'Male', '/uploads/profile3.webp', 'Bio for Michael', 1, 1, '2025-12-14 11:30:00', '2025-03-20 07:47:31'),
(117, 'user_dec6', 'Charlotte Evans', 'charlotteevans61@example.com', 9876543261, 'hashed_pass61', 'Female', '/uploads/profile3.webp', 'Bio for Charlotte', 1, 1, '2025-12-17 09:10:00', '2025-03-20 07:47:34'),
(118, 'user_dec7', 'Lucas Green', 'lucasgreen62@example.com', 9876543262, 'hashed_pass62', 'Male', '/uploads/profile3.webp', 'Bio for Lucas', 1, 1, '2025-12-20 06:00:00', '2025-03-20 07:47:45'),
(119, 'user_dec8', 'Ella Turner', 'ellaturner63@example.com', 9876543263, 'hashed_pass63', 'Female', '/uploads/profile3.webp', 'Bio for Ella', 1, 1, '2025-12-23 02:50:00', '2025-03-20 07:47:49'),
(120, 'user_dec9', 'Benjamin Carter', 'benjamincarter64@example.com', 9876543264, 'hashed_pass64', 'Male', '/uploads/profile3.webp', 'Bio for Benjamin', 1, 1, '2025-12-26 10:45:00', '2025-03-20 07:47:52'),
(121, 'user_dec10', 'Zoe Harrison', 'zoeharrison65@example.com', 9876543265, 'hashed_pass65', 'Female', '/uploads/profile3.webp', 'Bio for Zoe', 1, 1, '2025-12-28 09:20:00', '2025-03-20 07:47:56'),
(122, 'user_dec11', 'Nathan Roberts', 'nathanroberts66@example.com', 9876543266, 'hashed_pass66', 'Male', '/uploads/profile3.webp', 'Bio for Nathan', 1, 1, '2025-12-30 06:35:00', '2025-03-20 07:48:01'),
(123, 'user_dec12', 'Leah Edwards', 'leahedwards67@example.com', 9876543267, 'hashed_pass67', 'Female', '/uploads/profile3.webp', 'Bio for Leah', 1, 1, '2025-12-31 12:30:00', '2025-03-20 07:48:11'),
(124, 'demo', 'demo', 'demo@gmail.com', 9767976769, '$2y$10$KBrtp5jZNglkq.U8mKUcqenl1bbZ5rrUUyvgrYz3MAyrDoeMOzRK.', 'MALE', '/uploads/1742471934_Screenshot_20250317_213522_Instagram.jpg', '', 1, 1, '2025-03-20 11:57:48', '2025-03-20 11:58:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_master`
--
ALTER TABLE `admin_master`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admin_email` (`admin_email`,`admin_phone`);

--
-- Indexes for table `comments_master`
--
ALTER TABLE `comments_master`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `posts_id` (`post_id`),
  ADD KEY `users_id` (`user_id`);

--
-- Indexes for table `follow_master`
--
ALTER TABLE `follow_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_follow` (`follower_id`,`following_id`),
  ADD KEY `followe_master_ibfk_2` (`following_id`);

--
-- Indexes for table `likes_master`
--
ALTER TABLE `likes_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notifications_user` (`user_id`),
  ADD KEY `fk_notifications_sender` (`sender_id`),
  ADD KEY `fk_notifications_post` (`post_id`);

--
-- Indexes for table `otp_verification`
--
ALTER TABLE `otp_verification`
  ADD PRIMARY KEY (`otp_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `posts_media_master`
--
ALTER TABLE `posts_media_master`
  ADD PRIMARY KEY (`media_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `save_posts_master`
--
ALTER TABLE `save_posts_master`
  ADD PRIMARY KEY (`save_post_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_master`
--
ALTER TABLE `user_master`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_email` (`user_email`,`user_phone_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_master`
--
ALTER TABLE `admin_master`
  MODIFY `admin_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `comments_master`
--
ALTER TABLE `comments_master`
  MODIFY `comment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `follow_master`
--
ALTER TABLE `follow_master`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `likes_master`
--
ALTER TABLE `likes_master`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `otp_verification`
--
ALTER TABLE `otp_verification`
  MODIFY `otp_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `posts_media_master`
--
ALTER TABLE `posts_media_master`
  MODIFY `media_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `save_posts_master`
--
ALTER TABLE `save_posts_master`
  MODIFY `save_post_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_master`
--
ALTER TABLE `user_master`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments_master`
--
ALTER TABLE `comments_master`
  ADD CONSTRAINT `posts_id` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_id` FOREIGN KEY (`user_id`) REFERENCES `user_master` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `follow_master`
--
ALTER TABLE `follow_master`
  ADD CONSTRAINT `follow_master_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `user_master` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `follow_master_ibfk_2` FOREIGN KEY (`following_id`) REFERENCES `user_master` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likes_master`
--
ALTER TABLE `likes_master`
  ADD CONSTRAINT `likes_master_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_master_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user_master` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notifications_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_notifications_sender` FOREIGN KEY (`sender_id`) REFERENCES `user_master` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_notifications_user` FOREIGN KEY (`user_id`) REFERENCES `user_master` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `otp_verification`
--
ALTER TABLE `otp_verification`
  ADD CONSTRAINT `otp_verification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_master` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user_master` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts_media_master`
--
ALTER TABLE `posts_media_master`
  ADD CONSTRAINT `post_id` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `save_posts_master`
--
ALTER TABLE `save_posts_master`
  ADD CONSTRAINT `save_posts_master_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `save_posts_master_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user_master` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
