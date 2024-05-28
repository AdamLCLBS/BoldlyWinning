-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 09 avr. 2024 à 07:33
-- Version du serveur : 8.0.30
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `boldlywinning`
--
CREATE DATABASE IF NOT EXISTS `boldlywinning` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `boldlywinning`;

-- --------------------------------------------------------

--
-- Structure de la table `bracket`
--

CREATE TABLE `bracket` (
  `id_bracket` int NOT NULL,
  `id_tournoi` int NOT NULL,
  `nom_bracket` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Bracket',
  `taille_bracket` int DEFAULT NULL,
  `jeux` varchar(32) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `bracket`
--

INSERT INTO `bracket` (`id_bracket`, `id_tournoi`, `nom_bracket`, `taille_bracket`, `jeux`) VALUES
(15, 18, '1er bracket', 32, 'multi'),
(16, 19, 'vvv', 32, 'guilty'),
(18, 21, 'Bracket', 12, 'Guilty'),
(19, 22, 'Premier Bracket', 12, 'Tekken'),
(22, 25, '1er bracket', 10, 'tekken 8');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `id_contact` int NOT NULL,
  `nom` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `sujet` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id_contact`, `nom`, `mail`, `sujet`, `message`) VALUES
(7, 'Lahcene', 'adam.louis.lahcene@gmail.com', 'ECLIPSE DE 3J ????', 'Salut a tous c\'est lasalle ajd on se retrouve pour compter toute les places de parking dans los santos aller c\'est parti 1, 2, 3, 5, ');

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

CREATE TABLE `joueur` (
  `id_joueur` int NOT NULL,
  `id_user` int NOT NULL,
  `id_bracket` int NOT NULL,
  `nom_joueur` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nombre_point` int NOT NULL DEFAULT '0',
  `win` int NOT NULL DEFAULT '0',
  `loses` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `joueur`
--

INSERT INTO `joueur` (`id_joueur`, `id_user`, `id_bracket`, `nom_joueur`, `nombre_point`, `win`, `loses`) VALUES
(28, 3, 16, 'Globo', 1, 1, 0),
(33, 5, 16, 'TaZythhhh', 0, 0, 0),
(34, 3, 16, 'Gotaga', 0, 0, 0),
(35, 5, 16, 'Wartek', 0, 0, 0),
(36, 3, 16, 'Roblox', 0, 0, 0),
(37, 5, 16, 'Minecraft', 0, 0, 0),
(38, 3, 16, 'Diablox9', 0, 0, 1),
(39, 5, 16, 'Zack Nani', 0, 0, 0),
(40, 3, 16, 'Doigby', 0, 0, 0),
(41, 5, 16, 'Bazouxx', 0, 0, 0),
(45, 3, 15, 'Globo', 0, 0, 0),
(46, 5, 15, 'TaZythhhh', 0, 0, 0),
(47, 8, 18, 'Mada', 0, 0, 0),
(52, 15, 16, 'OVAL', 0, 0, 0),
(53, 15, 16, 'OVAL2', 0, 0, 0),
(54, 16, 22, 'Soutenance', 2, 1, 0),
(55, 16, 22, 'Soutenance2', 0, 0, 0),
(56, 16, 22, 'Soutenance3', 0, 0, 1),
(57, 16, 22, 'Soutenance4', 0, 0, 0),
(58, 15, 15, 'OVAL', 0, 0, 0),
(59, 15, 19, 'OVAL', 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `match_bracket`
--

CREATE TABLE `match_bracket` (
  `id_match` int NOT NULL,
  `id_bracket` int NOT NULL,
  `id_joueur1` int NOT NULL,
  `id_joueur2` int NOT NULL,
  `p1` varchar(32) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `p2` varchar(32) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `winner` varchar(32) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `score_p1` int NOT NULL DEFAULT '0',
  `score_p2` int NOT NULL DEFAULT '0',
  `ft` enum('1','2','3','4','5','6','7') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `match_bracket`
--

INSERT INTO `match_bracket` (`id_match`, `id_bracket`, `id_joueur1`, `id_joueur2`, `p1`, `p2`, `winner`, `score_p1`, `score_p2`, `ft`) VALUES
(4410, 22, 54, 56, 'Soutenance', 'Soutenance3', 'Soutenance', 2, 0, '1'),
(4411, 22, 55, 57, 'Soutenance2', 'Soutenance4', NULL, 0, 0, '1'),
(4412, 22, 54, 55, 'Soutenance', 'Soutenance2', NULL, 0, 0, '1'),
(4413, 22, 57, 56, 'Soutenance4', 'Soutenance3', NULL, 0, 0, '1'),
(4414, 22, 54, 57, 'Soutenance', 'Soutenance4', NULL, 0, 0, '1'),
(4415, 22, 56, 55, 'Soutenance3', 'Soutenance2', NULL, 0, 0, '1'),
(4416, 15, 45, 58, 'Globo', 'OVAL', NULL, 0, 0, '1'),
(4417, 15, 45, 46, 'Globo', 'TaZythhhh', NULL, 0, 0, '1'),
(4418, 15, 58, 46, 'OVAL', 'TaZythhhh', NULL, 0, 0, '1'),
(4419, 16, 28, 38, 'Globo', 'Diablox9', 'Globo', 1, 0, '1'),
(4420, 16, 33, 39, 'TaZythhhh', 'Zack Nani', NULL, 0, 0, '1'),
(4421, 16, 34, 40, 'Gotaga', 'Doigby', NULL, 0, 0, '1'),
(4422, 16, 35, 41, 'Wartek', 'Bazouxx', NULL, 0, 0, '1'),
(4423, 16, 36, 52, 'Roblox', 'OVAL', NULL, 0, 0, '1'),
(4424, 16, 37, 53, 'Minecraft', 'OVAL2', NULL, 0, 0, '1'),
(4425, 16, 28, 33, 'Globo', 'TaZythhhh', NULL, 0, 0, '1'),
(4426, 16, 34, 38, 'Gotaga', 'Diablox9', NULL, 0, 0, '1'),
(4427, 16, 35, 39, 'Wartek', 'Zack Nani', NULL, 0, 0, '1'),
(4428, 16, 36, 40, 'Roblox', 'Doigby', NULL, 0, 0, '1'),
(4429, 16, 37, 41, 'Minecraft', 'Bazouxx', NULL, 0, 0, '1'),
(4430, 16, 53, 52, 'OVAL2', 'OVAL', NULL, 0, 0, '1'),
(4431, 16, 28, 34, 'Globo', 'Gotaga', NULL, 0, 0, '1'),
(4432, 16, 35, 33, 'Wartek', 'TaZythhhh', NULL, 0, 0, '1'),
(4433, 16, 36, 38, 'Roblox', 'Diablox9', NULL, 0, 0, '1'),
(4434, 16, 37, 39, 'Minecraft', 'Zack Nani', NULL, 0, 0, '1'),
(4435, 16, 53, 40, 'OVAL2', 'Doigby', NULL, 0, 0, '1'),
(4436, 16, 52, 41, 'OVAL', 'Bazouxx', NULL, 0, 0, '1'),
(4437, 16, 28, 35, 'Globo', 'Wartek', NULL, 0, 0, '1'),
(4438, 16, 36, 34, 'Roblox', 'Gotaga', NULL, 0, 0, '1'),
(4439, 16, 37, 33, 'Minecraft', 'TaZythhhh', NULL, 0, 0, '1'),
(4440, 16, 53, 38, 'OVAL2', 'Diablox9', NULL, 0, 0, '1'),
(4441, 16, 52, 39, 'OVAL', 'Zack Nani', NULL, 0, 0, '1'),
(4442, 16, 41, 40, 'Bazouxx', 'Doigby', NULL, 0, 0, '1'),
(4443, 16, 28, 36, 'Globo', 'Roblox', NULL, 0, 0, '1'),
(4444, 16, 37, 35, 'Minecraft', 'Wartek', NULL, 0, 0, '1'),
(4445, 16, 53, 34, 'OVAL2', 'Gotaga', NULL, 0, 0, '1'),
(4446, 16, 52, 33, 'OVAL', 'TaZythhhh', NULL, 0, 0, '1'),
(4447, 16, 41, 38, 'Bazouxx', 'Diablox9', NULL, 0, 0, '1'),
(4448, 16, 40, 39, 'Doigby', 'Zack Nani', NULL, 0, 0, '1'),
(4449, 16, 28, 37, 'Globo', 'Minecraft', NULL, 0, 0, '1'),
(4450, 16, 53, 36, 'OVAL2', 'Roblox', NULL, 0, 0, '1'),
(4451, 16, 52, 35, 'OVAL', 'Wartek', NULL, 0, 0, '1'),
(4452, 16, 41, 34, 'Bazouxx', 'Gotaga', NULL, 0, 0, '1'),
(4453, 16, 40, 33, 'Doigby', 'TaZythhhh', NULL, 0, 0, '1'),
(4454, 16, 39, 38, 'Zack Nani', 'Diablox9', NULL, 0, 0, '1'),
(4455, 16, 28, 53, 'Globo', 'OVAL2', NULL, 0, 0, '1'),
(4456, 16, 52, 37, 'OVAL', 'Minecraft', NULL, 0, 0, '1'),
(4457, 16, 41, 36, 'Bazouxx', 'Roblox', NULL, 0, 0, '1'),
(4458, 16, 40, 35, 'Doigby', 'Wartek', NULL, 0, 0, '1'),
(4459, 16, 39, 34, 'Zack Nani', 'Gotaga', NULL, 0, 0, '1'),
(4460, 16, 38, 33, 'Diablox9', 'TaZythhhh', NULL, 0, 0, '1'),
(4461, 16, 28, 52, 'Globo', 'OVAL', NULL, 0, 0, '1'),
(4462, 16, 41, 53, 'Bazouxx', 'OVAL2', NULL, 0, 0, '1'),
(4463, 16, 40, 37, 'Doigby', 'Minecraft', NULL, 0, 0, '1'),
(4464, 16, 39, 36, 'Zack Nani', 'Roblox', NULL, 0, 0, '1'),
(4465, 16, 38, 35, 'Diablox9', 'Wartek', NULL, 0, 0, '1'),
(4466, 16, 33, 34, 'TaZythhhh', 'Gotaga', NULL, 0, 0, '1'),
(4467, 16, 28, 41, 'Globo', 'Bazouxx', NULL, 0, 0, '1'),
(4468, 16, 40, 52, 'Doigby', 'OVAL', NULL, 0, 0, '1'),
(4469, 16, 39, 53, 'Zack Nani', 'OVAL2', NULL, 0, 0, '1'),
(4470, 16, 38, 37, 'Diablox9', 'Minecraft', NULL, 0, 0, '1'),
(4471, 16, 33, 36, 'TaZythhhh', 'Roblox', NULL, 0, 0, '1'),
(4472, 16, 34, 35, 'Gotaga', 'Wartek', NULL, 0, 0, '1'),
(4473, 16, 28, 40, 'Globo', 'Doigby', NULL, 0, 0, '1'),
(4474, 16, 39, 41, 'Zack Nani', 'Bazouxx', NULL, 0, 0, '1'),
(4475, 16, 38, 52, 'Diablox9', 'OVAL', NULL, 0, 0, '1'),
(4476, 16, 33, 53, 'TaZythhhh', 'OVAL2', NULL, 0, 0, '1'),
(4477, 16, 34, 37, 'Gotaga', 'Minecraft', NULL, 0, 0, '1'),
(4478, 16, 35, 36, 'Wartek', 'Roblox', NULL, 0, 0, '1'),
(4479, 16, 28, 39, 'Globo', 'Zack Nani', NULL, 0, 0, '1'),
(4480, 16, 38, 40, 'Diablox9', 'Doigby', NULL, 0, 0, '1'),
(4481, 16, 33, 41, 'TaZythhhh', 'Bazouxx', NULL, 0, 0, '1'),
(4482, 16, 34, 52, 'Gotaga', 'OVAL', NULL, 0, 0, '1'),
(4483, 16, 35, 53, 'Wartek', 'OVAL2', NULL, 0, 0, '1'),
(4484, 16, 36, 37, 'Roblox', 'Minecraft', NULL, 0, 0, '1');

-- --------------------------------------------------------

--
-- Structure de la table `tournoi`
--

CREATE TABLE `tournoi` (
  `id_tournoi` int NOT NULL,
  `tournoi_statut` int NOT NULL DEFAULT '0',
  `nom_tournoi` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `nom_createur` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_user` int NOT NULL,
  `nombre_joueur` int DEFAULT NULL,
  `gagnant` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_debut` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_in_fin` datetime DEFAULT NULL,
  `cp` int DEFAULT NULL,
  `montant_entree` int DEFAULT NULL,
  `montant_jeux` int DEFAULT NULL,
  `jeux` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `banniere` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tournoi`
--

INSERT INTO `tournoi` (`id_tournoi`, `tournoi_statut`, `nom_tournoi`, `description`, `nom_createur`, `id_user`, `nombre_joueur`, `gagnant`, `date_debut`, `date_fin`, `check_in`, `check_in_fin`, `cp`, `montant_entree`, `montant_jeux`, `jeux`, `Image`, `banniere`) VALUES
(18, 1, 'Salut a tous c\'est la salle', 'Courte description', 'TaZythhhh', 5, 64, NULL, '2024-03-23 00:00:00', '2024-03-24 00:00:00', '2024-03-30 09:13:00', '2024-03-30 13:13:00', 25, 4, 4, 'multi', 'https://image.noelshack.com/fichiers/2023/23/1/1685969421-silverwolf-bruh.png', 'https://s.yimg.com/ny/api/res/1.2/g.dnoXzRT9ehvTUr1d53Ig--/YXBwaWQ9aGlnaGxhbmRlcjt3PTk2MDtoPTU0ODtjZj13ZWJw/https://media.zenfs.com/fr/numerama_fr_articles_937/6a4a1cf47c9857144521abbaacbb1801'),
(19, 1, 'salut', 'Une vrai description\r\nABABABABABABABABABABABABABA', 'Globo', 3, 12, NULL, '2024-03-27 00:00:00', '2024-03-22 07:33:00', '2024-03-29 07:33:00', '2024-03-29 07:33:00', 1, 2, 2, 'guilty', 'https://risibank.fr/cache/medias/0/32/3294/329471/full.png', ''),
(21, 0, 'Titre du tournoi', 'Une petit description ', 'Mada', 8, 12, NULL, '2024-03-29 00:00:00', '2024-03-30 00:00:00', '2024-03-29 14:29:00', '2024-03-29 14:30:00', 90, 5, 5, 'Guilty', 'https://content.imageresizer.com/images/memes/Drip-Goku-meme-3.jpg', ''),
(22, 0, 'Un tournoi de tekken 8', 'La description du tournoi', 'Franky', 13, 12, NULL, '2024-04-01 02:00:00', '2024-03-30 00:00:00', '2024-03-29 15:42:00', '2024-03-29 16:42:00', 30, 2, 2, 'Tekken', 'https://s.yimg.com/ny/api/res/1.2/g.dnoXzRT9ehvTUr1d53Ig--/YXBwaWQ9aGlnaGxhbmRlcjt3PTk2MDtoPTU0ODtjZj13ZWJw/https://media.zenfs.com/fr/numerama_fr_articles_937/6a4a1cf47c9857144521abbaacbb1801', ''),
(25, 2, 'salut', 'Une description classique', 'Soutenance', 16, 10, NULL, '2024-04-05 00:00:00', '2024-04-06 00:00:00', '2024-04-05 18:25:00', '2024-04-05 19:25:00', NULL, NULL, NULL, 'tekken 8', 'https://cdn.futura-sciences.com/cdn-cgi/image/width=1920,quality=60,format=auto/sources/images/dossier/773/01-intro-773.jpg', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `statut` int NOT NULL,
  `pseudo` varchar(32) COLLATE utf8mb4_general_ci NOT NULL,
  `mdp` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` varchar(32) COLLATE utf8mb4_general_ci NOT NULL,
  `nom` varchar(32) COLLATE utf8mb4_general_ci NOT NULL,
  `civilite` enum('f','m','a','') COLLATE utf8mb4_general_ci NOT NULL,
  `ville` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `statut`, `pseudo`, `mdp`, `mail`, `prenom`, `nom`, `civilite`, `ville`) VALUES
(1, 0, 'DORF', '123', 'adam.louis.lahcene@gmail.com', 'Walid', 'legoat', 'f', 'Paris'),
(3, 2, 'Globo92', '$2y$10$qlv8IZ3mySUIoX9WPxrpaujB4JL3onInQkuZPcyYRxDyWoBIKvEIS', 'adam.louis.lahcene@gmail.com', 'Adam', 'Lahcene', 'f', NULL),
(4, 0, 'GOAT2002', '$2y$10$JQpBuUXvxDrpo1.LzfUDIOe6eEQViTtO9rPVz9jmiG.tScu0/u3AS', 'TAFCD2000@GMAIL.COM', 'ROR20005', 'GOAT5', 'f', 'Lille'),
(5, 2, 'TaZythhhh', '9119', 'adam.louis.lahcene@gmail.com', 'Adam', 'Lahcene', 'f', NULL),
(6, 0, 'Juju1', '$2y$10$GwtvuMRPZkuh.2luIPG7BeJocxNAI4cXaFAoNdz1JRxh9zb4IHh7a', 'justine.perinel@free.Fr', 'Justine', 'Perinel', 'f', NULL),
(8, 2, 'Mada', '8228', 'TaZyth77@gmail.com', 'Adam', 'Lahcene', 'f', NULL),
(10, 0, 'KOF', '$2y$10$Awc7rG/E4q.H0CJt.pJv0OTjmCXK.o8ulTvRX7lDdt86Xsszjbahe', 'TaZyth7777@gmail.com', 'Adam', 'Lahcene', 'f', NULL),
(11, 0, 'TFT', '$2y$10$a6tpz6Tm3Lbk.gDdMJ7xjei7MlzkACO79LO7yi1j1lDEHGo84eali', 'TAFCD205@GMAIL.COM', 'ROR20005', 'Lahcene', 'f', NULL),
(12, 0, 'gotaga', '$2y$10$ksE03vGQIQb5Hn6LhEX7gu5AwUoW6gmxU.tQxu23Qd6nprsWxhyga', 'koil@gmail.com', 'ddd', 'ddd', 'f', NULL),
(13, 0, 'Franky92', '$2y$10$2jqzWdhkjbe5JEYFSU/db.OCsB70FlXgPcmNIuV/C/v.YBD.LZiXi', 'Frank.medecine@gmail.com', 'Medecine', 'Frank', 'f', NULL),
(15, 2, 'OVAL', '$2y$10$lrcJiq9VDsSwKFfpLH.yO.qCTKDKQTvf8KAc87L6BIC5u03d1w4w.', 'TAFCD20088@GMAIL.COM', 'ROR2000', 'Lahcene', 'm', NULL),
(16, 0, 'Soutenance', '$2y$10$Ofngu68fikjUrQw7a1Ep3.Bok7H6f4OZoJGpWUgm3.2s3nN4JheYm', 'Adressemail@gmail.com', 'Adam', 'Lahcene', 'm', NULL),
(17, 0, 'BANANA', '$2y$10$ShYmBm6kYvqo7lcia.ZZZ.xRNHibp83A./fnNKjIKAzMOz9G.p7iK', 'BANANA@gmail.com', 'ROR20005', 'Lahcene', 'm', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bracket`
--
ALTER TABLE `bracket`
  ADD PRIMARY KEY (`id_bracket`),
  ADD KEY `id_tournoi` (`id_tournoi`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id_contact`);

--
-- Index pour la table `joueur`
--
ALTER TABLE `joueur`
  ADD PRIMARY KEY (`id_joueur`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_bracket` (`id_bracket`);

--
-- Index pour la table `match_bracket`
--
ALTER TABLE `match_bracket`
  ADD PRIMARY KEY (`id_match`),
  ADD KEY `id_bracket` (`id_bracket`),
  ADD KEY `id_joueur` (`id_joueur1`),
  ADD KEY `id_joueur2` (`id_joueur2`);

--
-- Index pour la table `tournoi`
--
ALTER TABLE `tournoi`
  ADD PRIMARY KEY (`id_tournoi`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bracket`
--
ALTER TABLE `bracket`
  MODIFY `id_bracket` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id_contact` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `joueur`
--
ALTER TABLE `joueur`
  MODIFY `id_joueur` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT pour la table `match_bracket`
--
ALTER TABLE `match_bracket`
  MODIFY `id_match` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4485;

--
-- AUTO_INCREMENT pour la table `tournoi`
--
ALTER TABLE `tournoi`
  MODIFY `id_tournoi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `bracket`
--
ALTER TABLE `bracket`
  ADD CONSTRAINT `bracket_ibfk_1` FOREIGN KEY (`id_tournoi`) REFERENCES `tournoi` (`id_tournoi`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Contraintes pour la table `joueur`
--
ALTER TABLE `joueur`
  ADD CONSTRAINT `joueur_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `joueur_ibfk_2` FOREIGN KEY (`id_bracket`) REFERENCES `bracket` (`id_bracket`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Contraintes pour la table `match_bracket`
--
ALTER TABLE `match_bracket`
  ADD CONSTRAINT `match_bracket_ibfk_1` FOREIGN KEY (`id_bracket`) REFERENCES `bracket` (`id_bracket`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `match_bracket_ibfk_2` FOREIGN KEY (`id_joueur1`) REFERENCES `joueur` (`id_joueur`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `match_bracket_ibfk_3` FOREIGN KEY (`id_joueur2`) REFERENCES `joueur` (`id_joueur`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Contraintes pour la table `tournoi`
--
ALTER TABLE `tournoi`
  ADD CONSTRAINT `tournoi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
