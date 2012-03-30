<?php
/**
 * @category    Fishpig
 * @package     Fishpig_Wordpress
 * @license     http://fishpig.co.uk/license.txt
 * @author      Ben Tideswell <help@fishpig.co.uk>
 */

class Fishpig_Wordpress_Block_Sidebar_Widget_Posts extends Fishpig_Wordpress_Block_Sidebar_Widget_Abstract
{
	/**
	 * Set the posts collection
	 *
	 */
	protected function _beforeToHtml()
	{
		parent::_beforeToHtml();

		$this->setPosts($this->_getPostCollection());


//		echo '<pre>'; print_r($this->getData());		exit;
		return $this;
	}
	
	/**
	 * Control the number of posts displayed
	 *
	 * @param int $count
	 * @return $this
	 */
	public function setPostCount($count)
	{
		return $this->setNumber($count);
	}
	
	/**
	 * Adds on cateogry/author ID filters
	 *
	 * @return Fishpig_Wordpress_Model_Mysql4_Post_Collection
	 */
	protected function _getPostCollection()
	{
		$collection = Mage::getResourceModel('wordpress/post_collection')
			->addIsPublishedFilter()
			->setOrderByPostDate()
			->setPageSize($this->getNumber() ? $this->getNumber() : 5)
			->setCurPage(1);

		if ($categoryId = $this->getCategoryId()) {
			$collection->addCategoryIdFilter($categoryId);
		}
		
		if ($authorId = $this->getAuthorId()) {
			$collection->addAuthorIdFilter($authorId);
		}

		return $collection;
	}
	
	/**
	 * Retrieve the default title
	 *
	 * @return string
	 */
	public function getDefaultTitle()
	{
		if ($this->getCategory()) {
			return $this->getCategory()->getName();
		}
		
		return $this->__('Recent Posts');
	}
	
	/**
	 * Retrieve the category model used to filter the posts
	 *
	 * @return Fishpig_Wordpress_Model_Post_Category|false
	 */
	public function getCategory()
	{
		if (!$this->hasCategory()) {
			$this->setCategory(false);
			if ($this->getCategoryId()) {
				$category = Mage::getModel('wordpress/post_category')->load($this->getCategoryId());

				if ($category->getId()) {
					$this->setCategory($category)->setCategoryId($category->getId());
				}
			}
		}
		
		return $this->_getData('category');
	}
	
	/**
	 * Retrieve the category ID
	 *
	 * return int|null
	 */
	public function getCategoryId()
	{
		if ($categoryId = $this->_getData('category_id')) {
			return $categoryId;
		}
		
		return $this->_getData('cat');	
	}
	
	/**
	 * Retrieve the ID used for the list
	 * This is necessary so multiple instances can be used
	 *
	 * @return string
	 */
	public function getListId()
	{
		if (!$this->hasListId()) {
			$hash = md5(rand(1111, 9999) . $this->getCategoryId() . $this->getAuthorId() . $this->getTitle());
			
			$this->setListId(substr($hash, 0, 6));
		}
		
		return $this->_getData('list_id');
	}
	
	/**
	 * Added to support 'Category Posts Widget' WP plugin
	 *
	 */
	public function canDisplayCommentCount()
	{
		return $this->_getData('comment_num') == 'on';
	}
	
	public function canDisplayDate()
	{
		return $this->_getData('date') == 'on';
	}
	
	public function canDisplayExcerpt()
	{
		return $this->getData('excerpt') == 'on';
	}
	
	public function canDisplayTitleLink()
	{
		return $this->getData('title_link') == 'on';
	}
	
	public function getExcerptLength()
	{
		if ($this->canDisplayExcerpt()) {
			return $this->_getData('excerpt_length');
		}
		
		return null;
	}
	
	public function getCommentCountString(Fishpig_Wordpress_Model_Post $post)
	{
		if ($post->getCommentCount() == 0) {
			return $this->__('No Comments');
		}
		else if ($post->getCommentCount() > 1) {
			return $this->__('%d Comments', $post->getCommentCount());
		}

		return $this->__('1 Comment');	
	}
}
