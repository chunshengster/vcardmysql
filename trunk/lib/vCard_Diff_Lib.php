<?php
/**
 * 比较一维、二维数组
 * @version $Id$
 * @author wenhui<wenhui@wo.com.cn> chunshengster<chunshengster@gmail.com>
 */

if(!function_exists('debugLog')){
    require_once dirname(__FILE__).'/debug.php';
}

class vCard_Diff_Lib {

    public static function  diff_twodimension($old,$new,$fields) {
        $a1 = $old;
        $b1 = $new;
        $c1 = array();

        foreach($a1 as $key =>$value) {

            if($value[$fields[0]]!='') {

                $a11[$value[$fields[0]]]['TYPE'] = $value[$fields[1]];
                $a11[$value[$fields[0]]]['RESOURCE_ID'] = $value['RESOURCE_ID'];
            }
        }

        $i=0;
        foreach($b1 as $key =>$value) {
            if($value[$fields[0]]!='') {//去掉值为空的字段
                $b11[$value[$fields[0]]]['TYPE'] = $value[$fields[1]];

                if(array_key_exists($value[$fields[0]],$a11)) {//字段1存在
//                    echo $value[$fields[1]].'<-->'.var_export($a11[$value[$fields[0]]]['TYPE'],true)."\n";
                    
                    if($value[$fields[1]]==$a11[$value[$fields[0]]]['TYPE']) {//字段2内容没变

//                        $c1[$i]['FLAG'] = 'KEEP';
//                        $c1[$i][$fields[0]] =$value[$fields[0]];
//                        $c1[$i][$fields[1]] = $value[$fields[1]];
//                        $i++;
                    }
                    else {
                        $c1[$i]['FLAG'] ='CHANGED';
                        $c1[$i][$fields[0]] =$value[$fields[0]];
                        $c1[$i][$fields[1]] = $value[$fields[1]];
                        $c1[$i]['RESOURCE_ID'] = $a11[$value[$fields[0]]]['RESOURCE_ID'];
                        $i++;
                    }
                }
                else {
                    $c1[$i]['FLAG'] ='NEW';
                    $c1[$i][$fields[0]] =$value[$fields[0]];
                    $c1[$i][$fields[1]] = $value[$fields[1]];
                    $i++;
                }
            }
        }

        foreach($a1 as $key =>$value) {
            if(!array_key_exists($value[$fields[0]],$b11)) {
                $c1[$i]['FLAG'] ='DELETED';
                $c1[$i][$fields[0]] =$value[$fields[0]];
                $c1[$i][$fields[1]] = $value[$fields[1]];
                $c1[$i]['RESOURCE_ID'] = $value['RESOURCE_ID'];
                $i++;
            }
        }
        return $c1;
    }
    public static function show_dimension($key) {
//        $a = count($array,COUNT_RECURSIVE);
//        $b =  count($array);
        $one = array('vCard_Explanatory_Properties','vCard_Identification_Properties','vCard_Geographical_Properties','vCard_Organizational_Properties');
        $two = array('vCard_Delivery_Addressing_Properties_ADR','vCard_Delivery_Addressing_Properties_LABEL','vCard_Telecommunications_Addressing_Properties_Tel','vCard_Telecommunications_Addressing_Properties_Email');
        if(in_array($key, $one)) {
            return 'onedimension';
        }
        elseif(in_array($key, $two)) {
            return  'twodimension';
        }
    }

    /**
     * 比较两个vcard的数据变化。返回 vcard_b 与 vcard_a 的数据变化。数据结构请参考 class_vcard
     * @param <class_vCard> $vcard_a
     * @param <class_vCard> $vcard_b
     */
    public static function vCard_Diff($vcard_a,$vcard_b) {
        foreach ($vcard_a as $key => $value) {
            $rs = self::show_dimension($key);
            //$delfields = 'UID,REV,RESOURCE_ID';
            if($rs =='onedimension') {
                debugLog(__FILE__,__CLASS__,__METHOD__,__LINE__,var_export($value,true),var_export($vcard_b[$key],true));
                $c[$key]= self::diff_onedimension($value, $vcard_b[$key]);
            }
            if($rs == 'twodimension') {
                $fields =array_keys($vcard_b[$key][0]);

//                echo ">>>>>>:\n";
//                echo "key => ".$key."<<end key \n";
//                var_export($fields);
//                echo "<<<<<<\n";
                $c[$key] = self::diff_twodimension($value, $vcard_b[$key], $fields);
            }
        }
        return $c;
    }

    public static function diff_onedimension($old,$new) {
        debugLog(__FILE__,__CLASS__,__METHOD__,__LINE__,var_export($old,true),var_export($new,true));
        $is_changed = false;
        foreach ($new as $key=>$value) {
            if(isset($value) && $value <> '') {
                if(isset ($old[$key]) && $old[$key] <> $value) {
                    $old['FLAG'] = 'CHANGED';
                    $is_changed = true;
                    $old[$key] = $value;
                }
            }
        }
        if($is_changed) {
            debugLog(__FILE__,__CLASS__,__METHOD__,__LINE__,var_export($old,true));
            return $old;
        }else {
            return array();
        }
    }
    
}
?>
