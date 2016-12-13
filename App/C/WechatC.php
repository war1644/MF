<?php
/**
 * 微信相关处理类
 * @author 路漫漫
 * @link ahmerry@qq.com
 * @version 0.9
 * @since
 * <p>v0.9 2016/12/8 15:15  初版</p>
 */
use Base\C;
use Base\Redis;
use Base\Tool\MFWechat;

class WechatC extends C {

    public $WX;
    public $M;
    public $U;
    const DEBUG = 0;
    const TICKET= 'gQH47joAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2taZ2Z3TVRtNzJXV1Brb3ZhYmJJAAIEZ23sUwMEmm3sUw==';

    public function index(){
        if (!$this->WX) {
            $option = require MFPATH . 'Config/wechat.php';
            $this->WX = new MFWechat($option);
        }
        print_r($this->WX);

        $m = new AppkeyM();
        $this->assign('data',$m->find(1));
        $this->display('home');
    }




    //接收微信
    public function auth(){
        if (!$this->WX) {
            $option = require MFPATH . 'Config/wechat.php';
            $this->WX = new MFWechat($option);
        }
        print_r($this->WX);

        $m = new AppkeyM();
        $this->assign('data',$m->find(1));
        $this->display('home');
    }
}