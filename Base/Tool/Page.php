<?php 
namespace Base;
/**
 * Created by 路漫漫.
 * User: ahmerry@qq.com
 * Date: 2016/12/9 11:58
 *
 * 分页
 *
 */
class Page {
	public $total = 0;
	public $num = 10;
	public $key = 'page';
	public $curr = 1;
	public $cnt = 5;

	public function __construct($total=0 , $num=10) {
		$this->total = $total;
		$this->num = $num;
		$this->curr = isset($_GET[$this->key]) ? (int)$_GET[$this->key] : 1; // 计算当前页码
	}

	/**
	* 输出页码
	*/
	public function show() {
		$max = ceil($this->total / $this->num); // 计算最大页码

		// 计算最左侧页码
		$left = $this->curr - floor(($this->cnt - 1) / 2);
		$left = max($left , 1);

		$right = $left + $this->cnt - 1; // 计算最右页码
		$right = min($right , $max);

		$left = $right - $this->cnt + 1; // 计算最左页码
		$left = max($left , 1);

		unset($_GET[$this->key]);

		$code = [];
		for($i=$left; $i<=$right; $i++) {
			$_GET[$this->key] = $i;
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
			$code[] = $uri."?$this->key=$i";
		}

		return $code;
	}

}

?>