-- MySQL dump 10.13  Distrib 5.5.49, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: ogerarch-dev-next
-- ------------------------------------------------------
-- Server version	5.5.49-0ubuntu0.14.04.1

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
-- Table structure for table `archFind`
--

DROP TABLE IF EXISTS `archFind`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archFind` (
  `id` int(11) NOT NULL,
  `excavId` int(11) NOT NULL,
  `archFindId` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `archFindIdSort` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `fieldName` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `plotName` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `section` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `area` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `profile` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `atStepLowering` tinyint(4) NOT NULL,
  `atStepCleaningRaw` tinyint(4) NOT NULL,
  `atStepCleaningFine` tinyint(4) NOT NULL,
  `atStepOther` tinyint(4) NOT NULL,
  `isStrayFind` tinyint(4) NOT NULL,
  `interpretation` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `datingSpec` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `datingPeriodId` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `planName` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `interfaceIdList` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `archObjectIdList` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `archObjGroupIdList` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `specialArchFind` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `ceramicsCountId` int(11) NOT NULL,
  `animalBoneCountId` int(11) NOT NULL,
  `humanBoneCountId` int(11) NOT NULL,
  `ferrousCountId` int(11) NOT NULL,
  `nonFerrousMetalCountId` int(11) NOT NULL,
  `glassCountId` int(11) NOT NULL,
  `architecturalCeramicsCountId` int(11) NOT NULL,
  `daubCountId` int(11) NOT NULL,
  `stoneCountId` int(11) NOT NULL,
  `silexCountId` int(11) NOT NULL,
  `mortarCountId` int(11) NOT NULL,
  `timberCountId` int(11) NOT NULL,
  `organic` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `archFindOther` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `sedimentSampleCountId` int(11) NOT NULL,
  `slurrySampleCountId` int(11) NOT NULL,
  `charcoalSampleCountId` int(11) NOT NULL,
  `mortarSampleCountId` int(11) NOT NULL,
  `slagSampleCountId` int(11) NOT NULL,
  `sampleOther` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `excav_find` (`excavId`,`archFindId`),
  UNIQUE KEY `excav_findSort` (`excavId`,`archFindIdSort`),
  CONSTRAINT `archFind_ibfk_1` FOREIGN KEY (`excavId`) REFERENCES `excavation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `archFindCatalog`
--

DROP TABLE IF EXISTS `archFindCatalog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archFindCatalog` (
  `excavId` int(11) NOT NULL,
  `catalogId` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `partId` int(11) NOT NULL,
  `archFindId` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `denotation` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `subType` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `material` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `lengthValue` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `diaMeter` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`excavId`,`catalogId`,`partId`),
  KEY `archFindId` (`archFindId`),
  CONSTRAINT `archFindCatalog_ibfk_1` FOREIGN KEY (`excavId`) REFERENCES `excavation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `archObjGroup`
--

DROP TABLE IF EXISTS `archObjGroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archObjGroup` (
  `id` int(11) NOT NULL,
  `excavId` int(11) NOT NULL,
  `archObjGroupId` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `typeId` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `typeSerial` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `interpretation` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `datingSpec` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `datingPeriodId` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `listComment` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `excav_objgroup` (`excavId`,`archObjGroupId`),
  CONSTRAINT `archObjGroup_ibfk_1` FOREIGN KEY (`excavId`) REFERENCES `excavation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `archObjGroupToArchObject`
--

DROP TABLE IF EXISTS `archObjGroupToArchObject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archObjGroupToArchObject` (
  `id` int(11) NOT NULL,
  `excavId` int(11) NOT NULL,
  `archObjGroupId` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `archObjectId` char(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `excav_object` (`excavId`,`archObjectId`),
  KEY `excav_objgroup` (`excavId`,`archObjGroupId`),
  CONSTRAINT `archObjGroupToArchObject_ibfk_1` FOREIGN KEY (`excavId`) REFERENCES `excavation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `archObjGroupType`
--

DROP TABLE IF EXISTS `archObjGroupType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archObjGroupType` (
  `id` int(11) NOT NULL,
  `name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `beginDate` date NOT NULL,
  `endDate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `archObject`
--

DROP TABLE IF EXISTS `archObject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archObject` (
  `id` int(11) NOT NULL,
  `excavId` int(11) NOT NULL,
  `archObjectId` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `typeId` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `typeSerial` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `interpretation` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `datingSpec` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `datingPeriodId` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `listComment` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `excav_object` (`excavId`,`archObjectId`),
  CONSTRAINT `archObject_ibfk_1` FOREIGN KEY (`excavId`) REFERENCES `excavation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `archObjectToStratum`
--

DROP TABLE IF EXISTS `archObjectToStratum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archObjectToStratum` (
  `id` int(11) NOT NULL,
  `excavId` int(11) NOT NULL,
  `archObjectId` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `stratumId` char(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `excav_object` (`excavId`,`archObjectId`),
  KEY `excav_stratum` (`excavId`,`stratumId`),
  CONSTRAINT `archObjectToStratum_ibfk_1` FOREIGN KEY (`excavId`) REFERENCES `excavation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `archObjectType`
--

DROP TABLE IF EXISTS `archObjectType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archObjectType` (
  `id` int(11) NOT NULL,
  `name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `beginDate` date NOT NULL,
  `endDate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cadastralAustria`
--

DROP TABLE IF EXISTS `cadastralAustria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cadastralAustria` (
  `cadastralId` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `districtName` varchar(500) NOT NULL,
  `surveyOfficeName` varchar(500) NOT NULL,
  `regionId` varchar(10) NOT NULL,
  `unknown1` int(11) NOT NULL,
  `communeId` int(11) NOT NULL,
  `communeName` varchar(500) NOT NULL,
  `unknown2` int(11) NOT NULL,
  `geo1a` int(11) NOT NULL,
  `geo1b` int(11) NOT NULL,
  `geo2a` int(11) NOT NULL,
  `geo2b` int(11) NOT NULL,
  PRIMARY KEY (`cadastralId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `name1` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `name2` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `postalCode` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `countryName` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `shortName` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dbStructLog`
--

DROP TABLE IF EXISTS `dbStructLog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dbStructLog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `beginTime` datetime NOT NULL,
  `structSerial` int(11) NOT NULL,
  `structTime` datetime NOT NULL,
  `preCheck` text COLLATE utf8_unicode_ci NOT NULL,
  `cmdLog` text COLLATE utf8_unicode_ci NOT NULL,
  `log` text COLLATE utf8_unicode_ci NOT NULL,
  `error` text COLLATE utf8_unicode_ci NOT NULL,
  `postCheck` text COLLATE utf8_unicode_ci NOT NULL,
  `surplus` text COLLATE utf8_unicode_ci NOT NULL,
  `endTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `excavation`
--

DROP TABLE IF EXISTS `excavation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `excavation` (
  `id` int(11) NOT NULL,
  `name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `excavMethodId` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `beginDate` date NOT NULL,
  `endDate` date NOT NULL,
  `authorizedPerson` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `originator` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `officialId` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `officialId2` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `countryName` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `regionName` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `districtName` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `communeName` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `cadastralCommunityName` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `fieldName` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `plotName` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `datingSpec` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `datingPeriodId` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `gpsX` decimal(20,10) DEFAULT NULL,
  `gpsY` decimal(20,10) DEFAULT NULL,
  `gpsZ` decimal(20,10) DEFAULT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `projectBaseDir` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(1) NOT NULL,
  `emailBda` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pdfTemplate`
--

DROP TABLE IF EXISTS `pdfTemplate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pdfTemplate` (
  `id` int(11) NOT NULL,
  `sectionId` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `template` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pictureFile`
--

DROP TABLE IF EXISTS `pictureFile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pictureFile` (
  `id` int(11) NOT NULL,
  `excavId` int(11) NOT NULL,
  `fileName` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `mimeType` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `fileSize` int(11) NOT NULL,
  `isExternal` tinyint(4) NOT NULL,
  `content` longblob NOT NULL,
  `externalStoreFileName` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `title` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `isOverview` tinyint(4) NOT NULL,
  `relevance` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `auxStratumIdList` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `auxArchFindIdList` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `auxSection` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `auxSektor` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `auxPlanum` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `auxProfile` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `auxObject` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `auxGrave` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `auxWall` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `auxComplex` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `datingPeriodId` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `datingSpec` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `excavId` (`excavId`),
  CONSTRAINT `pictureFile_ibfk_1` FOREIGN KEY (`excavId`) REFERENCES `excavation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prepFindTMPNEW`
--

DROP TABLE IF EXISTS `prepFindTMPNEW`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prepFindTMPNEW` (
  `iid` int(11) NOT NULL AUTO_INCREMENT,
  `excavId` int(11) NOT NULL,
  `archFindId` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `archFindIdSort` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `archFindSubId` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `archFindSubIdSort` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `stockLocationId` int(11) NOT NULL,
  `oriArchFindId` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `datingSpec` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `specialArchFind` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `ceramicsCountId` tinyint(4) NOT NULL,
  `animalBoneCountId` tinyint(4) NOT NULL,
  `humanBoneCountId` tinyint(4) NOT NULL,
  `ferrousCountId` tinyint(4) NOT NULL,
  `nonFerrousMetalCountId` tinyint(4) NOT NULL,
  `glassCountId` tinyint(4) NOT NULL,
  `architecturalCeramicsCountId` tinyint(4) NOT NULL,
  `daubCountId` tinyint(4) NOT NULL,
  `stoneCountId` tinyint(4) NOT NULL,
  `silexCountId` tinyint(4) NOT NULL,
  `mortarCountId` tinyint(4) NOT NULL,
  `timberCountId` tinyint(4) NOT NULL,
  `organic` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `archFindOther` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `sedimentSampleCountId` tinyint(4) NOT NULL,
  `slurrySampleCountId` tinyint(4) NOT NULL,
  `charcoalSampleCountId` tinyint(4) NOT NULL,
  `mortarSampleCountId` tinyint(4) NOT NULL,
  `slagSampleCountId` tinyint(4) NOT NULL,
  `sampleOther` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `washStatusId` tinyint(4) NOT NULL,
  `labelStatusId` tinyint(4) NOT NULL,
  `restoreStatusId` tinyint(4) NOT NULL,
  `photographStatusId` tinyint(4) NOT NULL,
  `drawStatusId` tinyint(4) NOT NULL,
  `layoutStatusId` tinyint(4) NOT NULL,
  `scientificStatusId` tinyint(4) NOT NULL,
  `publishStatusId` tinyint(4) NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`iid`),
  UNIQUE KEY `excav_find_sub` (`excavId`,`archFindId`,`archFindSubId`),
  KEY `excavId` (`excavId`),
  KEY `excav_findSort` (`excavId`,`archFindIdSort`),
  KEY `stockLocationId` (`stockLocationId`),
  CONSTRAINT `prepFindTMPNEW_ibfk_1` FOREIGN KEY (`excavId`) REFERENCES `excavation` (`id`),
  CONSTRAINT `prepFindTMPNEW_ibfk_2` FOREIGN KEY (`stockLocationId`) REFERENCES `stockLocation` (`stockLocationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stockLocation`
--

DROP TABLE IF EXISTS `stockLocation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stockLocation` (
  `stockLocationId` int(11) NOT NULL AUTO_INCREMENT,
  `excavId` int(11) DEFAULT NULL,
  `name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `outerId` int(11) NOT NULL,
  `movable` tinyint(4) NOT NULL,
  `reusable` tinyint(4) NOT NULL,
  `typeId` int(11) NOT NULL,
  `maxInnerTypeId` int(11) NOT NULL,
  `canItem` tinyint(4) NOT NULL,
  `canExcavMovable` tinyint(4) NOT NULL,
  `canReusableMovable` int(11) NOT NULL,
  `contentComment` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`stockLocationId`),
  KEY `excavId` (`excavId`),
  CONSTRAINT `stockLocation_ibfk_1` FOREIGN KEY (`excavId`) REFERENCES `excavation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stockLocationType`
--

DROP TABLE IF EXISTS `stockLocationType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stockLocationType` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `sizeClass` int(11) NOT NULL,
  `excavVisible` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stratum`
--

DROP TABLE IF EXISTS `stratum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stratum` (
  `id` int(11) NOT NULL,
  `excavId` int(11) NOT NULL,
  `stratumId` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `stratumIdSort` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `categoryId` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `originator` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `fieldName` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `plotName` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `section` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `area` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `profile` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `typeId` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `interpretation` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `datingSpec` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `datingPeriodId` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pictureReference` text COLLATE utf8_unicode_ci NOT NULL,
  `planDigital` tinyint(4) NOT NULL,
  `planAnalog` tinyint(4) NOT NULL,
  `photogrammetry` tinyint(4) NOT NULL,
  `photoDigital` tinyint(4) NOT NULL,
  `photoSlide` tinyint(4) NOT NULL,
  `photoPrint` tinyint(4) NOT NULL,
  `lengthValue` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `width` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `height` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `diaMeter` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `hasArchFind` tinyint(4) NOT NULL,
  `hasSample` tinyint(4) NOT NULL,
  `hasArchObject` tinyint(4) NOT NULL,
  `hasArchObjGroup` tinyint(4) NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `listComment` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `isTopEdge` tinyint(4) NOT NULL,
  `isBottomEdge` tinyint(4) NOT NULL,
  `hasAutoInterface` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `excav_stratum` (`excavId`,`stratumId`),
  UNIQUE KEY `excv_stratumSort` (`excavId`,`stratumIdSort`),
  CONSTRAINT `stratum_ibfk_1` FOREIGN KEY (`excavId`) REFERENCES `excavation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stratumComplex`
--

DROP TABLE IF EXISTS `stratumComplex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stratumComplex` (
  `id` int(11) NOT NULL,
  `excavId` int(11) NOT NULL,
  `stratumId` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `stratum2Id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `excav_stratum` (`excavId`,`stratumId`),
  CONSTRAINT `stratumComplex_ibfk_1` FOREIGN KEY (`excavId`) REFERENCES `excavation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stratumDeposit`
--

DROP TABLE IF EXISTS `stratumDeposit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stratumDeposit` (
  `id` int(11) NOT NULL,
  `excavId` int(11) NOT NULL,
  `stratumId` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `hardness` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `consistency` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `inclusion` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `orientation` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `incline` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `materialDenotation` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `excav_stratum` (`excavId`,`stratumId`),
  CONSTRAINT `stratumDeposit_ibfk_1` FOREIGN KEY (`excavId`) REFERENCES `excavation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stratumInterface`
--

DROP TABLE IF EXISTS `stratumInterface`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stratumInterface` (
  `id` int(11) NOT NULL,
  `excavId` int(11) NOT NULL,
  `stratumId` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `shape` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `contour` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `intersection` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `vertex` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `sidewall` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `basis` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `excav_stratum` (`excavId`,`stratumId`),
  CONSTRAINT `stratumInterface_ibfk_1` FOREIGN KEY (`excavId`) REFERENCES `excavation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stratumMatrix`
--

DROP TABLE IF EXISTS `stratumMatrix`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stratumMatrix` (
  `id` int(11) NOT NULL,
  `excavId` int(11) NOT NULL,
  `stratumId` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `relation` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `stratum2Id` char(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `excav_stratum` (`excavId`,`stratumId`),
  CONSTRAINT `stratumMatrix_ibfk_1` FOREIGN KEY (`excavId`) REFERENCES `excavation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stratumSkeleton`
--

DROP TABLE IF EXISTS `stratumSkeleton`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stratumSkeleton` (
  `id` int(11) NOT NULL,
  `excavId` int(11) NOT NULL,
  `stratumId` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `bodyPosition` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `orientation` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `boneQuality` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `dislocationNone` tinyint(4) NOT NULL,
  `dislocationBase` tinyint(4) NOT NULL,
  `dislocationShaft` tinyint(4) NOT NULL,
  `dislocationPrivation` tinyint(4) NOT NULL,
  `dislocationDen` tinyint(4) NOT NULL,
  `recoverySingleBones` tinyint(4) NOT NULL,
  `recoveryBlock` tinyint(4) NOT NULL,
  `recoveryHardened` tinyint(4) NOT NULL,
  `specialBurial` tinyint(4) NOT NULL,
  `viewDirection` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `legPosition` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `armPosition` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `positionDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `upperArmRightLength` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `upperArmLeftLength` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `foreArmRightLength` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `foreArmLeftLength` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `thighRightLength` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `thighLeftLength` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `shinRightLength` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `shinLeftLength` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `bodyLength` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `sex` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `age` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `burialCremationId` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cremationDemageStratumIdList` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `cremationDemageDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `coffinStratumIdList` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `tombTimberStratumIdList` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `tombStoneStratumIdList` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `tombBrickStratumIdList` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `tombOtherMaterialStratumIdList` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `tombFormCircleStratumIdList` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `tombFormOvalStratumIdList` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `tombFormRectangleStratumIdList` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `tombFormSquareStratumIdList` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `tombFormOtherStratumIdList` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `tombDemageStratumIdList` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `tombDemageFormId` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tombDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `burialObjectArchFindIdList` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `costumeArchFindIdList` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `depositArchFindIdList` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `tombConstructArchFindIdList` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `excav_stratum` (`excavId`,`stratumId`),
  CONSTRAINT `stratumSkeleton_ibfk_1` FOREIGN KEY (`excavId`) REFERENCES `excavation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stratumTimber`
--

DROP TABLE IF EXISTS `stratumTimber`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stratumTimber` (
  `id` int(11) NOT NULL,
  `excavId` int(11) NOT NULL,
  `stratumId` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `dendrochronology` tinyint(4) NOT NULL,
  `lengthApplyTo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `widthApplyTo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `heightApplyTo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `orientation` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `functionDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `constructDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `relationDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `timberType` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `infill` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `otherConstructMaterial` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `surface` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `preservationStatus` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `physioZoneDullEdge` tinyint(4) NOT NULL,
  `physioZoneSeapWood` tinyint(4) NOT NULL,
  `physioZoneHeartWood` tinyint(4) NOT NULL,
  `secundaryUsage` tinyint(4) NOT NULL,
  `processSign` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `processDetail` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `connection` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `excav_stratum` (`excavId`,`stratumId`),
  CONSTRAINT `stratumTimber_ibfk_1` FOREIGN KEY (`excavId`) REFERENCES `excavation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stratumToArchFind`
--

DROP TABLE IF EXISTS `stratumToArchFind`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stratumToArchFind` (
  `id` int(11) NOT NULL,
  `excavId` int(11) NOT NULL,
  `stratumId` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `archFindId` char(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `excav_archfind` (`excavId`,`archFindId`),
  KEY `excav_stratum` (`excavId`,`stratumId`),
  CONSTRAINT `stratumToArchFind_ibfk_1` FOREIGN KEY (`excavId`) REFERENCES `excavation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stratumType`
--

DROP TABLE IF EXISTS `stratumType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stratumType` (
  `id` int(11) NOT NULL,
  `categoryId` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `beginDate` date NOT NULL,
  `endDate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stratumWall`
--

DROP TABLE IF EXISTS `stratumWall`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stratumWall` (
  `id` int(11) NOT NULL,
  `excavId` int(11) NOT NULL,
  `stratumId` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `datingStratigraphy` tinyint(4) NOT NULL,
  `datingWallStructure` tinyint(4) NOT NULL,
  `lengthApplyTo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `widthApplyTo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `heightRaising` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `heightRaisingApplyTo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `heightFooting` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `heightFootingApplyTo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `constructionType` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `wallBaseType` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `structureType` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `relationDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `layerDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `shellDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `kernelDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `formworkDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `hasPutlogHole` tinyint(4) NOT NULL,
  `putlogHoleDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `hasBarHole` tinyint(4) NOT NULL,
  `barHoleDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `materialType` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `stoneSize` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `stoneMaterial` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `stoneProcessing` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `hasCommonBrick` tinyint(4) NOT NULL,
  `hasVaultBrick` tinyint(4) NOT NULL,
  `hasRoofTile` tinyint(4) NOT NULL,
  `hasFortificationBrick` tinyint(4) NOT NULL,
  `brickDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `hasProductionStampSign` tinyint(4) NOT NULL,
  `hasProductionFingerSign` tinyint(4) NOT NULL,
  `hasProductionOtherAttribute` tinyint(4) NOT NULL,
  `productionDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `mixedWallBrickPercent` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `mixedWallDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `spoilDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `binderState` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `binderType` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `binderColor` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `binderSandPercent` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `binderLimeVisible` tinyint(4) NOT NULL,
  `binderGrainSize` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `binderConsistency` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `additivePebbleSize` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `additiveLimepopSize` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `additiveCrushedTilesSize` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `additiveCharcoalSize` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `additiveStrawSize` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `additiveOtherSize` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `additiveOtherDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `abreuvoirType` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `abreuvoirDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `plasterSurface` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `plasterThickness` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `plasterExtend` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `plasterColor` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `plasterMixture` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `plasterGrainSize` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `plasterConsistency` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `plasterAdditives` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `plasterLayer` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `excav_stratum` (`excavId`,`stratumId`),
  CONSTRAINT `stratumWall_ibfk_1` FOREIGN KEY (`excavId`) REFERENCES `excavation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trash`
--

DROP TABLE IF EXISTS `trash`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trash` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `userName` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `time` datetime NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `logonName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `realName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sslClientDN` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `sslClientIssuerDN` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `logonPerm` tinyint(1) NOT NULL,
  `superPerm` tinyint(1) NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `logonName` (`logonName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `userGroup`
--

DROP TABLE IF EXISTS `userGroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userGroup` (
  `userGroupId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `updateMasterDataPerm` tinyint(4) NOT NULL,
  `insertBookingPerm` int(11) NOT NULL,
  `updateBookingPerm` int(11) NOT NULL,
  PRIMARY KEY (`userGroupId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `userToUserGroup`
--

DROP TABLE IF EXISTS `userToUserGroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userToUserGroup` (
  `userId` int(11) NOT NULL,
  `userGroupId` int(11) NOT NULL,
  PRIMARY KEY (`userId`,`userGroupId`),
  KEY `userGroupId` (`userGroupId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-05-25 15:27:15
