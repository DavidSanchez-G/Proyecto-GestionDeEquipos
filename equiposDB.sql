-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-11-2025 a las 07:49:48
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
-- Base de datos: `equiposbd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `idAlumno` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `fk_idAula_alumno` int(11) DEFAULT NULL,
  `fk_idOrdenador_alumno` int(11) DEFAULT NULL,
  `fk_idUsuario_alumno` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`idAlumno`, `nombre`, `apellidos`, `email`, `fk_idAula_alumno`, `fk_idOrdenador_alumno`, `fk_idUsuario_alumno`) VALUES
(1, 'Omar', 'Boukhana', NULL, NULL, NULL, NULL),
(2, 'David', 'Sanchez', 'dsanchezg@campusdigitalfp.com', 1, 1, 1),
(3, 'Hugo', 'Dionisio', NULL, NULL, NULL, NULL),
(4, 'Alejandro', 'Alvarez', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aulas`
--

CREATE TABLE `aulas` (
  `idAula` int(11) NOT NULL,
  `nombre_aula` varchar(50) DEFAULT NULL,
  `planta` varchar(50) DEFAULT NULL,
  `centro` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `aulas`
--

INSERT INTO `aulas` (`idAula`, `nombre_aula`, `planta`, `centro`) VALUES
(1, 'Joan Clarke', 'Planta 2', 'CAMPUS DIGITAL'),
(2, 'Anna Easly', 'Planta 2', 'CAMPUS DIGITAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantenimiento`
--

CREATE TABLE `mantenimiento` (
  `idMantenimiento` int(11) NOT NULL,
  `num_ticket` varchar(50) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `estado` enum('pendiente','solucionada') NOT NULL,
  `tipo` enum('asignacion','incidencia') NOT NULL,
  `fk_idAlumno` int(11) DEFAULT NULL,
  `fk_idOrdenador` int(11) DEFAULT NULL,
  `fk_idPeriferico` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mantenimiento`
--

INSERT INTO `mantenimiento` (`idMantenimiento`, `num_ticket`, `fecha`, `descripcion`, `estado`, `tipo`, `fk_idAlumno`, `fk_idOrdenador`, `fk_idPeriferico`) VALUES
(18, '1-1-20251109', '2025-11-09', 'necesito un raton', 'pendiente', 'asignacion', 2, NULL, NULL),
(19, '2-1-20251109', '2025-11-09', 'le falta una tecla', 'pendiente', 'incidencia', 2, 1, NULL),
(20, '3-1-20251111', '2025-11-11', 'hola', 'pendiente', 'incidencia', 2, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenadores`
--

CREATE TABLE `ordenadores` (
  `idOrdenador` int(11) NOT NULL,
  `marca` varchar(45) DEFAULT NULL,
  `so` varchar(45) DEFAULT NULL,
  `modelo` varchar(45) DEFAULT NULL,
  `num_serie` int(11) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `estado` enum('averiado','operativo') DEFAULT NULL,
  `fk_idAula` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ordenadores`
--

INSERT INTO `ordenadores` (`idOrdenador`, `marca`, `so`, `modelo`, `num_serie`, `numero`, `estado`, `fk_idAula`) VALUES
(1, 'HP', 'Windows 11', 'ProBook', 1234, 23, 'operativo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perifericos`
--

CREATE TABLE `perifericos` (
  `idPerifericos` int(11) NOT NULL,
  `marca` varchar(45) DEFAULT NULL,
  `modelo` varchar(45) DEFAULT NULL,
  `num_serie` int(11) DEFAULT NULL,
  `estado` enum('averiado','operativo') DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `fk_idAlumno` int(11) DEFAULT NULL,
  `fk_id_tipo_periferico` int(11) DEFAULT NULL,
  `fk_idAula` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

CREATE TABLE `profesor` (
  `idProfesor` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `fk_idUsuario` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesor`
--

INSERT INTO `profesor` (`idProfesor`, `nombre`, `apellidos`, `email`, `fk_idUsuario`) VALUES
(1, 'adrian', 'zuñiga', 'azuñigar@campusdigitalfp.com', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_periferico`
--

CREATE TABLE `tipo_periferico` (
  `id_tipo_periferico` int(11) NOT NULL,
  `tipo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_periferico`
--

INSERT INTO `tipo_periferico` (`id_tipo_periferico`, `tipo`) VALUES
(1, 'cargador'),
(2, 'raton'),
(3, 'teclado'),
(4, 'pantalla');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `rol` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `usuario`, `password`, `rol`) VALUES
(1, 'david', '$2y$10$ABe9tNptllsbWx1HArqmNOFpauI973tuWhvzZnUxwhUxiSjU416wO', 'alumno'),
(3, 'admin', '$2y$10$WsDm.E.0pcRfc8NXi.W8PePh2h6riF2/OX5BLEopHncNF/Cori.S6', 'administrador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`idAlumno`),
  ADD KEY `ordenador_idordenador` (`fk_idOrdenador_alumno`),
  ADD KEY `Usuario_idUsuario` (`fk_idUsuario_alumno`),
  ADD KEY `aula_idaula` (`fk_idAula_alumno`);

--
-- Indices de la tabla `aulas`
--
ALTER TABLE `aulas`
  ADD PRIMARY KEY (`idAula`);

--
-- Indices de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  ADD PRIMARY KEY (`idMantenimiento`),
  ADD KEY `alumno_idalumno` (`fk_idAlumno`),
  ADD KEY `mantenimiento_Ordenador` (`fk_idOrdenador`),
  ADD KEY `mantenimiento_Periferico` (`fk_idPeriferico`);

--
-- Indices de la tabla `ordenadores`
--
ALTER TABLE `ordenadores`
  ADD PRIMARY KEY (`idOrdenador`),
  ADD KEY `fk_Aula_ordenador` (`fk_idAula`);

--
-- Indices de la tabla `perifericos`
--
ALTER TABLE `perifericos`
  ADD PRIMARY KEY (`idPerifericos`),
  ADD KEY `alumno_idalumno` (`fk_idAlumno`),
  ADD KEY `id_tipo_periferico` (`fk_id_tipo_periferico`),
  ADD KEY `fk_Aula_periferico` (`fk_idAula`);

--
-- Indices de la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`idProfesor`);

--
-- Indices de la tabla `tipo_periferico`
--
ALTER TABLE `tipo_periferico`
  ADD PRIMARY KEY (`id_tipo_periferico`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `idAlumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `aulas`
--
ALTER TABLE `aulas`
  MODIFY `idAula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  MODIFY `idMantenimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `ordenadores`
--
ALTER TABLE `ordenadores`
  MODIFY `idOrdenador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `perifericos`
--
ALTER TABLE `perifericos`
  MODIFY `idPerifericos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `profesor`
--
ALTER TABLE `profesor`
  MODIFY `idProfesor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tipo_periferico`
--
ALTER TABLE `tipo_periferico`
  MODIFY `id_tipo_periferico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `alumnos_ibfk_1` FOREIGN KEY (`fk_idOrdenador_alumno`) REFERENCES `ordenadores` (`idOrdenador`),
  ADD CONSTRAINT `alumnos_ibfk_2` FOREIGN KEY (`fk_idUsuario_alumno`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `alumnos_ibfk_3` FOREIGN KEY (`fk_idAula_alumno`) REFERENCES `aulas` (`idAula`);

--
-- Filtros para la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  ADD CONSTRAINT `mantenimiento_Ordenador` FOREIGN KEY (`fk_idOrdenador`) REFERENCES `ordenadores` (`idOrdenador`),
  ADD CONSTRAINT `mantenimiento_Periferico` FOREIGN KEY (`fk_idPeriferico`) REFERENCES `perifericos` (`idPerifericos`),
  ADD CONSTRAINT `mantenimiento_ibfk_1` FOREIGN KEY (`fk_idAlumno`) REFERENCES `alumnos` (`idAlumno`);

--
-- Filtros para la tabla `ordenadores`
--
ALTER TABLE `ordenadores`
  ADD CONSTRAINT `fk_Aula_ordenador` FOREIGN KEY (`fk_idAula`) REFERENCES `aulas` (`idAula`);

--
-- Filtros para la tabla `perifericos`
--
ALTER TABLE `perifericos`
  ADD CONSTRAINT `fk_Alumno_periferico` FOREIGN KEY (`fk_idAlumno`) REFERENCES `alumnos` (`idAlumno`),
  ADD CONSTRAINT `fk_Aula_periferico` FOREIGN KEY (`fk_idAula`) REFERENCES `aulas` (`idAula`),
  ADD CONSTRAINT `fk_TipoPeriderico_alumno` FOREIGN KEY (`fk_id_tipo_periferico`) REFERENCES `tipo_periferico` (`id_tipo_periferico`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
