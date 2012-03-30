<?php
/**
 * @category    Fishpig
 * @package     Fishpig_Wordpress
 * @license     http://fishpig.co.uk/license.txt
 * @author      Ben Tideswell <help@fishpig.co.uk>
 */

class Fishpig_Wordpress_Helper_Data extends Fishpig_Wordpress_Helper_Abstract
{
	/**
	 * Retrieve the top link URL
	 *
	 * @return string
	 */
	public function getTopLinkUrl()
	{
		try {
			if ($this->isFullyIntegrated()) {
				if ($this->isBlogMagentoHomepage()) {
					return $this->_getUrl();
				}
				
				return $this->getUrl();
			}
		
			return $this->getWpOption('home');
		}
		catch (Exception $e) {
			$this->log('Magento & WordPress are not correctly integrated (see entry below).');
			$this->log($e->getMessage());
		}
		
		return '';
	}

	/**
	 * Returns the pretty version of the blog route
	 *
	 * @return string
	 */
	public function getPrettyBlogRoute()
	{
		return Mage::getStoreConfig('wordpress_blog/top_link/label');
	}
	
	/**
	 * Returns the given string prefixed with the Wordpress table prefix
	 *
	 * @return string
	 */
	public function getTableName($table)
	{
		return Mage::helper('wordpress/db')->getTableName($table);
	}
	
	/**
	 * Determine whether the module is enabled
	 * This can be changed by going to System > Configuration > Advanced
	 *
	 * @return bool
	 */
	public function isEnabled()
	{
		return !Mage::getStoreConfig('advanced/modules_disable_output/Fishpig_Wordpress');
	}
	
	/**
	  * Formats a Wordpress date string
	  *
	  */
	public function formatDate($date, $format = null, $f = false)
	{
		if ($format == null) {
			$format = $this->getDefaultDateFormat();
		}
		
		/**
		 * This allows you to translate month names rather than whole date strings
		 * eg. "March","Mars"
		 *
		 */
		$len = strlen($format);
		$out = '';
		
		for( $i = 0; $i < $len; $i++) {	
			$out .= $this->__(Mage::getModel('core/date')->date($format[$i], strtotime($date)));
		}
		
		return $out;
	}
	
	/**
	  * Formats a Wordpress date string
	  *
	  */
	public function formatTime($time, $format = null)
	{
		if ($format == null) {
			$format = $this->getDefaultTimeFormat();
		}
		
		return $this->formatDate($time, $format);
	}
	
	/**
	  * Return the default date formatting
	  *
	  */
	public function getDefaultDateFormat()
	{
		return $this->getWpOption('date_format', 'F jS, Y');
	}
	
	/**
	  * Return the default time formatting
	  *
	  */
	public function getDefaultTimeFormat()
	{
		return $this->getWpOption('time_format', 'g:ia');
	}
	
	/**
	 * Determine whether a WordPress plugin is enabled in the WP admin
	 *
	 * @param string $name
	 * @param bool $format
	 * @return bool
	 */
	public function isPluginEnabled($name, $format = true)
	{
		$name = $format ? Mage::getSingleton('catalog/product_url')->formatUrlKey($name) : $name;
		
		if ($plugins = $this->getWpOption('active_plugins')) {
			$plugins = unserialize($plugins);

			foreach($plugins as $plugin) {
				if (strpos($plugin, $name) !== false) {
					return true;
				}
			}
		}
		
		return false;
	}

	/**
	 * Determine whether Cryllic locale support is enabled
	 *
	 * @return bool
	 */
	public function isCryllicLocaleEnabled()
	{
		return Mage::getStoreConfigFlag('wordpress_blog/locale/cyrillic_enabled');
	}

	/**
	 * Determine whether the blog is set to be the Magento homepage
	 *
	 * @return bool
	 */
	public function isBlogMagentoHomepage()
	{
		return Mage::getStoreConfigFlag('wordpress_blog/layout/blog_as_homepage')
			&& (Mage::getStoreConfig('web/default/front') == 'wordpress/homepage/index');
	}
	
	/**
	 * Determine whether to force single store
	 *
	 * @return bool
	 */
	public function forceSingleStore()
	{
		return Mage::getStoreConfigFlag('wordpress_blog/associations/force_single_store');
	}
	
	/**
	 * Retrieve the current version of the extension
	 *
	 * @return string
	 */
	public function getExtensionVersion()
	{
		return Mage::getConfig()->getNode()->modules->Fishpig_Wordpress->version;
	}
}
