<?php
class Elblogdeselo_Ordermodel_Block_Product_View extends Mage_Catalog_Block_Product_View
{
	protected function _prepareLayout(){
	$lengthBlock=$this->getLayout()->addBlock('core/template','length_product')
		->setTemplate('mto/length_product.phtml');
	$this->setChild('length_product',$lengthBlock);
	return parent::_prepareLayout();
	}
}