-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2017 at 11:19 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `payments`
--

-- --------------------------------------------------------

--
-- Table structure for table `paytm`
--

CREATE TABLE `paytm` (
  `name` varchar(50) NOT NULL,
  `reg` int(20) NOT NULL,
  `tid` int(20) NOT NULL,
  `date` varchar(20) NOT NULL,
  `amount` float NOT NULL,
  `mob_number` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `paytm`
--
ALTER TABLE `paytm`
  ADD PRIMARY KEY (`tid`),
  ADD UNIQUE KEY `tid` (`tid`),
  ADD KEY `tid_2` (`tid`),
  ADD KEY `tid_3` (`tid`),
  ADD KEY `tid_4` (`tid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
