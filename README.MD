# MF
    一个轻便简约干净型PHP框架，路由吸取Laravel，自动载入采用PSR-4，核心大小不到24kb!
    初次使用建议直接看Base目录文件，用不了半天时间
### 目录结构
* `Base` : 框架核心
* `Config` : 数据库,路由等配置目录
* `App` : 应用demo目录,使用举例    
* `Public` : 入口

     * `index.php` : 入口文件
     * `V` : 视图目录
* `composer.json` : composer配置

### 注意
* 由于采用PSR-4自动加载
* 添加新Class类后，请运行composer dump-autoload
* 添加新目录后，先更新composer.json,再运行dump-autoload
```
"autoload":
 {
    "classmap":
    [
       "App/C",
       "App/M",
       "Base"
    ]
}
```
   
* **否则error:找不到类,不要问我**