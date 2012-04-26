<?php
class Elblogdeselo_Pruebaajax_AjaxController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		//echo 'Hello everybody';
		$this->loadLayout();
		$this->renderLayout();
	}
}