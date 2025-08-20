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
