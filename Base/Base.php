<?php
/**
 * Created by 路漫漫.
 * User: ahmerry@qq.com
 * Date: 2016/12/9 10:00
 * 在框架里面，你应该接管一切信息----路漫漫
 */
class Base {
    public function __construct() {
        $this->initSystemHandlers();
    }

    /**
     * 接管系统错误、异常
     */
    public function initSystemHandlers() {
        set_error_handler([$this , 'handlerError']);
        set_exception_handler([$this , 'handlerException']);
    }

    /**
     * 处理错误
     */
    public function handlerError($errno , $errstr , $file , $line) {
        $exception = new \ErrorException($errstr , $errno , 1 , $file , $line);
        throw $exception;
    }

    public function handlerException($exception) {
        $this->handler($exception);
    }

    /**
     * 处理异常
     */
    public function handler($exception) {
        $msg = $exception->getMessage();
        $file = $exception->getFile();
        $line = $exception->getline();
        $err = "File : $file\n<br>Line : $line\n<br>$msg\n<pre>";
        //写入日志
        MFLog($err);
        $traces = $exception->getTrace();
        if($exception instanceof \ErrorException) {
            array_shift($traces);
        }

        $c = new \Base\C();
        $c->view('error',['err'=>$err,'traces'=>$traces]);
    }
}
