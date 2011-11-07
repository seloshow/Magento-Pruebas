<?php

/**
 * Admin Roles Model
 */
class Weiler_Lite_Model_Admin_Roles extends Mage_Admin_Model_Roles
{
	
	//can be moved to event hooked to block or controller ?!
	function _removeDisabledAcl($resource = null)
	{
		if(!$resource) {
			$resource = Mage::getSingleton('admin/config')->getAdminhtmlConfig()->getNode('acl/resources/admin/children');
		}

		foreach($resource->children() as $key => $r) {
			if($r->disabled==1) {
				unset($resource->$key);
				continue;
			}

			if ($r->depends) {
				foreach($r->depends->module as $_module) {
					if(!Mage::helper('core')->isModuleEnabled($_module)) {
						unset($resource->$key);
						continue;
					}
				}
			}			
			
			if($r->children){
				$this->_removeDisabledAcl($r->children);
			}
		}
	}

    protected function _buildResourcesArray(Varien_Simplexml_Element $resource = null,
        $parentName = null, $level = 0, $represent2Darray = null, $rawNodes = false, $module = 'adminhtml')
    {
    	$this->_removeDisabledAcl();
    	return parent::_buildResourcesArray($resource,$parentName,$level,$represent2Darray,$rawNodes,$module);
    }

}
