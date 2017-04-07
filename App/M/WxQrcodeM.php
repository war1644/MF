<?php
namespace App\M;
/**
 *         ▂▃╬▄▄▃▂▁▁
 *  ●●●█〓██████████████▇▇▇▅▅▅▅▅▅▅▅▅▇▅▅          BUG
 *  ▄▅████☆RED █ WOLF☆███▄▄▃▂
 *  █████████████████████████████
 *  ◥⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙◤
 *
 * demo 示例
 * @author 路漫漫
 * @link ahmerry@qq.com
 * @version
 * v0.9 2017/01/23 初版
 */
use Base\Lib\M;

class WxQrcodeM extends M {

    public function addMac($data=[]) {
//        $sql = "insert into $this->table "
            foreach ($data as $i) {
                $this->add($i);
            }
    }

}