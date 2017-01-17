PHP它爹说
===
>Rasmus: "I don't like frameworks. PHP frameworks are ridiculous slow".

MF
===
    为什么我还要写MF？因为虽然不需要复杂的框架，但是一款简单结构化代码的工具还是需要的！
   
    一个轻便简约干净型MVC PHP框架，Macaw路由，composer autoload，核心大小不到24kb!
    因为简单，所以你可以直接看代码就能懂，看代码的时间用不了你半天的
    
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
* 虽然用了composer，但是耦合很低。不想用它，直接删除，自己添加class映射就好
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