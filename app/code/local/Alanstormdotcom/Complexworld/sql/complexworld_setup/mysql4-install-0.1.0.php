<?php   
$installer = $this;
$installer->addEntityType('complexworld_eavblogpost',Array(
//entity_mode is the URL you'd pass into a Mage::getModel() call
'entity_model'          =>'complexworld/eavblogpost',
//blank for now
'attribute_model'       =>'',
//table refers to the resource URI complexworld/eavblogpost
//<complexworld_resource_eav_mysql4>...<eavblogpost><table>eavblog_posts</table>
'table'         =>'complexworld/eavblogpost',
//blank for now, but can also be eav/entity_increment_numeric
'increment_model'       =>'',
//appears that this needs to be/can be above "1" if we're using eav/entity_increment_numeric
'increment_per_store'   =>'0'
));
$installer->installEntities();