<?php
class Alanstormdotcom_Complexworld_Model_Resource_Eav_Mysql4_Eavblogpost extends Mage_Eav_Model_Entity_Abstract
{   
    public function _construct()
    {
        $resource = Mage::getSingleton('core/resource');
        $this->setType('complexworld_eavblogpost');
          $this->setConnection(
                $resource->getConnection('complexworld_read'),
                $resource->getConnection('complexworld_write')
            );
    }
}