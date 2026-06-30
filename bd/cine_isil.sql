-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2026 at 01:52 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cine_isil`
--
CREATE DATABASE IF NOT EXISTS `cine_isil` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cine_isil`;

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `calificacion` decimal(3,1) NOT NULL,
  `premios` int(11) NOT NULL,
  `fechaCreacion` date NOT NULL,
  `duracion` int(11) NOT NULL,
  `genero` varchar(50) NOT NULL,
  `imagen_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `titulo`, `calificacion`, `premios`, `fechaCreacion`, `duracion`, `genero`, `imagen_url`) VALUES
(1, 'Shutter Island', 9.7, 2, '1990-05-09', 120, 'Suspenso', 'img/movie1.jpg'),
(3, 'Fight Club', 8.8, 3, '2015-10-31', 110, 'Drama', 'img/movie2.jpg'),
(4, 'Forrest Gump', 8.6, 1, '2012-08-18', 105, 'Drama', 'img/movie3.jpg'),
(5, 'Forgotten', 8.8, 5, '2008-02-14', 130, 'Suspenso', 'img/movie4.jpg'),
(6, 'The Dark Knight', 9.2, 2, '2019-07-22', 118, 'Acción', 'img/movie5.jpg'),
(7, 'Inception', 9.0, 4, '2021-10-29', 125, 'Sci-Fi', 'img/movie6.jpg'),
(8, 'Kill Bill', 8.6, 1, '2003-03-28', 98, 'Acción', 'img/movie7.jpg'),
(9, 'Thor: El mundo Oscuro', 8.5, 5, '2000-10-19', 102, 'Acción', 'img/movie8.jpg'),
(10, 'Kiki Nightmare', 3.0, 0, '2001-02-27', 120, 'Anime', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `perfil` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nombre`, `apellido`, `email`, `password`, `perfil`) VALUES
(1, 'Jose Gabriel', 'Rosas del Aguila', 'pochellin@gmail.com', '$2y$10$952lr9vO0j9DJccBPhiAqeFS.GTKUFd5.MEyemYVSK01bibfQUroS', 2),
(2, 'Kiara', 'Tapia', 'Kiara_tapia@gmail.com', '$2y$10$SDTv6w2lQ3PWaO5.VW1WP.GkddDt0UTRxjMnxpkmxDSVfPbiO0CvW', 2),
(3, 'Paulo', 'Garcia', 'paulo@gmail.com', '$2y$10$wf6yPjPAkEIMLK93MGksL.X7DWZONZAplbN/weuBgrM5AvOKluyFi', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
