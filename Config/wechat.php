<?php
/**
 * Created by 路漫漫.
 * User: ahmerry@qq.com
 * Date: 2016/12/9 15:29
 */

return [
    'token' =>'', //填写你设定的key
    'encodingaeskey'=>'', //填写加密用的EncodingAESKey
    'appid' =>'', //填写高级调用功能的app id
    'appsecret'=>'',//填写高级调用功能的密钥
    'debug'=>true,
    'cacheDir'=>RUN_PATH.'Wechat/',//缓存目录
    'logcallback'=>'WxDebug'//微信回调方法
];