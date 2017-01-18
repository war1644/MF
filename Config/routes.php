<?php
/**
 * Created by 路漫漫.
 * User: ahmerry@qq.com
 * Date: 2016/12/8 13:53
 * PHP框架,有了路由就有了一切----路漫漫
 * 增加该路由防御体系(cookie,get,post),若不想防御,增加第三个参数'false'
 */
//载入了 Macaw 类
use Base\Macaw;

//路由分发
//其实你找不到get/post/any方法>_<，找不到就触发__callstatic这货,接收$method 和 $params参数，$method就是没找到的方法名，$params为方法里的两个参数
//__callstatic分别将URL（即 fuck）、HTTP方法（即 GET）和回调代码压入 $routes、$methods 和 $callbacks 三个 Macaw 类的静态成员变量（数组）中
Macaw::get('fuck', function() {
    echo "成功！";
});

Macaw::any('',function (){
    echo 'welcome to MF';
});

Macaw::any('Wechat/(:all)',function ($p){
    $c = new WechatC();
    $c->method = $p;
    $c->$p();
});

Macaw::any('Public/(:all)',function ($p){
    $c = new PublicC();
    $c->method = $p;
    $c->$p();
});


Macaw::any('wechat', 'WechatC@auth');

Macaw::$error_callback = function() {
    throw new \Exception("路由无匹配项 404 Not Found",404);
};

//有啥是我hold不住的？
//Macaw::any('(:all)', function($fu) {
//    echo '未匹配到路由<br>'.$fu;
//});

//处理当前 URL ,匹配直接回调闭包方法，不匹配再用正则匹配，还没有就404
Macaw::dispatch();