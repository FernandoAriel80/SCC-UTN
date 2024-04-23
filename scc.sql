
CREATE TABLE IF NOT EXISTS `scc`.`tipoArticulos` (
  `idTipoArticulos` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `descripcionTipoArticulos` VARCHAR(45) NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -------------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `scc`.`tipoestados` (
  `idEstado` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `descripcionEstado` VARCHAR(20) NOT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `scc`.`tipomedida` (
  `idTipoMedida` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nomenclatura` VARCHAR(20) NOT NULL,
  `descripcionMedida` VARCHAR(20) NOT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -------------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `scc`.`tipogenero` (
  `idTipoGenero` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `Descripcion` VARCHAR(50) NOT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `scc`.`talle` (
  `idTalle` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `descripcionTalle` varchar(20) NOT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `scc`.`colores` (
  `idColores` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `color` varchar(50) NOT NULL,
  `codigo` varchar(10) DEFAULT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `scc`.`pedidos` (
  `idPedido` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `fechaPedido` datetime DEFAULT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `scc`.`articulos` (
  `idArticulos` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `descripcionArticulo` varchar(50) NOT NULL,
  `idTipoMedida` int(11) NOT NULL,
  `unidadPorLote` int(11) NOT NULL,
  `precioPorUnidad` decimal(10,0) NOT NULL,
  `idTipoArticulos` int(11) DEFAULT NULL,
   CONSTRAINT `articulos_ibfk_1` FOREIGN KEY (`idTipoMedida`) REFERENCES `tipomedida` (`idTipoMedida`),
   CONSTRAINT `fk_articulos_tipoArticulos1` FOREIGN KEY (`idTipoArticulos`) REFERENCES `tipoarticulos` (`idTipoArticulos`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `scc`.`consumospedidos` (
  `idConsumoPedido` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idPedido` int(11) NOT NULL,
  `idArticulos` int(11) NOT NULL,
  `cantTotal` int(11) NOT NULL,
   CONSTRAINT `consumospedidos_ibfk_1` FOREIGN KEY (`idPedido`) REFERENCES `pedidos` (`idPedido`),
   CONSTRAINT `consumospedidos_ibfk_2` FOREIGN KEY (`idArticulos`) REFERENCES `articulos` (`idArticulos`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `scc`.`curva` (
  `idCurva` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idTalle` int(11) NOT NULL,
  `idTipoGenero` int(11) NOT NULL,
  `idTipoMedida` int(11) NOT NULL,
  `medidaHombro` int(11) NOT NULL,
  `medidaPecho` int(11) NOT NULL,
  `medidaCintura` int(11) NOT NULL,
  `medidaEspalda` int(11) NOT NULL,
  `medidaManga` int(11) NOT NULL,
  `medidaCuello` int(11) NOT NULL,
  CONSTRAINT `curva_ibfk_1` FOREIGN KEY (`idTalle`) REFERENCES `talle` (`idTalle`),
  CONSTRAINT `curva_ibfk_2` FOREIGN KEY (`idTipoGenero`) REFERENCES `tipogenero` (`idTipoGenero`),
  CONSTRAINT `curva_ibfk_3` FOREIGN KEY (`idTipoMedida`) REFERENCES `tipomedida` (`idTipoMedida`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `scc`.`curvaavios` (
  `idCurvaAvios` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idCurva` int(11) NOT NULL,
  `idArticulos` int(11) NOT NULL,
  `cantUnitaria` int(11) NOT NULL,
  CONSTRAINT `curvaavios_ibfk_1` FOREIGN KEY (`idCurva`) REFERENCES `curva` (`idCurva`),
  CONSTRAINT `curvaavios_ibfk_2` FOREIGN KEY (`idArticulos`) REFERENCES `articulos` (`idArticulos`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `scc`.`curvamaterial` (
  `idCurvaMaterial` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idTipoGenero` int(11) NOT NULL,
  `idArticulos` int(11) NOT NULL,
  `cantUnitaria` int(11) NOT NULL,
  CONSTRAINT `curvamaterial_ibfk_1` FOREIGN KEY (`idTipoGenero`) REFERENCES `tipogenero` (`idTipoGenero`),
  CONSTRAINT `curvamaterial_ibfk_2` FOREIGN KEY (`idArticulos`) REFERENCES `articulos` (`idArticulos`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `scc`.`movimientopedidoestado` (
 `idMovimiento` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
 `idPedido` int(11) NOT NULL,
 `idEstado` int(11) NOT NULL,
 `fechaActualizacion` datetime NOT NULL,
  CONSTRAINT `movimientopedidoestado_ibfk_1` FOREIGN KEY (`idEstado`) REFERENCES `tipoestados` (`idEstado`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `scc`.`pedidosdetalles` (
  `idPedidoDetalle` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `cantArticulo` int(11) NOT NULL,
  `cantConsumo` int(11) NOT NULL,
  `precioTotal` decimal(10,2) NOT NULL,
  `habilitado` tinyint(1) NOT NULL DEFAULT 1,
  `idEstado` int(11) DEFAULT 1,
  `idPedido` int(11) NOT NULL,
  `actualizacionFecha` datetime DEFAULT NULL,
  CONSTRAINT `fk_pedidosdetalles_pedidos1` FOREIGN KEY (`idPedido`) REFERENCES `pedidos` (`idPedido`),
  CONSTRAINT `pedidosdetalles_ibfk_1` FOREIGN KEY (`idEstado`) REFERENCES `tipoestados` (`idEstado`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `scc`.`renglondetalles` (
  `idRenglonDetalle` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idtalle` int(11) NOT NULL,
  `idTipoGenero` int(11) NOT NULL,
  `idColor` int(11) NOT NULL,
  `UnidadesTalle` int(11) NOT NULL,
  `idPedido` int(11) DEFAULT NULL,
  `idRenglon` int(11) DEFAULT NULL,
  CONSTRAINT `fk_TipoGenero` FOREIGN KEY (`idTipoGenero`) REFERENCES `tipogenero` (`idTipoGenero`),
  CONSTRAINT `fk_idColor` FOREIGN KEY (`idColor`) REFERENCES `colores` (`idColores`),
  CONSTRAINT `fk_idTalle` FOREIGN KEY (`idtalle`) REFERENCES `talle` (`idTalle`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `scc`.`renglones` (
  `idPedidoRenglon` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idPedido` int(11) NOT NULL,
  `idRenglon` int(11) NOT NULL,
  CONSTRAINT `fk_pedido` FOREIGN KEY (`idPedido`) REFERENCES `pedidos` (`idPedido`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -------------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `scc`.`stockmateriales` (
  `idStockMaterial` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `idArticulos` int(11) NOT NULL,
  `cantidadPorLote` DECIMAL(10, 5) NOT NULL,
  CONSTRAINT `stockmateriales_ibfk_1` FOREIGN KEY (`idArticulos`) REFERENCES `articulos` (`idArticulos`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -------------------------------------------------------------------------------

INSERT INTO `colores` (`color`,`codigo`) VALUES
('Rojo','dd303d'),
('Amarillo','fecb05'),
('Azul','485de3');

-- ------------------------------------------------------------------------------

INSERT INTO `talle` (`descripcionTalle`) VALUES
('S'),
('M'),
('L'),
('XL'),
('XXL');

-- -------------------------------------------------------------------------------

INSERT INTO `tipogenero` (`Descripcion`) VALUES
('Hombre'),
('Mujer');

-- -------------------------------------------------------------------------------

INSERT INTO `tipoestados` (`descripcionEstado`) VALUES
('No iniciado'),
('En proceso'),
('Suspendido'),
('Finalizado');

-- -------------------------------------------------------------------------------

INSERT INTO `tipomedida` (`nomenclatura`,`descripcionMedida`) VALUES
('centimetro','cm'),
('toneladas','t'),
('metros','mt'),
('unitario','u');

-- -------------------------------------------------------------------------------

INSERT INTO `tipoarticulos` (`descripcionTipoArticulos`) VALUES
('noAvio'),
('avio');

-- -------------------------------------------------------------------------------

INSERT INTO `articulos` (`descripcionArticulo`,`idTipoMedida`,`unidadPorLote`,`precioPorUnidad`,`idTipoArticulos`) VALUES
('tela',3,100,1300.0,1),
('hilo',3,100,78.0,2),
('botones',4,1000,6.5,2);

-- -------------------------------------------------------------------------------

INSERT INTO `curva` (`idTalle`,`idTipoGenero`,`idTipoMedida`,
`medidaCuello`,`medidaPecho`,`medidaCintura`,`medidaHombro`,`medidaEspalda`,`medidaManga`) VALUES
(1,1,1,36, 52,47,47,77,63),
(2,1,1,38, 55,50,49,77,64),
(3,1,1,40, 58,53,51,78,65),
(4,1,1,42, 61,56,53,79,66),
(5,1,1,44, 64,59,55,80,67),
(1,2,1,35, 90,74,38,60,65),
(2,2,1,37, 94,78,40,62,66),
(3,2,1,39, 98,82,40,63,67),
(4,2,1,41,102,84,42,64,68),
(5,2,1,43,104,86,43,65,69);

-- -------------------------------------------------------------------------------

INSERT INTO `stockmateriales` (`idArticulos`,`cantidadPorLote`) VALUES
(1,1000),
(2,1000),
(3,1000);
-- -------------------------------------------------------------------------------

INSERT INTO `curvamaterial` (`idTipoGenero`,`idArticulos`,`cantUnitaria`) VALUES
(1 ,2,120),
(1 ,3, 17),
(2 ,2,100),
(2 ,3, 16);

