<?php
namespace App;

class FuncoesGerais{
    public static function validarFBToken($fb_ID, $fb_Token){
        $url = 'https://graph.facebook.com/'.$fb_ID.'?fields=id,name&access_token='.$fb_Token;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $res = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($httpcode != '200' && $httpcode != 200){
            return false;
        }
        return true;
    }
}
