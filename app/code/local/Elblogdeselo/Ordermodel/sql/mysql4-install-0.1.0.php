<?php
$read=Mage::getSingleton('core/resource')
 		->getConnection('core_read');
$eid=$read->fetchRow('select ... where entity_type_code="quote_item"');
$quote_type_id=$eid['entity_type_id'];

$eid=$read->fetchRow('select ... where entity_type_code="order_item"');
$order_type_id=$eid['entity_type_id'];

$installer=$this;
$installer->starSetup();
//quote type
$c=array(
	'entity_type_id'=>$quote_type_id,
	'attribute_code'=>'mto_length',
);
$attribute=new Mage_Eav_Model_Entity_Attribute();
$attribute->loadByCode($c['entity_type_id'], $c['attribute_code'])
	->setStoreId(0)
	->addData($c);
	
$c=array(
	'entity_type_id'=>$quote_type_id,
	'attribute_code'=>'mto_length',
);
$attribute=new Mage_Eav_Model_Entity_Attribute();
$attribute->loadByCode($c['entity_type_id'], $c['attribute_code'])
	->setStoreId(0)
	->addData($c);
	
//order type
	
	$c=array(
	'entity_type_id'=>$order_type_id,
	'attribute_code'=>'mto_length',
);
$attribute=new Mage_Eav_Model_Entity_Attribute();
$attribute->loadByCode($c['entity_type_id'], $c['attribute_code'])
	->setStoreId(0)
	->addData($c);
	
$c=array(
	'entity_type_id'=>$order_type_id,
	'attribute_code'=>'mto_length',
);
$attribute=new Mage_Eav_Model_Entity_Attribute();
$attribute->loadByCode($c['entity_type_id'], $c['attribute_code'])
	->setStoreId(0)
	->addData($c);
	
$attribute->save();

$installer->endSetup();