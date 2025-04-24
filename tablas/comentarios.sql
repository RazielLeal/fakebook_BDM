-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-04-2025 a las 08:07:27
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
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `comentario_id` int(11) NOT NULL COMMENT 'PRIMARY KEY, AUTO_INCREMENT\r\n',
  `usuarios_id` int(11) NOT NULL COMMENT 'NOT NULL, FOREIGN KEY (usuarios_id) ON DELETE CASCADE\r\n',
  `publicacion_id` int(11) NOT NULL COMMENT 'NOT NULL, FOREIGN KEY (publicacion_id) ON DELETE CASCADE\r\n',
  `contenido` text NOT NULL COMMENT 'Texto libre/ NOT NULL\r\n',
  `fecha_comentario` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`comentario_id`, `usuarios_id`, `publicacion_id`, `contenido`, `fecha_comentario`) VALUES
(2, 21, 58, 'Prueba', '2025-04-23 22:48:15'),
(3, 21, 58, 'abr segundo com,entario', '2025-04-23 23:53:24');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`comentario_id`),
  ADD KEY `usuarios_id` (`usuarios_id`),
  ADD KEY `publicacion_id` (`publicacion_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `comentario_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PRIMARY KEY, AUTO_INCREMENT\r\n', AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`usuarios_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`publicacion_id`) REFERENCES `publicaciones` (`publicacion_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
