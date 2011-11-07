<?php
/**
 * Default rss helper
 */
if(Mage::helper('core')->isModuleEnabled('Mage_Rss')) {
	
	class Weiler_Lite_Helper_Rss_Order extends Mage_Rss_Helper_Order
	{
	}
	
} else {
	
	class Weiler_Lite_Helper_Rss_Order extends Mage_Core_Helper_Abstract
	{
	    public function isStatusNotificationAllow()
	    {
	        return false;
	    }
	
	}
	
}
