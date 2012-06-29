<?php
class Elblogdeselo_Probandocache_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction(){
		//echo 'hola';
		//$xml = Mage::getConfig()->getNode()->asXml();
		//file_put_contents('/tmp/no-cache.xml', $xml);
		//file_put_contents('/tmp/with-cache.xml', $xml);
// 		$xml = Mage::getConfig()->getNode();
// 		foreach($xml as $node)
// 		{
// 			var_dump($node->getName());
// 		}
		$xml = Mage::getConfig()->getNode('stores');
		var_dump($xml->asXml());
	}
	
}