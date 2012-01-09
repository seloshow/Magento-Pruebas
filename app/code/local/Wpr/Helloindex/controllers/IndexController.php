<?php
class Wpr_Helloindex_IndexController extends Mage_Core_Controller_Front_Action {
	public function indexAction()
	{ 
		$this->loadLayout();
		//echo 'hello index';
		$this->renderLayout();
	}
	public function goodbyeAction()
	{
		echo 'goodbye';
	}
}