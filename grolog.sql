-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2018 at 06:24 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `grolog`
--
CREATE DATABASE IF NOT EXISTS `grolog` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `grolog`;

-- --------------------------------------------------------

--
-- Table structure for table `actionlog`
--

DROP TABLE IF EXISTS `actionlog`;
CREATE TABLE IF NOT EXISTS `actionlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL COMMENT 'ip address doing action',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'date action occured',
  `username` varchar(255) NOT NULL COMMENT 'user account',
  `action` varchar(255) NOT NULL COMMENT 'action taken',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='table logs all actions' AUTO_INCREMENT=407 ;

-- --------------------------------------------------------

--
-- Table structure for table `api`
--

DROP TABLE IF EXISTS `api`;
CREATE TABLE IF NOT EXISTS `api` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(64) DEFAULT NULL,
  `authcode` varchar(255) DEFAULT NULL,
  `apikey` varchar(255) DEFAULT NULL,
  `used` varchar(1) DEFAULT 'N',
  `ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

DROP TABLE IF EXISTS `banks`;
CREATE TABLE IF NOT EXISTS `banks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bankName` varchar(255) NOT NULL,
  `bankLocation` varchar(2) NOT NULL DEFAULT 'ES',
  `userAdded` int(11) NOT NULL DEFAULT '35',
  `bankWebsite` varchar(255) NOT NULL DEFAULT 'noaddre.ss',
  `softDeleted` varchar(1) NOT NULL DEFAULT 'N' COMMENT 'N or Y, so breeder wont be removed and error system this slot is here to be the place holder for removed lookups',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `breeder`
--

DROP TABLE IF EXISTS `breeder`;
CREATE TABLE IF NOT EXISTS `breeder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `breederName` varchar(255) NOT NULL,
  `breederLocation` varchar(2) NOT NULL,
  `userAdded` int(11) NOT NULL DEFAULT '0' COMMENT 'The users table userid of the person who added the breeder to the database, 0 is system default',
  `breederWebsite` varchar(255) NOT NULL,
  `softDeleted` varchar(1) DEFAULT 'N' COMMENT 'Y or N, Y if its deleted and no longer an active breeder, N if its still an active breeder',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `caretakerid`
--

DROP TABLE IF EXISTS `caretakerid`;
CREATE TABLE IF NOT EXISTS `caretakerid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(255) NOT NULL,
  `middleName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `dateAddedToDb` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `addressHouseNumber` varchar(255) NOT NULL,
  `addressRoadName` varchar(255) NOT NULL,
  `addressCity` varchar(255) NOT NULL,
  `addressState` varchar(255) NOT NULL,
  `addressZip` varchar(255) NOT NULL,
  `addressCountry` varchar(255) NOT NULL DEFAULT 'US',
  `userId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Table structure for table `emailauth`
--

DROP TABLE IF EXISTS `emailauth`;
CREATE TABLE IF NOT EXISTS `emailauth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `authcode` varchar(255) DEFAULT NULL,
  `timeCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `used` varchar(2) NOT NULL DEFAULT 'N',
  `ip` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=87 ;

-- --------------------------------------------------------

--
-- Table structure for table `feedings`
--

DROP TABLE IF EXISTS `feedings`;
CREATE TABLE IF NOT EXISTS `feedings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caretakerId` int(11) NOT NULL,
  `seedId` int(11) NOT NULL,
  `plantId` int(11) NOT NULL,
  `feedingTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `feedingNuteIds` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `finalweight`
--

DROP TABLE IF EXISTS `finalweight`;
CREATE TABLE IF NOT EXISTS `finalweight` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plantId` int(11) NOT NULL,
  `userIdWet` int(11) DEFAULT NULL,
  `userIdDry` int(11) DEFAULT NULL,
  `wetWeightObtainedDate` timestamp NULL DEFAULT NULL,
  `wetWeightUntrimmedGrams` decimal(65,0) NOT NULL,
  `wetWeightTrimmedGrams` decimal(65,0) NOT NULL,
  `wetWeightUnusableTrimGrams` decimal(65,0) NOT NULL,
  `wetWeightSugarTrimGrams` decimal(65,0) NOT NULL,
  `dryWeightObtainedDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dryWeightUntrimmedGrams` decimal(65,0) NOT NULL,
  `dryWeightTrimmedGrams` decimal(65,0) NOT NULL,
  `dryWeightUnusableTrimGrams` decimal(65,0) NOT NULL,
  `dryWeightSugarTrimGrams` decimal(65,0) NOT NULL,
  `processedWeight` decimal(65,0) NOT NULL COMMENT 'used if making concentrate or hash',
  `willBeProcessed` varchar(255) NOT NULL DEFAULT 'N' COMMENT 'if it is being processed to hash or concentrate. if it is change N to Y',
  `processedType` int(255) DEFAULT NULL COMMENT 'type of processing to be done, NULL none, 1 buble hash, 2 shift, 3 oil, 4 budder, 5 sugar, 6 wax, 7 honey oil, 8 other',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `growspace`
--

DROP TABLE IF EXISTS `growspace`;
CREATE TABLE IF NOT EXISTS `growspace` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roomName` varchar(255) NOT NULL,
  `roomHeight` int(11) NOT NULL,
  `roomWidth` int(11) NOT NULL,
  `roomDepth` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lighting`
--

DROP TABLE IF EXISTS `lighting`;
CREATE TABLE IF NOT EXISTS `lighting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lightType` varchar(255) NOT NULL COMMENT 'led, hps, mhs etc',
  `lightName` varchar(255) NOT NULL,
  `growSpace` int(11) NOT NULL,
  `watts` int(11) NOT NULL,
  `wattsReal` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `nutrientnaming`
--

DROP TABLE IF EXISTS `nutrientnaming`;
CREATE TABLE IF NOT EXISTS `nutrientnaming` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nuteId` int(11) NOT NULL,
  `nuteName` varchar(255) NOT NULL,
  `nuteN` int(11) NOT NULL,
  `nuteP` int(11) NOT NULL,
  `nuteK` int(11) NOT NULL,
  `nuteAdditional` varchar(255) NOT NULL COMMENT 'if nute being used is calmag etc allows custom labeling or percentages',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `plantgrowth`
--

DROP TABLE IF EXISTS `plantgrowth`;
CREATE TABLE IF NOT EXISTS `plantgrowth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plantId` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image` blob NOT NULL,
  `imageName` varchar(255) NOT NULL,
  `imageDescription` varchar(255) NOT NULL,
  `plantHeight` decimal(10,0) NOT NULL,
  `plantWidth` decimal(10,0) NOT NULL,
  `notes` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `plants`
--

DROP TABLE IF EXISTS `plants`;
CREATE TABLE IF NOT EXISTS `plants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `strainId` int(11) NOT NULL,
  `caretakerId` int(11) NOT NULL,
  `roomId` int(11) NOT NULL,
  `whenObtained` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `whenPlanted` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `whenSprouted` timestamp NULL DEFAULT NULL,
  `harvested` varchar(1) NOT NULL DEFAULT 'N' COMMENT 'Y or N, easy access for the database to know if its a LIVE plant or if it was already harvested',
  `whenHarvested` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `whereObtainedId` int(11) NOT NULL,
  `breeder` int(11) NOT NULL,
  `softDeleted` varchar(1) NOT NULL DEFAULT 'N' COMMENT 'Y or N, soft deletes a plant so it is nevere removed from the system even if deleted from the front end',
  `userIdHarvested` int(11) DEFAULT NULL,
  `finalDryWeightObtained` varchar(1) NOT NULL DEFAULT 'N' COMMENT 'has the dry weight been entered? Y for yes N for no. will dicteate if dry or harvested comes up',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=120 ;

-- --------------------------------------------------------

--
-- Table structure for table `plantupdates`
--

DROP TABLE IF EXISTS `plantupdates`;
CREATE TABLE IF NOT EXISTS `plantupdates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plantId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `submissionTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` varchar(255) NOT NULL,
  `nutrientUpdate` varchar(1) NOT NULL DEFAULT 'N' COMMENT 'Y or No if nutrients were used if so then go to check nutrient associated ',
  `nutrientAssociatedUpdate` int(11) DEFAULT NULL COMMENT 'the id for the nutrient feedings table info',
  `photoUploaded` varchar(1) NOT NULL DEFAULT 'N' COMMENT 'Y or N if there is a photo associated with the comment upload',
  `fileUploaded` varchar(255) DEFAULT NULL COMMENT 'the filename for the file upload',
  `softDeleted` varchar(1) DEFAULT 'N' COMMENT 'Y or N. If comment is deleted from view on the front end',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='comments and updates on the plants, ' AUTO_INCREMENT=123 ;

-- --------------------------------------------------------

--
-- Table structure for table `strain`
--

DROP TABLE IF EXISTS `strain`;
CREATE TABLE IF NOT EXISTS `strain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `breederId` int(11) NOT NULL,
  `strainName` varchar(255) NOT NULL,
  `strainType` int(11) NOT NULL COMMENT '1 photofem, 2 autofem, 3 photoreg, 4 autoreg, 5 ruderalis, 6 other',
  `strainSativa` int(11) NOT NULL,
  `strainIndica` int(11) NOT NULL,
  `strainRuderalis` int(11) NOT NULL,
  `strainWebsite` varchar(255) DEFAULT NULL COMMENT 'webpage describing strain. seedfinder, breeder webpage, etc will work',
  `strainDescription` longtext COMMENT 'breeder or website strain description',
  `seedNumber` int(11) NOT NULL,
  `cloneNumber` int(11) NOT NULL,
  `whereObtained` int(11) NOT NULL,
  `softDeleted` varchar(1) NOT NULL DEFAULT 'N' COMMENT 'N or Y, so breeder wont be removed and error system this slot is here to be the place holder for removed lookups',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) NOT NULL COMMENT 'Two letter state/province code unless not applicable',
  `country` varchar(2) NOT NULL COMMENT 'Two letter country code',
  `signupDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'date of signup',
  `apikey` varchar(1) DEFAULT 'N',
  `apikeycode` varchar(255) DEFAULT NULL,
  `admin` varchar(1) NOT NULL DEFAULT 'N' COMMENT 'N or Y',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

-- --------------------------------------------------------

--
-- Table structure for table `wasteremoval`
--

DROP TABLE IF EXISTS `wasteremoval`;
CREATE TABLE IF NOT EXISTS `wasteremoval` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plantId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `wasteType` int(11) NOT NULL,
  `wasteCenterId` int(11) NOT NULL DEFAULT '1',
  `wasteWeight` decimal(10,0) DEFAULT NULL,
  `wasteVolume` decimal(10,0) DEFAULT NULL,
  `wasteMethod` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
