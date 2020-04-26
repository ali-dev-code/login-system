-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2020 at 07:10 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

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
  `role` varchar(255) NOT NULL,
  `validation_code` text NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `role`, `validation_code`, `active`) VALUES
(19, 'ali', 'ali', 'aliasghar5', 'aliasgharabcd@gmail.com', '4d7ab12f3ca1d4d78abeb248c85c0525', '', '5d545e363523bcd45c1b7848ce265f60', 1),
(20, 'taskeen', 'taskeen', 'taskeenhiader514', 'taskeenhiader514@gmail.com', '202cb962ac59075b964b07152d234b70', '', 'a8e67e18ea43d8b4c0316b5604348b01', 0),
(26, 'test user', 'test user', 'testuser', 'testuser@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Brand', '6a6c03da340dea3b420b20e566c07c42', 1),
(27, 'test user 2', 'test user 2', 'testuser2', 'testuser2@gmail.com', '96e79218965eb72c92a549dd5a330112', 'Influencer', '3cad448116376690ea1083242cb07bab', 1),
(28, 'test user 3', 'test user 3', 'testuser3', 'testuser3@gmail.com', '96e79218965eb72c92a549dd5a330112', 'Brand', 'e48c61a1bcd1409af19ea6f38579b53d', 1),
(29, 'test user 4', 'test user 4', 'testuser4', 'testuser4@gmail.com', '96e79218965eb72c92a549dd5a330112', 'Influencer', 'e05971dbbc0ba91d2ba9aea3ad44157c', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
