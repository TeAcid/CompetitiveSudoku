-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 18. apr 2016 ob 16.11
-- Različica strežnika: 5.7.9
-- Različica PHP: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `projekt`
--

-- --------------------------------------------------------

--
-- Struktura tabele `oseba`
--

DROP TABLE IF EXISTS `oseba`;
CREATE TABLE IF NOT EXISTS `oseba` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ime` varchar(30) NOT NULL,
  `priimek` varchar(30) NOT NULL,
  `upime` varchar(20) NOT NULL,
  `enaslov` varchar(100) NOT NULL,
  `geslo` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Odloži podatke za tabelo `oseba`
--

INSERT INTO `oseba` (`ID`, `ime`, `priimek`, `upime`, `enaslov`, `geslo`) VALUES
(3, 'Admin', 'Admin', 'admin', 'admin@gmail.com', '$2y$10$02Wqw2eCfY9IbPfR6t/VNeJ7zHJUct6MdLVM6by8tx6L1QXOrYY1K');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
