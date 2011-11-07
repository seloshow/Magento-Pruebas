<?php

class Weiler_Lite_Block_Adminhtml_System_Config_Form_Fieldset_Modules_DisableOutput
    extends Mage_Adminhtml_Block_System_Config_Form_Fieldset_Modules_DisableOutput
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $html = $this->_getHeaderHtml($element);

        $modules = array_keys((array)Mage::getConfig()->getNode('modules')->children());

        sort($modules);
        
        //var_dump(Mage::getConfig()->getNode('modules')); die();

        foreach ($modules as $moduleName) {
            if ($moduleName==='Mage_Adminhtml') {
                continue;
            }
            
            //lite:
            if('true'!==(string)Mage::getConfig()->getNode("modules/$moduleName")->active || $moduleName==='Weiler_Lite') {
            	continue;
            }
            //
            
            $html.= $this->_getFieldHtml($element, $moduleName);
        }
        $html .= $this->_getFooterHtml($element);

        return $html;
    }
}
