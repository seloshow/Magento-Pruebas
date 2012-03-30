<?php
/**
 * @category    Fishpig
 * @package     Fishpig_Wordpress
 * @license     http://fishpig.co.uk/license.txt
 * @author      Ben Tideswell <help@fishpig.co.uk>
 */

class Fishpig_Wordpress_Adminhtml_Catalog_ProductController extends Mage_Adminhtml_Controller_Action
{
	/**
	 * Display the associated posts grid
	 *
	 */
	public function postAction()
	{
		if (!$this->_isSingleStoreMode() && !$this->getStoreId()) {
			$this->_forward('storeSelector');
		}
		else {
			if ($this->_initWordPressDatabaseForStore()) {
				$this->_initProduct();
				$this->loadLayout();
				$this->renderLayout();
			}
			else {
				$this->_forward('noWordPressDatabase');
			}
		}
	}
	
	/**
	 * Display the associated posts grid
	 *
	 */
	public function postGridAction()
	{
		if (!$this->_isSingleStoreMode() && !$this->getStoreId()) {
			$this->_forward('storeSelector');
		}
		else {
			if ($this->_initWordPressDatabaseForStore()) {
				$this->_initProduct();
				$this->loadLayout();
				$this->renderLayout();
			}
			else {
				$this->_forward('noWordPressDatabase');
			}
		}
	}
	
	
	/**
	 * Display the associated posts grid
	 *
	 */
	public function categoryAction()
	{
		if (!$this->_isSingleStoreMode() && !$this->getStoreId()) {
			$this->_forward('storeSelector');
		}
		else {
			if ($this->_initWordPressDatabaseForStore()) {
				$this->_initProduct();
				$this->loadLayout();
				$this->renderLayout();
			}
			else {
				$this->_forward('noWordPressDatabase');
			}
		}
	}
	
	/**
	 * Display the associated posts grid
	 *
	 */
	public function categoryGridAction()
	{
		if (!$this->_isSingleStoreMode() && !$this->getStoreId()) {
			$this->_forward('storeSelector');
		}
		else {
			if ($this->_initWordPressDatabaseForStore()) {
				$this->_initProduct();
				$this->loadLayout();
				$this->renderLayout();
			}
			else {
				$this->_forward('noWordPressDatabase');
			}
		}
	}

	/**
	 * Display the associated posts grid
	 *
	 */
	public function pageAction()
	{
		if (!$this->_isSingleStoreMode() && !$this->getStoreId()) {
			$this->_forward('storeSelector');
		}
		else {
			if ($this->_initWordPressDatabaseForStore()) {
				$this->_initProduct();
				$this->loadLayout();
				$this->renderLayout();
			}
			else {
				$this->_forward('noWordPressDatabase');
			}
		}
	}
	
	/**
	 * Display the associated posts grid
	 *
	 */
	public function pageGridAction()
	{
		if (!$this->_isSingleStoreMode() && !$this->getStoreId()) {
			$this->_forward('storeSelector');
		}
		else {
			if ($this->_initWordPressDatabaseForStore()) {
				$this->_initProduct();
				$this->loadLayout();
				$this->renderLayout();
			}
			else {
				$this->_forward('noWordPressDatabase');
			}
		}
	}
	
	public function noWordPressDatabaseAction()
	{
		$this->getResponse()->setBody('<p style="font-size: 18px; margin-top: 40px; text-align: center;">There was an error connecting to the WordPress database for this store.</p>');
	}
	
	protected function _initWordPressDatabaseForStore()
	{
		return Mage::helper('wordpress/db')->connect();
	}
	
	public function storeSelectorAction()
	{
		$this->getResponse()->setBody('<p style="font-size: 18px; margin-top: 40px; text-align: center;">You must select a store using the store changer (top left) before associating blog items with this product.</p>');
	}
	
	/**
	 * Determine whether only 1 store exists
	 *
	 * @return bool
	 */
	protected function _isSingleStoreMode()
	{
		return Mage::app()->isSingleStoreMode() || Mage::helper('wordpress')->forceSingleStore();
	}
	
	public function getStoreId()
	{
		if (!$this->_isSingleStoreMode()) {
			return Mage::app()->getRequest()->getParam('store');
		}
		
		return Mage::helper('wordpress')->getDefaultStore()->getId();
	}
	
	/**
	 * Initialise the product model
	 * This should only be called via AJAX actions
	 *
	 * @return false|Mage_Catalog_Model_Product
	 */
	protected function _initProduct()
	{
		if (!Mage::registry('product')) {
			if ($productId = $this->getRequest()->getParam('id')) {
				$product = Mage::getModel('catalog/product')->load($productId);
				
				if ($product->getId()) {
					Mage::register('product', $product);
					return $product;
				}
			}
		}
		
		return false;
	}
}
