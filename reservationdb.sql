-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 21 avr. 2025 à 21:27
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
-- Structure de la table `reservations`
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
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `nom`, `prenom`, `date_reservation`, `heure`, `nb_personnes`, `created_at`, `id_table`, `email`) VALUES

(5, 'bahdja', 'mimi', '2025-04-02', '23:11:00', 1, '2025-04-06 20:11:06', 0, ''),
(6, 'bahdja', 'mimi', '2025-04-02', '23:11:00', 1, '2025-04-06 20:12:50', 0, ''),
(7, 'bahdja', 'mimi', '2025-04-02', '23:11:00', 1, '2025-04-06 20:15:38', 0, ''),
(8, 'test', 'mimi', '2025-04-17', '15:40:00', 1, '2025-04-12 13:38:54', 0, ''),
(12, 'mehdi', 'amokrane', '2025-04-30', '20:30:00', 1, '2025-04-12 15:28:30', 1, 'mehdiamokrane28@gmail.com'),
(13, 'mehdi', 'amokrane', '2025-04-17', '15:40:00', 1, '2025-04-12 15:28:59', 1, 'mehdiamokrane28@gmail.com'),
(14, 'Dupont', 'lily', '2025-04-02', '23:11:00', 2, '2025-04-12 15:36:27', 1, 'aliceabib5@gmail.com'),
(15, 'Dupont', 'jean', '2025-04-01', '22:16:00', 2, '2025-04-12 15:37:34', 1, 'jeandupont5@gmail.com'),
(16, 'Dupont', 'jean', '2025-04-01', '22:16:00', 2, '2025-04-12 15:37:45', 2, 'jeandupont5@gmail.com');


--
-- Index pour les tables déchargées
--

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
