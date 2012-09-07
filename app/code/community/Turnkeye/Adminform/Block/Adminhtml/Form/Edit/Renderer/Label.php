<?php

class Turnkeye_Adminform_Block_Adminhtml_Form_Edit_Renderer_Label
extends Mage_Adminhtml_Block_Widget
implements Varien_Data_Form_Element_Renderer_Interface
{

    /**
     * renderer
     *
     * @param Varien_Data_Form_Element_Abstract $element
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $element->setDisabled(true);
        $disabled = true;
        $htmlId = 'use_config_' . $element->getHtmlId();
        $html = '<tr><td class="label">' . $element->getLabelHtml() . '</td><td class="value">';
        $html .= '<input id="' . $htmlId . '" name="use_c[]" value="' . $element->getId() . '"'. ($disabled ? ' checked="checked"' : '');
        $html .= ' onclick="toggleValueElements(this, this.parentNode);" class="checkbox" type="checkbox" />';
        $html .= ' <label for="' . $htmlId . '" class="normal">' . Mage::helper('turnkeye_adminform')->__('Do not change value') . '</label>';
        $html .= $element->getElementHtml();
        $html .= '<script type="text/javascript">toggleValueElements($(\'' . $htmlId . '\'), $(\'' . $htmlId . '\').parentNode);</script>';

        return $html . '</td><td class="scope - label"><span class="nobr"></span></td></tr>';
    }
}
