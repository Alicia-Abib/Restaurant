-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 25, 2025 at 01:31 AM
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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `nom`) VALUES
(4, 'Boissons'),
(3, 'Desserts'),
(1, 'Entrées'),
(2, 'Plats');

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
(1, 'Moucer', 'Bahdja', 'mcrbahdja@gmail.com', '$2y$10$VnJO8anQuYQzrU0mZaCicuO4ZN6M8zN4akb2GXVknJR08b0mvfmyS');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `prix` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `nom`, `description`, `prix`, `image_url`, `category_id`, `created_at`) VALUES
(9, 'Sushi mix (12 pièces)', 'Assortiment maki & nigiri : saumon, thon, crevette, avocat.', 15.90, 'assets/img/sushi.jpg', 1, '2025-04-23 20:30:59'),
(10, 'Sashimi saumon (8 pièces)', 'Tranches fines de saumon Label Rouge, servies avec gingembre & wasabi.', 13.50, 'assets/img/sashimi.jpg', 1, '2025-04-23 20:30:59'),
(11, 'Gyoza poulet (6 pièces)', 'Raviolis grillés farcis poulet & légumes, sauce soja-sésame.', 6.90, 'assets/img/gyoza.jpg', 1, '2025-04-23 20:30:59'),
(12, 'Ramen tonkotsu', 'Bouillon de porc mijoté 12 h, nouilles fraîches, chashu, œuf mariné.', 14.80, 'assets/img/ramen.jpg', 2, '2025-04-23 20:30:59'),
(13, 'Pad Thaï crevettes', 'Nouilles de riz sautées, crevettes, œuf, cacahuètes, coriandre.', 12.40, 'assets/img/pad_thai.jpg', 2, '2025-04-23 20:30:59'),
(14, 'Bibimbap bœuf', 'Riz chaud, légumes croquants, bœuf mariné, œuf au plat, sauce gochujang.', 13.90, 'assets/img/bibimbap.jpg', 2, '2025-04-23 20:30:59'),
(15, 'Banh Mi porc laqué', 'Baguette vietnamienne, porc caramélisé, pickles, coriandre, mayo épicée.', 8.50, 'assets/img/banh_mi.jpg', 2, '2025-04-23 20:30:59'),
(16, 'Bubble tea taro 50 cl', 'Perles de tapioca, lait végétal au taro, glaçons.', 4.80, 'assets/img/bubble_tea.jpg', 4, '2025-04-23 20:30:59'),
(17, 'Mochi trio', 'Glaces japonaises parfum thé vert, fraise et sésame.', 5.20, 'assets/img/mochi.jpg', 3, '2025-04-23 21:23:49'),
(18, 'Dorayaki azuki', 'Pancake japonais fourré pâte de haricots rouges.', 4.50, 'assets/img/dorayaki.jpg', 3, '2025-04-23 21:23:49'),
(19, 'Taiyaki custard', 'Gaufre poisson garnie de crème pâtissière.', 4.90, 'assets/img/taiyaki.jpg', 3, '2025-04-23 21:23:49'),
(20, 'Cheesecake matcha', 'Cheesecake onctueux au thé vert matcha Uji.', 5.80, 'assets/img/cheesecake.jpg', 3, '2025-04-23 21:23:49');

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
(38, 'Alicia', 'Abib', '2025-04-23', '13:00:00', 1, '2025-04-23 15:44:07', 2, 'abib.alicia@yahoo.com', NULL),
(39, 'Alicia', 'Abib', '2025-04-23', '14:00:00', 1, '2025-04-23 15:44:25', 1, 'abib.alicia@yahoo.com', NULL),
(47, 'Rahali', 'Thiziri', '2025-04-24', '12:00:00', 2, '2025-04-24 22:34:32', 2, 'mcrbahdja@gmail.com', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `fk_client` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
