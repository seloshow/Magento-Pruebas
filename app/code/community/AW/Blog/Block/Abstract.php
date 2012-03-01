<?php

/**
 * aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/LICENSE-L.txt
 *
 * @category   AW
 * @package    AW_Blog
 * @copyright  Copyright (c) 2009-2010 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/LICENSE-L.txt
 */
class AW_Blog_Block_Abstract extends Mage_Core_Block_Template {

    protected function _processCollection($collection, $category = false) {

        $route = Mage::helper('blog')->getRoute();

        foreach ($collection as $item) {
           
            /* Escape tags */
            AW_Blog_Helper_Data::escapeSpecialChars($item);
            
            
            if ($category) {                
                if (Mage::getStoreConfig('blog/blog/categories_urls')) {
                    $item->setAddress($this->getUrl($route . '/cat/' .  $this->getCat()->getIdentifier() . '/post/' . $item->getIdentifier()));
                } else {
                    $item->setAddress($this->getUrl($route . "/" . $item->getIdentifier()));
                }
            } else {
               $item->setAddress($this->getUrl($route . "/" . $item->getIdentifier()));
            }
 
            $item->setCreatedTime($this->formatTime($item->getCreatedTime(), Mage::getStoreConfig('blog/blog/dateformat'), true));
            $item->setUpdateTime($this->formatTime($item->getUpdateTime(), Mage::getStoreConfig('blog/blog/dateformat'), true));

            if (Mage::getStoreConfig(AW_Blog_Helper_Config::XML_BLOG_USESHORTCONTENT) && trim($item->getShortContent())) {
                $content = trim($item->getShortContent());
                $content = $this->closetags($content);
                $content .= ' <a href="' . $this->getUrl($route . "/" . $item->getIdentifier()) . '" >' . $this->__('Read More') . '</a>';
                $item->setPostContent($content);
            } elseif ((int) Mage::getStoreConfig(AW_Blog_Helper_Config::XML_BLOG_READMORE) != 0) {
                
                
                $content = $item->getPostContent();
                $strManager = new AW_Blog_Helper_Substring(array('input' => Mage::helper('blog')->filterWYS($content)));
                $content = $strManager->getHtmlSubstr((int) Mage::getStoreConfig(AW_Blog_Helper_Config::XML_BLOG_READMORE));

                if ($strManager->getSymbolsCount() == Mage::getStoreConfig(AW_Blog_Helper_Config::XML_BLOG_READMORE)) {
                    $content .= ' <a href="' . $this->getUrl($route . "/" . $item->getIdentifier()) . '" >' . $this->__('Read More') . '</a>';
                }
                $item->setPostContent($content);
            }


            $comments = Mage::getModel('blog/comment')->getCollection()
                    ->addPostFilter($item->getPostId())
                    ->addApproveFilter(2);
            $item->setCommentCount(count($comments));

            $cats = Mage::getModel('blog/cat')->getCollection()
                    ->addPostFilter($item->getPostId());
            $catUrls = array();
            foreach ($cats as $cat) {
                $catUrls[$cat->getTitle()] = Mage::getUrl($route . "/cat/" . $cat->getIdentifier());
            }


            $item->setCats($catUrls);
        }


        if ($category) {

            $this->setData('cat', $collection);
            return $this->getData('cat');
        }


        return $collection;
    }
     
    public function getBookmarkHtml($post) {
        if (Mage::getStoreConfig('blog/blog/bookmarkslist')) {
            $this->setTemplate('aw_blog/bookmark.phtml');
            $this->setPost($post);
            return $this->toHtml();
        }
        return;
    }

    public function getTagsHtml($post) {

        if (trim($post->getTags())) {
            $this->setTemplate('aw_blog/line_tags.phtml');
            $this->setPost($post);
            return $this->toHtml();
        }
        return;
    }

    public function getCommentsEnabled() {
        return Mage::getStoreConfig('blog/comments/enabled');
    }
 
    public function getPagesCollection($mode,$params = array()) {
        
          if ((int) Mage::getStoreConfig('blog/blog/perpage') != 0) { 
             
            if($mode == 'list') { $bool = false; }
            else { $bool = true; }

            $pager = Mage::getConfig()->getBlockClassName('blog/pager'); 
            $pager = new $pager();
            $pager->setTemplate('aw_blog/pager/list.phtml');
            $pager->setCategoryMode($bool); 
            
            
            foreach($params as $key => $param) {                
                $pager->{$key}($param);                
            }
           
            return $pager->renderView();
         }
     
    }
 

    public function addTopLink() {
        if (Mage::helper('blog')->getEnabled()) {
            $route = Mage::helper('blog')->getRoute();
            $title = Mage::getStoreConfig('blog/blog/title');
            $this->getParentBlock()->addLink($title, $route, $title, true, array(), 15, null, 'class="top-link-blog"');
        }
    }

    public function addFooterLink() {
        if (Mage::helper('blog')->getEnabled()) {
            $route = Mage::helper('blog')->getRoute();
            $title = Mage::getStoreConfig('blog/blog/title');
            $this->getParentBlock()->addLink($title, $route, $title, true);
        }
    }

    public function closetags($html) {
        return Mage::helper('blog/post')->closetags($html);
    }

    protected function _prepareCollection($customFilters = array()) {

        if (!$this->getCachedCollection()) {

            $collection = Mage::getModel('blog/blog')->getCollection()
                    ->addPresentFilter()
                    ->addStoreFilter(Mage::app()->getStore()->getId())
                    ->setOrder('created_time ', 'desc');

            if (!empty($customFilters)) {
                foreach ($customFilters as $filter => $value) {
                    $collection->{$filter}($value);
                }
            }

            $page = $this->getRequest()->getParam('page');
            Mage::getSingleton('blog/status')->addEnabledFilterToCollection($collection);
            $collection->setPageSize((int) Mage::getStoreConfig(AW_Blog_Helper_Config::XML_BLOG_PERPAGE));
            $collection->setCurPage($page);

            $this->setCachedCollection($collection);
        }

        return $this->getCachedCollection();
    }

   
}
