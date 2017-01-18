<?php
/**
 * Created by 路漫漫.
 * User: ahmerry@qq.com
 * Date: 2016/12/9 15:29
 */

return [
    'token' =>'', //填写你设定的token
    'encodingaeskey'=>'', //填写加密用的EncodingAESKey
    //正式号
    'appid' =>'', //填写高级调用功能的app id
    'appsecret'=>'',//填写高级调用功能的密钥
    //测试号
//    'appid' =>'', //填写高级调用功能的app id
//    'appsecret'=>'',//填写高级调用功能的密钥
    'debug'=>true,
    'cacheDir'=>RUN_PATH.'Wechat/',//缓存目录
    'logcallback'=>'PublicC::wxDebug'//微信回调方法；需要注意，方法如果在类里，需要写类名"$classname::wxDebug"
];