-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 15 mars 2023 à 13:02
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
-- Structure de la table `classenseignant`
--

DROP TABLE IF EXISTS `classenseignant`;
CREATE TABLE IF NOT EXISTS `classenseignant` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `IdProf` int(11) NOT NULL,
  `IdClasse` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(40) COLLATE utf16_bin NOT NULL,
  `Prenom` varchar(32) COLLATE utf16_bin NOT NULL,
  `Email` varchar(128) COLLATE utf16_bin NOT NULL,
  `Telelphone` varchar(16) COLLATE utf16_bin NOT NULL,
  `Description` varchar(1024) COLLATE utf16_bin NOT NULL,
  `Specialite` varchar(32) COLLATE utf16_bin NOT NULL,
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
-- Structure de la table `enseignant`
--

DROP TABLE IF EXISTS `enseignant`;
CREATE TABLE IF NOT EXISTS `enseignant` (
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
-- Structure de la table `fiche`
--

DROP TABLE IF EXISTS `fiche`;
CREATE TABLE IF NOT EXISTS `fiche` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(32) COLLATE utf16_bin NOT NULL,
  `Sujet` varchar(32) COLLATE utf16_bin NOT NULL,
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
  `Date` text COLLATE utf16_bin NOT NULL,
  `ScoreTDA` float NOT NULL,
  `ScoreDyslexie` float NOT NULL,
  `ScoreDysortho` float NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf16 COLLATE=utf16_bin;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
