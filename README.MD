PHP它爹说
===
>Rasmus: "I don't like frameworks. PHP frameworks are ridiculous slow".

MF
===
    为什么还要写MF？因为虽然不需要复杂的框架，但是一款简单结构化代码的工具还是需要的！
   
    一个轻便简约干净型MVC PHP框架，Macaw路由，命名空间式autoload，内置waf，核心大小46kb!
    
    使用请看App文件夹下demo
    
目录结构
===
* `Base` : 框架核心
* `App` : 应用demo目录,使用举例    
* `Public` : 入口
     * `index.php` : 入口文件
     * `V` : 视图目录

注意
===
* 路由配置在Config下
* url需要重写下，当然不重写就在路由匹配时多写个index.php也可以，详见下
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
* Base下工具类用不上的可以删掉，减小框架体积（框架将缩小到100K以内），完全独立。
