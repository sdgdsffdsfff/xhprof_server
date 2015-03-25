<?php
namespace Phplib\Xhprof;

/**
 * 性能分析接囗
 */
interface IPerformanceAnalysis {
	
	public function start();

	public function write();
}
