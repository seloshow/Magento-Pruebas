<?php
/**
 * @category    Fishpig
 * @package     Fishpig_Wordpress
 * @license     http://fishpig.co.uk/license.txt
 * @author      Ben Tideswell <help@fishpig.co.uk>
 */

class Fishpig_Wordpress_Block_Page_View_Comments extends Fishpig_Wordpress_Block_Post_View_Comments
{
	/**
	 * Block name for the comments form block
	 *
	 * @var string
	 */
	protected $_commentsFormBlockName = 'wordpress_page_comment_form';
	
	/**
	 * Block type for the comments form block
	 *
	 * @var string
	 */
	protected $_commentsFormBlockType = 'wordpress/page_view_comment_form';
	
	/**
	 * Name of the pager block
	 *
	 * @var string
	 */
	protected $_pagerBlockName = 'wordpress_page_comment_pager';

	/**
	 * Block type for the pager block
	 *
	 * @var string
	 */	
	protected $_pagerBlockType = 'wordpress/page_view_comment_pager';

	/**
	 * Retrieve the page object
	 * This is overridden to save duplicating all post comment code
	 *
	 * @return Fishpig_Wordpress_Model_Page
	 */
	public function getPost()
	{
		return $this->getPage();
	}

	/**
	 * Retrieve the page object
	 *
	 * @return Fishpig_Wordpress_Model_Page
	 */	
	public function getPage()
	{
		return Mage::registry('wordpress_page');
	}
}
