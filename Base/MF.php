<?php
/**
 *         ▂▃╬▄▄▃▂▁▁
 *  ●●●█〓██████████████▇▇▇▅▅▅▅▅▅▅▅▅▇▅▅          BUG
 *  ▄▅████☆RED█WOLF☆████▄▄▃▂
 *  █████████████████████████████
 *  ◥⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙◤
 *
 * 在框架里，你应该接管一切信息
 * @author 路漫漫
 * @link ahmerry@qq.com
 * @version
 * v0.9 2017/3/9 10:49  初版
 */
//检测常量
defined('MFPATH') ? : define('MFPATH' , $_SERVER["DOCUMENT_ROOT"].'/../');
defined('BASE_URL') ? : define('BASE_URL' , 'http://c.cn/');
defined('RUN_PATH') ? : define('RUN_PATH' , MFPATH.'RunData/');
defined('V_PATH') ? : define('V_PATH' , MFPATH.'Public/V/');
defined('UP_PATH') ? : define('UP_PATH' , MFPATH.'Public/Upload/');
defined('KS_PATH') ? : define('KS_PATH' , V_PATH.'KSWechat/');
defined('V_URL') ? : define('V_URL' , BASE_URL.'V/');
defined('STATIC_URL') OR define('STATIC_URL' , V_URL.'Static/');
defined('REDIS') OR define('REDIS' , false);
defined('CONFIG_PATH') OR define('CONFIG_PATH' , MFPATH.'Config/');

//搬运工出场
// 内存中开启一个(命名空间类名=>文件名路径)数组
//代码中使用某个类的时候（use xxxx），将自动载入该类所在的文件
//include MFPATH."vendor/autoload.php";

//引入全局方法
include MFPATH."Base/F/functions.php";
include MFPATH."Base/Base.php";

//接管
new \Base\Base();

//路由,交通指挥出场
include CONFIG_PATH."routes.php";