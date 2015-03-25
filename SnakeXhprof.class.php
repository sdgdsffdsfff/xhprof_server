<?php
namespace Phplib\Xhprof;

/**
 * Snake 请求
 */
class SnakeXhprof extends XhprofBase implements IPerformanceAnalysis {

	private $timeStart = 0;
	private $timeFinish = 0;
	private $xhprofData = '';
	private $module = '';
	private $action = '';
	//分析数据落地方式
	private $analysisDataType = AnyFactory::TYPE_STORAGE_TEXT;
	//分析统计数据落地方式
	private $analysisSummary  = AnyFactory::TYPE_ANY_REDIS;

	public function setSwitch($data) {
		$switch = FALSE;
		$this->module = $data['module'];
		$this->action = $data['action'];
		$server = explode('.', $_SERVER['SERVER_NAME']);
		$actionList = \Phplib\Xhprof\Helper\XhprofConfigRedisHelper::getActionList($server[1], $this->module, Helper\XhprofConfigRedisHelper::PLATFORM_SNAKE);
		foreach ($actionList as $value) {
			list($actionName, $serverSwitch) = explode(':', $value);
			if ($actionName == $this->action) {
				$switch = $serverSwitch;
				break;
			}
		}
		$this->switch = $switch;
	}

	public function start() {
		if (!$this->getSwitch()) {
			return FALSE;
		}
		xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
		$this->timeStart = microtime(TRUE);
	}

	public function write() {
		if (!$this->getSwitch()) {
			return FALSE;
		}
		$this->xhprofData = xhprof_disable();
		$this->timeFinish = microtime(TRUE);
		//简单化处理
		//写入文本
		$fileWriteObj = new FileWriteData();
		$runId = uniqid();
		$server = explode('.', $_SERVER['SERVER_NAME']);
		$fileWriteObj->setDir('/home/work/xhprof/' . $server[1] . '/');
		$fileWriteObj->save($this->xhprofData, $runId);
		$response = $fileWriteObj->response();
		if ($response['code'] !== \Phplib\Xhprof\DataLoadBase::SUCCESS) {
			return FALSE;
		}
		//统计数据
		$statisticData = array(
			'module' => $this->module,
			'action' => $this->action,
			'time_spend' => round(($this->timeFinish - $this->timeStart) * 1000, 2),
			'ctime' => $_SERVER['REQUEST_TIME'],
		);
		Helper\RedisStatisticHelper::set($response['run_id'], $statisticData);
		Helper\RedisStatisticListHelper::add($server[1], Helper\RedisStatisticListHelper::XHPROF_TYPE_SNAKE, $response['run_id']);
		return TRUE;
	}

}
