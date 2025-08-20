-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-08-2025 a las 21:08:24
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
-- Estructura de tabla para la tabla `authorities`
--

CREATE TABLE `authorities` (
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `personal_phone` varchar(50) DEFAULT NULL,
  `personal_email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `authorities`
--

INSERT INTO `authorities` (`id`, `school_id`, `role`, `name`, `personal_phone`, `personal_email`, `created_at`, `updated_at`) VALUES
(9, 7, 'Director/a', 'Director 1', '3000000001', 'director1@example.com', '2025-08-11 15:30:27', '2025-08-11 15:30:27'),
(10, 8, 'Director/a', 'Director 2', '3000000002', 'director2@example.com', '2025-08-11 15:30:27', '2025-08-11 15:30:27'),
(11, 9, 'Director/a', 'Director 3', '3000000003', 'director3@example.com', '2025-08-11 15:30:27', '2025-08-11 15:30:27'),
(12, 10, 'Director/a', 'Director 4', '3000000004', 'director4@example.com', '2025-08-11 15:30:27', '2025-08-11 15:30:27'),
(13, 11, 'Director/a', 'Director 5', '3000000005', 'director5@example.com', '2025-08-11 15:30:28', '2025-08-11 15:30:28'),
(14, 12, 'Director/a', 'Director 6', '3000000006', 'director6@example.com', '2025-08-11 15:30:28', '2025-08-11 15:30:28'),
(15, 13, 'Director/a', 'Director 7', '3000000007', 'director7@example.com', '2025-08-11 15:30:28', '2025-08-11 15:30:28'),
(16, 14, 'Director/a', 'Director 8', '3000000008', 'director8@example.com', '2025-08-11 15:30:28', '2025-08-11 15:30:28'),
(17, 15, 'Director/a', 'Director 9', '3000000009', 'director9@example.com', '2025-08-11 15:30:28', '2025-08-11 15:30:28'),
(18, 16, 'Director/a', 'Director 10', '3000000010', 'director10@example.com', '2025-08-11 15:30:28', '2025-08-11 15:30:28'),
(19, 17, 'Director/a', 'Director 11', '3000000011', 'director11@example.com', '2025-08-11 15:30:28', '2025-08-11 15:30:28'),
(20, 18, 'Director/a', 'Director 12', '3000000012', 'director12@example.com', '2025-08-11 15:30:28', '2025-08-11 15:30:28'),
(21, 19, 'Director/a', 'Director 13', '3000000013', 'director13@example.com', '2025-08-11 15:30:28', '2025-08-11 15:30:28'),
(22, 20, 'Director/a', 'Director 14', '3000000014', 'director14@example.com', '2025-08-11 15:30:28', '2025-08-11 15:30:28'),
(23, 21, 'Director/a', 'Director 15', '3000000015', 'director15@example.com', '2025-08-11 15:30:28', '2025-08-11 15:30:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(7, 'Sin categoría', NULL, '2025-08-11 15:36:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inspectors`
--

CREATE TABLE `inspectors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `levelModality` varchar(50) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `schools`
--

CREATE TABLE `schools` (
  `id` int(11) NOT NULL,
  `schoolName` varchar(255) NOT NULL,
  `order_number` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `is_disadvantaged` tinyint(1) NOT NULL DEFAULT 0,
  `shift` varchar(50) NOT NULL,
  `service_code` varchar(50) NOT NULL,
  `shared_building` varchar(255) DEFAULT NULL,
  `cue_code` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `locality` varchar(100) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `schools`
--

INSERT INTO `schools` (`id`, `schoolName`, `order_number`, `category_id`, `is_disadvantaged`, `shift`, `service_code`, `shared_building`, `cue_code`, `address`, `locality`, `phone`, `email`, `created_at`, `updated_at`) VALUES
(24, 'Escuela 1', 1, 10, 0, 'Mañana', 'SC001', NULL, 'CUE001', 'Calle 1', 'Ciudad A', '111111111', 'esc1@example.com', '2025-08-12 19:07:36', '2025-08-12 19:07:36'),
(25, 'Escuela 2', 2, 10, 1, 'Tarde', 'SC002', 'Edificio A', 'CUE002', 'Calle 2', 'Ciudad A', '222222222', 'esc2@example.com', '2025-08-12 19:07:36', '2025-08-12 19:07:36'),
(26, 'Escuela 3', 3, 10, 0, 'Mañana', 'SC003', NULL, 'CUE003', 'Calle 3', 'Ciudad B', '333333333', 'esc3@example.com', '2025-08-12 19:07:36', '2025-08-12 19:07:36'),
(27, 'Escuela 4', 4, 10, 0, 'Tarde', 'SC004', NULL, 'CUE004', 'Calle 4', 'Ciudad B', '444444444', 'esc4@example.com', '2025-08-12 19:07:36', '2025-08-12 19:07:36'),
(28, 'Escuela 5', 5, 10, 1, 'Mañana', 'SC005', 'Edificio B', 'CUE005', 'Calle 5', 'Ciudad C', '555555555', 'esc5@example.com', '2025-08-12 19:07:36', '2025-08-12 19:07:36'),
(29, 'Escuela 6', 6, 11, 0, 'Mañana', 'SC006', NULL, 'CUE006', 'Calle 6', 'Ciudad C', '666666666', 'esc6@example.com', '2025-08-12 19:07:36', '2025-08-12 19:07:36'),
(30, 'Escuela 7', 7, 11, 0, 'Tarde', 'SC007', NULL, 'CUE007', 'Calle 7', 'Ciudad D', '777777777', 'esc7@example.com', '2025-08-12 19:07:36', '2025-08-12 19:07:36'),
(31, 'Escuela 8', 8, 11, 1, 'Mañana', 'SC008', 'Edificio C', 'CUE008', 'Calle 8', 'Ciudad D', '888888888', 'esc8@example.com', '2025-08-12 19:07:36', '2025-08-12 19:07:36'),
(32, 'Escuela 9', 9, 11, 0, 'Tarde', 'SC009', NULL, 'CUE009', 'Calle 9', 'Ciudad E', '999999999', 'esc9@example.com', '2025-08-12 19:07:36', '2025-08-12 19:07:36'),
(33, 'Escuela 10', 10, 11, 0, 'Mañana', 'SC010', NULL, 'CUE010', 'Calle 10', 'Ciudad E', '1010101010', 'esc10@example.com', '2025-08-12 19:07:36', '2025-08-12 19:07:36'),
(34, 'Escuela 11', 11, 12, 0, 'Tarde', 'SC011', NULL, 'CUE011', 'Calle 11', 'Ciudad F', '111111222', 'esc11@example.com', '2025-08-12 19:07:36', '2025-08-12 19:07:36'),
(35, 'Escuela 12', 12, 12, 1, 'Mañana', 'SC012', 'Edificio D', 'CUE012', 'Calle 12', 'Ciudad F', '222222333', 'esc12@example.com', '2025-08-12 19:07:36', '2025-08-12 19:07:36'),
(36, 'Escuela 13', 13, 12, 0, 'Tarde', 'SC013', NULL, 'CUE013', 'Calle 13', 'Ciudad G', '333333444', 'esc13@example.com', '2025-08-12 19:07:36', '2025-08-12 19:07:36'),
(37, 'Escuela 14', 14, 12, 0, 'Mañana', 'SC014', NULL, 'CUE014', 'Calle 14', 'Ciudad G', '444444555', 'esc14@example.com', '2025-08-12 19:07:36', '2025-08-12 19:07:36'),
(38, 'Escuela 15', 15, 12, 1, 'Tarde', 'SC015', 'Edificio E', 'CUE015', 'Calle 15', 'Ciudad H', '555555666', 'esc15@example.com', '2025-08-12 19:07:36', '2025-08-12 19:07:36');
(7, 'Escuela 12', 1, 7, 0, 'Mañana', 'SC001', '', 'CUE001', 'Calle 1', 'Ciudad A', '111111111', 'esc1@example.com', '2025-08-11 15:30:27', '2025-08-11 15:40:00'),
(8, 'Escuela 2', 2, 7, 1, 'Tarde', 'SC002', 'Edificio A', 'CUE002', 'Calle 2', 'Ciudad A', '222222222', 'esc2@example.com', '2025-08-11 15:30:27', '2025-08-11 15:40:00'),
(9, 'Escuela 3', 3, 7, 0, 'Mañana', 'SC003', NULL, 'CUE003', 'Calle 3', 'Ciudad B', '333333333', 'esc3@example.com', '2025-08-11 15:30:27', '2025-08-11 15:40:00'),
(10, 'Escuela 4', 4, 7, 0, 'Tarde', 'SC004', NULL, 'CUE004', 'Calle 4', 'Ciudad B', '444444444', 'esc4@example.com', '2025-08-11 15:30:27', '2025-08-11 15:40:00'),
(11, 'Escuela 5', 5, 7, 1, 'Mañana', 'SC005', 'Edificio B', 'CUE005', 'Calle 5', 'Ciudad C', '555555555', 'esc5@example.com', '2025-08-11 15:30:28', '2025-08-11 15:40:00'),
(12, 'Escuela 6', 6, 7, 0, 'Mañana', 'SC006', NULL, 'CUE006', 'Calle 6', 'Ciudad C', '666666666', 'esc6@example.com', '2025-08-11 15:30:28', '2025-08-11 15:41:24'),
(13, 'Escuela 7', 7, 7, 0, 'Tarde', 'SC007', NULL, 'CUE007', 'Calle 7', 'Ciudad D', '777777777', 'esc7@example.com', '2025-08-11 15:30:28', '2025-08-11 15:41:24'),
(14, 'Escuela 8', 8, 7, 1, 'Mañana', 'SC008', 'Edificio C', 'CUE008', 'Calle 8', 'Ciudad D', '888888888', 'esc8@example.com', '2025-08-11 15:30:28', '2025-08-11 15:41:24'),
(15, 'Escuela 9', 9, 7, 0, 'Tarde', 'SC009', NULL, 'CUE009', 'Calle 9', 'Ciudad E', '999999999', 'esc9@example.com', '2025-08-11 15:30:28', '2025-08-11 15:41:24'),
(16, 'Escuela 10', 10, 7, 0, 'Mañana', 'SC010', NULL, 'CUE010', 'Calle 10', 'Ciudad E', '1010101010', 'esc10@example.com', '2025-08-11 15:30:28', '2025-08-11 15:41:24'),
(17, 'Escuela 11', 11, 7, 0, 'Tarde', 'SC011', NULL, 'CUE011', 'Calle 11', 'Ciudad F', '111111222', 'esc11@example.com', '2025-08-11 15:30:28', '2025-08-11 15:37:09'),
(18, 'Escuela 12', 12, 7, 1, 'Mañana', 'SC012', 'Edificio D', 'CUE012', 'Calle 12', 'Ciudad F', '222222333', 'esc12@example.com', '2025-08-11 15:30:28', '2025-08-11 15:37:09'),
(19, 'Escuela 13', 13, 7, 0, 'Tarde', 'SC013', NULL, 'CUE013', 'Calle 13', 'Ciudad G', '333333444', 'esc13@example.com', '2025-08-11 15:30:28', '2025-08-11 15:37:09'),
(20, 'Escuela 14', 14, 7, 0, 'Mañana', 'SC014', NULL, 'CUE014', 'Calle 14', 'Ciudad G', '444444555', 'esc14@example.com', '2025-08-11 15:30:28', '2025-08-11 15:37:09'),
(21, 'Escuela 15', 15, 7, 1, 'Tarde', 'SC015', 'Edificio E', 'CUE015', 'Calle 15', 'Ciudad H', '555555666', 'esc15@example.com', '2025-08-11 15:30:28', '2025-08-11 15:37:09'),
(22, 'Escuela de Comercio N°', 3, 7, 1, 'manana', 'JI 903', 'Edificio A', 'CUE011', 'Luis py 366', 'Carmen de patagones', '02920541084', 'Agustin500cm@gmail.com', '2025-08-11 15:36:50', '2025-08-11 15:36:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Usuario','Administrador') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'Agustin500cm@gmail.com', '$2y$10$HWNAV694yPRci4kkECogt.h8ItY.hexhGEkcykTQPWwosIA0f6MZW', 'Admistrador', '2025-08-05 15:55:04');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `schools`
--
ALTER TABLE `schools`
  ADD CONSTRAINT `schools_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
