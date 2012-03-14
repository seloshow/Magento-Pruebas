<?php
/**
 * @author	@davidselo
 * @description: Utilizaremos el widjet de Magento de grid container.*/
class CA_Smspremium_Block_Adminhtml_Smspremium extends Mage_Adminhtml_Block_Widget_Grid_Container
{

	public function __construct()
	{
		$this->_controller = 'adminhtml_smspremium';
		$this->_blockGroup = 'smspremium';
		$this->_headerText = Mage::helper('smspremiumhelper')->__('Gestión de listas de envío');
		$this->_addButtonLabel = Mage::helper('smspremiumhelper')->__('Añadir Nueva');
		
		parent::__construct();
	}
	/*Este fichero tiene que ir acompañado de otro llamado Grid.php ya que Magento va a intentar crear un 
	 * bloque en la clase padre  _blockGroup.'/' . $this->_controller . '_grid' 
	 *     [blockGroup]_[controller]_[grid]
	 *     [blockGroup] =>smspremium
	 *     [controller] =>adminhtml_smspremium
	 *     [grid] =>grid
	 *  smspremium_adminhtml_smspremium_grid
	 * 
	 * protected function _prepareLayout()
	 *  {
	 *    $this->setChild( 'grid',
	 *    $this->getLayout()->createBlock( $this->_blockGroup.'/' . $this->_controller . '_grid',$this->_controller . '.grid')->setSaveParametersInSession(true) );
	 *    return parent::_prepareLayout();
	 *  }
	 *  */
}