-- Adminer 4.7.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `concerts`;
CREATE TABLE `concerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `description` blob NOT NULL,
  `date` datetime DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `place` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `price` int(11) NOT NULL DEFAULT '0',
  `hidden` tinyint(4) NOT NULL DEFAULT '0',
  `photo_id` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `album_id` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `instrument` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `group` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `description` blob,
  `gender` varchar(10) COLLATE utf8_czech_ci NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `photo_coords` text COLLATE utf8_czech_ci NOT NULL,
  `extra` text COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `songs`;
CREATE TABLE `songs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `author` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `hidden` tinyint(4) NOT NULL DEFAULT '0',
  `tags` text COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `videos`;
CREATE TABLE `videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `date` date NOT NULL,
  `hidden` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


-- 2019-03-23 23:42:40
