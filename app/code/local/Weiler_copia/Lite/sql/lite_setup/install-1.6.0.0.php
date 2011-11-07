<?php

$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Setup */

$installer->startSetup();


//remove "system" (is_user_defined) from some product attributes
$attributeCodes = array(
	'msrp',
	'msrp_display_actual_price_type',
	'msrp_enabled',
	'news_from_date',
	'news_to_date',
	'recurring_profile',
	'is_recurring',
	'country_of_manufacture',
	'small_image',
	'thumbnail',
	'gift_message_available',
	'enable_googlecheckout',
	'is_imported',
	'tier_price',
	'special_price',
	'special_from_date',
	'special_to_date',
	
	'custom_design',
	'custom_design_from',
	'custom_design_to',
	'custom_layout_update',
	'page_layout',
	'options_container',

	'meta_title',
	'meta_keyword',
	'meta_description',
);

foreach($attributeCodes as $attributeCode) {
	if(!$this->getAttributeId(Mage_Catalog_Model_Product::ENTITY, $attributeCode)) {
		continue;
	}
	$installer->updateAttribute(
	    Mage_Catalog_Model_Product::ENTITY,
	    $attributeCode,
	    'is_user_defined',
		1
	);
}


//add Lite attribute set
//copy current Default and remove all non-system attributes except few if they are there

$defaultTypeId = Mage::getModel('catalog/product')->getResource()->getTypeId();
$defaultAttributeSetId = Mage::getModel('eav/entity_type')->load($defaultTypeId)->getDefaultAttributeSetId();

/* @var $model Mage_Eav_Model_Entity_Attribute_Set */
$model  = Mage::getModel('eav/entity_attribute_set')
			->setEntityTypeId($defaultTypeId);

$model->setAttributeSetName('Lite');	//check if Lite named attribute set exist already?
$model->save();

$groups = Mage::getModel('eav/entity_attribute_group')
			->getResourceCollection()
			->setAttributeSetFilter($defaultAttributeSetId)
			->load();

$newGroups = array();
foreach ($groups as $group) {
	$newGroup = clone $group;
	$newGroup->setId(null)
		->setAttributeSetId($model->getId())
		->setDefaultId($group->getDefaultId());

	$groupAttributesCollection = Mage::getModel('eav/entity_attribute')
		->getResourceCollection()
		->setAttributeGroupFilter($group->getId())
		->load();

	$newAttributes = array();
	foreach ($groupAttributesCollection as $attribute) {
		
		if( $attribute->getIsUserDefined() && 
			!in_array(
				$attribute->getAttributeCode(),
				array(	'cost',
						'small_image',
						'thumbnail'
						//'meta_title',
						//'meta_keyword',
						//'meta_description'
				)
			)) {
			continue;
		}
		
		$newAttribute = Mage::getModel('eav/entity_attribute')
			->setId($attribute->getId())
			->setAttributeSetId($model->getId())
			->setEntityTypeId($model->getEntityTypeId())
			->setSortOrder($attribute->getSortOrder());
		$newAttributes[] = $newAttribute;
	}
	if(!empty($newAttributes)) {
		$newGroup->setAttributes($newAttributes);
		$newGroups[] = $newGroup;
	}
}

$model->setGroups($newGroups);

$model->save();

$installer->endSetup();
