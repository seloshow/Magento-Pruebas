<?php 
/*@davidselo: Observer dedicado a comprobar si estas en una determinada cms(landing page) 
 * y si es así, escribimos en la sesión del usuario que ha pasado por esta landing. Posteriormente 
 * deberemos de comprobar si este usuario tiene esta variable y si es así lo meteremos en un grupo determinado.*/
class Wpr_Identifycustomer_Model_Observer
{
	/**
	 * @param $observer=> {
	 * 					page(Mage_Cms_Model_Page)
	 * 					controller_action(Mage_Core_Controller_Varien_Action)
	 * }
	 * @author david
	 * @twitter @davidselo
	 * 
	 * */
	
	public function checkCustomer($observer){
		/*A esto habría que ponerle una variable estática para que saltara una vez y ya no volviera a saltar mas, 
		 * dado que el evento que hemos utilizado es lanzado en muchos sitios a nosotroso solo nos interesa en la prumera
		 * ves que es lanzado*/
		//var_dump($observer->getPage()->getIdentifier());
		$titulo=$observer->getPage()->getIdentifier();
		if(strcmp($titulo, 'landing-mg')==0)
			{
				$var='patata';
				Mage::getSingleton('core/session')->setPatata($var);
				$action=$observer->getControllerAction();
				$action->getLayout()->getUpdate()
					->addHandle('patata');
				//$action->loadLayout();
				//$action->RenderLayout();
				
					
			}
		
			//var_dump( $observer->getCondition());exit;//Funciona si paro la ejecución, debe de haber algo ejecutandose concurrentemente
			
			
		
		
	}
}