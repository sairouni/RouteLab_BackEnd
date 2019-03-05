-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-03-2019 a las 12:51:30
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.10

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

--
-- Volcado de datos para la tabla `asociada`
--

INSERT INTO `asociada` (`idasociada`, `idlocalidad`, `idpost`) VALUES
(1, 1, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foto`
--

CREATE TABLE `foto` (
  `idpost` int(11) NOT NULL,
  `idlocalidad` int(11) NOT NULL,
  `url` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `foto`
--

INSERT INTO `foto` (`idpost`, `idlocalidad`, `url`) VALUES
(1, 1, 'c://hola que tal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localidad`
--

CREATE TABLE `localidad` (
  `idlocalidad` int(11) NOT NULL,
  `pais` varchar(50) NOT NULL,
  `poblacion` varchar(70) NOT NULL,
  `direccion` varchar(300) NOT NULL,
  `latitud` varchar(30) NOT NULL,
  `longitud` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `localidad`
--

INSERT INTO `localidad` (`idlocalidad`, `pais`, `poblacion`, `direccion`, `latitud`, `longitud`) VALUES
(1, 'Barcelona', '', '', '41', '2'),
(2, 'Barcelona', '', '', '41.390205', '2.154007'),
(3, 'España', 'Madrid', 'calle los santajos 2015', '45878', '7878'),
(4, 'Barcelona', 'MMA', 'holAQUE', '431', '2'),
(5, 'Barcelona', 'MMA', 'holAQUE', '431', '4848482');

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
(1, 4, 1, '2018-12-13', '10:30:00', 'SHola que tal'),
(2, 4, 1, '2018-12-13', '10:30:00', 'SHola vikcbkaiovbeiobv tal');

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
(1, 'La travesia en Argentina', ' en esta travesia seras bien chido', 'ruta', 4),
(3, 'Esta ruta mola supongo', 'Cuidado con la mega ruta', 'ruta', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recasociada`
--

CREATE TABLE `recasociada` (
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

--
-- Volcado de datos para la tabla `recomendaciones`
--

INSERT INTO `recomendaciones` (`idrec`, `icono`, `descripcion`) VALUES
(1, 'c://mmyserver/icono/correr.jpg', 'estae icono sirve para las rutas donde vas a correr ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `social`
--

CREATE TABLE `social` (
  `idsocial` int(11) NOT NULL,
  `idseguido` int(11) NOT NULL,
  `idseguidor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombreusuario` varchar(20) NOT NULL,
  `oauth_provider` varchar(15) DEFAULT NULL,
  `oauth_uid` varchar(25) DEFAULT NULL,
  `nombre` varchar(50) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `edad` int(11) NOT NULL,
  `telefono` varchar(16) NOT NULL,
  `idlocalidad` int(10) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `empresa` tinyint(1) NOT NULL,
  `nombre_empresa` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombreusuario`, `oauth_provider`, `oauth_uid`, `nombre`, `pass`, `email`, `edad`, `telefono`, `idlocalidad`, `admin`, `foto`, `empresa`, `nombre_empresa`) VALUES
(1, 'ismael campeador', NULL, NULL, 'ismael', 'isma12', 'ismael@gmail,com', 19971204, '0', 1, 1, 'url:C//feneuffe', 1, 'cacatua'),
(4, 'marc_elcampeador', NULL, NULL, 'marquitus', 'marcos', 'marc@gmail.com', 19200210, '0', 1, 0, 'jfiejfef', 1, 'Stucom'),
(5, 'ury95_elcampeador', NULL, NULL, 'oriol', '1234', 'elamo@gmail,com', 19950811, '0', 1, 0, 'url:C//feneuffe', 1, 'elamoSL'),
(7, 'Vecchio', NULL, NULL, 'Gianluca', '12345678', 'gianlucalvs@gmail.com', 0, '0', 1, 0, '/img.jpg', 1, 'Routelab'),
(9, 'Vecchio', NULL, NULL, 'Gianluca', '12345678', 'gianlucalvs@gmail.com', 0, '0', 1, 0, '/img.jpg', 1, 'Routelab'),
(10, 'ismatonto', NULL, NULL, 'ismatonto', '123456789', 'ismatonto@gmail.com', 0, '0', 1, 0, '/img.jpg', 1, 'Routelab'),
(11, 'ury95_elcampeador', NULL, NULL, 'oriol', '1234', 'elamo@gmail,com', 22, '632589658', 3, 0, 'url:C//feneuffe', 1, ''),
(14, 'gian', NULL, NULL, 'gian', '12345678', 'ismatonto3933823987@gmail.com', 21, '3232323232', 3, 0, '/img.jpg', 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoracion`
--

CREATE TABLE `valoracion` (
  `idusuario` int(11) NOT NULL,
  `idpost` int(11) NOT NULL,
  `valoracion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `valoracion`
--

INSERT INTO `valoracion` (`idusuario`, `idpost`, `valoracion`) VALUES
(1, 1, 5),
(4, 1, 7),
(5, 1, 8);

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
-- Indices de la tabla `recasociada`
--
ALTER TABLE `recasociada`
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
  ADD PRIMARY KEY (`idusuario`,`idpost`),
  ADD KEY `fkpostV` (`idpost`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asociada`
--
ALTER TABLE `asociada`
  MODIFY `idasociada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `localidad`
--
ALTER TABLE `localidad`
  MODIFY `idlocalidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `mensajeria`
--
ALTER TABLE `mensajeria`
  MODIFY `idmensajeria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `idpost` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `recasociada`
--
ALTER TABLE `recasociada`
  MODIFY `idrecpost` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recomendaciones`
--
ALTER TABLE `recomendaciones`
  MODIFY `idrec` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `social`
--
ALTER TABLE `social`
  MODIFY `idsocial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
-- Filtros para la tabla `recasociada`
--
ALTER TABLE `recasociada`
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
