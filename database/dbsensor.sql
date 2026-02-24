-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2024 at 06:28 AM
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
-- Database: `dbsensor`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`) VALUES
(3, 'admin', '$2y$10$K46YM7OjBM7ty/AehxLP4u1kskaYFpk3TRL7xWNDTE/8NCY9vzHBy');

-- --------------------------------------------------------

--
-- Table structure for table `tbdatasensor`
--

CREATE TABLE `tbdatasensor` (
  `id` varchar(99) NOT NULL,
  `waktu` datetime DEFAULT NULL,
  `nilaiakurasi` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbdatasensor`
--

INSERT INTO `tbdatasensor` (`id`, `waktu`, `nilaiakurasi`) VALUES
('3', '2024-07-24 09:45:00', 90),
('1', '2024-01-18 01:07:00', 31.12),
('2', '2024-06-13 01:11:00', 72.23),
('4', '2023-04-13 10:14:00', 97.9);

-- --------------------------------------------------------

--
-- Table structure for table `tbjenissensor`
--

CREATE TABLE `tbjenissensor` (
  `id` varchar(99) NOT NULL,
  `nama` varchar(999) NOT NULL,
  `koordinat` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbjenissensor`
--

INSERT INTO `tbjenissensor` (`id`, `nama`, `koordinat`) VALUES
('1', 'Pusri TI', '-2.9682017, 104.8004501'),
('2', 'Lemabang 1 Ilir', '-2.9777933074630187, 104.79053729012253'),
('3', 'SMA Plus 17 ', '-2.941525, 104.747773'),
('4', 'Ampera', '-2.991639, 104.763482'),
('5', 'HAHAHAHHA', '-2.9728871661233702, 104.754312304668');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbjenissensor`
--
ALTER TABLE `tbjenissensor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
