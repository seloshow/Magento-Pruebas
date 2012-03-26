<?php
class CA_Smspremium_Block_Adminhtml_Smspremium_Listmanagement_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

	public function __construct()
	{
		parent::__construct();
		$this->setId('smspremium_tabs');
      	$this->setDestElementId('edit_form');
     	$this->setTitle(Mage::helper('smspremiumhelper')->__('Información SMS'));
	}

	protected function _beforeToHtml()
	{
		/*Primer tab que es un ejemplo para la recogida de datos de un formulario*/
		$this->addTab('segmentation_section', array(
				'label'     => Mage::helper('smspremiumhelper')->__('Formulario de prueba'),
				'title'     => Mage::helper('smspremiumhelper')->__('Configuración de prueba'),
				'content'   => $this->getLayout()->createBlock('smspremium/adminhtml_smspremium_edit_tab_segmentacion')->toHtml(),
		));
		
	
		return parent::_beforeToHtml();
	}
}