<?php
class Wpr_Exportproduct_IndexController extends Mage_Core_Controller_Front_Action{
	
	public function indexAction(){
		$csv = '';
		$catalog=Mage::getModel('catalog/product')->getCollection();
		$heading = array('sku','name','image_url','product_url','description','price','manufacturer','delivery_cost','delivery_time','disponibility','ean');
		$csv.= implode(',', $heading)."\n";
		return array(
            'type'  => 'filename',
            'value' => 'uno',
            'rm'    => true // can delete file after use
        );
	
	}
}