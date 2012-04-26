<?php
/**
 * @category   PSystem
 * @package    PSystem_AjaxQuickCart
 * @author     Pascal System <info@pascalsystem.pl>
 * @version    1.0.2
 */

/**
 * Pascal Quick Cart Ajax refresh data JavaScripts
 * 
 * @category   PSystem
 * @package    PSystem_AjaxQuickCart
 * @author     Pascal System <info@pascalsystem.pl>
 * @version    1.0.2
 */
class PSystem_AjaxQuickCart_Block_Refresh extends Mage_Core_Block_Abstract {
/**
 * Get html code
 * 
 * @return string
 */
	public function _toHtml() {
		$html = '<script type="text/javascript">'."\n";
		$html.= 'PS.AjaxQuickCart.refresh(\''.$this->getUrl('ajaxquickcart/viewcart/refresh').'\');';
		$html.= '</script>'."\n";
		
		return $html;
	}
}
