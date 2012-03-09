<?php
/**
 * @author @davidselo
 * @descripction Esta clase es la que va a contener todas las tabs de las izquierda que sean necesarias.
 * */
class CA_Smspremium_Block_Adminhtml_Smspremium_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

	public function __construct()
	{
		parent::__construct();
		$this->setId('smspremium_tabs');
      	$this->setDestElementId('segmentation_form');
     	$this->setTitle(Mage::helper('smspremiumhelper')->__('Deal Information'));
	}

	protected function _beforeToHtml()
	{
		$this->addTab('segmentation_section', array(
				'label'     => Mage::helper('smspremiumhelper')->__('Formulario de prueba'),
				'title'     => Mage::helper('smspremiumhelper')->__('Configuración de prueba'),
				'content'   => $this->getLayout()->createBlock('smspremium/adminhtml_smspremium_edit_tab_segmentacion')->toHtml(),
		));
		 	 
		return parent::_beforeToHtml();
	}
}