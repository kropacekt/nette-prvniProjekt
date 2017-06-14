-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Stř 14. čen 2017, 12:08
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

-- --------------------------------------------------------

--
-- Struktura tabulky `projekt`
--

CREATE TABLE IF NOT EXISTS `projekt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `datum_odevzdani` date NOT NULL,
  `typ` set('časově omezený','continuous integration') COLLATE utf8_czech_ci NOT NULL,
  `webovy_projekt` set('ne','ano') COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nazev` (`nazev`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `projekt`
--

INSERT INTO `projekt` (`id`, `nazev`, `datum_odevzdani`, `typ`, `webovy_projekt`) VALUES
(1, 'Kropiho projekt', '2017-06-16', 'časově omezený', 'ano'),
(2, 'Hello project', '2017-06-30', 'časově omezený', 'ne'),
(3, 'Zkouška formu', '2017-02-08', 'časově omezený', 'ano'),
(13, 'Contin Web', '2017-05-31', 'continuous integration', 'ano'),
(14, 'Omezenec newebový', '2017-06-11', 'časově omezený', 'ne'),
(16, 'Šestnáctý', '2018-02-11', 'časově omezený', 'ano');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
