<?php
namespace Phplib\Xhprof;

/**
 * xhprof 分析工具基类，不针对某一框架平台
 */
abstract class XhprofBase {

	protected $switch = FALSE;

	public function __construct($data) {
		if (defined('XHPROF_SWITCH') && XHPROF_SWITCH == 1 && !empty($data['use_xhprof'])) {
			$this->setSwitch($data);
		}
	}

	protected function getSwitch() {return $this->switch;}

	protected function setSwitch($config, $data) { }
}
