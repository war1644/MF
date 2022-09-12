<?php
namespace App\C;
/**
 *         ▂▃╬▄▄▃▂▁▁
 *  ●●●█〓████████████▇▇▇▅▅▅▅▅▅▅▅▅▇▅▅          BUG
 *  ▄▅█████☆█☆█☆███████▄▄▃▂
 *  ███████████████████████████
 *  ◥⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙◤
 *
 *
 * demo 示例
 * @author 路漫漫
 * @link ahmerry@qq.com
 * @version
 * v2016/12/9 初版
 */
use Base\Lib\C;
use Base\Tool\Vcode;
use Base\Tool\Page;

class PublicC extends C {


    public function index(){

        echo 'hello';
    }

    public function test(){
//        $this->view();
    }

    public function upload(){
//        $imgName = [];
//        $arr = $_POST['imgs'];
//        for ($i=0;$i<count($arr);$i++){
//            $imgName[] = base64ToImg($arr[$i]);
//        }
//        echo ResultFormat(['code'=>1,'data'=>$imgName,'count'=>count($arr)]);
    }

    public function run(){
//        define('IS_LOGIN',true);
//        $this->view('Wechat/running');
    }

    public function endRun(){
//        MFLog($_POST);
//        if ($_POST && $_POST['summary']['id']){
//            $id = $_POST['summary']['id'];
//            $data = base64_encode(gzcompress(json_encode($_POST)));
//            $jsonData = json_encode(["service"=>"pad.upload","id"=>$id,"data"=>$data,"appkey"=>"LlCKimYod15f","crc"=>"26a6922e6409095a1e4cbce91b98c41e"]);
//            echo $res = PostMan('api.com.cn/Open/',$jsonData);
//            MFLog($res);
//        }
//        die();
    }

    /**
     * 登录
     */
    public function login(){
//        if (Vcode::check($_POST['vcode'])){
//
//        }else{
//
//        }

    }

    //退出登录 ,清除 session
    public function logout(){

    }

    /**
     * 分页功能
     */
    public function testpage() {
//        $page = new Page(345);
//        print_r($page->show());
    }

    /**
     * 验证码功能
     */
    public function vcode() {
//        $vcode = new Vcode();
//        $vcode->scode();
    }

}