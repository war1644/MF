<?php
/**
 *         ▂▃╬▄▄▃▂▁▁
 *  ●●●█〓██████████████▇▇▇▅▅▅▅▅▅▅▅▅▇▅▅          BUG
 *  ▄▅████☆RED █ WOLF☆███▄▄▃▂
 *  █████████████████████████████
 *  ◥⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙◤
 *
 * WebSocket服务端启动文件
 * @author 路漫漫
 * @link ahmerry@qq.com
 * @version
 * v2017/04/08  初版
 */
//报错开关
ini_set("display_errors", "On");
//报错等级 0 关闭 -1 全开
error_reporting(-1);

//设置全局常量
define('MFPATH' , str_replace('\\', '/', __DIR__).'/../');

/***********************检测常量**************************/
//核心常量
defined('MFPATH') || define('MFPATH' , $_SERVER["DOCUMENT_ROOT"].'/../');
defined('RUN_PATH') || define('RUN_PATH' , MFPATH.'RunData/');
defined('UP_PATH') || define('UP_PATH' , RUN_PATH.'Upload/');
defined('CONFIG_PATH') || define('CONFIG_PATH' , MFPATH.'Base/Config/');


/***********************框架需要的全局内容可以在此引入**************************/
//全局方法
include MFPATH."Base/Lib/F.php";
//启动服务
include MFPATH."Base/Tool/WebSocket.php";





