<?php

/**
 * Adminhtml sales create order product search grid price column renderer
 */
class Weiler_Lite_Block_Adminhtml_Sales_Order_Create_Search_Grid_Renderer_Price extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Price
{
    /**
     * Render minimal price for downloadable products
     *
     * @param   Varien_Object $row
     * @return  string
     */
    public function render(Varien_Object $row)
    {
    	//lite:
    	if(Mage::helper('core')->isModuleEnabled('Mage_Downloadable')) {
	        if ($row->getTypeId() == Mage_Downloadable_Model_Product_Type::TYPE_DOWNLOADABLE) {
	            $row->setPrice($row->getPrice());
	        }
    	}
        //
        return parent::render($row);
    }

}
