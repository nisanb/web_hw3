-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 03, 2018 at 03:18 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ISNetworkDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `Followers`
--

CREATE TABLE `Followers` (
  `FollowerID` varchar(100) NOT NULL,
  `FollowingID` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Followers`
--

INSERT INTO `Followers` (`FollowerID`, `FollowingID`) VALUES
('aa', 'asd'),
('asd', 'aa'),
('nisanb2', 'aa');

-- --------------------------------------------------------

--
-- Table structure for table `JobOffers`
--

CREATE TABLE `JobOffers` (
  `id` int(5) NOT NULL,
  `Role` varchar(100) NOT NULL,
  `Description` varchar(400) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Company` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Messages`
--

CREATE TABLE `Messages` (
  `id` int(5) NOT NULL,
  `FromID` varchar(100) NOT NULL,
  `ToID` varchar(100) NOT NULL,
  `strMessage` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Notifications`
--

CREATE TABLE `Notifications` (
  `id` int(5) NOT NULL,
  `iType` int(5) NOT NULL,
  `iStatus` int(5) NOT NULL DEFAULT '0',
  `time` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `UserID` varchar(100) NOT NULL,
  `Message` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `projectFiles`
--

CREATE TABLE `projectFiles` (
  `id` int(5) NOT NULL,
  `ProjectID` int(5) NOT NULL,
  `fileName` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Projects`
--

CREATE TABLE `Projects` (
  `id` int(5) NOT NULL,
  `UserID` varchar(100) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Date` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `Description` varchar(800) NOT NULL,
  `Views` int(5) NOT NULL DEFAULT '0',
  `ResearchStartDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ResearchEndDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `likes` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Research`
--

CREATE TABLE `Research` (
  `ResearchID` int(5) NOT NULL,
  `ResearchName` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Research`
--

INSERT INTO `Research` (`ResearchID`, `ResearchName`) VALUES
(1, 'Artificial Inntelligence'),
(2, 'TCP/IP Networks'),
(3, 'Human Influence');

-- --------------------------------------------------------

--
-- Table structure for table `Skills`
--

CREATE TABLE `Skills` (
  `id` int(5) NOT NULL,
  `skillName` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Skills`
--

INSERT INTO `Skills` (`id`, `skillName`) VALUES
(1, 'Developer'),
(2, 'Content Maker'),
(3, 'Administration'),
(4, 'High Management');

-- --------------------------------------------------------

--
-- Table structure for table `userResearches`
--

CREATE TABLE `userResearches` (
  `UserID` varchar(100) NOT NULL,
  `ResearchID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userResearches`
--

INSERT INTO `userResearches` (`UserID`, `ResearchID`) VALUES
('aa', 1),
('aa', 2),
('asd', 3);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `role_desc` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `profilepic` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `role`, `role_desc`, `name`, `profilepic`, `password`) VALUES
('aa', 'aa', 'aa', 'aa', 'Default.png', 'aaa'),
('asd', 'asd', 'asd', 'asd', 'asd', 'asd'),
('ddf', 'ddf', 'ddf', 'ddf', 'Default.png', 'ddf'),
('nisanb', 'admin', 'admindesc', 'Nisan Bahar', 'Default.png', 'admin'),
('nisanb2', 'admin', 'admindesc', 'Nisan Bahar', 'Default.png', 'admin'),
('nisanb3', 'admin', 'admin2', 'Nisan Bahar', 'Default.png', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `userSkills`
--

CREATE TABLE `userSkills` (
  `UserID` varchar(100) NOT NULL,
  `SkillID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userSkills`
--

INSERT INTO `userSkills` (`UserID`, `SkillID`) VALUES
('aa', 1),
('aa', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Followers`
--
ALTER TABLE `Followers`
  ADD PRIMARY KEY (`FollowerID`,`FollowingID`),
  ADD KEY `FollowingID` (`FollowingID`);

--
-- Indexes for table `JobOffers`
--
ALTER TABLE `JobOffers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Messages`
--
ALTER TABLE `Messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FromID` (`FromID`),
  ADD KEY `ToID` (`ToID`);

--
-- Indexes for table `Notifications`
--
ALTER TABLE `Notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `projectFiles`
--
ALTER TABLE `projectFiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ProjectID` (`ProjectID`),
  ADD KEY `fileName` (`fileName`);

--
-- Indexes for table `Projects`
--
ALTER TABLE `Projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Projects_ibfk_1` (`UserID`);

--
-- Indexes for table `Research`
--
ALTER TABLE `Research`
  ADD PRIMARY KEY (`ResearchID`);

--
-- Indexes for table `Skills`
--
ALTER TABLE `Skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userResearches`
--
ALTER TABLE `userResearches`
  ADD PRIMARY KEY (`UserID`,`ResearchID`),
  ADD KEY `ResearchID` (`ResearchID`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userSkills`
--
ALTER TABLE `userSkills`
  ADD PRIMARY KEY (`UserID`,`SkillID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `SkillID` (`SkillID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `JobOffers`
--
ALTER TABLE `JobOffers`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Messages`
--
ALTER TABLE `Messages`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Notifications`
--
ALTER TABLE `Notifications`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projectFiles`
--
ALTER TABLE `projectFiles`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Research`
--
ALTER TABLE `Research`
  MODIFY `ResearchID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Skills`
--
ALTER TABLE `Skills`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Followers`
--
ALTER TABLE `Followers`
  ADD CONSTRAINT `Followers_ibfk_1` FOREIGN KEY (`FollowerID`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Followers_ibfk_2` FOREIGN KEY (`FollowingID`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Messages`
--
ALTER TABLE `Messages`
  ADD CONSTRAINT `Messages_ibfk_1` FOREIGN KEY (`FromID`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Messages_ibfk_2` FOREIGN KEY (`ToID`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Notifications`
--
ALTER TABLE `Notifications`
  ADD CONSTRAINT `Notifications_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projectFiles`
--
ALTER TABLE `projectFiles`
  ADD CONSTRAINT `projectFiles_ibfk_1` FOREIGN KEY (`ProjectID`) REFERENCES `Projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Projects`
--
ALTER TABLE `Projects`
  ADD CONSTRAINT `Projects_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `userResearches`
--
ALTER TABLE `userResearches`
  ADD CONSTRAINT `userResearches_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userResearches_ibfk_2` FOREIGN KEY (`ResearchID`) REFERENCES `Research` (`ResearchID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `userSkills`
--
ALTER TABLE `userSkills`
  ADD CONSTRAINT `userSkills_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userSkills_ibfk_2` FOREIGN KEY (`SkillID`) REFERENCES `Skills` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
