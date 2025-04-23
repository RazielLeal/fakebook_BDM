-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-04-2025 a las 10:36:53
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
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuarios_id` int(11) NOT NULL COMMENT ' Identificador único del usuario (PK)/autoincrementable',
  `nombres` varchar(40) NOT NULL COMMENT 'Texto alfabético, hasta 40 caracteres ',
  `apellidos` varchar(20) NOT NULL COMMENT 'Texto alfabético, hasta 20 \r\ncaracteres ',
  `contra` varchar(255) NOT NULL COMMENT 'Contraseña del usuario (encriptada).',
  `email` varchar(100) NOT NULL COMMENT 'Correo válido, único, \r\nhasta 100 caracteres ',
  `estado` bit(1) NOT NULL DEFAULT b'1' COMMENT ' Estado del usuario (1=activo, 0=inactivo).',
  `fechaRegistro` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha y hora de registro, valor por defecto: \r\nCURRENT_TIMESTAMP',
  `imagen_perfil` mediumblob DEFAULT NULL COMMENT 'Imagen de perfil del usuario (almacenada en binario).',
  `username` varchar(50) NOT NULL COMMENT 'Texto, único, hasta 50 caracteres ',
  `fechaNacimiento` date NOT NULL COMMENT 'Fecha válida: YYYY-MM-DD ',
  `genero` enum('Hombre','Mujer','No especificar') NOT NULL DEFAULT 'No especificar' COMMENT '''Hombre'', ''Mujer'', ''No especificar'' '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuarios_id`, `nombres`, `apellidos`, `contra`, `email`, `estado`, `fechaRegistro`, `imagen_perfil`, `username`, `fechaNacimiento`, `genero`) VALUES
(13, 'Uriel', 'Almaguer', '$2y$10$Qqvns8Oli8hrBZeBW3RxvOCdGOifpu5chDqoSMUaerNzzuT4TiG5K', 'uriel@gmail.com', b'1', '2025-04-06 07:06:23', NULL, 'uriel', '2021-07-30', 'Hombre'),
(15, 'Grecia', 'Arenas', '$2y$10$Qqvns8Oli8hrBZeBW3RxvOCdGOifpu5chDqoSMUaerNzzuT4TiG5K', 'grecia@gmail.com', b'1', '2025-04-06 07:19:59', NULL, 'grecia', '2022-02-25', 'Mujer'),
(16, 'Jordi', 'Saldaña', '$2y$10$HKoD8rykkHEHU2B3yIT4Ae4jed6N14UsHNY28Egg5nF92Hd48z9Ai', 'jordi@gmail.com', b'1', '2025-04-07 00:35:45', NULL, 'rito', '2023-02-07', 'Hombre'),
(17, 'Adrian', 'Almaguer Soto', '$2y$10$u3o74ZnXV8UxtuW8lDH1jeD1V3.O6X8l798JtK1b8qdGKTFMCByYW', 'Adrian@hotmail.com', b'1', '2025-04-07 07:20:24', NULL, 'ELTERRENEITOR', '2004-08-20', 'Hombre'),
(19, 'Rodrigo', 'Medina', '$2y$10$8Fa2qr9PfmKr6nsuFSLzfOotdZK5UwmvEFU3l8crpManpH6..mixS', 'rodrigo@gmail.com', b'1', '2025-04-07 07:30:35', NULL, 'rodri', '1900-01-01', 'Hombre'),
(20, 'asd', 'asd', '$2y$10$2uPyzjfjtuhuUkNfk3GdG.3GqWnAMsNG4aMvwVRa5hy61Ijm1iZRy', 'ejemplo@ejemplo.mx', b'1', '2025-04-08 18:47:16', NULL, 'asd', '1999-10-11', 'Hombre'),
(21, 'Carlos Raziel', 'Leal Pérez', '$2y$10$b3/loO3SeYuUUpIYhHIwk.1ayDmTdZCgaOwPpq0xG/.RP14ooC0LK', 'raziel@gmail.com', b'1', '2025-04-21 16:08:55', NULL, 'rockaleta', '1999-12-08', 'Hombre');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuarios_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuarios_id` int(11) NOT NULL AUTO_INCREMENT COMMENT ' Identificador único del usuario (PK)/autoincrementable', AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
