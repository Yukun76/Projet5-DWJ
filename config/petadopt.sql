-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 21 fév. 2019 à 14:57
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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ad`
--

INSERT INTO `ad` (`id`, `title`, `content`, `image`, `created_at`, `animal_id`) VALUES
(16, 'Enzo, agé de 6 ans', 'Histoire:\r\nIl passait sa vie dans une cage dans un abri de jardin avec très peu de contact...Depuis sa prise en charge, il essaie de rattraper le temps perdu. Ne vous fiez pas à son physique que certains qualifieraient de \"commun\", il a un cœur hors norme et ça change tout.\r\n\r\nCaractère:\r\nTrès affectueux et dynamique, ENZO est en recherche de contact permanent. Il devra être dans une famille très disponible pour lui.\r\nIl pèse 12kg500.\r\n\r\nCommentaire:\r\nVisite et placement en famille d’accueil du lundi au dimanche de 14h à 17h y compris les jours fériés. Se munir d\'un justificatif de domicile de moins de 3 mois et d\'une pièce d\'identité.\r\nParticipation aux frais vétérinaires 150€.', '29a723cd2bebc0981ee0282828a936a1.jpeg', '2019-02-05 14:06:37', 8),
(17, 'Killian, agé de 2 ans', 'Histoire :\r\nSaisi parce que son propriétaire n\'était pas en règle administrativement, KILLIAN nous a été confié.\r\n\r\nCaractère :\r\n*** OPÉRATION DOYENS ***\r\nUn chien sympa, bien dans ses pattes, qui a besoin de sorties régulières, surtout s\'il est adopté en appartement. Cependant, KILLIAN ne s\'entend pas avec ses congénères, et n\'aime pas les chats. Avec des enfants respectueux et non turbulents, KILLIAN sera un merveilleux senior qui appréciera le calme et la tranquillité d\'un foyer.\r\n\r\nCommentaire :\r\nAttention, KILLIAN est soumis à la loi des chiens de 2ème catégorie qui impose plusieurs règles au propriétaire. Pour en savoir plus, merci de nous contacter au 01.02.03.04.05', '4cb0849c89519f8befc28d97f1758613.jpeg', '2019-02-05 14:08:57', 14),
(18, 'Boubou, agé de 1 an', 'Histoire :\r\nCAUSE DU RETRAIT OU DE LA PRISE EN CHARGE :\r\nSurpopulation, mauvaises conditions de vie, défaut de soins et très grosse malnutrition. Il vivait dans un appartement avec 28 autres chats et 8 lapins. Ils étaient affamés et remplis de puces et de vers.\r\n\r\nCARACTÈRE :\r\nBoubou est un chat encore craintif de part son passé, il aime le calme et la douceur de l’humain. Une fois en confiance et rassuré, il s’allonge et se roule pour réclamer d’autres\r\ncaresses. C’est aussi un bon ronronthérapeute, à qui il faudra juste de la douceur et de la patience. Boubou se révèle être un chat doux, calme et discret qui aime jouer avec son\r\ncopain chat. Il adore se mettre sur le rebord de la fenêtre et regarder ce qu’il se passe dehors. Il est très propre et ne fait pas de bêtises. Si vous êtes patient, calme et que\r\nvous recherchez un compagnon qui vous ressemble, Boubou saura vous séduire pour la vie.\r\n\r\nVenez le rencontrer dans sa famille d’accueil !', '475909fae128952581b0ccf696b225b6.jpeg', '2019-02-05 14:12:04', 9),
(19, 'Cookie, agé de 1 an', 'Histoire :\r\nCOOKIE a été recueillie récemment.\r\n\r\nCaractère :\r\nTrès gentille chatte. Très calme, reposante, douce, joueuse.\r\n\r\nCommentaire :\r\nPlacement sous contrat avec participation aux frais vétérinaires. Foyer sans jeunes enfants. Placement en appartement fenêtres sécurisées. Pour adopter COOKIE appelez Christine au 06 05 04 03 02 ou Pierre au 06 07 08 09 10', '506968c98965e09901df3e40b5a0659c.jpeg', '2019-02-05 14:14:37', 11),
(20, 'Kiki, agé de 7 mois', 'Histoire :\r\nMes maitres n\'ont plus le temps de s\'occuper de moi.\r\n\r\nCaractère :\r\nJe suis un très gentil chien, joueur et câlin.\r\n\r\nCommentaire :\r\nOK chiens et chats et enfants', 'd0ffae8abbc3f6b43fecd3c892f009ab.jpeg', '2019-02-05 14:17:40', 13),
(21, 'Poopie, le petit cochon d\'inde !', 'Histoire :\r\nPoopie est un magnifique cochon d\'inde avec de longs poils, il a environ un an, il est très bavard et très gourmand bien sur comme tout bon cochon d\'inde qui se respecte ! Il n\'a pas été habitué à être manipulé, il n\'aime donc pas trop être porté mais il apprécie les caresses. Avec un peu de patience et de douceur, il devrait vite prendre confiance en l\'humain.\r\n\r\nCaractère:\r\nIl cohabite actuellement avec Alcide mais ça ne se passe pas très bien, il serait donc préférable qu\'il soit adopté tout seul ou idéalement il faudrait qu\'il soit castré pour cohabiter avec une femelle !\r\n\r\nCommentaire :\r\nUne adoption double est souhaitée pour Alcide et Poopie (qui sont père et fils).\r\nen famille d\'accueil à Vauréal (95), frais d\'adoption 25€ par cochon d\'inde.', '363d4051ef5928b6a68c45f2a6e6a194.jpeg', '2019-02-05 14:22:04', 12),
(22, 'Alicide, cochon d\'inde péruvien', 'Histoire :\r\nAlcide est un très beau cochon d\'inde, d\'un peu plus d\'un an, très très bavard et très gourmand bien sur. Il n\'a pas été habitué à être manipulé, il n\'aime donc pas trop être porté mais il apprécie les caresses. Avec amour et patience, il devrait vite prendre confiance en l\'humain.\r\n\r\nCaractère :\r\nIl cohabite actuellement avec Poopie mais ça ne se passe pas très bien, il serait donc préférable qu\'il soit adopté tout seul ou idéalement il faudrait qu\'il soit castré pour cohabiter avec une femelle !\r\n\r\nCommentaire :\r\nen famille d\'accueil a Vaureal (95)\r\nfrais d\'adoption 25€ par cochon d\'inde', '15e67d9b087fe406f4b18f0a7f51bb31.jpeg', '2019-02-05 14:24:29', 15);

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `animal`
--

INSERT INTO `animal` (`id`, `type`, `sexe`, `region_id`, `name`) VALUES
(8, 'chien', 'f', 1, 'Enzo'),
(9, 'chat', 'm', 3, 'Boubou'),
(11, 'chat', 'f', 5, 'Cookie'),
(12, 'autre', 'm', 9, 'Poopie'),
(13, 'chien', 'm', 10, 'Kiki'),
(14, 'chien', 'm', 12, 'Killian'),
(15, 'autre', 'm', 9, 'ALCIDE');

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
(1, 'YuKunOCR@gmail.com', 'Yu', '$2y$13$diFjNALRE66Smd93C3Vz.uj3pluUpCdxQPWJqzD.IQYEDfpkDQwfK', 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', '2019-02-21 11:41:09', 'krBoQQWO6zbxpCKzQphMKWRw3Tu66FnvwoBVLHXL0hw'),
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
