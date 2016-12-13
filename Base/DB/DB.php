<?php
namespace Base;
/**
 * Created by 路漫漫.
 * User: ahmerry@qq.com
 * Date: 2016/12/8 15:32
 */

class DB extends \PDO {
	public function __construct() {
		$cfg = include(MFPATH . 'Config/db.php');
		$dsn = 'mysql:host=' . $cfg['host'] . ';dbname=' . $cfg['dbname'];
		parent::__construct($dsn , $cfg['user'] , $cfg['password']);
		$this->charset($cfg['charset']);
	}

	/**
	* 选择数据库
	*/
	public function useDb($db) {
		$this->exec('use ' . $db);
	}

	/**
	* 设置字符集
	*/
	public function charset($char) {
		$this->exec('set names ' . $char);
	}

	/**
	* 查询1行
	*/
	public function getRow($sql , $params=[]) {
		$st = $this->prepare($sql);
		if($st->execute($params)) {
			return $st->fetch(\PDO::FETCH_ASSOC);
		} else {
			list(,$errno , $errstr) = $st->errorinfo();
			throw new \Exception($errstr, $errno);
		}
	}

	/**
	* 查询多行
	*/
	public function getAll($sql , $params=[]) {
		$st = $this->prepare($sql);
		if($st->execute($params)) {
			return $st->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			list(,$errno , $errstr) = $st->errorinfo();
			throw new \Exception($errstr, $errno);
		}
	}

	/**
	* 删除数据
	*/
	public function delete($sql , $params=[]) {
		$st = $this->prepare($sql);
		if($st->execute($params)) {
			return $st->rowCount();
		} else {
			list(,$errno , $errstr) = $st->errorinfo();
			throw new \Exception($errstr, $errno);
		}
	}

	/**
	* 添加记录
	*/
	public function insert($sql , $params=[]) {
		$st = $this->prepare($sql);
		if($st->execute($params)) {
			return $this->lastInsertId();
		} else {
			list(,$errno , $errstr) = $st->errorinfo();
			throw new \Exception($errstr, $errno);
		}
	}

	/**
	* 修改记录
	*/
	public function update($sql , $params=[]) {
		$st = $this->prepare($sql);
		if($st->execute($params)) {
			return $st->rowCount();
		} else {
			list(,$errno , $errstr) = $st->errorinfo();
			throw new \Exception($errstr, $errno);
		}
	}

}
