SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `DB_vCard` ;
CREATE SCHEMA IF NOT EXISTS `DB_vCard` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
SHOW WARNINGS;
USE `DB_vCard` ;

-- -----------------------------------------------------
-- Table `DB_vCard`.`vCard_Explanatory_Properties`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `DB_vCard`.`vCard_Explanatory_Properties` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `DB_vCard`.`vCard_Explanatory_Properties` (
  `idvCard_Explanatory_Properties` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `UID` CHAR(64) NOT NULL ,
  `VERSION` CHAR(3) NOT NULL DEFAULT '2.1' ,
  `REV` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `LANG` CHAR(16) NULL DEFAULT NULL ,
  `CATEGORIES` VARCHAR(45) NULL DEFAULT NULL ,
  `PRODID` VARCHAR(45) NULL DEFAULT NULL ,
  `SORT-STRING` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`idvCard_Explanatory_Properties`) )
ENGINE = InnoDB
AUTO_INCREMENT = 261
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
CREATE UNIQUE INDEX `UID_UNIQUE` ON `DB_vCard`.`vCard_Explanatory_Properties` (`UID` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `DB_vCard`.`vCard_Delivery_Addressing_Properties_ADR`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `DB_vCard`.`vCard_Delivery_Addressing_Properties_ADR` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `DB_vCard`.`vCard_Delivery_Addressing_Properties_ADR` (
  `idvCard_Delivery_Addressing_Properties_ADR` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `vCard_Explanatory_Properties_idvCard_Explanatory_Properties` BIGINT(20) UNSIGNED NOT NULL ,
  `ADR` BLOB NULL DEFAULT NULL ,
  `AdrType` SET('DOM','INTL','POSTAL','PARCEL','HOME','WORK') NULL DEFAULT NULL ,
  PRIMARY KEY (`idvCard_Delivery_Addressing_Properties_ADR`, `vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) ,
  CONSTRAINT `fk_vCard_Delivvery_Addressing_Properties_vCard_Explanatory_Pr1`
    FOREIGN KEY (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` )
    REFERENCES `DB_vCard`.`vCard_Explanatory_Properties` (`idvCard_Explanatory_Properties` ))
ENGINE = InnoDB
AUTO_INCREMENT = 532
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
CREATE INDEX `fk_vCard_Delivvery_Addressing_Properties_vCard_Explanatory_Pr1` ON `DB_vCard`.`vCard_Delivery_Addressing_Properties_ADR` (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `DB_vCard`.`vCard_Delivery_Addressing_Properties_LABEL`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `DB_vCard`.`vCard_Delivery_Addressing_Properties_LABEL` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `DB_vCard`.`vCard_Delivery_Addressing_Properties_LABEL` (
  `idvCard_Delivery_Addressing_Properties_LABEL` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `vCard_Explanatory_Properties_idvCard_Explanatory_Properties` BIGINT(20) UNSIGNED NOT NULL ,
  `LABEL` BLOB NULL DEFAULT NULL ,
  `LabelType` SET('DOM','INTL','POSTAL','PARCEL','HOME','WORK') NULL DEFAULT NULL ,
  PRIMARY KEY (`idvCard_Delivery_Addressing_Properties_LABEL`, `vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) ,
  CONSTRAINT `fk_vCard_Delivvery_Addressing_Properties_LABEL_vCard_Explanat1`
    FOREIGN KEY (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` )
    REFERENCES `DB_vCard`.`vCard_Explanatory_Properties` (`idvCard_Explanatory_Properties` ))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
CREATE INDEX `fk_vCard_Delivvery_Addressing_Properties_LABEL_vCard_Explanat1` ON `DB_vCard`.`vCard_Delivery_Addressing_Properties_LABEL` (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `DB_vCard`.`vCard_Extension_Properties`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `DB_vCard`.`vCard_Extension_Properties` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `DB_vCard`.`vCard_Extension_Properties` (
  `idvCard_Extension_Properties` BIGINT(20) NOT NULL AUTO_INCREMENT ,
  `vCard_Explanatory_Properties_idvCard_Explanatory_Properties` BIGINT(20) UNSIGNED NOT NULL ,
  `ExtensionName` CHAR(32) NOT NULL ,
  `ExtensionValue` BLOB NULL DEFAULT NULL ,
  PRIMARY KEY (`idvCard_Extension_Properties`, `vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) ,
  CONSTRAINT `fk_vCard_Extension_Properties_vCard_Explanatory_Properties1`
    FOREIGN KEY (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` )
    REFERENCES `DB_vCard`.`vCard_Explanatory_Properties` (`idvCard_Explanatory_Properties` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
CREATE INDEX `fk_vCard_Extension_Properties_vCard_Explanatory_Properties1` ON `DB_vCard`.`vCard_Extension_Properties` (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `DB_vCard`.`vCard_Geographical_Properties`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `DB_vCard`.`vCard_Geographical_Properties` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `DB_vCard`.`vCard_Geographical_Properties` (
  `idvCard_Geographical_Properties` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `vCard_Explanatory_Properties_idvCard_Explanatory_Properties` BIGINT(20) UNSIGNED NOT NULL ,
  `TZ` CHAR(8) NOT NULL ,
  `GEO` CHAR(32) NOT NULL ,
  PRIMARY KEY (`idvCard_Geographical_Properties`, `vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) ,
  CONSTRAINT `fk_vCard_Geographical_Properties_vCard_Explanatory_Properties1`
    FOREIGN KEY (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` )
    REFERENCES `DB_vCard`.`vCard_Explanatory_Properties` (`idvCard_Explanatory_Properties` ))
ENGINE = InnoDB
AUTO_INCREMENT = 191
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
CREATE INDEX `fk_vCard_Geographical_Properties_vCard_Explanatory_Properties1` ON `DB_vCard`.`vCard_Geographical_Properties` (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `DB_vCard`.`vCard_Identification_Properties`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `DB_vCard`.`vCard_Identification_Properties` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `DB_vCard`.`vCard_Identification_Properties` (
  `idvCard_Identification_Properties` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `vCard_Explanatory_Properties_idvCard_Explanatory_Properties` BIGINT(20) UNSIGNED NOT NULL ,
  `FN` CHAR(64) NULL DEFAULT NULL ,
  `N` CHAR(64) NULL DEFAULT NULL ,
  `NICKNAME` CHAR(64) NULL DEFAULT NULL ,
  `PHOTO` BLOB NULL DEFAULT NULL ,
  `PhotoType` ENUM('GIF','BMP','JPEG','URL') CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL DEFAULT NULL ,
  `BDAY` DATE NULL DEFAULT NULL ,
  `URL` VARCHAR(256) NULL DEFAULT NULL ,
  `SOUND` BLOB NULL DEFAULT NULL ,
  `NOTE` VARCHAR(1024) NULL DEFAULT NULL ,
  PRIMARY KEY (`idvCard_Identification_Properties`, `vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) ,
  CONSTRAINT `fk_vCard_Identification_Properties_vCard_Explanatory_Properti1`
    FOREIGN KEY (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` )
    REFERENCES `DB_vCard`.`vCard_Explanatory_Properties` (`idvCard_Explanatory_Properties` ))
ENGINE = InnoDB
AUTO_INCREMENT = 265
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
CREATE INDEX `fk_vCard_Identification_Properties_vCard_Explanatory_Properti1` ON `DB_vCard`.`vCard_Identification_Properties` (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `DB_vCard`.`vCard_Organizational_Properties`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `DB_vCard`.`vCard_Organizational_Properties` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `DB_vCard`.`vCard_Organizational_Properties` (
  `idvCard_Organizational_Properties` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `vCard_Explanatory_Properties_idvCard_Explanatory_Properties` BIGINT(20) UNSIGNED NOT NULL ,
  `TITLE` CHAR(64) NULL DEFAULT NULL ,
  `ROLE` CHAR(128) NULL DEFAULT NULL ,
  `LOGO` BLOB NULL DEFAULT NULL ,
  `LogoType` ENUM('GIF','BMP','JPEG') NULL DEFAULT NULL ,
  `AGENT` BLOB NULL DEFAULT NULL ,
  `ORG` BLOB NULL DEFAULT NULL ,
  PRIMARY KEY (`idvCard_Organizational_Properties`, `vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) ,
  CONSTRAINT `fk_vCard_Organizational_Properties_vCard_Explanatory_Properti1`
    FOREIGN KEY (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` )
    REFERENCES `DB_vCard`.`vCard_Explanatory_Properties` (`idvCard_Explanatory_Properties` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 226
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
CREATE INDEX `fk_vCard_Organizational_Properties_vCard_Explanatory_Properti1` ON `DB_vCard`.`vCard_Organizational_Properties` (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `DB_vCard`.`vCard_Telecommunications_Addressing_Properties_Email`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `DB_vCard`.`vCard_Telecommunications_Addressing_Properties_Email` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `DB_vCard`.`vCard_Telecommunications_Addressing_Properties_Email` (
  `idvCard_Telecommunications_Addressing_Properties_Email` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `vCard_Explanatory_Properties_idvCard_Explanatory_Properties` BIGINT(20) UNSIGNED NOT NULL ,
  `EMAIL` CHAR(64) NOT NULL ,
  `EmailType` SET('AOL','AppleLink','POWERSHARE','ATTMail','CIS','eWorld','INTERNET','IBMMail','MCIMail','PRODIGY','TLX','X400') NULL DEFAULT NULL ,
  PRIMARY KEY (`idvCard_Telecommunications_Addressing_Properties_Email`, `vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) ,
  CONSTRAINT `fk_vCard_Telecommunications_Addressing_Properties_Email_vCard1`
    FOREIGN KEY (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` )
    REFERENCES `DB_vCard`.`vCard_Explanatory_Properties` (`idvCard_Explanatory_Properties` ))
ENGINE = InnoDB
AUTO_INCREMENT = 490
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
CREATE INDEX `fk_vCard_Telecommunications_Addressing_Properties_Email_vCard1` ON `DB_vCard`.`vCard_Telecommunications_Addressing_Properties_Email` (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` ASC) ;

SHOW WARNINGS;
CREATE INDEX `k_Email` ON `DB_vCard`.`vCard_Telecommunications_Addressing_Properties_Email` (`EMAIL` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `DB_vCard`.`vCard_Telecommunications_Addressing_Properties_Tel`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `DB_vCard`.`vCard_Telecommunications_Addressing_Properties_Tel` ;

SHOW WARNINGS;
CREATE  TABLE IF NOT EXISTS `DB_vCard`.`vCard_Telecommunications_Addressing_Properties_Tel` (
  `idvCard_Telecommunications_Addressing_Properties_Tel` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `vCard_Explanatory_Properties_idvCard_Explanatory_Properties` BIGINT(20) UNSIGNED NOT NULL ,
  `TEL` CHAR(32) NULL DEFAULT NULL ,
  `TelType` SET('PREF','WORK','HOME','VOICE','FAX','MSG','CELL','PAGER','BBS','CAR','VIDEO') NULL DEFAULT NULL ,
  PRIMARY KEY (`idvCard_Telecommunications_Addressing_Properties_Tel`, `vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) ,
  CONSTRAINT `fk_vCard_Telecommunications_Addressing_Properties_vCard_Expla1`
    FOREIGN KEY (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` )
    REFERENCES `DB_vCard`.`vCard_Explanatory_Properties` (`idvCard_Explanatory_Properties` ))
ENGINE = InnoDB
AUTO_INCREMENT = 1357
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
CREATE INDEX `fk_vCard_Telecommunications_Addressing_Properties_vCard_Expla1` ON `DB_vCard`.`vCard_Telecommunications_Addressing_Properties_Tel` (`vCard_Explanatory_Properties_idvCard_Explanatory_Properties` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Placeholder table for view `DB_vCard`.`v_contacts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DB_vCard`.`v_contacts` (`idvCard_Explanatory_Properties` INT, `UID` INT, `N` INT, `FN` INT, `EMAILS` INT, `TELS` INT, `MICROBLOG` INT);
SHOW WARNINGS;

-- -----------------------------------------------------
-- View `DB_vCard`.`v_contacts`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `DB_vCard`.`v_contacts` ;
SHOW WARNINGS;
DROP TABLE IF EXISTS `DB_vCard`.`v_contacts`;
SHOW WARNINGS;
USE `DB_vCard`;
create  OR REPLACE view `v_contacts` as 
    select t1.idvCard_Explanatory_Properties ,t1.UID,
            t2.N,t2.FN ,
            group_concat(distinct(t3.EMAIL)) as EMAILS,
            group_concat(distinct(t4.TEL)) as TELS,
            t5.ExtensionValue as MICROBLOG 
        from 
            vCard_Explanatory_Properties as t1 
        left join vCard_Identification_Properties as t2  
            on 
                t1.idvCard_Explanatory_Properties = t2.vCard_Explanatory_Properties_idvCard_Explanatory_Properties 
        left join vCard_Telecommunications_Addressing_Properties_Email as t3 
            on 
                t1.idvCard_Explanatory_Properties = t3.vCard_Explanatory_Properties_idvCard_Explanatory_Properties  
        left join vCard_Telecommunications_Addressing_Properties_Tel as t4 
            on t1.idvCard_Explanatory_Properties = t4.vCard_Explanatory_Properties_idvCard_Explanatory_Properties 
        left join vCard_Extension_Properties as t5  
            on  t1.idvCard_Explanatory_Properties = t5.vCard_Explanatory_Properties_idvCard_Explanatory_Properties 
                and t5.ExtensionName='X-MICROBLOG' 
    group by t1.idvCard_Explanatory_Properties;
SHOW WARNINGS;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
