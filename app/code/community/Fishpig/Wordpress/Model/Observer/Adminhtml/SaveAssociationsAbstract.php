<?php
/**
 * @category    Fishpig
 * @package     Fishpig_Wordpress
 * @license     http://fishpig.co.uk/license.txt
 * @author      Ben Tideswell <help@fishpig.co.uk>
 */

abstract class Fishpig_Wordpress_Model_Observer_Adminhtml_SaveAssociationsAbstract
{
	protected $_storeIds = null;
	
	/**
	 * Retrieve the current store ID
	 * If no store ID is set or site is multistore, return default store ID
	 *
	 * @return int
	 */
	protected function _getStoreIds()
	{
		if (is_null($this->_storeIds)) {
			if (Mage::app()->isSingleStoreMode() && Mage::helper('wordpress')->forceSingleStore()) {
				$this->_storeIds = $this->_getAllStoreIds();
			}
			else if ($storeId = (int)Mage::app()->getRequest()->getParam('store')) {
					$this->_storeIds = array($storeId);
			}
			else {
				$this->_storeIds = $this->_getAllStoreIds();
			}
		}
		
		return $this->_storeIds;
	}
	
	protected function _getAllStoreIds()
	{
		$select = $this->_getResource()
			->getConnection('core_read')
			->select()
			->from($this->_getResource()->getTableName('core/store'), 'store_id')
			->where('store_id>?', 0);
			
		return $this->_getResource()->getConnection('core_read')->fetchCol($select);
	}
	
	public function getSingleStoreId()
	{
		$storeIds = $this->_getStoreIds();
		
		if (is_array($storeIds)) {
			return array_shift($storeIds);
		}
		
		return $storeIds;
	}
	
	/**
	 * Retrieve the resource class
	 *
	 */
	protected function _getResource()
	{
		return Mage::getSingleton('core/resource');
	}
}
