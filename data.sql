CREATE DATABASE  IF NOT EXISTS `nyit` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `nyit`;
-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: localhost    Database: nyit
-- ------------------------------------------------------
-- Server version	5.6.17

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
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(45) DEFAULT NULL,
  `pass` char(128) DEFAULT NULL,
  `salt` char(128) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `user_UNIQUE` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` VALUES (7,'Chochu','$2a$10$MCreTnnXXDb/AzQGIqd67OHJQKBU/D42UhFgEJzWXCu2V5/AAYVoC','$2a$10$MCreTnnXXDb/AzQGIqd67Q==',NULL),(8,'root','$2a$10$5WYEzGHiU320n8gcvG6MC.mwOtdCorzRSCa2scmRaQnx.cbubQOaO','$2a$10$5WYEzGHiU320n8gcvG6MCA==',NULL);
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `building`
--

DROP TABLE IF EXISTS `building`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `building` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) DEFAULT NULL,
  `Abb` varchar(45) DEFAULT NULL,
  `CampusID` int(11) NOT NULL,
  `AltName` varchar(45) DEFAULT NULL,
  `Active` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `BuildingCampusFK_idx` (`CampusID`),
  CONSTRAINT `BuildingCampusFK` FOREIGN KEY (`CampusID`) REFERENCES `campus` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `building`
--

LOCK TABLES `building` WRITE;
/*!40000 ALTER TABLE `building` DISABLE KEYS */;
INSERT INTO `building` VALUES (10,'Education hall','Ed Hall',1,'EDH',NULL),(11,'Anna Robin','AARH',1,'300 Building',NULL),(12,'Theo','THEO',1,'400 Building',NULL),(13,'Harry Schure Hall','HSH',1,'200 Building',NULL),(14,'Wisser Library','WIS',1,'',NULL);
/*!40000 ALTER TABLE `building` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `campus`
--

DROP TABLE IF EXISTS `campus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) DEFAULT NULL,
  `Abb` varchar(2) DEFAULT NULL,
  `Address` varchar(45) DEFAULT NULL,
  `State` varchar(45) DEFAULT NULL,
  `Zip` varchar(45) DEFAULT NULL,
  `Country` varchar(45) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campus`
--

LOCK TABLES `campus` WRITE;
/*!40000 ALTER TABLE `campus` DISABLE KEYS */;
INSERT INTO `campus` VALUES (1,'Old Westbury','OW','Northern Blvd, Old Westbury','11111','USA','NY',NULL);
/*!40000 ALTER TABLE `campus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deploy`
--

DROP TABLE IF EXISTS `deploy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deploy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `EquipID` int(11) DEFAULT NULL,
  `DateInstall` date DEFAULT NULL,
  `CurrentCampusID` int(11) DEFAULT NULL,
  `CurrentBuildingID` int(11) DEFAULT NULL,
  `CurrentRoomID` int(11) DEFAULT NULL,
  `DateRemove` date DEFAULT NULL,
  `PastCampusID` int(11) DEFAULT NULL,
  `PastBuildingID` int(11) DEFAULT NULL,
  `PastRoomID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deploy`
--

LOCK TABLES `deploy` WRITE;
/*!40000 ALTER TABLE `deploy` DISABLE KEYS */;
INSERT INTO `deploy` VALUES (9,18,'2016-04-02',1,11,9,'2016-04-02',1,12,17),(10,9,'2016-04-02',1,11,7,NULL,NULL,NULL,NULL),(11,18,'0000-00-00',1,12,17,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `deploy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipment`
--

DROP TABLE IF EXISTS `equipment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) DEFAULT NULL,
  `equipmenttype` int(11) NOT NULL,
  `Asset` varchar(45) DEFAULT NULL,
  `Serial` varchar(45) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT NULL,
  `DeployID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `EquipmentType_idx` (`equipmenttype`),
  KEY `FKDeployID_idx` (`DeployID`),
  CONSTRAINT `EquipmentType` FOREIGN KEY (`equipmenttype`) REFERENCES `equipmenttype` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment`
--

LOCK TABLES `equipment` WRITE;
/*!40000 ALTER TABLE `equipment` DISABLE KEYS */;
INSERT INTO `equipment` VALUES (4,'OA-01',2,'1','1',1,0),(5,'OA-02',2,'2','2',1,0),(6,'OA-03',2,'3','3',1,0),(7,'OA-01-Monitor',5,'1','1',1,0),(8,'OA-02-Monitor',5,'2','2',1,0),(9,'UltraSharp Room 210',7,'23','23',0,10),(11,'New Guy PC',9,'1','1',1,0),(17,'Touch Screen Monitor',7,'','',0,0),(18,'Test',2,'','',1,11);
/*!40000 ALTER TABLE `equipment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipmenttype`
--

DROP TABLE IF EXISTS `equipmenttype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipmenttype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Make` varchar(45) DEFAULT NULL,
  `Model` varchar(45) DEFAULT NULL,
  `Type` varchar(45) DEFAULT NULL,
  `Description` longtext,
  `Active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipmenttype`
--

LOCK TABLES `equipmenttype` WRITE;
/*!40000 ALTER TABLE `equipmenttype` DISABLE KEYS */;
INSERT INTO `equipmenttype` VALUES (2,'Dell','OptiPlex 7010','PC','Graphics processor: Intel GPU\r\nInstalled memory: 8 GB RAM\r\nProcessor speed: 3.5 GHz\r\nOperating system: Windows\r\nDrive capacity: 1 TB Drive\r\nStyle: Small Form Factor, To',NULL),(5,'Del','Dell 24 Ultra HD 4K Monitor - P2415Q','Monitor','Your vision deserves pixel-perfect clarity.\r\n\r\nExpect beautiful 4K clarity on a 23.8\" Ultra HD monitor with four times the resolution of Full HD, wide color coverage and reliable performance.\r\nUltra HD 3840 x 2160 resolution: Over 8 million pixels with four times the resolution of Full HD, plus wide color coverage at 99% sRGB (deltaE <3).\r\nSeamless connection to other peripherals: Connect to laptops, tablets and other devices without compromising on picture quality.\r\nReliable performance: Premium Panel Guarantee and minimal downtime with 3 years Advanced Exchange Service.',NULL),(6,'Dell','Dell 27 Ultra HD 4K Monitor - P2715Q','Monitor','Device Type\r\nLED-backlit LCD monitor - 27\"\r\nBuilt-in Devices\r\nUSB hub\r\nPanel Type\r\nIPS\r\nAspect Ratio\r\nWidescreen - 16:9\r\nNative Resolution\r\n4K 3840 x 2160 at 60 Hz\r\nPixel Pitch\r\n0.1554 mm\r\nBrightness\r\n350 cd/m2\r\nContrast Ratio\r\n1000:1 / 2000000:1 (dynamic)\r\nResponse Time\r\n9 ms (gray-to-gray)\r\nColor Support\r\n1.07 billion colors\r\nInput Connectors\r\nHDMI, DisplayPort, Mini DisplayPort, MHL\r\nDisplay Position Adjustments\r\nHeight, pivot (rotation), swivel, tilt\r\nScreen Coating\r\nAnti-glare, 3H Hard Coating\r\nColor\r\nBlack\r\nDimensions (WxDxH)\r\n25.2 in x 8 in x 16.7 in - with stand',NULL),(7,'Dell','Dell UltraSharp 27 Ultra HD 5K Monitor with P','Monitor','Device Type\r\nLED-backlit LCD monitor - 27\"\r\nBuilt-in Devices\r\nCard reader, USB 3.0 hub\r\nPanel Type\r\nIPS\r\nAspect Ratio\r\nWidescreen - 16:9\r\nNative Resolution\r\n5K 5120 x 2880 at 60 Hz\r\nPixel Pitch\r\n0.116 mm\r\nBrightness\r\n350 cd/m2\r\nContrast Ratio\r\n1000:1 / 8000000:1 (dynamic)\r\nResponse Time\r\n8 ms (gray-to-gray)\r\nColor Support\r\n1.07 billion colors\r\nInput Connectors\r\n2xDisplayPort, Mini DisplayPort\r\nSpeakers\r\nIntegrated\r\nDisplay Position Adjustments\r\nHeight, pivot (rotation), swivel, tilt\r\nScreen Coating\r\nAnti-glare, 3H Hard Coating, anti-smudge coating\r\nColor\r\nBlack',NULL),(8,'Dell','OptiPlex 5040','PC','NEW OptiPlex 5040 and the OptiPlex 7020 commercial desktops available in tower and small for advanced performance, security and manageability.	',NULL),(9,'Dell','New OptiPlex 3240 All-in-One','All in One','Customizable: Choose the Windows that\'s right for your business. Additional options include more hard drive space, optical disk drive space and wireless options.',NULL);
/*!40000 ALTER TABLE `equipmenttype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Building` varchar(45) DEFAULT NULL,
  `Room` varchar(45) DEFAULT NULL,
  `Item_Name` varchar(45) DEFAULT NULL,
  `Item_Type` varchar(45) DEFAULT NULL,
  `Assest` int(11) DEFAULT NULL,
  `Service` varchar(45) DEFAULT NULL,
  `Active` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory`
--

LOCK TABLES `inventory` WRITE;
/*!40000 ALTER TABLE `inventory` DISABLE KEYS */;
INSERT INTO `inventory` VALUES (1,'HSH','132','OW-HSH-132-TS','PC',-1,'-1',''),(2,'HSH','142','OW-HSH-142-TS','PC',12342,'123211',''),(3,'EH','260','OW-ED-260-21','PC',123,'322',''),(4,'300','301','OW-300-301-ts','pc',1231,'-1','\0'),(5,'400','411','OW-400-411-TS','PC',-1,'-1',''),(6,'400','412','OW-400-412-TS','PC',-1,'-1',''),(7,'400','414','OW-400-414-TS','PC',-1,'-1','');
/*!40000 ALTER TABLE `inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `RoomNumber` varchar(45) DEFAULT NULL,
  `AltName` varchar(45) DEFAULT NULL,
  `BuildingID` int(11) NOT NULL,
  `CampusID` int(11) NOT NULL,
  `Active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `RoomBuildingFK_idx` (`BuildingID`),
  KEY `RoomCampusFK_idx` (`CampusID`),
  CONSTRAINT `RoomBuildingFK` FOREIGN KEY (`BuildingID`) REFERENCES `building` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `RoomCampusFK` FOREIGN KEY (`CampusID`) REFERENCES `campus` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room`
--

LOCK TABLES `room` WRITE;
/*!40000 ALTER TABLE `room` DISABLE KEYS */;
INSERT INTO `room` VALUES (7,'301','',11,1,1),(8,'302','',11,1,1),(9,'303','',11,1,1),(10,'304','',11,1,1),(11,'305','',11,1,1),(12,'306','',11,1,1),(13,'307','',11,1,1),(14,'308','',11,1,1),(15,'309','',11,1,1),(16,'310','',11,1,1),(17,'411','',12,1,1),(18,'409','',12,1,1),(19,'206','',10,1,1),(20,'260','',10,1,1),(21,'227','DL5',13,1,1),(22,'DL1','',13,1,1),(23,'DL2','',13,1,1),(24,'DL3','',13,1,1),(25,'DL4','',13,1,1),(26,'CLC2','',13,1,1),(27,'322','Conf Room',14,1,1),(28,'L10','Lab',14,1,1);
/*!40000 ALTER TABLE `room` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-08  6:10:24
