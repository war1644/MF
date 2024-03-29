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
//define('BASE_URL' , '/');
//define('API_URL' , 'api.com.cn/V0.5/');
defined('RUN_PATH') || define('RUN_PATH' , MFPATH.'../data/');
defined('V_PATH') || define('V_PATH' , MFPATH.'Public/V/');
defined('V_URL') || define('V_URL' , BASE_URL.'V/');
defined('UP_PATH') || define('UP_PATH' , RUN_PATH.'Upload/');
defined('CONFIG_PATH') || define('CONFIG_PATH' , MFPATH.'Base/Config/');
defined('STATIC_URL') || define('STATIC_URL' , V_URL.'Static/');
defined('CACHE_PATH') || define('CACHE_PATH' , RUN_PATH.'Cache/');

//功能性常量
defined('REDIS') || define('REDIS' , false);
//可以是A_PATH,B_PATH等等，为多项目提供支持
defined('APP_PATH') || define('APP_PATH' , MFPATH.'App/');

/***********************框架需要的全局内容可以在此引入**************************/
//全局方法
include MFPATH."Base/Lib/F.php";

//接管系统
include MFPATH."Base/Lib/Base.php";
//路由,交通指挥出场
if(file_exists(APP_PATH.'Config/config.php')){
    include APP_PATH."Config/routes.php";
}
include CONFIG_PATH."routes.php";