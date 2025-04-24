-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 24 avr. 2025 à 11:50
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `reservationdb`
--

-- --------------------------------------------------------

--
-- Structure de la table `menu`
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
-- Déchargement des données de la table `menu`
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

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
