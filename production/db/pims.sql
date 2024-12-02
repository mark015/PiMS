-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2024 at 09:57 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pims`
--

-- --------------------------------------------------------

--
-- Table structure for table `encoded_item`
--

CREATE TABLE `encoded_item` (
  `id` int(11) NOT NULL,
  `item_code` varchar(255) NOT NULL,
  `item_desc` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `encoded_item`
--

INSERT INTO `encoded_item` (`id`, `item_code`, `item_desc`, `quantity`, `date`) VALUES
(3, 'CH-0000003-24', 'Chair, Wooden, wiht Arm', '1000', '2024-11-28'),
(4, 'CH-000002-24', 'Chair, Plastic', '1500', '2024-07-11'),
(5, 'CH-000001-24', 'Chair, Wooden, wiht Arm', '2500', '2024-01-03'),
(6, 'TA-000003-24', 'Table, Plastic, Folding', '25', '2024-11-28'),
(7, 'TA-000002-24', 'Table, Plastic, Folding', '20', '2024-07-11'),
(8, 'TA-000001-24', 'Table, Plastic, Folding', '25', '2024-01-03');

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE `school` (
  `id` int(11) NOT NULL,
  `school_id` varchar(255) NOT NULL,
  `school_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`id`, `school_id`, `school_name`) VALUES
(7, '136904', 'Pututan Elementary Sschool'),
(8, '136910', 'Bayanan Elementary School Unit 1'),
(9, '136899', 'Bayanan Elementary School Main');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `role`) VALUES
(1, 'Mark Balinario', 'admin', '8d4db54daf7d67db5f3c96e43f61c609', 'Admin'),
(2, 'mark', 'mbdev', '464da487a0286c0b7c1f00e5ed3de7d1', 'User'),
(3, 'user2', 'user2', '464da487a0286c0b7c1f00e5ed3de7d1', 'User');

-- --------------------------------------------------------

--
-- Table structure for table `withdral_item`
--

CREATE TABLE `withdral_item` (
  `id` int(11) NOT NULL,
  `school_id` varchar(255) NOT NULL,
  `item_id` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `withdral_item`
--

INSERT INTO `withdral_item` (`id`, `school_id`, `item_id`, `quantity`) VALUES
(16, '7', 'CH-0000003-24', '1000'),
(17, '8', 'CH-000002-24', '1500'),
(18, '9', 'CH-000001-24', '2500'),
(19, '7', 'TA-000003-24', '25'),
(21, '8', 'TA-000002-24', '20'),
(22, '9', 'TA-000001-24', '25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `encoded_item`
--
ALTER TABLE `encoded_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdral_item`
--
ALTER TABLE `withdral_item`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `encoded_item`
--
ALTER TABLE `encoded_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `school`
--
ALTER TABLE `school`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `withdral_item`
--
ALTER TABLE `withdral_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
