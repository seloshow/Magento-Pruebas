<?php
/**
 * @author	@davidselo
 * @description Creación de la extensión de sms premium de compra amiga
 * @company @CompraAmiga  
 * 
 * */
class CA_Smspremium_Block_Adminhtml_Smspremium_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	/*@davidselo:Este elemento va a buscar el formulario justo en la carpeta Edit/Form
	 * 
	 * protected function _prepareLayout()
	 * {
	 *   if ($this->_blockGroup && $this->_controller && $this->_mode) {
	 *       $this->setChild('form', $this->getLayout()->createBlock($this->_blockGroup . '/' . $this->_controller . '_' . $this->_mode . '_form'));
	 *   }
	 *   return parent::_prepareLayout();
	 *  }
	 *  */
	
	public function __construct()
	{
		parent::__construct();
		$this->_objectId = 'id';
		/*
		 * $this->_blockGroup = ‘<module>’; 
		 * in 
		 * <Namespace>_<Module>_Block_Adminhtml_<Module>_Edit
		 * 		This should match with your config.xml :
		 * 		<blocks> 
		 * 			<module> 
		 * 				<class><Namespace>_<Module>_Block</class> 
		 *			 </module> 
		 * 		</blocks>
		 * 
*/
		//$this->_blockGroup = 'smspremium';/*Esto es el nombre del módulo.*/
		//$this->_controller = 'adminhtml_smspremium';
		$this->_blockGroup = 'smspremium';
		$this->_controller = 'adminhtml_smspremium';
		$this->updateButton('save', 'label', Mage::helper('smspremiumhelper')->__('Guardar SMS'));
		$this->_removeButton('reset');
		
		
		
		
	}
	public function getHeaderText()
	{
		return Mage::helper('smspremiumhelper')->__("Sms Premium");
	}
	
}