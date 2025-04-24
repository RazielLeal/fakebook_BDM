-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-04-2025 a las 08:07:11
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
-- Estructura de tabla para la tabla `amigos`
--

CREATE TABLE `amigos` (
  `id_amigos` int(11) NOT NULL COMMENT 'Identificador único de la relación de amistad (PK)/ Clave primaria, NOT NULL, AUTO_INCREMENT',
  `usuario_id` int(11) NOT NULL COMMENT 'ID del usuario que envió o tiene al amigo (FK -> usuarios)/ Clave foránea, NOT NULL, referencia a usuarios(usuarios_id), ON DELETE CASCADE',
  `amigo_id` int(11) NOT NULL COMMENT 'ID del amigo (otro usuario en la tabla usuarios)/ Clave foránea, NOT NULL, referencia a usuarios(usuarios_id), ON DELETE CASCADE',
  `estado` enum('Pendiente','Aceptado','Rechazado','Bloqueado','Eliminado') NOT NULL DEFAULT 'Pendiente' COMMENT 'Estado de la amistad (Pendiente, Aceptado, Rechazado, Bloqueado y Eliminado)',
  `fecha_solicitud` datetime DEFAULT current_timestamp() COMMENT 'Valor por defecto CURRENT_TIMESTAMP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `amigos`
--

INSERT INTO `amigos` (`id_amigos`, `usuario_id`, `amigo_id`, `estado`, `fecha_solicitud`) VALUES
(14, 15, 13, 'Aceptado', '2025-04-23 02:17:24'),
(15, 13, 15, 'Aceptado', '2025-04-23 15:30:07'),
(16, 13, 21, 'Eliminado', '2025-04-23 15:40:15'),
(17, 21, 13, 'Eliminado', '2025-04-23 15:40:29'),
(19, 21, 15, 'Eliminado', '2025-04-23 18:56:39'),
(20, 15, 21, 'Bloqueado', '2025-04-23 18:56:46');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `amigos`
--
ALTER TABLE `amigos`
  ADD PRIMARY KEY (`id_amigos`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `amigo_id` (`amigo_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `amigos`
--
ALTER TABLE `amigos`
  MODIFY `id_amigos` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la relación de amistad (PK)/ Clave primaria, NOT NULL, AUTO_INCREMENT', AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `amigos`
--
ALTER TABLE `amigos`
  ADD CONSTRAINT `amigos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuarios_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `amigos_ibfk_2` FOREIGN KEY (`amigo_id`) REFERENCES `usuarios` (`usuarios_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
