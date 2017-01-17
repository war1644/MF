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
}