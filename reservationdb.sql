-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 27, 2025 at 05:03 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `mdp_reset_codes`
--

CREATE TABLE `mdp_reset_codes` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `code` varchar(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(20, 'Cheesecake matcha', 'Cheesecake onctueux au thé vert matcha Uji.', 5.80, 'assets/img/cheesecake.jpg', 3, '2025-04-23 21:23:49'),
(21, 'Tempura crevettes', 'Beignets de crevettes croustillants servis avec sauce tentsuyu', 7.90, 'assets/img/tempura.jpg', 1, '2025-04-26 22:06:58'),
(22, 'Edamame', 'Jeunes fèves de soja légèrement salées', 3.60, 'assets/img/edamame.jpg', 1, '2025-04-26 22:06:58'),
(23, 'Katsu curry', 'Porc pané, riz parfumé et sauce curry japonaise maison', 14.20, 'assets/img/katsu_curry.jpg', 2, '2025-04-26 22:06:58'),
(24, 'Pho bo', 'Bouillon vietnamien mijoté, bœuf émincé, herbes fraîches, nouilles', 12.70, 'assets/img/pho_bo.jpg', 2, '2025-04-26 22:06:58'),
(25, 'Yakitori poulet', 'Brochettes de poulet laqué sauce tare, riz blanc', 11.40, 'assets/img/yakitori.jpg', 2, '2025-04-26 22:06:58'),
(26, 'Daifuku', 'Pâte de riz gluant fourrée à la pâte de haricots rouges', 4.30, 'assets/img/daifuku.jpg', 3, '2025-04-26 22:06:58'),
(27, 'Crème brûlée au sésame', 'Crème infusée au sésame noir avec caramel craquant', 5.60, 'assets/img/creme_brulee_sesame.jpg', 3, '2025-04-26 22:06:58'),
(28, 'Matcha latte', 'Thé vert matcha mousseux au lait', 4.80, 'assets/img/matcha_latte.jpg', 4, '2025-04-26 22:06:58'),
(29, 'Jus de yuzu pétillant', 'Boisson gazeuse artisanale au yuzu', 3.90, 'assets/img/yuzu_soda.jpg', 4, '2025-04-26 22:06:58'),
(30, 'Oolong glacé', 'Thé Oolong infusé à froid, notes fleuries', 3.70, 'assets/img/oolong_glace.jpg', 4, '2025-04-26 23:31:46'),
(31, 'Genmaicha chaud', 'Thé vert japonais grillé au riz soufflé', 3.40, 'assets/img/genmaicha.jpg', 4, '2025-04-26 23:31:46'),
(32, 'Thai iced tea', 'Thé noir épicé, lait concentré sucré, glace pilée', 4.20, 'assets/img/thai_iced_tea.jpg', 4, '2025-04-26 23:31:46'),
(33, 'Café viet susu', 'Café robusta filtré goutte-à-goutte, lait sucré', 3.90, 'assets/img/cafe_viet.jpg', 4, '2025-04-26 23:31:46'),
(34, 'Limonade lychee-gingembre', 'Soda artisanal au litchi & gingembre frais', 3.80, 'assets/img/lychee_ginger_soda.jpg', 4, '2025-04-26 23:31:46'),
(35, 'Bubble tea mangue', 'Thé noir, lait, perles de tapioca saveur mangue', 4.60, 'assets/img/bubble_mangue.jpg', 4, '2025-04-26 23:31:46'),
(36, 'Soda sakura', 'Boisson pétillante aux fleurs de cerisier', 4.00, 'assets/img/soda_sakura.jpg', 4, '2025-04-26 23:31:46'),
(37, 'Jus frais yuzu-pamplemousse', 'Pressé minute, sucré au miel', 4.10, 'assets/img/jus_yuzu_pamp.jpg', 4, '2025-04-26 23:31:46'),
(38, 'Mocktail Tokyo Mule', 'Gingembre, citron vert, yuzu, tonic', 5.20, 'assets/img/tokyo_mule.jpg', 4, '2025-04-26 23:31:46'),
(39, 'Virgin sake spritz', 'Saké sans alcool, tonic, concombre', 4.90, 'assets/img/virgin_sake_spritz.jpg', 4, '2025-04-26 23:31:46'),
(40, 'Gyoza porc', 'Raviolis japonais grillés, farce porc-chou', 5.60, 'assets/img/gyoza.jpg', 1, '2025-04-27 00:01:06'),
(41, 'Rouleaux de printemps', 'Galette de riz, crudités, vermicelles, menthe', 4.80, 'assets/img/rouleaux_printemps.jpg', 1, '2025-04-27 00:01:06'),
(42, 'Nems crevette', 'Rouleaux frits croustillants, crevettes entières', 5.20, 'assets/img/nems_crevette.jpg', 1, '2025-04-27 00:01:06'),
(43, 'Karaage', 'Morceaux de poulet marinés, friture minute', 6.40, 'assets/img/karaage.jpg', 1, '2025-04-27 00:01:06'),
(44, 'Siu mai porc-crevette', 'Bouchées vapeur porc, crevette et shiitake', 5.90, 'assets/img/siu_mai.jpg', 1, '2025-04-27 00:01:06'),
(45, 'Salade wakame', 'Algues marinées, sésame grillé', 4.10, 'assets/img/wakame.jpg', 1, '2025-04-27 00:01:06'),
(46, 'Takoyaki', 'Boulettes de pâte au poulpe, sauce okonomi', 6.30, 'assets/img/takoyaki.jpg', 1, '2025-04-27 00:01:06'),
(47, 'Bao buns char siu', 'Pains vapeur fourrés au porc laqué', 5.80, 'assets/img/bao_char_siu.jpg', 1, '2025-04-27 00:01:06'),
(48, 'Brochettes tofu satay', 'Tofu grillé, sauce cacahuète épicée', 5.00, 'assets/img/tofu_satay.jpg', 1, '2025-04-27 00:01:06'),
(49, 'Pancakes kimchi', 'Mini galettes coréennes au kimchi, sauce soja', 4.90, 'assets/img/kimchi_pancake.jpg', 1, '2025-04-27 00:01:06'),
(50, 'Bibimbap', 'Riz coréen, bœuf mariné, légumes sautés, œuf', 13.90, 'assets/img/bibimbap.jpg', 2, '2025-04-27 00:11:50'),
(51, 'Pad Thaï crevettes', 'Nouilles de riz sautées, crevettes, tamarin, cacahuètes', 12.80, 'assets/img/pad_thai.jpg', 2, '2025-04-27 00:11:50'),
(52, 'Ramen miso', 'Bouillon miso, porc chashu, nouilles fraîchement tirées', 14.50, 'assets/img/ramen_miso.jpg', 2, '2025-04-27 00:11:50'),
(53, 'Bo Bun bœuf', 'Vermicelles, bœuf citronnelle, nems, crudités, menthe', 11.90, 'assets/img/bo_bun.jpg', 2, '2025-04-27 00:11:50'),
(54, 'Bò Kho', 'Ragoût vietnamien de bœuf épicé, carottes, pain ou riz', 13.40, 'assets/img/bo_kho.jpg', 2, '2025-04-27 00:11:50'),
(55, 'Salmon teriyaki', 'Filet de saumon laqué, riz vinaigré, légumes croquants', 15.20, 'assets/img/salmon_teriyaki.jpg', 2, '2025-04-27 00:11:50'),
(56, 'Massaman curry', 'Curry thaï doux, bœuf, pommes de terre, lait de coco', 14.10, 'assets/img/massaman_curry.jpg', 2, '2025-04-27 00:11:50'),
(57, 'Mapo tofu', 'Tofu soyeux, porc haché, sauce piment-poivre Sichuan', 11.60, 'assets/img/mapo_tofu.jpg', 2, '2025-04-27 00:11:50'),
(58, 'Katsu don', 'Porc pané sur bol de riz, œuf, oignons, bouillon dashi', 12.70, 'assets/img/katsu_don.jpg', 2, '2025-04-27 00:11:50'),
(59, 'Laksa', 'Soupe épicée coco, crevettes, nouilles, herbes fraîches', 13.80, 'assets/img/laksa.jpg', 2, '2025-04-27 00:11:50'),
(60, 'Nasi goreng', 'Riz sauté indonésien, poulet, légumes, œuf au plat', 11.50, 'assets/img/nasi_goreng.jpg', 2, '2025-04-27 00:11:50'),
(61, 'Tteokbokki', 'Gâteaux de riz coréens pimentés, sauce gochujang, poisson', 10.90, 'assets/img/tteokbokki.jpg', 2, '2025-04-27 00:11:50'),
(62, 'Mochi glacé mangue', 'Glace mangue entourée de pâte de riz moelleuse', 4.70, 'assets/img/mochi_mangue.jpg', 3, '2025-04-27 00:25:10'),
(63, 'Pudding coco pandan', 'Flan coco parfum pandan, coulis caramel palmier', 4.90, 'assets/img/pudding_pandan.jpg', 3, '2025-04-27 00:25:10'),
(64, 'Chè ba màu', 'Trilogie vietnamienne de haricots, gelée et coco', 5.20, 'assets/img/che_ba_mau.jpg', 3, '2025-04-27 00:25:10'),
(65, 'Dorayaki azuki-matcha', 'Pancakes japonais fourrés haricots rouges, crème matcha', 4.60, 'assets/img/dorayaki_matcha.jpg', 3, '2025-04-27 00:25:10'),
(66, 'Taiyaki choco-noisette', 'Gaufre poisson farcie chocolat noisette', 4.80, 'assets/img/taiyaki_choco.jpg', 3, '2025-04-27 00:25:10'),
(67, 'Perles de coco', 'Boulettes vapeur coco-sésame, cœur haricot mungo', 4.30, 'assets/img/perles_coco.jpg', 3, '2025-04-27 00:25:10'),
(68, 'Crêpe mille-couches matcha', 'Gâteau 20 crêpes fines, crème légère thé vert', 5.60, 'assets/img/mille_crepes_matcha.jpg', 3, '2025-04-27 00:25:10'),
(69, 'Bingsu fraise', 'Glace neige coréenne, purée et dés de fraises', 5.80, 'assets/img/bingsu_fraise.jpg', 3, '2025-04-27 00:25:10'),
(70, 'Tarte yuzu-meringuée', 'Crème yuzu acidulée, meringue italienne', 5.40, 'assets/img/tarte_yuzu.jpg', 3, '2025-04-27 00:25:10'),
(71, 'Gâteau chiffon sesame noir', 'Génoise aérienne, crème chantilly sésame noir', 5.20, 'assets/img/chiffon_sesame.jpg', 3, '2025-04-27 00:25:10');

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
-- Indexes for table `mdp_reset_codes`
--
ALTER TABLE `mdp_reset_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_email` (`email`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mdp_reset_codes`
--
ALTER TABLE `mdp_reset_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mdp_reset_codes`
--
ALTER TABLE `mdp_reset_codes`
  ADD CONSTRAINT `mdp_reset_codes_ibfk_1` FOREIGN KEY (`email`) REFERENCES `clients` (`email`) ON DELETE CASCADE;

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
