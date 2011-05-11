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
) ENGINE=InnoDB AUTO_INCREMENT=226 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=233 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=220 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=455 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-05-11 11:52:50
