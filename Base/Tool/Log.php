<?php
/**
 *         ▂▃╬▄▄▃▂▁▁
 *  ●●●█〓████████████▇▇▇▅▅▅▅▅▅▅▅▅▇▅▅          BUG
 *  ▄▅█████☆█☆█☆███████▄▄▃▂
 *  ███████████████████████████
 *  ◥⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙◤
 *
 */

namespace Base\Tool;


class Log
{
    /**
     * 写入
     * @author dxq1994@gmail.com
     * @version 2018/3/24
     * @param mixed $content
     * @param string $name
     * @param string $path
     * @return bool|int
     */
    public static function set($content, $name='', $path='')
    {
        defined('CACHE_PATH') && $path = CACHE_PATH.$path;
        if (!$name) return false;
        self::checkDir($path);
        $file = $path.$name;
        if (is_array($content) || is_object($content)) $content = json_encode($content,JSON_UNESCAPED_UNICODE);
        return file_put_contents($file,$content);
    }

    /**
     * 获取缓存
     * @author dxq1994@gmail.com
     * @version 2018/3/24
     * @param string $name
     * @param string $path
     * @return mixed
     */
    public static function get( $name='', $path='')
    {
        defined('CACHE_PATH') && $path = CACHE_PATH.$path;
        $file = $path.$name;
        $cache = json_decode(@file_get_contents($file),true);
        return $cache;
    }

    /**
     * 检测是否是有该文件夹，没有则生成
     * @author dxq1994@gmail.com
     * @version 2018/3/24
     * @param string $dir
     * @param int $mode
     * @return bool
     */
    public static function checkDir($dir='', $mode=0660) {
        if (!$dir)  return false;
        if(!is_dir($dir)) {
            if (!file_exists($dir) && mkdir($dir, $mode, true))
                return true;
            return false;
        }
        return true;
    }

    /**
     * 写入日志到文件
     * @author dxq1994@gmail.com
     * @version 2018/3/27
     * @param mixed $log 日志内容
     * @param string $name 日志文件名
     * @param string $path 日志路径
     */
    public static function add($log, $name='', $path='')
    {
        if (!$path){
            defined('CACHE_PATH') && $path = CACHE_PATH.$path;
            $path = $path.'logs/'.date('Ymd/');
        }else{
            defined('CACHE_PATH') && $path = CACHE_PATH.$path;
        }
        if (!$name) $name = date( 'Ymd' );
        self::checkDir($path);
        $file = $path.$name.'.log';
        if (is_array($log) || is_object($log)) $log = json_encode($log,JSON_UNESCAPED_UNICODE);
        $content = "Time : ".date('Y-m-d H:i:s')."\nData : ".$log."\n\n";
        file_put_contents($file,$content,FILE_APPEND);
        #error_log($content,3,$file);
    }

    public static function varName(&$var, $scope=0)
    {
        $old = $var;
        if (($key = array_search($var = 'unique'.rand().'value', !$scope ? $GLOBALS : $scope)) && $var = $old) return $key;
        return false;
    }


}
