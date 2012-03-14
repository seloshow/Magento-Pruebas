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
	public function listmanagementAction()
	{
		
		/*Action destinado a la gestión de las listas de clientes.*/
		/*cargo el layout*/
		$this->loadLayout();
		$this->_setActiveMenu('smsmainmenu/item1');
		$this->renderLayout();
		Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('smspremiumhelper')->__('Grid rellenado con datos de prueba, posteriormente recogerlos de la BBDD'));
		
	}
	
	public function newAction(){
		$this->loadLayout();
		var_dump("Action new llamado por defecto por Magento");
		$this->_setActiveMenu('smsmainmenu/item1');
		
		$this->renderLayout();
	}
	
	/*Action utilizado para realizar el salvado de los datos del formulario.*/
	public function saveAction()
	{
		/*Comprobamos si viajan datos por post*/
		if ($data = $this->getRequest()->getPost()) {
			/*Tratamiento de los datos recibidos por POST*/
			
			 /* PASO 1: normalización de los datos de formato tiempo, para esta normalizanción utilizaremos un helper */
			$data=Mage::helper('smspremiumhelper')->filterPostData($data);
			//var_dump($data);exit;
// 			$data['smspremium_name']='patata';
// 			$data['smspremium_apellido']= 'patata';
			//echo $nombre.' '.$apellido;
			/*Los datos de la hora de disponibilidad nos vienen en un array, con lo cual hay que pasarlos a una cadena de texto con la hora*/
			$dataToTime=$data['hora_disponibilidad'][0].",".$data['hora_disponibilidad'][1].",".$data['hora_disponibilidad'][2];
			$data['hora_disponibilidad']=$dataToTime;
			
			/*PASO 3: Una vez que tenemos los datos normalizados, introducimos el $data entero en el modelo.*/
			//var_dump($data);exit;
			$model=Mage::getModel('smspremium/smspremium');
			$model->setData($data);
			$model->save();
			Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('smspremiumhelper')->__('Almacenada disponibilidad de usuario'));
			$this->_redirect('*/*/');
		}
		else{
			Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('smspremiumhelper')->__('Alguno de los datos es incorrecto'));
			$this->_redirect('*/*/');
		}
	}
}