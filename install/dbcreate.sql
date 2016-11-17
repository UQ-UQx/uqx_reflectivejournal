-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 17, 2016 at 02:45 AM
-- Server version: 5.5.42
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `reflectivejournal`
--

-- --------------------------------------------------------

--
-- Table structure for table `studentresponse`
--

CREATE TABLE `studentresponse` (
  `response_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `student_id` varchar(1000) NOT NULL,
  `reflectivetext` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `studentresponse`
--
ALTER TABLE `studentresponse`
  ADD PRIMARY KEY (`response_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `studentresponse`
--
ALTER TABLE `studentresponse`
  MODIFY `response_id` int(11) NOT NULL AUTO_INCREMENT;
