-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-11-2024 a las 17:23:46
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `market`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `tipo` enum('vendedor','comprador') NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `contrasena`, `tipo`, `creado_en`) VALUES
(4, 'Juanito lopez', 'juanito.lopez@example.com', '$2y$10$guJG9dsdoVF90Pf46mwagevw0PI/s99ORrMdQDTNPp/wxXT2j9GoK', 'comprador', '2024-11-18 03:58:16'),
(6, 'Maria lopez', 'Mari.lopez@example.com', '$2y$10$vqc.DAmdY4ExmGoMWdzXNOnbh7rzMLSdRFxm59X/JLDIzQF3oA9mu', 'comprador', '2024-11-18 03:59:22'),
(7, 'Julian Pérez', 'julian.perez@example.com', '$2y$10$V8qTNXqfwEn46NbsoNok.u09DdvjNId4S6Yka/ZG9rpR20bpDp2gm', 'vendedor', '2024-11-18 04:03:46'),
(12, 'Juan Pérez', 'juan.perez@example.com', '$2y$10$sus.BbWKTZsNxX6eQ72YquDdhYchIpEPYSjuJkfqk7nkZJu5dS1bi', 'vendedor', '2024-11-18 05:13:58'),
(13, 'Elmer Maxuel', 'me@yahoo.com', '$2y$10$MhU8XSpxthTuFbsY0ZgTWOmrzwUFnJSIcBb1vE7u2L/KLC8WPALL6', 'vendedor', '2024-11-18 08:45:32'),
(14, 'Rosa Folores', 'Rose@gmail.com', '$2y$10$ZbNsisL0tsv1DRwlM8xTcO7ItyJCgzTUs23pC4FecAukdNPNbvMb6', 'vendedor', '2024-11-18 08:49:21');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
