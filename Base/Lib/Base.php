<?php
namespace Base\Lib;
/**
 *         ▂▃╬▄▄▃▂▁▁
 *  ●●●█〓██████████████▇▇▇▅▅▅▅▅▅▅▅▅▇▅▅          BUG
 *  ▄▅████☆RED █ WOLF☆███▄▄▃▂
 *  █████████████████████████████
 *  ◥⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙◤
 *
 * 在框架里面，你应该接管一切信息
 * @author 路漫漫
 * @link ahmerry@qq.com
 * @version
 * v2017/03/14      删除composer,采用autoload方式加载文件
 * v2016/12/15      初版
 */
class Base {
    protected static $obj = null;
    private function __construct() {
        $this->initSystemHandlers();
        //autoload自动载入
        $this->init();
    }

    //关闭clone
    private function __clone() {}

    public static function ins(){
        if (self::$obj===null){
            self::$obj = new self();
        }
        return self::$obj;
    }

    /**
     * 接管系统错误、异常
     */
    protected function initSystemHandlers() {
        set_error_handler([$this , 'handlerError']);
        set_exception_handler([$this , 'handlerException']);
    }

    /**
     * 处理错误
     */
    public function handlerError($errno , $errstr , $file , $line) {
        throw new \ErrorException($errstr , $errno , 1 , $file , $line);
    }

    public function handlerException($exception) {
        $this->handler($exception);
    }

    /**
     * 处理异常
     */
    protected function handler($exception) {
        $msg = $exception->getMessage();
        $file = $exception->getFile();
        $line = $exception->getline();
        $code = $exception->getCode();
        $err = "File : $file\n<br>Line : $line\n<br>$msg\n<pre>";
        //写入日志
        MFLog($err);
        $traces = $exception->getTrace();
        if($exception instanceof \ErrorException) {
            array_shift($traces);
        }
        $c = new \Base\C();
        if (isset($code) && $code==404){
            $c->view('Base/404.php',['err'=>$err]);
        }else{
            $c->view('Base/error.php',['err'=>$err,'traces'=>$traces]);

        }
    }

    /**
     * 自动加载对应文件
     *
     * @param string $class
     * @return bool
     */
    protected static function autoLoad($class) {
        $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
        clearstatcache();
        $path = MFPATH . $file;
        if (is_file($path)) {
            include $path;
            if (class_exists($class, false)) {
                return true;
            }
        }
        return false;
    }

    /**
     * 初始化
     *
     * @return object
     */
    protected function init() {
        spl_autoload_register([$this, 'autoLoad']);
        return $this;
    }
}
//自调用
Base::ins();