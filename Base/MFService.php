<?php
/**
 *         ▂▃╬▄▄▃▂▁▁
 *  ●●●█〓████████████▇▇▇▅▅▅▅▅▅▅▅▅▇▅▅          BUG
 *  ▄▅█████☆█☆█☆███████▄▄▃▂
 *  ███████████████████████████
 *  ◥⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙◤
 *
 * 在框架里，你应该接管一切信息
 * @author 路漫漫
 * @link ahmerry@qq.com
 * @version
 * v2017/03/30   精简调整部分结构
 * v2016/12/09   初版
 */
/***********************检测常量**************************/
//核心常量
defined('MFPATH') || define('MFPATH' , $_SERVER["DOCUMENT_ROOT"].'/../');
defined('RUN_PATH') || define('RUN_PATH' , MFPATH.'RunData/');
defined('V_PATH') || define('V_PATH' , MFPATH.'Public/V/');
defined('UP_PATH') || define('UP_PATH' , RUN_PATH.'Upload/');
defined('CONFIG_PATH') || define('CONFIG_PATH' , MFPATH.'Base/Config/');
defined('CACHE_PATH') || define('CACHE_PATH' , RUN_PATH.'Cache/');
//功能性常量
defined('APP_PATH') || define('APP_PATH' , MFPATH.'App/');

/***********************框架需要的全局内容可以在此引入**************************/
//全局方法
include MFPATH."Base/Lib/F.php";

//接管系统
include MFPATH."Base/Lib/Base.php";

//启动服务
$S = \Base\Tool\Socket::ins('192.168.1.26',8404);
//\Base\Tool\Socket::ins('0.0.0.0',8404);