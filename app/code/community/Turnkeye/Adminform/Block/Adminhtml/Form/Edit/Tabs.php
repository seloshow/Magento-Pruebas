<?php

class Turnkeye_Adminform_Block_Adminhtml_Form_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('edit_home_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('turnkeye_adminform')->__('Form Tabs'));
    }

    /**
     * add tabs before output
     *
     * @return Turnkeye_Adminform_Block_Adminhtml_Form_Edit_Tabs
     */
    protected function _beforeToHtml()
    {
        $this->addTab('general', array(
            'label'     => Mage::helper('turnkeye_adminform')->__('General'),
            'title'     => Mage::helper('turnkeye_adminform')->__('General'),
            'content'   => $this->getLayout()->createBlock('turnkeye_adminform/adminhtml_form_edit_tab_general')->toHtml(),
        ));

        $product_content = $this->getLayout()->createBlock('turnkeye_adminform/adminhtml_form_edit_tab_product', 'adminform_products.grid')->toHtml();
        $serialize_block = $this->getLayout()->createBlock('adminhtml/widget_grid_serializer');
        $serialize_block->initSerializerBlock('adminform_products.grid', 'getSelectedProducts', 'products', 'selected_products');
        $serialize_block->addColumnInputName('position');
        $product_content .= $serialize_block->toHtml();
        $this->addTab('associated_products', array(
            'label'     => Mage::helper('turnkeye_adminform')->__('Products'),
            'title'     => Mage::helper('turnkeye_adminform')->__('Products'),
            'content'   => $product_content
        ));

        return parent::_beforeToHtml();
    }

}