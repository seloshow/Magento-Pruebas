<?php

class Turnkeye_Adminform_Block_Adminhtml_Form_Edit_Renderer_Multienabled extends Varien_Data_Form_Element_Multiselect
{

    /**
     * Retrieve Element HTML fragment
     *
     * @return string
     */
    public function getElementHtml()
    {
        $disabled = false;
        if (!$this->getValue()) {
            $this->setData('disabled', 'disabled');
            $disabled = true;
        }
        $html = parent::getElementHtml();
        $htmlId = 'use_config_' . $this->getHtmlId();
        $html .= '<input id="' . $htmlId . '" name="use_config[]" value="' . $this->getId() . '"';
        $html .= ($disabled ? ' checked="checked"' : '') . ($this->getReadonly()? ' disabled="disabled"':'');
        $html .= ' onclick="toggleValueElements(this, this.parentNode);" class="checkbox" type="checkbox" />';
        $html .= ' <label for="' . $htmlId . '" class="normal">' . $this->getCheckboxLabel() . '</label>';
        $html .= '<script type="text/javascript">toggleValueElements($(\'' . $htmlId . '\'), $(\'' . $htmlId . '\').parentNode);</script>';

        return $html;
    }

}