-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-05-2025 a las 13:45:08
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
-- Base de datos: `escuela`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carpetas`
--

CREATE TABLE `carpetas` (
  `id` int(11) NOT NULL,
  `cue` varchar(20) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `carpeta` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carpetas`
--

INSERT INTO `carpetas` (`id`, `cue`, `nombre`, `carpeta`) VALUES
(1, '0621234001234', 'Escuela Técnica Nº 1', 'folders/Escuela Técnica Nº 1'),
(2, '0621234005678', 'Escuela Secundaria Nº 5', 'folders/Escuela Secundaria Nº 5'),
(3, '0621234001122', 'Instituto Técnico Industrial', 'folders/Instituto Técnico Industrial');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `escuelas`
--

CREATE TABLE `escuelas` (
  `id` int(11) NOT NULL,
  `nombreEscuela` varchar(100) NOT NULL,
  `turno` varchar(20) DEFAULT NULL,
  `servicio` varchar(100) DEFAULT NULL,
  `edificioCompartido` tinyint(1) DEFAULT NULL,
  `CUE` varchar(15) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `localidad` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correoElectronico` varchar(100) DEFAULT NULL,
  `directivo` varchar(100) DEFAULT NULL,
  `vicedirectora` varchar(100) DEFAULT NULL,
  `secretaria` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `escuelas`
--

INSERT INTO `escuelas` (`id`, `nombreEscuela`, `turno`, `servicio`, `edificioCompartido`, `CUE`, `direccion`, `localidad`, `telefono`, `correoElectronico`, `directivo`, `vicedirectora`, `secretaria`) VALUES
(1, 'Escuela Técnica Nº 1', 'Mañana', 'Técnico en Programación', 0, '0621234001234', 'Av. Principal 1234', 'Carmen de Patagones', '2920-123456', 'tecnica1@educacion.edu.ar', 'Ing. Juan Pérez', 'Lic. Ana Gómez', 'Sra. Laura Díaz'),
(2, 'Escuela Secundaria Nº 5', 'Tarde', 'Bachiller en Ciencias Sociales', 1, '0621234005678', 'Calle Belgrano 345', 'Viedma', '2920-654321', 'secundaria5@educacion.edu.ar', 'Prof. Marta López', 'Prof. Sergio Ríos', 'Sra. Natalia Ferreyra'),
(3, 'Instituto Técnico Industrial', 'Mañana', 'Electromecánica', 0, '0621234001122', 'Ruta 3 km 10', 'Bahía Blanca', '291-456789', 'iti@educacion.edu.ar', 'Ing. Carlos Méndez', 'Lic. Laura Sosa', 'Srta. Mariana Ortiz'),
(4, 'Escuela Agrotécnica Nº 2', 'Completo', 'Técnico Agropecuario', 1, '0621234003344', 'Camino Rural S/N', 'General Conesa', '2920-987654', 'agrotecnica2@educacion.edu.ar', 'Ing. Rosa Herrera', 'Prof. Andrés Castillo', 'Sra. Luisa Ramírez'),
(5, 'Escuela Técnica Nº 3', 'Tarde', 'Maestro Mayor de Obras', 0, '0621234007788', 'Calle Mitre 234', 'San Antonio Oeste', '2934-112233', 'tecnica3@educacion.edu.ar', 'Arq. Julio Godoy', 'Lic. Elena Vargas', 'Srta. Silvia Torres'),
(6, 'Colegio Politécnico Patagónico', 'Mañana', 'Informática Profesional', 1, '0621234009900', 'Calle Sarmiento 987', 'Bariloche', '294-556677', 'politecnico@educacion.edu.ar', 'Ing. Fernando Ríos', 'Lic. Paola Medina', 'Sra. Viviana Escudero'),
(7, 'Escuela Técnica Nº 6', 'Noche', 'Electrónica', 0, '0621234012345', 'Av. Libertad 456', 'Choele Choel', '298-112244', 'tecnica6@educacion.edu.ar', 'Ing. Raúl Coria', 'Prof. Clara Olmos', 'Srta. Mariela Funes'),
(8, 'Escuela Técnica Nº 7', 'Mañana', 'Automotores', 1, '0621234015678', 'Calle Rivadavia 654', 'Río Colorado', '2920-889900', 'tecnica7@educacion.edu.ar', 'Ing. Nicolás Cabrera', 'Lic. Teresa Navarro', 'Sra. Gabriela Molina'),
(9, 'Escuela Técnica Nº 8', 'Tarde', 'Técnico Químico', 0, '0621234018901', 'Pasaje Los Andes 123', 'Luis Beltrán', '2934-334455', 'tecnica8@educacion.edu.ar', 'Ing. Matías Suárez', 'Prof. Valeria Luján', 'Srta. Daniela Bustos'),
(10, 'Escuela Técnica Nº 9', 'Completo', 'Técnico en Energías Renovables', 1, '0621234020011', 'Calle Neuquén 789', 'San Carlos de Bariloche', '294-778899', 'tecnica9@educacion.edu.ar', 'Ing. Cecilia Robledo', 'Lic. Jorge Martínez', 'Sra. Beatriz Giménez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `contrasena` varchar(50) NOT NULL,
  `tipo` enum('administrador','directivo') NOT NULL,
  `correo` varchar(50) NOT NULL,
  `telefono` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `contrasena`, `tipo`, `correo`, `telefono`) VALUES
(2, 'admin', '$2y$10$wIJQs9/qXsQIlUPrxVV3O.RuP6XlvwY14xC91HgzgOn', 'directivo', 'agustin500cm@gmail.com', 2147483647),
(3, 'adsasdas', '$2y$10$0ybxvliQeOf74a78ze0APO/eaBfhkpd1wa8ISA3nZ74', 'administrador', 'holanda@gmail.com', 1234567891),
(4, 'rosas', '$2y$10$3RFCQ0nAE6UazTzKGpO2M.WVPMrWA80HwaUVI6EjZNn', 'administrador', 'rosas4000@gmail.com', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carpetas`
--
ALTER TABLE `carpetas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cue` (`cue`);

--
-- Indices de la tabla `escuelas`
--
ALTER TABLE `escuelas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carpetas`
--
ALTER TABLE `carpetas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `escuelas`
--
ALTER TABLE `escuelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
