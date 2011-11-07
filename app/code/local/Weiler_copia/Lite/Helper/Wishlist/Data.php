<?php

if(Mage::helper('core')->isModuleEnabled('Mage_Wishlist')) {
	
	class Weiler_Lite_Helper_Wishlist_Data extends Mage_Wishlist_Helper_Data
	{
	}
	
} else {

	class Weiler_Lite_Helper_Wishlist_Data extends Mage_Core_Helper_Abstract
	{
		
		public function isAllow()
		{
			return false;
		}
		
		public function isAllowInCart()
		{
			return false;
		}
		
	    public function getAddUrl($item)
	    {
	        return '';
	    }
	
	}

}
