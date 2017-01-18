PHP它爹说
===
>Rasmus: "I don't like frameworks. PHP frameworks are ridiculous slow".

MF
===
    为什么我还要写MF？因为虽然不需要复杂的框架，但是一款简单结构化代码的工具还是需要的！
   
    一个轻便简约干净型MVC PHP框架，Macaw路由，composer autoload，内置waf(当然，再牛逼的waf也不如良好的编码习惯)，核心大小不到24kb!
    
    因为简单，所以你可以直接看源码。放心，这不是Laravel，入门phper应该半天以内就看完了
    
目录结构
===
* `Base` : 框架核心
* `Config` : 数据库,路由等配置目录
* `App` : 应用demo目录,使用举例    
* `Public` : 入口
     * `index.php` : 入口文件
     * `V` : 视图目录
* `composer.json` : composer配置

注意
===
* url需要重写下，当然不重写就在路由匹配时多写个index.php也可以。详见下
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
        index  index.html index.php;
    } 
    ```
* Base下工具类用不上的可以删掉，完全独立。放在那也没事，不new也会耗资源
* 虽然用了composer，但耦合很低。不想用它，直接删除，自己添加class映射就好
* 添加新目录后，先更新composer.json,再运行dump-autoload -o
    ```
    "autoload":
     {
        "classmap":
        [
           "App",
           "Base"
        ]
    }
    ```