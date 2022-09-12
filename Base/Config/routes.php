<?php
/**
 *         ▂▃╬▄▄▃▂▁▁
 *  ●●●█〓████████████▇▇▇▅▅▅▅▅▅▅▅▅▇▅▅          BUG
 *  ▄▅█████☆█☆█☆███████▄▄▃▂
 *  ███████████████████████████
 *  ◥⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙◤
 *
 *
 * PHP框架,有了路由就有了一切
 * @author 路漫漫
 * @link ahmerry@qq.com
 * @version
 * v2017/01/09  增加路由过滤体系(cookie,get,post),若不想过滤,增加第三个参数为false
 * v2017/03/09  初版
 */
use Base\Lib\Macaw;
//__callstatic分别将URL、HTTP方法（即 GET）和回调代码压入 $routes、$methods 和 $callbacks 三个 Macaw 类的静态成员变量（数组）中
Macaw::$error_callback = function() {
    throw new \Exception("路由无匹配项 404 Not Found",404);
};

//有啥是我hold不住的？
//Macaw::any('(:all)', function($fu) {
//    echo 'hold up <br>'.$fu;
//});

//处理当前 URL ,匹配直接回调闭包方法，不匹配再用正则匹配，还没有就404
Macaw::dispatch();