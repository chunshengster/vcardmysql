<?php
/**
 * 比较一维、二维数组
 * @version $Id$
 * @author wenhui<wenhui@wo.com.cn>
 */
class vCard_Diff_Lib {
    //put your code here
    public static function diff_onedimension($old,$new,$del_fields) {

        ksort($old);
        ksort($new);
        if(count($old) > 0) $tmp = $old['RESOURCE_ID'];
        $del_filed = array(',',$del_fields);
        foreach($del_filed as $key =>$value) {
           if(isset ($old[$value])) unset($old[$value]);
           if(isset ($new[$value])) unset($new[$value]);
        }

        $a1 = serialize($old);
        $b1 = serialize($new);
        $c1 = array();
        if($a1!=$b1) {
            if(count($old) > 0 && count($new) > 0){
                $c1 = $new;
                $c1['FLAG'] = 'CHANGED';
                $c1['RESOURCE_ID'] = $tmp;
            }elseif(count($old)>0){
                $c1 = array();
                $c1['FLAG'] = 'DELETED';
                $c1['RESOURCE_ID'] = $tmp;
            }elseif (count($new)>0) {
                $c1 = $new;
                $c1['FLAG'] = 'NEW';
            }
        }
        return $c1;
    }

    public static function  diff_twodimension($old,$new,$fileds) {
        $a1 = $old;
        $b1 = $new;

        foreach($a1 as $key =>$value) {
            if($value[$fileds[0]]!='') {
                $a11[$value[$fileds[0]]]['TYPE'] = $value[$fileds[1]];
                $a11[$value[$fileds[0]]]['RESOURCE_ID'] = $value['RESOURCE_ID'];
            }
        }

        $i=0;
        foreach($b1 as $key =>$value) {
            if($value[$fileds[0]]!='') {//去掉值为空的字段
                $b11[$value[$fileds[0]]] = $value[$fileds[1]];

                if(array_key_exists($value[$fileds[0]],$a11)) {//字段1存在
                    if($value[$fileds[1]]==$a11[$value[$fileds[0]]]) {//字段2内容没变
                        $c1[$i]['FLAG'] = 'KEEP';
                        $c1[$i][$fileds[0]] =$value[$fileds[0]];
                        $c1[$i][$fileds[1]] = $value[$fileds[1]];
                        $i++;
                    }
                    else {
                        $c1[$i]['FLAG'] ='CHANGED';
                        $c1[$i][$fileds[0]] =$value[$fileds[0]];
                        $c1[$i][$fileds[1]] = $value[$fileds[1]];
                        $c1[$i]['RESOURCE_ID'] = $a11[$value[$fileds[0]]]['RESOURCE_ID'];
                        $i++;
                    }
                }
                else {
                    $c1[$i]['FLAG'] ='NEW';
                    $c1[$i][$fileds[0]] =$value[$fileds[0]];
                    $c1[$i][$fileds[1]] = $value[$fileds[1]];
                    $i++;
                }
            }
        }

        foreach($a1 as $key =>$value) {
            if(!array_key_exists($value[$fileds[0]],$b11)) {
                $c1[$i]['FLAG'] ='DELETED';
                $c1[$i][$fileds[0]] =$value[$fileds[0]];
                $c1[$i][$fileds[1]] = $value[$fileds[1]];
                $c1[$i]['RESOURCE_ID'] = $value['RESOURCE_ID'];
                $i++;
            }
        }
        return $c1;
    }
    public static function show_dimension($array) {
        $a = count($array,COUNT_RECURSIVE);
        $b =  count($array);
        if($a==$b) {
            return 'onedimension';
        }
        else {
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
            $rs = ArrayClass::show_dimension($value);
            $delfields = 'UID,REV,RESOURCE_ID';
            if($rs =='onedimension') {
                $c[$key]= self::diff_onedimension($value, $vcard_b[$key],$delfields );
            }
            if($rs == 'twodimension') {
                $fileds =array_keys($vcard_b[$key][0]);

//                echo ">>>>>>:\n";
//                echo "key => ".$key."<<end key \n";
//                var_export($fileds);
//                echo "<<<<<<\n";
                $c[$key] = self::diff_twodimension($value, $vcard_b[$key], $fileds);
            }
        }
        return $c;
    }
}
?>
