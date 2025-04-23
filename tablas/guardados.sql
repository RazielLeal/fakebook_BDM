-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-04-2025 a las 10:36:22
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
-- Base de datos: `fakebook_bdm`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guardados`
--

CREATE TABLE `guardados` (
  `guardado_id` int(11) NOT NULL COMMENT 'PRIMARY KEY, AUTO_INCREMENT',
  `usuarios_id` int(11) NOT NULL COMMENT 'NOT NULL, FOREIGN KEY (usuarios_id) ON DELETE CASCADE',
  `publicacion_id` int(11) NOT NULL COMMENT 'NOT NULL, FOREIGN KEY (publicacion_id) ON DELETE CASCADE',
  `fecha_guardado` datetime DEFAULT current_timestamp() COMMENT 'DEFAULT CURRENT_TIMESTAMP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `guardados`
--
ALTER TABLE `guardados`
  ADD PRIMARY KEY (`guardado_id`),
  ADD UNIQUE KEY `usuarios_id` (`usuarios_id`,`publicacion_id`),
  ADD KEY `publicacion_id` (`publicacion_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `guardados`
--
ALTER TABLE `guardados`
  MODIFY `guardado_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PRIMARY KEY, AUTO_INCREMENT';

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `guardados`
--
ALTER TABLE `guardados`
  ADD CONSTRAINT `guardados_ibfk_1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`usuarios_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `guardados_ibfk_2` FOREIGN KEY (`publicacion_id`) REFERENCES `publicaciones` (`publicacion_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
