<?php
class Interactiv4_Loginredirect_Model_Observer {
	public function prueba($observer){
		$url = Mage::getModel('core/url')
                       ->getUrl("/home");
        
 	  /* Url a la que vamos a mandar despues derealizar el login.
      $url = Mage::getModel('core/url')
                       ->getUrl("checkout/cart/index");
                       */
                       
       Mage::app()
                ->getResponse()
                ->setRedirect($url);
       Mage::app()
                ->getResponse()
                ->sendResponse(); 
                exit;
	}
}