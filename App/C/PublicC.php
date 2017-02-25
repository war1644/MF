<?php
/**
 * Created by 路漫漫.
 * User: ahmerry@qq.com
 * Date: 2016/12/9 17:17
 *
 */
use Base\C;
use Base\Tool\Vcode;
use Base\Tool\Page;
class PublicC extends C {

    protected $WX;

    public function index(){
       
    }

    public function run(){
        define('IS_LOGIN',true);
        $this->view('KSWechat/running');
    }

    public function endRun() {
        if ($_POST){
            MFLog(json_encode($_POST));
            echo true;
        }


    }

    /**
     * 登录
     */
    public function login(){
        if (Vcode::check($_POST['vcode'])){

        }else{

        }

    }

    //退出登录 ,清除 session
    public function logout(){

    }

    /**
     * 微信debug调试回调方法
     * 方法名在config定义
     */
    public static function wxDebug($text){
        MFLog($text,'WxDebug','Wechat/');
    }

    //接收微信
    public function wechat(){
        new WechatC();
    }

    /**
     * 分页功能
     */
    public function testpage() {
        $page = new Page(345);
        print_r($page->show());
    }

    /**
     * 验证码功能
     */
    public function vcode() {
        $vcode = new Vcode();
        $vcode->scode();
    }

}