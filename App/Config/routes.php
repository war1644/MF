<?php
/**
 *         ▂▃╬▄▄▃▂▁▁
 *  ●●●█〓██████████████▇▇▇▅▅▅▅▅▅▅▅▅▇▅▅          BUG
 *  ▄▅████☆RED █ WOLF☆███▄▄▃▂
 *  ████████████████████████████
 *  ◥⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙◤
 *
 * PHP框架,有了路由就有了一切
 * @author 路漫漫
 * @link ahmerry@qq.com
 * @version
 * v2017/01/09  增加路由过滤体系(cookie,get,post),若不想过滤,增加第三个参数为false
 * v2017/03/09  初版
 */
use Base\Lib\Macaw;
//路由分发
Macaw::get('fuck', function() {
    echo "成功！";
});

Macaw::any('',function (){
    echo "welcome to routes";
});

Macaw::any('Wechat/(:all)',function ($p){
    $c = new App\C\WechatC();
    $c->method = $p;
    $c->$p();
});

Macaw::any('Public/(:all)',function ($p){
    $c = new App\C\PublicC();
    $c->method = $p;
    $c->$p();
});

Macaw::any('Home/Home/(:all)',function ($p){
    $c = new App\C\Home\HomeC();
    $c->method = $p;
    $c->$p();
});


Macaw::any('wechat', 'App\C\WechatC@auth');
