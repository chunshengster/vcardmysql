<?php

class getImg {

    /**
     * 通过url获取图片的地址
     * @param <string> $url
     * @return <array> $data 
     */
    static function get_url_img($url) {
        if (!function_exists('curl_init')) {
            return array('type'=>'','data'=>'');
        }
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        if (!curl_error($ch)) {
            $type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            if(preg_match('/image\/(.*)/', $type, $matches)){
                return array('type' => $matches[1], 'data' => base64_encode($data));
            }
            return array('type' => $type, 'data' => base64_encode($data));
        }else{
            return array('type'=>'','data'=>'');
        }
    }

}

?>
