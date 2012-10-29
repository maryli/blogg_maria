-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 25 okt 2012 kl 09:16
-- Serverversion: 5.5.24-log
-- PHP-version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `blogg`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `bloggcat`
--

CREATE TABLE IF NOT EXISTS `bloggcat` (
  `catID` int(11) NOT NULL AUTO_INCREMENT,
  `catName` varchar(50) NOT NULL,
  `catDesc` varchar(100) NOT NULL,
  PRIMARY KEY (`catID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumpning av Data i tabell `bloggcat`
--

INSERT INTO `bloggcat` (`catID`, `catName`, `catDesc`) VALUES
(1, 'Kategori 1', 'Beskrivning av kategori 1'),
(2, 'Kategori 2', 'Beskrivning av kategori 2'),
(3, 'Bildgalleri', 'Välkommen till bildgalleriet');

-- --------------------------------------------------------

--
-- Tabellstruktur `bloggposts`
--

CREATE TABLE IF NOT EXISTS `bloggposts` (
  `bloggID` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `posterName` varchar(50) NOT NULL,
  `posted` datetime NOT NULL,
  `catID` int(11) NOT NULL,
  PRIMARY KEY (`bloggID`),
  KEY `catID` (`catID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=115 ;

--
-- Dumpning av Data i tabell `bloggposts`
--

INSERT INTO `bloggposts` (`bloggID`, `content`, `posterName`, `posted`, `catID`) VALUES
(105, '<p><img style="vertical-align: middle;" src="images/header.png" alt="" width="350" height="100" /></p>', 'Maria', '2012-10-03 20:37:22', 1),
(110, '<h2>Rubrik</h2>\r\n<p><img src="images/street.jpg" alt="" width="500" height="745" /></p>\r\n<p>Bildbeskrivning.</p>', 'Maria', '2012-10-04 16:05:39', 1),
(111, '<h2>Rubrik</h2>\r\n<p><img src="images/rain.jpg" alt="" width="612" height="612" /></p>\r\n<p>Bildbeskrivning.</p>', 'Maria', '2012-10-04 16:06:34', 1),
(112, '<h2>Rubrik</h2>\r\n<p><img src="images/bw.jpg" alt="" width="500" height="750" /></p>\r\n<p>Bildbeskrivning.</p>', 'Maria', '2012-10-04 16:07:14', 2),
(113, '<h2>Rubrik</h2>\r\n<p><img src="images/turkos.jpg" alt="" width="427" height="640" /></p>\r\n<p>Bildbeskrivning.</p>', 'Maria', '2012-10-04 16:14:52', 2),
(114, '<h2>Rubrik.</h2>\r\n<p><img src="images/rosa.jpg" alt="" width="500" height="676" /></p>\r\n<p>Bildbeskrivning.</p>', 'Maria', '2012-10-04 19:09:32', 2);

-- --------------------------------------------------------

--
-- Tabellstruktur `gallery`
--

CREATE TABLE IF NOT EXISTS `gallery` (
  `imageID` int(11) NOT NULL AUTO_INCREMENT,
  `thumbName` varchar(100) NOT NULL,
  `imageName` varchar(100) NOT NULL,
  PRIMARY KEY (`imageID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumpning av Data i tabell `gallery`
--

INSERT INTO `gallery` (`imageID`, `thumbName`, `imageName`) VALUES
(12, 'thumb_rosa.jpg', 'rosa.jpg'),
(22, 'thumb_flicka.jpg', 'flicka.jpg'),
(23, 'thumb_rain.jpg', 'rain.jpg'),
(24, 'thumb_turkos.jpg', 'turkos.jpg'),
(29, 'thumb_back.jpg', 'back.jpg');

-- --------------------------------------------------------

--
-- Tabellstruktur `usertable`
--

CREATE TABLE IF NOT EXISTS `usertable` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `password` char(128) NOT NULL,
  `userName` varchar(100) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumpning av Data i tabell `usertable`
--

INSERT INTO `usertable` (`userID`, `password`, `userName`) VALUES
(7, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'Maria'),
(8, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'Maria'),
(9, 'b3e1886e6a0073cfe52722c15ad6639e8143690c2769a2eed2cfb01044debfe6', 'pelle'),
(11, 'cc0a46737f64e799b96bc575660bab3ee1a5696ce62d72ae4934be60eb3b0c54', 'kajsa'),
(35, 'd42390a309a937ce29aef0eb37e612b8ef893d5d6c3c7ab459db585002d60d47', 'Asta'),
(36, 'd42390a309a937ce29aef0eb37e612b8ef893d5d6c3c7ab459db585002d60d47', 'Asta'),
(37, 'd42390a309a937ce29aef0eb37e612b8ef893d5d6c3c7ab459db585002d60d47', 'Asta');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
