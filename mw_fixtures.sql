-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mar 04 Juillet 2017 à 12:04
-- Version du serveur :  5.5.55-0+deb8u1-log
-- Version de PHP :  5.6.30-0+deb8u1

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `magicw`
--

-- --------------------------------------------------------

--
-- Structure de la table `access_type`
--

CREATE TABLE IF NOT EXISTS `access_type` (
`id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `access_type`
--

INSERT INTO `access_type` (`id`, `name`) VALUES
(1, 'public'),
(2, 'link');

-- --------------------------------------------------------

--
-- Structure de la table `combo_points`
--

CREATE TABLE IF NOT EXISTS `combo_points` (
`id` int(11) NOT NULL,
  `length` int(11) NOT NULL,
  `points` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `combo_points`
--

INSERT INTO `combo_points` (`id`, `length`, `points`) VALUES
(1, 2, 4),
(2, 3, 6),
(3, 4, 10),
(4, 5, 15),
(5, 6, 20),
(6, 7, 25),
(7, 8, 25),
(8, 9, 25),
(9, 10, 25);

-- --------------------------------------------------------

--
-- Structure de la table `general_parameters`
--

CREATE TABLE IF NOT EXISTS `general_parameters` (
`id` int(11) NOT NULL,
  `tutorial_id` int(11) DEFAULT NULL,
  `selfregistration` tinyint(1) NOT NULL,
  `home_text` longtext COLLATE utf8_unicode_ci,
  `piwik_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `general_parameters`
--

INSERT INTO `general_parameters` (`id`, `tutorial_id`, `selfregistration`, `home_text`, `piwik_url`) VALUES
(1, 7, 1, 'Magic Word was created as part of the GAMER work package in the Innovalangues project at the Stendhal University in Grenoble, France. Innovalangues is a language learning centered IDEFI project (Initiatives in Excellence for Innovative Education) and will run from 2012 to 2018..... test', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `language_ui`
--

CREATE TABLE IF NOT EXISTS `language_ui` (
`id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `language_ui`
--

INSERT INTO `language_ui` (`id`, `name`, `value`) VALUES
(1, 'french', 'fr'),
(2, 'english', 'en');

-- --------------------------------------------------------

--
-- Structure de la table `letter_canonic_letter`
--

CREATE TABLE IF NOT EXISTS `letter_canonic_letter` (
`id` int(11) NOT NULL,
  `value` varchar(1) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `letter_canonic_letter`
--

INSERT INTO `letter_canonic_letter` (`id`, `value`) VALUES
(1, 'a'),
(2, 'b'),
(3, 'c'),
(4, 'd'),
(5, 'e'),
(6, 'f'),
(7, 'g'),
(8, 'h'),
(9, 'i'),
(10, 'j'),
(11, 'k'),
(12, 'l'),
(13, 'm'),
(14, 'n'),
(15, 'o'),
(16, 'p'),
(17, 'q'),
(18, 'r'),
(19, 's'),
(20, 't'),
(21, 'u'),
(22, 'v'),
(23, 'w'),
(24, 'x'),
(25, 'y'),
(26, 'z');

-- --------------------------------------------------------

--
-- Structure de la table `letter_language`
--

CREATE TABLE IF NOT EXISTS `letter_language` (
`id` int(11) NOT NULL,
  `letter_id` int(11) DEFAULT NULL,
  `point` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `language_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `letter_language`
--

INSERT INTO `letter_language` (`id`, `letter_id`, `point`, `weight`, `language_id`) VALUES
(1, 1, 1, 9, 1),
(2, 2, 3, 2, 1),
(14, 3, 3, 2, 1),
(15, 4, 2, 3, 1),
(16, 5, 1, 15, 1),
(17, 6, 4, 2, 1),
(18, 7, 2, 2, 1),
(19, 8, 4, 2, 1),
(20, 9, 1, 8, 1),
(21, 10, 8, 1, 1),
(22, 11, 10, 1, 1),
(23, 12, 1, 5, 1),
(24, 13, 2, 3, 1),
(25, 14, 1, 6, 1),
(26, 15, 1, 6, 1),
(27, 16, 3, 2, 1),
(28, 17, 8, 1, 1),
(29, 18, 1, 6, 1),
(30, 19, 1, 6, 1),
(31, 20, 1, 6, 1),
(32, 21, 1, 6, 1),
(33, 22, 4, 2, 1),
(34, 23, 10, 1, 1),
(35, 24, 10, 1, 1),
(36, 25, 10, 1, 1),
(37, 26, 10, 1, 1),
(38, 1, 1, 9, 2),
(39, 2, 3, 2, 2),
(40, 3, 3, 2, 2),
(41, 4, 2, 4, 2),
(42, 5, 1, 12, 2),
(43, 6, 4, 2, 2),
(44, 7, 2, 3, 2),
(45, 8, 4, 2, 2),
(46, 9, 1, 9, 2),
(47, 10, 8, 1, 2),
(48, 11, 5, 1, 2),
(49, 12, 1, 4, 2),
(50, 13, 3, 2, 2),
(51, 14, 1, 6, 2),
(52, 15, 1, 8, 2),
(53, 16, 3, 2, 2),
(54, 17, 10, 1, 2),
(55, 18, 1, 6, 2),
(56, 19, 1, 4, 2),
(57, 20, 1, 6, 2),
(58, 21, 1, 4, 2),
(59, 22, 4, 2, 2),
(60, 23, 4, 2, 2),
(61, 24, 8, 1, 2),
(62, 25, 4, 2, 2),
(63, 26, 1, 10, 2);

-- --------------------------------------------------------

--
-- Structure de la table `roundType`
--

CREATE TABLE IF NOT EXISTS `roundType` (
`id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `class` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `roundType`
--

INSERT INTO `roundType` (`id`, `name`, `class`) VALUES
(2, 'rush', 'RoundType\\Rush'),
(3, 'conquer', 'RoundType\\Conquer');

-- --------------------------------------------------------

--
-- Structure de la table `wordbox_acquisition_type`
--

CREATE TABLE IF NOT EXISTS `wordbox_acquisition_type` (
`id` int(11) NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `wordbox_acquisition_type`
--

INSERT INTO `wordbox_acquisition_type` (`id`, `value`) VALUES
(1, 'manual');

-- --------------------------------------------------------

--
-- Structure de la table `word_length_points`
--

CREATE TABLE IF NOT EXISTS `word_length_points` (
`id` int(11) NOT NULL,
  `length` int(11) NOT NULL,
  `points` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `word_length_points`
--

INSERT INTO `word_length_points` (`id`, `length`, `points`) VALUES
(1, 2, 0),
(2, 3, 1),
(3, 4, 1),
(4, 5, 2),
(5, 6, 3),
(6, 7, 5),
(7, 8, 11),
(8, 9, 12),
(9, 10, 13),
(10, 11, 14),
(11, 12, 15),
(12, 13, 20),
(13, 14, 20),
(14, 15, 40),
(15, 16, 50);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `access_type`
--
ALTER TABLE `access_type`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `combo_points`
--
ALTER TABLE `combo_points`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `general_parameters`
--
ALTER TABLE `general_parameters`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_75AC6A6F89366B7B` (`tutorial_id`);

--
-- Index pour la table `language_ui`
--
ALTER TABLE `language_ui`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `letter_canonic_letter`
--
ALTER TABLE `letter_canonic_letter`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_ED1363F21D775834` (`value`);

--
-- Index pour la table `letter_language`
--
ALTER TABLE `letter_language`
 ADD PRIMARY KEY (`id`), ADD KEY `IDX_4A4AED994525FF26` (`letter_id`), ADD KEY `IDX_4A4AED9982F1BAF4` (`language_id`);

--
-- Index pour la table `roundType`
--
ALTER TABLE `roundType`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `wordbox_acquisition_type`
--
ALTER TABLE `wordbox_acquisition_type`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `word_length_points`
--
ALTER TABLE `word_length_points`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `access_type`
--
ALTER TABLE `access_type`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `combo_points`
--
ALTER TABLE `combo_points`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `general_parameters`
--
ALTER TABLE `general_parameters`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `language_ui`
--
ALTER TABLE `language_ui`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `letter_canonic_letter`
--
ALTER TABLE `letter_canonic_letter`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT pour la table `letter_language`
--
ALTER TABLE `letter_language`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT pour la table `roundType`
--
ALTER TABLE `roundType`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `wordbox_acquisition_type`
--
ALTER TABLE `wordbox_acquisition_type`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `word_length_points`
--
ALTER TABLE `word_length_points`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `general_parameters`
--
ALTER TABLE `general_parameters`
ADD CONSTRAINT `FK_75AC6A6F89366B7B` FOREIGN KEY (`tutorial_id`) REFERENCES `game` (`id`);

--
-- Contraintes pour la table `letter_language`
--
ALTER TABLE `letter_language`
ADD CONSTRAINT `FK_4A4AED994525FF26` FOREIGN KEY (`letter_id`) REFERENCES `letter_canonic_letter` (`id`);
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
