<?php
/**
 * Created by 路漫漫.
 * User: ahmerry@qq.com
 * Date: 2016/12/9 17:17
 *
 */
use Base\C;
use Base\Vcode;

class PublicC extends C{

    protected $WX;

    public function index(){
       
    }

    /**
     * 后台登录
     */
    public function login(){

    }

    //退出登录 ,清除 session
    public function logout(){

    }

    /**
     * 微信debug调试回调方法
     * 方法名在config定义
     */
    public function WxDebug($text){
        MFLog($text,'wxdebug','Wechat/');
    }

    //接收微信
    public function wechat(){
        new WechatC();
    }

}