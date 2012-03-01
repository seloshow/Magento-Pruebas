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
class AW_Blog_Block_Cat extends AW_Blog_Block_Abstract {
     
    public function getPosts() {
        
        $cats = Mage::getSingleton('blog/cat');
       
        if ($cats->getCatId() === NULL) {
            return false;
        } 
        
          $collection = parent::_prepareCollection(array('addCatFilter'=>$cats->getCatId()));            
          parent::_processCollection($collection,$categoryMode = true);    
         
           return $collection;
       
    }
  
    public function getCat() {
        $cats = Mage::getSingleton('blog/cat');
        return $cats;
    }

    public function getPages() {
        
        echo parent::getPagesCollection('category',array('setCatId'=>$this->getCat()->getId()));
        
    }
    

    protected function _prepareLayout() {
        
        $post = $this->getCat();
        
        $route = Mage::helper('blog')->getRoute();

        // show breadcrumbs
        if (Mage::getStoreConfig('blog/blog/blogcrumbs') && ($breadcrumbs = $this->getLayout()->getBlock('breadcrumbs'))) {
            $breadcrumbs->addCrumb('home', array('label' => Mage::helper('blog')->__('Home'), 'title' => Mage::helper('blog')->__('Go to Home Page'), 'link' => Mage::getBaseUrl()));
            ;
            $breadcrumbs->addCrumb('blog', array('label' => Mage::getStoreConfig('blog/blog/title'), 'title' => Mage::helper('blog')->__('Return to ' . Mage::getStoreConfig('blog/blog/title')), 'link' => Mage::getUrl($route)));
            $breadcrumbs->addCrumb('blog_page', array('label' => $post->getTitle(), 'title' => $post->getTitle()));
        }

        if ($head = $this->getLayout()->getBlock('head')) {           
            $head->setTitle($post->getTitle());
            $head->setKeywords($post->getMetaKeywords());
            $head->setDescription($post->getMetaDescription());
        }
    }
    
    
    protected function _toHtml() {
        return Mage::helper('blog')->filterWYS(parent::_toHtml());
    }

 

}
