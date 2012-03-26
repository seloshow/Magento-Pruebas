<?php
class CA_Smspremium_Block_Adminhtml_Smspremium_Listmanagement_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
	{
		parent::__construct();
		$this->_objectId='id';
		$this->_blockGroup = 'smspremium';
		$this->_controller = 'adminhtml_smspremium';
		$this->updateButton('save', 'label', Mage::helper('smspremiumhelper')->__('Guardar SMS'));
		$this->_removeButton('reset');
	}
}