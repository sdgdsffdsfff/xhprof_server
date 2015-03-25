<?php
namespace Phplib\Xhprof\Helper;

/**
 * 性能统计信息
 */
class RedisStatisticListHelper extends \Phplib\Redis\Redis {
	
	static $prefix = 'XHPROF_STATISTIC_LIST';

	const XHPROF_TYPE = 'XHPROF';

	const XHPROF_TYPE_SNAKE = 'XHPROF_SNAKE';

	/**
	 * 添加统计信息
	 * @param $uniqid string 唯一键
	 * @param $data array 统计数据
	 * @return boolean
	 */
	public static function add($host, $type = 'XHPROF', $uniqid) {
		$name = $host . $type;	
		return parent::lpush($name, $uniqid);
	}

	/**
	 * 获取统计信息
	 */
	public static function getStatistic($host, $offset, $limit) {
		$name = $host . self::XHPROF_TYPE;
		$end = $offset + $limit - 1;
		return parent::lRange($name, $offset, $end);
	}

	/**
	 * 获取snake统计信息
	 */
	public static function getSnakeStatistic($host, $offset, $limit) {
		$name = $host . self::XHPROF_TYPE_SNAKE;
		$end = $offset + $limit - 1;
		return parent::lRange($name, $offset, $end);
	}
}
