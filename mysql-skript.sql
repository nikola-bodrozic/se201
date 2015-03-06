-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 06, 2015 at 09:50 AM
-- Server version: 5.5.42-cll
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `nikolabo_ingatio`
--

-- --------------------------------------------------------

--
-- Table structure for table `se201_cenaPoAkciji`
--

CREATE TABLE IF NOT EXISTS `se201_cenaPoAkciji` (
  `imeFirme` varchar(20) NOT NULL,
  `cena` int(11) NOT NULL,
  PRIMARY KEY (`imeFirme`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `se201_cenaPoAkciji`
--

INSERT INTO `se201_cenaPoAkciji` (`imeFirme`, `cena`) VALUES
('facebook', 52),
('twitter', 45),
('microsoft', 14),
('ibm', 32);

-- --------------------------------------------------------

--
-- Table structure for table `se201_klijent`
--

CREATE TABLE IF NOT EXISTS `se201_klijent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ime` varchar(20) COLLATE utf8_bin NOT NULL,
  `prezime` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Dumping data for table `se201_klijent`
--

INSERT INTO `se201_klijent` (`id`, `ime`, `prezime`) VALUES
(1, 'Milan', 'Jovanović'),
(2, 'Dragan', 'Petrović'),
(3, 'Dejan', 'Marković');

-- --------------------------------------------------------

--
-- Table structure for table `se201_portfolio`
--

CREATE TABLE IF NOT EXISTS `se201_portfolio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `klijent_id` int(11) NOT NULL,
  `imeFirme` varchar(30) NOT NULL,
  `brojAkcija` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `se201_portfolio`
--

INSERT INTO `se201_portfolio` (`id`, `klijent_id`, `imeFirme`, `brojAkcija`) VALUES
(1, 2, 'facebook', 3),
(2, 2, 'twitter', 8),
(3, 3, 'microsoft', 7),
(4, 3, 'ibm', 22);
