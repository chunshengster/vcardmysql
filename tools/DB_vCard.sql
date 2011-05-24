-- MySQL dump 10.13  Distrib 5.1.54, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: DB_vCard
-- ------------------------------------------------------
-- Server version	5.1.54-1ubuntu4

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
-- Current Database: `DB_vCard`
--

/*!40000 DROP DATABASE IF EXISTS `DB_vCard`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `DB_vCard` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `DB_vCard`;

--
-- Table structure for table `User_Contacts`
--

DROP TABLE IF EXISTS `User_Contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User_Contacts` (
  `id_user_contacts` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_user_contacts`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User_Contacts`
--

LOCK TABLES `User_Contacts` WRITE;
/*!40000 ALTER TABLE `User_Contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `User_Contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vCard_Delivery_Addressing_Properties_ADR`
--

DROP TABLE IF EXISTS `vCard_Delivery_Addressing_Properties_ADR`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vCard_Delivery_Addressing_Properties_ADR` (
  `idvCard_Delivery_Addressing_Properties_ADR` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vCard_Explanatory_Properties_idvCard_Explanatory_Properties` bigint(20) unsigned NOT NULL,
  `ADR` blob,
  `AdrType` set('DOM','INTL','POSTAL','PARCEL','HOME','WORK') DEFAULT NULL,
  PRIMARY KEY (`idvCard_Delivery_Addressing_Properties_ADR`,`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`),
  KEY `fk_vCard_Delivvery_Addressing_Properties_vCard_Explanatory_Pr1` (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`),
  CONSTRAINT `fk_vCard_Delivvery_Addressing_Properties_vCard_Explanatory_Pr1` FOREIGN KEY (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) REFERENCES `vCard_Explanatory_Properties` (`idvCard_Explanatory_Properties`)
) ENGINE=InnoDB AUTO_INCREMENT=530 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vCard_Delivery_Addressing_Properties_ADR`
--

LOCK TABLES `vCard_Delivery_Addressing_Properties_ADR` WRITE;
/*!40000 ALTER TABLE `vCard_Delivery_Addressing_Properties_ADR` DISABLE KEYS */;
INSERT INTO `vCard_Delivery_Addressing_Properties_ADR` VALUES (529,160,';;;;;;中国','WORK');
/*!40000 ALTER TABLE `vCard_Delivery_Addressing_Properties_ADR` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vCard_Delivery_Addressing_Properties_LABEL`
--

DROP TABLE IF EXISTS `vCard_Delivery_Addressing_Properties_LABEL`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vCard_Delivery_Addressing_Properties_LABEL` (
  `idvCard_Delivery_Addressing_Properties_LABEL` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vCard_Explanatory_Properties_idvCard_Explanatory_Properties` bigint(20) unsigned NOT NULL,
  `LABEL` blob,
  `LabelType` set('DOM','INTL','POSTAL','PARCEL','HOME','WORK') DEFAULT NULL,
  PRIMARY KEY (`idvCard_Delivery_Addressing_Properties_LABEL`,`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`),
  KEY `fk_vCard_Delivvery_Addressing_Properties_LABEL_vCard_Explanat1` (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`),
  CONSTRAINT `fk_vCard_Delivvery_Addressing_Properties_LABEL_vCard_Explanat1` FOREIGN KEY (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) REFERENCES `vCard_Explanatory_Properties` (`idvCard_Explanatory_Properties`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vCard_Delivery_Addressing_Properties_LABEL`
--

LOCK TABLES `vCard_Delivery_Addressing_Properties_LABEL` WRITE;
/*!40000 ALTER TABLE `vCard_Delivery_Addressing_Properties_LABEL` DISABLE KEYS */;
/*!40000 ALTER TABLE `vCard_Delivery_Addressing_Properties_LABEL` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vCard_Explanatory_Properties`
--

DROP TABLE IF EXISTS `vCard_Explanatory_Properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vCard_Explanatory_Properties` (
  `idvCard_Explanatory_Properties` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `UID` char(64) NOT NULL,
  `VERSION` char(3) NOT NULL DEFAULT '2.1',
  `REV` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `LANG` char(16) DEFAULT NULL,
  `CATEGORIES` varchar(45) DEFAULT NULL,
  `PRODID` varchar(45) DEFAULT NULL,
  `SORT-STRING` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idvCard_Explanatory_Properties`),
  UNIQUE KEY `UID_UNIQUE` (`UID`)
) ENGINE=InnoDB AUTO_INCREMENT=231 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vCard_Explanatory_Properties`
--

LOCK TABLES `vCard_Explanatory_Properties` WRITE;
/*!40000 ALTER TABLE `vCard_Explanatory_Properties` DISABLE KEYS */;
INSERT INTO `vCard_Explanatory_Properties` VALUES (160,'c1d38996-3e39-11e0-b3cb-fefdade6870a','2.1','2011-02-22 04:11:00','','','',''),(161,'89128cc4-3e3e-11e0-b3cb-fefdade6870a','2.1','2011-02-22 04:57:52','','','Wo-Push',''),(162,'9a004c9c-3e3e-11e0-b3cb-fefdade6870a','2.1','2011-03-16 09:28:40','','','Wo-Push',''),(163,'69534ce2-3e3f-11e0-b3cb-fefdade6870a','2.1','2011-02-22 04:51:29','','','Wo-Push',''),(164,'7a51299c-3e3f-11e0-b3cb-fefdade6870a','2.1','2011-02-22 04:51:57','','','Wo-Push',''),(165,'e70977aa-3e40-11e0-b3cb-fefdade6870a','2.1','2011-03-16 10:25:02','','','Wo-Push',''),(166,'fb8e84bc-3e41-11e0-b3cb-fefdade6870a','2.1','2011-03-16 10:25:04','','','Wo-Push',''),(167,'c3ef67c8-3e42-11e0-b3cb-fefdade6870a','3.0','2011-02-22 05:15:29','','','',''),(168,'2724dfca-3e44-11e0-b3cb-fefdade6870a','2.1','2011-03-16 10:25:03','','','Wo-Push',''),(169,'dceae0fc-3ef3-11e0-b3cb-fefdade6870a','3.0','2011-02-23 02:23:12','','','',''),(170,'427f1532-3ef4-11e0-b3cb-fefdade6870a','3.0','2011-02-23 02:26:02','','','',''),(171,'e8249fb6-3ef9-11e0-b3cb-fefdade6870a','3.0','2011-02-23 03:06:28','','','',''),(172,'7a702858-40a4-11e0-b636-fefdade6870a','3.0','2011-02-25 05:59:59','','','',''),(173,'269aa9ec-40a9-11e0-b636-fefdade6870a','3.0','2011-02-25 06:33:26','','','',''),(174,'ef8ddfac-49fc-11e0-a216-fefdade6870a','2.1','2011-03-09 03:25:52',NULL,NULL,NULL,NULL),(175,'a0bc9706-4a01-11e0-a216-fefdade6870a','2.1','2011-03-09 03:59:27',NULL,NULL,NULL,NULL),(176,'836e81be-4a24-11e0-a216-fefdade6870a','2.1','2011-03-09 08:09:10',NULL,NULL,NULL,NULL),(177,'91895f54-4a2d-11e0-a216-fefdade6870a','2.1','2011-03-09 09:13:59',NULL,NULL,NULL,NULL),(178,'abe40450-4a30-11e0-a216-fefdade6870a','2.1','2011-03-09 09:36:12',NULL,NULL,NULL,NULL),(179,'b5b7b602-4a30-11e0-a216-fefdade6870a','2.1','2011-03-09 09:36:28',NULL,NULL,NULL,NULL),(180,'2435e094-4a32-11e0-a216-fefdade6870a','2.1','2011-03-09 09:46:43',NULL,NULL,NULL,NULL),(181,'3ee912da-4a32-11e0-a216-fefdade6870a','2.1','2011-03-09 09:47:28',NULL,NULL,NULL,NULL),(182,'be4e1db8-4a32-11e0-a216-fefdade6870a','2.1','2011-03-09 09:51:02',NULL,NULL,NULL,NULL),(183,'c77521ce-4a33-11e0-a216-fefdade6870a','2.1','2011-03-09 09:58:27',NULL,NULL,NULL,NULL),(184,'edaa8f64-4a33-11e0-a216-fefdade6870a','2.1','2011-03-09 09:59:31',NULL,NULL,NULL,NULL),(185,'401d87a6-4a34-11e0-a216-fefdade6870a','2.1','2011-03-09 10:01:49',NULL,NULL,NULL,NULL),(186,'92641214-4a34-11e0-a216-fefdade6870a','2.1','2011-03-09 10:04:07',NULL,NULL,NULL,NULL),(187,'09cd9622-4a35-11e0-a216-fefdade6870a','2.1','2011-03-09 10:07:27',NULL,NULL,NULL,NULL),(188,'0ce8bd02-4a38-11e0-a216-fefdade6870a','2.1','2011-03-09 10:29:01',NULL,NULL,NULL,NULL),(189,'7fca1d2a-4a38-11e0-a216-fefdade6870a','2.1','2011-03-09 10:32:14',NULL,NULL,NULL,NULL),(190,'09d6220a-4fb8-11e0-a216-fefdade6870a','2.1','2011-03-18 09:18:42','','','Wo-Push',''),(191,'0df5af44-70b1-11e0-94f0-000c29e043e5','2.1','2011-04-27 09:04:56','','','Wo-Push',''),(192,'1fdda450-70b1-11e0-94f0-000c29e043e5','2.1','2011-04-27 09:04:26','','','Wo-Push',''),(193,'aead3eac-70b1-11e0-94f0-000c29e043e5','2.1','2011-04-27 09:04:26','','','Wo-Push',''),(194,'b717060e-70b1-11e0-94f0-000c29e043e5','2.1','2011-04-27 09:04:40','','','Wo-Push',''),(195,'d9c937da-70b1-11e0-94f0-000c29e043e5','2.1','2011-04-27 09:04:38','','','Wo-Push',''),(196,'de57ed28-70b1-11e0-94f0-000c29e043e5','2.1','2011-04-27 09:04:46','','','Wo-Push',''),(197,'0e6d1bf0-70b2-11e0-94f0-000c29e043e5','2.1','2011-04-27 09:04:06','','','Wo-Push',''),(198,'c5871432-70b5-11e0-94f0-000c29e043e5','2.1','2011-04-27 10:04:42','','','Wo-Push',''),(199,'d262732c-70b5-11e0-94f0-000c29e043e5','2.1','2011-04-27 10:04:04','','','Wo-Push',''),(200,'dc271b24-70b5-11e0-94f0-000c29e043e5','2.1','2011-04-27 10:04:20','','','Wo-Push',''),(201,'1928801c-70b6-11e0-94f0-000c29e043e5','2.1','2011-04-27 10:04:02','','','Wo-Push',''),(202,'1c5867f2-70b6-11e0-94f0-000c29e043e5','2.1','2011-04-27 10:04:08','','','Wo-Push',''),(203,'1cdd8af4-70b6-11e0-94f0-000c29e043e5','2.1','2011-04-27 10:04:09','','','Wo-Push',''),(204,'1d9e9a1e-70b6-11e0-94f0-000c29e043e5','2.1','2011-04-27 10:04:10','','','Wo-Push',''),(205,'4f0bd5e4-70b6-11e0-94f0-000c29e043e5','2.1','2011-04-27 10:04:33','','','Wo-Push',''),(206,'aaf63c6e-70b6-11e0-94f0-000c29e043e5','2.1','2011-04-27 10:04:07','','','Wo-Push',''),(207,'f28c55b8-70b6-11e0-94f0-000c29e043e5','2.1','2011-04-27 10:04:07','','','Wo-Push',''),(208,'8fd0ce9e-70b7-11e0-94f0-000c29e043e5','2.1','2011-04-27 10:04:31','','','Wo-Push',''),(209,'cddb62e4-70b7-11e0-94f0-000c29e043e5','2.1','2011-04-27 10:04:15','','','Wo-Push',''),(210,'c75b7a84-70b8-11e0-94f0-000c29e043e5','2.1','2011-04-27 10:04:14','','','Wo-Push',''),(211,'500f71a0-70b9-11e0-94f0-000c29e043e5','2.1','2011-04-27 10:04:03','','','Wo-Push',''),(212,'78d26688-70b9-11e0-94f0-000c29e043e5','2.1','2011-04-27 10:04:11','','','Wo-Push',''),(213,'84958ed2-70b9-11e0-94f0-000c29e043e5','2.1','2011-04-27 10:04:31','','','Wo-Push',''),(214,'9af029c6-70b9-11e0-94f0-000c29e043e5','2.1','2011-04-27 10:04:09','','','Wo-Push',''),(215,'a65ae21a-70b9-11e0-94f0-000c29e043e5','2.1','2011-04-27 10:04:28','','','Wo-Push',''),(216,'ac029bf4-70b9-11e0-94f0-000c29e043e5','2.1','2011-04-27 10:04:37','','','Wo-Push',''),(217,'a21e6aba-70bd-11e0-94f0-000c29e043e5','2.1','2011-04-27 11:04:59','','','Wo-Push',''),(218,'afc1f3a6-7227-11e0-9e2e-000c29e043e5','2.1','2011-04-29 06:04:39','','','Wo-Push',''),(219,'8cea4ec2-7228-11e0-9e2e-000c29e043e5','2.1','2011-04-29 06:04:50','','','Wo-Push',''),(220,'a7456e5a-7228-11e0-9e2e-000c29e043e5','2.1','2011-04-29 06:04:35','','','Wo-Push',''),(221,'b0d78c06-722c-11e0-9e2e-000c29e043e5','2.1','2011-04-29 06:04:29','','','Wo-Push',''),(222,'f7361d58-76ef-11e0-bfd6-000c29e043e5','2.1','2011-05-05 08:16:23','','','',''),(223,'ee4bb04c-76f2-11e0-bfd6-000c29e043e5','2.1','2011-05-05 08:37:37','','','',''),(224,'d5ac593e-76f6-11e0-bfd6-000c29e043e5','2.1','2011-05-05 09:05:33','','','',''),(225,'ee768dc8-77c2-11e0-880a-000c29e043e5','2.1','2011-05-06 09:26:32','','','Wo-Push',''),(226,'1fab527c-820c-11e0-8fd8-000c29c88079','2.1','2011-05-19 11:05:40','','','Wo-Push',''),(227,'2c0324e6-820c-11e0-8fd8-000c29c88079','2.1','2011-05-19 11:05:01','','','Wo-Push',''),(228,'33018bde-820c-11e0-8fd8-000c29c88079','2.1','2011-05-19 11:05:12','','','Wo-Push',''),(229,'4eb46dce-820c-11e0-8fd8-000c29c88079','2.1','2011-05-19 11:05:59','','','Wo-Push',''),(230,'508a5bf4-820c-11e0-8fd8-000c29c88079','2.1','2011-05-19 11:05:02','','','Wo-Push','');
/*!40000 ALTER TABLE `vCard_Explanatory_Properties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vCard_Extension_Properties`
--

DROP TABLE IF EXISTS `vCard_Extension_Properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vCard_Extension_Properties` (
  `idvCard_Extension_Properties` bigint(20) NOT NULL AUTO_INCREMENT,
  `vCard_Explanatory_Properties_idvCard_Explanatory_Properties` bigint(20) unsigned NOT NULL,
  `ExtensionName` char(32) NOT NULL,
  `ExtensionValue` blob,
  PRIMARY KEY (`idvCard_Extension_Properties`,`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`),
  KEY `fk_vCard_Extension_Properties_vCard_Explanatory_Properties1` (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`),
  CONSTRAINT `fk_vCard_Extension_Properties_vCard_Explanatory_Properties1` FOREIGN KEY (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) REFERENCES `vCard_Explanatory_Properties` (`idvCard_Explanatory_Properties`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vCard_Extension_Properties`
--

LOCK TABLES `vCard_Extension_Properties` WRITE;
/*!40000 ALTER TABLE `vCard_Extension_Properties` DISABLE KEYS */;
INSERT INTO `vCard_Extension_Properties` VALUES (1,190,'X-MICROBLOG','http://weibo.com/chunshengster@平凡的香草'),(2,190,'X-BLOG','http://blog.sina.com.cn/chunshengok'),(3,190,'X-BLOG','http://blog.sina.com.cn/chunshengok123'),(4,190,'X-BLOG','http://blog.sina.com.cn/chunshengok123'),(5,190,'X-BLOG','http://blog.sina.com.cn/chunshengok123');
/*!40000 ALTER TABLE `vCard_Extension_Properties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vCard_Geographical_Properties`
--

DROP TABLE IF EXISTS `vCard_Geographical_Properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vCard_Geographical_Properties` (
  `idvCard_Geographical_Properties` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vCard_Explanatory_Properties_idvCard_Explanatory_Properties` bigint(20) unsigned NOT NULL,
  `TZ` char(8) NOT NULL,
  `GEO` char(32) NOT NULL,
  PRIMARY KEY (`idvCard_Geographical_Properties`,`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`),
  KEY `fk_vCard_Geographical_Properties_vCard_Explanatory_Properties1` (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`),
  CONSTRAINT `fk_vCard_Geographical_Properties_vCard_Explanatory_Properties1` FOREIGN KEY (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) REFERENCES `vCard_Explanatory_Properties` (`idvCard_Explanatory_Properties`)
) ENGINE=InnoDB AUTO_INCREMENT=190 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vCard_Geographical_Properties`
--

LOCK TABLES `vCard_Geographical_Properties` WRITE;
/*!40000 ALTER TABLE `vCard_Geographical_Properties` DISABLE KEYS */;
INSERT INTO `vCard_Geographical_Properties` VALUES (166,160,'',';'),(167,161,'',';'),(168,162,'',';'),(169,163,'',';'),(170,164,'',';'),(171,165,'',';'),(172,166,'',';'),(173,167,'',';'),(174,168,'',';'),(175,169,'',';'),(176,170,'',';'),(177,171,'',';'),(178,172,'',';'),(179,173,'',';'),(180,190,'',';'),(181,222,'',';'),(182,223,'',';'),(183,224,'',';'),(184,225,'',';'),(185,226,'',';'),(186,227,'',';'),(187,228,'',';'),(188,229,'',';'),(189,230,'',';');
/*!40000 ALTER TABLE `vCard_Geographical_Properties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vCard_Identification_Properties`
--

DROP TABLE IF EXISTS `vCard_Identification_Properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vCard_Identification_Properties` (
  `idvCard_Identification_Properties` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vCard_Explanatory_Properties_idvCard_Explanatory_Properties` bigint(20) unsigned NOT NULL,
  `FN` char(64) DEFAULT NULL,
  `N` char(64) DEFAULT NULL,
  `NICKNAME` char(64) DEFAULT NULL,
  `PHOTO` blob,
  `PhotoType` enum('GIF','BMP','JPEG') DEFAULT NULL,
  `BDAY` date DEFAULT NULL,
  `URL` varchar(256) DEFAULT NULL,
  `SOUND` blob,
  `NOTE` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`idvCard_Identification_Properties`,`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`),
  KEY `fk_vCard_Identification_Properties_vCard_Explanatory_Properti1` (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`),
  CONSTRAINT `fk_vCard_Identification_Properties_vCard_Explanatory_Properti1` FOREIGN KEY (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) REFERENCES `vCard_Explanatory_Properties` (`idvCard_Explanatory_Properties`)
) ENGINE=InnoDB AUTO_INCREMENT=238 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vCard_Identification_Properties`
--

LOCK TABLES `vCard_Identification_Properties` WRITE;
/*!40000 ALTER TABLE `vCard_Identification_Properties` DISABLE KEYS */;
INSERT INTO `vCard_Identification_Properties` VALUES (166,160,'王春生','王;春生;;;','','',NULL,'0000-00-00','','',''),(167,161,'江锡卓','江锡卓;;;;','','',NULL,'0000-00-00','','',''),(168,162,'王春生','王;春生;;;','','',NULL,'0000-00-00','','',''),(169,163,'江锡卓','江锡卓;;;;','','',NULL,'0000-00-00','','',''),(170,164,'王春生','王春生;;;;','','',NULL,'0000-00-00','','',''),(171,165,'江锡卓','江锡卓;;;;','','',NULL,'0000-00-00','','',''),(172,166,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(173,167,'','','','',NULL,'0000-00-00','','',''),(174,168,'郝希治','郝;希治;;;','','',NULL,'0000-00-00','','',''),(175,169,'傅闽','傅闽;;;;','','',NULL,'0000-00-00','','',''),(176,170,'','','','',NULL,'0000-00-00','','',''),(177,171,'郝希治','郝;希治;;;','','',NULL,'0000-00-00','','',''),(178,172,'郝希治','郝;希治;;;','','',NULL,'0000-00-00','','',''),(179,173,'傅闽','傅闽;;;;','','',NULL,'0000-00-00','','',''),(180,177,'傅闽','傅闽;;;;','','',NULL,'0000-00-00','','',''),(181,178,'傅闽','傅闽;;;;','','',NULL,'0000-00-00','','',''),(182,179,'傅闽','傅闽;;;;','','',NULL,'0000-00-00','','',''),(183,180,'傅闽','傅闽;;;;','','',NULL,'0000-00-00','','',''),(184,181,'傅闽','傅闽;;;;','','',NULL,'0000-00-00','','',''),(185,182,'傅闽','傅闽;;;;','','',NULL,'0000-00-00','','',''),(186,183,'傅闽','傅闽;;;;','','',NULL,'0000-00-00','','',''),(187,184,'傅闽','傅闽;;;;','','',NULL,'0000-00-00','','',''),(188,185,'傅闽','傅闽;;;;','','',NULL,'0000-00-00','','',''),(189,186,'傅闽','傅闽;;;;','','',NULL,'0000-00-00','','',''),(190,187,'傅闽','傅闽;;;;','','',NULL,'0000-00-00','','',''),(191,188,'傅闽','傅闽;;;;','','',NULL,'0000-00-00','','',''),(192,189,'傅闽','傅闽;;;;','','',NULL,'0000-00-00','','',''),(193,190,'王春生','王;春生;;;','','',NULL,'1981-04-18','','','宋体我'),(194,166,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(195,166,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(196,166,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(197,166,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(198,191,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(199,192,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(200,193,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(201,194,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(202,195,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(203,196,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(204,197,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(205,198,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(206,199,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(207,200,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(208,201,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(209,202,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(210,203,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(211,204,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(212,205,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(213,206,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(214,207,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(215,208,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(216,209,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(217,210,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(218,211,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(219,212,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(220,213,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(221,214,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(222,215,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(223,216,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(224,217,'傅闽','傅;闽;;;','','',NULL,'0000-00-00','','',''),(225,218,'江锡卓','江;锡卓;;;','','',NULL,'0000-00-00','','',''),(226,219,'江锡卓','江;锡卓;;;','','',NULL,'0000-00-00','','',''),(227,220,'江锡卓','江;锡卓;;;','','',NULL,'0000-00-00','','',''),(228,221,'杨桦','杨;桦;;;','','',NULL,'0000-00-00','','',''),(229,222,'Chifeng Qu','Qu;Chifeng;;;','','http\\://images.plaxo.com/fetch_image?uhid=244815425411&url=http%3A%2F%2Fprofile.ak.fbcdn.net%2Fhprofile-ak-snc4%2F161510_663767173_4529665_n.jpg&chk=8%DC%97D%A9%CE%1E%3DAj%E3%F5%CFl%9D%02','','0000-00-00','','',''),(230,223,'Chifeng Qu','Qu;Chifeng;;;','','http\\://images.plaxo.com/fetch_image?uhid=244815425411&url=http%3A%2F%2Fprofile.ak.fbcdn.net%2Fhprofile-ak-snc4%2F161510_663767173_4529665_n.jpg&chk=8%DC%97D%A9%CE%1E%3DAj%E3%F5%CFl%9D%02','','0000-00-00','','',''),(231,224,'Phillip Wu','Wu;Phillip;;;','Phillip Wu','http\\://images.plaxo.com/fetch_image?path=77312408105_0_-1943012466','','0000-00-00','http\\://www.infothinker.com','',''),(232,225,'王春生','王;春生;;;','','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','JPEG','1981-04-18','','',''),(233,226,'杨桦','杨;桦;;;','','',NULL,'0000-00-00','','',''),(234,227,'杨桦','杨;桦;;;','','',NULL,'0000-00-00','','',''),(235,228,'杨桦','杨;桦;;;','','',NULL,'0000-00-00','','',''),(236,229,'杨桦','杨;桦;;;','','',NULL,'0000-00-00','','',''),(237,230,'杨桦','杨;桦;;;','','',NULL,'0000-00-00','','','');
/*!40000 ALTER TABLE `vCard_Identification_Properties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vCard_Organizational_Properties`
--

DROP TABLE IF EXISTS `vCard_Organizational_Properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vCard_Organizational_Properties` (
  `idvCard_Organizational_Properties` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vCard_Explanatory_Properties_idvCard_Explanatory_Properties` bigint(20) unsigned NOT NULL,
  `TITLE` char(64) DEFAULT NULL,
  `ROLE` char(128) DEFAULT NULL,
  `LOGO` blob,
  `LogoType` enum('GIF','BMP','JPEG') DEFAULT NULL,
  `AGENT` blob,
  `ORG` blob,
  PRIMARY KEY (`idvCard_Organizational_Properties`,`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`),
  KEY `fk_vCard_Organizational_Properties_vCard_Explanatory_Properti1` (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`),
  CONSTRAINT `fk_vCard_Organizational_Properties_vCard_Explanatory_Properti1` FOREIGN KEY (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) REFERENCES `vCard_Explanatory_Properties` (`idvCard_Explanatory_Properties`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=225 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vCard_Organizational_Properties`
--

LOCK TABLES `vCard_Organizational_Properties` WRITE;
/*!40000 ALTER TABLE `vCard_Organizational_Properties` DISABLE KEYS */;
INSERT INTO `vCard_Organizational_Properties` VALUES (166,160,'','','',NULL,NULL,''),(167,161,'','','',NULL,NULL,''),(168,162,'','','',NULL,NULL,''),(169,163,'','','',NULL,NULL,''),(170,164,'','','',NULL,NULL,''),(171,165,'','','',NULL,NULL,''),(172,166,'','','',NULL,NULL,''),(173,167,'','','',NULL,NULL,''),(174,168,'','','',NULL,NULL,''),(175,169,'','','',NULL,NULL,''),(176,170,'','','',NULL,NULL,''),(177,171,'','','',NULL,NULL,''),(178,172,'','','',NULL,NULL,''),(179,173,'','','',NULL,NULL,''),(180,190,'','','',NULL,NULL,''),(181,166,'','','',NULL,NULL,''),(182,166,'','','',NULL,NULL,''),(183,166,'','','',NULL,NULL,''),(184,166,'','','',NULL,NULL,''),(185,191,'','','',NULL,NULL,''),(186,192,'','','',NULL,NULL,''),(187,193,'','','',NULL,NULL,''),(188,194,'','','',NULL,NULL,''),(189,195,'','','',NULL,NULL,''),(190,196,'','','',NULL,NULL,''),(191,197,'','','',NULL,NULL,''),(192,198,'','','',NULL,NULL,''),(193,199,'','','',NULL,NULL,''),(194,200,'','','',NULL,NULL,''),(195,201,'','','',NULL,NULL,''),(196,202,'','','',NULL,NULL,''),(197,203,'','','',NULL,NULL,''),(198,204,'','','',NULL,NULL,''),(199,205,'','','',NULL,NULL,''),(200,206,'','','',NULL,NULL,''),(201,207,'','','',NULL,NULL,''),(202,208,'','','',NULL,NULL,''),(203,209,'','','',NULL,NULL,''),(204,210,'','','',NULL,NULL,''),(205,211,'','','',NULL,NULL,''),(206,212,'','','',NULL,NULL,''),(207,213,'','','',NULL,NULL,''),(208,214,'','','',NULL,NULL,''),(209,215,'','','',NULL,NULL,''),(210,216,'','','',NULL,NULL,''),(211,217,'','','',NULL,NULL,''),(212,218,'','','',NULL,NULL,''),(213,219,'','','',NULL,NULL,''),(214,220,'','','',NULL,NULL,''),(215,221,'','','',NULL,NULL,''),(216,222,'','','',NULL,NULL,''),(217,223,'','','',NULL,NULL,''),(218,224,'CEO','','',NULL,NULL,'InfoThinker'),(219,225,'','','',NULL,NULL,''),(220,226,'','','',NULL,NULL,''),(221,227,'','','',NULL,NULL,''),(222,228,'','','',NULL,NULL,''),(223,229,'','','',NULL,NULL,''),(224,230,'','','',NULL,NULL,'');
/*!40000 ALTER TABLE `vCard_Organizational_Properties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vCard_Telecommunications_Addressing_Properties_Email`
--

DROP TABLE IF EXISTS `vCard_Telecommunications_Addressing_Properties_Email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vCard_Telecommunications_Addressing_Properties_Email` (
  `idvCard_Telecommunications_Addressing_Properties_Email` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vCard_Explanatory_Properties_idvCard_Explanatory_Properties` bigint(20) unsigned NOT NULL,
  `EMAIL` char(64) NOT NULL,
  `EmailType` set('AOL','AppleLink','POWERSHARE','ATTMail','CIS','eWorld','INTERNET','IBMMail','MCIMail','PRODIGY','TLX','X400') DEFAULT NULL,
  PRIMARY KEY (`idvCard_Telecommunications_Addressing_Properties_Email`,`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`),
  KEY `fk_vCard_Telecommunications_Addressing_Properties_Email_vCard1` (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`),
  KEY `k_Email` (`EMAIL`),
  CONSTRAINT `fk_vCard_Telecommunications_Addressing_Properties_Email_vCard1` FOREIGN KEY (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) REFERENCES `vCard_Explanatory_Properties` (`idvCard_Explanatory_Properties`)
) ENGINE=InnoDB AUTO_INCREMENT=460 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vCard_Telecommunications_Addressing_Properties_Email`
--

LOCK TABLES `vCard_Telecommunications_Addressing_Properties_Email` WRITE;
/*!40000 ALTER TABLE `vCard_Telecommunications_Addressing_Properties_Email` DISABLE KEYS */;
INSERT INTO `vCard_Telecommunications_Addressing_Properties_Email` VALUES (417,160,'chunshengster@gmail.com','INTERNET'),(418,161,'xizhuo@gmail.com','INTERNET'),(419,162,'chunshengster@gmail.com','INTERNET'),(420,163,'xizhuo@gmail.com','INTERNET'),(421,164,'chunshengster@gmail.com','INTERNET'),(422,165,'xizhuo@gmail.com','INTERNET'),(423,166,'fumin18@wo.com.cn','INTERNET'),(424,169,'fumin18@wo.com.cn','INTERNET'),(425,173,'fumin18@wo.com.cn','INTERNET'),(426,182,'fumin18@wo.com.cn','INTERNET'),(427,183,'fumin18@wo.com.cn','INTERNET'),(428,184,'fumin18@wo.com.cn','INTERNET'),(429,185,'fumin18@wo.com.cn','INTERNET'),(430,186,'fumin18@wo.com.cn','INTERNET'),(431,187,'fumin18@wo.com.cn','INTERNET'),(432,188,'fumin18@wo.com.cn','INTERNET'),(433,189,'fumin18@wo.com.cn','INTERNET'),(435,190,'vanilla_cn@hotmail.com','INTERNET'),(436,209,'fumin18@wo.com.cn','INTERNET'),(437,210,'fumin18@wo.com.cn','INTERNET'),(438,211,'fumin18@wo.com.cn','INTERNET'),(439,212,'fumin18@wo.com.cn','INTERNET'),(440,213,'fumin18@wo.com.cn','INTERNET'),(441,214,'fumin18@wo.com.cn','INTERNET'),(442,215,'fumin18@wo.com.cn','INTERNET'),(443,216,'fumin18@wo.com.cn','INTERNET'),(444,217,'fumin18@wo.com.cn','INTERNET'),(445,218,'xizhuo@wo.com.cn','INTERNET'),(446,219,'xizhuo@wo.com.cn','INTERNET'),(447,220,'xizhuo@gmail.com','INTERNET'),(448,221,'hr2008@sina.com','INTERNET'),(449,222,'chifeng@gmail.com','INTERNET'),(450,223,'chifeng@gmail.com','INTERNET'),(451,224,'phillip.wu@infothinker.com','INTERNET'),(452,224,'phillip.wu@gmail.com','INTERNET'),(453,224,'phillip.wu@infominker.com','INTERNET'),(454,225,'vanilla_cn@hotmail.com','INTERNET'),(455,226,'hr2009@sina.com','INTERNET'),(456,227,'hr2009@sina.com','INTERNET'),(457,228,'hr2009@sina.com','INTERNET'),(458,229,'hr2009@sina.com','INTERNET'),(459,230,'hr2009@sina.com','INTERNET');
/*!40000 ALTER TABLE `vCard_Telecommunications_Addressing_Properties_Email` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vCard_Telecommunications_Addressing_Properties_Tel`
--

DROP TABLE IF EXISTS `vCard_Telecommunications_Addressing_Properties_Tel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vCard_Telecommunications_Addressing_Properties_Tel` (
  `idvCard_Telecommunications_Addressing_Properties_Tel` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vCard_Explanatory_Properties_idvCard_Explanatory_Properties` bigint(20) unsigned NOT NULL,
  `TEL` char(32) DEFAULT NULL,
  `TelType` set('PREF','WORK','HOME','VOICE','FAX','MSG','CELL','PAGER','BBS','CAR','VIDEO') DEFAULT NULL,
  PRIMARY KEY (`idvCard_Telecommunications_Addressing_Properties_Tel`,`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`),
  KEY `fk_vCard_Telecommunications_Addressing_Properties_vCard_Expla1` (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`),
  CONSTRAINT `fk_vCard_Telecommunications_Addressing_Properties_vCard_Expla1` FOREIGN KEY (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) REFERENCES `vCard_Explanatory_Properties` (`idvCard_Explanatory_Properties`)
) ENGINE=InnoDB AUTO_INCREMENT=1329 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vCard_Telecommunications_Addressing_Properties_Tel`
--

LOCK TABLES `vCard_Telecommunications_Addressing_Properties_Tel` WRITE;
/*!40000 ALTER TABLE `vCard_Telecommunications_Addressing_Properties_Tel` DISABLE KEYS */;
INSERT INTO `vCard_Telecommunications_Addressing_Properties_Tel` VALUES (1273,160,'01066505725','WORK'),(1274,160,'18601108230','CELL'),(1275,161,'01066505754','HOME'),(1276,161,'18601108230','CELL'),(1277,162,'01066505725','WORK'),(1278,162,'18601108092','CELL'),(1279,163,'01066505754','WORK'),(1280,163,'18601108230','CELL'),(1281,164,'01066505725','WORK'),(1282,164,'18601108092','CELL'),(1283,165,'01066505754','HOME'),(1285,166,'+8618601318706','CELL'),(1286,167,'13501216934','CELL'),(1287,168,'13501216934','HOME'),(1288,169,'+8618601318706','CELL'),(1289,170,'13501216934','CELL'),(1290,171,'13501216934','CELL'),(1291,172,'13501216934','CELL'),(1292,173,'+8618601318706','CELL'),(1293,177,'+8618601318706','CELL'),(1294,178,'+8618601318706','CELL'),(1295,179,'+8618601318706','CELL'),(1296,180,'+8618601318706','CELL'),(1297,181,'+8618601318706','CELL'),(1298,182,'+8618601318706','CELL'),(1299,183,'+8618601318706','CELL'),(1300,184,'+8618601318706','CELL'),(1301,185,'+8618601318706','CELL'),(1302,186,'+8618601318706','CELL'),(1303,187,'+8618601318706','CELL'),(1304,188,'+8618601318706','CELL'),(1305,189,'+8618601318706','CELL'),(1306,165,'18601108092','CELL'),(1308,190,'18601108092','HOME'),(1310,190,'13810154053','HOME'),(1311,209,'+8618601318706','CELL'),(1312,210,'+8618601318706','CELL'),(1313,211,'+8618601318706','CELL'),(1314,212,'+8618601318706','CELL'),(1315,213,'+8618601318706','CELL'),(1316,214,'+8618601318706','CELL'),(1317,215,'+8618601318706','CELL'),(1318,216,'+8618601318706','CELL'),(1319,217,'+8618601318706','CELL'),(1320,218,'+86186011108230','CELL'),(1321,219,'+86186011108230','CELL'),(1322,220,'+86186011108230','CELL'),(1323,221,'13501247001','CELL'),(1324,224,'00862083835210','WORK,VOICE'),(1325,224,'02083824884','WORK,FAX'),(1326,224,'13500005016','VOICE,CELL'),(1327,225,'18601108092','HOME'),(1328,225,'13810154053','HOME');
/*!40000 ALTER TABLE `vCard_Telecommunications_Addressing_Properties_Tel` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-05-24 17:47:26
