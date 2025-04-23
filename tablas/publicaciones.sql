-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-04-2025 a las 10:36:46
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
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE `publicaciones` (
  `publicacion_id` int(11) NOT NULL COMMENT 'Identificador único de la publicación (PK)./ Entero, autoincrementable',
  `usuarios_id` int(11) NOT NULL COMMENT 'ID del usuario que publicó (FK -> usuarios)/ Clave foránea, debe \r\nexistir en \r\nusuarios(usuarios_id)',
  `contenido` text DEFAULT NULL COMMENT 'Texto libre ',
  `fecha_publicacion` datetime DEFAULT current_timestamp() COMMENT 'Fecha y hora, por defecto: \r\nCURRENT_TIMESTAMP '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `publicaciones`
--

INSERT INTO `publicaciones` (`publicacion_id`, `usuarios_id`, `contenido`, `fecha_publicacion`) VALUES
(1, 15, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2025-04-08 02:44:55'),
(2, 16, 'Mi primera publicación en Fakebook. ¡Hola a todos!', '2025-04-08 10:00:00'),
(3, 16, '¡Qué bonito día para aprender algo nuevo de programación!', '2025-04-08 14:30:00'),
(4, 16, '¿Alguien más emocionado por los nuevos avances en tecnología?', '2025-04-08 18:15:00'),
(5, 13, '¡Primer post en Fakebook! Muy emocionado de estar aquí.', '2025-04-08 12:00:00'),
(6, 13, 'Los atardeceres aquí en Nuevo León nunca decepcionan. 🌅', '2025-04-08 16:45:00'),
(7, 13, '¿Alguien tiene recomendaciones de libros interesantes?', '2025-04-08 21:10:00'),
(8, 21, 'Prueba desde mysql para ver si jala', '2025-04-21 19:11:49'),
(9, 21, 'Prueba para ver si jala desde navegadorPrueba para ver si jala desde navegador', '2025-04-21 19:18:00'),
(10, 21, 'Segunda prueba desde navegador', '2025-04-21 19:19:24'),
(20, 21, 'abr abr', '2025-04-21 21:26:34'),
(21, 21, 'ahora', '2025-04-21 21:26:40'),
(40, 21, 'qwe', '2025-04-21 22:08:24'),
(48, 21, 'Aver, jalas?', '2025-04-21 22:12:59'),
(49, 21, 'asd', '2025-04-21 22:16:24'),
(51, 21, 'asdasdasd', '2025-04-21 23:54:40'),
(54, 21, 'abr si jala con videos', '2025-04-22 00:54:32'),
(56, 21, 'Prueba de video 2', '2025-04-22 14:57:04'),
(57, 21, 'Prueba con jgp', '2025-04-22 15:13:17'),
(58, 21, 'Prueba con JPG', '2025-04-22 15:13:47'),
(59, 15, 'Mi primer publicación con imagen :D', '2025-04-22 21:28:32');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`publicacion_id`),
  ADD KEY `usuarios_id` (`usuarios_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `publicacion_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la publicación (PK)./ Entero, autoincrementable', AUTO_INCREMENT=60;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD CONSTRAINT `publicaciones_ibfk_1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`usuarios_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
