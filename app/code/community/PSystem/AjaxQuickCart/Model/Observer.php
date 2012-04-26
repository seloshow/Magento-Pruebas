<?php
/**
 * @category   PSystem
 * @package    PSystem_AjaxQuickCart
 * @author     Pascal System <info@pascalsystem.pl>
 * @version    1.0.2
 */

/**
 * Pascal Quick Cart Ajax Observer
 * 
 * @category   PSystem
 * @package    PSystem_AjaxQuickCart
 * @author     Pascal System <info@pascalsystem.pl>
 * @version    1.0.2
 */
class PSystem_AjaxQuickCart_Model_Observer extends Mage_Core_Block_Abstract {
/**
 * After try add product to cart
 * 
 * @param Varien_Event_Observer $event
 * @return void
 */
	public function postDispatchAddToCart(Varien_Event_Observer $event) {
		/* @var $action Mage_Checkout_CartController */
		$action = $event->getControllerAction();
		
		if (!$ajaxRequest = $action->getRequest()->getHeader('X-Requested-With')) {
			return;
		}
		
		/* @var $baseObserver PSystem_Base_Model_Observer */
		$baseObserver = Mage::getModel('psbase/observer');
		
		/* @var $checkout Mage_Checkout_Model_Session */
		$checkout = Mage::getSingleton('checkout/session');
		/* @var $msg Mage_Core_Model_Message_Collection */
		$msg = $checkout->getMessages(true);
		$isError = (count($msg->getItems('success'))==0)?true:false;
		
		if ($isError) {
			$productId = intval($action->getRequest()->getParam('product'));
			/* @var $product Mage_Catalog_Model_Product */
			$product = Mage::getModel('catalog/product')->load($productId);
			if ($productId && ($product->getId() == $productId)) {
				Mage::register('product', $product);
				Mage::register('current_product', $product);
			} else {
				$product = false;
			}
			
			/* @var $layout Mage_Core_Model_Layout */
			$layout = $action->getLayout();
			
			if ($product) {
				$productType = $product->getTypeId();
				$updater = $layout->getUpdate();
				$updater->addHandle('catalog_product_view');
				$updater->addHandle('PRODUCT_TYPE_'.$productType);
				$updater->addHandle('ajaxquickcart_product_view');
				$updater->addHandle('PRODUCT_TYPE_ajaxquickcart_'.$productType);
			}
			$action->loadLayout();
			
			if ($product && ($block = $layout->getBlock('product.info')) && ($content = $layout->getBlock('content'))) {
				$content->unsetChildren();
				$content->append($block);
			}
		} else {
			$layout = $action->loadLayout()->getLayout();
		}
		
		$baseObserver->postdispatch($event);
		exit;
	}
	
/**
 * Check is load only options on catalog_product_view page
 *
 * @param Varien_Event_Observer $event
 * @return void
 */
	public function preDispatchCatalogProductView(Varien_Event_Observer $event) {
		/* @var $action Mage_Core_Controller_Varien_Action */
		$action = $event->getAction();
		if ($action->getFullActionName() != 'catalog_product_view') {
			return;
		}
		
		/* @var $request Mage_Core_Controller_Request_Http */
		$request = $action->getRequest();
		if ((!$ajaxRequest = $action->getRequest()->getHeader('X-Requested-With'))
			|| (!$request->getParams('ajaxquickcartoption'))) {
			return;
		}
		
		if (!$productId = intval($request->getParam('id')))
			return;
		/* @var $product Mage_Catalog_Model_Product */
		$product = Mage::getModel('catalog/product')->load($productId);
		if ($product->getId() != $productId)
			return;
		
		$productType = $product->getTypeId();
		
		/* @var $update Mage_Core_Model_Layout_Update */
		$update = $action->getLayout()->getUpdate();
		/*$update->addUpdate('<reference name="product.info">
			<action method="setTemplate"><template>ajaxquickcart/quickcart/product.phtml</template></action>
		</reference>');*/
		$update->addHandle('ajaxquickcart_product_view');
		$update->addHandle('PRODUCT_TYPE_ajaxquickcart_'.$productType);
		//todo: add addtocart ajax on layer
	}
	
/**
 * After item deleted from cart
 * 
 * @param Varien_Event_Observer $event
 * @return void
 */
	public function postDispatchDeleteCartItem(Varien_Event_Observer $event) {
		/* @var $action Mage_Checkout_CartController */
		$action = $event->getControllerAction();
		$headers = $action->getResponse()->getHeaders();
		if (!is_array($headers)) $headers = array();
		$moduleUrl = Mage::getUrl('ajaxquickcart');
		foreach ($headers as $header) {
			if ((strtolower($header['name']) == 'location') && (strpos($header['value'], $moduleUrl)===0)) {
				$action->getResponse()->setRedirect(Mage::getUrl('checkout/cart'));
			}
		}
	}
}
