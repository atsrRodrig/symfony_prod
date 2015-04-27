-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mer 22 Avril 2015 à 17:37
-- Version du serveur: 5.5.41-0ubuntu0.14.04.1
-- Version de PHP: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `symfony`
--

-- --------------------------------------------------------

--
-- Structure de la table `acteur`
--

CREATE TABLE IF NOT EXISTS `acteur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prenom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nom` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `biographie` longtext COLLATE utf8_unicode_ci NOT NULL,
  `dateNaissance` date NOT NULL,
  `ville` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sexe` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Contenu de la table `acteur`
--

INSERT INTO `acteur` (`id`, `prenom`, `nom`, `biographie`, `dateNaissance`, `ville`, `image`, `sexe`) VALUES
(1, 'Paul', 'MARTIN', 'Les fabuleux voyages / 2012', '1936-01-20', 'Paris', '1.jpg', 0),
(2, 'Jacques', 'DUPONT', 'La grande foire  (1936)', '1902-02-20', 'Londres', '2.jpg', 0),
(3, 'Isabelle', 'DUBOIS', 'Promenade en forêt', '1960-08-13', 'BERLIN', '3.jpg', 1),
(4, 'Pierre', 'CHEVALIER', 'Le tour du monde (1982)\r\nLa fête au village (1988)', '1945-10-12', 'BORDEAUX', '4.jpg', 0),
(5, 'Charlie', 'CHAPLIN', 'Les temps modernes (1935)', '1901-05-04', 'NEW YORK', '5.jpg', 0);

-- --------------------------------------------------------

--
-- Structure de la table `film`
--

CREATE TABLE IF NOT EXISTS `film` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `dateDeRealisation` datetime NOT NULL,
  `note` double NOT NULL,
  `image` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `genre_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8244BE224296D31F` (`genre_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Contenu de la table `film`
--

INSERT INTO `film` (`id`, `titre`, `description`, `dateDeRealisation`, `note`, `image`, `genre_id`) VALUES
(1, 'Les temps modernes', 'Film de charlie Chaplin évoquant les progressions industrielles', '1902-10-05 00:00:00', 5, '5.jpg', 4),
(2, 'Le professionnel', 'Film ''aventures  avec de l''humour', '1970-12-10 00:00:00', 4, '4.jpg', 5),
(3, 'Blanche Neige et les sept nains', 'Film dessein animé de Disnay', '1937-10-01 10:10:10', 3, '6.jpg', 1),
(4, 'Pirates des caraibes', 'Film fantastique', '2011-10-05 10:10:10', 3.5, '7.jpg', 3),
(5, 'Le livre de la jungle', 'Dessein animé', '1967-10-05 05:05:10', 2.7, '8.jpg', 1);

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

CREATE TABLE IF NOT EXISTS `genre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Contenu de la table `genre`
--

INSERT INTO `genre` (`id`, `type`, `description`) VALUES
(1, 'dessein animé', 'Dessein animé de la vieille école '),
(2, 'Film d''horreur', 'Film non conseillé aux enfant de moins de 16 ans'),
(3, 'Films de science fiction', 'Futuriste'),
(4, 'Comedie', 'Comédie  '),
(5, 'Action', 'beaucoup d''activité pour les participants'),
(6, 'comedie musicale', 'musique');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `film`
--
ALTER TABLE `film`
  ADD CONSTRAINT `FK_8244BE224296D31F` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
