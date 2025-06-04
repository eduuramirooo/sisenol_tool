-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-06-2025 a las 13:03:48
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
-- Base de datos: `sisenol`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `notas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `contenido` text DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notas`
--

INSERT INTO `notas` (`id`, `usuario_id`, `contenido`, `fecha`, `created_at`, `updated_at`) VALUES
(1, 1, 'Revisar enchufes del plano cocina', '2025-04-05 08:47:05', '2025-04-05 06:47:05', '2025-04-05 06:47:05'),
(2, 2, 'Cambiar interruptores en la oficina', '2025-04-05 08:47:05', '2025-04-05 06:47:05', '2025-04-05 06:47:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `documento` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `imagen`, `documento`, `created_at`, `updated_at`) VALUES
(1, 'Producto A', 'Descripción A', '/upload/img/productoA.png', '/upload/document/producto_a_documentos.zip', '2025-04-05 06:47:05', '2025-05-14 05:58:36'),
(2, 'Producto B', 'Descripción B', '/upload/img/productoB.png', '/upload/document/producto_b.pdf', '2025-04-05 06:47:05', '2025-04-05 06:47:05'),
(3, 'Producto C', 'Descripción C', '/upload/img/productoC.png', '/upload/document/producto_c.pdf', '2025-04-05 06:47:05', '2025-04-05 06:47:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_usuario`
--

CREATE TABLE `producto_usuario` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto_usuario`
--

INSERT INTO `producto_usuario` (`id`, `usuario_id`, `producto_id`) VALUES
(1, 1, 1),
(2, 1, 3),
(3, 2, 2),
(5, 5, 2),
(6, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `carpeta` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`id`, `nombre`, `carpeta`, `created_at`, `updated_at`) VALUES
(1, 'Proyecto Solar', '\\\\DESKTOP-R9K7UMI\\Sisenol\\proyectosolar', '2025-04-07 09:31:48', '2025-05-08 06:13:06'),
(2, 'Proyecto Alpha', '\\\\DESKTOP-R9K7UMI\\Sisenol\\proyecto_alpha', '2025-04-24 11:44:53', '2025-04-24 11:44:53'),
(3, 'Proyecto Beta', '\\\\DESKTOP-R9K7UMI\\Sisenol\\proyecto_beta', '2025-04-24 11:44:53', '2025-04-24 11:44:53'),
(4, 'Edu', '\\\\DESKTOP-R9K7UMI\\Sisenol\\edu', '2025-04-24 09:59:59', '2025-04-24 09:59:59'),
(5, 'Practica', '\\\\DESKTOP-R9K7UMI\\Sisenol\\practica', '2025-05-07 06:12:27', '2025-05-07 06:12:27'),
(6, 'Practica2', 'carpeta', '2025-05-07 06:14:25', '2025-05-12 16:43:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto_usuario`
--

CREATE TABLE `proyecto_usuario` (
  `id` int(11) NOT NULL,
  `proyecto_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proyecto_usuario`
--

INSERT INTO `proyecto_usuario` (`id`, `proyecto_id`, `usuario_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-04-07 09:31:54', '2025-04-07 09:31:54'),
(2, 1, 1, '2025-04-24 11:45:03', '2025-04-24 11:45:03'),
(3, 1, 2, '2025-04-24 11:45:03', '2025-04-24 11:45:03'),
(4, 2, 1, '2025-04-24 11:45:03', '2025-04-24 11:45:03'),
(5, 4, 5, '2025-05-05 08:29:32', '2025-05-05 08:29:32'),
(6, 4, 4, '2025-05-07 06:05:18', '2025-05-07 06:05:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `alias` varchar(100) DEFAULT NULL,
  `tipo` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `alias`, `tipo`, `created_at`, `updated_at`, `activo`) VALUES
(1, 'eduu', '$2y$10$76KF1qNKTP7rk2Qbgz.9duyjkqCjkH4VUgjkHLE8RCRbgyX8YjUGa', 'Edu', 'admin', '2025-04-05 06:47:05', '2025-04-05 06:47:05', 1),
(2, 'jdoe', '$2y$10$NtrUx.A7M8yEkygP/zFGh.USCE/ieK3Ad1ghjUJW8Sxa8KbDsEoWa', 'Juan', 'user', '2025-04-05 06:47:05', '2025-04-05 06:47:05', 1),
(3, 'amora', '$2y$10$Sy/BglmCyaE5fteGRmCBZeoj9nVuyAQVnDoGsHvhfSKPRVsUdJOGy', 'Ana', 'user', '2025-04-05 06:47:05', '2025-04-05 06:47:05', 1),
(4, 'admin1', '$2y$10$czPK7xWsyRT7pr20D104ieG03PFKGMhrx9zPhCpY38NToSgVUJHRC', 'Administrador', 'admin', '2025-04-05 06:47:05', '2025-04-05 06:47:05', 1),
(5, 'sisenolUser', '$2y$10$gne9lvfCHCxH2RQqYgseUuklg1kehEFxBLRLTIuUX7Rad9hYrrU1m', 'el duro', 'user', NULL, NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `producto_usuario`
--
ALTER TABLE `producto_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proyecto_usuario`
--
ALTER TABLE `proyecto_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proyecto_id` (`proyecto_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `notas`
--
ALTER TABLE `notas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `producto_usuario`
--
ALTER TABLE `producto_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `proyecto_usuario`
--
ALTER TABLE `proyecto_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `notas`
--
ALTER TABLE `notas`
  ADD CONSTRAINT `notas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `producto_usuario`
--
ALTER TABLE `producto_usuario`
  ADD CONSTRAINT `producto_usuario_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `producto_usuario_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `proyecto_usuario`
--
ALTER TABLE `proyecto_usuario`
  ADD CONSTRAINT `proyecto_usuario_ibfk_1` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `proyecto_usuario_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
