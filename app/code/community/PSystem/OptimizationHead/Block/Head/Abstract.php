<?php
/**
 * @category   PSystem
 * @package    PSystem_OptimizationHead
 * @author     Pascal System <info@pascalsystem.pl>
 * @version    1.0.2
 */

/**
 * Pascal Head combine abstract
 * 
 * @category   PSystem
 * @package    PSystem_OptimizationHead
 * @author     Pascal System <info@pascalsystem.pl>
 * @version    1.0.2
 */
$extClass = Mage::getStoreConfig('psoptimizationhead/extension/classname');
if (!$extClass) $extClass = 'Mage_Page_Block_Html_Head';
eval('abstract class PSystem_OptimizationHead_Block_Head_Abstract extends '.$extClass.' {}');