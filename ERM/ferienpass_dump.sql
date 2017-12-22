CREATE DATABASE  IF NOT EXISTS `Ferienpass` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `Ferienpass`;
-- MySQL dump 10.13  Distrib 5.7.19, for Linux (x86_64)
--
-- Host: localhost    Database: Ferienpass
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.16.04.1

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
-- Table structure for table `Account`
--

DROP TABLE IF EXISTS `Account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Account` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(80) NOT NULL,
  `Passwort` text NOT NULL,
  `Rechnungsadresse` varchar(80) NOT NULL,
  `Ort` varchar(50) NOT NULL,
  `PLZ` int(11) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `is_member` tinyint(1) NOT NULL DEFAULT '0',
  `zu_bezahlen_rp` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Email_UNIQUE` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Account`
--

LOCK TABLES `Account` WRITE;
/*!40000 ALTER TABLE `Account` DISABLE KEYS */;
INSERT INTO `Account` VALUES (1,'janosh.b@bluewin.ch','$2y$10$XLJYeIX.gzSuwLwET7A81.dpwEzomGl0/E0wtt7gye9BeET0WMF8i','Nicerdicerstreet 42','Pfyn',8505,1,0,NULL),(2,'alex@alexi.ch','$2y$10$STIU5TfRj4TlJpYG0aBiduqHQyp3QCUSn44BRjDYlCNddbXcghXdq','BZT Frauenfeld','Frauenfeld',8500,1,0,NULL),(3,'lila@gmail.com','$2y$10$klT1jbxMqmSn/QjGxc/DU.yJDrXB1JKvKonArSh7VSg1OtzinkK76','Hine Links 42','Luzern',6003,0,0,NULL);
/*!40000 ALTER TABLE `Account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Event`
--

DROP TABLE IF EXISTS `Event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Event` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Titel` varchar(80) NOT NULL,
  `Event_start` datetime NOT NULL,
  `Event_ende` datetime NOT NULL,
  `Phase_1` datetime NOT NULL,
  `Phase_2` datetime NOT NULL,
  `Anmeldeschluss` datetime NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Titel_UNIQUE` (`Titel`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Event`
--

LOCK TABLES `Event` WRITE;
/*!40000 ALTER TABLE `Event` DISABLE KEYS */;
INSERT INTO `Event` VALUES (1,'Ferienpass 2018','2018-04-02 00:00:00','2018-04-13 00:00:00','2018-02-01 12:00:00','2018-03-01 12:00:00','2018-03-26 00:00:00',0);
/*!40000 ALTER TABLE `Event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Klasse`
--

DROP TABLE IF EXISTS `Klasse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Klasse` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Klassenbezeichnung` varchar(15) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Klasse`
--

LOCK TABLES `Klasse` WRITE;
/*!40000 ALTER TABLE `Klasse` DISABLE KEYS */;
INSERT INTO `Klasse` VALUES (1,'1. Kindergarten'),(2,'2. Kindergarten'),(3,'1. Klasse'),(4,'2. Klasse'),(5,'3. Klasse'),(6,'4. Klasse'),(7,'5. Klasse'),(8,'6. Klasse'),(9,'-');
/*!40000 ALTER TABLE `Klasse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Kurs`
--

DROP TABLE IF EXISTS `Kurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Kurs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(80) NOT NULL,
  `Beschreibung` text NOT NULL,
  `Treffpunkt` text NOT NULL,
  `Teilnehmer_min` int(11) DEFAULT NULL,
  `Teilnehmer_max` int(11) DEFAULT NULL,
  `Preis_Mitglieder_rp` int(11) NOT NULL,
  `Preis_Nichtmitglieder_rp` int(11) NOT NULL,
  `Besonderes` text,
  `Leitung` varchar(80) NOT NULL,
  `rPfad_Vorschaubild` varchar(80) DEFAULT NULL,
  `Event_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_Kurs_Event1_idx` (`Event_ID`),
  CONSTRAINT `fk_Kurs_Event1` FOREIGN KEY (`Event_ID`) REFERENCES `Event` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Kurs`
--

LOCK TABLES `Kurs` WRITE;
/*!40000 ALTER TABLE `Kurs` DISABLE KEYS */;
INSERT INTO `Kurs` VALUES (1,'Schwimmen','Du kannst noch nicht schwimmen? Lerne es in einem Tag!','Hallenbad Frauenfeld',3,15,1000,2000,'Badehosen und Badetuch selber mitbringen','Leroid Schwimmer',NULL,1),(2,'PHP coden','Du willst deine eigene Webseite erstellen? Lerne mit PHP eine Webapplikation nach MVC-Entwursmuster zu implementieren.','BZT Frauenfeld',1,4,1500,3000,'eigener Laptop (kein Toaster) mitbringen','Alexander Schenkel',NULL,1),(3,'Reiten','Auf dem Bauernhof \"Naturhof Pfyn\" hast du die einmalige Gelegenheit das Reiten zu erleben.','Naturhof Pfyn, Hine Links 6, 8505 Pfyn',1,6,1000,2300,NULL,'Frau Hoffer',NULL,1);
/*!40000 ALTER TABLE `Kurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Kurstag`
--

DROP TABLE IF EXISTS `Kurstag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Kurstag` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Datum_Begin` datetime NOT NULL,
  `Datum_Ende` datetime NOT NULL,
  `Klasse_min` int(11) DEFAULT NULL,
  `Klasse_max` int(11) DEFAULT NULL,
  `Anzahl_Helfer` int(11) NOT NULL DEFAULT '0',
  `Kurs_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_Kurstag_Kurs1_idx` (`Kurs_ID`),
  KEY `fk_Kurstag_Klasse1_idx` (`Klasse_min`),
  KEY `fk_Kurstag_Klasse2_idx` (`Klasse_max`),
  CONSTRAINT `fk_Kurstag_Klasse1` FOREIGN KEY (`Klasse_min`) REFERENCES `Klasse` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Kurstag_Klasse2` FOREIGN KEY (`Klasse_max`) REFERENCES `Klasse` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Kurstag_Kurs1` FOREIGN KEY (`Kurs_ID`) REFERENCES `Kurs` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Kurstag`
--

LOCK TABLES `Kurstag` WRITE;
/*!40000 ALTER TABLE `Kurstag` DISABLE KEYS */;
INSERT INTO `Kurstag` VALUES (1,'2018-04-03 09:00:00','2018-04-03 16:00:00',6,8,0,1),(2,'2018-04-10 13:00:00','2018-04-10 18:00:00',8,9,0,2),(3,'2018-04-11 08:00:00','2018-04-11 19:00:00',7,8,0,2),(4,'2018-04-05 14:00:00','2018-04-05 16:00:00',4,7,0,3);
/*!40000 ALTER TABLE `Kurstag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `KurstagTeilnehmerHelfer`
--

DROP TABLE IF EXISTS `KurstagTeilnehmerHelfer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `KurstagTeilnehmerHelfer` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Teilnehmer_m` tinyint(1) NOT NULL,
  `Helfer` tinyint(1) NOT NULL,
  `Person_ID` int(11) NOT NULL,
  `Kurstag_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_KursTeilnehmerHelfer_Person1_idx` (`Person_ID`),
  KEY `fk_KurstagTeilnehmerHelfer_Kurstag1_idx` (`Kurstag_ID`),
  CONSTRAINT `fk_KursTeilnehmerHelfer_Person1` FOREIGN KEY (`Person_ID`) REFERENCES `Person` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_KurstagTeilnehmerHelfer_Kurstag1` FOREIGN KEY (`Kurstag_ID`) REFERENCES `Kurstag` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `KurstagTeilnehmerHelfer`
--

LOCK TABLES `KurstagTeilnehmerHelfer` WRITE;
/*!40000 ALTER TABLE `KurstagTeilnehmerHelfer` DISABLE KEYS */;
/*!40000 ALTER TABLE `KurstagTeilnehmerHelfer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Person`
--

DROP TABLE IF EXISTS `Person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Person` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Vorname` varchar(50) NOT NULL,
  `Nachname` varchar(50) NOT NULL,
  `Geburtsdatum` date NOT NULL,
  `Account_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_Person_Account_idx` (`Account_ID`),
  CONSTRAINT `fk_Person_Account` FOREIGN KEY (`Account_ID`) REFERENCES `Account` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Person`
--

LOCK TABLES `Person` WRITE;
/*!40000 ALTER TABLE `Person` DISABLE KEYS */;
/*!40000 ALTER TABLE `Person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'Ferienpass'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-22 10:58:12
