<?php
class CA_Smspremium_Model_Mysql4_Smspremium extends Mage_Core_Model_Mysql4_Abstract
{
	protected function _construct()
	{
		$this->_init('smspremium/smspremium', 'smspremium_id');
	}
}