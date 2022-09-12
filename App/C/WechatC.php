<?php
namespace App\C;
/**
 *         ▂▃╬▄▄▃▂▁▁
 *  ●●●█〓████████████▇▇▇▅▅▅▅▅▅▅▅▅▇▅▅          BUG
 *  ▄▅█████☆█☆█☆███████▄▄▃▂
 *  ███████████████████████████
 *  ◥⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙◤
 *
 * 微信相关处理类demo 示例
 * @author 路漫漫
 * @link ahmerry@qq.com
 * @version
 * v2017/03/02 微信智能设备相关处理
 * v2017/02/26 Oauth授权处理
 * v2016/12/08 初版
 */
use Base\Lib\C;
use Base\Tool\MFWechat;
use Base\Tool\Wechat\Wechat;

class WechatC extends C {

    protected $WX;
    protected $jsApi;
    protected $userInfo;
    const DEBUG = true;

    public function __construct() {
        MFLog('收到微信请求');
        if (!$this->WX) {
            $option = Config('wx');
            if (REDIS){
                $this->WX = new MFWechat($option);
            }else{
                $this->WX = new Wechat($option);
                if (!$this->WX->getCache($this->WX->tokenName))
                    //获取access_token,并进行全局缓存
                    $this->WX->checkAuth();
            }
        }
        //只要在第一次token或者加密消息才开启
//        $this->WX->valid();
        if (!isset($_GET['callback'])){
            //处理请求内容
            $this->receiveEvent();
        }
        //开启JSAPI
        $this->jsApi();
    }

    /**
     * 微信debug调试回调方法
     * 方法名在config定义
     */
    public static function wxDebug($text){
        MFLog($text,'WxDebug','Wechat/');
    }

    /**
     * 微信服务器回调方法
     * 方法名在config定义
     */
    public static function wxCallback($text){
        MFLog($text,'WxCallback','Wechat/');
    }

    public function auth(){
        MFLog('auth完成');
    }

    public function setMenu(){

        //设置菜单
        $buttons =  [
//            ['type'=>'view','name'=>'连接智能设备','url'=>'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx6834f279296c34&redirect_uri=http%3A%2F%2Fwx.ss.cn%2FWechat%2FgetUserInfo&response_type=code&scope=snsapi_userinfo&state='],
            ['type'=>'view','name'=>'app下载','url'=>'https://sj.qq.com/myapp/detail.htm?apkName=com.android'],
//            [
//                'name'=>'智能设备', 'sub_button'=>[
//                    ['type'=>'view','name'=>'已绑设备','url'=>'https://hw.weixin.qq.com/devicectrl/panel/device-list.html?appid='],
//                ]
//            ],
//            [
//                'name'=>'页面测试', 'sub_button'=>[
//                    ['type'=>'view','name'=>'test','url'=>'http://wx.xxx.cn/Wechat/test'],
//                ]
//            ]
        ];
        Dump($this->WX->createMenu($buttons));
    }

    //接收微信信息
    protected function receiveEvent() {
        if ($_REQUEST) {
            $type = $this->WX->getRev()->getRevType();
            switch ( $type ) {
                case Wechat::MSGTYPE_TEXT:
                    $this->WX->text( "come come" )->reply();
                    break;
                case Wechat::MSGTYPE_EVENT:
                    $event = $this->WX->getRevEvent();
                    $this->wxDebug('收到微信事件 : '.json_encode($event));
                    $this->responseWxEvent($event);
                    break;
                case Wechat::MSGTYPE_BIND:
                    $event = $this->WX->getRevDevice();
                    $this->wxDebug('收到微信绑定事件 : '.json_encode($event));
                    break;
                default:
                    if (self::DEBUG) {
                        $this->wxDebug("收到微信请求 : ".json_encode($_REQUEST)."\n数据 : ".json_encode($this->WX->getRevData()));
                    }
                    if (isset($_REQUEST['code'])){
                        $this->WX->getOauthAccessToken();
                        $this->userInfo = $this->WX->getOauthUserinfo();
                    }
                    $this->WX->text( "help info" )->reply();
                    break;
            }
            MFLog('响应微信完成');
        }
    }

    public function responseWxEvent($event){
        if($event['event'] == 'subscribe'){
            $this->WX->text( "欢迎关注" )->reply();
        }

    }

    public function send(){
//        $list = $this->WX->getUserList()['data']['openid'];
//        $list2['user_list'] = array_map(function ($v){
//            return ['openid'=>$v];
//        },$list);
////        echo json_encode($list,256);die();
//
//        $res = $this->WX->getUsersInfo($list2);
//        echo json_encode($res,256);die();
//        die();
//        {{first.DATA}}
//        今日收益：{{keyword1.DATA}}
//累计收益：{{keyword2.DATA}}
//总资产：{{keyword3.DATA}}
//{{remark.DATA}}
        $data = [

            "touser"=>"oRdRgw31VyzzUhbI3cccHcDD_qfY",//lmm
            "template_id"=>"0z-DOPhn4CnQiBuQF-2MSRe_fH8pdoRZxwC22DTWM8s",
            "url"=>"https://a.app.qq.com/o/simple.jsp?pkgname=com.android",
            "data"=>[
                "first"=>[
                    "value"=>"即墨，你有收益入账",
                    "color">"#173177",
                ],
                "keyword1"=>[
                    "value"=>"1.80 元",
                    "color">"#173177",
                ],
                "keyword2"=>[
                    "value"=>"39.80 元",
                    "color">"#173177",
                ],
                "keyword3"=>[
                    "value"=>"50.80 元",
                    "color">"#173177",
                ],
                "remark"=>[
                    "value"=>"",
                    "color">"#173177",
                ],
            ]
        ];
        $this->WX->sendTemplateMessage($data);
    }

    protected function jsApi() {
        $tick = $this->WX->getJsTicket();
        if (!$tick) {
            echo $tmp = "\n获取js_ticket失败<br>";
            echo $errCode = "\n错误码：".$this->WX->errCode;
            echo $errCode = "\n错误原因：".ErrCode::getErrText($this->WX->errCode);
            MFLog($tmp.$errCode.$errCode);
            exit;
        }
        $this->jsApi = $this->WX->getJsSign();
    }

    public function sendkfmsg(){

    }

    /**
     * 排行榜
     * @return Wechat
     */
    public function getCode() {
        $redirect_uri = 'http://wx.xxxx.cn/Wechat/getUserInfo';
        $url = $this->WX->getOauthRedirect($redirect_uri);
        Dump($url);
    }

    /**
     * 获取用户信息
     * @return Wechat
     */
    public function getUserInfo() {
        $userInfo = $this->userInfo;
        MFLog($userInfo);
        $arr = Session($userInfo['unionid']);
        if (!$arr){
            $jsonData = json_encode([
                "service"=>"user.weixin",
                "wx_openid"=>$userInfo['openid'],
                "wx_unionid"=>$userInfo['unionid'],
                "brand"=>"wechat",
                "wx_nickname"=>$userInfo['nickname'],
                "avatar"=>$userInfo['headimgurl'],
            ]);
            $res = PostMan(API_URL,$jsonData);
            $res = json_decode($res,true);
            if ($res['ret']==200){
                $arr = [
                    'id'=>$res['data']['info']['id'],
                    'uid'=>$userInfo['unionid'],
                    'oid'=>$userInfo['openid'],
                    'avatar'=>$res['data']['info']['avatar'],
                    'nickname'=>$res['data']['info']['nickname']
                ];
                Session($userInfo['unionid'],json_encode($arr));
                $this->endRun($arr);
            }else{
                Dump('服务器获取信息失败,请刷新页面');
            }
        }else{
            $this->endRun(json_decode($arr,true));
        }

    }


    /**
     * 排行榜
     * @return Wechat
     */
    public function ranking() {
        $url = $this->WX->getRanking();
//        $data['title'] = 'xxxx';
//        $data['jsSign'] = $this->jsApi;
//        $this->view('Wechat/device',$data);
    }
    
    /**
     * 跑步机交互页
     * @return Wechat
     *
     */
    public function test() {
        $data['title'] = 'xxxx';
        $data['jsSign'] = $this->jsApi;
        $this->view('Wechat/device.php',$data);
    }

    /**
     * 绑定跑步机
     * @return Wechat
     */
    public function bindDevice() {
        $data['title'] = 'xxx';
        $postData = [
            "ticket"=> $_POST['ticket'],
            "device_id"=> $_POST['deviceId'],
            "openid"=> $_POST['oid']
        ];
        echo $this->WX->bindDevice($postData);
    }

    /**
     * 连接跑步机页面
     * @return Wechat
     */
    public function index() {
        $data['jsSign'] = $this->jsApi;
        $this->view('add.html',$data);
    }

    /**
     * 连接跑步机页面
     * @return Wechat
     */
    public function endRun($arr=[]) {
        $data['title'] = 'xxx';
        $data['jsSign'] = $this->jsApi;
//        $data['id'] = $arr['id'];
//        $data['oid'] = $arr['oid'];
//        $data['avatar'] = $arr['avatar'];
//        $data['nickname'] = $arr['nickname'];
        $rank = new \App\M\RankingM();
        $data['distance'] = $rank->countDistance(intval($arr['id']=20688));

        $data['nickname'] = 'nickname';
        $data['id'] = 0;
        $data['oid'] = 0;
        $data['avatar'] = 'http://img.com.cn/upload/avatar/User/204881464950129069.png';
        $this->view('Wechat/test.html',$data);
    }

    /**
     * 循环添加mac
     * @return Wechat
     */
    public function addMac() {
        die();
        $excel = $log = [];
        for ($i=1030;$i<2030;$i++){
            $mac = dechex($i);
            $len = 6-strlen($mac);
            $zeroNum = '';
            if ($len){
                for ($j=0;$j<$len;$j++){
                    $zeroNum.='0';
                }
            }
            $mac = "14580f$zeroNum$mac";
            $len = 5-strlen($i);
            $zeroNum = '';
            if ($len){
                for ($j=0;$j<$len;$j++){
                    $zeroNum.='0';
                }
            }
            $name = "$zeroNum$i-V1";
            $snid = "SNID:$zeroNum$i";
            $qrcode = [
                "service"=>"connBLE",
                [
                    "name"=>$name,
                    "mac"=>$mac
                ]
            ];
            $base64 = base64_encode(json_encode($qrcode));
            $qrcode = "http://weixin.qq.com/r/4ztSSmTEYTkerSAp927x#$base64";

            $data = [
                "device_num"=>"1",
                "device_list"=>[[
                    "id"=>"$name",
                    "mac"=>"$mac",
                    "connect_protocol"=>"3",
                    "auth_key"=>"",
                    "close_strategy"=>"1",
                    "conn_strategy"=>"16",
                    "crypt_method"=>"0",
                    "auth_ver"=>"0",
                    "manu_mac_pos"=>"-1",
                    "ser_mac_pos"=>"-2"
                ]],
                "product_id"=>"27569"
            ];
//            if ($this->WX->addDeviceMac($data)){
//                $log[] = "$name : $mac 添加成功\n";
                $sqlData[] = [
                    'mac'=>$mac,
                    'name'=>$name,
                    'qrcode'=>$qrcode,
                    'snid'=>$i,
                    'add_time'=>date('Y-m-d H:i:s')
                ];
//                $excel[] = [$name,$mac,$qrcode,$snid];
//            }else{
//                $log[] = "$name : $mac 添加失败\n";
//            }
        }
//        $title = ['NAME','MAC','QRCODE','SNID'];
//        SaveToExcel::exportExcel($excel,$title);
//        MFLog($log);
        $qr = new WxQrcodeM();
        $qr->addMac($sqlData);

    }



}
