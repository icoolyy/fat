<?php

namespace fat\http;

class Http
{
    /**
     * GET 请求
     *
     * @param $url
     *
     * @return bool|mixed
     */
    public static function get($url)
    {
        $oCurl = curl_init();
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if (intval($aStatus["http_code"]) == 200) {
            return $sContent;
        } else {
            return false;
        }
    }

    /**
     * POST 请求
     *
     * @param string $url
     * @param array $param
     * @param bool $post_json 是否发送json格式参数
     *
     * @return string content
     */
    public static function post($url, $param, $post_json = false)
    {
        $oCurl = curl_init();
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        if ($post_json) {
            $strPOST = json_encode($param, JSON_UNESCAPED_UNICODE);
        } else {
            if (is_string($param)) {
                $strPOST = $param;
                if (substr($param, 0, 1) == '@') {
                    $strPOST = array('file' => $param);
                }
            } else {
                $aPOST = array();
                foreach ($param as $key => $val) {
                    $aPOST[] = $key . "=" . urlencode($val);
                }
                $strPOST = join("&", $aPOST);
            }
        }

        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_POST, true);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $strPOST);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if (intval($aStatus["http_code"]) == 200) {
            return $sContent;
        } else {
            return false;
        }
    }
}