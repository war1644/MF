<?php
namespace Base\Tool;
/**
 *         ▂▃╬▄▄▃▂▁▁
 *  ●●●█〓████████████▇▇▇▅▅▅▅▅▅▅▅▅▇▅▅          BUG
 *  ▄▅█████☆█☆█☆███████▄▄▃▂
 *  ███████████████████████████
 *  ◥⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙▲⊙◤
 *
 *
 * @author 路漫漫
 * @link ahmerry@qq.com
 * @version
 * v2016/12/19   初版
 */
class Upload {
	public $file = [];
	public $ext = '';
	public $name = '';
	public $dir = '';
	public $allowExt = ['jpg' , 'jpeg' , 'png' , 'gif' , 'dod'];
	public $maxSize = 1000000;

	public function up($name){
		if(!isset($_FILES[$name])) {
			throw new \Exception("has not this file", 500);
		}

		if($_FILES[$name]['error'] !== 0) {
			return false;
		} else {
			$this->file = $_FILES[$name];
		}
		
		if(move_uploaded_file($this->file['tmp_name'], MFPATH . $this->createDir() . '/' . $this->createName() . '.' . $this->getExt())) {
			return [
				'url'=>$this->dir . '/' . $this->name . '.' . $this->ext,
				'ext'=>$this->ext,
			];
		} else {
			return false;
		}
	}

	// 创建目录
	public function createDir() {
		$this->dir = UP_PATH . date('Ymd/');
        if (CheckDir($this->dir)) return true;
        return false;
	}

	// 获取文件后缀
	public function getExt(){
		$ext = explode('.' , $this->file['name']);
		return $this->ext = strtolower(end($ext));
	}

	// 生成文件名
	public function createName($len = 6) {
		return $this->name = RandStr($len);
	}
	// 检查是否允许上传
	// 检查上传文件大小
	/*
	 自行加2个方法,负责检测后缀是否允许上传
	 检测文件的大小是否超标
	*/
}
