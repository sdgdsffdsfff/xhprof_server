<?php
namespace Phplib\Xhprof;

/**
 * 性能分析数据写入文件
 */
class FileWriteData extends DataLoadBase {
	
	private $dir = '/home/work/xhprof/';
	private $suffix = 'xhprof';

	/**
	 * 获取写入文件名
	 * $param $runId 唯一识别码
	 */
	public function getFileName($runId) {
		$file = $this->dir . "$runId." . $this->suffix;
		return $file;
	}

	public function setDir($dir) {
		if (!file_exists($dir)) {
			mkdir($dir);
		}
		$this->dir = $dir;
	}

	/*
	 * 获取数据
	 */
	public function getFileData($data) {
		return serialize($data);	
	}

	/**
	 * 获取唯一码
	 */
	protected function getRunId($runId = NULL) {
		if (is_null($runId)) {
			$runId = uniqid();
		}
		return $runId;
	}

	/**
	 * 写入数据
	 */
	public function save($data, $runId = NULL) {
		$runId = $this->getRunId($runId);
		$fileName = $this->getFileName($runId);
		$file = fopen($fileName, 'w');	
		if ($file) {
			fwrite($file, $this->getFileData($data));
			fclose($file);
			$this->setCode(self::SUCCESS);
			$this->runId = $runId;
		}
		else {
			$this->setCode(self::FILE_NOT_EXISTS);
		}
	}

}
