<?php

$installer = $this;

$installer->startSetup();
$setup = Mage::getModel('customer/entity_setup', 'core_setup');
$setup->addAttribute('customer', 'school', array(
	'type' => 'int',
	'input' => 'select',
	'label' => 'School',
	'global' => 1,
	'visible' => 1,
	'required' => 0,
	'user_defined' => 1,
	'default' => '0',
	'visible_on_front' => 1,
    'source' =>	 'profile/entity_school',
));


if (version_compare(Mage::getVersion(), '1.6.0', '<='))
{
	
	$customer = Mage::getModel('customer/customer');
	$attrSetId = $customer->getResource()->getEntityType()->getDefaultAttributeSetId();
// 	var_dump($attrSetId);exit;
	$setup->addAttributeToSet('customer', $attrSetId, 'General', 'school');
}

if (version_compare(Mage::getVersion(), '1.4.2', '>='))
{
	
	Mage::getSingleton('eav/config')
	->getAttribute('customer', 'school')
	/*@davidselo: con la siguiente línea definimos en que formulario se va a tener en cuenta el atributo.*/
	->setData('used_in_forms', array('adminhtml_customer','customer_account_create','customer_account_edit','checkout_register'))
	->save();

}

$tablequote = $this->getTable('sales/quote');
$installer->run("
ALTER TABLE  $tablequote ADD  `customer_school` INT NOT NULL
");



$installer->endSetup();