<?php
/**
 *         ▂▃╬▄▄▃▂▁▁
 *  ●●●█〓██████████████▇▇▇▅▅▅▅▅▅▅▅▅▇▅▅          BUG
 *  ▄▅████☆RED█WOLF☆████▄▄▃▂
 *  █████████████████████████████
 *  ◥⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙◤
 *
 * 框架配置
 * @author 路漫漫
 * @link ahmerry@qq.com
 * @version
 * v0.9 2017/02/15  初版
 */

return [
    'db' => [
        'host'=>'localhost',
        'user'=>'root',
        'password'=>'root',
        'dbname'=>'',
        'charset'=>'',
        'prefix'=>''
    ],
    'redis' => [
        'host' => '127.0.0.1',
        'port' => 6379,
        'prefix'=>''
    ],
    'smtp' => [
        'host' => "",//SMTP服务器
        'port' => 0,//SMTP服务器端口
        'user' => "",//SMTP服务器的发送邮箱帐号
        'pass' => ""//SMTP服务器的发送邮箱密码
    ]

];



