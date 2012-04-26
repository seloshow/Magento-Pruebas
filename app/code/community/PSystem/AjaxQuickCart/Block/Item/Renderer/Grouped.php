<?php
/**
 * @category   PSystem
 * @package    PSystem_AjaxQuickCart
 * @author     Pascal System <info@pascalsystem.pl>
 * @version    1.0.2
 */

/**
 * Pascal Quick Cart Ajax item layer renderer for group products
 * 
 * @category   PSystem
 * @package    PSystem_AjaxQuickCart
 * @author     Pascal System <info@pascalsystem.pl>
 * @version    1.0.2
 */
class PSystem_AjaxQuickCart_Block_Item_Renderer_Grouped extends Mage_Checkout_Block_Cart_Item_Renderer_Grouped {
/**
 * Get item delete url
 *
 * @return string
 */
	public function getDeleteUrl() {
		return $this->getUrl(
			'checkout/cart/delete',
			array(
				'id'=>$this->getItem()->getId(),
				Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED => $this->helper('core/url')->getEncodedUrl(Mage::getUrl('checkout/cart/index'))
			)
		);
	}
}