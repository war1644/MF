PHP它爹说
===
>Rasmus: "I don't like frameworks. PHP frameworks are ridiculous slow".

MF
===
MF只有100kb不到，最关键的是：
**MF无任何依赖，没有复杂的结构，没有复杂的引用、调用，下载即食**
你只需要在routes里配置路由规则，在Controller里各种new，以及在Model里各种sql就好。
        
目录结构
===
* `App` :demo
    * `Config` : 
        * `config.php` : 配置
        * `routes.php` : 路由规则 
* `Base` : 框架核心  
* `Public` : 入口
     * `index.php` : 入口文件
     * `V` : 视图目录

工作流程
===
##### service模式
* 服务器调用service.php --> 常量检测定义 --> 全局方法载入,接管PHP系统错误日志等 --> 建立服务,监听端口；  
* websocket连接 --> 握手 --> 通讯

##### 常规模式
* 请求 --> index.php --> 常量检测定义 --> 全局方法载入,接管PHP系统错误日志等 --> 路由waf检测，过滤，new Controller --> new Model;
  
##### 对应文件流程
    index.php/service.php  --> MF.php/MFservice.php --> routes.php --> 各种new吧

注意
===
* url重写下会显得网址更好看，当然不重写就在路由匹配时多写个index.php也可以，详见下
    ```php
        //未重写的url匹配
        Macaw::any('index.php/Wechat/(:all)',function ($p){
            $c = new WechatC();
            $c->method = $p;
            $c->$p();
        });
        
        //重写过后的url匹配
        Macaw::any('Wechat/(:all)',function ($p){
            $c = new WechatC();
            $c->method = $p;
            $c->$p();
        });
    ```
* nginx rewrite

    ```
        location / {  
            if (!-e $request_filename) {  
                rewrite  ^/(.*)$  /index.php/$1  last;  
                break;  
            }  
            index index.php;  
        }   
    ```
* Base/Tool下工具类根据自己需求保留，用不上的可以删掉，减小框架体积（框架将缩小到100K以内），完全独立。
