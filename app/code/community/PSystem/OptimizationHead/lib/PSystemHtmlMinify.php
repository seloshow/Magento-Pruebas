<?php
/**
 * @category   PSystem
 * @package    PSystem_OptimizationHead
 * @author     Pascal System <info@pascalsystem.pl>
 * @version    1.0.0
 */

/**
 * Pascal Optimization observer
 * 
 * @category   PSystem
 * @package    PSystem_OptimizationHead
 * @author     Pascal System <info@pascalsystem.pl>
 * @version    1.0.0
 */
class PSystemHtmlMinify {
/**
 * Compress html
 *
 * @param string $content
 * @return string
 */
	public static function min($content) {
		$content = str_replace("\n",'',$content);
		$content = str_replace("\r",'',$content);
		$content = preg_replace('/([\s]{2,})/',' ',$content);
		return $content;
	}
}