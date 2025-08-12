-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-08-2025 a las 00:50:17
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
-- Base de datos: `file_manager`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `schools`
--

CREATE TABLE `schools` (
  `id` int(11) NOT NULL,
  `schoolName` varchar(100) NOT NULL,
  `shift` enum('manana','tarde','noche') DEFAULT NULL,
  `service` varchar(100) DEFAULT NULL,
  `sharedBuilding` tinyint(1) DEFAULT NULL,
  `cue` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `principal` varchar(100) DEFAULT NULL,
  `vicePrincipal` varchar(100) DEFAULT NULL,
  `secretary` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `schools`
--

INSERT INTO `schools` (`id`, `schoolName`, `shift`, `service`, `sharedBuilding`, `cue`, `address`, `city`, `phone`, `email`, `principal`, `vicePrincipal`, `secretary`) VALUES
(1, 'Escuela Primaria N°1', 'manana', 'Educación Primaria', 0, '123456789012345', 'Calle Falsa 123', 'Buenos Aires', '011-1234-5678', 'dir1@escuela.edu.ar', 'Laura González', 'Carlos Pérez', 'Ana Ruiz'),
(2, 'Instituto San Martín', 'tarde', 'Educación Secundaria', 1, '234567890123456', 'Av. Libertador 456', 'Córdoba', '0351-5678-1234', 'dir2@institutosm.edu.ar', 'Ricardo Díaz', 'María López', 'Jorge Romero'),
(4, 'Escuela Técnica N°2', 'manana', 'Técnico Electromecánico', 0, '456789012345678', 'Mitre 1010', 'La Plata', '0221-888-9999', 'et2@educacion.gob.ar', 'Martín Suárez', 'Elena Castro', 'Federico Molina'),
(5, 'Escuela Rural El Ceibo', NULL, 'Educación Básica Rural', 1, '567890123456789', 'Ruta 3 Km 45', 'San Luis', '02652-321-000', 'ceibo@rural.edu.ar', 'Nora Ramírez', NULL, 'Ramón Cáceres'),
(9, 'Instituto Técnico Industrial', 'tarde', 'Técnico en Electrónica', 0, '890123456789012', 'Castelli 1234', 'Mar del Plata', '0223-555-1212', 'iti@mdq.edu.ar', 'Daniel Ríos', 'Laura Iglesias', 'Néstor Giménez'),
(11, 'Escuela de Comercio N°', 'manana', 'Contabilidad y Administración', 1, '60924501', 'Luis py 366', 'Carmen de patagones', '02920541084', 'Agustin500cm@gmail.com', 'Juan Pérez', 'dsadas', 'gfdgdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'Agustin500cm@gmail.com', '$2y$10$HWNAV694yPRci4kkECogt.h8ItY.hexhGEkcykTQPWwosIA0f6MZW', 'user', '2025-08-05 15:55:04');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
