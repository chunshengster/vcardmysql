SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

ALTER TABLE `DB_vCard`.`vCard_Telecommunications_Addressing_Properties_Email` CHANGE COLUMN `EmailType` `EmailType` SET('AOL','AppleLink','POWERSHARE','ATTMail','CIS','eWorld','INTERNET','IBMMail','MCIMail','PRODIGY','TLX','X400','HOME','WORK','OTHER') NULL DEFAULT 'INTERNET'  ;


-- -----------------------------------------------------
-- Placeholder table for view `DB_vCard`.`v_contacts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DB_vCard`.`v_contacts` (`idvCard_Explanatory_Properties` INT, `UID` INT, `N` INT, `FN` INT, `EMAILS` INT, `TELS` INT, `MICROBLOG` INT);


USE `DB_vCard`;

-- -----------------------------------------------------
-- View `DB_vCard`.`v_contacts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `DB_vCard`.`v_contacts`;
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

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
