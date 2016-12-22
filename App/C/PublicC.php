<?php
/**
 * Created by 路漫漫.
 * User: ahmerry@qq.com
 * Date: 2016/12/9 17:17
 *
 */
use Base\C;
use Base\Redis;
use Base\Tool\MFWechat;
use Base\Vcode;

class PublicC extends C{

    public $WX;

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

    //微信调试回调debug
    public function logdebug($text){
        file_put_contents(RUNDIR.'wxdebug.log',$text."\n",FILE_APPEND);
    }

    //接收微信
    public function wechat(){
        if (!$this->WX){
            $option = require MFPATH . 'Config/wechat.php';
            $this->WX = new MFWechat($option);

            //初次微信认证需要
            // $this->WX->valid();
        }

        if ($_REQUEST) {
            if (!$this->WX->getCache('access_token'))
                //获取access_token,并进行全局缓存
                $this->WX->checkAuth();

            $type = $this->WX->getRev()->getRevType();
            if (self::DEBUG) {
                file_put_contents(RUNDIR.'wxevent.log',FILE_APPEND,$_REQUEST);
            }

            switch($type) {
                case Wechat::MSGTYPE_TEXT:
                    $msg= C('WXMSG')[0];
                    $this->WX->text($msg)->reply();
                    break;
                case Wechat::MSGTYPE_EVENT:
                    $arr = $this->WX->getRevEvent();
                    $this->event($arr);
                    // $this->WX->text("感谢您关注KT100")->reply();
                    break;
                case Wechat::MSGTYPE_IMAGE:
                    break;
            }
            //备用方案
            // $arr = xml2arr($data);
            // $arr['EventKey'] = explode('_',  $arr['EventKey'])[1];
            // $this->changenum($arr);
            // file_put_contents(RUNTIME_PATH.'wxevent.cache',FILE_APPEND,$_REQUEST);
            // $data = file_get_contents(RUNTIME_PATH.'wxevent.cache');

        }
    }

    // 参数  描述
    // ToUserName  开发者微信号
    // FromUserName    发送方帐号（一个OpenID）
    // CreateTime  消息创建时间 （整型）
    // MsgType 消息类型，event
    // Event   事件类型，subscribe
    // EventKey    事件KEY值，qrscene_为前缀，后面为二维码的参数值
    // Ticket  二维码的ticket，可用来换取二维码图片

    // 参数  描述
    // ToUserName  开发者微信号
    // FromUserName    发送方帐号（一个OpenID）
    // CreateTime  消息创建时间 （整型）
    // MsgType 消息类型，event
    // Event   事件类型，SCAN
    // EventKey    事件KEY值，是一个32位无符号整数，即创建二维码时的二维码scene_id
    // Ticket  二维码的ticket，可用来换取二维码图片
    private function event($arr)
    {

        $arr['event']=='SCAN' ? $arr['qrid'] = $arr['key'] :'';
        if ( $arr['qrid'] || ($arr['qrid'] = $this->WX->getRevSceneId()) ) {
            if ( $arr['openid'] = $this->WX->getRevFrom()) {
                $U = D('Wxuser');
                $r = $U->where(array('openid'=>$arr['openid']))->find();
                if ($r) {
                    if ($msg= C('WXMSG')[2])
                        $this->WX->text($msg)->reply();
                    exit();
                }
                $wxuser = $this->WX->getUserInfo($arr['openid']);
                $wxuser['qrid'] = $arr['qrid'];

                // $a = implode(',', $wxuser);
                // \Think\Log::write($a, 'INFO');
            }

            if ( strlen($arr['qrid']) == 6 ){
                $M = D('Wxqrcode');
            }else{
                $M = D('Wxeverqrcode');
            }

            switch($arr['event']) {
                case 'subscribe':
                    $M->change($arr,1);
                    $U->adduser($wxuser);
                    $msg= C('WXMSG')[1];
                    $this->WX->text($msg)->reply();
                    break;
                case 'unsubscribe':
                    // $M->change($arr,-1);
                    // $U->deluser($arr);
                    break;
                case 'SCAN':
                    // $M->change($arr,1);
                    // $a = implode('', $arr);
                    // $this->WX->text("又见面了，等你等的好辛苦啊")->reply();
                    // $U->adduser($arr);

                    break;
            }
        }elseif ($arr['event'] == 'unsubscribe') {
            // $M->change($arr,-1);
            // $U->deluser($arr);
        }
    }

    public function nm()
    {
        if (IS_ROOT) {
            // if (!$this->WX){
            //         $this->WX = new Wechat(C('WXOPTION'));
            //         // $this->WX->valid();
            //         // session('WX',serialize( $this->WX) );
            //     }
            // if (!$this->WX->getCache('access_token'))
            //     //获取access_token,并进行全局缓存
            //     $this->WX->checkAuth();
            //设置菜单
            $newmenu =  array(
                "button"=>array(
                    array('type'=>'view','name'=>'最新资讯','url'=>'http://mp.weixin.qq.com/mp/getmasssendmsg?__biz=MjM5Mzc5NzIwMA==#wechat_webview_type=1&wechat_redirect'),
                    array(
                        'name'=>'康体100', 'sub_button'=>array(
                        array('type'=>'view','name'=>'康体100简介','url'=>'http://eqxiu.com/s/Lm2RT1ow'),
                        array('type'=>'view','name'=>'健身资讯','url'=>'http://www.kt100.cn/news.php'),
                        array('type'=>'view','name'=>'运动大使招聘','url'=>'http://eqxiu.com/s/qp9KQQOL'),
                        array('type'=>'view','name'=>'附近体验店查询','url'=>'http://www.kt100.cn/mobile/stores.php'),
                    )),
                    array('name'=>'网上商城', 'sub_button'=>array(
                        array('type'=>'view','name'=>'跑步机','url'=>'http://www.kt100.cn/mobile/category.php?id=17'),
                        array('type'=>'view','name'=>'按摩椅','url'=>'http://www.kt100.cn/mobile/category.php?id=19'),
                        array('type'=>'view','name'=>'有氧器材','url'=>'http://www.kt100.cn/mobile/category.php?id=16'),
                        array('type'=>'view','name'=>'力量器材','url'=>'http://www.kt100.cn/mobile/category.php?id=27'),
                        array('type'=>'view','name'=>'京东商城','url'=>'http://kt100.jd.com'),
                    )),
                )
            );

            $result = $this->WX->createMenu($newmenu);
            // \Think\Log::write($result);

        }

    }

    public function test()
    {
        if (IS_ROOT) {
            var_dump(C('WXMSG'));
        }


        // $user = array(
        //     "subscribe"=> 1,
        //     "openid"=> "o6_bmjrPTlm6_2sgVt7hMZOPfL2M",
        //     "nickname"=> "Band",
        //     "sex"=> 1,
        //     "language"=> "zh_CN",
        //     "city"=> "广州",
        //     "province"=> "广东",
        //     "country"=> "中国",
        //     "headimgurl"=>    "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/0",
        //     "subscribe_time"=> 1382694957,
        //     "unionid"=> " o6_bmasdasdsad6_2sgVt7hMZOPfL",
        //     "remark"=> "",
        //     "groupid"=> 0,
        // );
        // dump( D('Wxuser')->adduser($user) );
        // dump(new AuthGroupModel('AuthGroup') );
        // dump( D('AuthGroup') );

    }
}