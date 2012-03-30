<?php
# File: app/code/local/Nofrills/Booklayout/controllers/ReferenceController.php
# URL: http://magento.example.com/nofrills_booklayout/reference
class Nofrills_Booklayout_ReferenceController extends Mage_Core_Controller_Front_Action
{
	/*Usado para crear la estructura base de la p�gina*/
	protected function _initLayout()
	{
		$path_page = Mage::getModuleDir('','Nofrills_Booklayout').DS.
		'page-layouts'.DS.'page.xml';
		$xml = file_get_contents($path_page);
		$layout = Mage::getSingleton('core/layout')
			->getUpdate()
			->addUpdate($xml);
	}
	/*Usado para mandar la salida */
	protected function _sendOutput()
	{
		$layout = Mage::getSingleton('core/layout');
		$layout->generateXml()
			->generateBlocks();
		/*Remove instructions are processed in the Mage Core Model Layout::generateXml method.*/
		echo $layout->setDirectOutput(false)->getOutput();
	}
	# URL: http://magento.example.com/nofrills_booklayout/reference
	public function indexAction()
	{
		$this->_initLayout();//carga la estructura general de la p�gina
		/*A�adir las actualizaciones aqu�*/
		/*Esto ahora lo vamos a realizar con una funci�n*/
// 		Mage::getSingleton('core/layout')
// 			->getUpdate()
// 			->addUpdate('<reference name ="content">
// 				<block type ="core/text" name="our_message">
// 				<action method ="setText"><text>Here we go!</text></action>
// 				</block>
// 				</reference>');
		$this->_loadUpdateFile('ceaser.xml');
		$this->_sendOutput();//Manda a la salida 
	}
	/*M�todo que a�adira el file que le pasemos para que actualice le m�dulo*/
	protected function _loadUpdateFile($file)
	{
		$path_update = Mage::getModuleDir('','Nofrills_Booklayout').DS.
		'content-updates'.DS.$file;
		$layout = Mage::getSingleton('core/layout')
			->getUpdate()
			->addUpdate(file_get_contents($path_update));
	}
	/*Cargamos el layout en base a la petici�n realizada*/
	protected function _loadUpdateFileFromRequest()
	{
		$path_update = Mage::getModuleDir('', 'Nofrills_Booklayout') . DS .
		'content-updates' . DS . $this->getFullActionName() . '.xml';
		/*@davidselo: as� es como funciona el handle asociado al controlados que est� saltando
		 * en Magento pondriamos en el layour <nofrill_reference_fox>
		 * Module Name: nofrills booklayout
		 * Controller Name: reference
		 * Action Name: fox
		 * Es esencial para itentificar unicamente cualquier petici�n basandose en estos tres criterios.
		 * */
		$layout = Mage::getSingleton('core/layout')
		->getUpdate()
		->addUpdate(file_get_contents($path_update));
		//var_dump($layout);
		/*PANTALLA:
		 * <block type="nofrills_booklayout/template" name="root" template="simple-page/2col.phtml" output="toHtml">
		 * 		<block type="nofrills_booklayout/template" name="additional_head" template="simple-page/head.phtml" />
		 * 		<block type="nofrills_booklayout/template" name="sidebar">
		 * 			<action method="setTemplate"><template>simple-page/sidebar.phtml</template></action>
		 * 		</block>
		 * 		<block type="core/text_list" name="content" />
		 * 	</block>
		 * <reference name="content">
		 * 		<block type="core/text" name="our_message">
		 * 			<action method="setText"><text>
		 * 				Magento is a foxy system.
		 * 			</text></action>
		 * 		</block>
		 * 	</reference>	
		 * <remove name="sidebar" />"
		 * 
		 * */
	}
	# URL : http :// magento . example . com / nofrills_booklayout / reference / fox
	public function foxAction()
	{
		$this->_initLayout();
		$this->_loadUpdateFileFromRequest();
		$this->_sendOutput();
	}
	/*
	 * @davidselo: Mostrando los archivos que estan en los nodos del tipo 
	 * <frontend>
	 * 		<layout>
	 * 			<updates>
	 * 				<file>archivo.xml</file>
	 * 
	 * */
	public function layoutfilesAction ()
	{
		$updatesRoot = Mage::app ()-> getConfig ()->getNode ('frontend/layout/updates');
		$updateFiles = array ();
		foreach ( $updatesRoot->children () as $updateNode ) {
			if ( $updateNode-> file ) {
				$module = $updateNode -> getAttribute ('module');
				/*@davidselo: El siguiente If comprueba si esta desabilitada la salida, esto se configura en 
				 * sistema->configuracion->avanzado. Entonces si esta desabilitada no cargará la actualización de layout para dicho módulo.*/
				if ( $module && Mage::getStoreConfigFlag ('advanced/modules_disable_output/'.$module )) 
				{
					continue ;
				}
				$updateFiles [] = ( string ) $updateNode -> file ;
			}
		}
		// custom local layout updates file - load always last
		/*Nota: El último fichero que se va a cargar va a ser local.xml, esto lo han hecho así para que puedas tener tus propias customizaciones del tema.*/
		$updateFiles [] = 'local.xml ';
		var_dump ( $updateFiles );
	}
	# URL : http :// magento . example . com / nofrills_booklayout / reference / handle
	public function handleAction ()
	{
		$this->loadLayout ();
		$handles = Mage :: getSingleton ('core/layout')-> getUpdate ()-> getHandles ();
		var_dump ( $handles );
		exit ;
	}
	
}