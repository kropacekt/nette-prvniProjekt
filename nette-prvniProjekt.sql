-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Čtv 22. čen 2017, 10:23
-- Verze serveru: 10.1.21-MariaDB
-- Verze PHP: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `nette-prvniprojekt`
--
CREATE DATABASE IF NOT EXISTS `nette-prvniprojekt` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `nette-prvniprojekt`;

-- --------------------------------------------------------

--
-- Struktura tabulky `projekt`
--

DROP TABLE IF EXISTS `projekt`;
CREATE TABLE IF NOT EXISTS `projekt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `datum_odevzdani` date NOT NULL,
  `typ` set('časově omezený','continuous integration') COLLATE utf8_czech_ci NOT NULL,
  `webovy_projekt` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nazev` (`nazev`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `projekt`
--

INSERT INTO `projekt` (`id`, `nazev`, `datum_odevzdani`, `typ`, `webovy_projekt`) VALUES
(1, 'Kropiho projekt', '2017-06-17', 'continuous integration', 1),
(13, 'Contin Web', '2017-05-31', 'continuous integration', 0),
(14, 'Omezenec newebový', '2017-06-11', 'časově omezený', 1),
(16, 'Šestnáctý', '2018-02-11', 'časově omezený', 0),
(30, 'Battle of the Bastards', '2017-06-02', 'časově omezený', 1),
(34, 'Projekt Kropáčka a Payna', '2017-06-30', 'časově omezený', 1),
(41, 'Abel Payne Glass Lindemann web contInt project', '2017-06-10', 'continuous integration', 1),
(42, 'Westeros project', '2017-07-17', 'continuous integration', 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `projekt_uzivatel`
--

DROP TABLE IF EXISTS `projekt_uzivatel`;
CREATE TABLE IF NOT EXISTS `projekt_uzivatel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_p` int(11) DEFAULT NULL,
  `fk_u` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fk_p` (`fk_p`,`fk_u`),
  KEY `fk_u` (`fk_u`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;

--
-- Vypisuji data pro tabulku `projekt_uzivatel`
--

INSERT INTO `projekt_uzivatel` (`id`, `fk_p`, `fk_u`) VALUES
(23, 1, 1),
(49, 13, 1),
(62, 13, 2),
(48, 13, 20),
(42, 30, 11),
(14, 34, 1),
(2, 34, 14),
(24, 41, 7),
(25, 41, 14),
(33, 41, 16),
(27, 41, 18),
(35, 42, 11),
(36, 42, 12),
(37, 42, 13),
(38, 42, 14);

-- --------------------------------------------------------

--
-- Struktura tabulky `uzivatel`
--

DROP TABLE IF EXISTS `uzivatel`;
CREATE TABLE IF NOT EXISTS `uzivatel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jmeno` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `prijmeni` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unikatni_uzivatel` (`jmeno`,`prijmeni`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `uzivatel`
--

INSERT INTO `uzivatel` (`id`, `jmeno`, `prijmeni`) VALUES
(19, 'Axl', 'Rose'),
(13, 'Beric', 'Dondarrion'),
(4, 'Emil', 'Segeč'),
(16, 'Hugh', 'Glass'),
(7, 'Jan', 'Abel'),
(17, 'Jay', 'Gatsby'),
(11, 'Jon', 'Snow'),
(2, 'Martin', 'Hora'),
(15, 'Michael', 'Corleone'),
(8, 'Michal', 'Bernášek'),
(10, 'Michal', 'Průša'),
(5, 'Nikola', 'Rusakov'),
(3, 'Patrik', 'Šafránek'),
(6, 'Petr', 'Panský'),
(9, 'Petr', 'Šístek'),
(14, 'Podrick', 'Payne'),
(20, 'Saul', 'Hudson'),
(18, 'Till', 'Lindemann'),
(1, 'Tomáš', 'Kropáček'),
(12, 'Tyrion', 'Lannister');

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `projekt_uzivatel`
--
ALTER TABLE `projekt_uzivatel`
  ADD CONSTRAINT `projekt_uzivatel_ibfk_1` FOREIGN KEY (`fk_p`) REFERENCES `projekt` (`id`),
  ADD CONSTRAINT `projekt_uzivatel_ibfk_2` FOREIGN KEY (`fk_u`) REFERENCES `uzivatel` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
