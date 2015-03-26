<?php
namespace Phplib\Xhprof;

/**
 * 性能分析工厂类
 *
 * 不局限于xhprof
 */
class AnyFactory {

	//分析数据落地
	const TYPE_STORAGE_TEXT = 1; 
	const TYPE_STORAGE_DB = 2;
	const TYPE_STORAGE_REDIS = 3;


	//统计数据
	const TYPE_ANY_DB = 1;
	const TYPE_ANY_REDIS = 2;

	//请求来源
	const SOURCE_SNAKE = 1; 
	const SOURCE_VIRUS = 2;

	private $classMap = array(
		self::SOURCE_VIRUS => '\\Phplib\\Xhprof\\VirusXhprof',
		self::SOURCE_SNAKE => '\\Phplib\\Xhprof\\SnakeXhprof',
	);

	private $source = 0;
	private $data = array();

	/**
	 * @param $source 来源 self::请求来源
	 * @param $data 请求数据 array
	 */
	public function __construct($source, $data) {
		$this->source = $source;
		$this->data = $data;
	}

	public function request() {
		static $singleton = array();
		!isset($singleton[$this->source]) && $singleton[$this->source] = new $this->classMap[$this->source]($this->data);
		return $singleton[$this->source];
	}

}
