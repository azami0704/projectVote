-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2022-12-22 09:27:01
-- 伺服器版本： 10.4.25-MariaDB
-- PHP 版本： 8.1.10

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
  `subject_id` int(10) UNSIGNED NOT NULL,
  `ip` varchar(16) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `option_id` varchar(128) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- 傾印資料表的資料 `projectvote_log`
--

INSERT INTO `projectvote_log` (`id`, `user_id`, `subject_id`, `ip`, `option_id`, `created_at`) VALUES
(10, 1, 61, '::1', '122,123,124', '2022-12-19 07:28:44'),
(16, 11, 61, '::1', '122', '2022-12-20 12:50:44'),
(17, 11, 61, '::1', '122', '2022-12-20 12:51:06'),
(18, 1, 66, '::1', '138', '2022-12-20 15:16:03'),
(19, 12, 64, '::1', '133', '2022-12-20 15:35:10'),
(20, 12, 68, '::1', '145', '2022-12-20 15:39:52'),
(21, 12, 67, '::1', '142', '2022-12-20 15:40:02'),
(22, 12, 70, '::1', '148', '2022-12-21 05:35:02'),
(23, 12, 71, '::1', '150', '2022-12-21 05:36:09'),
(24, 1, 71, '::1', '150', '2022-12-21 05:39:37');

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
(61, '測試投票更新', '測~~~試', 1, 5, 1, 1, '2022-12-28 16:00:00', '2023-01-19 15:59:59', '2022-12-19 06:00:24', '2022-12-20 15:34:10', 1849956),
(64, '自數滿自數滿自數滿自數滿自數滿', '自數滿自數滿自數滿自數滿自數滿自數滿自數滿自數滿自數滿自數滿自數滿自數滿自數滿自數滿自數滿自數滿自數', 0, 1, 0, 1, '2022-12-19 16:00:00', '2023-01-20 15:59:59', '2022-12-20 14:25:31', '2022-12-21 06:50:31', 92936727),
(66, '選聖誕節吃甚麼', '聖誕節大餐', 0, 1, 0, 1, '2022-12-19 16:00:00', '2023-01-20 15:59:59', '2022-12-20 15:15:56', '2022-12-20 15:16:03', 14679104),
(67, '今年元旦會去跨年嗎?', '迎接2023大家都怎麼過?', 0, 1, 1, 1, '2022-12-22 16:00:00', '2023-01-02 15:59:59', '2022-12-20 15:36:37', '2022-12-21 03:05:31', 59086686),
(68, '哪種東西最容易導電', '猜猜看', 0, 1, 1, 4, '2022-12-13 16:00:00', '2022-12-19 15:59:59', '2022-12-20 15:39:20', '2022-12-21 03:11:53', 65682702),
(69, '測試私人投票無權限', '測試私人投票無權限', 0, 0, 2, 1, '2022-12-20 16:00:00', '2023-01-21 15:59:59', '2022-12-21 02:20:47', '2022-12-21 02:20:47', 79655455),
(70, '測試結束投票畫面', '測試結束投票畫面', 0, 1, 1, 1, '2022-12-12 16:00:00', '2022-12-22 15:59:59', '2022-12-21 03:22:58', '2022-12-21 05:35:02', 65373019),
(71, '測試看結果', '測試看結果', 0, 2, 2, 1, '2022-12-20 16:00:00', '2023-01-21 15:59:59', '2022-12-21 05:36:03', '2022-12-21 05:39:37', 98588040),
(72, '生活未開始測試', '生活未開始測試', 0, 0, 0, 1, '2022-12-22 16:00:00', '2023-01-21 15:59:59', '2022-12-21 06:55:19', '2022-12-21 06:55:19', 11650261),
(73, '生活已結束測試', '生活已結束測試', 0, 0, 1, 1, '2022-12-13 16:00:00', '2022-12-19 15:59:59', '2022-12-21 06:55:52', '2022-12-21 06:57:01', 93714548),
(74, '政治未開始測試', '政治未開始測試未開始測試', 0, 0, 0, 2, '2022-12-20 16:00:00', '2023-01-21 15:59:59', '2022-12-21 06:56:17', '2022-12-21 06:56:17', 43511399),
(75, '政治已結束測試1', '政治已結束測試1', 0, 0, 1, 2, '2022-12-13 16:00:00', '2022-12-18 15:59:59', '2022-12-21 06:56:33', '2022-12-21 06:57:16', 3138128),
(76, '星座未開始測試', '星座未開始測試', 0, 0, 0, 3, '2022-12-22 16:00:00', '2023-01-21 15:59:59', '2022-12-21 06:57:35', '2022-12-21 07:07:55', 7731487),
(77, '星座測試', '星座測試', 0, 0, 0, 3, '2022-12-20 16:00:00', '2023-01-21 15:59:59', '2022-12-21 06:57:55', '2022-12-21 07:07:50', 85517587),
(78, '趣味測試', '趣味測試', 0, 0, 0, 4, '2022-12-20 16:00:00', '2023-01-21 15:59:59', '2022-12-21 06:58:12', '2022-12-21 06:58:12', 88380252),
(79, '趣味未開始測試', '趣味未開始測試', 0, 0, 0, 4, '2022-12-22 16:00:00', '2023-01-21 15:59:59', '2022-12-21 06:58:35', '2022-12-21 06:58:35', 15898273),
(80, '趣味已結束測試', '趣味已結束測試', 0, 0, 0, 4, '2022-12-13 16:00:00', '2022-12-18 15:59:59', '2022-12-21 06:58:52', '2022-12-21 06:58:52', 92830857),
(81, '星座已結束', '星座已結束', 0, 0, 0, 3, '2022-12-13 16:00:00', '2022-12-18 15:59:59', '2022-12-21 07:00:01', '2022-12-21 07:07:44', 33617436);

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
  `start_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '開始時間',
  `end_time` timestamp NULL DEFAULT NULL COMMENT '結束時間',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `check_num` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- 傾印資料表的資料 `projectvote_subject_daily`
--

INSERT INTO `projectvote_subject_daily` (`id`, `title`, `description`, `type`, `vote`, `image`, `start_time`, `end_time`, `created_at`, `update_at`, `check_num`) VALUES
(1, '111', '11', 0, 0, 3, '2022-12-21 16:00:00', '2023-01-21 15:59:59', '2022-12-21 15:12:17', '2022-12-21 16:00:23', 72483116);

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
(1, 1, '11', 0, '2022-12-21 15:12:17', '2022-12-21 15:12:17'),
(2, 1, '1', 0, '2022-12-21 15:12:17', '2022-12-21 15:12:17');

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
(122, 61, '選項1', 5, '2022-12-19 06:00:24', '2022-12-19 06:00:24'),
(123, 61, '選項2', 2, '2022-12-19 06:00:24', '2022-12-19 06:00:24'),
(124, 61, '選項3', 2, '2022-12-19 06:00:24', '2022-12-19 06:00:24'),
(125, 61, '選項4', 1, '2022-12-19 06:00:24', '2022-12-19 06:00:24'),
(126, 61, '選項5', 1, '2022-12-19 06:00:24', '2022-12-19 06:00:24'),
(133, 64, '自數滿自數滿自數滿', 1, '2022-12-20 14:25:31', '2022-12-20 14:25:31'),
(134, 64, '自數滿自數滿自數滿自數滿自數1', 0, '2022-12-20 14:25:31', '2022-12-20 14:25:31'),
(137, 66, '火雞', 0, '2022-12-20 15:15:56', '2022-12-20 15:15:56'),
(138, 66, '披薩', 1, '2022-12-20 15:15:56', '2022-12-20 15:15:56'),
(139, 66, '義大利麵', 0, '2022-12-20 15:15:56', '2022-12-20 15:15:56'),
(140, 66, '草莓蛋糕', 0, '2022-12-20 15:15:56', '2022-12-20 15:15:56'),
(141, 67, '年~是一定要跨的', 0, '2022-12-20 15:36:37', '2022-12-20 15:36:37'),
(142, 67, '冷死了才不要人擠人', 1, '2022-12-20 15:36:37', '2022-12-20 15:36:37'),
(143, 68, '銀', 0, '2022-12-20 15:39:20', '2022-12-20 15:39:20'),
(144, 68, '銅', 0, '2022-12-20 15:39:20', '2022-12-20 15:39:20'),
(145, 68, '廖老大', 1, '2022-12-20 15:39:20', '2022-12-20 15:39:20'),
(146, 69, '測試1', 0, '2022-12-21 02:20:47', '2022-12-21 02:20:47'),
(147, 69, '測試2', 0, '2022-12-21 02:20:47', '2022-12-21 02:20:47'),
(148, 70, '111', 1, '2022-12-21 03:22:58', '2022-12-21 03:22:58'),
(149, 70, '222', 0, '2022-12-21 03:22:58', '2022-12-21 03:22:58'),
(150, 71, '測', 2, '2022-12-21 05:36:03', '2022-12-21 05:36:03'),
(151, 71, '試', 0, '2022-12-21 05:36:03', '2022-12-21 05:36:03'),
(152, 72, '生活1', 0, '2022-12-21 06:55:19', '2022-12-21 06:55:19'),
(153, 72, '生活2', 0, '2022-12-21 06:55:19', '2022-12-21 06:55:19'),
(154, 73, '結束測試', 0, '2022-12-21 06:55:52', '2022-12-21 06:55:52'),
(155, 73, '結束測試2', 0, '2022-12-21 06:55:52', '2022-12-21 06:55:52'),
(156, 74, '政治未開始測試1', 0, '2022-12-21 06:56:17', '2022-12-21 06:56:17'),
(157, 74, '政治未開始測試2', 0, '2022-12-21 06:56:17', '2022-12-21 06:56:17'),
(158, 75, '政治已結束測試1', 0, '2022-12-21 06:56:33', '2022-12-21 06:56:33'),
(159, 75, '政治已結束測試2', 0, '2022-12-21 06:56:33', '2022-12-21 06:56:33'),
(160, 76, '星座未開始測試', 0, '2022-12-21 06:57:35', '2022-12-21 06:57:35'),
(161, 76, '星座未開始測試2', 0, '2022-12-21 06:57:35', '2022-12-21 06:57:35'),
(162, 77, '星座測試', 0, '2022-12-21 06:57:55', '2022-12-21 06:57:55'),
(163, 77, '星座測試2', 0, '2022-12-21 06:57:55', '2022-12-21 06:57:55'),
(164, 78, '趣味測試', 0, '2022-12-21 06:58:12', '2022-12-21 06:58:12'),
(165, 78, '趣味測試2', 0, '2022-12-21 06:58:12', '2022-12-21 06:58:12'),
(166, 79, '趣味未開始測試', 0, '2022-12-21 06:58:35', '2022-12-21 06:58:35'),
(167, 79, '趣味未開始測試2', 0, '2022-12-21 06:58:35', '2022-12-21 06:58:35'),
(168, 80, '趣味已結束測試', 0, '2022-12-21 06:58:52', '2022-12-21 06:58:52'),
(169, 80, '趣味已結束測試2', 0, '2022-12-21 06:58:52', '2022-12-21 06:58:52'),
(170, 81, '星座已結束', 0, '2022-12-21 07:00:01', '2022-12-21 07:00:01'),
(171, 81, '星座已結束1', 0, '2022-12-21 07:00:01', '2022-12-21 07:00:01');

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
(36, 61, 'amy1111@gmail.com', 0),
(40, 64, 'amy1111@gmail.com', 0),
(42, 66, 'amy1111@gmail.com', 0),
(44, 67, 'EEE@gmail.com', 0),
(45, 68, 'EEE@gmail.com', 0),
(48, 70, 'EEE@gmail.com', 0),
(49, 71, 'EEE@gmail.com', 0),
(50, 71, 'amy1111@gmail.com', 1),
(51, 69, 'EEE@gmail.com', 1),
(52, 72, 'amy1111@gmail.com', 0),
(53, 73, 'amy1111@gmail.com', 0),
(54, 74, 'amy1111@gmail.com', 0),
(55, 75, 'amy1111@gmail.com', 0),
(56, 76, 'amy1111@gmail.com', 0),
(57, 77, 'amy1111@gmail.com', 0),
(58, 78, 'amy1111@gmail.com', 0),
(59, 79, 'amy1111@gmail.com', 0),
(60, 80, 'amy1111@gmail.com', 0),
(61, 81, 'amy1111@gmail.com', 0);

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
(1, '20221221230729.jpg', 457720, 'jpg', NULL, '2022-12-21 15:07:29'),
(2, '20221221230941.jpg', 4154326, 'jpg', NULL, '2022-12-21 15:09:41'),
(3, '20221221231217.jpg', 2553930, 'jpg', NULL, '2022-12-21 15:12:17');

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
(1, 'amy1111@gmail.com', 'A22222222', 'azami', 'doggy0704@gmail.com', '0931394552', 0, '2022-12-22 06:00:06', '2022-12-14 00:36:16', '2022-12-22 06:00:06'),
(2, '1111@gmail.com', '2222', '測試2', '1111@gmail.com', '0', 1, NULL, '2022-12-14 05:08:48', '2022-12-14 05:08:48'),
(3, 'test2@gmail.com', '1122', '測試3', 'test2@gmail.com', '0', 1, NULL, '2022-12-14 05:33:37', '2022-12-14 05:33:37'),
(4, 'test123@gmail.com', '0000', 'aaaa', 'test123@gmail.com', '912345678', 1, NULL, '2022-12-14 06:34:48', '2022-12-14 06:34:48'),
(5, 'ssss@gmail.com', 'AADD1234', '測試帳號', 'ssss@gmail.com', '0', 1, NULL, '2022-12-14 06:36:19', '2022-12-14 06:36:19'),
(6, 'FFFF@gmail.com', '1111', 'CCC', 'FFFF@gmail.com', '0', 1, '2022-12-15 05:39:15', '2022-12-14 07:02:49', '2022-12-22 05:39:21'),
(7, 'HHH@gmail.com', 'AAAAAA', 'test123', 'HHH@gmail.com', '0', 1, '2022-12-22 03:22:01', '2022-12-14 07:11:44', '2022-12-22 03:22:01'),
(8, 'KKKK@gmail.com', '3DDD1234', '1111', 'KKKK@gmail.com', '0', 1, NULL, '2022-12-14 07:49:03', '2022-12-14 07:49:03'),
(9, 'NB@gmail.com', 'AAAAAAAAA', 'AA', 'NB@gmail.com', '0', 1, NULL, '2022-12-14 07:51:52', '2022-12-14 07:51:52'),
(10, 'KKJJ@gmail.com', 'gOOgle123', '11', 'KKJJ@gmail.com', '0', 1, NULL, '2022-12-14 07:52:52', '2022-12-14 07:52:52'),
(11, 'AAAA@gmail.com', 'Q11111111', '1234', 'AAAA@gmail.com', '', 1, '2022-12-20 12:56:13', '2022-12-20 11:51:14', '2022-12-20 12:56:13'),
(12, 'EEE@gmail.com', 'A11111111', 'test124', 'EEE@gmail.com', '', 1, '2022-12-21 07:58:51', '2022-12-20 13:32:51', '2022-12-21 07:58:51');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `projectvote_log`
--
ALTER TABLE `projectvote_log`
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `projectvote_subject`
--
ALTER TABLE `projectvote_subject`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `projectvote_subject_category`
--
ALTER TABLE `projectvote_subject_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `projectvote_subject_daily`
--
ALTER TABLE `projectvote_subject_daily`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `projectvote_subject_daily_options`
--
ALTER TABLE `projectvote_subject_daily_options`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `projectvote_subject_options`
--
ALTER TABLE `projectvote_subject_options`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `projectvote_subject_users`
--
ALTER TABLE `projectvote_subject_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `projectvote_upload`
--
ALTER TABLE `projectvote_upload`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `projectvote_users`
--
ALTER TABLE `projectvote_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
