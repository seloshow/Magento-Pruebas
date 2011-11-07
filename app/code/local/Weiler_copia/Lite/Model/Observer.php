<?php
class Weiler_Lite_Model_Observer
{
    
    /**
     * Remove Related, Upsell, Crosssell and Recurring tabs on product edit
     * core_block_abstract_prepare_layout_after event
     */		
	public function removeCatalogProductEditTabs($observer)
	{
		$block = $observer->getEvent()->getBlock();
		
		if(!($block instanceof Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs)) {
			return;
		}
		
		foreach(array('related','upsell','crosssell') as $tab) {
			if(Mage::getStoreConfigFlag("lite/$tab/hide")) {
				$block->removeTab($tab);
			}
		}
		
		return;
	}    
    
    /**
     * Manipulate layout loading
     * core_layout_update_updates_get_after event
     */		
	public function removeLayouts($observer)
	{
		$updatesRoot = $observer->getEvent()->getUpdates();
		
		if(Mage::getStoreConfigFlag('lite/billing_agreement/hide')) {
			unset($updatesRoot->sales_billing_agreement);
		}
		
		if(Mage::getStoreConfigFlag('lite/recurring_profile/hide')) {
			unset($updatesRoot->sales_recurring_profile);
		}

	    /**
	     * Lame and dirty hack to prevent layout loading if module output
	     * is disabled under "Disable Modules Output"
	     */		
        foreach ($updatesRoot->children() as $name => $updateNode) {
            if ($updateNode->file) {
            	
            	if($updateNode->getAttribute('module')) {
					continue;
				}
			
				$class = Mage::app()->getConfig()->getBlockClassName("$name/Xyz");
				$module = substr($class, 0, strpos($class, '_Block_Xyz'));			

				$updateNode->addAttribute('module', $module);
            }
        }
        
        return;
	}
	
    /**
     * Removes Widget button from Wysiwyg if Mage_Widget disabled
     * cms_wysiwyg_config_prepare event
     */	
	public function removeWidgetsFromWysiwyg($observer)
	{
		$config = $observer->getEvent()->getConfig();
		
		if(!Mage::helper('core')->isModuleEnabled('Mage_Widget')) {
			$config->setData('add_widgets', false);
		}
		
		return;
	}
	
    /**
     * Clean all quotes in defined period (cron process)
     * Not activated currently
     */
    public function cleanExpiredQuotes($schedule)
    {
        Mage::dispatchEvent('clear_expired_quotes_before', array('sales_observer' => $this));

        $lifetimes = Mage::getConfig()->getStoresConfigByPath('checkout/cart/delete_quote_after');
        foreach ($lifetimes as $storeId=>$lifetime) {
            $lifetime *= 86400;

            /** @var $quotes Mage_Sales_Model_Mysql4_Quote_Collection */
            $quotes = Mage::getModel('sales/quote')->getCollection();

            $quotes->addFieldToFilter('store_id', $storeId);
            $quotes->addFieldToFilter('updated_at', array('to'=>date("Y-m-d", time()-$lifetime)));
            //$quotes->addFieldToFilter('is_active', 0);

            foreach ($this->getExpireQuotesAdditionalFilterFields() as $field => $condition) {
                $quotes->addFieldToFilter($field, $condition);
            }

            $quotes->walk('delete');
        }
        return $this;
    }	
	
}