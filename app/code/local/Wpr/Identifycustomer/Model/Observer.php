<?php 
class Wpr_Identifycustomer_Model_Observer
{
	private static $_vecesEjecutado = 1;/*Variable estática que nos valdrá para únicamente tener en cuenta la primera vez que se ejecuto este evento*/
	
	public function checkCustomer($observer){
		/*A esto habría que ponerle una variable estática para que saltara una vez y ya no volviera a saltar mas, 
		 * dado que el evento que hemos utilizado es lanzado en muchos sitios a nosotroso solo nos interesa en la prumera
		 * ves que es lanzado*/
		if (self::$_vecesEjecutado > 1){
			//var_dump( $observer->getResponse());exit;
			//var_dump(self::$_vecesEjecutado);
			//return $this;
		}
		else{
			//var_dump( $observer->getFront()->getRequest()->getHttpHost());//exit;//Funciona si paro la ejecución, debe de haber algo ejecutandose concurrentemente
			
			//self::$_vecesEjecutado ++;
			
		}
	}
}