<?php
/**
 * @category   PSystem
 * @package    PSystem_AjaxQuickCart
 * @author     Pascal System <info@pascalsystem.pl>
 * @version    1.0.2
 */

/**
 * @see Mage_Checkout_CartController
 */
require_once 'Mage/Checkout/controllers/CartController.php';

/**
 * Pascal Quick Cart Ajax Header JavaScripts
 * 
 * @category   PSystem
 * @package    PSystem_AjaxQuickCart
 * @author     Pascal System <info@pascalsystem.pl>
 * @version    1.0.2
 */
class PSystem_AjaxQuickCart_ViewcartController extends Mage_Checkout_CartController {
/**
 * Index action display only products in cart
 * 
 * @return void
 */
	public function indexAction() {
		$this->loadLayout()
			->_initLayoutMessages('checkout/session')
			->_initLayoutMessages('catalog/session')
		;
		$this->renderLayout();
	}
	
/**
 * Refresh box with items in cart
 * 
 * @return void
 */
	public function refreshAction() {
		/* @var $layout Mage_Core_Model_Layout */
		$layout = $this->loadLayout()->getLayout();
		/* @var $ajaxBlock PSystem_AjaxQuickCart_Block_Refresh_Response */
		if (($ajaxBlock = $layout->getBlock('ajax.response'))
			&& ($ajaxBlock instanceof PSystem_AjaxQuickCart_Block_Refresh_Response)) {
			echo $ajaxBlock->toHtml();
			exit;
		}
	}
}