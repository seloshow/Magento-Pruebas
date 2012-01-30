<?php
class Wpr_Helloindex_IndexController extends Mage_Core_Controller_Front_Action {
	public function indexAction()
	{ 
		$this->loadLayout();
		//echo 'hello index';
		$this->renderLayout();
		//Mage::log(Mage::getConfig(),0,'system.log');
		//var_export(Mage::getConfig());exit;
	}
	public function goodbyeAction()
	{
		echo 'goodbye';
	}
}