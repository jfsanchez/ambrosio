-- MySQL dump 10.13  Distrib 5.5.57, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: ambrosio
-- ------------------------------------------------------
-- Server version	5.5.57-0+deb8u1

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
-- Table structure for table `configuracion`
--

DROP TABLE IF EXISTS `configuracion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuracion` (
  `idconfiguracion` int(11) NOT NULL AUTO_INCREMENT,
  `variable` varchar(120) NOT NULL,
  `valor` text NOT NULL,
  PRIMARY KEY (`idconfiguracion`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuracion`
--

LOCK TABLES `configuracion` WRITE;
/*!40000 ALTER TABLE `configuracion` DISABLE KEYS */;
INSERT INTO `configuracion` VALUES (1,'email_smtp_servidor','localhost'),(2,'email_smtp_usuario','usuario'),(3,'email_smtp_clave','clave'),(4,'email_smtp_email','noreply@localhost'),(5,'email_notification_to_1','informatica@localhost'),(6,'email_notification_to_2','reparacions@localhost'),(7,'email_default_subject_1','[Incidencia informática] '),(8,'email_default_subject_2','[Incidencia mantemento] '),(9,'base_url','https://localhost/incidencias/'),(10,'email_smtp_nombre','Nome institucion');
/*!40000 ALTER TABLE `configuracion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado`
--

DROP TABLE IF EXISTS `estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado` (
  `idestado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  PRIMARY KEY (`idestado`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado`
--

LOCK TABLES `estado` WRITE;
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
INSERT INTO `estado` VALUES (1,'Aberta'),(2,'Pechada'),(3,'En progreso'),(4,'En espera'),(5,'Arquivada');
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo`
--

DROP TABLE IF EXISTS `grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo` (
  `idgrupo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) NOT NULL,
  `urlfondo` varchar(255) NOT NULL,
  PRIMARY KEY (`idgrupo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo`
--

LOCK TABLES `grupo` WRITE;
/*!40000 ALTER TABLE `grupo` DISABLE KEYS */;
INSERT INTO `grupo` VALUES (1,'Mantemento informático','informatica.png'),(2,'Limpeza','reparacion.png'),(3,'FCT',''),(4,'Secretaría','');
/*!40000 ALTER TABLE `grupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incidencia`
--

DROP TABLE IF EXISTS `incidencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incidencia` (
  `idincidencia` int(11) NOT NULL AUTO_INCREMENT,
  `fechacreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre` varchar(200) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `urgencia` tinyint(4) NOT NULL DEFAULT '0',
  `idlocalizacion` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `fechaResolucion` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `idestado` int(11) NOT NULL,
  `idgrupo` int(11) NOT NULL,
  `tokenweb` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`idincidencia`),
  KEY `idgrupo` (`idgrupo`),
  KEY `idestado` (`idestado`),
  KEY `idlocalizacion` (`idlocalizacion`),
  CONSTRAINT `incidencia_ibfk_1` FOREIGN KEY (`idgrupo`) REFERENCES `grupo` (`idgrupo`),
  CONSTRAINT `incidencia_ibfk_2` FOREIGN KEY (`idlocalizacion`) REFERENCES `localizaciones` (`idlocalizacion`),
  CONSTRAINT `incidencia_ibfk_3` FOREIGN KEY (`idestado`) REFERENCES `estado` (`idestado`),
  CONSTRAINT `incidencia_ibfk_4` FOREIGN KEY (`idgrupo`) REFERENCES `grupo` (`idgrupo`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incidencia`
--

LOCK TABLES `incidencia` WRITE;
/*!40000 ALTER TABLE `incidencia` DISABLE KEYS */;
/*!40000 ALTER TABLE `incidencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `localizaciones`
--

DROP TABLE IF EXISTS `localizaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `localizaciones` (
  `idlocalizacion` int(11) NOT NULL AUTO_INCREMENT,
  `nombreaula` varchar(120) NOT NULL,
  `tienehorario` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idlocalizacion`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `localizaciones`
--

LOCK TABLES `localizaciones` WRITE;
/*!40000 ALTER TABLE `localizaciones` DISABLE KEYS */;
INSERT INTO `localizaciones` VALUES (1,'Non aplicable',0),(2,'WEB',0),(3,'Servidores',0),(4,'Aula usos múltiples',1);
/*!40000 ALTER TABLE `localizaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `respuestaincidencia`
--

DROP TABLE IF EXISTS `respuestaincidencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `respuestaincidencia` (
  `idrespuesta` int(11) NOT NULL AUTO_INCREMENT,
  `idincidencia` int(11) NOT NULL,
  `fechaHora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `idusuario` int(11) NOT NULL,
  `texto` text NOT NULL,
  `idestado` int(11) NOT NULL,
  `publica` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idrespuesta`),
  KEY `idincidencia` (`idincidencia`),
  KEY `idestado` (`idestado`),
  KEY `idusuario` (`idusuario`),
  CONSTRAINT `respuestaincidencia_ibfk_1` FOREIGN KEY (`idincidencia`) REFERENCES `incidencia` (`idincidencia`),
  CONSTRAINT `respuestaincidencia_ibfk_2` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`),
  CONSTRAINT `respuestaincidencia_ibfk_3` FOREIGN KEY (`idestado`) REFERENCES `estado` (`idestado`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `respuestaincidencia`
--

LOCK TABLES `respuestaincidencia` WRITE;
/*!40000 ALTER TABLE `respuestaincidencia` DISABLE KEYS */;
/*!40000 ALTER TABLE `respuestaincidencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(120) NOT NULL,
  `clave` char(64) NOT NULL,
  `fallos` int(11) NOT NULL,
  `ultimofallo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `esadmin` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'admin','Clave con salt hasheada',0,'2017-09-19 16:51:28',1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuariogrupo`
--

DROP TABLE IF EXISTS `usuariogrupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuariogrupo` (
  `idusuario` int(11) NOT NULL,
  `idgrupo` int(11) NOT NULL,
  KEY `idusuario` (`idusuario`),
  KEY `idgrupo` (`idgrupo`),
  CONSTRAINT `usuariogrupo_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`),
  CONSTRAINT `usuariogrupo_ibfk_2` FOREIGN KEY (`idgrupo`) REFERENCES `grupo` (`idgrupo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuariogrupo`
--

LOCK TABLES `usuariogrupo` WRITE;
/*!40000 ALTER TABLE `usuariogrupo` DISABLE KEYS */;
INSERT INTO `usuariogrupo` VALUES (1,1),(1,2),(1,3),(1,4);
/*!40000 ALTER TABLE `usuariogrupo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-09-23 13:18:02
