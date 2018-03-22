-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Lun 31 Juillet 2017 à 17:45
-- Version du serveur :  5.6.28
-- Version de PHP :  7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `datacreator`
--

-- --------------------------------------------------------

--
-- Structure de la table `creations`
--

CREATE TABLE `creations` (
  `id` int(11) NOT NULL,
  `idMembre` int(11) NOT NULL COMMENT 'Fait référence à membre',
  `dateCreation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `saison` int(1) NOT NULL COMMENT '1, 2, 3 ou 4',
  `roman` varchar(255) NOT NULL,
  `nomPage` varchar(255) NOT NULL,
  `sousTitre` varchar(255) NOT NULL,
  `template` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `creations`
--

INSERT INTO `creations` (`id`, `idMembre`, `dateCreation`, `saison`, `roman`, `nomPage`, `sousTitre`, `template`) VALUES
(1, 3, '2017-07-28 10:27:24', 1, 'Holiday', 'page1', 'Introduction', 'templateIntro'),
(2, 2, '2017-07-28 10:27:24', 1, 'Holiday', 'page32', 'Leçon 4', 'template1ter'),
(3, 4, '2017-07-28 10:27:24', 1, 'Busy Businessman', 'page105', 'Récit 7 jeu 8', 'templateDragDrop'),
(4, 6, '2017-07-28 10:27:24', 1, 'Courier', 'page45', 'Leçon 5 exercice 2', 'templateDragDrop'),
(5, 5, '2017-07-28 10:27:24', 2, 'Mystère sur la saison2', 'page98', 'Jeu animé 10', 'templateSelector2'),
(6, 2, '2017-07-31 09:36:36', 2, 'My beloved computer', 'page4', 'Exercice drôle', 'templateSelector1'),
(7, 2, '2017-07-31 09:36:36', 3, 'Where is Billy?', 'page156', 'Mot de la fin', 'templateFinAnime');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `creations`
--
ALTER TABLE `creations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_idMembre` (`idMembre`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `creations`
--
ALTER TABLE `creations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `creations`
--
ALTER TABLE `creations`
  ADD CONSTRAINT `FK_idMembre` FOREIGN KEY (`idMembre`) REFERENCES `membre` (`id`);
