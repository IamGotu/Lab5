-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2024 at 10:43 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ipt101`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(10) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `Lastname` varchar(45) DEFAULT NULL,
  `First_name` varchar(45) DEFAULT NULL,
  `Middle_name` varchar(45) DEFAULT NULL,
  `Email` varchar(45) DEFAULT NULL,
  `Status` varchar(45) DEFAULT NULL,
  `Active` varchar(45) DEFAULT NULL,
  `verify_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(45) NOT NULL,
  `birthdate` text NOT NULL,
  `email` varchar(45) NOT NULL,
  `phone_number` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `profile_picture` text NOT NULL,
  `Status` varchar(45) NOT NULL,
  `Active` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `verify_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`user_id`, `full_name`, `birthdate`, `email`, `phone_number`, `address`, `password`, `profile_picture`, `Status`, `Active`, `created_at`, `verify_token`) VALUES
(20, 'Mark John Jopia', '2010-01-04', 'markjohnjopia1@gmail.com', '09514810354', 'Sinawal GSC', '12345', '1341032.png', 'Verified', 'Online', '2024-06-03 17:52:03', '4e0c');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `verify_token` (`verify_token`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `verify_token` (`verify_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
