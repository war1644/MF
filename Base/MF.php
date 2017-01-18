<?php
/**
 * Created by 路漫漫.
 * link: ahmerry@qq.com
 * Date: 2016/12/9 10:00
 * 在框架里面，你应该接管一切信息----路漫漫
 */
//检测常量
defined('MFPATH') ? : define('MFPATH' , $_SERVER["DOCUMENT_ROOT"].'/../');
defined('BASE_URL') ? : define('BASE_URL' , 'http://c.cn/');
defined('RUN_PATH') ? : define('RUN_PATH' , MFPATH.'RunData/');
defined('V_PATH') ? : define('V_PATH' , MFPATH.'Public/V/');
defined('KS_PATH') ? : define('KS_PATH' , V_PATH.'KSWechat/');
defined('V_URL') ? : define('V_URL' , BASE_URL.'V/');
defined('STATIC_URL') OR define('STATIC_URL' , V_URL.'Static/');
defined('REDIS') OR define('REDIS' , false);
defined('CONFIG_PATH') OR define('CONFIG_PATH' , MFPATH.'Config/');

//搬运工出场
//autoload自动载入 内存中开启一个(命名空间类名=>文件名路径)数组
//代码中使用某个类的时候（use xxxx），将自动载入该类所在的文件
require_once MFPATH."vendor/autoload.php";

//引入全局方法
require_once MFPATH."Base/F/functions.php";

//接管
new \Base\Base();

//路由,交通指挥出场
require_once CONFIG_PATH."routes.php";