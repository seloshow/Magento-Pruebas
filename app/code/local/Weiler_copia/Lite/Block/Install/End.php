<?php

/**
 * Installation ending block
 */
class Weiler_Lite_Block_Install_End extends Mage_Install_Block_End
{

    /**
     * Return url for iframe source
     *
     * @return string
     */
    public function getIframeSourceUrl()
    {
		if(!Mage::helper('core')->isModuleEnabled('Mage_AdminNotification')) {
        	return null;
        }
		
        return parent::getIframeSourceUrl();
    }
}
