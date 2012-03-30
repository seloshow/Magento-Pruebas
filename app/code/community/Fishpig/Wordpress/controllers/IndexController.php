<?php
/**
 * @category    Fishpig
 * @package     Fishpig_Wordpress
 * @license     http://fishpig.co.uk/license.txt
 * @author      Ben Tideswell <help@fishpig.co.uk>
 */

class Fishpig_Wordpress_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		try {
			$wpUrl = Mage::helper('wordpress')->getUrl();
			
			$this->_redirectUrl($wpUrl);
		}
		catch (Exception $e) {
			Mage::helper('wordpress')->log($e->getMessage());
			
			$this->_forward('noRoute');
		}
	}
}
