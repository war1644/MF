<?php

/**
 *         ▂▃╬▄▄▃▂▁▁
 *  ●●●█〓████████████▇▇▇▅▅▅▅▅▅▅▅▅▇▅▅          BUG
 *  ▄▅█████☆█☆█☆███████▄▄▃▂
 *  ███████████████████████████
 *  ◥⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙◤
 *
 * info
 * @author 路漫漫
 * @link dxq1994@gmail.com
 * @version
 * v2018/4/12  初版
 * v2018/8/21  新增索引形式的队列执行
 *
 */

namespace Base\Tool;


class MultiCurl
{
    public static $task = [];
    private static $curl = null;
    public static $debug = false;

    /**
     * 新增索引形式的队列执行
     * 调整传参
     * @version v2018/8/21 下午7:33 初版
     * @param $data array 请求类型
     * @param string $taskName
     */
    public static function add($data,$taskName='')
    {
        if(strtolower($data['type']) == 'post') {
            self::$curl = self::curl_post($data['url'],$data['data'],$data['header']);
        } else {
            self::$curl = self::curl_get($data['url'],$data['data'],$data['header']);
        }
        if($taskName){
            self::$task[$taskName] = self::$curl;
        }else{
            self::$task[] = self::$curl;
        }
    }

    /**
     * 提交GET请求，curl方法
     * @param string  $url     请求url地址
     * @param mixed   $data   GET数据,数组或类似id=1&k1=v1
     * @param array   $header   头信息
     * @param int    $timeout   超时时间
     * @param int    $port    端口号
     * @return obj 句柄对象
     */
    private static function curl_get($url, $data = array(), $header = array(), $timeout = 5, $port = 80)
    {
        $ch = curl_init();
        if ($data) {
            $data = is_array($data)?http_build_query($data): $data;
            $url .= (strpos($url,'?')?  '&': "?") . $data;
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, 0);
        //curl_setopt($ch, CURLOPT_PORT, $port);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION ,1); //是否抓取跳转后的页面
        return $ch;
    }

    /**
     * 提交POST请求，curl方法
     * @param string  $url     请求url地址
     * @param mixed   $data   POST数据,数组或类似id=1&k1=v1
     * @param array   $header   头信息
     * @param int    $timeout   超时时间
     * @param int    $port    端口号
     * @return obj 句柄对象
     */
    private static function curl_post($url, $data = array(), $header = array(), $timeout = 10, $port = 80)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        //curl_setopt($ch, CURLOPT_PORT, $port);
        if($header) curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        return $ch;
    }

    /**
     * 批量执行curl请求
     * @return array
     */
    public static function exec($debug=false)
    {
        $redata = array();
        $master = curl_multi_init();
        foreach(self::$task as $t)
        {
            curl_multi_add_handle($master,$t);
        }

        $running=null;
        // 执行批处理句柄
        do {
            usleep(10000);//???
            curl_multi_exec($master,$running);
        } while ($running > 0);

        // 关闭全部句柄
        foreach(self::$task as $k=>$t)
        {
            $redata[$k] = curl_multi_getcontent($t);
            if(self::is_json($redata[$k]))
            {
                $redata[$k] = json_decode($redata[$k],true);
            }

            curl_multi_remove_handle($master, $t);
        }

        curl_multi_close($master);
        return $redata;
    }

    /**
     * 检测是否是json格式数据
     */
    private static function is_json($string)
    {
        json_decode($string);
        return (json_last_error() === JSON_ERROR_NONE);
    }

}