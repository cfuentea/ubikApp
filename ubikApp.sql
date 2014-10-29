/*
 Navicat MySQL Data Transfer

 Source Server         : Local
 Source Server Type    : MySQL
 Source Server Version : 50529
 Source Host           : localhost
 Source Database       : ubikApp

 Target Server Type    : MySQL
 Target Server Version : 50529
 File Encoding         : utf-8

 Date: 10/29/2014 01:49:20 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `Campana`
-- ----------------------------
DROP TABLE IF EXISTS `Campana`;
CREATE TABLE `Campana` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Empresa_id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` longtext,
  `fechaIngreso` datetime DEFAULT NULL,
  `distanciaCampana` int(11) DEFAULT NULL,
  `fechaInicio` datetime DEFAULT NULL,
  `fechaFin` datetime DEFAULT NULL,
  `imagen1` varchar(45) DEFAULT NULL,
  `imagen2` varchar(45) DEFAULT NULL,
  `imagen3` varchar(45) DEFAULT NULL,
  `multipleCampana` int(11) NOT NULL DEFAULT '0',
  `Estado_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Campana_estado1_idx` (`Estado_id`),
  KEY `fk_Campana_Empresa1_idx` (`Empresa_id`),
  CONSTRAINT `fk_Campana_Empresa1` FOREIGN KEY (`Empresa_id`) REFERENCES `Empresa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Campana_estado1` FOREIGN KEY (`Estado_id`) REFERENCES `Estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `CampanaCategoria`
-- ----------------------------
DROP TABLE IF EXISTS `CampanaCategoria`;
CREATE TABLE `CampanaCategoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Categoria_id` int(11) NOT NULL,
  `Campana_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_CampanaCategoria_Categoria1_idx` (`Categoria_id`),
  KEY `fk_CampanaCategoria_Campana1_idx` (`Campana_id`),
  CONSTRAINT `fk_CampanaCategoria_Campana1` FOREIGN KEY (`Campana_id`) REFERENCES `Campana` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_CampanaCategoria_Categoria1` FOREIGN KEY (`Categoria_id`) REFERENCES `Categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `CampanaSucursal`
-- ----------------------------
DROP TABLE IF EXISTS `CampanaSucursal`;
CREATE TABLE `CampanaSucursal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Sucursal_id` int(11) NOT NULL,
  `Campana_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_CampanaSucursal_Sucursal1_idx` (`Sucursal_id`),
  KEY `fk_CampanaSucursal_Campana1_idx` (`Campana_id`),
  CONSTRAINT `fk_CampanaSucursal_Campana1` FOREIGN KEY (`Campana_id`) REFERENCES `Campana` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_CampanaSucursal_Sucursal1` FOREIGN KEY (`Sucursal_id`) REFERENCES `Sucursal` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `Categoria`
-- ----------------------------
DROP TABLE IF EXISTS `Categoria`;
CREATE TABLE `Categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `ownerIngreso` varchar(100) DEFAULT NULL,
  `fechaIngreso` datetime DEFAULT NULL,
  `ownerEdicion` varchar(100) DEFAULT NULL,
  `fechaEdicion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `Ciudad`
-- ----------------------------
DROP TABLE IF EXISTS `Ciudad`;
CREATE TABLE `Ciudad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `Pais_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ciudad_pais1_idx` (`Pais_id`),
  CONSTRAINT `fk_ciudad_pais1` FOREIGN KEY (`Pais_id`) REFERENCES `Pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `Ciudad`
-- ----------------------------
BEGIN;
INSERT INTO `Ciudad` VALUES ('1', 'Santiago', '1');
COMMIT;

-- ----------------------------
--  Table structure for `Comuna`
-- ----------------------------
DROP TABLE IF EXISTS `Comuna`;
CREATE TABLE `Comuna` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `Ciudad_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comuna_ciudad1_idx` (`Ciudad_id`),
  CONSTRAINT `fk_comuna_ciudad1` FOREIGN KEY (`Ciudad_id`) REFERENCES `Ciudad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `Comuna`
-- ----------------------------
BEGIN;
INSERT INTO `Comuna` VALUES ('1', 'Santiago', '1');
COMMIT;

-- ----------------------------
--  Table structure for `Empresa`
-- ----------------------------
DROP TABLE IF EXISTS `Empresa`;
CREATE TABLE `Empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `nombreFantasia` varchar(50) DEFAULT NULL,
  `rut` varchar(15) DEFAULT NULL,
  `direccionCasaCentral` varchar(100) DEFAULT NULL,
  `telefonoFijo` varchar(15) DEFAULT NULL,
  `telefonoFax` varchar(15) DEFAULT NULL,
  `representanteLegal` varchar(255) DEFAULT NULL,
  `emailContacto` varchar(100) DEFAULT NULL,
  `fechaIngreso` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `Estado`
-- ----------------------------
DROP TABLE IF EXISTS `Estado`;
CREATE TABLE `Estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombreEstado` varchar(100) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL COMMENT 'Esta tabla mantendrá todos los códigos de estados para los distintos tipos de datos.\nel orden de los códigos son:\n000 - 099: Códigos de usuario\n100 - 199: Códigos de Campañas\n200 - 299: Códigos de Empresas',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `Pais`
-- ----------------------------
DROP TABLE IF EXISTS `Pais`;
CREATE TABLE `Pais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `Pais`
-- ----------------------------
BEGIN;
INSERT INTO `Pais` VALUES ('1', 'Chile');
COMMIT;

-- ----------------------------
--  Table structure for `Sucursal`
-- ----------------------------
DROP TABLE IF EXISTS `Sucursal`;
CREATE TABLE `Sucursal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `dirección` varchar(100) DEFAULT NULL,
  `Comuna_id` int(11) NOT NULL,
  `tipoSucursal` varchar(45) DEFAULT NULL,
  `fechaIngreso` datetime DEFAULT NULL,
  `ownerIngreso` varchar(45) DEFAULT NULL,
  `latitud` int(11) DEFAULT NULL,
  `longitud` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sucursalEmpresa_comuna1_idx` (`Comuna_id`),
  CONSTRAINT `fk_sucursalEmpresa_comuna1` FOREIGN KEY (`Comuna_id`) REFERENCES `Comuna` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `Usuario`
-- ----------------------------
DROP TABLE IF EXISTS `Usuario`;
CREATE TABLE `Usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(45) DEFAULT NULL,
  `apellidos` varchar(45) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fechaNacimiento` date DEFAULT NULL,
  `Comuna_id` int(11) NOT NULL,
  `password` varchar(45) DEFAULT NULL,
  `hashValidacion` varchar(45) DEFAULT NULL,
  `fechaRegistro` datetime DEFAULT NULL,
  `ultimoAcceso` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_usuarios_comuna1_idx` (`Comuna_id`),
  CONSTRAINT `fk_usuarios_comuna1` FOREIGN KEY (`Comuna_id`) REFERENCES `Comuna` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `Usuario`
-- ----------------------------
BEGIN;
INSERT INTO `Usuario` VALUES ('1', 'Paulina', 'Bulboa', 'paulibulboa@gmail.com', '2010-10-07', '1', null, null, '2014-10-24 22:06:17', '2014-10-24 22:06:27'), ('2', 'Carlos', 'Fuentealba', 'carlosfuentealba@gmail.com', '2007-05-10', '1', null, null, '2014-10-29 01:10:30', null), ('3', 'Juan', 'Perez', 'juan@perez.com', null, '1', null, null, null, null), ('4', 'Juan', 'Perez', 'juan@perez.com', null, '1', null, null, null, null);
COMMIT;

-- ----------------------------
--  Table structure for `UsuarioCampana`
-- ----------------------------
DROP TABLE IF EXISTS `UsuarioCampana`;
CREATE TABLE `UsuarioCampana` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Usuario_id` int(11) NOT NULL,
  `Campana_id` varchar(45) DEFAULT NULL,
  `Categoria_id` varchar(45) DEFAULT NULL,
  `fechaUso` date DEFAULT NULL,
  `fechaEliminacion` date DEFAULT NULL,
  `valoracion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_UsuarioCampana_Usuario1_idx` (`Usuario_id`),
  CONSTRAINT `fk_UsuarioCampana_Usuario1` FOREIGN KEY (`Usuario_id`) REFERENCES `Usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `marcaProductos`
-- ----------------------------
DROP TABLE IF EXISTS `marcaProductos`;
CREATE TABLE `marcaProductos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `ownerIngreso` varchar(45) DEFAULT NULL,
  `fechaIngreso` varchar(45) DEFAULT NULL,
  `ownerEdicion` varchar(45) DEFAULT NULL,
  `fechaEdicion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
