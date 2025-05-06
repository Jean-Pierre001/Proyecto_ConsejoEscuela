-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-04-2025 a las 03:22:50
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto_coop`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `advance`
--

CREATE TABLE `advance` (
  `id_advance` int(11) NOT NULL,
  `facturacion` decimal(10,2) NOT NULL,
  `anticipo` decimal(10,2) NOT NULL,
  `plazos` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `advance`
--

INSERT INTO `advance` (`id_advance`, `facturacion`, `anticipo`, `plazos`, `total`, `fecha_registro`) VALUES
(1, 2000.00, 20.00, 4.00, 1976.00, '2025-04-25 00:35:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `costanera`
--

CREATE TABLE `costanera` (
  `id_costanera` int(11) NOT NULL,
  `facturacion` decimal(10,2) NOT NULL,
  `anticipo` decimal(10,2) NOT NULL,
  `plazos` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `costanera`
--

INSERT INTO `costanera` (`id_costanera`, `facturacion`, `anticipo`, `plazos`, `total`, `fecha_registro`) VALUES
(1, 231312.00, 4324.00, 233.00, 226755.00, '2025-04-25 01:06:42'),
(2, 231312.00, 4324.00, 233.00, 226755.00, '2025-04-25 01:07:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patagones`
--

CREATE TABLE `patagones` (
  `id_patagones` int(11) NOT NULL,
  `facturacion` decimal(10,2) NOT NULL,
  `anticipo` decimal(10,2) NOT NULL,
  `plazos` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `patagones`
--

INSERT INTO `patagones` (`id_patagones`, `facturacion`, `anticipo`, `plazos`, `total`, `fecha_registro`) VALUES
(1, 231321.00, 343.00, 33.00, 230945.00, '2025-04-25 01:07:59'),
(2, 231321.00, 343.00, 33.00, 230945.00, '2025-04-25 01:08:03'),
(3, 231321.00, 343.00, 33.00, 230945.00, '2025-04-25 01:11:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros_contables`
--

CREATE TABLE `registros_contables` (
  `id` int(11) NOT NULL,
  `facturacion` decimal(10,2) NOT NULL,
  `anticipo` decimal(10,2) NOT NULL,
  `plazos` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registros_contables`
--

INSERT INTO `registros_contables` (`id`, `facturacion`, `anticipo`, `plazos`, `total`, `fecha_registro`) VALUES
(27, 2000.00, 333.00, 43.00, 1624.00, '2025-04-25 01:03:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socios`
--

CREATE TABLE `socios` (
  `id_socio` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `cuit_cuil` varchar(20) DEFAULT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_egreso` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `socios`
--

INSERT INTO `socios` (`id_socio`, `nombre`, `apellido`, `dni`, `cuit_cuil`, `fecha_ingreso`, `fecha_egreso`) VALUES
(7, 'jean', 'perez', '48843820', '20-23326545-8', '5555-04-23', '0232-03-31'),
(28, 'Juan', 'Pérez', '12345678', '20-12345678-9', '2025-01-01', '0000-00-00'),
(29, 'Ana', 'García', '23456789', '20-23456789-0', '2025-02-01', '0000-00-00'),
(30, 'Luis', 'Martínez', '34567890', '20-34567890-1', '2025-03-01', '0000-00-00'),
(31, 'María', 'López', '45678901', '20-45678901-2', '2025-04-01', '0000-00-00'),
(32, 'Carlos', 'Rodríguez', '56789012', '20-56789012-3', '2025-05-01', '0000-00-00'),
(33, 'Laura', 'González', '67890123', '20-67890123-4', '2025-06-01', '0000-00-00'),
(34, 'Pedro', 'Sánchez', '78901234', '20-78901234-5', '2025-07-01', '0000-00-00'),
(35, 'Sandra', 'Fernández', '89012345', '20-89012345-6', '2025-08-01', '0000-00-00'),
(36, 'Javier', 'Pérez', '90123456', '20-90123456-7', '2025-09-01', '0000-00-00'),
(37, 'Patricia', 'Díaz', '10234567', '20-10234567-8', '2025-10-01', '0000-00-00'),
(38, 'Francisco', 'Gómez', '21345678', '20-21345678-9', '2025-11-01', '0000-00-00'),
(39, 'Susana', 'Ramírez', '32456789', '20-32456789-0', '2025-12-01', '0000-00-00'),
(40, 'Mario', 'Hernández', '43567890', '20-43567890-1', '2026-01-01', '0000-00-00'),
(41, 'Elena', 'Ruiz', '54678901', '20-54678901-2', '2026-02-01', '0000-00-00'),
(42, 'Ricardo', 'Jiménez', '65789012', '20-65789012-3', '2026-03-01', '0000-00-00'),
(43, 'Raquel', 'Torres', '76890123', '20-76890123-4', '2026-04-01', '0000-00-00'),
(44, 'José', 'Díaz', '87901234', '20-87901234-5', '2026-05-01', '0000-00-00'),
(45, 'Isabel', 'Sánchez', '98012345', '20-98012345-6', '2026-06-01', '0000-00-00'),
(46, 'David', 'Fernández', '09123456', '20-09123456-7', '2026-07-01', '0000-00-00'),
(47, 'Carmen', 'Ruiz', '20234567', '20-20234567-8', '2026-08-01', '0000-00-00'),
(48, 'Jean Pierre', 'Lobos', '48843819', '20-23326545-8', '2025-04-23', '2025-05-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(50) NOT NULL,
  `rol` enum('administrador','usuarioVista') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `usuario`, `contrasena`, `rol`) VALUES
(1, 'Oscar', 'admin', 'administrador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `advance`
--
ALTER TABLE `advance`
  ADD PRIMARY KEY (`id_advance`);

--
-- Indices de la tabla `costanera`
--
ALTER TABLE `costanera`
  ADD PRIMARY KEY (`id_costanera`);

--
-- Indices de la tabla `patagones`
--
ALTER TABLE `patagones`
  ADD PRIMARY KEY (`id_patagones`);

--
-- Indices de la tabla `registros_contables`
--
ALTER TABLE `registros_contables`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `socios`
--
ALTER TABLE `socios`
  ADD PRIMARY KEY (`id_socio`),
  ADD UNIQUE KEY `dni` (`dni`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `advance`
--
ALTER TABLE `advance`
  MODIFY `id_advance` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `costanera`
--
ALTER TABLE `costanera`
  MODIFY `id_costanera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `patagones`
--
ALTER TABLE `patagones`
  MODIFY `id_patagones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `registros_contables`
--
ALTER TABLE `registros_contables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `socios`
--
ALTER TABLE `socios`
  MODIFY `id_socio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
