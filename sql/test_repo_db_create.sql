-- phpMyAdmin SQL Dump
-- version 4.2.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 27, 2015 at 05:11 PM
-- Server version: 5.5.40
-- PHP Version: 5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test_repo`
--
CREATE DATABASE IF NOT EXISTS `test_repo` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test_repo`;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
`id` int(10) unsigned NOT NULL,
  `category` enum('Meteorologie','Aerodinamica','Navigatie') NOT NULL,
  `category_index` int(11) NOT NULL,
  `text` text NOT NULL,
  `answer_1` varchar(255) DEFAULT NULL,
  `answer_2` varchar(255) DEFAULT NULL,
  `answer_3` varchar(255) DEFAULT NULL,
  `answer_4` varchar(255) DEFAULT NULL,
  `answer_5` varchar(255) DEFAULT NULL,
  `answer_6` varchar(255) DEFAULT NULL,
  `answer_7` varchar(255) DEFAULT NULL,
  `answer_8` varchar(255) DEFAULT NULL,
  `answer_9` varchar(255) DEFAULT NULL,
  `answer_10` varchar(255) DEFAULT NULL,
  `correct` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--


-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE IF NOT EXISTS `scores` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `finished` tinyint(1) NOT NULL,
  `test_setup` text NOT NULL,
  `score` float NOT NULL,
  `questions_answered` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `criteria` varchar(255) NOT NULL,
  `q_right` int(11) NOT NULL,
  `q_wrong` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE IF NOT EXISTS `tests` (
`id` int(11) NOT NULL,
  `scores_id` int(11) NOT NULL,
  `questions_id` int(11) NOT NULL,
  `user_answers` varchar(255) NOT NULL,
  `score` float NOT NULL,
  `number_answers` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tests`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `scores`
--
ALTER TABLE `scores`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
