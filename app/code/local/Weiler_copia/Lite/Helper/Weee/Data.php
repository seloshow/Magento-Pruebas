<?php

/**
 * WEEE data helper
 */

if(Mage::helper('core')->isModuleEnabled('Mage_Weee')) {
	
	class Weiler_Lite_Helper_Weee_Data extends Mage_Weee_Helper_Data
	{
	}
	
} else {

	class Weiler_Lite_Helper_Weee_Data extends Mage_Core_Helper_Abstract
	{
	
		public function getPriceDisplayType($store = null)
	    {
	        return 0;
	    }		
		
		public function typeOfDisplay($product, $compareTo = null, $zone = null, $store = null)
    	{
    		return false;
    	}	

	    public function getApplied($item)
	    {
	    	return array();
	    }   

	    public function getAmountForDisplay($product)
	    {
	        return 0;
	    }
	        
	}

}
