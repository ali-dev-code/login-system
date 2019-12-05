-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2019 at 11:19 AM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `validation_code` text NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `validation_code`, `active`) VALUES
(19, 'ali', 'ali', 'aliasghar5', 'aliasgharabcd@gmail.com', '4d7ab12f3ca1d4d78abeb248c85c0525', '0008821554bb799b2e9b9627c338dd4a', 1),
(20, 'taskeen', 'taskeen', 'taskeenhiader514', 'taskeenhiader514@gmail.com', '202cb962ac59075b964b07152d234b70', 'a8e67e18ea43d8b4c0316b5604348b01', 0),
(21, 'taskeen', 'taskeen', 'taskeenhiader5144', 'taskeenhiader51w1234@gmail.com', '202cb962ac59075b964b07152d234b70', 'bbfbd303043f11003aa05de7e7705557', 0),
(22, 'asad', 'asad', 'asadali', 'asadali@gmail.com', '140b543013d988f4767277b6f45ba542', 'fdcbacd52e7bca975a1fab6cc9941abf', 0),
(23, 'ali', 'ali', 'aliasghar', 'sufyan@gmail.com', '202cb962ac59075b964b07152d234b70', 'd13a422209bdf0aadd9fe14aed8dea95', 0),
(24, 'ali', 'ali', 'aliasghar333', 'aliraza@gmail.com', '202cb962ac59075b964b07152d234b70', 'bca37f73bf8cbbf663ae093f93a7abba', 0),
(25, 'ali', 'ali', 'aliasghar555', 'sufyan111@gmail.com', '202cb962ac59075b964b07152d234b70', '2c48a18a25be76f69a56ef29ec6d5081', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
