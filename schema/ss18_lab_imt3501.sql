-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 03. Okt, 2018 14:53 PM
-- Server-versjon: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ss18_lab_imt3501`
--

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `category`
--

CREATE TABLE `category` (
  `categoryId` int(11) NOT NULL,
  `categoryName` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dataark for tabell `category`
--

INSERT INTO `category` (`categoryId`, `categoryName`) VALUES
(1, 'Category 1'),
(2, 'Category 2'),
(3, 'Category 3');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `failedlogins`
--

CREATE TABLE `failedlogins` (
  `userId` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `oldpwhash`
--

CREATE TABLE `oldpwhash` (
  `userId` int(11) NOT NULL,
  `salt` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `pWHash` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `replies`
--

CREATE TABLE `replies` (
  `replyId` int(11) NOT NULL,
  `content` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `userId` int(11) NOT NULL,
  `topicId` int(11) NOT NULL,
  `subReplyOf` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dataark for tabell `replies`
--

INSERT INTO `replies` (`replyId`, `content`, `timestamp`, `userId`, `topicId`, `subReplyOf`) VALUES
(1, 'Content of reply 1', '2018-10-03 12:49:00', 1, 1, NULL),
(2, 'Content of reply 2', '2018-10-03 12:50:00', 2, 2, NULL),
(3, 'Content of reply 3', '2018-10-03 12:51:00', 3, 3, NULL);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `topics`
--

CREATE TABLE `topics` (
  `topicId` int(11) NOT NULL,
  `topicName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `categoryId` int(11) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dataark for tabell `topics`
--

INSERT INTO `topics` (`topicId`, `topicName`, `description`, `timestamp`, `categoryId`, `userId`) VALUES
(1, 'Topic 1', 'Description for topic 1', '2018-10-03 12:44:00', 1, 1),
(2, 'Topic 2', 'Description for topic 2', '2018-10-03 12:45:00', 2, 2),
(3, 'Topic 3', 'Description for topic 3', '2018-10-03 12:46:00', 3, 3);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `user`
--

CREATE TABLE `user` (
  `userId` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `usertype` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dataark for tabell `user`
--

INSERT INTO `user` (`userId`, `username`, `password`, `email`, `usertype`) VALUES
(1, 'user1', '$2y$10$kuR9OIhby1br/D18DGQZne7IE6hV/ajNTZ4Lxp7QeICbW1Ny4gS22', 'user1@mail.com', 'normal'),
(2, 'user2', '$2y$10$4ub5mFib/sY85MICjxMgv.GXITpVsAapntD2I.9ybKDvO8C.UbQaa', 'user2@mail.com', 'normal'),
(3, 'user3', '$2y$10$6rktN596UvPhVXDF3ICnPOTQ9/I/ctC1b6vB8kt2GWyggi43n7jG6', 'user3@mail.com', 'normal');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryId`);

--
-- Indexes for table `failedlogins`
--
ALTER TABLE `failedlogins`
  ADD PRIMARY KEY (`userId`,`timestamp`);

--
-- Indexes for table `oldpwhash`
--
ALTER TABLE `oldpwhash`
  ADD PRIMARY KEY (`userId`,`salt`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`replyId`),
  ADD KEY `threadId` (`topicId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topicId`),
  ADD KEY `categoryId` (`categoryId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `replyId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topicId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Begrensninger for dumpede tabeller
--

--
-- Begrensninger for tabell `failedlogins`
--
ALTER TABLE `failedlogins`
  ADD CONSTRAINT `failedlogins_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`);

--
-- Begrensninger for tabell `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`topicId`) REFERENCES `topics` (`topicId`),
  ADD CONSTRAINT `replies_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`);

--
-- Begrensninger for tabell `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `category` (`categoryId`),
  ADD CONSTRAINT `topics_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
