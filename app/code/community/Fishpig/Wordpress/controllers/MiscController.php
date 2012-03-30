<?php
/**
 * @category    Fishpig
 * @package     Fishpig_Wordpress
 * @license     http://fishpig.co.uk/license.txt
 * @author      Ben Tideswell <help@fishpig.co.uk>
 */

class Fishpig_Wordpress_MiscController extends Mage_Core_Controller_Front_Action
{
	/**
	 * Set the post password and redirect to the referring page
	 *
	 */
	public function applyPostPasswordAction()
	{
		$password = $this->getRequest()->getPost('post_password');
		
		Mage::getSingleton('wordpress/session')->setPostPassword($password);
		
		$this->_redirectReferer();
	}
}
