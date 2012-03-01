<?php

class Inchoo_CoffeeFreak_Block_EditSpecial_SampleBlockForTabAreaShowoff extends Mage_Adminhtml_Block_Template
{
	
	/*
	 * Where does "_toHtml()" come from?
	 * If you trace back the Mage_Adminhtml_Block_Template and all the parents you will see that 
	 * "_toHtml()" comes from 
	 * 
	 * Not that we do not need to use any view (template file). 
	 * We can assemble output directly in code => OK to use if no user control is needed on front.
	 */
	protected function _toHtml() 
	{
		return 'Inchoo_CoffeeFreak_Block_SampleBlockForTabAreaShowoff custom block based (extended) on Mage_Adminhtml_Block_Template class';
	}
}