-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-04-2025 a las 10:36:31
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
-- Estructura de tabla para la tabla `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL COMMENT 'Entero positivo/ PRIMARY KEY, AUTO_INCREMENT\r\n',
  `usuarios_id` int(11) NOT NULL COMMENT 'NOT NULL, ON DELETE CASCADE',
  `publicacion_id` int(11) NOT NULL COMMENT 'NOT NULL, ON DELETE CASCADE',
  `fecha_like` datetime DEFAULT current_timestamp() COMMENT 'DEFAULT CURRENT_TIMESTAMP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `likes`
--

INSERT INTO `likes` (`like_id`, `usuarios_id`, `publicacion_id`, `fecha_like`) VALUES
(8, 15, 2, '2025-04-08 22:11:50'),
(9, 15, 4, '2025-04-08 22:15:46'),
(10, 15, 3, '2025-04-08 22:16:57'),
(11, 15, 5, '2025-04-08 22:17:43'),
(12, 15, 6, '2025-04-08 22:24:54'),
(13, 13, 1, '2025-04-08 23:06:28'),
(14, 16, 1, '2025-04-08 23:06:28'),
(15, 17, 1, '2025-04-08 23:06:28'),
(16, 19, 1, '2025-04-08 23:06:28'),
(17, 20, 1, '2025-04-08 23:06:28'),
(18, 15, 7, '2025-04-21 15:16:04'),
(19, 21, 10, '2025-04-21 19:32:45');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `fk_likes_usuarios` (`usuarios_id`),
  ADD KEY `fk_likes_publicaciones` (`publicacion_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Entero positivo/ PRIMARY KEY, AUTO_INCREMENT\r\n', AUTO_INCREMENT=20;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `fk_likes_publicaciones` FOREIGN KEY (`publicacion_id`) REFERENCES `publicaciones` (`publicacion_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_likes_usuarios` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`usuarios_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
