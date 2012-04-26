<?php
/**
 * @category   PSystem
 * @package    PSystem_AjaxQuickCart
 * @author     Pascal System <info@pascalsystem.pl>
 * @version    1.0.2
 */

/**
 * Pascal Quick Cart Ajax item layer renderer
 * 
 * @category   PSystem
 * @package    PSystem_AjaxQuickCart
 * @author     Pascal System <info@pascalsystem.pl>
 * @version    1.0.2
 */
class PSystem_AjaxQuickCart_Block_Item_Renderer extends Mage_Checkout_Block_Cart_Item_Renderer {
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