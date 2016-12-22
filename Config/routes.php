<?php
/**
 * Created by 路漫漫.
 * User: ahmerry@qq.com
 * Date: 2016/12/8 13:53
 * PHP框架,有了路由就有了一切----路漫漫
 * 增加该路由防御体系(cookie,get,post),若不想防御,增加第三个参数'false'
 */
//载入了 Macaw 类
use war1644\Macaw\Macaw;

//路由分发
//其实你找不到get方法>_<，找不到就触发__callstatic这货,接收$method 和 $params参数，$method就是没找到的方法名，$params为方法里的两个参数
//__callstatic分别将URL（即 fuck）、HTTP方法（即 GET）和回调代码压入 $routes、$methods 和 $callbacks 三个 Macaw 类的静态成员变量（数组）中
Macaw::get('fuck', function() {
    echo "成功！";
});
Macaw::get('home', 'HomeC@home');
Macaw::get('wxindex', 'WechatC@Test');
Macaw::any('wechat', 'WechatC@auth');
//Macaw::any('logdebug', 'WechatC@logdebug');
Macaw::get('wetest', 'WechatC@Index');
Macaw::get('wemenu', 'WechatC@SetMenus');


Macaw::get('wemenu', 'WechatC@SetMenus');
Macaw::$error_callback = function() {
    throw new \Exception("路由无匹配项 404 Not Found");
};

//有啥是老子hold不住的, 额,post就hold不住...
//Macaw::get('(:all)', function($fu) {
//    echo '未匹配到路由<br>'.$fu;
//});

//处理当前 URL ,匹配直接回调闭包方法，不匹配再用正则匹配，还没有就404
Macaw::dispatch();