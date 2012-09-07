<?php

class Turnkeye_Adminform_Adminhtml_AdminformController extends Mage_Adminhtml_Controller_Action
{


    /**
     * View form action
     */
    public function indexAction()
    {
        $this->_registryObject();
        $this->loadLayout();
        $this->_setActiveMenu('turnkeye/form');
        $this->_addBreadcrumb(Mage::helper('turnkeye_adminform')->__('Form'), Mage::helper('turnkeye_adminform')->__('Form'));
        $this->renderLayout();
    }

    /**
     * Grid Action
     * Display list of products related to current category
     *
     * @return void
     */
    public function gridAction()
    {
        $this->_registryObject();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('turnkeye_adminform/adminhtml_form_edit_tab_product')
                ->toHtml()
        );
    }

    /**
     * Grid Action
     * Display list of products related to current category
     *
     * @return void
     */
    public function saveAction()
    {
        $output  = "<pre>Full Data:\n";
        $output .= print_r($this->getRequest()->getParams(), 1);
        $products = Mage::helper('adminhtml/js')->decodeGridSerializedInput($this->getRequest()->getParam('products'));
        $output .= "\nProducts:\n";
        $output .= print_r($products, 1);
        $output .= "</pre>";
        $this->getResponse()->setBody($output);
    }

    /**
     * registry form object
     */
    protected function _registryObject()
    {
//        Mage::register('turnkeye_adminform', Mage::getModel('turnkeye_adminform/form'));
    }

}