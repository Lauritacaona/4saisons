-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Lun 31 Juillet 2017 à 17:47
-- Version du serveur :  5.6.28
-- Version de PHP :  7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `datacreator`
--

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `droit` int(11) NOT NULL COMMENT '1 : admin - 2 : normal - 3 : restraint',
  `derniereConnexion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tempsPasse` int(11) NOT NULL DEFAULT '0',
  `paginator` tinyint(1) NOT NULL,
  `datacreator` tinyint(1) NOT NULL,
  `backgrounator` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table de test pour le data creator';

--
-- Contenu de la table `membre`
--

INSERT INTO `membre` (`id`, `nom`, `mdp`, `droit`, `derniereConnexion`, `tempsPasse`, `paginator`, `datacreator`, `backgrounator`) VALUES
(2, 'Laurie', '$2y$10$u6tSQBy7csb6yEkN/EtaKeJg9xwt6hm0VQ.GyV9QFwClFRgd3X/Wa', 1, '2017-07-31 10:58:10', 0, 1, 1, 1),
(3, 'admin', '$2y$10$E7tSxl8O9zNcOD8bzqnzrejnhPn6salYSIrB8jpOXP6WBOeSoqdGu', 1, '2017-07-31 12:47:26', 0, 1, 1, 1),
(4, 'Proffou', '$2y$10$46GBsBJ7u3s0mcRdMkLFZeI8kQr6Ew17ANmvnJw8KMWx9QXgoFygO', 2, '2017-07-31 07:48:35', 0, 1, 1, 0),
(5, 'Loulou', '$2y$10$l2T7U5HF9Phsah0RVeZF..ZHB2tdX9Miv0dyUfcpPDMuPT/Wd2XPi', 2, '2017-07-31 07:48:35', 0, 0, 1, 0),
(6, 'MaitreCorbeau', '$2y$10$rX8LRDoO1zbMcv9XV6xVOO2Cgkok3LTmUK97kdy4349WCTYL93n3u', 3, '2017-07-31 10:48:52', 0, 0, 0, 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE_nom` (`nom`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
