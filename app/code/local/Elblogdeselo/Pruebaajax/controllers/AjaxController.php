<?php
class Elblogdeselo_Pruebaajax_AjaxController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		//echo 'Hello everybody';
		$this->loadLayout();
		$this->renderLayout();
	}
	public function addheaderAction(){
		$this->loadLayout()->renderLayout();
	}
	
	public function addleftAction()
	{
		$this->loadLayout()->renderLayout();
	}
	public function addrightAction()
	{
		$this->loadLayout()->renderLayout();
	}
	
	public function addcontentAction(){
		$this->loadLayout()->renderLayout();
	}
	public function addfooterAction(){
		$this->loadLayout()->renderLayout();
	}
}