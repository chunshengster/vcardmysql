CREATE  VIEW `view_contacts` AS 
select 
    `t1`.`idvCard_Explanatory_Properties` AS `idvCard_Explanatory_Properties`,
    `t1`.`UID` AS `UID`,
    `t2`.`N` AS `N`,
    `t2`.`FN` AS `FN`,
    group_concat(distinct `t3`.`EMAIL` separator ',') AS `EMAILS`,
    group_concat(distinct `t4`.`TEL` separator ',') AS `TELS`,
    `t5`.`ExtensionValue` as MICROBLOG 
from (`vCard_Explanatory_Properties` `t1` 
    left join 
        ((`vCard_Identification_Properties` `t2` 
    join `vCard_Telecommunications_Addressing_Properties_Email` `t3`) 
    join `vCard_Telecommunications_Addressing_Properties_Tel` `t4`) 
    join `vCard_Extension_Properties` `t5`) 
    on
        (((`t1`.`idvCard_Explanatory_Properties` = `t2`.`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) 
        and 
        (`t1`.`idvCard_Explanatory_Properties` = `t3`.`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`) 
        and 
        (`t1`.`idvCard_Explanatory_Properties` = `t4`.`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`)
        and 
        (`t1`.`idvCard_Explanatory_Properties` = `t5`.`vCard_Explanatory_Properties_idvCard_Explanatory_Properties`)
        and
        (`t5`.ExtensionName = 'X-MICROBLOG')
        ))) 
group by `t1`.`idvCard_Explanatory_Properties`