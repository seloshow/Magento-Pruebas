<?php
class CA_SmsPremium_Block_Adminhtml_Smspremium_Content extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
	{
		parent::__construct();
		$this->_objectId= 'id';
		$this->_blockGroup = 'smspremium';
		
	}
}