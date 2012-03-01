<?php

class Inchoo_CoffeeFreak_AdminControllersHere_FreakOutController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		//Get current layout state
		$this->loadLayout();
		
		//Create core block based on inchoo/example_core_block.phtml template (view) file
		//Note the location "adminhtml"... needs to be there since this is admin controller
		$block = $this->getLayout()->createBlock(
			'Mage_Core_Block_Template',
			'my_block_name_here',
			array('template' => 'inchoo/example_core_block.phtml')
		);
		
		
		
		
		$this->getLayout()->getBlock('content')->append($block);
		//Below example does the same thing, and looks cooler :)
		//$this->_addContent($block);
		
		//Release layout stream... lol... sounds fancy
		$this->renderLayout();
	}
}