<?php

/**
 * Adminhtml sales report grid block
 */
class Weiler_Lite_Block_Adminhtml_Report_Refresh_Statistics_Grid extends Mage_Adminhtml_Block_Report_Refresh_Statistics_Grid
{

    protected function _prepareCollection()
    {
        parent::_prepareCollection();
        if(!Mage::helper('core')->isModuleEnabled('Mage_SalesRule')) {
        	$this->getCollection()->removeItemByKey('coupons');
        }
        return $this;
    }

}
