<?php
namespace Base\Tool;

/**
 *         ▂▃╬▄▄▃▂▁▁
 *  ●●●█〓████████████▇▇▇▅▅▅▅▅▅▅▅▅▇▅▅          BUG
 *  ▄▅█████☆█☆█☆███████▄▄▃▂
 *  ███████████████████████████
 *  ◥⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙◤
 *
 * Socket工具类
 * 客户端在Public/V/Base
 * 调用示例：
 * new Socket('127.0.0.1',2416);
 * @param $address 连接地址
 * @param $port 端口
 * @author 路漫漫
 * @link ahmerry@qq.com
 * @version
 * v2017/04/12      增加对客户端信息的转发处理
 * v2017/04/08      增加发送到指定客户端
 *                  改进CPU占用99%的问题
 *                  单例模式，感觉用处不大
 * v2017/01/17      初版
 */

class Socket {
    private $sockets;//socket数组
    private $users;
    private $userName;
    private $master;
    private static $obj = null;

    //关闭clone
    private function __clone() {}

    private function __construct($address, $port){
        //$cfg = Config('socket');后期读取配置host,端口
        //开启端口，并监听
        $this->master=$this->openSocket($address, $port);
        $this->sockets=['s'=>$this->master];
        $this->run();
    }

    public static function ins($address, $port){
        if (self::$obj===null){
            self::$obj = new self($address, $port);
        }
        return self::$obj;
    }

    public function getSockets(){
        return $this->sockets;
    }

    private function run(){
        while(true){
            //拿所有的连接
            $changes=$this->sockets;
            $null = null;
            socket_select($changes,$null,$null,0);

            //遍历连接
            foreach($changes as $sock) {
                if ($sock == $this->master) {
                    //接受一个Socket连接
                    $client = socket_accept($this->master);
                    //把该连接存到数组
                    $this->sockets[] = $client;
                    //给该连接一个识别符
                    $this->users[] = [
                        'socket' => $client,
                        'hold' => false
                    ];
                } else {
                    //从连接里拿出请求信息
                    $len = socket_recv($sock, $buffer, 1024, 0);
                    $user = $this->search($sock);
                    if (!$len){
                        $this->close($sock, $user);
                        continue;
                    }

//                    $this->e($buffer);
//                    $this->send($buffer);
//                    if ($len < 1) {
//                        $this->close($sock, $user);
//                        continue;
//                    }
//                    if ($len>400){
//                        if (!$this->users[$user]['hold']){
//                            $this->woshou($user,$buffer);
//                        }
//                        continue;
//                    }
                    $hexData = $this->asciiToHexArray($buffer);
                    $this->e($hexData);
                    //                    $this->e($hexData);
                    $result = $this->notify($hexData,$user);
                    if (!$result){
//                        MFLog($result,'RespondSocket');
                        $this->send('false');
                        continue;
                    }
////                    if ($result[0]=='wx'){
////                        $this->send($result);
////                    }
//                    if ($result === -233){
//                        $this->close($sock,$user);
//                    } else {
//                        //返给指定客户端
////                        MFLog($result,'RespondSocket');
                        $this->send(hex2bin($result));
//                        //返回给所有客户端
////                    $this->send($result);
//                    }
                }
            }
            //避免对锁，cpu占用99%等
            usleep(100);
        }
    }

    /*public static function encode($payload, $connection)
    {
        if (empty($connection->websocketType)) {
            $connection->websocketType = self::BINARY_TYPE_BLOB;
        }
        $payload = (string)$payload;
        if (empty($connection->handshakeStep)) {
            self::sendHandshake($connection);
        }
        $mask = 1;
        $mask_key = "\x00\x00\x00\x00";

        $pack = '';
        $length = $length_flag = strlen($payload);
        if (65535 < $length) {
            $pack   = pack('NN', ($length & 0xFFFFFFFF00000000) >> 32, $length & 0x00000000FFFFFFFF);
            $length_flag = 127;
        } else if (125 < $length) {
            $pack   = pack('n*', $length);
            $length_flag = 126;
        }

        $head = ($mask << 7) | $length_flag;
        $head = $connection->websocketType . chr($head) . $pack;

        $frame = $head . $mask_key;
        // append payload to frame:
        for ($i = 0; $i < $length; $i++) {
            $frame .= $payload[$i] ^ $mask_key[$i % 4];
        }
        if ($connection->handshakeStep === 1) {
            // If buffer has already full then discard the current package.
            if (strlen($connection->tmpWebsocketData) > $connection->maxSendBufferSize) {
                if ($connection->onError) {
                    try {
                        call_user_func($connection->onError, $connection, WORKERMAN_SEND_FAIL, 'send buffer full and drop package');
                    } catch (\Exception $e) {
                        Worker::log($e);
                        exit(250);
                    } catch (\Error $e) {
                        Worker::log($e);
                        exit(250);
                    }
                }
                return '';
            }
            $connection->tmpWebsocketData = $connection->tmpWebsocketData . $frame;
            // Check buffer is full.
            if ($connection->maxSendBufferSize <= strlen($connection->tmpWebsocketData)) {
                if ($connection->onBufferFull) {
                    try {
                        call_user_func($connection->onBufferFull, $connection);
                    } catch (\Exception $e) {
                        Worker::log($e);
                        exit(250);
                    } catch (\Error $e) {
                        Worker::log($e);
                        exit(250);
                    }
                }
            }
            return '';
        }
        return $frame;
    }*/


    //关闭连接
    private function close($sock,$user){
        socket_close($sock);
        unset($this->sockets[$user],$this->users[$user]);
//        $this->send(['msg'=>'','name'=>$user,'type'=>'removeUser']);
//        $this->send(['code'=>1,'msg'=>"玩家【 $user 】下线",'type'=>'talk']);
    }

    //wifi模块数据转hex数组
    private function asciiToHexArray($str) {
        return str_split(bin2hex($str), 2);
    }

    //获取发送socket的客户端
    private function search($sock){
        foreach ($this->users as $k=>$v){
            if($sock==$v['socket'])
                return $k;
        }
        return false;
    }
    //获取发送socket的客户端
    private function searchKey($sock,$key = 'myKey'){
        foreach ($this->users as $k=>$v){
            if($sock==$v[$key])
                return $k;
        }
        return false;
    }

    //建立端口监听
    private function openSocket($address,$port){
        //创建端口
        $server = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        //阻塞模式
        //        socket_set_block($server);
        socket_set_option($server, SOL_SOCKET, SO_REUSEADDR, 1);
        socket_bind($server, $address, $port);
        socket_listen($server);
        $this->e('socket服务已开启 : '.date('Y-m-d H:i:s'));
        $this->e('开始监听 : '.$address.' ,端口 : '.$port);
        return $server;
    }

    //php的websocket特殊处理,比起node.js哎,说多了都是泪
    private function woshou($k,$buffer){
        $buf  = substr($buffer,strpos($buffer,'Sec-WebSocket-Key:')+18);
        $key  = trim(substr($buf,0,strpos($buf,"\r\n")));

        $new_key = base64_encode(sha1($key."258EAFA5-E914-47DA-95CA-C5AB0DC85B11",true));

        $new_message = "HTTP/1.1 101 Switching Protocols\r\n";
        $new_message .= "Upgrade: websocket\r\n";
        $new_message .= "Sec-WebSocket-Version: 13\r\n";
        $new_message .= "Connection: Upgrade\r\n";
        $new_message .= "Sec-WebSocket-Accept: " . $new_key . "\r\n\r\n";
        //告诉客户端握手成功
        socket_write($this->users[$k]['socket'],$new_message,strlen($new_message));
        $this->users[$k]['hold']=true;
        return true;
    }

    //帧数据解码,php在流泪
    private function uncode($str){
        $mask = array();
        $data = '';
        $msg = unpack('H*',$str);
        $head = substr($msg[1],0,2);
        if (hexdec($head{1}) === 8) {
            $data = false;
        }else if (hexdec($head{1}) === 1){
            $mask[] = hexdec(substr($msg[1],4,2));
            $mask[] = hexdec(substr($msg[1],6,2));
            $mask[] = hexdec(substr($msg[1],8,2));
            $mask[] = hexdec(substr($msg[1],10,2));

            $s = 12;
            $e = strlen($msg[1])-2;
            $n = 0;
            for ($i=$s; $i<= $e; $i+= 2) {
                $data .= chr($mask[$n%4]^hexdec(substr($msg[1],$i,2)));
                $n++;
            }
        }
        return $data;
    }

    //帧数据编码（发回客户端用），php还是在流泪
    private function code($msg){
        $msg = json_encode($msg,JSON_UNESCAPED_UNICODE);
        $msg = preg_replace(array('/\r$/','/\n$/','/\r\n$/',), '', $msg);
        $frame = array();
        $frame[0] = '81';
        $len = strlen($msg);
        $frame[1] = $len<16?'0'.dechex($len):dechex($len);
        $frame[2] = $this->ord_hex($msg);
        $data = implode('',$frame);
        return pack("H*", $data);
    }
    private function ord_hex($data) {
        $msg = '';
        $l = strlen($data);
        for ($i= 0; $i<$l; $i++) {
            $msg .= dechex(ord($data{$i}));
        }
        return $msg;
    }

    //编码后发回到客户端
    //$user为客户端识别
    private function send($msg,$user=null){
//        $msg = $this->code($msg);
        if (is_array($msg) || is_object($msg)){
            $msg = json_encode($msg,JSON_UNESCAPED_UNICODE);
        }
        if (is_null($user)){
            foreach($this->users as $v){
                //发送给所有客户端
                socket_write($v['socket'],$msg,strlen($msg));
            }
        }else{
            //发送给指定客户端
            socket_write($this->users[$user]['socket'],$msg,strlen($msg));
        }
    }

    /**
     * 通知对应控制器处理
     * 校验码：一个Bytes，长度+命令码+数据码的累加和，加满溢出。（& 异或）
     * request:
     * 开始码 长度码 命令码 数据码 校验码 结束码
     * 37 | 19 | 50 | F8 A2 33 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 D5 FD | 08 | 36
     * respond:
     * 开始码 长度码 命令码 数据码 校验码 结束码
     * 36 | 19 | 50 | F7 A2 33 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 D5 FD | 08 | 37
     *
     *
     */
    private function notify($msg=[],$k){
        //数据效验
        if ($msg[0] != '37'){
            $start=-1;$end=-1;
            foreach ($msg as $k => $v){
                if ($v=='37'){
                    $start = $k;
                }
                if ($v=='36'){
                    $end = $k;
                }
            }
            if ($start==-1 || $end==-1 ){
                return false;
            }
            $msg = array_slice($msg,$start,$end-$start+1);
            MFLog(['校正后：',$msg]);
        }
        $count = count($msg);
        if ( ($msg[0] != '37') || (hexdec($msg[1]) != $count)) return false;
        $data = [];
        switch($msg[4]){
            /**
             * 跑步机运行数据上报
             * D0 	D1 	  D2   –    D17 	D18 	D19
             * F8 	A2       	           校验码 	FD
             */
            case 'a2':
//                if (isset($this->users[$k]['wx']) && $count==22){
//                    $this->send($msg,$this->users[$k]['wx']);
//                }
                $c = new \App\C\TreadmillC();
                $data = $c->runInfo();
                $data = join('',$data);
                break;
            /**
             * 闲时交互  （暂时不用）
             * D0	D1	 D2  D3	 D4	 D5	    D6	    D7
             * F8	A7   00  00  00  00   校验码   	FD
             */
            case 'a5':
                $c = new \App\C\TreadmillC();
                $data = $c->treammillInfo();
                $data = join('',$data);
                break;
                break;
            /**
             * 安全相关
             * D0	D1	 D2  D3	 D4	 D5	    D6	    D7
             * F8	A7   00  00  00  00   校验码   	FD
             *
             */
            case 'a7':
                $c = new \App\C\TreadmillC();
                //授权跑步机
                if($msg[5] == '00' && $msg[6] == '00' && $msg[7] == '00' && $msg[8] == '00'){
                    if (isset($this->user[$k]['myKey'])){
                        return $this->user[$k]['cmd'];
                    }else{
                        $data = $c->auth();
                        $this->user[$k]['myKey'] = $data[9].$data[10].$data[11].$data[12];
                        $this->user[$k]['cmd'] = $data = join('',$data);
                    }
                }else{
                    if (isset($this->user[$k]['myKey'])){
                        //解锁跑步机
                        $c->setKey($this->user[$k]['myKey']);
                        $data = $c->unlock();
                        $data = join('',$data);
                    }else{
                        $data = $c->checkAuth([$msg[5],$msg[6],$msg[7],$msg[8]]);
                        if ($data){
                            $this->user[$k]['myKey'] = $data['myKey'];
                            return false;
                        }
                    }
                }
                break;
            case 'a8':
                $c = new \App\C\TreadmillC();
                if($msg[5] == 'aa' && $msg[6] == 'aa' && $msg[7] == 'aa' && $msg[8] == 'aa'){
                    //解锁成功,启动跑步机
                    $data = $c->start();
                    $data = join('',$data);
                }else{
                    //解锁跑步机
                    $c->setKey($this->user[$k]['myKey']);
                    $data = $c->unlock();
                    $data = join('',$data);
                }

                break;

            default:
                return false;
//                $data = '366A52F733F0F30000001E5FC1A1A0A0A1C15F1E000000000000E1F31A0E0C0C0E1AF3E100000000000000818181A0FFFF000000000000000000000C0C0C0CFFFF0C0C0C0C0000000000004181A0A0A0A0A5DF530000000000000C0E1E5C4D8DAC2C0C0C000000FDCA37';
                break;
        }
        return $data;
    }

    /**
     * 通知对应控制器处理
     * 校验码：一个Bytes，长度+命令码+数据码的累加和，加满溢出。（& 异或）
     * request:
     * 开始码 长度码 命令码 数据码 校验码 结束码
     * 37 | 19 | 50 | F8 A2 33 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 D5 FD | 08 | 36
     * respond:
     * 开始码 长度码 命令码 数据码 校验码 结束码
     * 36 | 19 | 50 | F7 A2 33 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 D5 FD | 08 | 37
     *
     *
     */
    private function wxNotify($msg=[],$k){
        //数据效验
        $count = count($msg);
        if ($msg[0] != 'wx' || hexdec($msg[1]) == $count) return false;
        $data = [];
        switch($msg[4]){
            case 'DA':
                if ($this->user[$k]['tm']){
                    $this->send(['wx','code'=>-1,'msg'=>'正在使用跑步机中'],$k);
                    return false;
                }
                $c = new \App\C\TreadmillC();
                $m = new \App\M\TreadmillM();
                $treadmill = $m->getAuth(['id'=>hexdec($msg[5])]);
                $key = $this->searchKey($treadmill['myKey']);
                if (!$key){
                    $this->send(['wx','code'=>-1,'msg'=>'跑步机匹配错误'],$k);
                    return false;
                }
                $this->user[$key]['wx'] = $k;
                $this->user[$k]['tm'] = $key;

                //解锁跑步机
                $c->setKey($treadmill['myKey']);
                $c->unlock();
                $data = join('',$data);
                $this->send(hex2bin($data),$key);
                $this->send(['wx','code'=>1,'msg'=>'解锁完成'],$k);

                //通知跑步机上传数据
                $cmd = join('',$c->runInfo());
                $this->send(hex2bin($cmd),$key);
                return false;
                break;
            case 'DB':

                break;
            /**
             * 跑步机运行数据上报
             * D0 	D1 	  D2   –    D17 	D18 	D19
             * F8 	A2       	           校验码 	FD
             */
            case 'A2':
                if (isset($this->users[$k]['wx']) && $count==22){
                    $this->send($msg,$this->users[$k]['wx']);
                }
                return false;
                break;
            /**
             * 闲时交互  （暂时不用）
             * D0	D1	 D2  D3	 D4	 D5	    D6	    D7
             * F8	A7   00  00  00  00   校验码   	FD
             */
            //            case 'A5':
            //                $m = new \App\C\TreadmillC();
            //                //授权跑步机
            //                if($msg[5] == '00' && $msg[6] == '00' && $msg[7] == '00' && $msg[8] == '00'){
            //                    if (isset($this->user[$k]['myKey'])){
            //                        return $this->user[$k]['cmd'];
            //                    }else{
            //                        $data = $m->auth();
            //                        $this->user[$k]['myKey'] = $data[9].$data[10].$data[11].$data[12];
            //                        $this->user[$k]['cmd'] = $data = join('',$data);
            //                    }
            //                }else{
            //                    if (isset($this->user[$k]['myKey'])){
            //                        return false;
            //                    }else{
            //                        $data = $m->checkAuth([$msg[5],$msg[6],$msg[7],$msg[8]]);
            //                        if ($data){
            //                            $this->user[$k]['myKey'] = $data['myKey'];
            //                        }
            //                    }
            //                }
            //                break;
            /**
             * 安全相关
             * D0	D1	 D2  D3	 D4	 D5	    D6	    D7
             * F8	A7   00  00  00  00   校验码   	FD
             */
            case 'A7':
                $m = new \App\C\TreadmillC();
                //授权跑步机
                if($msg[5] == '00' && $msg[6] == '00' && $msg[7] == '00' && $msg[8] == '00'){
                    if (isset($this->user[$k]['myKey'])){
                        return $this->user[$k]['cmd'];
                    }else{
                        $data = $m->auth();
                        $this->user[$k]['myKey'] = $data[9].$data[10].$data[11].$data[12];
                        $this->user[$k]['cmd'] = $data = join('',$data);
                    }
                }else{
                    if (isset($this->user[$k]['myKey'])){
                        return false;
                    }else{
                        $data = $m->checkAuth([$msg[5],$msg[6],$msg[7],$msg[8]]);
                        if ($data){
                            $this->user[$k]['myKey'] = $data['myKey'];
                            return false;
                        }
                    }
                }
                break;

            default:
                return false;
                //                $data = '366A52F733F0F30000001E5FC1A1A0A0A1C15F1E000000000000E1F31A0E0C0C0E1AF3E100000000000000818181A0FFFF000000000000000000000C0C0C0CFFFF0C0C0C0C0000000000004181A0A0A0A0A5DF530000000000000C0E1E5C4D8DAC2C0C0C000000FDCA37';
                break;
        }
        return $data;
    }

    /**
     * 指令效验计算
     * 查询：D0 0xF7 D1 0xA4 ... D9 0xFD
     * 控制：D0 0xF7 D1 0xA2 ... D12 0xFD
     */
    private function checkSign($info) {
        $len = count($info) - 2;
        $tmp = 0;
        for ( $i = 1; $i < $len; $i++) {
            $tmp += hexdec($info[$i]);
        }
        $tmp = $tmp & 255;
        $tmp1 = (dechex($tmp) == $info[18]) || (dechex($tmp) == $info[3]);
        return $tmp1;
    }

    //记录到log
    private function e($str){
        MFLog($str,'RequestSocket');
    }
}

