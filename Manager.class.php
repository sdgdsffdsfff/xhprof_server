<?php
namespace Phplib\Xhprof;

/**
 * 请求类的性能数据分析管理
 *
 */
class Manager {

	static $singleton = NULL;

	private $xhprofObj = NULL;

	public static function getRequest(IPerformanceAnalysis $xhprofObj) {
		if (is_null(self::$singleton)) {
			self::$singleton = new self($xhprofObj);
		}	
		return self::$singleton;
	}

	private function __construct(IPerformanceAnalysis $obj) {
		$this->xhprofObj = $obj;
	}
	
	/**
	 * 初始化
	 */
	public function init() {
		$this->xhprofObj->start();
	}

	/**
	 * 入库
	 */
	public function finish() {
		$this->xhprofObj->write();	
	}
}
