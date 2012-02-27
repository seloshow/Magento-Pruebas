<?php
class Wpr_Bannerbienvenida_Block_Bienvenida extends Mage_Core_Block_Template
{
	public function primeraVez(){
		$session=Mage::getSingleton('core/session');
		$unaVez=$session->getPrimeraEjecucion();
		if(!isset($unaVez))
		{
			$session->setPrimeraEjecucion(1);
			return true;
		}
		return false;
		
		
	}
}