-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for empresa
CREATE DATABASE IF NOT EXISTS `empresa` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `empresa`;

-- Dumping structure for table empresa.autor
CREATE TABLE IF NOT EXISTS `autor` (
  `idAutor` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `carnet` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`idAutor`),
  UNIQUE KEY `carnet` (`carnet`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

-- Dumping data for table empresa.autor: ~50 rows (approximately)
/*!40000 ALTER TABLE `autor` DISABLE KEYS */;
INSERT INTO `autor` (`idAutor`, `nombre`, `carnet`) VALUES
	(1, 'Welsh', 'LS451194'),
	(2, 'Paten', 'AJ481316'),
	(3, 'Prudence', 'CO912497'),
	(4, 'Liliane', 'UI547413'),
	(5, 'Chas', 'UQ404967'),
	(6, 'Phip', 'FO514800'),
	(7, 'Alyda', 'LW473714'),
	(8, 'Creigh', 'NU860376'),
	(9, 'Ingeborg', 'GV554960'),
	(10, 'Glennis', 'MR497434'),
	(11, 'Sergeant', 'YH553187'),
	(12, 'Reeva', 'OO559948'),
	(13, 'Sven', 'RP652901'),
	(14, 'Shalne', 'UN801851'),
	(15, 'Fonzie', 'JY084055'),
	(16, 'Lillian', 'LM478327'),
	(17, 'Beale', 'CB874391'),
	(18, 'Gherardo', 'IA848010'),
	(19, 'Bernardina', 'AA994865'),
	(20, 'Sheree', 'JE076314'),
	(21, 'Faustine', 'SW154115'),
	(22, 'Annora', 'QG519287'),
	(23, 'Manolo', 'HD791309'),
	(24, 'Wallis', 'VD204138'),
	(25, 'Zonda', 'JR027467'),
	(26, 'Jilleen', 'UL026002'),
	(27, 'Aron', 'MN476430'),
	(28, 'Lani', 'ZN353169'),
	(29, 'Garrik', 'HJ077130'),
	(30, 'Ardelia', 'MR110556'),
	(31, 'Analise', 'SG319107'),
	(32, 'Basilius', 'ME454534'),
	(33, 'Silvain', 'JV317312'),
	(34, 'Jeri', 'EP771659'),
	(35, 'Janene', 'XJ238036'),
	(36, 'Solly', 'OO542563'),
	(37, 'Berkie', 'RH020384'),
	(38, 'Milzie', 'BF900318'),
	(39, 'Eddie', 'YK251507'),
	(40, 'Rene', 'JD497322'),
	(41, 'Scarface', 'EA745025'),
	(42, 'Alexio', 'HT270737'),
	(43, 'Agneta', 'JF684679'),
	(44, 'Marlyn', 'BT038495'),
	(45, 'Aube', 'RB094388'),
	(46, 'Maddy', 'TS872567'),
	(47, 'Nickolas', 'TE284793'),
	(48, 'Wiley', 'BQ215097'),
	(49, 'Carr', 'VC882151'),
	(50, 'Devan', 'LE608450');
/*!40000 ALTER TABLE `autor` ENABLE KEYS */;

-- Dumping structure for table empresa.categoria
CREATE TABLE IF NOT EXISTS `categoria` (
  `idCategoria` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) NOT NULL,
  `estado` char(1) DEFAULT NULL,
  PRIMARY KEY (`idCategoria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table empresa.categoria: ~0 rows (approximately)
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;

-- Dumping structure for table empresa.orden
CREATE TABLE IF NOT EXISTS `orden` (
  `idComanda` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idCombo` bigint(20) NOT NULL,
  `descripcion` text NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` char(1) DEFAULT NULL,
  `fechaRegistro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fechaDespacho` datetime NOT NULL,
  PRIMARY KEY (`idComanda`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table empresa.orden: ~0 rows (approximately)
/*!40000 ALTER TABLE `orden` DISABLE KEYS */;
/*!40000 ALTER TABLE `orden` ENABLE KEYS */;

-- Dumping structure for table empresa.producto
CREATE TABLE IF NOT EXISTS `producto` (
  `idProducto` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `producto` varchar(100) NOT NULL,
  `estado` char(1) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `idCategoria` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`idProducto`),
  KEY `idCategoria_idx` (`idCategoria`),
  CONSTRAINT `idCategoria` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table empresa.producto: ~0 rows (approximately)
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;

-- Dumping structure for table empresa.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table empresa.usuario: ~0 rows (approximately)
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
