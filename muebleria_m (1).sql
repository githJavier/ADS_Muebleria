-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-12-2024 a las 23:09:36
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `muebleria_m`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boleta`
--

CREATE TABLE `boleta` (
  `idBoleta` int(11) NOT NULL,
  `numeroBoleta` varchar(12) NOT NULL,
  `fechaEmitida` date NOT NULL,
  `horaEmitida` time NOT NULL,
  `cajeroEmitida` varchar(200) NOT NULL,
  `impuesto` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `idTipoPago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL,
  `categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `categoria`) VALUES
(1, 'CAMAS'),
(2, 'COMODA'),
(3, 'ROPERO'),
(4, 'VELADORES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleboleta`
--

CREATE TABLE `detalleboleta` (
  `idDetalleBoleta` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precioUnitario` decimal(10,2) NOT NULL,
  `precioTotal` decimal(10,2) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `idBoleta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleproforma`
--

CREATE TABLE `detalleproforma` (
  `idDetalleProforma` int(11) NOT NULL,
  `idProforma` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precioUnitario` decimal(10,2) NOT NULL,
  `precioTotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `privilegio`
--

CREATE TABLE `privilegio` (
  `idPrivilegio` int(11) NOT NULL,
  `labelPrivilegio` varchar(255) NOT NULL,
  `pathPrivilegio` varchar(255) NOT NULL,
  `iconPrivilegio` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `privilegio`
--

INSERT INTO `privilegio` (`idPrivilegio`, `labelPrivilegio`, `pathPrivilegio`, `iconPrivilegio`, `name`) VALUES
(1, 'Emitir Proforma', '../../saleModule/EmitirProforma/getProforma.php', 'proforma.svg', 'btnEmitirProforma'),
(2, 'Visualizar Ventas', '../../saleModule/VisualizarVenta/getVisualizarVenta.php', 'ventas.svg', 'btnVisualizarVenta'),
(3, 'Emitir Boleta', '../../saleModule/EmitirBoleta/getBoleta.php', 'boleta.svg', 'btnEmitirBoleta'),
(4, 'Gestionar Productos', '../../adminModule/GestionarProductos/getGestionarProductos.php', 'productos.svg', 'btnGestionarProducto'),
(5, 'Gestionar Usuarios', '../../adminModule/GUP/getGUP.php', 'gup.svg', 'btnGUP');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idProducto` int(11) NOT NULL,
  `codigo` varchar(12) NOT NULL,
  `producto` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `imagen` varchar(100) NOT NULL,
  `estado` enum('Activo','Descontinuado') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idProducto`, `codigo`, `producto`, `precio`, `cantidad`, `imagen`, `estado`) VALUES
(1, 'MUEB00000001', 'cama de 1 plaza y media ', 750.00, 10, 'prueba.png', 'Activo'),
(2, 'MUEB00000002', 'Cama 2 Plazas', 1200.00, 37, 'prueba.png', 'Activo'),
(4, 'MUEB00000003', 'cama 2 Plazas con Alero', 1350.00, 50, 'prueba.png', 'Activo'),
(5, 'MUEB00000004', 'cama queen', 1400.00, 25, 'prueba.png', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productocategoria`
--

CREATE TABLE `productocategoria` (
  `idProductoCategoria` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productocategoria`
--

INSERT INTO `productocategoria` (`idProductoCategoria`, `idProducto`, `idCategoria`) VALUES
(1, 1, 1),
(2, 2, 1),
(4, 4, 1),
(5, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proforma`
--

CREATE TABLE `proforma` (
  `idProforma` int(11) NOT NULL,
  `numeroProforma` bigint(20) NOT NULL,
  `vendedorEmitida` varchar(200) NOT NULL,
  `fechaEmitida` date NOT NULL,
  `horaEmitida` time NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `impuesto` decimal(10,2) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idRol` int(11) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idRol`, `nombre_rol`, `descripcion`) VALUES
(1, 'Administrador', 'Rol con acceso total al sistema'),
(2, 'Cajero', 'Rol responsable de registrar ventas y emitir boletas'),
(3, 'Vendedor', 'Rol encargado de generar proformas y asistir a clientes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipopago`
--

CREATE TABLE `tipopago` (
  `idTipoPago` int(11) NOT NULL,
  `tipo` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipopago`
--

INSERT INTO `tipopago` (`idTipoPago`, `tipo`) VALUES
(1, 'EFECTIVO'),
(2, 'TARJETA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `correo` varchar(250) NOT NULL,
  `telefono` char(9) NOT NULL,
  `nombreUsuario` varchar(100) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `estado` bit(1) NOT NULL,
  `preguntaSeguridad` varchar(255) NOT NULL,
  `respuestaSeguridad` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `correo`, `telefono`, `nombreUsuario`, `clave`, `estado`, `preguntaSeguridad`, `respuestaSeguridad`) VALUES
(5, 'Pedro', 'Pablo ', '2113110142@untels.edu.pe', '954561597', 'javier', '2113110142', b'1', 'comida favorita', 'arroz con pollo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarioprivilegio`
--

CREATE TABLE `usuarioprivilegio` (
  `idUsuarioPrivilegio` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idPrivilegio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarioprivilegio`
--

INSERT INTO `usuarioprivilegio` (`idUsuarioPrivilegio`, `idUsuario`, `idPrivilegio`) VALUES
(12, 5, 1),
(13, 5, 2),
(14, 5, 3),
(15, 5, 4),
(16, 5, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariorol`
--

CREATE TABLE `usuariorol` (
  `idUsuarioRol` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idRol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuariorol`
--

INSERT INTO `usuariorol` (`idUsuarioRol`, `idUsuario`, `idRol`) VALUES
(5, 5, 1),
(6, 5, 2),
(7, 5, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `boleta`
--
ALTER TABLE `boleta`
  ADD PRIMARY KEY (`idBoleta`),
  ADD UNIQUE KEY `numeroBoleta` (`numeroBoleta`),
  ADD KEY `fk_boleta_tipoPago` (`idTipoPago`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `detalleboleta`
--
ALTER TABLE `detalleboleta`
  ADD PRIMARY KEY (`idDetalleBoleta`),
  ADD KEY `fk_detalleBoleta_producto` (`idProducto`),
  ADD KEY `fk_detalleBoleta_boleta` (`idBoleta`);

--
-- Indices de la tabla `detalleproforma`
--
ALTER TABLE `detalleproforma`
  ADD PRIMARY KEY (`idDetalleProforma`),
  ADD KEY `fk_detalleProforma_proforma` (`idProforma`),
  ADD KEY `fk_detalleProforma_producto` (`idProducto`);

--
-- Indices de la tabla `privilegio`
--
ALTER TABLE `privilegio`
  ADD PRIMARY KEY (`idPrivilegio`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idProducto`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `productocategoria`
--
ALTER TABLE `productocategoria`
  ADD PRIMARY KEY (`idProductoCategoria`),
  ADD KEY `fk_productoCategoria_producto` (`idProducto`),
  ADD KEY `fk_productoCategoria_categoria` (`idCategoria`);

--
-- Indices de la tabla `proforma`
--
ALTER TABLE `proforma`
  ADD PRIMARY KEY (`idProforma`),
  ADD UNIQUE KEY `numeroProforma` (`numeroProforma`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idRol`),
  ADD UNIQUE KEY `nombre_rol` (`nombre_rol`);

--
-- Indices de la tabla `tipopago`
--
ALTER TABLE `tipopago`
  ADD PRIMARY KEY (`idTipoPago`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD UNIQUE KEY `usuario` (`nombreUsuario`);

--
-- Indices de la tabla `usuarioprivilegio`
--
ALTER TABLE `usuarioprivilegio`
  ADD PRIMARY KEY (`idUsuarioPrivilegio`),
  ADD KEY `fk_usuarioPrivilegio_usuario` (`idUsuario`),
  ADD KEY `fk_usuarioPrivilegio_privilegio` (`idPrivilegio`);

--
-- Indices de la tabla `usuariorol`
--
ALTER TABLE `usuariorol`
  ADD PRIMARY KEY (`idUsuarioRol`),
  ADD KEY `fk_usuarioRol_usuario` (`idUsuario`),
  ADD KEY `fk_usuarioRol_rol` (`idRol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `boleta`
--
ALTER TABLE `boleta`
  MODIFY `idBoleta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detalleboleta`
--
ALTER TABLE `detalleboleta`
  MODIFY `idDetalleBoleta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalleproforma`
--
ALTER TABLE `detalleproforma`
  MODIFY `idDetalleProforma` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `privilegio`
--
ALTER TABLE `privilegio`
  MODIFY `idPrivilegio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `productocategoria`
--
ALTER TABLE `productocategoria`
  MODIFY `idProductoCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `proforma`
--
ALTER TABLE `proforma`
  MODIFY `idProforma` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipopago`
--
ALTER TABLE `tipopago`
  MODIFY `idTipoPago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarioprivilegio`
--
ALTER TABLE `usuarioprivilegio`
  MODIFY `idUsuarioPrivilegio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `usuariorol`
--
ALTER TABLE `usuariorol`
  MODIFY `idUsuarioRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `boleta`
--
ALTER TABLE `boleta`
  ADD CONSTRAINT `fk_boleta_tipoPago` FOREIGN KEY (`idTipoPago`) REFERENCES `tipopago` (`idTipoPago`);

--
-- Filtros para la tabla `detalleboleta`
--
ALTER TABLE `detalleboleta`
  ADD CONSTRAINT `fk_detalleBoleta_boleta` FOREIGN KEY (`idBoleta`) REFERENCES `boleta` (`idBoleta`),
  ADD CONSTRAINT `fk_detalleBoleta_producto` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`);

--
-- Filtros para la tabla `detalleproforma`
--
ALTER TABLE `detalleproforma`
  ADD CONSTRAINT `fk_detalleProforma_producto` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`),
  ADD CONSTRAINT `fk_detalleProforma_proforma` FOREIGN KEY (`idProforma`) REFERENCES `proforma` (`idProforma`);

--
-- Filtros para la tabla `productocategoria`
--
ALTER TABLE `productocategoria`
  ADD CONSTRAINT `fk_productoCategoria_categoria` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`),
  ADD CONSTRAINT `fk_productoCategoria_producto` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`);

--
-- Filtros para la tabla `usuarioprivilegio`
--
ALTER TABLE `usuarioprivilegio`
  ADD CONSTRAINT `fk_usuarioPrivilegio_privilegio` FOREIGN KEY (`idPrivilegio`) REFERENCES `privilegio` (`idPrivilegio`),
  ADD CONSTRAINT `fk_usuarioPrivilegio_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `usuariorol`
--
ALTER TABLE `usuariorol`
  ADD CONSTRAINT `fk_usuarioRol_rol` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`),
  ADD CONSTRAINT `fk_usuarioRol_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
