<?php

/**
 * Demac Media
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.demacmedia.com/LICENSE-Magento.txt
 *
 * @category   Demac
 * @author     Allan MacGregor (allan@demacmedia.com)
 * @package    Demac_Sweep
 * @copyright  Copyright (c) 2010-2011 Demac Media (http://www.demacmedia.com)
 * @license    http://www.demacmedia.com/LICENSE-Magento.txt
 */
class Demac_CacheSweep_Model_Sweeper {

    /**
     * Sweep Old Magento Cache
     *
     * @internal param $void
     * @return void
     */
	public function sweep() {
		$startTime = time();
		Mage::app()->getCache()->clean(Zend_Cache::CLEANING_MODE_OLD);
		$duration = time() - $startTime;
		Mage::log('[CACHESWEEPER] Sweep Old Cache (duration: '.$duration.')', null, 'demac_cachesweeper.log');
	}
	
	/**
	 *  Sweep Magento Cache
	 *  
	 * @see app/code/core/Mage/Adminhtml/controllers/CacheController.php
	 * @return void
	 */
	public function sweepSystem() {
		$startTime = time();
		Mage::app()->cleanCache();
		$duration = time() - $startTime;
		Mage::log('[CACHESWEEPER] Sweep Cache (duration: '.$duration.')', null, 'demac_cachesweeper.log');
	}
	
	/**
	 * Sweep Cache Storage
	 *  
	 * @see app/code/core/Mage/Adminhtml/controllers/CacheController.php
	 * @return void
	 */
	public function sweepAll() {
		$startTime = time();
		Mage::app()->getCacheInstance()->flush();
		$duration = time() - $startTime;
		Mage::log('[CACHESWEEPER] Sweep Cache Storage (duration: '.$duration.')', null, 'demac_cachesweeper.log');
	}
	
	/**
	 * Sweep images
	 *  
	 * @see app/code/core/Mage/Adminhtml/controllers/CacheController.php
	 * @return void
	 */
	public function sweepImages() {
		$startTime = time();
		Mage::getModel('catalog/product_image')->clearCache();
		Mage::dispatchEvent('clean_catalog_images_cache_after');
		$duration = time() - $startTime;
		Mage::log('[CACHESWEEPER] Sweep Images Cache (duration: '.$duration.')', null, 'demac_cachesweeper.log');
	}
	
	/**
	 * Sweep Style
	 *  
	 * @see app/code/core/Mage/Adminhtml/controllers/CacheController.php
	 * @return void
	 */
	public function sweepStyle() {
		$startTime = time();
		Mage::getModel('core/design_package')->cleanMergedJsCss();
		Mage::dispatchEvent('clean_media_cache_after');
		$duration = time() - $startTime;
		Mage::log('[CACHESWEEPER] Sweep Style Files Cache (duration: '.$duration.')', null, 'demac_cachesweeper.log');
	}

}
