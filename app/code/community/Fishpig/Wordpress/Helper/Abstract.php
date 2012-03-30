<?php
/**
 * @category    Fishpig
 * @package     Fishpig_Wordpress
 * @license     http://fishpig.co.uk/license.txt
 * @author      Ben Tideswell <help@fishpig.co.uk>
 */

class Fishpig_Wordpress_Helper_Abstract extends Mage_Core_Helper_Abstract
{
	/**
	 * Internal cache variable
	 *
	 * @var array
	 */
	static protected $_cache = array();
	
	/**
	  * Returns the URL used to access your Wordpress frontend
	  *
	  * @param string|null $extra = null
	  * @param array $params = array
	  * @return string
	  */
	public function getUrl($extra = null, array $params = array())
	{
		if (count($params) > 0) {
			$extra = trim($extra, '/') . '/';
			
			foreach($params as $key => $value) {
				$extra .= $key . '/' . $value . '/';
			}
		}
		
		if ($this->isFullyIntegrated()) {
			$params = array(
				'_direct' 	=> $this->getBlogRoute() . '/' . ltrim($extra, '/'), 
				'_secure' 	=> false,
				'_nosid' 	=> true,
				'_store'		=> Mage::app()->getStore()->getId(),
			);
			
			if (Mage::app()->getStore()->getCode() == 'admin') {
				if ($storeCode = Mage::app()->getRequest()->getParam('store')) {
					$params['_store'] = $storeCode;
				}
				else {
					$params['_store'] = $this->getDefaultStore(Mage::app()->getRequest()->getParam('website', null))->getId();
				}
			}
			
			$url = $this->_getUrl('', $params);
		}
		else {
			$url = $this->getWpOption('home') . '/' . ltrim($extra, '/');
		}
	
		return htmlspecialchars($url);
	}
	
	/**
	  * Returns the URL Wordpress is installed on
	  *
	  * @param string $extra
	  * @return string
	  */
	public function getBaseUrl($extra = '')
	{
		return rtrim($this->getWpOption('siteurl'), '/') . '/' . $extra;
	}
	
	/**
	  * Get Wordpress Admin URL
	  *
	  */
	public function getAdminUrl($extra = null)
	{
		return $this->getBaseUrl('wp-admin/' . $extra);
	}
	
	/**
	  * Returns the blog route selected in the Magento config
	  *
	  * Returns null if full integration is disbaled
	  *
	  */
	public function getBlogRoute()
	{
		return $this->isFullyIntegrated() ? strtolower($this->getConfigValue('wordpress/integration/route')) : null;
	}
	
	/**
	 * Returns true if Magento/Wordpress are installed in the same DB
	 * This can be configured in the Magento admin
	 *
	 * @return bool
	 */
	public function isSameDatabase()
	{
		return !$this->getConfigValue('wordpress/database/is_different_db');
	}
	
	/**
	  * Returns true if full integration is enabled
	  *
	  */
	public function isFullyIntegrated()
	{
		return $this->getConfigValue('wordpress/integration/full');
	}
	
	/**
	  * Gets a Wordpress option based on it's name
	  *
	  * If the value isn't found in the cache, it is fetched and added
	  *
	  */
	public function getCachedWpOption($optionName, $default = null)
	{
		return $this->getWpOption($optionName, $default);
	}
	
	/**
	  * Gets a Wordpress option based on it's name
	  *
	  */
	public function getWpOption($key, $default = null)
	{
		$helper = Mage::helper('wordpress/db');
		$cacheKey = '_wp_option_' . $key;
		
		if (!$this->_isCached($cacheKey)) {
			$this->_cache($cacheKey, $default);
			
			try {
				$option = Mage::getModel('wordpress/option')->load($key, 'option_name');
				
				if ($option->getId() && $option->getOptionValue()) {
					$this->_cache($cacheKey, $option->getOptionValue());
				}
			}
			catch (Exception $e) {
				$this->_cache($cacheKey, '');
			}
		}
		
		return $this->_cached($cacheKey);
	}
	
	/**
	  * Logs an error to the Wordpress error log
	  *
	  */
	public function log($message, $level = null, $file = 'wordpress.log')
	{
		if ($this->getConfigValue('wordpress/debug/log_enabled')) {
			if ($message = trim($message)) {
				return Mage::log($message, $level, $file, true);
			}
		}
	}
	
	/**
	 * Retrieve the local path to file cache path
	 *
	 * @return string
	 */
	public function getFileCachePath()
	{
		return Mage::getBaseDir('var') . DS . 'wordpress' . DS;
	}
	
	/**
	 * Returns true if the current Magento version is below 1.4
	 *
	 * @return bool
	 */
	public function isLegacyMagento()
	{
		return version_compare(Mage::getVersion(), '1.4.0.0', '<');
	}

	/**
	 * Determine whether the Magento is the Enterprise edition
	 *
	 * @return bool
	 */
	public function isEnterpriseMagento()
	{
		return is_file(Mage::getBaseDir('code') . DS . implode(DS, array('Enterprise', 'Enterprise', 'etc')) . DS . 'config.xml');
	}
	
	/**
	 * Retrieve the path for the WordPress installation
	 * The main use of this is to include the phpass class file for Customer Synchronisation
	 *
	 * @return string
	 */
	public function getWordPressPath()
	{
		$path = $this->getConfigValue('wordpress/misc/path');

		if (!$path) {
			$mUrlParts = parse_url(Mage::getBaseUrl());
			$wUrlParts = parse_url($this->getBaseUrl());

			$basePath = Mage::getBaseDir();
			
			if (isset($mUrlParts['path']) && !empty($mUrlParts['path'])) {
				$basePath = substr($basePath, 0, -(strlen($mUrlParts['path'])-1));
			}

			$path = $basePath . $wUrlParts['path'];
		}
		
		return rtrim($path, DS) . DS;
	}
	
	/**
	 * Determine whether integration is enabled
	 *
	 * @return bool
	 */
	public function integrationIsEnabled()
	{
		return Mage::helper('wordpress/db')->isConnected() && Mage::helper('wordpress/db')->isQueryable();
	}

	/**
	 * Retrieves all config values for the extension
	 *
	 * @return array
	 */
	protected function _getAllConfigValues()
	{
		if (!$this->_isCached('config')) {
			$this->_cache('config', array());
			
			$store 		= Mage::app()->getStore();
			$request	= Mage::app()->getRequest();
			
			if ($store->getCode() == 'admin') {
				$websiteCode 	= $request->getParam('website', false);
				$storeCode 		= $request->getParam('store', false);
				$storeId			= intval($storeCode)==$storeCode;
				$options 			= array('default' => 0);
				
				if ($storeCode) 	{
					$store = Mage::getModel('core/store')->load($storeCode, ($storeId ? null : 'code'));
					
					if ($store->getId()) {
						$options = array(
							'stores' => $store->getId(), 
							'websites' => $store->getWebsiteId(), 
							'default' => 0
						);
					}
				}
				else if ($websiteCode) {
					$website = Mage::getModel('core/website')->load($websiteCode, 'code');
					
					if ($website->getId()) {
						$options = array(
							'websites' => $website->getId(), 
							'default' => 0
						);
					}
				}
			}
			else {
				$options = array(
					'stores' => $store->getId(), 
					'websites' => $store->getWebsite()->getId(), 
					'default' => 0
				);
			}

			$resource = Mage::getSingleton('core/resource');
			$db 			= $resource->getConnection('core_read');
			$config		= array();
			
			foreach($options as $scope => $scopeId) {
				$select = $db->select()
					->from($resource->getTableName('core/config_data'), array('path', 'value'))
					->where('path LIKE ?', 'wordpress%')
					->where('scope=?', $scope)
					->where('scope_id=?', $scopeId);
		
				if ($results = $db->fetchAll($select)) {
					foreach($results as $result) {
						if (!isset($config[$result['path']])) {
							$config[$result['path']] = $result['value'];
						}
					}
				}
			}

			$this->_cache('config', $config);
		}

		return $this->_cached('config');
	}
	
	
	/**
	 * Retrieve a cached config value
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function getConfigValue($key)
	{
		if ($config = $this->_getAllConfigValues()) {
			return isset($config[$key]) ? $config[$key] : null;
		}
		
		return null;
	}
	
	/**
	 * Retrieve the default store model
	 *
	 * @return Mage_Core_Model_Store
	 */
	public function getDefaultStore($websiteCode = null)
	{
		if (!$this->_isCached('default_store')) {	
			$connection = Mage::getSingleton('core/resource')->getConnection('core_read');
			$select = $connection->select()
				->from(array('_store_table' => $this->getTableName('core/store')), 'store_id')
				->where('_store_table.store_id > ?', 0)
				->where('_store_table.code != ?', 'admin')
				->limit(1)
				->order('_store_table.sort_order ASC');
			
			if (!is_null($websiteCode)) {
				$select->join(
					array('_website_table' => $this->getTableName('core/website')),
					$connection->quoteInto('`_website_table`.`website_id`=`_store_table`.`website_id` AND `_website_table`.`code`=?', $websiteCode),
					''
				);
			}
			
			$store = Mage::getModel('core/store')->load($connection->fetchOne($select));
			
			if (!$store->getId() && !is_null($websiteCode)) {
				return $this->getDefaultStore();
			}
			
			$this->_cache('default_store', $store);
		}
		
		return $this->_cached('default_store');
	}
	
	/**
	 * Store a value in the cache
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return $this;
	 */
	protected function _cache($key, $value)
	{
		self::$_cache[$key] = $value;
		
		return $this;
	}
	
	/**
	 * Determine whether there is a value in the cache for the key
	 *
	 * @param string $key
	 * @return bool
	 */
	protected function _isCached($key)
	{
		return isset(self::$_cache[$key]);
	}
	
	/**
	 * Retrieve a value from the cache
	 *
	 * @param string $key
	 * @param mixed $default = null
	 * @return mixed
	 */
	protected function _cached($key, $default = null)
	{
		if ($this->_isCached($key)) {
			return self::$_cache[$key];
		}
		
		return $default;
	}
}
