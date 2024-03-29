-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2023-03-21 08:45:35
-- 伺服器版本： 10.4.24-MariaDB
-- PHP 版本： 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `vote`
--

-- --------------------------------------------------------

--
-- 資料表結構 `projectvote_log`
--

CREATE TABLE `projectvote_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `subject_id` int(10) UNSIGNED DEFAULT NULL,
  `daily_subject_id` int(10) UNSIGNED DEFAULT NULL,
  `ip` varchar(16) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `option_id` varchar(128) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- 傾印資料表的資料 `projectvote_log`
--

INSERT INTO `projectvote_log` (`id`, `user_id`, `subject_id`, `daily_subject_id`, `ip`, `option_id`, `created_at`) VALUES
(21, 12, 67, NULL, '::1', '142', '2022-12-20 15:40:02'),
(23, 12, 71, NULL, '::1', '150', '2022-12-21 05:36:09'),
(24, 1, 71, NULL, '::1', '150', '2022-12-21 05:39:37'),
(33, 1, 74, NULL, '::1', '156', '2022-12-24 14:01:51'),
(34, 1, NULL, 3, '::1', '7', '2022-12-24 14:35:21'),
(35, 1, NULL, 4, '::1', '9', '2022-12-24 16:36:36'),
(36, 12, NULL, 4, '::1', '8', '2022-12-25 04:26:54');

-- --------------------------------------------------------

--
-- 資料表結構 `projectvote_login`
--

CREATE TABLE `projectvote_login` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- 傾印資料表的資料 `projectvote_login`
--

INSERT INTO `projectvote_login` (`id`, `user_id`, `login_time`) VALUES
(1, 1, '2022-12-24 01:39:08'),
(2, 12, '2022-12-24 01:42:19'),
(3, 1, '2022-12-24 01:43:58'),
(4, 12, '2022-12-24 02:45:03'),
(5, 1, '2022-12-24 02:45:21'),
(6, 12, '2022-12-24 03:02:34'),
(7, 1, '2022-12-24 03:15:01'),
(8, 1, '2022-12-24 14:35:02'),
(9, 12, '2022-12-25 01:57:39'),
(10, 12, '2022-12-25 01:58:45'),
(11, 12, '2022-12-25 02:03:11'),
(12, 12, '2022-12-25 02:03:56'),
(13, 12, '2022-12-25 02:04:17'),
(14, 12, '2022-12-25 02:09:50'),
(15, 12, '2022-12-25 02:10:16'),
(16, 12, '2022-12-25 02:15:12'),
(17, 12, '2022-12-25 02:17:45'),
(18, 12, '2022-12-25 02:19:10'),
(19, 12, '2022-12-25 02:21:08'),
(20, 12, '2022-12-25 02:22:06'),
(21, 12, '2022-12-25 02:23:13'),
(22, 12, '2022-12-25 02:23:43'),
(23, 12, '2022-12-25 02:26:00'),
(24, 12, '2022-12-25 02:26:29'),
(25, 12, '2022-12-25 02:30:01'),
(26, 12, '2022-12-25 02:30:26'),
(27, 12, '2022-12-25 02:33:42'),
(28, 12, '2022-12-25 02:34:18'),
(29, 12, '2022-12-25 02:35:09'),
(30, 12, '2022-12-25 02:44:23'),
(31, 12, '2022-12-25 02:48:15'),
(32, 1, '2022-12-25 02:49:10'),
(33, 12, '2022-12-25 04:26:49'),
(34, 1, '2022-12-25 05:57:35'),
(35, 12, '2022-12-25 05:57:43'),
(36, 12, '2023-01-19 07:24:09'),
(37, 1, '2023-01-19 07:26:00'),
(38, 12, '2023-01-19 10:31:06'),
(39, 1, '2023-01-19 12:44:23'),
(40, 1, '2023-01-27 06:03:33'),
(41, 1, '2023-01-27 07:23:25'),
(42, 12, '2023-01-27 08:03:11'),
(43, 1, '2023-01-27 08:03:39'),
(44, 1, '2023-02-01 13:00:36'),
(45, 1, '2023-02-01 13:00:37'),
(46, 1, '2023-02-08 13:30:43'),
(47, 1, '2023-02-13 10:58:49'),
(48, 0, '2023-03-19 11:49:42'),
(49, 13, '2023-03-19 11:50:47'),
(50, 13, '2023-03-19 11:51:14'),
(51, 13, '2023-03-19 11:51:40'),
(52, 13, '2023-03-19 13:21:48'),
(53, 1, '2023-03-21 04:45:18');

-- --------------------------------------------------------

--
-- 資料表結構 `projectvote_subject`
--

CREATE TABLE `projectvote_subject` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(64) COLLATE utf8mb4_unicode_520_ci NOT NULL COMMENT '投票主題',
  `description` text COLLATE utf8mb4_unicode_520_ci DEFAULT NULL COMMENT '描述',
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '投票類型',
  `vote` int(10) NOT NULL DEFAULT 0 COMMENT '被投票次數',
  `private` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否為私人投票',
  `category_id` int(10) UNSIGNED NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '開始時間',
  `end_time` timestamp NULL DEFAULT NULL COMMENT '結束時間',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `check_num` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- 傾印資料表的資料 `projectvote_subject`
--

INSERT INTO `projectvote_subject` (`id`, `title`, `description`, `type`, `vote`, `private`, `category_id`, `start_time`, `end_time`, `created_at`, `update_at`, `check_num`) VALUES
(67, '今年元旦會去跨年嗎?', '迎接2023大家都怎麼過?', 0, 1, 1, 1, '2022-12-22 16:00:00', '2023-01-02 15:59:59', '2022-12-20 15:36:37', '2023-01-19 12:12:18', 59086686),
(69, '測試私人投票無權限', '測試私人投票無權限', 0, 0, 2, 1, '2022-12-20 16:00:00', '2023-01-21 15:59:59', '2022-12-21 02:20:47', '2022-12-21 02:20:47', 79655455),
(71, '測試看結果', '測試看結果', 0, 2, 1, 1, '2022-12-20 16:00:00', '2023-01-21 15:59:59', '2022-12-21 05:36:03', '2023-01-19 10:33:14', 98588040),
(72, '生活未開始測試', '生活未開始測試', 0, 0, 1, 1, '2022-12-24 16:00:00', '2023-01-21 15:59:59', '2022-12-21 06:55:19', '2022-12-24 13:46:38', 11650261),
(74, '政治未開始測試', '政治未開始測試未開始測試', 0, 1, 1, 2, '2022-12-20 16:00:00', '2023-01-22 15:59:59', '2022-12-21 06:56:17', '2022-12-24 14:01:51', 43511399),
(83, '12121', '1212', 0, 0, 1, 3, '2022-12-19 16:00:00', '2022-12-21 15:59:59', '2022-12-24 14:17:29', '2022-12-24 14:28:01', 15640739),
(85, '測試模組功能', '測試模組11', 1, 0, 0, 1, '2023-01-18 16:00:00', '2023-01-20 15:59:59', '2023-01-19 09:10:05', '2023-01-19 09:10:05', 82301746),
(87, '測試筆數1', '測試筆數1', 0, 0, 0, 1, '2023-01-18 16:00:00', '2023-02-19 15:59:59', '2023-01-19 11:37:43', '2023-01-19 11:37:43', 17767566),
(88, '測試筆數1', '測試筆數1', 0, 0, 0, 1, '2023-01-18 16:00:00', '2023-02-19 15:59:59', '2023-01-19 11:37:50', '2023-01-19 11:37:50', 45221475),
(89, '測試筆數1', '測試筆數1', 0, 0, 0, 1, '2023-01-18 16:00:00', '2023-02-19 15:59:59', '2023-01-19 11:37:55', '2023-01-19 11:37:55', 18801066),
(90, '測試筆數1', '測試筆數1', 0, 0, 0, 1, '2023-01-18 16:00:00', '2023-02-19 15:59:59', '2023-01-19 11:38:02', '2023-01-19 11:38:02', 92873920),
(91, '測試筆數1', '測試筆數1', 0, 0, 0, 1, '2023-01-18 16:00:00', '2023-02-19 15:59:59', '2023-01-19 11:38:08', '2023-01-19 11:38:08', 59804819),
(92, '測試筆數1', '測試筆數1', 0, 0, 0, 1, '2023-01-18 16:00:00', '2023-02-19 15:59:59', '2023-01-19 11:38:14', '2023-01-19 11:38:14', 66024522),
(93, '測試筆數1', '測試筆數1', 0, 0, 0, 1, '2023-01-18 16:00:00', '2023-02-19 15:59:59', '2023-01-19 11:38:21', '2023-01-19 11:38:21', 54709671),
(94, '測試筆數1', '測試筆數1', 0, 0, 0, 1, '2023-01-18 16:00:00', '2023-02-19 15:59:59', '2023-01-19 11:38:31', '2023-01-19 11:38:31', 95363898),
(95, '測試筆數1', '測試筆數1', 0, 0, 0, 1, '2023-01-18 16:00:00', '2023-02-19 15:59:59', '2023-01-19 11:38:37', '2023-01-19 11:38:37', 53440259),
(96, '測試換頁', '測試換頁1', 0, 0, 0, 1, '2023-01-18 16:00:00', '2023-02-19 15:59:59', '2023-01-19 12:13:16', '2023-01-19 12:13:16', 24524300),
(97, '測試跳轉', '111', 0, 0, 0, 1, '2023-02-11 16:00:00', '2023-03-13 15:59:59', '2023-02-13 10:59:18', '2023-02-13 11:32:25', 32399812),
(98, '測試111', '111', 0, 0, 0, 1, '2023-02-12 16:00:00', '2023-03-13 15:59:59', '2023-02-13 11:31:30', '2023-02-13 11:31:30', 10134200);

-- --------------------------------------------------------

--
-- 資料表結構 `projectvote_subject_category`
--

CREATE TABLE `projectvote_subject_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `category` varchar(32) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- 傾印資料表的資料 `projectvote_subject_category`
--

INSERT INTO `projectvote_subject_category` (`id`, `category`) VALUES
(1, '生活'),
(2, '政治'),
(3, '星座'),
(4, '趣味');

-- --------------------------------------------------------

--
-- 資料表結構 `projectvote_subject_daily`
--

CREATE TABLE `projectvote_subject_daily` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(64) COLLATE utf8mb4_unicode_520_ci NOT NULL COMMENT '主題',
  `description` text COLLATE utf8mb4_unicode_520_ci NOT NULL COMMENT '描述',
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '投票類型',
  `vote` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '被投票次數',
  `image` int(10) UNSIGNED DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '開始時間',
  `end_time` timestamp NULL DEFAULT NULL COMMENT '結束時間',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `check_num` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- 傾印資料表的資料 `projectvote_subject_daily`
--

INSERT INTO `projectvote_subject_daily` (`id`, `title`, `description`, `type`, `vote`, `image`, `start_time`, `end_time`, `created_at`, `update_at`, `check_num`) VALUES
(3, '狗派還是貓派', '狗派還是貓派', 0, 1, 5, '2022-12-23 16:00:00', '2022-12-24 15:59:59', '2022-12-23 12:48:45', '2022-12-24 14:35:21', 38852176),
(4, '粽子大對決', '南部粽,北部粽,哪個才是王道?', 0, 2, 8, '2022-12-24 16:00:00', '2022-12-25 15:59:59', '2022-12-24 03:17:08', '2022-12-25 04:26:54', 47909368),
(6, '粽子大對決', '南部粽,北部粽,哪個才是王道?', 0, 0, 11, '2022-12-25 16:00:00', '2022-12-26 15:59:59', '2022-12-24 05:49:07', '2022-12-24 05:50:11', 45342876),
(8, '測試設圖片', '測試設圖片', 1, 0, 1, '2022-12-22 16:00:00', '2022-12-23 15:59:59', '2022-12-24 10:16:55', '2022-12-24 13:44:42', 39769670),
(9, '測試元件化功能', '測試元件合併功能', 0, 0, 13, '2023-01-26 16:00:00', '2023-01-27 15:59:59', '2023-01-19 09:11:05', '2023-01-27 08:06:13', 9342364);

-- --------------------------------------------------------

--
-- 資料表結構 `projectvote_subject_daily_options`
--

CREATE TABLE `projectvote_subject_daily_options` (
  `id` int(10) UNSIGNED NOT NULL,
  `subject_id` int(10) UNSIGNED NOT NULL,
  `opt` varchar(64) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `vote` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- 傾印資料表的資料 `projectvote_subject_daily_options`
--

INSERT INTO `projectvote_subject_daily_options` (`id`, `subject_id`, `opt`, `vote`, `created_at`, `update_at`) VALUES
(6, 3, '狗', 0, '2022-12-23 12:48:45', '2022-12-23 12:48:45'),
(7, 3, '貓', 1, '2022-12-23 12:48:45', '2022-12-24 14:35:21'),
(8, 4, '南部粽', 1, '2022-12-24 03:17:08', '2022-12-25 04:26:54'),
(9, 4, '北部粽', 1, '2022-12-24 03:17:08', '2022-12-24 16:36:36'),
(15, 6, '南部粽', 0, '2022-12-24 05:49:07', '2022-12-24 05:49:07'),
(16, 6, '北部粽', 0, '2022-12-24 05:49:07', '2022-12-24 05:49:07'),
(19, 8, '測試設圖片1', 0, '2022-12-24 10:16:55', '2022-12-24 10:16:55'),
(20, 8, '測試設圖片2', 0, '2022-12-24 10:16:55', '2022-12-24 10:16:55'),
(22, 9, '測試元件合併功能1', 0, '2023-01-19 09:11:05', '2023-01-19 09:11:05'),
(23, 9, '測試元件合併功能2', 0, '2023-01-19 09:11:05', '2023-01-19 09:11:05');

-- --------------------------------------------------------

--
-- 資料表結構 `projectvote_subject_options`
--

CREATE TABLE `projectvote_subject_options` (
  `id` int(10) UNSIGNED NOT NULL,
  `subject_id` int(10) UNSIGNED NOT NULL,
  `opt` varchar(64) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `vote` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- 傾印資料表的資料 `projectvote_subject_options`
--

INSERT INTO `projectvote_subject_options` (`id`, `subject_id`, `opt`, `vote`, `created_at`, `update_at`) VALUES
(141, 67, '年~是一定要跨的', 0, '2022-12-20 15:36:37', '2022-12-20 15:36:37'),
(142, 67, '冷死了才不要人擠人', 1, '2022-12-20 15:36:37', '2022-12-20 15:36:37'),
(146, 69, '測試1', 0, '2022-12-21 02:20:47', '2022-12-21 02:20:47'),
(147, 69, '測試2', 0, '2022-12-21 02:20:47', '2022-12-21 02:20:47'),
(150, 71, '測', 2, '2022-12-21 05:36:03', '2022-12-21 05:36:03'),
(151, 71, '試', 0, '2022-12-21 05:36:03', '2022-12-21 05:36:03'),
(152, 72, '生活1', 0, '2022-12-21 06:55:19', '2022-12-21 06:55:19'),
(153, 72, '生活2', 0, '2022-12-21 06:55:19', '2022-12-21 06:55:19'),
(156, 74, '政治未開始測試1', 1, '2022-12-21 06:56:17', '2022-12-21 06:56:17'),
(157, 74, '政治未開始測試2', 0, '2022-12-21 06:56:17', '2022-12-21 06:56:17'),
(178, 83, '212', 0, '2022-12-24 14:17:29', '2022-12-24 14:17:29'),
(179, 83, '1212', 0, '2022-12-24 14:17:29', '2022-12-24 14:17:29'),
(183, 85, '測試功能', 0, '2023-01-19 09:10:05', '2023-01-19 09:10:05'),
(184, 85, '正不正常', 0, '2023-01-19 09:10:05', '2023-01-19 09:10:05'),
(185, 85, '1212', 0, '2023-01-19 09:10:05', '2023-01-19 09:10:05'),
(188, 87, '測試筆數1', 0, '2023-01-19 11:37:43', '2023-01-19 11:37:43'),
(189, 87, '測試筆數2', 0, '2023-01-19 11:37:43', '2023-01-19 11:37:43'),
(190, 88, '測試筆數1', 0, '2023-01-19 11:37:50', '2023-01-19 11:37:50'),
(191, 88, '測試筆數2', 0, '2023-01-19 11:37:50', '2023-01-19 11:37:50'),
(192, 89, '測試筆數1', 0, '2023-01-19 11:37:55', '2023-01-19 11:37:55'),
(193, 89, '測試筆數2', 0, '2023-01-19 11:37:55', '2023-01-19 11:37:55'),
(194, 90, '測試筆數1', 0, '2023-01-19 11:38:02', '2023-01-19 11:38:02'),
(195, 90, '測試筆數2', 0, '2023-01-19 11:38:02', '2023-01-19 11:38:02'),
(196, 91, '測試筆數1', 0, '2023-01-19 11:38:08', '2023-01-19 11:38:08'),
(197, 91, '測試筆數2', 0, '2023-01-19 11:38:08', '2023-01-19 11:38:08'),
(198, 92, '測試筆數1', 0, '2023-01-19 11:38:14', '2023-01-19 11:38:14'),
(199, 92, '測試筆數2', 0, '2023-01-19 11:38:14', '2023-01-19 11:38:14'),
(200, 93, '測試筆數1', 0, '2023-01-19 11:38:21', '2023-01-19 11:38:21'),
(201, 93, '測試筆數2', 0, '2023-01-19 11:38:21', '2023-01-19 11:38:21'),
(202, 94, '測試筆數1', 0, '2023-01-19 11:38:31', '2023-01-19 11:38:31'),
(203, 94, '測試筆數2', 0, '2023-01-19 11:38:31', '2023-01-19 11:38:31'),
(204, 95, '測試筆數1', 0, '2023-01-19 11:38:37', '2023-01-19 11:38:37'),
(205, 95, '測試筆數2', 0, '2023-01-19 11:38:37', '2023-01-19 11:38:37'),
(206, 96, '測試換頁1', 0, '2023-01-19 12:13:16', '2023-01-19 12:13:16'),
(207, 96, '測試換頁2', 0, '2023-01-19 12:13:16', '2023-01-19 12:13:16'),
(208, 97, '11', 0, '2023-02-13 10:59:18', '2023-02-13 10:59:18'),
(209, 97, '1', 0, '2023-02-13 10:59:18', '2023-02-13 10:59:18'),
(210, 98, '11', 0, '2023-02-13 11:31:30', '2023-02-13 11:31:30'),
(211, 98, '1', 0, '2023-02-13 11:31:30', '2023-02-13 11:31:30');

-- --------------------------------------------------------

--
-- 資料表結構 `projectvote_subject_users`
--

CREATE TABLE `projectvote_subject_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `subject_id` int(10) UNSIGNED NOT NULL,
  `account` varchar(128) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `auth` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '權限\r\n0=owner\r\n1=member'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- 傾印資料表的資料 `projectvote_subject_users`
--

INSERT INTO `projectvote_subject_users` (`id`, `subject_id`, `account`, `auth`) VALUES
(44, 67, 'EEE@gmail.com', 0),
(49, 71, 'EEE@gmail.com', 0),
(51, 69, 'EEE@gmail.com', 1),
(52, 72, 'amy1111@gmail.com', 0),
(54, 74, 'amy1111@gmail.com', 0),
(63, 83, 'amy1111@gmail.com', 0),
(67, 85, 'amy1111@gmail.com', 0),
(73, 87, 'EEE@gmail.com', 0),
(74, 88, 'EEE@gmail.com', 0),
(75, 89, 'EEE@gmail.com', 0),
(76, 90, 'EEE@gmail.com', 0),
(77, 91, 'EEE@gmail.com', 0),
(78, 92, 'EEE@gmail.com', 0),
(79, 93, 'EEE@gmail.com', 0),
(80, 94, 'EEE@gmail.com', 0),
(81, 95, 'EEE@gmail.com', 0),
(82, 96, 'EEE@gmail.com', 0),
(83, 97, 'amy1111@gmail.com', 0),
(84, 98, 'amy1111@gmail.com', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `projectvote_upload`
--

CREATE TABLE `projectvote_upload` (
  `id` int(10) UNSIGNED NOT NULL,
  `file_name` varchar(64) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `size` int(10) UNSIGNED NOT NULL,
  `type` varchar(64) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `upload_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- 傾印資料表的資料 `projectvote_upload`
--

INSERT INTO `projectvote_upload` (`id`, `file_name`, `size`, `type`, `description`, `upload_time`) VALUES
(1, 'daily_default.jpg', 40462, 'jpg', NULL, '2022-12-21 15:07:29'),
(5, '20221223204845.jpeg', 446300, 'jpeg', NULL, '2022-12-23 12:48:45'),
(8, '20221224114638.jpeg', 724967, 'jpeg', NULL, '2022-12-24 03:46:38'),
(11, '20221224135011.jpeg', 724967, 'jpeg', NULL, '2022-12-24 05:50:11'),
(13, '20230119171105.jpeg', 446300, 'jpeg', NULL, '2023-01-19 09:11:05');

-- --------------------------------------------------------

--
-- 資料表結構 `projectvote_users`
--

CREATE TABLE `projectvote_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `account` varchar(64) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `email` varchar(128) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `tel` varchar(10) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `level` tinyint(4) NOT NULL DEFAULT 1,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- 傾印資料表的資料 `projectvote_users`
--

INSERT INTO `projectvote_users` (`id`, `account`, `password`, `name`, `email`, `tel`, `level`, `last_login`, `created_at`, `update_at`) VALUES
(1, 'amy1111@gmail.com', 'A11111111', 'azami', 'doggy0704@gmail.com', '0931394552', 0, '2023-03-21 04:45:18', '2022-12-14 00:36:16', '2023-03-21 04:45:18'),
(2, '1111@gmail.com', '2222', '測試2', '1111@gmail.com', '0', 1, '2023-03-19 11:49:42', '2022-12-14 05:08:48', '2023-03-19 11:49:42'),
(3, 'test2@gmail.com', '1122', '測試3', 'test2@gmail.com', '0', 1, '2023-03-19 11:49:42', '2022-12-14 05:33:37', '2023-03-19 11:49:42'),
(4, 'test123@gmail.com', '0000', 'aaaa', 'test123@gmail.com', '912345678', 1, '2023-03-19 11:49:42', '2022-12-14 06:34:48', '2023-03-19 11:49:42'),
(5, 'ssss@gmail.com', 'AADD1234', '測試帳號', 'ssss@gmail.com', '0', 1, '2023-03-19 11:49:42', '2022-12-14 06:36:19', '2023-03-19 11:49:42'),
(6, 'FFFF@gmail.com', '1111', 'CCC', 'FFFF@gmail.com', '0', 1, '2023-03-19 11:49:42', '2022-12-14 07:02:49', '2023-03-19 11:49:42'),
(7, 'HHH@gmail.com', 'AAAAAA', 'test123', 'HHH@gmail.com', '0', 1, '2023-03-19 11:49:42', '2022-12-14 07:11:44', '2023-03-19 11:49:42'),
(8, 'KKKK@gmail.com', '3DDD1234', '1111', 'KKKK@gmail.com', '0', 1, '2023-03-19 11:49:42', '2022-12-14 07:49:03', '2023-03-19 11:49:42'),
(9, 'NB@gmail.com', 'AAAAAAAAA', 'AA', 'NB@gmail.com', '0', 1, '2023-03-19 11:49:42', '2022-12-14 07:51:52', '2023-03-19 11:49:42'),
(10, 'KKJJ@gmail.com', 'gOOgle123', '11', 'KKJJ@gmail.com', '0', 1, '2023-03-19 11:49:42', '2022-12-14 07:52:52', '2023-03-19 11:49:42'),
(11, 'AAAA@gmail.com', 'Q11111111', '1234', 'AAAA@gmail.com', '', 1, '2023-03-19 11:49:42', '2022-12-20 11:51:14', '2023-03-19 11:49:42'),
(12, 'EEE@gmail.com', 'X11111111', 'test124', 'EEE@gmail.com', '', 1, '2023-03-19 11:49:42', '2022-12-20 13:32:51', '2023-03-19 11:49:42'),
(13, 'admin@gmail.com', 'Admin1234', '管理員', 'admin@gmail.com', '111', 0, '2023-03-19 13:21:48', '2023-03-19 11:50:40', '2023-03-19 13:21:48');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `projectvote_log`
--
ALTER TABLE `projectvote_log`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `projectvote_login`
--
ALTER TABLE `projectvote_login`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `projectvote_subject`
--
ALTER TABLE `projectvote_subject`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `projectvote_subject_category`
--
ALTER TABLE `projectvote_subject_category`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `projectvote_subject_daily`
--
ALTER TABLE `projectvote_subject_daily`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `projectvote_subject_daily_options`
--
ALTER TABLE `projectvote_subject_daily_options`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `projectvote_subject_options`
--
ALTER TABLE `projectvote_subject_options`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `projectvote_subject_users`
--
ALTER TABLE `projectvote_subject_users`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `projectvote_upload`
--
ALTER TABLE `projectvote_upload`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `projectvote_users`
--
ALTER TABLE `projectvote_users`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `projectvote_log`
--
ALTER TABLE `projectvote_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `projectvote_login`
--
ALTER TABLE `projectvote_login`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `projectvote_subject`
--
ALTER TABLE `projectvote_subject`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `projectvote_subject_category`
--
ALTER TABLE `projectvote_subject_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `projectvote_subject_daily`
--
ALTER TABLE `projectvote_subject_daily`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `projectvote_subject_daily_options`
--
ALTER TABLE `projectvote_subject_daily_options`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `projectvote_subject_options`
--
ALTER TABLE `projectvote_subject_options`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `projectvote_subject_users`
--
ALTER TABLE `projectvote_subject_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `projectvote_upload`
--
ALTER TABLE `projectvote_upload`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `projectvote_users`
--
ALTER TABLE `projectvote_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
