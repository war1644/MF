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
        $path = RUN_PATH . 'Logs/'.date('Y/');
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
 * 获取IP
 * @return string $ip
 */
function GetIp() {
    static $ip = null;
    if ($ip !==null) {
        return $ip;
    }
    //判断是否为代理/别名/常规
    if (getenv('HTTP_X_FORWARDED_FOR')) {

        $ip = getenv('HTTP_X_FORWARDED_FOR');

    } elseif (getenv('HTTP_CLIENT_IP')) {

        $ip = getenv('HTTP_CLIENT_IP');

    } else {
        $ip = getenv('REMOTE_ADDR');
    }
    return $ip;
}

/**
 * 递归转义数组中的字符,防止SQL注入
 * @param
 * @return bool 失败则返回false
 */
function SqlDef($arr) {
    foreach ($arr as $k => $v) {
        if (is_string($v)) {
            $arr[$k] = addslashes ($v);
        } elseif (is_array($v)) {
            $arr[$k] = sqlDef($v);
        }
    }
    return $arr;
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

/**
 * 生成等比例缩略图
 * @param $pic filename
 * @param $w,$h 缩略后的宽高
 * @return string 缩略图路径,失败则返回false
 */
function ScalePic($pic,$w=200,$h=200) {
    $path =MFPATH.'Upload/'.date('m-H-i-s').'.png';
    //获取图片信息
    list($bw,$bh,$type) = getimagesize($pic);
    //创建大小画布
    //1 = GIF，2 = JPG，3 = PNG，4 = SWF，5 = PSD，6 = BMP
    $img = [
        1=>'imagecreatefromgif',
        2=>'imagecreatefromjpeg',
        3=>'imagecreatefrompng',
        6=>'imagecreatefromwbmp'
    ];
    $big = $img[$type]($pic);//动态调用
    $small = imagecreatetruecolor($w, $h);//缩率图放置框
    //造色,填充
    $white = imagecolorallocate($small, 255, 255, 255);
    imagefill($small, 0, 0, $white);

    //计算缩略比
    $balance = min($w/$bw,$h/$bh);
    $new_bw=$balance*$bw;
    $new_bh=$balance*$bh;
    //缩略
    imagecopyresampled($small, $big, ($w-$new_bw)/2, ($h-$new_bh)/2, 0, 0,$new_bw, $new_bh, $bw, $bh);
    //输出,关闭画布
    imagepng($small,$path);
    imagedestroy($big);
    imagedestroy($small);
    return $path;
}


/**
 * 加水印
 * @param $pic filename
 * @param $stamp 水印文件
 * @return string 水印图路径,失败则返回false
 */
function AddStampPic($pic,$stamp) {
    $path =MFPATH.'Upload/'.'stamp'.date('m-H-i-s').'.png';
    //获取图片信息
    list($bw,$bh,$btype) = getimagesize($pic);
    list($sw,$sh,$stype) = getimagesize($stamp);

    //创建大小画布
    //1 = GIF，2 = JPG，3 = PNG，4 = SWF，5 = PSD，6 = BMP
    $img = [
        1=>'imagecreatefromgif',
        2=>'imagecreatefromjpeg',
        3=>'imagecreatefrompng',
        6=>'imagecreatefromwbmp'
    ];
    $big = $img[$btype]($pic);//动态调用
    $small =  $img[$stype]($stamp);

    //水印贴大画布上
    imagecopymerge($big, $small, $bw-$sw, $bh-$sh, 0, 0, $sw, $sh, 60);
    //保存,关闭
    imagepng($big,$path);
    imagedestroy($big);
    imagedestroy($small);
    return $path;
}