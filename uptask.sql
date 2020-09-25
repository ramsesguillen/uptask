-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         5.7.24 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura para tabla uptask.proyectos
CREATE TABLE IF NOT EXISTS `proyectos` (
  `id_proyecto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_proyecto` varchar(100) NOT NULL,
  PRIMARY KEY (`id_proyecto`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla uptask.proyectos: ~10 rows (aproximadamente)
DELETE FROM `proyectos`;
/*!40000 ALTER TABLE `proyectos` DISABLE KEYS */;
INSERT INTO `proyectos` (`id_proyecto`, `nombre_proyecto`) VALUES
	(1, 'Tienda Virtual'),
	(2, 'Blog'),
	(3, 'Restaurant'),
	(4, 'Carrito de compras'),
	(5, 'Workshop'),
	(6, 'Sitio web'),
	(7, 'Crear APLI'),
	(8, 'Diseño logotipo'),
	(9, 'Diseño logotipo'),
	(10, 'Diseño de pagina web');
/*!40000 ALTER TABLE `proyectos` ENABLE KEYS */;

-- Volcando estructura para tabla uptask.tareas
CREATE TABLE IF NOT EXISTS `tareas` (
  `id_tarea` int(11) NOT NULL AUTO_INCREMENT,
  `id_proyecto` int(11) NOT NULL,
  `nombre_tarea` varchar(100) DEFAULT NULL,
  `estado` int(1) DEFAULT '0',
  PRIMARY KEY (`id_tarea`),
  KEY `FK_tareas_proyectos` (`id_proyecto`),
  CONSTRAINT `FK_tareas_proyectos` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos` (`id_proyecto`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla uptask.tareas: ~0 rows (aproximadamente)
DELETE FROM `tareas`;
/*!40000 ALTER TABLE `tareas` DISABLE KEYS */;
INSERT INTO `tareas` (`id_tarea`, `id_proyecto`, `nombre_tarea`, `estado`) VALUES
	(1, 2, 'Tomar fotografias', 0),
	(2, 3, 'Crear menu', 1),
	(3, 4, 'Crear el html', 0),
	(4, 7, 'Diseñar base de datos', 1),
	(5, 3, 'Editar fotografias', 1),
	(8, 3, 'Crear paleta de colores', 1),
	(9, 6, 'Crear proyecto', 0),
	(10, 8, 'Recortar esquinas', 0),
	(14, 10, 'cambiar colores', 0),
	(15, 3, 'Diseñar BD', 1),
	(16, 3, 'enivar propuestas', 0);
/*!40000 ALTER TABLE `tareas` ENABLE KEYS */;

-- Volcando estructura para tabla uptask.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla uptask.usuarios: ~0 rows (aproximadamente)
DELETE FROM `usuarios`;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`id_user`, `usuario`, `password`) VALUES
	(6, 'admin', '$2y$12$JyEI0XzN3.dibGf00IBgd.bMXh0lnWXcH/nrfEAA8Y0FNaNg.Ql3C');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
