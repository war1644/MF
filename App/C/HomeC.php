<?php
/**
 * Created by 路漫漫.
 * User: ahmerry@qq.com
 * Date: 2016/12/8 15:17
 *
 */
use Base\C;
use Base\Redis;
use Base\Tool\SMTP;

class HomeC extends C{

    public function home(){
        for ($i=175;$i<=239;$i++){
            $mac = dechex($i);
            $name = strtoupper($mac);
            $data = [
                "device_num"=>"1",
                "device_list"=>[[
                    "id"=>"KS940V3-$name",
                    "mac"=>"12086a17fc$mac",
                    "connect_protocol"=>"3",
                    "auth_key"=>"",
                    "close_strategy"=>"2",
                    "conn_strategy"=>"1",
                    "crypt_method"=>"0",
                    "auth_ver"=>"0",
                    "manu_mac_pos"=>"-1",
                    "ser_mac_pos"=>"-2"
                ]],
                "product_id"=>"24777"
            ];

            print_r($data);

        }

    }

    public function fuck(){
        $acticity = new RunGroupActivityUserM();
        $file = UP_PATH.'export.xls';
        $acticity->findAll();
        file_put_contents($file,ob_get_contents(),LOCK_EX);
        $subject = "测试邮件系统";//邮件主题
        $body = "<h1> 测试邮件系统----路漫漫 </h1>";//邮件内容

        //发送邮件，多个使用','分隔
        $mail = SMTP::Ins();
        //加附件先加再发送，如果不指定name自动从指定的文件中取文件名
        $mail->AddFile($file,'跑团活动.xls');
        $mail->send('ahmerry@qq.com',$subject,$body);
    }

    public function test(){
        $u = new UserM();
        $u->test();
    }
}