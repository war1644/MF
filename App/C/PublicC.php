<?php
namespace App\C;
/**
 *         ▂▃╬▄▄▃▂▁▁
 *  ●●●█〓██████████████▇▇▇▅▅▅▅▅▅▅▅▅▇▅▅          BUG
 *  ▄▅████☆RED █ WOLF☆███▄▄▃▂
 *  █████████████████████████████
 *  ◥⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙◤
 *
 * demo 示例
 * @author 路漫漫
 * @link ahmerry@qq.com
 * @since
 * <p>v0.9 2016/12/9 初版</p>
 */
use Base\C;
use Base\Tool\Vcode;
use Base\Tool\Page;

class PublicC extends C {

    protected $WX;

    public function index(){
       die(1);
    }

    public function test(){
        $this->view();
    }

    public function run(){
        define('IS_LOGIN',true);
        $this->view('KSWechat/running');
    }

    public function endRun(){


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
        new \WechatC();
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