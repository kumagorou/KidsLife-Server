-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015 年 11 月 29 日 07:13
-- サーバのバージョン： 5.6.20
-- PHP Version: 5.6.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kidslife_db`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `accounts`
--

CREATE TABLE `accounts` (
  `id` int(10) NOT NULL,
  `name` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `accounts`
--

INSERT INTO `accounts` (`id`, `name`) VALUES
(1, '子供'),
(2, '親'),
(3, '作成者');

-- --------------------------------------------------------

--
-- テーブルの構造 `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'アウトドア'),
(2, 'インドア'),
(3, '工作教室'),
(4, '遠足');

-- --------------------------------------------------------

--
-- テーブルの構造 `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `event_name` text,
  `category_id` int(11) DEFAULT NULL,
  `body` text,
  `capacity` int(11) DEFAULT NULL,
  `address` text,
  `schedule` text,
  `regulation` text,
  `pay` varchar(255) DEFAULT NULL,
  `image` text,
  `thumbnail` text,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `dead_line` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `events`
--

INSERT INTO `events` (`id`, `event_name`, `category_id`, `body`, `capacity`, `address`, `schedule`, `regulation`, `pay`, `image`, `thumbnail`, `start_date`, `end_date`, `dead_line`, `created`, `modified`, `status`) VALUES
(1, '作ろう！僕らの秘密基地', 1, '秘密基地（ひみつきち）とは、周囲に知られないように建設または設置された拠点のことを指す。', 50, '恵比寿ガーデンプレイス', '9時開始\r\n↓\r\n21時終了', '小学4年生から小学6年生まで', '1000', NULL, NULL, '2015-12-24 00:00:00', '2015-11-25 00:00:00', '2015-11-30 00:00:00', '2015-11-28 09:54:42', '2015-11-28 09:54:42', 1),
(2, 'Unityブートキャンプ', 2, 'Unityマスターになろう', 50, '恵比寿ガーデンプレイス', '9時開始\r\n↓\r\n21時終了', '小学4年生から小学6年生まで', '1000', NULL, NULL, '2015-12-24 00:00:00', '2015-11-25 00:00:00', '2015-11-30 00:00:00', '2015-11-28 09:54:42', '2015-11-28 09:54:42', 1),
(3, '書道教室無料体験', 2, '書道極めよう', 50, '恵比寿ガーデンプレイス', '9時開始\r\n↓\r\n21時終了', '小学4年生から小学6年生まで', '0', NULL, NULL, '2015-12-24 00:00:00', '2015-11-25 00:00:00', '2015-11-30 00:00:00', '2015-11-28 09:54:42', '2015-11-28 09:54:42', 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `events-users`
--

CREATE TABLE `events-users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `events_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `gender`
--

CREATE TABLE `gender` (
  `id` int(11) NOT NULL,
  `name` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `gender`
--

INSERT INTO `gender` (`id`, `name`) VALUES
(1, 'male'),
(2, 'female');

-- --------------------------------------------------------

--
-- テーブルの構造 `medals`
--

CREATE TABLE `medals` (
  `id` int(11) NOT NULL,
  `name` varchar(11) NOT NULL,
  `image` text NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `state`
--

CREATE TABLE `state` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `state`
--

INSERT INTO `state` (`id`, `name`) VALUES
(1, '参加予約'),
(2, '参加済み'),
(3, 'キャンセル');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `account_type_id` int(10) NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `gender_id` int(10) DEFAULT NULL,
  `age` int(10) DEFAULT NULL,
  `uuid` varchar(30) NOT NULL,
  `image` text,
  `favorite_id` int(11) DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`user_id`, `account_type_id`, `user_name`, `gender_id`, `age`, `uuid`, `image`, `favorite_id`, `isActive`, `created`, `modified`) VALUES
(1, 1, 'よつやなぎ たかみつ', 1, 12, '5659db2c7c07bf3d92f57f92', 'id_1.png', 1, 1, '2015-11-28 17:00:29', '2015-11-28 17:00:29');

-- --------------------------------------------------------

--
-- テーブルの構造 `users-manage_events`
--

CREATE TABLE `users-manage_events` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `users-medals`
--

CREATE TABLE `users-medals` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `medal_id` int(11) NOT NULL,
  `created` date DEFAULT NULL,
  `modified` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `events-users`
--
ALTER TABLE `events-users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id_2` (`user_id`),
  ADD UNIQUE KEY `events_id_2` (`events_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `events_id` (`events_id`),
  ADD KEY `state_id` (`state_id`);

--
-- Indexes for table `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medals`
--
ALTER TABLE `medals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `account_type_id` (`account_type_id`),
  ADD KEY `gender` (`gender_id`),
  ADD KEY `favorite_id` (`favorite_id`);

--
-- Indexes for table `users-manage_events`
--
ALTER TABLE `users-manage_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `users-medals`
--
ALTER TABLE `users-medals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `medal_id` (`medal_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `events-users`
--
ALTER TABLE `events-users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gender`
--
ALTER TABLE `gender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `medals`
--
ALTER TABLE `medals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users-manage_events`
--
ALTER TABLE `users-manage_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users-medals`
--
ALTER TABLE `users-medals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- テーブルの制約 `events-users`
--
ALTER TABLE `events-users`
  ADD CONSTRAINT `events-users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `events-users_ibfk_2` FOREIGN KEY (`events_id`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `events-users_ibfk_3` FOREIGN KEY (`state_id`) REFERENCES `state` (`id`);

--
-- テーブルの制約 `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`account_type_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`gender_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`favorite_id`) REFERENCES `medals` (`id`);

--
-- テーブルの制約 `users-manage_events`
--
ALTER TABLE `users-manage_events`
  ADD CONSTRAINT `users-manage_events_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `users-manage_events_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`);

--
-- テーブルの制約 `users-medals`
--
ALTER TABLE `users-medals`
  ADD CONSTRAINT `users-medals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `users-medals_ibfk_2` FOREIGN KEY (`medal_id`) REFERENCES `medals` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
