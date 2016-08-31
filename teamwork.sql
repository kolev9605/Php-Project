-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 31 авг 2016 в 15:39
-- Версия на сървъра: 10.1.13-MariaDB
-- PHP Version: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `teamwork`
--

-- --------------------------------------------------------

--
-- Структура на таблица `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `content` varchar(200) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `votes` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `comments`
--

INSERT INTO `comments` (`id`, `content`, `post_id`, `user_id`, `votes`, `date`) VALUES
(6, 'TEST', 15, 9, 1, '2016-08-24 19:47:59'),
(7, 'Test', 15, 9, 1, '2016-08-24 19:49:06'),
(8, 'Test 2', 15, 11, -1, '2016-08-27 17:35:07'),
(9, 'Test delete', 27, 9, 1, '2016-08-31 08:26:11');

-- --------------------------------------------------------

--
-- Структура на таблица `commentvotes`
--

CREATE TABLE `commentvotes` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_positive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `commentvotes`
--

INSERT INTO `commentvotes` (`id`, `comment_id`, `user_id`, `is_positive`) VALUES
(2, 7, 9, 1),
(3, 6, 9, 1),
(4, 8, 11, 0),
(5, 9, 9, 1);

-- --------------------------------------------------------

--
-- Структура на таблица `conversationcomments`
--

CREATE TABLE `conversationcomments` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `conversationcomments`
--

INSERT INTO `conversationcomments` (`id`, `conversation_id`, `user_id`, `content`, `date`) VALUES
(2, 1, 9, 'Test text', '2016-08-29 16:30:39'),
(3, 2, 9, 'Test text', '2016-08-29 16:33:28'),
(4, 3, 9, 'TEEEEEEEEST', '2016-08-29 17:11:32'),
(5, 4, 9, 'TESTSTSTETEST', '2016-08-29 17:13:03'),
(6, 4, 9, 'Test', '2016-08-29 18:30:05'),
(7, 5, 9, 'TEST TEST TEST', '2016-08-29 18:31:30'),
(8, 4, 13, 'test', '2016-08-29 18:48:31'),
(9, 6, 9, 'TEST', '2016-08-29 23:03:05'),
(10, 7, 9, 'TEST', '2016-08-30 08:11:14');

-- --------------------------------------------------------

--
-- Структура на таблица `conversationparticipants`
--

CREATE TABLE `conversationparticipants` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `conversationparticipants`
--

INSERT INTO `conversationparticipants` (`id`, `conversation_id`, `user_id`) VALUES
(4, 1, 9),
(5, 1, 11),
(6, 1, 13),
(7, 2, 9),
(8, 2, 11),
(9, 2, 13),
(10, 3, 9),
(11, 3, 11),
(12, 3, 13),
(14, 4, 9),
(15, 4, 11),
(16, 4, 13),
(17, 5, 9),
(18, 5, 11),
(19, 6, 9),
(20, 6, 11),
(21, 7, 9),
(22, 7, 11),
(23, 7, 14);

-- --------------------------------------------------------

--
-- Структура на таблица `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `conversations`
--

INSERT INTO `conversations` (`id`, `title`, `date`) VALUES
(1, 'Test conversation', '2016-08-29 16:42:10'),
(2, 'Test conversation', '2016-08-29 16:43:20'),
(3, 'Test conversation 2', '2016-08-29 17:11:32'),
(4, 'Test conversation 3', '2016-08-29 17:13:03'),
(5, 'Test conversation 4', '2016-08-29 18:31:30'),
(6, 'Test conversation 5', '2016-08-29 23:03:05'),
(7, 'Test conversation 56', '2016-08-30 08:11:14');

-- --------------------------------------------------------

--
-- Структура на таблица `followers`
--

CREATE TABLE `followers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `followed_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `followers`
--

INSERT INTO `followers` (`id`, `user_id`, `followed_user_id`) VALUES
(4, 9, 13);

-- --------------------------------------------------------

--
-- Структура на таблица `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `imageLocation` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `votes` int(11) NOT NULL DEFAULT '0',
  `is_hot` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `posts`
--

INSERT INTO `posts` (`id`, `title`, `imageLocation`, `date`, `user_id`, `votes`, `is_hot`) VALUES
(11, 'Test', '0aOv20LD_460s.jpg', '2016-08-18 20:29:39', 9, -1, 0),
(12, 'NO', '0NO.jpg', '2016-08-18 20:30:15', 9, -1, 0),
(13, 'Test', '1NO.jpg', '2016-08-20 11:36:24', 9, -1, 0),
(14, 'Test2', '0Game ideas.jpg', '2016-08-20 11:52:45', 9, 1, 1),
(15, 'Test1', '13NO.jpg', '2016-08-20 12:35:25', 9, 2, 1),
(16, 'Test3', '3Game ideas.jpg', '2016-08-26 07:58:08', 11, 1, 1),
(17, 'Test Test Test', '14NO.jpg', '2016-08-28 16:05:01', 11, 1, 0),
(18, 'Test 4', '15NO.jpg', '2016-08-30 14:36:40', 11, 0, 0),
(19, 'Test 5', '4Game ideas.jpg', '2016-08-30 14:36:56', 11, 0, 0),
(20, 'Test 6', '16NO.jpg', '2016-08-30 14:37:34', 16, 0, 0),
(21, 'Test 7', '5Game ideas.jpg', '2016-08-30 14:37:48', 16, 1, 1),
(22, 'Test 8', '17NO.jpg', '2016-08-30 14:38:10', 16, 1, 1),
(23, 'Test 9', '6Game ideas.jpg', '2016-08-30 14:38:22', 16, 2, 1),
(24, 'Test 10', '18NO.jpg', '2016-08-30 14:38:36', 16, 2, 1);

-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(100) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `is_admin`) VALUES
(9, 'evgeni', '$2y$10$5OiHJNqEkoaSdADn6rAGU.D9mGNG.SNzTDEYL8P2rBjHIyWjn/ks6', 1),
(11, 'evgeni1', '$2y$10$G/139c7AxSJjTMT1oMMcy.H4Y0X2GplOd573ven.Y.jNQ.gpFr8Jm', 0),
(13, 'evgeni2', '$2y$10$5xM9Ims0iZUAfP/GF2ob6ewG61gXp5bS.k/XTPD6TnC.Uf3kvwCzy', 0),
(14, 'evgeni3', '$2y$10$2s9JqvHSEcLgUg5znT1dFuaj/3topVDxLx/pJUJeBYnd.96CG6YcO', 0),
(16, 'gosho', '$2y$10$yzcKOPmqRr8uq.Qtx3fROumMKSIkNzUhlizBcrttWrSPXnBKzIlo2', 0);

-- --------------------------------------------------------

--
-- Структура на таблица `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_positive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `votes`
--

INSERT INTO `votes` (`id`, `post_id`, `user_id`, `is_positive`) VALUES
(19, 15, 11, 1),
(21, 13, 9, 0),
(22, 12, 9, 0),
(23, 11, 9, 0),
(24, 17, 11, 1),
(35, 15, 9, 1),
(36, 14, 9, 1),
(37, 16, 9, 1),
(39, 23, 9, 1),
(40, 22, 9, 1),
(41, 21, 9, 1),
(42, 24, 11, 1),
(43, 23, 11, 1),
(46, 24, 9, 1),
(48, 27, 9, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commentvotes`
--
ALTER TABLE `commentvotes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversationcomments`
--
ALTER TABLE `conversationcomments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversationparticipants`
--
ALTER TABLE `conversationparticipants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_posts_idx` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `commentvotes`
--
ALTER TABLE `commentvotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `conversationcomments`
--
ALTER TABLE `conversationcomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `conversationparticipants`
--
ALTER TABLE `conversationparticipants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- Ограничения за дъмпнати таблици
--

--
-- Ограничения за таблица `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_users_posts` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
