-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-05-2025 a las 15:42:07
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `escuela`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `escuelas`
--

CREATE TABLE `escuelas` (
  `id` int(11) NOT NULL,
  `turno` varchar(20) DEFAULT NULL,
  `servicio` varchar(100) DEFAULT NULL,
  `edificio_compartido` tinyint(1) DEFAULT NULL,
  `CUE` varchar(15) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `localidad` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo_electronico` varchar(100) DEFAULT NULL,
  `directivo` varchar(100) DEFAULT NULL,
  `vicedirectora` varchar(100) DEFAULT NULL,
  `secretaria` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `escuelas`
--

INSERT INTO `escuelas` (`id`, `turno`, `servicio`, `edificio_compartido`, `CUE`, `direccion`, `localidad`, `telefono`, `correo_electronico`, `directivo`, `vicedirectora`, `secretaria`) VALUES
(34, 'Mañana', 'Común', NULL, '60924502', 'Villegas 270', 'Carmen de Patagones', '(02920) 461221', '[email protected]', 'Pedro Fernández', 'Lucía González', 'Juan Díaz'),
(35, 'Mañana', 'Común', NULL, '60924503', 'Río Negro 133', 'Stroeder', '(02920) 491428', '[email protected]', 'Elena García', 'Ricardo López', 'Isabel Martínez'),
(36, 'Mañana', 'Común', NULL, '60924504', 'Le Blanc', 'Carmen de Patagones', '(02920) 461575', '[email protected]', 'Carlos Pérez', 'María Rodríguez', 'José Sánchez'),
(37, 'Mañana', 'Común', NULL, '60924505', 'San Martín', 'Villalonga', '(02928) 492122', '[email protected]', 'Ana López', 'Luis González', 'Marta Díaz'),
(38, 'Mañana', 'Común', NULL, '60924506', 'Buenos Aires', 'Carmen de Patagones', '(02920) 464834', '[email protected]', 'Juan Martínez', 'Lucía Pérez', 'Carlos Sánchez'),
(39, 'Mañana', 'Común', NULL, '60924507', 'Comodoro Rivadavia 257', 'Carmen de Patagones', '(02920) 464834', '[email protected]', 'Pedro González', 'Ana Rodríguez', 'José Pérez'),
(40, 'Mañana', 'Común', NULL, '60924508', 'San Lorenzo 37 (entre Villegas y Bynon)', 'Carmen de Patagones', '(02920) 464837', '[email protected]', 'Romina Castro', 'Federico Luna', 'Laura Torres'),
(41, 'Mañana', 'Común', NULL, '60924509', '25 de Mayo 548', 'Stroeder', '(02920) 491187', '[email protected]', 'José López', 'Ana González', 'Carlos Martínez'),
(42, 'Mañana', 'Común', NULL, '60924510', 'Pje. Pozo Coronel', 'Cardenal Cagliero', '(02920) 15446569', '[email protected]', 'María Pérez', 'Luis Rodríguez', 'Marta Sánchez'),
(43, 'Mañana', 'Común', NULL, '60924511', '25 de Mayo 548', 'Carmen de Patagones', '(02920) 461276', '[email protected]', 'Carlos García', 'Ana López', 'José Martínez'),
(44, 'Mañana', 'Común', NULL, '60924512', 'San Martín s/n', 'Villalonga', '(02928) 492122', '[email protected]', 'Pedro Fernández', 'Lucía González', 'Juan Díaz'),
(45, 'Mañana', 'Común', NULL, '60924513', 'Zona Rural – J.B.Casas', 'Cardenal Cagliero', '(02920) 15446569', '[email protected]', 'Elena García', 'Ricardo López', 'Isabel Martínez'),
(46, 'Mañana', 'Común', NULL, '60924514', 'Jaime Harris 41', 'Carmen de Patagones', '(02920) 464102', '[email protected]', 'Carlos Pérez', 'María Rodríguez', 'José Sánchez'),
(47, 'Mañana', 'Común', NULL, '60924515', 'Balneario Los Pocitos', 'Los Pocitos', '(02920) 491015', '[email protected]', 'Ana López', 'Luis González', 'Marta Díaz'),
(48, 'Mañana', 'Común', NULL, '60924516', 'Colonia San Jose', 'Cardenal Cagliero', '(02920) 15446580', '[email protected]', 'Juan Martínez', 'Lucía Pérez', 'Carlos Sánchez'),
(49, 'Mañana', 'Común', NULL, '60924517', 'Zona Rural – Juan A. Pradere', 'Juan A. Pradere', '(291) 15446570', '[email protected]', 'Pedro González', 'Ana Rodríguez', 'José Pérez'),
(50, 'Mañana', 'Común', NULL, '60924518', 'Colonia La Graciela', 'Juan A. Pradere', '(2920) 15446511', '[email protected]', 'Romina Castro', 'Federico Luna', 'Laura Torres'),
(51, 'Mañana', 'Común', NULL, '60924519', 'Paso Alsina', 'Juan A. Pradere', '(2928) 420022', '[email protected]', 'José López', 'Ana González', 'Carlos Martínez'),
(52, 'Mañana', 'Común', NULL, '60924520', 'Estancia Balbuena', 'Juan A. Pradere', '(2928) 493055', '[email protected]', 'María Pérez', 'Luis Rodríguez', 'Marta Sánchez'),
(53, 'Mañana', 'Común', NULL, '60924521', 'Zona Rural – Juan A. Pradere', 'Juan A. Pradere', '(291) 15446581', '[email protected]', 'Carlos García', 'Ana López', 'José Martínez'),
(54, 'Mañana', 'Común', NULL, '60924522', 'Zona Rural – Cardenal Cagliero', 'Cardenal Cagliero', '(2920) 15446767', '[email protected]', 'Pedro Fernández', 'Lucía González', 'Juan Díaz'),
(55, 'Mañana', 'Común', NULL, '60924523', 'Colonia 7 de Marzo', 'Cardenal Cagliero', '(2920) 15446520', '[email protected]', 'Elena García', 'Ricardo López', 'Isabel Martínez');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `escuelas`
--
ALTER TABLE `escuelas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `escuelas`
--
ALTER TABLE `escuelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
