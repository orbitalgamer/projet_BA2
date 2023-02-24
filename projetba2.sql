-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 24 fév. 2023 à 13:55
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projetba2`
--
CREATE DATABASE IF NOT EXISTS `projetba2` DEFAULT CHARACTER SET utf16 COLLATE utf16_bin;
USE `projetba2`;

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

DROP TABLE IF EXISTS `classe`;
CREATE TABLE IF NOT EXISTS `classe` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(32) COLLATE utf16_bin NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- --------------------------------------------------------

--
-- Structure de la table `classprof`
--

DROP TABLE IF EXISTS `classprof`;
CREATE TABLE IF NOT EXISTS `classprof` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `IdProf` int(11) NOT NULL,
  `IdClasse` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- --------------------------------------------------------

--
-- Structure de la table `eleve`
--

DROP TABLE IF EXISTS `eleve`;
CREATE TABLE IF NOT EXISTS `eleve` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` int(11) NOT NULL,
  `Prenom` int(11) NOT NULL,
  `Annee` int(11) NOT NULL,
  `IdClasse` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- --------------------------------------------------------

--
-- Structure de la table `professeur`
--

DROP TABLE IF EXISTS `professeur`;
CREATE TABLE IF NOT EXISTS `professeur` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) COLLATE utf16_bin NOT NULL,
  `Prenom` varchar(50) COLLATE utf16_bin NOT NULL,
  `Email` varchar(255) COLLATE utf16_bin NOT NULL,
  `Mdp` varchar(255) COLLATE utf16_bin NOT NULL,
  `Admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- --------------------------------------------------------

--
-- Structure de la table `test`
--

DROP TABLE IF EXISTS `test`;
CREATE TABLE IF NOT EXISTS `test` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `IdProf` int(11) NOT NULL,
  `IdEleve` int(11) NOT NULL,
  `ScoreTDA` float NOT NULL,
  `ScoreDyslexie` float NOT NULL,
  `ScoreDysortho` float NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf16 COLLATE=utf16_bin;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
