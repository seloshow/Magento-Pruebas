<?php
class Alanstormdotcom_Complexworld_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction(){
		$weblog2 = Mage::getModel('complexworld/eavblogpost');
    	$weblog2->load(1);
    	var_dump($weblog2);
	}
	public function populateEntriesAction() {
	    for($i=0;$i<10;$i++) {    
	        $weblog2 = Mage::getModel('complexworld/eavblogpost');
	        $weblog2->setTitle('This is a test '.$i);
	        $weblog2->save();
	    }    
	
	    echo 'Done';
	}
	public function showcollectionAction() {
	    $weblog2 = Mage::getModel('complexworld/eavblogpost');
	    $entries = $weblog2->getCollection()->addAttributeToSelect('title');        
	    $entries->load();
	    foreach($entries as $entry)
	    {
	        // var_dump($entry->getData());
	        echo '<h3>'.$entry->getTitle().'</h3>';
	    }
	    echo '<br>Done<br>';
	}
}