<?php
/**
 * @category   PSystem
 * @package    PSystem_OptimizationHead
 * @author     Pascal System <info@pascalsystem.pl>
 * @version    1.0.2
 */

/**
 * @see PSystemHtmlMinify
 */
require_once dirname(__FILE__).'/../lib/PSystemHtmlMinify.php';

/**
 * Pascal Optimization observer
 * 
 * @category   PSystem
 * @package    PSystem_OptimizationHead
 * @author     Pascal System <info@pascalsystem.pl>
 * @version    1.0.2
 */
class PSystem_OptimizationHead_Model_Observer {
/**
 * Post dispatch proccess compress html file
 * 
 * @param Varien_Event_Observer $event
 */
	public function postDispatch(Varien_Event_Observer $event) {
		if (!Mage::getStoreConfig('psoptimizationhead/html/disable'))
			return;
		
		/* @var $controller Mage_Core_Controller_Varien_Action */
		$controller = $event->getControllerAction();
		$allHtml = $controller->getResponse()->getBody();
		$allHtml = PSystemHtmlMinify::min($allHtml);
		$controller->getResponse()->setBody($allHtml);
	}
}
