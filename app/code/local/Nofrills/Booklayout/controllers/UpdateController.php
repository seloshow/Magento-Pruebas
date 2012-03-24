<?php
class Nofrills_Booklayout_UpdateController extends Mage_Core_Controller_Front_Action
{
	public function indexAction(){
		$layout = Mage::getSingleton('core/layout');
		$xml = simplexml_load_string('<layout>
									  	<block type ="nofrills_booklayout/helloworld"
										name =" root " output ="toHtml" />
									</layout>','Mage_Core_Model_Layout_Element');
		$layout->setXml($xml);
		$layout->generateBlocks();
		echo $layout->setDirectOutput(true)->getOutput();
	}
	
public function complexAction()
		{	/*Capitulo anterior al 2.4*/
			/*	
			$layout = Mage::getSingleton('core/layout');
			$path	= Mage::getModuleDir('', 'Nofrills_Booklayout') . DS . 'page-layouts' . DS . 'complex.xml';
			$xml = simplexml_load_file($path,Mage::getConfig()->getModelClassName('core/layout_element'));
			$layout->setXml($xml);
			$layout->generateBlocks();
			echo $layout->setDirectOutput(true)->getOutput();	*/
			
			/*seccion 2.6 */
			$layout = Mage::getSingleton('core/layout');
			$path = Mage::getModuleDir('','Nofrills_Booklayout').DS.'page-layouts'.DS.'complex.xml';
			$xml = simplexml_load_file($path ,Mage::getConfig()->getModelClassName('core/layout_element'));
			$layout->setXml($xml);
			$text=$layout->createBlock('core/text','foxxy')
					->setText("The quick brown fox jumped over the lazy dog.");
			/*Es importante que se realice la inserción del bloque despues siempre de llamar al método
			 * generateBlocks(), ya que si no dará un error y dirá que estamos llamando a un objeto vacio.*/
			$layout->generateBlocks();
			$layout->getBlock('content')->insert($text);
			echo $layout->setDirectOutput(true)->getOutput();
		}	
# http://magento.example.com/nofrills_booklayout/update/helloUpdates
/*@davidselo: capitulo 2.8*/
public function helloUpdatesAction()
{
	$layout = Mage::getSingleton('core/layout');
	$update_manager = $layout->getUpdate();
	$update_manager->addUpdate('<block
			type ="nofrills_booklayout/helloworld"
			name ="root"
			output ="toHtml"/>');
	//var_dump($update_manager);
	$layout->generateXml();
	$layout->generateBlocks();
	echo $layout->setDirectOutput(true)->getOutput();
}
}