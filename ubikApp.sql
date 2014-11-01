-- MySQL dump 10.13  Distrib 5.5.29, for osx10.6 (i386)
--
-- Host: localhost    Database: ubikapp_main
-- ------------------------------------------------------
-- Server version	5.5.29

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Campana`
--

DROP TABLE IF EXISTS `Campana`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Campana`
--

LOCK TABLES `Campana` WRITE;
/*!40000 ALTER TABLE `Campana` DISABLE KEYS */;
/*!40000 ALTER TABLE `Campana` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CampanaCategoria`
--

DROP TABLE IF EXISTS `CampanaCategoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CampanaCategoria`
--

LOCK TABLES `CampanaCategoria` WRITE;
/*!40000 ALTER TABLE `CampanaCategoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `CampanaCategoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CampanaSucursal`
--

DROP TABLE IF EXISTS `CampanaSucursal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CampanaSucursal`
--

LOCK TABLES `CampanaSucursal` WRITE;
/*!40000 ALTER TABLE `CampanaSucursal` DISABLE KEYS */;
/*!40000 ALTER TABLE `CampanaSucursal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Categoria`
--

DROP TABLE IF EXISTS `Categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Categoria`
--

LOCK TABLES `Categoria` WRITE;
/*!40000 ALTER TABLE `Categoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `Categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Ciudad`
--

DROP TABLE IF EXISTS `Ciudad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Ciudad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `Pais_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ciudad_pais1_idx` (`Pais_id`),
  CONSTRAINT `fk_ciudad_pais1` FOREIGN KEY (`Pais_id`) REFERENCES `Pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=223 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Ciudad`
--

LOCK TABLES `Ciudad` WRITE;
/*!40000 ALTER TABLE `Ciudad` DISABLE KEYS */;
INSERT INTO `Ciudad` VALUES (1,'Región de Tarapacá',1),(2,'Región de Antofagasta',1),(3,'Región de Atacama',1),(4,'Región de Coquimbo',1),(5,'Región de Valparaiso',1),(6,'Región del Libertador General Bernardo O Higg',1),(7,'Región del Maule',1),(8,'Región del Bío-Bío',1),(9,'Región de la Araucanía',1),(10,'Región de Los Lagos',1),(11,'Región de Aysén del General Carlos Ibáñez del',1),(12,'Región de Magallanes y la Antártica Chilena',1),(13,'Región Metropolitana',1),(14,'Región de Los Ríos',1),(15,'Región de Arica y Parinacota',1),(222,'Prueba',1);
/*!40000 ALTER TABLE `Ciudad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Comuna`
--

DROP TABLE IF EXISTS `Comuna`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Comuna` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `Ciudad_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comuna_ciudad1_idx` (`Ciudad_id`),
  CONSTRAINT `fk_comuna_ciudad1` FOREIGN KEY (`Ciudad_id`) REFERENCES `Ciudad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Comuna`
--

LOCK TABLES `Comuna` WRITE;
/*!40000 ALTER TABLE `Comuna` DISABLE KEYS */;
INSERT INTO `Comuna` VALUES (1,'ARICA',15),(2,'IQUIQUE',1),(3,'HUARA',1),(4,'PICA',1),(5,'POZO ALMONTE',1),(6,'TOCOPILLA',2),(7,'ANTOFAGASTA',2),(8,'MEJILLONES',2),(9,'TALTAL',2),(10,'CALAMA',2),(11,'CHAÑARAL',3),(12,'DIEGO DE ALMAGRO',3),(13,'COPIAPO',3),(14,'CALDERA',3),(15,'TIERRA AMARILLA',3),(16,'VALLENAR',3),(17,'FREIRINA',3),(18,'HUASCO',3),(19,'LA SERENA',4),(20,'LA HIGUERA',4),(21,'COQUIMBO',4),(22,'ANDACOLLO',4),(23,'VICUÑA',4),(24,'PAIHUANO',4),(25,'OVALLE',4),(26,'MONTE PATRIA',4),(27,'PUNITAQUI',4),(28,'RIO HURTADO',4),(29,'COMBARBALA',4),(30,'ILLAPEL',4),(31,'CANELA',4),(32,'SALAMANCA',4),(33,'LOS VILOS',4),(34,'VALPARAISO',5),(35,'QUINTERO',5),(36,'PUCHUNCAVI',5),(37,'VIÑA DEL MAR',5),(38,'QUILPUE',5),(39,'VILLA ALEMANA',5),(40,'CASABLANCA',5),(41,'ISLA DE PASCUA',5),(42,'SAN ANTONIO',5),(43,'SANTO DOMINGO',5),(44,'ALGARROBO',5),(45,'EL QUISCO',5),(46,'CARTAGENA',5),(47,'EL TABO',5),(48,'QUILLOTA',5),(49,'LA CRUZ',5),(50,'LA CALERA',5),(51,'HIJUELAS',5),(52,'NOGALES',5),(53,'LIMACHE',5),(54,'OLMUE',5),(55,'PETORCA',5),(56,'CABILDO',5),(57,'PAPUDO',5),(58,'ZAPALLAR',5),(59,'LA LIGUA',5),(60,'SAN FELIPE',5),(61,'PUTAENDO',5),(62,'PANQUEHUE',5),(63,'CATEMU',5),(64,'SANTA MARIA',5),(65,'LLAY LLAY',5),(66,'LOS ANDES',5),(67,'CALLE LARGA',5),(68,'RINCONADA',5),(69,'SAN ESTEBAN',5),(70,'SANTIAGO CENTRO',13),(71,'LAS CONDES',13),(72,'PROVIDENCIA',13),(73,'SANTIAGO OESTE',13),(75,'CONCHALI',13),(76,'COLINA',13),(77,'RENCA',13),(78,'LAMPA',13),(79,'QUILICURA',13),(80,'TIL-TIL',13),(81,'QUINTA NORMAL',13),(82,'PUDAHUEL',13),(83,'CURACAVI',13),(84,'SANTIAGO SUR',13),(85,'PEÑAFLOR',13),(86,'TALAGANTE',13),(87,'ISLA DE MAIPO',13),(88,'MELIPILLA',13),(89,'EL MONTE',13),(90,'MARIA PINTO',13),(91,'ÑUÑOA',13),(92,'LA REINA',13),(93,'LA FLORIDA',13),(94,'MAIPU',13),(95,'SAN MIGUEL',13),(96,'LA CISTERNA',13),(97,'LA GRANJA',13),(98,'SAN BERNARDO',13),(99,'CALERA DE TANGO',13),(100,'PUENTE ALTO',13),(101,'PIRQUE',13),(102,'SAN JOSE DE MAIPO',13),(103,'BUIN',13),(104,'PAINE',13),(105,'RANCAGUA',6),(106,'MACHALI',6),(107,'GRANEROS',6),(108,'SAN PEDRO',13),(109,'ALHUE',13),(110,'CODEGUA',6),(111,'SAN FRANCISCO DE MOSTAZAL',6),(112,'DOÑIHUE',6),(113,'COLTAUCO',6),(114,'COINCO',6),(115,'PEUMO',6),(116,'LAS CABRAS',6),(117,'SAN VICENTE',6),(118,'PICHIDEGUA',6),(119,'REQUINOA',6),(120,'OLIVAR',6),(121,'RENGO',6),(122,'MALLOA',6),(123,'QUINTA DE TILCOCO',6),(124,'SAN FERNANDO',6),(125,'CHIMBARONGO',6),(126,'NANCAGUA',6),(127,'PLACILLA',6),(128,'SANTA CRUZ',6),(129,'LOLOL',6),(130,'PALMILLA',6),(131,'PERALILLO',6),(132,'CHEPICA',6),(133,'PAREDONES',6),(134,'MARCHIGUE',6),(135,'PUMANQUE',6),(136,'LITUECHE',6),(137,'PICHILEMU',6),(138,'NAVIDAD',6),(139,'LA ESTRELLA',6),(140,'CURICO',7),(141,'ROMERAL',7),(142,'TENO',7),(143,'RAUCO',7),(144,'HUALAÑE',7),(145,'LICANTEN',7),(146,'VICHUQUEN',7),(147,'MOLINA',7),(148,'SAGRADA FAMILIA',7),(149,'RIO CLARO',7),(150,'TALCA',7),(151,'SAN CLEMENTE',7),(152,'PELARCO',7),(153,'PENCAHUE',7),(154,'MAULE',7),(155,'CUREPTO',7),(156,'SAN JAVIER',7),(157,'CONSTITUCION',7),(158,'EMPEDRADO',7),(159,'LINARES',7),(160,'YERBAS BUENAS',7),(161,'COLBUN',7),(162,'LONGAVI',7),(163,'VILLA ALEGRE',7),(164,'PARRAL',7),(165,'RETIRO',7),(166,'CAUQUENES',7),(167,'CHANCO',7),(168,'CHILLAN',8),(169,'PINTO',8),(170,'COIHUECO',8),(171,'PORTEZUELO',8),(172,'QUIRIHUE',8),(173,'TREHUACO',8),(174,'NINHUE',8),(175,'COBQUECURA',8),(176,'SAN CARLOS',8),(177,'SAN GREGORIO DE ÑIQUEN',8),(178,'SAN FABIAN',8),(179,'SAN NICOLAS',8),(180,'BULNES',8),(181,'SAN IGNACIO',8),(182,'QUILLON',8),(183,'YUNGAY',8),(184,'PEMUCO',8),(185,'EL CARMEN',8),(186,'COELEMU',8),(187,'RANQUIL',8),(188,'CONCEPCION',8),(189,'TALCAHUANO',8),(190,'TOME',8),(191,'PENCO',8),(192,'HUALQUI',8),(193,'FLORIDA',8),(194,'CORONEL',8),(195,'LOTA',8),(196,'SANTA JUANA',8),(197,'CURANILAHUE',8),(198,'ARAUCO',8),(199,'LEBU',8),(200,'LOS ALAMOS',8),(201,'CAÑETE',8),(202,'CONTULMO',8),(203,'TIRUA',8),(204,'LOS ANGELES',8),(205,'SANTA BARBARA',8),(206,'QUILLECO',8),(207,'YUMBEL',8),(208,'CABRERO',8),(209,'TUCAPEL',8),(210,'LAJA',8),(211,'SAN ROSENDO',8),(212,'NACIMIENTO',8),(213,'NEGRETE',8),(214,'MULCHEN',8),(215,'QUILACO',8),(216,'ANGOL',9),(217,'PUREN',9),(218,'LOS SAUCES',9),(219,'RENAICO',9),(220,'COLLIPULLI',9),(221,'ERCILLA',9),(222,'TRAIGUEN',9),(223,'LUMACO',9),(224,'VICTORIA',9),(225,'CURACAUTIN',9),(226,'LONQUIMAY',9),(227,'TEMUCO',9),(228,'VILCUN',9),(229,'FREIRE',9),(230,'CUNCO',9),(231,'LAUTARO',9),(232,'GALVARINO',9),(233,'PERQUENCO',9),(234,'NUEVA IMPERIAL',9),(235,'CARAHUE',9),(236,'PUERTO SAAVEDRA',9),(237,'PITRUFQUEN',9),(238,'GORBEA',9),(239,'TOLTEN',9),(240,'LONCOCHE',9),(241,'VILLARRICA',9),(242,'PUCON',9),(243,'VALDIVIA',14),(244,'CORRAL',14),(245,'MARIQUINA',14),(246,'MAFIL',14),(247,'LOS LAGOS',14),(248,'FUTRONO',14),(249,'LANCO',14),(250,'PANGUIPULLI',14),(251,'LA UNION',14),(252,'PAILLACO',14),(253,'RIO BUENO',14),(254,'LAGO RANCO',14),(255,'OSORNO',10),(256,'PUYEHUE',10),(257,'SAN PABLO',10),(258,'PUERTO OCTAY',10),(259,'RIO NEGRO',10),(260,'PURRANQUE',10),(261,'PUERTO MONTT',10),(262,'COCHAMO',10),(263,'MAULLIN',10),(264,'LOS MUERMOS',10),(265,'CALBUCO',10),(266,'PUERTO VARAS',10),(267,'LLANQUIHUE',10),(268,'FRESIA',10),(269,'FRUTILLAR',10),(270,'CASTRO',10),(271,'CHONCHI',10),(272,'QUEILEN',10),(273,'QUELLON',10),(274,'PUQUELDON',10),(275,'QUINCHAO',10),(276,'CURACO DE VELEZ',10),(277,'ANCUD',10),(278,'QUEMCHI',10),(279,'DALCAHUE',10),(280,'CHAITEN',10),(281,'FUTALEUFU',10),(282,'PALENA',10),(284,'COYHAIQUE',11),(285,'AYSEN',11),(286,'CISNES',11),(287,'CHILE CHICO',11),(288,'RIO IBAÑEZ',11),(289,'COCHRANE',11),(290,'PUNTA ARENAS',12),(291,'PUERTO NATALES',12),(292,'PORVENIR',12),(293,'GENERAL LAGOS',15),(294,'PUTRE',15),(295,'CAMARONES',15),(296,'CAMINA',1),(297,'COLCHANE',1),(298,'MARIA ELENA',2),(299,'SIERRA GORDA',2),(300,'OLLAGÜE',2),(301,'SAN PEDRO DE ATACAMA',2),(302,'ALTO DEL CARMEN',3),(303,'ANTUCO',8),(304,'MELIPEUCO',9),(305,'CURARREHUE',9),(306,'TEODORO SCHMIDT',9),(307,'SAN JUAN DE LA COSTA',10),(308,'HUALAIHUE',10),(309,'GUAITECAS',11),(310,'O´HIGGINS',11),(311,'TORTEL',11),(312,'LAGO VERDE',11),(313,'TORRES DEL PAINE',12),(314,'RIO VERDE',12),(315,'SAN GREGORIO',12),(316,'LAGUNA BLANCA',12),(317,'PRIMAVERA',12),(318,'TIMAUKEL',12),(319,'NAVARINO',12),(320,'PELLUHUE',7),(321,'JUAN FERNANDEZ',5),(322,'PEÑALOLEN',13),(323,'MACUL',13),(324,'CERRO NAVIA',13),(325,'LO PRADO',13),(326,'SAN RAMON',13),(327,'LA PINTANA',13),(328,'ESTACION CENTRAL',13),(329,'RECOLETA',13),(330,'INDEPENDENCIA',13),(331,'VITACURA',13),(332,'LO BARNECHEA',13),(333,'CERRILLOS',13),(334,'HUECHURABA',13),(335,'SAN JOAQUIN',13),(336,'PEDRO AGUIRRE CERDA',13),(337,'LO ESPEJO',13),(338,'EL BOSQUE',13),(339,'PADRE HURTADO',13),(340,'CONCON',5),(341,'SAN RAFAEL',7),(342,'CHILLAN VIEJO',8),(343,'SAN PEDRO DE LA PAZ',8),(344,'CHIGUAYANTE',8),(345,'PADRE LAS CASAS',9),(346,'ALTO HOSPICIO',1),(999,'Santiago',222);
/*!40000 ALTER TABLE `Comuna` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Empresa`
--

DROP TABLE IF EXISTS `Empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Empresa`
--

LOCK TABLES `Empresa` WRITE;
/*!40000 ALTER TABLE `Empresa` DISABLE KEYS */;
/*!40000 ALTER TABLE `Empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Estado`
--

DROP TABLE IF EXISTS `Estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombreEstado` varchar(100) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL COMMENT 'Esta tabla mantendrá todos los códigos de estados para los distintos tipos de datos.\nel orden de los códigos son:\n000 - 099: Códigos de usuario\n100 - 199: Códigos de Campañas\n200 - 299: Códigos de Empresas',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Estado`
--

LOCK TABLES `Estado` WRITE;
/*!40000 ALTER TABLE `Estado` DISABLE KEYS */;
/*!40000 ALTER TABLE `Estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Pais`
--

DROP TABLE IF EXISTS `Pais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Pais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pais`
--

LOCK TABLES `Pais` WRITE;
/*!40000 ALTER TABLE `Pais` DISABLE KEYS */;
INSERT INTO `Pais` VALUES (1,'Chile');
/*!40000 ALTER TABLE `Pais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Sucursal`
--

DROP TABLE IF EXISTS `Sucursal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Sucursal`
--

LOCK TABLES `Sucursal` WRITE;
/*!40000 ALTER TABLE `Sucursal` DISABLE KEYS */;
/*!40000 ALTER TABLE `Sucursal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Usuario`
--

DROP TABLE IF EXISTS `Usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Usuario`
--

LOCK TABLES `Usuario` WRITE;
/*!40000 ALTER TABLE `Usuario` DISABLE KEYS */;
INSERT INTO `Usuario` VALUES (1,'Paulina','Bulboa','paulibulboa@gmail.com','2010-10-07',999,NULL,NULL,'2014-10-24 22:06:17','2014-10-24 22:06:27'),(2,'Carlos','Fuentealba','carlosfuentealba@gmail.com','2007-05-10',999,NULL,NULL,'2014-10-29 01:10:30',NULL),(3,'Juan','Perez','juan@perez.com',NULL,999,NULL,NULL,NULL,NULL),(4,'Juan','Perez','juan@perez.com',NULL,999,NULL,NULL,NULL,NULL),(5,'Pedro','Urdemales','super.pedro@gmail.com',NULL,999,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `Usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UsuarioCampana`
--

DROP TABLE IF EXISTS `UsuarioCampana`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UsuarioCampana`
--

LOCK TABLES `UsuarioCampana` WRITE;
/*!40000 ALTER TABLE `UsuarioCampana` DISABLE KEYS */;
/*!40000 ALTER TABLE `UsuarioCampana` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marcaProductos`
--

DROP TABLE IF EXISTS `marcaProductos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marcaProductos`
--

LOCK TABLES `marcaProductos` WRITE;
/*!40000 ALTER TABLE `marcaProductos` DISABLE KEYS */;
/*!40000 ALTER TABLE `marcaProductos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-11-01 13:55:52
