<?php
class Alanstormdotcom_Helloworld_IndexController extends Mage_Core_Controller_Front_Action {
	public function indexAction()
	{
		$customer=Mage::getModel('customer/customer');
		Zend_Debug::dump($customer);
		//echo 'Hello index';
		$this->loadLayout();//carga el layout del m�dulo
		$this->renderLayout();// renderiza el layout de la extensi�n.
		
	}
	public function goodbyeAction() {
    	$this->loadLayout();
    	$this->renderLayout();
		echo 'Goodbye World!';
	} 
	public function paramsAction() {
	    echo '<dl>';            
	    foreach($this->getRequest()->getParams() as $key=>$value) {
	        echo '<dt><strong>Param: </strong>'.$key.'</dt>';
	        echo '<dl><strong>Value: </strong>'.$value.'</dl>';
	    }
	    echo '</dl>';
	}
	public function viewConfigAction(){
		$params = $this->getRequest()->getParams();
		header('Content-Type: text/xml');
		//header('Content-Type: text/plain');         
		echo $config = Mage::getConfig()
		->loadModulesConfiguration($params['file'])        
		->getNode()
		->asXML();          
		exit;
	}
	public function collectionsAction(){
		$thing_1= new Varien_Object();
		$thing_1->setName('david');
		$thing_1->setAge('27');
		$thing_1->setLastName('Smith');
		
		
		$thing_2 = new Varien_Object();
		$thing_2->setName('Jane');
		$thing_2->setAge(12);
		
		$thing_3 = new Varien_Object();
		$thing_3->setName('Spot');
		$thing_3->setLastName('The Dog');
		$thing_3->setAge(7);
		//var_dump($thing_3->getData());
		//var_dump($thing_3["last_name"]);
		/*Definiremos ahora una serie de collections*/
		$collection_of_things = new Varien_Data_Collection();           
		$collection_of_things
		->addItem($thing_1)
		->addItem($thing_2)
		->addItem($thing_3);
		foreach($collection_of_things as $thing){
			var_dump($thing->getData());
		}
		echo "<br><br>";
		echo "obteniendo el primer y último elemento";
		echo "<br><br>";
		var_dump($collection_of_things->getFirstItem());
		var_dump($collection_of_things->getLastItem()->getData());
		echo "<br><br>";
		echo"Ahora como xml";
		var_dump( $collection_of_things->toXml() );  
		echo '<br><br>';
		echo'ahora obtenemos solo las columnas identificadas como name';
		echo '<br><br>';
		var_dump($collection_of_things->getColumnValues('name'));
		echo '<br><br>';
		echo 'El equipo de Magento nos permite realizar filtrados, ejemplo para el nombre david';
		echo '<br/><br>';
		var_dump($collection_of_things->getItemsByColumnValue('name','Spot'));
		
	}
	public function testAction(){
		$collection_of_products = Mage::getModel('catalog/product')->getCollection();
    	//var_dump($collection_of_products->getFirstItem()->getData());//Obtiene todos los datos del collection
    	//var_dump($collection_of_products->getSelect()); //might cause a segmentation fault.
    	/*Whoops! Since Magento is using the Zend database abstraction layer, your Select is also an Object. Let’s see that as a more useful string*/
    	/*$collection_of_products = Mage::getModel('catalog/product')
			->getCollection()
			->addAttributeToSelect('meta_title')
			->addAttributeToSelect('price');
		
		var_dump((string)$collection_of_products->getSelect());*/
		
		/*Ejemplo de como filtrar por un atributo*/
		/*$collection_of_products = Mage::getModel('catalog/product')
    		->getCollection();
    	$collection_of_products->addFieldToFilter('sku','n2610');

    	//another neat thing about collections is you can pass them into the count      //function.  More PHP5 powered goodness
    	echo "Our collection now has " . count($collection_of_products) . ' item(s)';           
    	var_dump($collection_of_products->getFirstItem()->getData());*/
		
		/*Consulta que realmente está realizando*/
		/*var_dump(
    		(string) 
    		Mage::getModel('catalog/product')
    		->getCollection()
    		->addFieldToFilter('sku','n2610')
    		->getSelect());*/
		/*Ahora veamos la consulta que escupe al añadirle todos los atributos EAV*/
		/*var_dump(
		(string) 
		Mage::getModel('catalog/product')
		->getCollection()
		->addAttributeToSelect('*')
		->addFieldToFilter('meta_title','my title')
		->getSelect()
		);*/
		
		/*Ahora vamos a hacer una operación de comparación, para ver como se harían los no equal, greater than*/
		/*var_dump(
		    (string) 
		    Mage::getModel('catalog/product')
		    ->getCollection()
		    ->addFieldToFilter('sku',array('gt'=>'n2610'))
		    ->getSelect()
		    );
		  */  
		/*
		 * Esto me parece muy interesante ponerlo aquí
		 * 
		 * array("eq"=>'n2610')
			WHERE (e.sku = 'n2610')
			
			array("neq"=>'n2610')
			WHERE (e.sku != 'n2610')
			
			array("like"=>'n2610')
			WHERE (e.sku like 'n2610')
			
			array("nlike"=>'n2610')
			WHERE (e.sku not like 'n2610')
			
			array("is"=>'n2610')
			WHERE (e.sku is 'n2610')
			
			array("in"=>array('n2610'))
			WHERE (e.sku in ('n2610'))
			
			array("nin"=>array('n2610'))
			WHERE (e.sku not in ('n2610'))
			
			array("notnull"=>'n2610')
			WHERE (e.sku is NOT NULL)
			
			array("null"=>'n2610')
			WHERE (e.sku is NULL)
			
			array("gt"=>'n2610')
			WHERE (e.sku > 'n2610')
			
			array("lt"=>'n2610')
			WHERE (e.sku < 'n2610')
			
			array("gteq"=>'n2610')
			WHERE (e.sku >= 'n2610')
			
			array("moreq"=>'n2610') //a weird, second way to do greater than equal
			WHERE (e.sku >= 'n2610')
			
			array("lteq"=>'n2610')
			WHERE (e.sku <= 'n2610')
			
			array("finset"=>array('n2610'))
			WHERE (find_in_set('n2610',e.sku))
			
			array('from'=>'10','to'=>'20')
			WHERE e.sku >= '10' and e.sku <= '20'*/
		    
		    echo(
		        (string) 
		        Mage::getModel('catalog/product')
		        ->getCollection()
		        ->addFieldToFilter('sku',array('like'=>'a%'))
		        ->addFieldToFilter('sku',array('like'=>'b%'))
		        ->getSelect()
		        );
    	
	}
	public function lazyAction()
	{
		$customer=new Customer();
	}
}