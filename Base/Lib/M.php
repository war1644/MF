<?php
namespace Base\Lib;
/**
 *         ▂▃╬▄▄▃▂▁▁
 *  ●●●█〓████████████▇▇▇▅▅▅▅▅▅▅▅▅▇▅▅          BUG
 *  ▄▅█████☆█☆█☆███████▄▄▃▂
 *  ███████████████████████████
 *  ◥⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙◤
 *
 * 表数据基础处理模型
 * 自动化映射表（主键，字段等等）
 * 清除不合法字段
 * 提供常用增删改查方法
 * @author 路漫漫
 * @link ahmerry@qq.com
 * @example
 * 1.
 * $sql = "xxxxxx";
 * $data = $this->query($sql)
 *
 * $data = ['type'=>1];
 * $this->where($data)->order('sort DESC')->limit(6)->fetchAll($field);
 *
 * $data = [':type'=>0,':time'=>time()];
 * $where = " `type`=:type and update_time > :time";
 * $this->where($where,$data)->order('access_count DESC')->limit(10,6)->fetchAll($field);
 *
 * 2.
 * $model = new KeywordM();
 * $model->where(['keyword'=>$keyword])->count();
 * $model->where(['keyword'=>$keyword])->fetch();
 * $model->where(['keyword'=>$keyword])->fetchAll();
 * $model->increment('access_count',['keyword'=>$keyword]);
 * 3.
 * $model->insert(['keyword'=>$keyword,'update_time'=>time()])
 * 4.
 * $time = strtotime("-1 month");
 *
 * @version
 * v2018/10       修改方法名保持跟pdo方法一致，便于识别，新增increment方法：字段字增1
 * v2017/04/07    增加executeSql方法（PDO预处理方式）;修复命名空间下AutoLoad时，表名匹配错误问题
 * v2017/01/24    增加最简单粗暴的query 和 exec方法(注意这两个为非预处理方式)
 * v2017/01/23    表名映射采用正则匹配
 * v2016/12/08    初版
 */

use Base\DB\MyPDO;
class M {
    protected $table = '';
    protected $db = null;
    protected $fields = [];
    protected $pk = '';
    protected $data = [];
    protected $options = [];
    protected $prefix = '';
    public $debug = false;

    public function __construct() {
        $this->getDb();
        $this->getTable();
        $this->parseTable();
        $this->reset();
    }

    /**
     * 获取ORM调用中的属性值
     */
    public function __get($per) {
        return isset($this->data[$per]) ? $this->data[$per] : NULL;
    }

    /**
     * 设置ORM调用中的属性值
     */
    public function __set($per , $value) {
        $this->data[$per] = $value;
    }

    /**
     * 根据Model类名分析出表名
     */
    public function getTable() {
        $this->prefix = $this->db->prefix;
        if($this->table){
            $this->table = '`'.$this->prefix.$this->table.'`';
        }else {
            $patt = '/[A-Z][a-z]*/';
            preg_match_all($patt, get_called_class(), $res);
            $res = $res[0];
            array_pop($res);
            unset($res[0], $res[1]);
            $res = strtolower(join('_', $res));
            $this->table = $this->prefix . $res;
        }
    }

    /**
     * 获取Db的实例,用于查询数据库
     */
    public function getDb() {
        $this->db = MyPDO::Ins();
    }

    /**
     * 根据主键来查询一条信息
     */
    public function find($id,$field = '*') {
        $sql = "select $field from $this->table where $this->pk = ?";
        return $this->data = $this->db->fetch($sql , [$id]);
    }

    /**
     * 根据主键来删除一条信息
     */
    public function delete($id) {
        $sql = "delete from $this->table where $this->pk = ?";
        return $this->db->delete($sql , [$id]);
    }

    /**
     * 根据传来的数组自动增加1条记录
     */
    public function insert($data=[]) {
        if(empty($data)) {
            $data = $this->data;
            $this->data = []; // 清空this->data
        }

        $data = $this->facade($data); // 过滤非法字段

        if(empty($data)) {
            throw new Exception("data object is empty", 500);
        }

        $sql = "insert into $this->table (`";
        $sql .= implode('`,`',  array_keys($data) );
        $sql .= "`) values (";
        $sql .= substr( str_repeat('?,',  count($data) ) , 0 , -1 );
        $sql .= ')';
        if ($this->debug) echo $sql;
        return $this->db->insert($sql , array_values($data));
    }

    /**
     * 更新
     * @version v2018/10/12 下午1:40 初版
     * @param array $data
     * @param array $where
     * @return mixed
     */
    public function update($data=[],$where=[]) {
        if(empty($data)) {
            $data = $this->data;
        }
        $data = $this->facade($data); // 过滤非法字段

        $keys = array_keys( $data );
        $values = array_values( $data );
        $str = '`'.join( '`=?, `', $keys ).'`=?';
        $whereStr = '1';
        if($where)
        {
            if(is_array($where)){
                $whereKeys = array_keys( $where );
                $whereValues = array_values( $where );
                $whereStr = '`'.join( '`=? and `', $whereKeys ).'`=?';
                $values = array_merge($values,$whereValues);
            }else{
                $whereStr = $where;
            }
        }
        $sql = "UPDATE $this->table SET $str WHERE $whereStr;";
        return $this->db->update($sql , $values);
    }


    /**
     * int字段自增减1
     * 该方法会自动更新表update_time字段
     * @version v2018/10/15 下午3:01 初版
     * @param $field
     * @param $where
     * @return mixed
     */
    public function increment($field,$where)
    {
        $values = [];
        if(is_array($where)){
            $whereKeys = array_keys( $where );
            $values = array_values( $where );
            $whereStr = '`'.join( '`=? and `', $whereKeys ).'`=?';
        }else{
            $whereStr = $where;
        }
        $sql = "update $this->table set `$field` = `$field`+'1' where $whereStr";
        return $this->db->update($sql , $values);
    }

    /**
     * 分析表字段与主键
     */
    public function parseTable() {
        $info = $this->db->fetchAll('desc ' . $this->table);
        foreach($info as $v) {
            $this->fields[] =  $v['Field'];

            if($v['Key'] === 'PRI') {
                $this->pk = $v['Field'];
            }
        }
    }

    /**
     * 查询1条
     * @author duanxuqiang@ucse.net
     * @version v2018/10/12 下午1:21 初版
     * @param string $field
     * @return mixed
     */
    public function fetch($field='') {
        if($field) $this->options['cols'] = $field;
        $sql = $this->parseSql();
        $result = $this->db->fetch($sql,$this->params);
        $this->reset();
        return $result;
    }

    /**
     * 查询全部
     * @author duanxuqiang@ucse.net
     * @version v2018/10/12 下午1:21 初版
     * @param string $field
     * @return mixed
     */
    public function fetchAll($field='') {
        if($field) $this->options['cols'] = $field;
        $sql = $this->parseSql();
        $result = $this->db->fetchAll($sql,$this->params);
        $this->reset();
        return $result;
    }

    /**
     * 统计总条数
     * @author duanxuqiang@ucse.net
     * @version v2018/10/12 下午1:21 初版
     * @param string $field
     * @return mixed
     */
    public function count($field='id') {
        $field = "COUNT($field)";
        $this->options['cols'] = $field;
        $sql = $this->parseSql();
        $result = $this->db->fetch($sql,$this->params);
        $this->reset();
        if(isset($result[$field])) return intval($result[$field]);
        return false;
    }


    /**
     * 数组传递条件,如['name'=>'lisi' , 'age'=>29]---->where name='lisi' and age='29';
     * @version v2018/10/12 下午1:22 初版
     * @param array $where
     * @param array $data
     * @return $this
     */
    public function where($where=[],$data=[]) {
        if(is_array($where)) {
            $tmp = [];
            foreach($where as $k=>$v) {
                $tmp[] = " `$k`='$v'";
            }
            $where = join(' and',$tmp);
            $this->options['where'] = $where;
        } else if( is_string($where) ) {
            $this->params = $data;
            $this->options['where'] = $where;
        }
        return $this;
    }


    public function group($cols='') {
        if($cols) {
            $this->options['group'] = 'group by ' . $cols;
        }

        return $this;
    }

    public function having($cols='') {
        if($cols) {
            $this->options['having'] = 'having ' . $cols;
        }

        return $this;
    }

    public function order($cols='') {
        if($cols) {
            $this->options['order'] = 'order by ' . $cols;
        }

        return $this;
    }

    public function limit($offset,$n = NULL) {
        if($n === null) {
            $n = $offset;
            $offset = 0;
        }

        $this->options['limit'] = 'limit ' . $offset . ',' . $n;

        return $this;
    }

    public function parseSql() {
        $sql = 'select %s from %s where %s %s %s %s %s';
        $sql = sprintf($sql , $this->options['cols'] , $this->table , $this->options['where'] ,$this->options['group'],$this->options['having']  ,$this->options['order'] ,$this->options['limit']);
        return $sql;
    }

    /**
     * 还原model的options,防止影响下一次select
     */
    public function reset() {
        $this->options = [
            'cols'=>'*',
            'where'=>'1',
            'group'=>'',
            'having'=>'',
            'order'=>'',
            'limit'=>''
        ];
        $this->params = [];
    }

    /**
     * 清除不合法字段
     */
    public function facade($data) {
        foreach($data as $k=>$v) {
            if(!in_array($k , $this->fields)) {
                unset($data[$k]);
            }
        }
        return $data;
    }

    /**
     * query 执行SQL语句
     * 最简单粗暴的查询方式
     *
     * @param String $strSql
     * @param String $queryMode 查询方式(all or row)
     * @param Boolean $debug
     * @return Array
     */
    public function query($strSql, $queryMode = 'all', $debug = false){
        return $this->db->query($strSql, $queryMode, $debug);
    }

    /**
     * execSql 执行SQL语句
     * 最简单粗暴的执行方式
     * @param String $strSql
     * @param Boolean $debug
     * @return Int
     */
    public function execSql($strSql, $debug = false) {
        return $this->db->execSql($strSql, $debug);
    }

    /**
     * executeSql 执行SQL语句
     * 最简单粗暴的预处理执行方式,自动判定sql语句类型,返回对应数据
     * @param String $sql
     * @param String $mode 查询方式(all or row)
     * @param Boolean $debug
     * @return Int || Array || Boolean
     */
    public function executeSql($sql,$params=[],$mode='row',$debug=false) {
        $result = $this->db->executeSql($sql,$params,$mode,$debug);
        if ($mode='row') $this->data = $result;
        return $result;
    }

    /**
     * beginTransaction 开始事务
     */
    public function beginTransaction() {
        $this->db->beginTransaction();
    }

    /**
     * commit 提交事务
     */
    public function commit() {
        $this->db->commit();
    }

    /**
     * rollback 回滚事务
     */
    public function rollback() {
        $this->db->rollback();
    }

}
