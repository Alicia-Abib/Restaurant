-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 23, 2025 at 02:47 PM
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
-- Database: `reservationdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `prenom`, `email`, `mdp`) VALUES
(1, 'Rahali', 'Thiziri', 'mcrbahdja@gmail.com', '$2y$10$VnJO8anQuYQzrU0mZaCicuO4ZN6M8zN4akb2GXVknJR08b0mvfmyS');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `date_reservation` date NOT NULL,
  `heure` time NOT NULL,
  `nb_personnes` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_table` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_client` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `nom`, `prenom`, `date_reservation`, `heure`, `nb_personnes`, `created_at`, `id_table`, `email`, `id_client`) VALUES
(5, 'bahdja', 'mimi', '2025-04-02', '23:11:00', 1, '2025-04-06 20:11:06', 0, '', NULL),
(6, 'bahdja', 'mimi', '2025-04-02', '23:11:00', 1, '2025-04-06 20:12:50', 0, '', NULL),
(7, 'bahdja', 'mimi', '2025-04-02', '23:11:00', 1, '2025-04-06 20:15:38', 0, '', NULL),
(8, 'test', 'mimi', '2025-04-17', '15:40:00', 1, '2025-04-12 13:38:54', 0, '', NULL),
(12, 'mehdi', 'amokrane', '2025-04-30', '20:30:00', 1, '2025-04-12 15:28:30', 1, 'mehdiamokrane28@gmail.com', NULL),
(13, 'mehdi', 'amokrane', '2025-04-17', '15:40:00', 1, '2025-04-12 15:28:59', 1, 'mehdiamokrane28@gmail.com', NULL),
(14, 'Dupont', 'lily', '2025-04-02', '23:11:00', 2, '2025-04-12 15:36:27', 1, 'aliceabib5@gmail.com', NULL),
(15, 'Dupont', 'jean', '2025-04-01', '22:16:00', 2, '2025-04-12 15:37:34', 1, 'jeandupont5@gmail.com', NULL),
(16, 'Dupont', 'jean', '2025-04-01', '22:16:00', 2, '2025-04-12 15:37:45', 2, 'jeandupont5@gmail.com', NULL),
(35, 'Moucer', 'Bahdja', '2025-04-22', '12:00:00', 1, '2025-04-22 22:09:29', 2, 'b.moucer12@gmail.com', NULL),
(36, 'Rahali', 'Thiziri', '2025-04-23', '12:00:00', 1, '2025-04-23 11:36:23', 4, 'mcrbahdja@gmail.com', 1),
(37, 'Rahali', 'Thiziri', '2025-04-23', '13:00:00', 2, '2025-04-23 12:43:04', 3, 'mcrbahdja@gmail.com', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_client` (`id_client`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `fk_client` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
