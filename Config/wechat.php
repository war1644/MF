<?php
/**
 * Created by 路漫漫.
 * User: ahmerry@qq.com
 * Date: 2016/12/9 15:29
 */

return [
    'token' =>'kingsmith', //填写你设定的token
    'encodingaeskey'=>'oCe5bLmXoIAgnjYD8dzRl5L18QFBnYscUqmaUCgItIN', //填写加密用的EncodingAESKey
    //正式号
    'appid' =>'wx91e7b6ade546e6a4', //填写高级调用功能的app id
    'appsecret'=>'0a9ccbe77f6c41db9d57d7c51d1dec60',//填写高级调用功能的密钥
    //测试号
//    'appid' =>'wx6834f279296c34e2', //填写高级调用功能的app id
//    'appsecret'=>'d4624c36b6795d1d99dcf0547af5443d',//填写高级调用功能的密钥
    'debug'=>true,
    'cacheDir'=>RUN_PATH.'Wechat/',//缓存目录
    'logcallback'=>'PublicC::wxDebug'//微信回调方法；需要注意，方法如果在类里，需要写类名"$classname::wxDebug"
];