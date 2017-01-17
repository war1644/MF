<?php
/**
 * Created by 路漫漫.
 * Link: ahmerry@qq.com
 * Date: 2016/12/12 17:27
 * 一些方法
 */

/**
 * 写入日志到文件
 * @param $log 日志内容
 * @param $name 日志文件名
 * @param $path 日志路径
 */
function MFLog($log, $name='', $path='') {
    if (!$path){
        $path = RUN_PATH . 'Logs/';
    }else{
        $path = RUN_PATH . $path;
    }
    CheckDir( $path );
    if (!$name) $name = date( 'm-d' );

    file_put_contents(
        $path.$name.'.log',
        "\n\nTime : ".date('Y-m-d H:i:s')."\n".$log,
        FILE_APPEND
    );
}

/**
 * 检测是否是有该文件夹，没有则生成
 */
function CheckDir($dir, $mode=0777) {
    if (!$dir)  return false;
    if(!is_dir($dir)) {
        if (!file_exists($dir) && @mkdir($dir, $mode, true))
            return true;
        return false;
    }
    return true;
}

/**
 * 设置session
 */
function Session($name,$value=''){
    session_start();
    if ($value !== ''){
        $_SESSION[$name] = $value;
        return true;
    }else{
        return $_SESSION[$name];
    }
}

/**
 * GET 请求
 * @param string $url
 */
function HttpGet($url){
    $oCurl = curl_init();
    if(stripos($url,"https://")!==FALSE){
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
    }
    curl_setopt($oCurl, CURLOPT_URL, $url);
    curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
    $sContent = curl_exec($oCurl);
    $aStatus = curl_getinfo($oCurl);
    curl_close($oCurl);
    if(intval($aStatus["http_code"])==200){
        return $sContent;
    }else{
        return false;
    }
}

/**
 * POST 请求
 * @param string $url
 * @param array $param
 * @param boolean $post_file 是否文件上传
 * @return string content
 */
function HttpPost($url,$param,$post_file=false){
    $oCurl = curl_init();
    if(stripos($url,"https://")!==FALSE){
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
    }
    if (PHP_VERSION_ID >= 50500 && class_exists('\CURLFile')) {
        $is_curlFile = true;
    } else {
        $is_curlFile = false;
        if (defined('CURLOPT_SAFE_UPLOAD')) {
            curl_setopt($oCurl, CURLOPT_SAFE_UPLOAD, false);
        }
    }
    if (is_string($param)) {
        $strPOST = $param;
    }elseif($post_file) {
        if($is_curlFile) {
            foreach ($param as $key => $val) {
                if (substr($val, 0, 1) == '@') {
                    $param[$key] = new \CURLFile(realpath(substr($val,1)));
                }
            }
        }
        $strPOST = $param;
    } else {
        $aPOST = array();
        foreach($param as $key=>$val){
            $aPOST[] = $key."=".urlencode($val);
        }
        $strPOST =  join("&", $aPOST);
    }
    curl_setopt($oCurl, CURLOPT_URL, $url);
    curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($oCurl, CURLOPT_POST,true);
    curl_setopt($oCurl, CURLOPT_POSTFIELDS,$strPOST);
    $sContent = curl_exec($oCurl);
    $aStatus = curl_getinfo($oCurl);
    curl_close($oCurl);
    if(intval($aStatus["http_code"])==200){
        return $sContent;
    }else{
        return false;
    }
}