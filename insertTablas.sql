
INSERT INTO `colores` (`color`,`codigo`) VALUES
('Rojo','dd303d'),
('Amarillo','fecb05'),
('Azul','485de3');


INSERT INTO `talle` (`descripcionTalle`) VALUES
('S'),
('M'),
('L'),
('XL'),
('XXL');

INSERT INTO `tipogenero` (`Descripcion`) VALUES
('Hombre'),
('Mujer');

INSERT INTO `tipoestados` (`descripcionEstado`) VALUES
('No iniciado'),
('En proceso'),
('Suspendido'),
('Finalizado');

INSERT INTO `tipomedida` (`nomenclatura`,`descripcionMedida`) VALUES
('centimetro','cm'),
('toneladas','t'),
('metros','mt'),
('unitario','u');


INSERT INTO `curva` (`idTalle`,`idTipoGenero`,`idTipoMedida`,
`medidaCuello`,`medidaPecho`,`medidaCintura`,`medidaHombro`,`medidaEspalda`,`medidaManga`) VALUES
(1,1,1,36.0,52.5,47.0,47.0,77.0,63.0),
(2,1,1,38.0,55.5,50.0,49.0,77.0,64.0),
(3,1,1,40.0,58.5,53.0,51.0,78.0,65.0),
(4,1,1,42.0,61.5,56.0,53.0,79.0,66.0),
(5,1,1,44.0,64.5,59.0,55.0,80.0,67.0),
(1,2,1,35.0,90.0,74.0,38.0,60.0,65.0),
(2,2,1,37.0,94.0,78.0,40.0,62.0,66.0),
(3,2,1,39.0,98.0,82.0,40.0,63.0,67.0),
(4,2,1,41.0,102.0,84.0,42.0,64.0,68.0),
(5,2,1,43.0,104.0,86.0,43.0,65.0,69.0);