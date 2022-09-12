<?php
/**
 *         ▂▃╬▄▄▃▂▁▁
 *  ●●●█〓████████████▇▇▇▅▅▅▅▅▅▅▅▅▇▅▅          BUG
 *  ▄▅█████☆█☆█☆███████▄▄▃▂
 *  ███████████████████████████
 *  ◥⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙◤
 *
 * 框架配置
 * @author 路漫漫
 * @link ahmerry@qq.com
 * @version
 * v2017/02/15  初版
 */

return [
    'db' => [
        'host'=>'localhost',
        'user'=>'root',
        'password'=>'root',
        'dbname'=>'wl',
        'charset'=>'utf8',
        'prefix'=>'wl_'
    ],
    'redis' => [
        'host' => '127.0.0.1',
        'port' => 6379,
        'prefix'=>''
    ],
    'wx' => [
        'token' =>'TATQAQ', //填写你设定的token
        'encodingaeskey'=>'', //填写加密用的EncodingAESKey
        //正式号
        'appid' =>'', //填写高级调用功能的app id
        'appsecret'=>'',//填写高级调用功能的密钥
        //测试号
//        'appid' =>'', //填写高级调用功能的app id
//        'appsecret'=>'',//填写高级调用功能的密钥
        'debug'=>true,
        'cacheDir'=>RUN_PATH.'Wechat/',//缓存目录
        'logcallback'=>'Wechat::wxCallback'//微信回调方法；需要注意，方法如果在类里，需要写类名"class::method"
    ],

];



