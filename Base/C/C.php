<?php
namespace Base;
/**
 * 变量输出
 * 视图引入
 * @author 路漫漫
 * @link ahmerry@qq.com
 * @version V1.0
 * @since
 * <p>v0.9 2016/12/8 15:15  初版</p>
 * <p>v1.0 2016/12/12 14:21  增加默认视图</p>
 */

class C {
    protected $m = null;
    public $method = null;
    protected $data = [];

    /**
     * 输出数组格式变量到视图
     * @param $key 输出到视图的变量名
     * @param $value 输出到视图的变量
     */
    public function assign($key , $value) {
        $this->data[$key] = $value;
    }

    /**
     * @param $template 视图文件名,若为空则为方法名
     */
    public function display($template) {
        //检查数据
        extract($this->data);
        if (!$template){
            $template = $this->method;
        }
        //引入视图
        include (V_PATH. $template . '.php');
    }
}