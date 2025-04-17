-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: mysql
-- Tiempo de generación: 16-04-2025 a las 20:33:09
-- Versión del servidor: 5.7.44
-- Versión de PHP: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `isla_transfers`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transfer_admin`
--

CREATE TABLE `transfer_admin` (
  `id_admin` int(11) NOT NULL,
  `email_admin` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `transfer_admin`
--

INSERT INTO `transfer_admin` (`id_admin`, `email_admin`, `password`) VALUES
(1, 'gagoxyz@admin.com', '1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transfer_hotel`
--

CREATE TABLE `transfer_hotel` (
  `id_hotel` int(11) NOT NULL,
  `nombre_hotel` varchar(100) DEFAULT NULL,
  `id_zona` int(11) DEFAULT NULL,
  `comision` decimal(10,2) DEFAULT NULL,
  `email_hotel` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `transfer_hotel`
--

INSERT INTO `transfer_hotel` (`id_hotel`, `nombre_hotel`, `id_zona`, `comision`, `email_hotel`, `password`) VALUES
(1, 'Hotel Paradise', 1, 10.99, 'hotel@paradise.com', '1234'),
(2, 'Mandarín Oriental', 2, 20.99, 'hotel@mandarinoriental.com', '1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transfer_precios`
--

CREATE TABLE `transfer_precios` (
  `id_precios` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL,
  `id_hotel` int(11) NOT NULL,
  `Precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transfer_reservas`
--

CREATE TABLE `transfer_reservas` (
  `id_reserva` int(11) NOT NULL,
  `localizador` varchar(100) NOT NULL,
  `id_hotel` int(11) DEFAULT NULL COMMENT 'Es el hotel que realiza la reserva',
  `id_tipo_reserva` int(11) DEFAULT NULL,
  `email_cliente` varchar(100) NOT NULL,
  `fecha_reserva` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_modificacion` datetime DEFAULT NULL,
  `id_destino` int(11) DEFAULT NULL,
  `fecha_entrada` date DEFAULT NULL,
  `hora_entrada` time DEFAULT NULL,
  `numero_vuelo_entrada` varchar(50) DEFAULT NULL,
  `origen_vuelo_entrada` varchar(50) DEFAULT NULL,
  `hora_vuelo_salida` time DEFAULT NULL,
  `fecha_vuelo_salida` date DEFAULT NULL,
  `hora_recogida_salida` time DEFAULT NULL,
  `num_viajeros` int(11) NOT NULL,
  `id_vehiculo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `transfer_reservas`
--

INSERT INTO `transfer_reservas` (`id_reserva`, `localizador`, `id_hotel`, `id_tipo_reserva`, `email_cliente`, `fecha_reserva`, `fecha_modificacion`, `id_destino`, `fecha_entrada`, `hora_entrada`, `numero_vuelo_entrada`, `origen_vuelo_entrada`, `hora_vuelo_salida`, `fecha_vuelo_salida`, `hora_recogida_salida`, `num_viajeros`, `id_vehiculo`) VALUES
(27, 'ai9FC2m', NULL, 1, 'david@uoc.edu', '2025-04-14 13:29:54', NULL, 2, '2025-04-17', '19:30:00', 'RY221', 'BARCELONA', '04:29:00', '2025-04-20', '01:27:00', 3, 1),
(33, 'IVqnvkd', NULL, 1, 'maria@uoc.edu', '2025-04-15 11:37:22', '2025-04-16 15:18:47', 2, '2025-04-17', '18:42:00', 'AAA123', 'SEVILLA', NULL, NULL, NULL, 4, 1),
(37, 'mX64uJH', NULL, 3, 'maria@uoc.edu', '2025-04-15 13:30:07', NULL, 1, NULL, NULL, 'FLY123', NULL, '16:30:00', '2025-04-16', '14:29:00', 3, 1),
(43, 'UbTFuab', NULL, 1, 'maria@uoc.edu', '2025-04-16 18:42:47', '2025-04-16 18:44:24', 1, '2025-04-30', '00:46:00', 'QW221', 'MADRID', NULL, NULL, NULL, 15, 2),
(44, '7yq3E9g', NULL, 1, 'maria@uoc.edu', '2025-04-16 18:43:05', NULL, 2, '2025-04-24', '21:43:00', 'XYZ012', 'ZARAGOZA', NULL, NULL, NULL, 2, 1),
(45, 'xS1bdWj', NULL, 3, 'maria@uoc.edu', '2025-04-16 18:46:06', NULL, 2, '2025-04-25', '23:48:00', 'FLY123', 'BARCELONA', NULL, NULL, NULL, 3, 1),
(46, 'cxLMFN1', NULL, 1, 'david@uoc.edu', '2025-04-16 19:31:37', '2025-04-16 19:43:29', 1, NULL, NULL, NULL, NULL, '08:33:00', '2025-04-19', '07:31:00', 14, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transfer_tipo_reserva`
--

CREATE TABLE `transfer_tipo_reserva` (
  `id_tipo_reserva` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `transfer_tipo_reserva`
--

INSERT INTO `transfer_tipo_reserva` (`id_tipo_reserva`, `descripcion`) VALUES
(1, 'Cliente'),
(2, 'Hotel'),
(3, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transfer_vehiculo`
--

CREATE TABLE `transfer_vehiculo` (
  `id_vehiculo` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `email_conductor` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `transfer_vehiculo`
--

INSERT INTO `transfer_vehiculo` (`id_vehiculo`, `descripcion`, `email_conductor`, `password`) VALUES
(1, 'Mercedes 7 plazas', 'conductor1@email.com', '1234'),
(2, 'Volvo 20 plazas', 'conductor2@email.com', '1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transfer_viajeros`
--

CREATE TABLE `transfer_viajeros` (
  `id_viajero` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido1` varchar(100) NOT NULL,
  `apellido2` varchar(100) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `codigoPostal` varchar(100) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `transfer_viajeros`
--

INSERT INTO `transfer_viajeros` (`id_viajero`, `nombre`, `apellido1`, `apellido2`, `direccion`, `codigoPostal`, `ciudad`, `pais`, `email`, `password`) VALUES
(1, 'David', 'Gago', 'Criado', 'Calle X 123', '08520', 'Barcelona', 'España', 'david@uoc.edu', '1234'),
(2, 'Maria', 'Rovira', 'Hola', 'Calle sin nombre X', '12345', 'Barcelona', 'España', 'maria@uoc.edu', '1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transfer_zona`
--

CREATE TABLE `transfer_zona` (
  `id_zona` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `transfer_zona`
--

INSERT INTO `transfer_zona` (`id_zona`, `descripcion`) VALUES
(1, 'Zona 1'),
(2, 'Zona 2');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `transfer_admin`
--
ALTER TABLE `transfer_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indices de la tabla `transfer_hotel`
--
ALTER TABLE `transfer_hotel`
  ADD PRIMARY KEY (`id_hotel`),
  ADD KEY `FK_HOTEL_ZONA` (`id_zona`);

--
-- Indices de la tabla `transfer_precios`
--
ALTER TABLE `transfer_precios`
  ADD PRIMARY KEY (`id_precios`),
  ADD KEY `FK_PRECIOS_HOTEL` (`id_hotel`),
  ADD KEY `FK_PRECIOS_VEHICULO` (`id_vehiculo`);

--
-- Indices de la tabla `transfer_reservas`
--
ALTER TABLE `transfer_reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `FK_RESERVAS_DESTINO` (`id_destino`),
  ADD KEY `FK_RESERVAS_HOTEL` (`id_hotel`),
  ADD KEY `FK_RESERVAS_TIPO` (`id_tipo_reserva`),
  ADD KEY `FK_RESERVAS_VEHICULO` (`id_vehiculo`);

--
-- Indices de la tabla `transfer_tipo_reserva`
--
ALTER TABLE `transfer_tipo_reserva`
  ADD PRIMARY KEY (`id_tipo_reserva`);

--
-- Indices de la tabla `transfer_vehiculo`
--
ALTER TABLE `transfer_vehiculo`
  ADD PRIMARY KEY (`id_vehiculo`);

--
-- Indices de la tabla `transfer_viajeros`
--
ALTER TABLE `transfer_viajeros`
  ADD PRIMARY KEY (`id_viajero`);

--
-- Indices de la tabla `transfer_zona`
--
ALTER TABLE `transfer_zona`
  ADD PRIMARY KEY (`id_zona`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `transfer_admin`
--
ALTER TABLE `transfer_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `transfer_hotel`
--
ALTER TABLE `transfer_hotel`
  MODIFY `id_hotel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `transfer_reservas`
--
ALTER TABLE `transfer_reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `transfer_tipo_reserva`
--
ALTER TABLE `transfer_tipo_reserva`
  MODIFY `id_tipo_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `transfer_vehiculo`
--
ALTER TABLE `transfer_vehiculo`
  MODIFY `id_vehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `transfer_viajeros`
--
ALTER TABLE `transfer_viajeros`
  MODIFY `id_viajero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `transfer_zona`
--
ALTER TABLE `transfer_zona`
  MODIFY `id_zona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `transfer_hotel`
--
ALTER TABLE `transfer_hotel`
  ADD CONSTRAINT `FK_HOTEL_ZONA` FOREIGN KEY (`id_zona`) REFERENCES `transfer_zona` (`id_zona`);

--
-- Filtros para la tabla `transfer_precios`
--
ALTER TABLE `transfer_precios`
  ADD CONSTRAINT `FK_PRECIOS_HOTEL` FOREIGN KEY (`id_hotel`) REFERENCES `transfer_hotel` (`id_hotel`),
  ADD CONSTRAINT `FK_PRECIOS_VEHICULO` FOREIGN KEY (`id_vehiculo`) REFERENCES `transfer_vehiculo` (`id_vehiculo`);

--
-- Filtros para la tabla `transfer_reservas`
--
ALTER TABLE `transfer_reservas`
  ADD CONSTRAINT `FK_RESERVAS_DESTINO` FOREIGN KEY (`id_destino`) REFERENCES `transfer_hotel` (`id_hotel`),
  ADD CONSTRAINT `FK_RESERVAS_HOTEL` FOREIGN KEY (`id_hotel`) REFERENCES `transfer_hotel` (`id_hotel`),
  ADD CONSTRAINT `FK_RESERVAS_TIPO` FOREIGN KEY (`id_tipo_reserva`) REFERENCES `transfer_tipo_reserva` (`id_tipo_reserva`),
  ADD CONSTRAINT `FK_RESERVAS_VEHICULO` FOREIGN KEY (`id_vehiculo`) REFERENCES `transfer_vehiculo` (`id_vehiculo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
