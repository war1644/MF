<?php
/**
 * Created by 路漫漫.
 * User: ahmerry@qq.com
 * Date: 2016/12/8 15:17
 *
 */
use Base\C;
use Base\Redis;

class HomeC extends C{

    public function home(){
//        Redis::init();
//        Redis::set('ks20688','djhkjahsdkhfkajsdhkahds');
//        echo Redis::get('ks20688');

//        $m = new UserM();$m->find(1)

//        $this->assign('data',$m->find(1));
//        test();
//        $this->display('metalmax/index');

        $this->view('KSWechat/Running');

    }
}