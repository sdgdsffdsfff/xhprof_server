<?php
namespace Phplib\Xhprof;

/**
 *
 */
class DataLoadBase {

	//成功
	const SUCCESS = 0;
	//没有找到文件
	const FILE_NOT_EXISTS = 1000;
	//数据为空
	const FILE_DATA_EMPTY = 2000;

	protected $msgMap = array(
		self::SUCCESS => '成功',
		self::FILE_NOT_EXISTS => '文件为空',
		self::FILE_DATA_EMPTY => '数据为空',
	);
	
	protected function setCode($code) {
		$this->code = $code;
		$this->setErrorMsg($this->msgMap[$code]);
	}

	protected function setErrorMsg($msg) {
		$this->msg = $msg;
	}

	public function response() {
		return array('code' => $this->code, 'msg' => $this->msgMap[$this->code], 'run_id' => $this->runId);
	}
}
