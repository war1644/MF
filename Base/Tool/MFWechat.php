<?php
namespace Base\Tool;
use Base\Redis;
use War1644\Phpwechatsdk\Wechat;
/**
 * @Created by 路漫漫.
 * @Links: ahmerry@qq.com
 * @Date: 2016/12/9 15:07
 * 实现微信类的access_token缓存方案
 */

class MFWechat extends Wechat{

    public function __construct($option) {
        parent::__construct($option);

        Redis::init();
        if (!$this->getCache(TOKEN_NAME.$option['appid']))
            //获取access_token,并进行全局缓存
            $this->checkAuth();

        var_dump($this->getCache(TOKEN_NAME.$option['appid']));
    }

    /**
     * 重载设置缓存
     * @param string $cachename
     * @param mixed $value
     * @param int $expired 默认7200
     * @return boolean
     */
    protected function setCache($cachename, $value, $expired=7200) {
        return Redis::set($cachename, $value, $expired);
    }

    /**
     * 重载获取缓存
     * @param string $cachename
     * @return mixed
     */
    public function getCache($cachename) {
        return Redis::get($cachename);
    }

    /**
     * 重载清除缓存
     * @param string $cachename
     * @return boolean
     */
    protected function removeCache($cachename) {
        return Redis::delete($cachename);
    }

}