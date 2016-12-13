<?php
namespace Base;
/**
 * Created by 路漫漫.
 * User: ahmerry@qq.com
 * Date: 2016/12/8 15:32
 *
 * 表数据基础处理模型
 * 自动化映射表（主键，字段等等）
 * 清除不合法字段
 * 提供常用增删改查方法
 *
 */

class M {
    protected $table = '';
    protected $db = null;
    protected $fields = [];
    protected $pk = '';
    protected $data = [];
    protected $options = [];
    protected $prefix = '';

    public function __construct() {
        $cfg = include(MFPATH . 'Config/db.php');
        $this->prefix = $cfg['prefix'];
        unset($cfg);
        $this->getTable();
        $this->getDb();
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
        $className = get_called_class();
        $this->table = $this->prefix.strtolower(substr($className , 0 , -1));
    }

    /**
    * 获取Db的实例,用于查询数据库
    */
    public function getDb() {
        $this->db = new DB();
    }

    /**
    * 根据主键来查询一条信息
    */
    public function find($id) {
        $sql = "select * from $this->table where $this->pk =?";
        return $this->data = $this->db->getRow($sql , [$id]);
    }

    /**
    * 根据主键来删除一条信息
    */
    public function remove($id) {
        $sql = 'delete from ' . $this->table . ' where ' . $this->pk . '=?';
        return $this->db->delete($sql , [$id]);
    }

    /**
    * 根据传来的数组自动增加1条记录
    */
    public function add($data=[]) {
        if(empty($data)) {
            $data = $this->data;
            $this->data = []; // 清空this->data
        }

        $data = $this->facade($data); // 过滤非法字段

        if(empty($data)) {
            throw new Exception("data object is empty", 500);
        }

        $sql = 'insert into ' . $this->table . ' (';
        $sql .= implode(',',  array_keys($data) );
        $sql .= ') values (';
        $sql .= substr( str_repeat('?,',  count($data) ) , 0 , -1 );
        $sql .= ')';

        return $this->db->insert($sql , array_values($data));
    }

    /**
    * 根据传来的数组修改1条记录
    * 传来的数组需要含有主键列,即要根据主要来修改
    */
    public function save($data=[]) {
        if(empty($data)) {
            $data = $this->data;
        }

        $data = $this->facade($data); // 过滤非法字段

        if(!isset($data[$this->pk])) {
            throw new Exception("need the primary key on svae", 500);
        }

        $pk = $data[$this->pk];
        unset($data[$this->pk]);

        $sql = 'update ' . $this->table . ' set ';
        foreach($data as $k=>$v) {
            $sql .= $k . '=? ,';
        }

        $sql = substr($sql , 0 , -1);
        $sql .= ' where ' . $this->pk . '=?';

        $data[$this->pk] = $pk;
        return $this->db->update($sql , array_values($data));
    }

    /**
    * 分析表字段与主键
    */
    public function parseTable() {
        $info = $this->db->getAll('desc ' . $this->table);
        foreach($info as $v) {
            $this->fields[] =  $v['Field'];

            if($v['Key'] === 'PRI') {
                $this->pk = $v['Field'];
            }
        }
    }

    /**
    * select 查询
    */
    public function select() {
        echo $sql = $this->parseSql();
        return $this->db->getAll($sql);
    }

    /**
    * 指定查询的列
    * @param string $col 要查询的列名
    */
    public function field($cols='') {
        $this->options['cols'] = $cols;
        return $this;
    }

    /**
    * 数组传递条件,如['name'=>'lisi' , 'age'=>29]---->where name='lisi' and age='29';
    * @param $cond array
    */
    public function where($cond=[]) {
        if(is_array($cond)) {
            $tmp = '';
            foreach($cond as $k=>$v) {
                $tmp .= $k . '=\'' . $v . '\'';
            }

            $this->options['where'] = $tmp;
        } else if( is_string($cond) ) {
            $this->options['where'] = $cond;
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

}
