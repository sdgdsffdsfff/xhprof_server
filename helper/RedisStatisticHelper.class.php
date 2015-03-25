<?php
namespace Phplib\Xhprof\Helper;

/**
 * 性能统计信息
 */
class RedisStatisticHelper extends \Phplib\Redis\Redis {
	
	static $prefix = 'XHPROF_STATISTIC';

	/**
	 * 添加统计信息
	 * @param $uniqid string 唯一键
	 * @param $data array 统计数据
	 * @return boolean
	 */
	public static function set($uniqid, $data) {
		$data = serialize($data);
		return parent::set($uniqid, $data);
	}

	/**
	 * 获取统计信息
	 * @param $uniqid string 唯一键
	 * @return array
	 */
	public static function get($uniqid) {
		$data = parent::get($uniqid);
		return unserialize($data);
	}

}
