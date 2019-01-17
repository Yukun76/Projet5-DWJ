-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 10 jan. 2019 à 13:41
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `petadopt`
--

-- --------------------------------------------------------

--
-- Structure de la table `ad`
--

DROP TABLE IF EXISTS `ad`;
CREATE TABLE IF NOT EXISTS `ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `animal_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_77E0ED588E962C16` (`animal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ad`
--

INSERT INTO `ad` (`id`, `title`, `content`, `image`, `created_at`, `animal_id`) VALUES
(6, 'Petit toutou cherche maitre', 'Petit toutou agé seulement d\'1mois cherche un maître qui aura plein d\'amour à lui donner', '07f85fa0003e8d51fdf07e3104518c13.jpeg', '2018-12-11 08:15:14', 8),
(7, 'Ce gentil et doux chat vous attend', 'Chattons attend un gentil maître pour l\'accompagner dans ses journées d\'aventures folles et insolites !', 'e9be5abac08afc83ec18c8a44e71f5d0.jpeg', '2018-12-11 08:21:42', 9),
(8, 'Cookie, le petit chat adorable', 'Cet adorable chatons, âgé de 2 mois, est à la recherche d\'une famille qui veillera sur lui.', '68a67f71644e2d540e18babeef7a1d3d.jpeg', '2018-12-11 08:29:12', 11),
(9, 'Un hamster en manque d\'affection !', 'Ce jeune venu au monde à besoin d\'un abri où passer ses journées !', 'c14af0c602117171c379ec151769c8a0.jpeg', '2018-12-11 10:53:04', 12),
(14, 'Chien cherche un ami avec qui s\'amuser', 'Chien cherche un ami avec qui s\'amuser', 'a1cf2f3674e5a0e97759c921b60091c1.jpeg', '2019-01-09 15:31:39', 14);

-- --------------------------------------------------------

--
-- Structure de la table `animal`
--

DROP TABLE IF EXISTS `animal`;
CREATE TABLE IF NOT EXISTS `animal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6AAB231F98260155` (`region_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `animal`
--

INSERT INTO `animal` (`id`, `type`, `sexe`, `region_id`, `name`) VALUES
(8, 'chien', 'f', 1, 'Enzo'),
(9, 'chat', 'm', 3, 'Boubou'),
(11, 'chat', 'f', 5, 'Cookie'),
(12, 'autre', 'm', 9, 'Poopie'),
(13, 'chien', 'm', 10, 'Kiki'),
(14, 'chien', 'm', 12, 'Killian');

-- --------------------------------------------------------

--
-- Structure de la table `booking`
--

DROP TABLE IF EXISTS `booking`;
CREATE TABLE IF NOT EXISTS `booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `ad_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_E00CEDDE4F34D596` (`ad_id`),
  KEY `IDX_E00CEDDEA76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `booking`
--

INSERT INTO `booking` (`id`, `user_id`, `ad_id`, `created_at`) VALUES
(8, 1, 6, '2019-01-08 20:24:49'),
(9, 1, 7, '2019-01-10 12:12:46');

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20181119092340'),
('20181120115002'),
('20181120120026'),
('20181122125530'),
('20181127101648'),
('20181127103826'),
('20181127115550'),
('20181127121257'),
('20181127122106'),
('20181127140922'),
('20181128102039'),
('20181211124652'),
('20181211133701'),
('20181211143228'),
('20181211154729'),
('20181211163503'),
('20181211164813'),
('20181211165306');

-- --------------------------------------------------------

--
-- Structure de la table `region`
--

DROP TABLE IF EXISTS `region`;
CREATE TABLE IF NOT EXISTS `region` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `region`
--

INSERT INTO `region` (`id`, `name`) VALUES
(1, 'Auvergne-Rhône-Alpes'),
(2, 'Bourgogne-Franche-Comté'),
(3, 'Bretagne'),
(4, 'Centre-Val de Loire'),
(5, 'Corse'),
(6, 'Grand Est : Alsace'),
(7, 'Hauts-de-France'),
(8, 'Île-de-France'),
(9, 'Normandie'),
(10, 'Nouvelle-Aquitain'),
(11, 'Occitanie : Languedoc-Roussillon-Midi-Pyrénée'),
(12, 'Pays de la loire'),
(13, 'Provence-Alpes-Côte d’Azur');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `password_requested_at` datetime DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `username`, `password`, `roles`, `password_requested_at`, `token`) VALUES
(1, 'YuKunOCR@gmail.com', 'Yu', '$2y$13$b5RIJCSRVqVjLE3yrM0YA.0xL/qPkQVEv0cCl0GD2khFPCUhxv.8K', 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', '2019-01-09 09:45:22', 'su6WSd2uPpN_bBWsoNLY1AfWB6ezNsQhYS48NT9Vlkw'),
(2, 'ayumu79@hotmail.com', 'Koko', '$2y$13$vRmb/XnI0XsF9hQQc8iy5u5QWBj7gCRctWUJpTYcXUaPqDv4zlUf6', 'a:1:{i:0;s:9:\"ROLE_USER\";}', NULL, NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ad`
--
ALTER TABLE `ad`
  ADD CONSTRAINT `FK_77E0ED588E962C16` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`);

--
-- Contraintes pour la table `animal`
--
ALTER TABLE `animal`
  ADD CONSTRAINT `FK_6AAB231F98260155` FOREIGN KEY (`region_id`) REFERENCES `region` (`id`);

--
-- Contraintes pour la table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `FK_E00CEDDE4F34D596` FOREIGN KEY (`ad_id`) REFERENCES `ad` (`id`),
  ADD CONSTRAINT `FK_E00CEDDEA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
