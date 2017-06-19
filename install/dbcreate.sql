-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jun 20, 2017 at 12:46 AM
-- Server version: 5.5.42
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `reflectivejournal`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `activity_id` int(11) NOT NULL,
  `course_id` varchar(1000) NOT NULL,
  `entry_title` varchar(1000) NOT NULL,
  `title` text,
  `introtext` text NOT NULL,
  `reviewintro` text NOT NULL,
  `feedback` text NOT NULL,
  `type` varchar(500) NOT NULL,
  `show_wordcloud` tinyint(1) NOT NULL,
  `show_titleinexport` tinyint(1) NOT NULL,
  `export_title` varchar(1000) NOT NULL,
  `wordcount_limit` int(11) NOT NULL,
  `show_wordcount` int(11) NOT NULL,
  `height` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `studentresponse`
--

CREATE TABLE `studentresponse` (
  `response_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `course_id` varchar(1000) NOT NULL,
  `student_id` varchar(1000) NOT NULL,
  `reflectivetext` text NOT NULL,
  `dateadded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `studentresponse`
--
ALTER TABLE `studentresponse`
  ADD PRIMARY KEY (`response_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `studentresponse`
--
ALTER TABLE `studentresponse`
  MODIFY `response_id` int(11) NOT NULL AUTO_INCREMENT;
