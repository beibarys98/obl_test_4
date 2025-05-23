-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: May 23, 2025 at 12:46 PM
-- Server version: 5.7.44
-- PHP Version: 8.2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yii2advanced`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `user_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci,
  `img_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`id`, `question_id`, `answer`, `img_path`) VALUES
(1, 1, 'Фвцвцд вбвцв', NULL),
(2, 1, 'Лаьуцда', NULL),
(3, 1, 'Купкуплкп qwdqwd', ''),
(5, 2, 'Фвцвцд вбвцв', 'uploads/_wi0N3oe.png'),
(6, 2, 'Лаьуцда', NULL),
(7, 2, 'Купкуплкп', ''),
(8, 2, 'квпкулпкудп', NULL),
(9, 3, 'Фвцвцд вбвцв', NULL),
(10, 3, 'Лаьуцда', NULL),
(11, 3, 'Купкуплкп', NULL),
(12, 3, 'Квпкулпкудп', NULL),
(13, 4, 'Фвцвцд вбвцв', NULL),
(14, 4, 'Лаьуцда', NULL),
(15, 4, 'Купкуплкп', NULL),
(16, 4, 'квпкулпкудп', NULL),
(17, 5, 'Фвцвцд вбвцв', NULL),
(18, 5, 'Лаьуцда', NULL),
(19, 5, 'Купкуплкп', NULL),
(20, 5, 'Квпкулпкудп', NULL),
(21, 6, 'Фвцвцд вбвцв', NULL),
(22, 6, 'Лаьуцда', NULL),
(23, 6, 'Купкуплкп', NULL),
(24, 6, 'квпкулпкудп', NULL),
(25, 7, 'Фвцвцд вбвцв', NULL),
(26, 7, 'Лаьуцда', NULL),
(27, 7, 'Купкуплкп', NULL),
(28, 7, 'квпкулпкудп', NULL),
(29, 8, 'Фвцвцд вбвцв', NULL),
(30, 8, 'Лаьуцда', NULL),
(31, 8, 'Купкуплкп', NULL),
(32, 8, 'Квпкулпкудп', NULL),
(33, 9, 'Фвцвцд вбвцв', NULL),
(34, 9, 'Лаьуцда', NULL),
(35, 9, 'Купкуплкп', NULL),
(36, 9, 'квпкулпкудп', NULL),
(37, 10, 'Фвцвцд вбвцв', NULL),
(38, 10, 'Лаьуцда', NULL),
(39, 10, 'Купкуплкп', NULL),
(40, 10, 'Квпкулпкудп', NULL),
(41, 11, 'Фвцвцд вбвцв', NULL),
(42, 11, 'Лаьуцда', NULL),
(43, 11, 'Купкуплкп', NULL),
(44, 11, 'квпкулпкудп', NULL),
(45, 12, 'Фвцвцд вбвцв', NULL),
(46, 12, 'Лаьуцда', NULL),
(47, 12, 'Купкуплкп', NULL),
(48, 12, 'квпкулпкудп', NULL),
(49, 13, 'Фвцвцд вбвцв', NULL),
(50, 13, 'Лаьуцда', NULL),
(51, 13, 'Купкуплкп', NULL),
(52, 13, 'Квпкулпкудп', NULL),
(53, 14, 'Фвцвцд вбвцв', NULL),
(54, 14, 'Лаьуцда', NULL),
(55, 14, 'Купкуплкп', NULL),
(56, 14, 'квпкулпкудп', NULL),
(57, 15, 'Фвцвцд вбвцв', NULL),
(58, 15, 'Лаьуцда', NULL),
(59, 15, 'Купкуплкп', NULL),
(60, 15, 'Квпкулпкудп', NULL),
(61, 16, 'Фвцвцд вбвцв', NULL),
(62, 16, 'Лаьуцда', NULL),
(63, 16, 'Купкуплкп', NULL),
(64, 16, 'квпкулпкудп', NULL),
(65, 17, 'Фвцвцд вбвцв', NULL),
(66, 17, 'Лаьуцда', NULL),
(67, 17, 'Купкуплкп', NULL),
(68, 17, 'квпкулпкудп', NULL),
(69, 18, 'Фвцвцд вбвцв', NULL),
(70, 18, 'Лаьуцда', NULL),
(71, 18, 'Купкуплкп', NULL),
(72, 18, 'Квпкулпкудп', NULL),
(73, 19, 'Фвцвцд вбвцв', NULL),
(74, 19, 'Лаьуцда', NULL),
(75, 19, 'Купкуплкп', NULL),
(76, 19, 'квпкулпкудп', NULL),
(77, 20, 'Фвцвцд вбвцв', NULL),
(78, 20, 'Лаьуцда', NULL),
(79, 20, 'Купкуплкп', NULL),
(80, 20, 'Квпкулпкудп', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `id` int(11) NOT NULL,
  `participant_id` int(11) DEFAULT NULL,
  `test_id` int(11) DEFAULT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `file`
--

INSERT INTO `file` (`id`, `participant_id`, `test_id`, `type`, `file_path`) VALUES
(33, 3, 1, 'receipt', 'receipts/DvsQ6azd.pdf'),
(34, 3, 1, 'report', 'reports/EmgoPMrz.xlsx');

-- --------------------------------------------------------

--
-- Table structure for table `participant`
--

CREATE TABLE `participant` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `test_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_time` datetime DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `result` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `participant`
--

INSERT INTO `participant` (`id`, `user_id`, `subject_id`, `test_id`, `name`, `school`, `language`, `payment_time`, `start_time`, `end_time`, `result`) VALUES
(3, 5, 1, 1, 'лол лол', 'лол', 'kz', '2025-05-23 17:44:51', '2025-05-23 17:45:06', '2025-05-23 17:45:17', 2);

-- --------------------------------------------------------

--
-- Table structure for table `participant_answer`
--

CREATE TABLE `participant_answer` (
  `id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `participant_answer`
--

INSERT INTO `participant_answer` (`id`, `participant_id`, `question_id`, `answer_id`) VALUES
(1, 3, 1, 1),
(2, 3, 2, 8),
(3, 3, 3, 9);

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci,
  `answer` int(11) DEFAULT NULL,
  `img_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `test_id`, `question`, `answer`, `img_path`) VALUES
(1, 1, 'Уцлдьа дцудль адцлуьа дцлуьа длуцьа.\r\nУцлдьа дцудль адцлуьа дцлуьа длуцьа.\r\nУцлдьа дцудль адцлуьа дцлуьа длуцьа. 2', 1, 'uploads/F0HMIBb-.png'),
(2, 1, 'Уцлдьа дцудль адцлуьа дцлуьа длуцьа.', 5, NULL),
(3, 1, 'Уцлдьа дцудль  адцлуьа дцлуьа длуцьа.', 9, NULL),
(4, 1, 'Уцлдьа дцудль адцлуьа дцлуьа длуцьа.', 13, NULL),
(5, 1, 'Уцлдьа дцудль адцлуьа дцлуьа длуцьа.', 17, NULL),
(6, 1, 'Уцлдьа дцудль адцлуьа дцлуьа длуцьа.\nУцлдьа дцудль адцлуьа дцлуьа длуцьа.\nУцлдьа дцудль адцлуьа дцлуьа длуцьа.', 21, NULL),
(7, 1, 'Уцлдьа дцудль адцлуьа дцлуьа длуцьа.', 25, NULL),
(8, 1, 'Уцлдьа дцудль  адцлуьа дцлуьа длуцьа.', 29, NULL),
(9, 1, 'Уцлдьа дцудль адцлуьа дцлуьа длуцьа.', 33, NULL),
(10, 1, 'Уцлдьа дцудль адцлуьа дцлуьа длуцьа.', 37, NULL),
(11, 1, 'Уцлдьа дцудль адцлуьа дцлуьа длуцьа.\nУцлдьа дцудль адцлуьа дцлуьа длуцьа.\nУцлдьа дцудль адцлуьа дцлуьа длуцьа.', 41, NULL),
(12, 1, 'Уцлдьа дцудль адцлуьа дцлуьа длуцьа.', 45, NULL),
(13, 1, 'Уцлдьа дцудль  адцлуьа дцлуьа длуцьа.', 49, NULL),
(14, 1, 'Уцлдьа дцудль адцлуьа дцлуьа длуцьа.', 53, NULL),
(15, 1, 'Уцлдьа дцудль адцлуьа дцлуьа длуцьа.', 57, NULL),
(16, 1, 'Уцлдьа дцудль адцлуьа дцлуьа длуцьа.\nУцлдьа дцудль адцлуьа дцлуьа длуцьа.\nУцлдьа дцудль адцлуьа дцлуьа длуцьа.', 61, NULL),
(17, 1, 'Уцлдьа дцудль адцлуьа дцлуьа длуцьа.', 65, NULL),
(18, 1, 'Уцлдьа дцудль  адцлуьа дцлуьа длуцьа.', 69, NULL),
(19, 1, 'Уцлдьа дцудль адцлуьа дцлуьа длуцьа.', 73, NULL),
(20, 1, 'Уцлдьа дцудль адцлуьа дцлуьа длуцьа.', 77, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `purpose` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost` int(11) DEFAULT NULL,
  `first` int(11) DEFAULT NULL,
  `second` int(11) DEFAULT NULL,
  `third` int(11) DEFAULT NULL,
  `fourth` int(11) DEFAULT NULL,
  `fifth` int(11) DEFAULT NULL,
  `acw` float DEFAULT NULL,
  `cx` int(11) DEFAULT NULL,
  `name_y` int(11) DEFAULT NULL,
  `number_x` int(11) DEFAULT NULL,
  `number_y` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `purpose`, `cost`, `first`, `second`, `third`, `fourth`, `fifth`, `acw`, `cx`, `name_y`, `number_x`, `number_y`) VALUES
(1, 'Олимпиада', 5000, 40, 35, 30, 25, 0, 9.5, 900, 760, 1490, 1120);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `title_kz` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ru` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `second` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `third` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fourth` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fifth` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `title_kz`, `title_ru`, `first`, `second`, `third`, `fourth`, `fifth`) VALUES
(1, 'қазақ тілі', 'казахский язык', 'templates/1/first.jpg', 'templates/1/second.jpg', 'templates/1/third.jpg', 'templates/1/fourth.jpg', 'templates/1/fifth.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `language` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `version` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`id`, `subject_id`, `language`, `version`, `status`, `duration`) VALUES
(1, 1, 'kz', '1', 'certificated', '00:00:10');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'admin', '0RPruuhL7dXXsbqUBLJsyJcT0mpz4WS2', '$2y$13$dA4UUk5mxPtMqTIlCTCiMOb55OPdSe4OowHyyGZNt26jK5FE24fPq', NULL, 'aaa@gmail.com', 10, 1746258543, 1746258580, 'V7rMKuf0Vq0bZNpffvP-y9iA1eLV7Kwy_1746258543'),
(5, '123456789123', 'QMFv-ZWj3Dpyvt37JkOMSP-3HnTIl7BZ', '$2y$13$9pooN8xYSOKUntZ3yfVz7u.hvRQ0g/D1QbOIrt1cJlM9yISE4qDdm', NULL, '', 10, 1748004230, 1748004230, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `participant_id` (`participant_id`),
  ADD KEY `test_id` (`test_id`);

--
-- Indexes for table `participant`
--
ALTER TABLE `participant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `participant_ibfk_3` (`test_id`);

--
-- Indexes for table `participant_answer`
--
ALTER TABLE `participant_answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `participant_id` (`participant_id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `answer_id` (`answer_id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_id` (`test_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `participant`
--
ALTER TABLE `participant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `participant_answer`
--
ALTER TABLE `participant_answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `file`
--
ALTER TABLE `file`
  ADD CONSTRAINT `file_ibfk_1` FOREIGN KEY (`participant_id`) REFERENCES `participant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `file_ibfk_2` FOREIGN KEY (`test_id`) REFERENCES `test` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `participant`
--
ALTER TABLE `participant`
  ADD CONSTRAINT `participant_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participant_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participant_ibfk_3` FOREIGN KEY (`test_id`) REFERENCES `test` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `participant_answer`
--
ALTER TABLE `participant_answer`
  ADD CONSTRAINT `participant_answer_ibfk_1` FOREIGN KEY (`participant_id`) REFERENCES `participant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participant_answer_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participant_answer_ibfk_3` FOREIGN KEY (`answer_id`) REFERENCES `answer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `test` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `test_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
