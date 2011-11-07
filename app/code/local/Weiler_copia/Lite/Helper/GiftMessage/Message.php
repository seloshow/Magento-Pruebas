<?php

if(Mage::helper('core')->isModuleEnabled('Mage_GiftMessage')) {
	
	class Weiler_Lite_Helper_GiftMessage_Message extends Mage_GiftMessage_Helper_Message
	{
	}
	
} else {
	
	class Weiler_Lite_Helper_GiftMessage_Message extends Mage_Core_Helper_Abstract
	{
		
	    public function getIsMessagesAvailable()
	    {
	        return false;
	    }
	    
	    public function isMessagesAvailable()
	    {
	    	return false;
	    }
	    
	    public function getInline()
	    {
	        return '';
	    }    
	
	}	
	
}
