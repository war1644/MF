<?php
namespace Base;
/**
 * 变量输出
 * 视图引入
 * @author 路漫漫
 * @link ahmerry@qq.com
 * @version V1.2
 * @since
 * <p>v0.9 2016/12/8 15:15  初版</p>
 * <p>v1.0 2016/12/12 14:21  增加默认视图</p>
 * <p>v1.1 2016/12/13 15:32  简化方法为一个</p>
 * <p>v1.2 2017/1/17 9:34  增加 $path 参数，方便视图快速切换</p>
 */

class C {
    protected $m = null;
    public $method = null;
    /**
     * 载入视图,输出变量到视图
     * @param $template 视图文件名,若为空则为方法名
     * @param $data 输出到视图的变量
     * @param $path 视图路径
     */
    public function view($template,$data='',$path='./') {
        if (!isset($data['title'])){
            $data['title'] = '废土战记';
        }
        if (!$template){
            $template = $this->method;
        }
        //引入视图
        include (V_PATH. $path .$template . '.php');
    }
}