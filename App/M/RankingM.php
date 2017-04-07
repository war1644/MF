<?php
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
 * v2017/4/7 初版
 */

namespace App\M;

class RankingM extends MyModel {

    public function countDistance($id) {
        $sql = "select distance from $this->table WHERE ks_id=? and type=?";
        $res = $this->executeSql($sql,[$id,4]);
        return $res ? $res['distance'] : 0;
    }
}