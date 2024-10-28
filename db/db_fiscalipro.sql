-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-10-2024 a las 00:17:56
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
-- Base de datos: `db_fiscalipro`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `correo_electronico` varchar(100) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `rol` enum('Usuario','Administrador') NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `correo_electronico`, `telefono`, `rol`, `contraseña`, `fecha_registro`) VALUES
(1, 'Alexander Angel', 'Diaz Granados', 'angellazarusdz20@gmail.com', '990358523', 'Administrador', '$2y$10$H.wrRnec0S/.nfx2w3RG6em6gmcoy57EJN29FZS2rkH1ZB0PMpjue', '2024-10-16 17:47:32'),
(176, 'Maribel', 'Montalvo Cervantes', 'mavisdrack31@gmail.com', '748456444', 'Administrador', '$2y$10$pu1LRS7jLmWCCP1UJq6WRuO49bbI3dLXqFKwvKvV1VjK97c0H5aA2', '2024-10-21 20:42:37'),
(177, 'Germain', 'Chavez Gutierrez', 'germainchavez45@gmail.com', '789456748', 'Usuario', '$2y$10$gDmycuqkjmDrMEPox9lfFeYqyOBtwL5eTD3gfb3kTu/XAmPOl6Pse', '2024-10-21 20:58:06'),
(178, 'Luciano', 'Diaz Granados', 'lucianodiaz16@gmail.com', '456748456', 'Usuario', '$2y$10$afnUknMuNs.b7AizPgHWUurtn2EbSwjXQL8rmFXSNeMzUiAwN41ta', '2024-10-21 20:58:46');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo_electronico` (`correo_electronico`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
