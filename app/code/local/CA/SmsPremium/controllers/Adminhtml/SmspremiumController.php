<?php
class CA_Smspremium_Adminhtml_SmspremiumController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
	{
		/*cargo el layout*/
		$this->loadLayout();
		/*Marco el menu de sms como seleccionado*/
		$this->_setActiveMenu('smsmainmenu/item1');
		/*Bloque que vamos a poner en el content*/
		$content = $this->getLayout()->createBlock(
			'smspremium/adminhtml_smspremium_edit',
			'sms_premium_block_content'
		);
		/*Bloque que vamos a poner en la izquierda*/
		$left=$this->getLayout()->createBlock(
			'smspremium/adminhtml_smspremium_edit_tabs',
			'sms_premium_block_left'
		);
		
		$this->_addContent($content)
				->_addLeft($left);
		
		/*renderizo el layout*/
		$this->renderLayout();
	}
	public function saveAction()
	{
		echo "save action";
	}
}