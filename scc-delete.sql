DELETE FROM pedidosdetalles;
DELETE FROM consumospedidos;
DELETE FROM renglondetalles;
DELETE FROM renglones;
DELETE FROM pedidos;
DELETE FROM movimientopedidoestado;

SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE pedidosdetalles AUTO_INCREMENT = 1;
ALTER TABLE consumospedidos AUTO_INCREMENT = 1;
ALTER TABLE renglondetalles AUTO_INCREMENT = 1;
ALTER TABLE renglones AUTO_INCREMENT = 1;
ALTER TABLE pedidos AUTO_INCREMENT = 1;
ALTER TABLE movimientopedidoestado AUTO_INCREMENT = 1;

SET FOREIGN_KEY_CHECKS = 1;
SET FOREIGN_KEY_CHECKS = 0;
SET FOREIGN_KEY_CHECKS = 1;

DELETE FROM stockmateriales;

SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE stockmateriales AUTO_INCREMENT = 1;

SET FOREIGN_KEY_CHECKS = 1;
SET FOREIGN_KEY_CHECKS = 0;
SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO `stockmateriales` (`idArticulos`,`cantidadPorLote`) VALUES
(1,1000),
(2,1000),
(3,1000);