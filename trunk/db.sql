SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `DB_vCard` ;
CREATE SCHEMA IF NOT EXISTS `DB_vCard` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
SHOW WARNINGS;
USE `DB_vCard` ;

-- -----------------------------------------------------
-- Table `User_Contacts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `User_Contacts` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `User_Contacts` (
  `id_user_contacts` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`id_user_contacts`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `vCard_Explanatory_Properties`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `vCard_Explanatory_Properties` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `vCard_Explanatory_Properties` (
  `idvCard_Explanatory_Properties` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `UID` CHAR(64) NOT NULL ,
  `VERSION` CHAR(3) NOT NULL DEFAULT 2.1 ,
  `REV` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  `LANG` CHAR(16) NULL DEFAULT NULL ,
  `CATEGORIES` VARCHAR(45) NULL ,
  `PRODID` VARCHAR(45) NULL ,
  `SORT-STRING` VARCHAR(45) NULL ,
  PRIMARY KEY (`idvCard_Explanatory_Properties`) )
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE UNIQUE INDEX `UID_UNIQUE` ON `vCard_Explanatory_Properties` (`UID` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `vCard_Identification_Properties`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `vCard_Identification_Properties` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `vCard_Identification_Properties` (
  `idvCard_Identification_Properties` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `vCard_Explanatory_Properties_idvCard_Explanatory_Properties` BIGINT UNSIGNED NOT NULL ,
  `FN` CHAR(64) NULL DEFAULT NULL ,
  `N` CHAR(64) NULL DEFAULT NULL ,
  `NICKNAME` CHAR(64) NULL ,
  `PHOTO` BLOB NULL DEFAULT NULL ,
  `PhotoType` ENUM('GIF','BMP','JPEG') NULL DEFAULT NULL ,
  `BDAY` DATE NULL DEFAULT NULL ,
  `URL` VARCHAR(256) NULL DEFAULT NULL ,
  `SOUND` BLOB NULL DEFAULT NULL ,
  `NOTE` VARCHAR(1024) NULL DEFAULT NULL ,
  PRIMARY KEY (`idvCard_Identification_Properties`, `vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) ,
  CONSTRAINT `fk_vCard_Identification_Properties_vCard_Explanatory_Properti1`
    FOREIGN KEY (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` )
    REFERENCES `vCard_Explanatory_Properties` (`idvCard_Explanatory_Properties` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_vCard_Identification_Properties_vCard_Explanatory_Properti1` ON `vCard_Identification_Properties` (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `vCard_Delivery_Addressing_Properties_ADR`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `vCard_Delivery_Addressing_Properties_ADR` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `vCard_Delivery_Addressing_Properties_ADR` (
  `idvCard_Delivery_Addressing_Properties_ADR` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `vCard_Explanatory_Properties_idvCard_Explanatory_Properties` BIGINT UNSIGNED NOT NULL ,
  `ADR` BLOB NULL DEFAULT NULL ,
  `AdrType` SET('DOM','INTL','POSTAL','PARCEL','HOME','WORK') NULL DEFAULT NULL ,
  PRIMARY KEY (`idvCard_Delivery_Addressing_Properties_ADR`, `vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) ,
  CONSTRAINT `fk_vCard_Delivvery_Addressing_Properties_vCard_Explanatory_Pr1`
    FOREIGN KEY (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` )
    REFERENCES `vCard_Explanatory_Properties` (`idvCard_Explanatory_Properties` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_vCard_Delivvery_Addressing_Properties_vCard_Explanatory_Pr1` ON `vCard_Delivery_Addressing_Properties_ADR` (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `vCard_Telecommunications_Addressing_Properties_Tel`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `vCard_Telecommunications_Addressing_Properties_Tel` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `vCard_Telecommunications_Addressing_Properties_Tel` (
  `idvCard_Telecommunications_Addressing_Properties_Tel` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `vCard_Explanatory_Properties_idvCard_Explanatory_Properties` BIGINT UNSIGNED NOT NULL ,
  `TEL` CHAR(32) NULL DEFAULT NULL ,
  `TelType` SET('PREF','WORK','HOME','VOICE','FAX','MSG','CELL','PAGER','BBS','CAR','VIDEO') NULL DEFAULT NULL ,
  PRIMARY KEY (`idvCard_Telecommunications_Addressing_Properties_Tel`, `vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) ,
  CONSTRAINT `fk_vCard_Telecommunications_Addressing_Properties_vCard_Expla1`
    FOREIGN KEY (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` )
    REFERENCES `vCard_Explanatory_Properties` (`idvCard_Explanatory_Properties` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_vCard_Telecommunications_Addressing_Properties_vCard_Expla1` ON `vCard_Telecommunications_Addressing_Properties_Tel` (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `vCard_Geographical_Properties`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `vCard_Geographical_Properties` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `vCard_Geographical_Properties` (
  `idvCard_Geographical_Properties` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `vCard_Explanatory_Properties_idvCard_Explanatory_Properties` BIGINT UNSIGNED NOT NULL ,
  `TZ` CHAR(8) NOT NULL ,
  `GEO` CHAR(32) NOT NULL ,
  PRIMARY KEY (`idvCard_Geographical_Properties`, `vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) ,
  CONSTRAINT `fk_vCard_Geographical_Properties_vCard_Explanatory_Properties1`
    FOREIGN KEY (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` )
    REFERENCES `vCard_Explanatory_Properties` (`idvCard_Explanatory_Properties` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_vCard_Geographical_Properties_vCard_Explanatory_Properties1` ON `vCard_Geographical_Properties` (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `vCard_Organizational_Properties`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `vCard_Organizational_Properties` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `vCard_Organizational_Properties` (
  `idvCard_Organizational_Properties` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `vCard_Explanatory_Properties_idvCard_Explanatory_Properties` BIGINT UNSIGNED NOT NULL ,
  `TITLE` CHAR(64) NULL DEFAULT NULL ,
  `ROLE` CHAR(128) NULL DEFAULT NULL ,
  `LOGO` BLOB NULL DEFAULT NULL ,
  `LogoType` ENUM('GIF','BMP','JPEG') NULL DEFAULT NULL ,
  `AGENT` BLOB NULL ,
  `ORG` BLOB NULL DEFAULT NULL ,
  PRIMARY KEY (`idvCard_Organizational_Properties`, `vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) ,
  CONSTRAINT `fk_vCard_Organizational_Properties_vCard_Explanatory_Properti1`
    FOREIGN KEY (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` )
    REFERENCES `vCard_Explanatory_Properties` (`idvCard_Explanatory_Properties` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_vCard_Organizational_Properties_vCard_Explanatory_Properti1` ON `vCard_Organizational_Properties` (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `vCard_Telecommunications_Addressing_Properties_Email`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `vCard_Telecommunications_Addressing_Properties_Email` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `vCard_Telecommunications_Addressing_Properties_Email` (
  `idvCard_Telecommunications_Addressing_Properties_Email` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `vCard_Explanatory_Properties_idvCard_Explanatory_Properties` BIGINT UNSIGNED NOT NULL ,
  `EMAIL` CHAR(64) NOT NULL ,
  `EmailType` SET('AOL','AppleLink','POWERSHARE','ATTMail','CIS','eWorld','INTERNET','IBMMail','MCIMail','PRODIGY','TLX','X400') NULL DEFAULT NULL ,
  PRIMARY KEY (`idvCard_Telecommunications_Addressing_Properties_Email`, `vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) ,
  CONSTRAINT `fk_vCard_Telecommunications_Addressing_Properties_Email_vCard1`
    FOREIGN KEY (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` )
    REFERENCES `vCard_Explanatory_Properties` (`idvCard_Explanatory_Properties` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_vCard_Telecommunications_Addressing_Properties_Email_vCard1` ON `vCard_Telecommunications_Addressing_Properties_Email` (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` ASC) ;

SHOW WARNINGS;
CREATE INDEX `k_Email` ON `vCard_Telecommunications_Addressing_Properties_Email` (`EMAIL` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `vCard_Delivery_Addressing_Properties_LABEL`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `vCard_Delivery_Addressing_Properties_LABEL` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `vCard_Delivery_Addressing_Properties_LABEL` (
  `idvCard_Delivery_Addressing_Properties_LABEL` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `vCard_Explanatory_Properties_idvCard_Explanatory_Properties` BIGINT UNSIGNED NOT NULL ,
  `LABEL` BLOB NULL DEFAULT NULL ,
  `LabelType` SET('DOM','INTL','POSTAL','PARCEL','HOME','WORK') NULL DEFAULT NULL ,
  PRIMARY KEY (`idvCard_Delivery_Addressing_Properties_LABEL`, `vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) ,
  CONSTRAINT `fk_vCard_Delivvery_Addressing_Properties_LABEL_vCard_Explanat1`
    FOREIGN KEY (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` )
    REFERENCES `vCard_Explanatory_Properties` (`idvCard_Explanatory_Properties` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;

SHOW WARNINGS;
CREATE INDEX `fk_vCard_Delivvery_Addressing_Properties_LABEL_vCard_Explanat1` ON `vCard_Delivery_Addressing_Properties_LABEL` (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` ASC) ;

SHOW WARNINGS;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
