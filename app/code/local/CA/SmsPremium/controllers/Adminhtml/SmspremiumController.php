<?php
class CA_SmsPremium_Adminhtml_SmspremiumController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		/*cargo el layout*/
		$this->loadLayout();
		/*Marco el menu de sms como seleccionado*/
		$this->_setActiveMenu('smsmainmenu/item1');
		/*Bloque que vamos a poner en el content*/
		$content = $this->getLayout()->createBlock(
			'smspremium/adminhtml_smspremium_content',
			'sms_premium_block'
		);
		
		
		/*renderizo el layout*/
		$this->renderLayout();
	}
}