-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mag 31, 2022 alle 08:56
-- Versione del server: 8.0.26
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `my_trippinduke`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `artists`
--

CREATE TABLE IF NOT EXISTS `artists` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dump dei dati per la tabella `artists`
--

INSERT INTO `artists` (`id`, `name`) VALUES
(1, 'A Day To Remember'),
(2, 'Asking Alexandria'),
(3, 'Bring Me The Horizon'),
(4, 'Memphis May Fire'),
(5, 'Upon This Dawning'),
(6, 'While She Sleeps'),
(7, 'Falling In Reverse'),
(8, 'Camilla Cabello'),
(9, 'Harry Styles'),
(10, 'YUNGBLUD'),
(11, 'Lil Tjay'),
(12, 'Travis Scott'),
(13, 'iann dior'),
(14, 'Billie Eilish'),
(18, 'Queen'),
(19, 'Michael Jackson'),
(20, 'Kendrick Lamar'),
(21, 'The Beatles');

-- --------------------------------------------------------

--
-- Struttura della tabella `carts`
--

CREATE TABLE IF NOT EXISTS `carts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dump dei dati per la tabella `carts`
--

INSERT INTO `carts` (`id`, `created_at`) VALUES
(1, '2022-04-13 11:20:05'),
(2, '2022-04-14 08:23:28'),
(3, '2022-04-14 15:47:20'),
(4, '2022-04-14 15:49:25'),
(5, '2022-04-14 15:56:05'),
(6, '2022-04-14 15:58:59'),
(7, '2022-04-14 16:08:46'),
(8, '2022-04-14 16:10:38'),
(9, '2022-04-14 16:15:03'),
(10, '2022-04-15 06:16:01'),
(11, '2022-04-15 06:22:02'),
(12, '2022-04-15 06:33:43'),
(13, '2022-04-15 06:34:31'),
(14, '2022-04-15 06:43:36'),
(15, '2022-04-15 06:51:31'),
(16, '2022-04-15 06:59:56'),
(17, '2022-04-15 07:02:25'),
(18, '2022-04-19 08:53:29'),
(19, '2022-04-20 10:09:24'),
(20, '2022-04-26 07:03:56'),
(21, '2022-04-26 07:58:13'),
(22, '2022-04-26 08:01:13'),
(23, '2022-05-03 06:31:39'),
(24, '2022-05-03 06:35:58'),
(25, '2022-05-03 06:36:09'),
(26, '2022-05-03 07:34:24'),
(27, '2022-05-03 07:52:18'),
(28, '2022-05-05 21:00:55'),
(29, '2022-05-08 12:41:22'),
(30, '2022-05-16 16:15:11'),
(31, '2022-05-16 16:20:11'),
(32, '2022-05-16 16:20:24'),
(33, '2022-05-16 16:20:55'),
(34, '2022-05-16 16:21:19'),
(35, '2022-05-18 10:52:54'),
(36, '2022-05-23 18:35:46'),
(37, '2022-05-23 18:35:52'),
(38, '2022-05-23 18:35:52'),
(39, '2022-05-23 18:35:53'),
(40, '2022-05-31 06:31:16'),
(41, '2022-05-31 06:47:01');

-- --------------------------------------------------------

--
-- Struttura della tabella `contains`
--

CREATE TABLE IF NOT EXISTS `contains` (
  `cart_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int DEFAULT NULL,
  PRIMARY KEY (`cart_id`,`product_id`),
  KEY `PRODUCT` (`product_id`) USING BTREE,
  KEY `CART` (`cart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `contains`
--

INSERT INTO `contains` (`cart_id`, `product_id`, `quantity`) VALUES
(1, 11, 2),
(2, 5, 1),
(2, 7, 1),
(4, 17, 1),
(7, 11, 5),
(7, 18, 1),
(8, 14, 1),
(11, 14, 1),
(13, 14, 1),
(19, 11, 6),
(19, 14, 1),
(23, 21, 1),
(25, 26, 1),
(27, 29, 4),
(35, 5, 3),
(35, 9, 1),
(35, 14, 1),
(40, 14, 1),
(40, 26, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `genres`
--

CREATE TABLE IF NOT EXISTS `genres` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(1, 'Metalcore'),
(2, 'Rock'),
(3, 'Pop'),
(4, 'Hip-Hop');

-- --------------------------------------------------------

--
-- Struttura della tabella `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `full_name` varchar(64) NOT NULL,
  `cart_id` int DEFAULT NULL,
  `address` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `CART` (`cart_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `orders`
--

INSERT INTO `orders` (`id`, `created_at`, `full_name`, `cart_id`, `address`) VALUES
(2, '2022-05-03 07:34:01', 'Mattia Lobriglio', 25, 'Milano via Rossi 12'),
(3, '2022-05-03 07:59:45', 'Paolo Ficara', 27, 'via Paolo 3 Torino'),
(5, '2022-05-31 06:48:57', 'Mattia Lobriglio', 40, 'via ROssi');

-- --------------------------------------------------------

--
-- Struttura della tabella `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `artist_id` int DEFAULT NULL,
  `genre_id` int DEFAULT NULL,
  `year` int DEFAULT NULL,
  `price` float DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ARTIST` (`artist_id`) USING BTREE,
  KEY `GENRE` (`genre_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dump dei dati per la tabella `products`
--

INSERT INTO `products` (`id`, `title`, `artist_id`, `genre_id`, `year`, `price`, `quantity`) VALUES
(5, 'Sempiternal', 3, 1, 2013, 14.99, 250),
(6, 'Challenger', 4, 1, 2012, 24.99, 150),
(7, 'Stand Up and Scream', 2, 1, 2009, 9.99, 200),
(8, 'We Are All Sinners', 5, 1, 2014, 8.99, 100),
(9, 'Coming Home', 7, 1, 2017, 9.99, 150),
(10, 'Brainwashed', 6, 1, 2015, 11.99, 200),
(11, 'amo', 3, 2, 2019, 14.99, 350),
(14, 'Harry''s House', 9, 3, 2022, 14.99, 500),
(15, 'weird!', 10, 2, 2020, 12.99, 300),
(17, 'ASTROWORLD', 12, 4, 2018, 14.99, 600),
(18, 'I''m Gone', 13, 4, 2020, 12.99, 300),
(21, 'That''s The Spirit', 3, 2, 2015, 13.99, 250),
(26, 'Happier Than Ever', 14, 3, 2021, 15.99, 500),
(27, 'The Drug in Me Is You', 7, 1, 2011, 10.99, 500),
(28, 'Homesick', 1, 1, 2009, 10.99, 400),
(29, 'Jazz', 18, 2, 1978, 17.99, 1000),
(30, 'Thriller', 19, 3, 1982, 16.99, 1000),
(31, 'Mr. Morale & The Big Steppers', 20, 4, 2022, 14.99, 700),
(32, '1', 1, 2, 2000, 16.99, 1000);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `username` varchar(32) DEFAULT NULL,
  `email` varchar(32) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `permission` int NOT NULL DEFAULT '1',
  `cart_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `CART` (`cart_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `permission`, `cart_id`) VALUES
(1, 'Test', 'User', 'testuser', 'testuser@example.com', '5d9c68c6c50ed3d02a2fcf54f63993b6', 1, 21),
(2, 'Admin', 'Admin', 'admin', 'admin@example.com', '21232f297a57a5a743894a0e4a801fc3', 2, NULL),
(3, 'Mattia', 'Lobriglio', 'trippinduke', 'lobri.shark@gmail.com', 'd602fa2d84707dabb8256032ade8febd', 1, NULL);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `contains`
--
ALTER TABLE `contains`
  ADD CONSTRAINT `contains_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `contains_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE;

--
-- Limiti per la tabella `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limiti per la tabella `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
