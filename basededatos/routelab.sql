-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-01-2019 a las 10:01:44
-- Versión del servidor: 10.1.26-MariaDB
-- Versión de PHP: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `routelab`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asociada`
--

CREATE TABLE `asociada` (
  `idasociada` int(11) NOT NULL,
  `idlocalidad` int(11) NOT NULL,
  `idpost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foto`
--

CREATE TABLE `foto` (
  `idpost` int(11) NOT NULL,
  `idlocalidad` int(11) NOT NULL,
  `urlFoto` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localidad`
--

CREATE TABLE `localidad` (
  `idlocalidad` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `latitud` float NOT NULL,
  `longitud` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `localidad`
--

INSERT INTO `localidad` (`idlocalidad`, `nombre`, `latitud`, `longitud`) VALUES
(1, 'Barcelona', 111, 111);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajeria`
--

CREATE TABLE `mensajeria` (
  `idmensajeria` int(11) NOT NULL,
  `idreceptor` int(11) NOT NULL,
  `idemisor` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `mensaje` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mensajeria`
--

INSERT INTO `mensajeria` (`idmensajeria`, `idreceptor`, `idemisor`, `fecha`, `hora`, `mensaje`) VALUES
(1, 2, 1, '2018-12-13', '10:30:00', 'hola'),
(2, 2, 1, '2018-12-13', '10:30:00', 'Send Nudes Pls'),
(3, 2, 1, '2018-12-13', '10:30:00', 'Hola que tal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

CREATE TABLE `post` (
  `idpost` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `tipo` varchar(25) NOT NULL,
  `idusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `post`
--

INSERT INTO `post` (`idpost`, `titulo`, `descripcion`, `tipo`, `idusuario`) VALUES
(1, 'Prueba', 'esta es una prueba de descripcion', 'ruta', 1),
(2, 'Hola', 'Muy Buenas', 'ruta', 2),
(3, 'Hola', 'Muy Buenas', 'ruta', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rec-post`
--

CREATE TABLE `rec-post` (
  `idrecpost` int(11) NOT NULL,
  `idpost` int(11) NOT NULL,
  `idrec` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recomendaciones`
--

CREATE TABLE `recomendaciones` (
  `idrec` int(11) NOT NULL,
  `icono` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `social`
--

CREATE TABLE `social` (
  `idsocial` int(11) NOT NULL,
  `idseguido` int(11) NOT NULL,
  `idseguidor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `social`
--

INSERT INTO `social` (`idsocial`, `idseguido`, `idseguidor`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombreusuario` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fechanacimiento` date NOT NULL,
  `idlocalidad` int(10) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `empresa` tinyint(4) NOT NULL,
  `nombre_empresa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombreusuario`, `nombre`, `pass`, `email`, `fechanacimiento`, `idlocalidad`, `admin`, `foto`, `empresa`, `nombre_empresa`) VALUES
(1, 'marc', 'marc', 'marc', 'marc@marc.com', '1998-07-04', 1, 0, '', 0, ''),
(2, 'isma', 'isma', 'isma', 'isma@isma.com', '1997-07-10', 1, 0, '', 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoracion`
--

CREATE TABLE `valoracion` (
  `idvaloracion` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idpost` int(11) NOT NULL,
  `valoracion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `valoracion`
--

INSERT INTO `valoracion` (`idvaloracion`, `idusuario`, `idpost`, `valoracion`) VALUES
(1, 1, 1, 5),
(2, 2, 1, 9),
(3, 2, 3, 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asociada`
--
ALTER TABLE `asociada`
  ADD PRIMARY KEY (`idasociada`),
  ADD KEY `fklocalidadA` (`idlocalidad`),
  ADD KEY `fkpostA` (`idpost`);

--
-- Indices de la tabla `foto`
--
ALTER TABLE `foto`
  ADD KEY `fkPostF` (`idpost`),
  ADD KEY `fklocalidadF` (`idlocalidad`);

--
-- Indices de la tabla `localidad`
--
ALTER TABLE `localidad`
  ADD PRIMARY KEY (`idlocalidad`);

--
-- Indices de la tabla `mensajeria`
--
ALTER TABLE `mensajeria`
  ADD PRIMARY KEY (`idmensajeria`),
  ADD KEY `fkreceptor` (`idreceptor`),
  ADD KEY `fkemisor` (`idemisor`);

--
-- Indices de la tabla `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`idpost`),
  ADD KEY `fkusuarioP` (`idusuario`);

--
-- Indices de la tabla `rec-post`
--
ALTER TABLE `rec-post`
  ADD PRIMARY KEY (`idrecpost`),
  ADD KEY `fkpostR` (`idpost`),
  ADD KEY `fkrecR` (`idrec`);

--
-- Indices de la tabla `recomendaciones`
--
ALTER TABLE `recomendaciones`
  ADD PRIMARY KEY (`idrec`);

--
-- Indices de la tabla `social`
--
ALTER TABLE `social`
  ADD PRIMARY KEY (`idsocial`),
  ADD KEY `fkseguido` (`idseguido`),
  ADD KEY `fkseguidor` (`idseguidor`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD KEY `fk_loca_u` (`idlocalidad`);

--
-- Indices de la tabla `valoracion`
--
ALTER TABLE `valoracion`
  ADD PRIMARY KEY (`idvaloracion`),
  ADD KEY `fkpostV` (`idpost`),
  ADD KEY `fkusuarioV` (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asociada`
--
ALTER TABLE `asociada`
  MODIFY `idasociada` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `localidad`
--
ALTER TABLE `localidad`
  MODIFY `idlocalidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `mensajeria`
--
ALTER TABLE `mensajeria`
  MODIFY `idmensajeria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `idpost` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `rec-post`
--
ALTER TABLE `rec-post`
  MODIFY `idrecpost` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `recomendaciones`
--
ALTER TABLE `recomendaciones`
  MODIFY `idrec` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `social`
--
ALTER TABLE `social`
  MODIFY `idsocial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `valoracion`
--
ALTER TABLE `valoracion`
  MODIFY `idvaloracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asociada`
--
ALTER TABLE `asociada`
  ADD CONSTRAINT `fklocalidadA` FOREIGN KEY (`idlocalidad`) REFERENCES `localidad` (`idlocalidad`),
  ADD CONSTRAINT `fkpostA` FOREIGN KEY (`idpost`) REFERENCES `post` (`idpost`);

--
-- Filtros para la tabla `foto`
--
ALTER TABLE `foto`
  ADD CONSTRAINT `fkPostF` FOREIGN KEY (`idpost`) REFERENCES `post` (`idpost`),
  ADD CONSTRAINT `fklocalidadF` FOREIGN KEY (`idlocalidad`) REFERENCES `localidad` (`idlocalidad`);

--
-- Filtros para la tabla `mensajeria`
--
ALTER TABLE `mensajeria`
  ADD CONSTRAINT `fkemisor` FOREIGN KEY (`idemisor`) REFERENCES `usuario` (`idusuario`),
  ADD CONSTRAINT `fkreceptor` FOREIGN KEY (`idreceptor`) REFERENCES `usuario` (`idusuario`);

--
-- Filtros para la tabla `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fkusuarioP` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`);

--
-- Filtros para la tabla `rec-post`
--
ALTER TABLE `rec-post`
  ADD CONSTRAINT `fkpostR` FOREIGN KEY (`idpost`) REFERENCES `post` (`idpost`),
  ADD CONSTRAINT `fkrecR` FOREIGN KEY (`idrec`) REFERENCES `recomendaciones` (`idrec`);

--
-- Filtros para la tabla `social`
--
ALTER TABLE `social`
  ADD CONSTRAINT `fkseguido` FOREIGN KEY (`idseguido`) REFERENCES `usuario` (`idusuario`),
  ADD CONSTRAINT `fkseguidor` FOREIGN KEY (`idseguidor`) REFERENCES `usuario` (`idusuario`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_loca_u` FOREIGN KEY (`idlocalidad`) REFERENCES `localidad` (`idlocalidad`);

--
-- Filtros para la tabla `valoracion`
--
ALTER TABLE `valoracion`
  ADD CONSTRAINT `fkpostV` FOREIGN KEY (`idpost`) REFERENCES `post` (`idpost`),
  ADD CONSTRAINT `fkusuarioV` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
