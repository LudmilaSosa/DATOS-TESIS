-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 21-02-2026 a las 01:54:38
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `canchaalmen3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `idcliente` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) DEFAULT NULL,
  `telefono` int UNSIGNED DEFAULT NULL,
  `usuario_idusuario` int NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `anonimo` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`idcliente`),
  KEY `fk_cliente_usuario1_idx` (`usuario_idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idcliente`, `Nombre`, `telefono`, `usuario_idusuario`, `email`, `anonimo`) VALUES
(1, 'Cliente anónimo', NULL, 1, NULL, 0),
(2, 'Juan', 2664335351, 0, NULL, 0),
(3, 'Rosa', 12345667, 0, NULL, 0),
(4, 'pepe', 0, 1, NULL, 0),
(5, 'pepe', 0, 1, NULL, 0),
(6, 'luis ruben garcia', 2665239807, 3, 'luis11@gmail.com', 0),
(7, 'pepe r', 12345678, 4, 'pepe.yo@gmail.com', 0),
(8, 'alo', 1012929293, 5, 'alo@gmail.com', 0),
(9, 'knknknj', 4294967295, 6, 'jhjhh@jvhvhv.com', 0),
(10, 'juan', 2664890930, 1, NULL, 0),
(11, 'mama', 1234567890, 7, 'mama@gmail.com', 0),
(12, 'sofia aguero', 2664890930, 1, 'sofi1@gmail.com', 0),
(13, 'Ludmila sosa', 2664987349, 2, 'lqkndkqwn@mslkvs.com', 0),
(14, 'pepe', 123456789, 3, 'pepe@gmail.com', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dias_habilitados`
--

DROP TABLE IF EXISTS `dias_habilitados`;
CREATE TABLE IF NOT EXISTS `dias_habilitados` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dia_semana` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `dias_habilitados`
--

INSERT INTO `dias_habilitados` (`id`, `dia_semana`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dias_no_laborales`
--

DROP TABLE IF EXISTS `dias_no_laborales`;
CREATE TABLE IF NOT EXISTS `dias_no_laborales` (
  `iddias_no_laborales` date NOT NULL,
  PRIMARY KEY (`iddias_no_laborales`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

DROP TABLE IF EXISTS `estados`;
CREATE TABLE IF NOT EXISTS `estados` (
  `idestados` varchar(45) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idestados`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fecha`
--

DROP TABLE IF EXISTS `fecha`;
CREATE TABLE IF NOT EXISTS `fecha` (
  `idfecha` int NOT NULL AUTO_INCREMENT,
  `fechaN` date DEFAULT NULL,
  PRIMARY KEY (`idfecha`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `fecha`
--

INSERT INTO `fecha` (`idfecha`, `fechaN`) VALUES
(1, '2025-10-02'),
(2, '2025-10-01'),
(3, '2025-10-03'),
(4, '2025-10-18'),
(5, '2025-10-23'),
(6, '2025-10-07'),
(7, '2025-10-10'),
(8, '2025-10-31'),
(9, '2025-11-21'),
(10, '2025-11-19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hora`
--

DROP TABLE IF EXISTS `hora`;
CREATE TABLE IF NOT EXISTS `hora` (
  `idhora` int NOT NULL AUTO_INCREMENT,
  `hora` time DEFAULT NULL,
  PRIMARY KEY (`idhora`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `hora`
--

INSERT INTO `hora` (`idhora`, `hora`) VALUES
(1, '18:00:00'),
(2, '19:00:00'),
(3, '20:00:00'),
(4, '21:00:00'),
(5, '22:00:00'),
(6, '23:00:00'),
(7, '00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `idroles` int NOT NULL,
  `estado` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idroles`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idroles`, `estado`) VALUES
(1, 'administrador'),
(2, 'empleado'),
(3, 'cliente'),
(4, 'cliente anonimo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_turno`
--

DROP TABLE IF EXISTS `tipo_turno`;
CREATE TABLE IF NOT EXISTS `tipo_turno` (
  `idtipo_turno` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `precio` double DEFAULT NULL,
  PRIMARY KEY (`idtipo_turno`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `tipo_turno`
--

INSERT INTO `tipo_turno` (`idtipo_turno`, `nombre`, `precio`) VALUES
(1, 'Fútbol', 8000),
(2, 'Jockey', 7000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnos_dados`
--

DROP TABLE IF EXISTS `turnos_dados`;
CREATE TABLE IF NOT EXISTS `turnos_dados` (
  `idTurnos_Dados` int NOT NULL AUTO_INCREMENT,
  `fecha_idfecha` int NOT NULL,
  `hora_idhora` int NOT NULL,
  `cliente_idcliente` int NOT NULL,
  `tipo_turno_idtipo_turno` int NOT NULL,
  `estado` enum('pendiente','confirmado','cancelado') DEFAULT 'pendiente',
  `codigo_pago` varchar(50) DEFAULT NULL,
  `vencimiento_pago` datetime DEFAULT NULL,
  PRIMARY KEY (`idTurnos_Dados`),
  KEY `fk_Turnos_Dados_fecha_idx` (`fecha_idfecha`),
  KEY `fk_Turnos_Dados_hora1_idx` (`hora_idhora`),
  KEY `fk_Turnos_Dados_cliente1_idx` (`cliente_idcliente`),
  KEY `fk_turno_tipo` (`tipo_turno_idtipo_turno`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `turnos_dados`
--

INSERT INTO `turnos_dados` (`idTurnos_Dados`, `fecha_idfecha`, `hora_idhora`, `cliente_idcliente`, `tipo_turno_idtipo_turno`, `estado`, `codigo_pago`, `vencimiento_pago`) VALUES
(2, 2, 4, 2, 2, 'pendiente', NULL, NULL),
(3, 3, 3, 1, 1, 'pendiente', NULL, NULL),
(4, 4, 1, 1, 2, 'pendiente', NULL, NULL),
(5, 5, 3, 9, 1, 'pendiente', NULL, NULL),
(6, 6, 1, 10, 2, 'pendiente', NULL, NULL),
(7, 7, 3, 11, 1, 'pendiente', NULL, NULL),
(8, 8, 4, 1, 1, 'pendiente', NULL, NULL),
(9, 9, 3, 1, 1, 'pendiente', 'PAG-690c9cdd9708a', '2025-11-21 15:00:00'),
(10, 10, 3, 13, 1, 'pendiente', 'PAG-691d22ee7e272', '2025-11-19 15:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `idusuario` int NOT NULL AUTO_INCREMENT,
  `nomusuario` varchar(45) DEFAULT NULL,
  `contrasena` varchar(255) NOT NULL,
  `roles_idroles` int NOT NULL,
  PRIMARY KEY (`idusuario`),
  KEY `fk_usuario_roles1_idx` (`roles_idroles`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nomusuario`, `contrasena`, `roles_idroles`) VALUES
(1, 'sofia1', '$2y$10$wRoysF6HWs3U2OwE7X5mj.w.ctNPoTYwS/cnZEHny8VSpvtjayfqy', 2),
(2, 'ludmila', '$2y$10$lK8KYSydgE2tIBMi6tBVZOfwClrwGzuAl5hf1ba6.pf3t0WYteaW6', 1),
(3, 'pepito', '$2y$10$9i5mPq119HoRREgXWs7mh.0F7F6i497NhMxy.GVex56.PRU5EYt5q', 2);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `turnos_dados`
--
ALTER TABLE `turnos_dados`
  ADD CONSTRAINT `fk_turno_tipo` FOREIGN KEY (`tipo_turno_idtipo_turno`) REFERENCES `tipo_turno` (`idtipo_turno`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
