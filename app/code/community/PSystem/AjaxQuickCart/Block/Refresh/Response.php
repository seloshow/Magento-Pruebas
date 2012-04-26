<?php
/**
 * @category   PSystem
 * @package    PSystem_AjaxQuickCart
 * @author     Pascal System <info@pascalsystem.pl>
 * @version    1.0.2
 */

/**
 * Pascal Quick Cart Ajax refresh response data
 * 
 * @category   PSystem
 * @package    PSystem_AjaxQuickCart
 * @author     Pascal System <info@pascalsystem.pl>
 * @version    1.0.2
 */
class PSystem_AjaxQuickCart_Block_Refresh_Response extends Mage_Core_Block_Abstract {
/**
 * List block with selector
 *
 * @var array
 */
	protected $_responseBlock = array();
	
/**
 * Add response block
 *
 * @param string $selector
 * @param string $blockName
 * @return PSystem_AjaxQuickCart_Block_Refresh_Response
 */
	public function addResponseBlock($selector, $blockName) {
		$this->_responseBlock[$selector] = $blockName;
		return $this;
	}
	
/**
 * Remove response block by selector
 *
 * @param string $selector
 * @return PSystem_AjaxQuickCart_Block_Refresh_Response
 */
	public function removeBlockBySelector($selector) {
		unset($this->_responseBlock[$selector]);
		return $this;
	}
	
	
/**
 * Remove response block by block name
 *
 * @param string $blockName
 * @return PSystem_AjaxQuickCart_Block_Refresh_Response
 */
	public function removeBlockByBlockName($blockName) {
		if (in_array($blockName, $this->_responseBlock)) {
			$res = array_search($blockName, $this->_responseBlock);
			if (is_array($res)) {
				foreach ($res as $_singleRes) {
					unset($this->_responseBlock[$_singleRes]);
				}
			} else {
				unset($this->_responseBlock[$res]);
			}
		}
		return $this;
	}
	
/**
 * Prepare html
 * 
 * @return string
 */
	public function _toHtml() {
		$dataArr = array();
		if (is_array($this->_responseBlock)) {
			$layout = $this->getLayout();
			foreach ($this->_responseBlock as $_blockSelector => $_blockName) {
				if ($_renderBlock = $layout->getBlock($_blockName)) {
					if (isset($dataArr[$_blockName]))
						continue;
					$dataArr[$_blockName] = array(
						'selector'	=> $_blockSelector,
						'html'		=> $_renderBlock->toHtml()
					);
				}
			}
		}
		return Mage::helper('core')->jsonEncode($dataArr);
	}
}