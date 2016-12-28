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
use Base\Tool\MFWechat;
use Base\Tool\Wechat\Wechat;

class WechatC extends C {

    protected $WX;
    protected $jsApi;
    const DEBUG = true;

    public function __construct() {
        MFLog('收到微信请求');
        if (!$this->WX) {
            $option = require CONFIG_PATH . 'wechat.php';
            if (REDIS){
                $this->WX = new MFWechat($option);
            }else{
                $this->WX = new Wechat($option);
                if (!$this->WX->getCache($this->WX->tokenName))
                    //获取access_token,并进行全局缓存
                    $this->WX->checkAuth();
            }
        }
        //处理请求内容
        $this->ReceiveEvent();

        //开启JSAPI
        $this->JsApi();
    }

    public function auth(){
        MFLog('auth完成');
    }

    public function SetMenus(){

        //设置菜单
        $buttons =  [
            ['type'=>'view','name'=>'连接智能设备','url'=>'http://wx.duanxq.cn/wxindex'],
            [
                'name'=>'智能设备', 'sub_button'=>[
                    ['type'=>'view','name'=>'已绑设备','url'=>'https://hw.weixin.qq.com/devicectrl/panel/device-list.html?appid=wx6834f279296c34e2'],
                ]
            ],
            [
                'name'=>'页面测试', 'sub_button'=>[
                    ['type'=>'view','name'=>'test','url'=>'http://wx.duanxq.cn/wetest'],
                ]
            ]

        ];
        $this->WX->createMenu($buttons);
    }

    //接收微信信息
    protected function ReceiveEvent() {
        if ($_REQUEST) {
            $type = $this->WX->getRev()->getRevType();
            switch ( $type ) {
                case Wechat::MSGTYPE_TEXT:
                    $this->WX->text( "欢迎来到KS智能设备世界" )->reply();
                    exit;
                    break;
                case Wechat::MSGTYPE_EVENT:
                    $event = $this->WX->getRevEvent();
                    $this->WxDebug('收到微信事件 : '.json_encode($event));
                    break;
                case Wechat::MSGTYPE_BIND:
                    $event = $this->WX->getRevDevice();
                    $this->WxDebug('收到微信绑定事件 : '.json_encode($event));
                    break;
                default:
                    if (self::DEBUG) {
                        $this->WxDebug("收到微信请求 : ".json_encode($_REQUEST)."\n数据 : ".json_encode($this->WX->getRevData()));
                    }
                    $this->WX->text( "help info" )->reply();
                    break;
            }
            MFLog('响应微信完成');
        }

    }

    protected function JsApi() {

        if (!$this->WX->getJsTicket()) {
            echo $tmp = "\n获取js_ticket失败<br>";
            echo $errCode = "\n错误码：".$this->WX->errCode;
            echo $errCode = "\n错误原因：".ErrCode::getErrText($this->WX->errCode);
            $this->WxDebug($tmp.$errCode.$errCode);
            exit;
        }
        $this->jsApi = $this->WX->getJsSign();
    }

    /**
     * 跑步机交互页
     * @return Wechat
     */
    public function Test() {
        $data['title'] = 'KS,为跑步而生';
        $data['jsSign'] = $this->jsApi;
        $this->view('KSWechat/scanDevice',$data);
    }

    /**
     * 连接跑步机页面
     * @return Wechat
     */
    public function Index() {
        $data['title'] = 'KS,为跑步而生';
        $data['jsSign'] = $this->jsApi;
        $this->view('KSWechat/device',$data);
    }


}