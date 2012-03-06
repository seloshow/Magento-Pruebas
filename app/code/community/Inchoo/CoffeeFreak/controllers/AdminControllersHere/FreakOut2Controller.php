<?php

class Inchoo_CoffeeFreak_AdminControllersHere_FreakOut2Controller extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		$this->loadLayout();
		
		$block = $this->getLayout()->createBlock(
			'Mage_Core_Block_Template',
			'my_block_name_here',
			array('template' => 'inchoo/example_core_block.phtml')
		);
		
		
		//$this->_addContent($block);
		
		
		
		$this->_addLeft($this->getLayout()->createBlock('Inchoo_CoffeeFreak_Block_ShowTabsAdminBlock'));
		
		$this->renderLayout();
		
	}
}