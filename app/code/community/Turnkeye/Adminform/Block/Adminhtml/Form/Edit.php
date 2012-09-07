<?php

class Turnkeye_Adminform_Block_Adminhtml_Form_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'turnkeye_adminform';
        $this->_controller = 'adminhtml_form';
        $this->_headerText = Mage::helper('turnkeye_adminform')->__('Edit Form');
    }

}