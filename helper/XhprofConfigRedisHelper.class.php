<?php
namespace Phplib\Xhprof\Helper;

/**
 * xhprof配置类,每个用户有独立的配置
 *
 * type: set
 *
 * 可以使配置文件落地 todo
 */
class XhprofConfigRedisHelper extends \Phplib\Redis\Redis {

	static $prefix = 'XHPROF_CONFIG';

	const TYPE_ACTION_LIST = 'ACTION_LIST';
	const TYPE_MODULE_LIST = 'MODULE_LIST';

	const PLATFORM_VIRUS = 'VIRUS';
	const PLATFORM_SNAKE = 'SNAKE';

	/**
	 * 获取moduleList
	 *
	 * @return array
	 */
	public static function getModuleList($host, $platform) {
		$name = $platform . ':' . self::TYPE_MODULE_LIST . ':' . $host;
		return parent::smembers($name);
	}

	/**
	 * 获取actionList
	 *
	 * @return array
	 */
	public static function getActionList($host, $module, $platform) {
		$name = $platform . ':' . self::TYPE_ACTION_LIST . ':' . $module. ':' . $host;
		return parent::smembers($name);
	}

	/**
	 * 添加module
	 *
	 * @return bool
	 */
	public static function addModuleList($host, $module, $platform) {
		$name = $platform . ':' . self::TYPE_MODULE_LIST . ':' . $host;
		return parent::sadd($name, $module);
	}

	/**
	 * 添加action
	 *
	 * @return bool
	 */
	public static function addActionList($host, $module, $action, $platform) {
		$name = $platform . ':' . self::TYPE_ACTION_LIST. ':' . $module . ':' . $host;
		return parent::sadd($name, $action);
	}

}
