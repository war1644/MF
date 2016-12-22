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