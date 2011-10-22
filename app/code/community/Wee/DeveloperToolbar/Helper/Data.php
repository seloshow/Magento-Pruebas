<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category    Wee
 * @package     Wee_DeveloperToolbar
 * @author      Stefan Wieczorek <stefan.wieczorek@mgt-commerce.com>
 * @copyright   Copyright (c) 2011 (http://www.mgt-commerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Wee_DeveloperToolbar_Helper_Data extends Mage_Core_Helper_Abstract
{
    public static function formatBytes($size, $praefix=true, $short= true) 
    {
        if ($praefix === true) {
          if($short === true){
            $norm = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 
              'EB', 'ZB', 'YB');
          } else {
            $norm = array('Byte', 
                          'Kilobyte', 
                          'Megabyte', 
                          'Gigabyte', 
                          'Terabyte', 
                          'Petabyte', 
                          'Exabyte', 
                          'Zettabyte', 
                          'Yottabyte'
                         );
          }
          $factor = 1000;
        } else {
          if($short === true) {
            $norm = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 
              'EiB', 'ZiB', 'YiB');
          } else {
            $norm = array('Byte', 
              'Kibibyte', 
              'Mebibyte', 
              'Gibibyte', 
              'Tebibyte', 
              'Pebibyte', 
              'Exbibyte', 
              'Zebibyte', 
              'Yobibyte'
             );
          }
          $factor = 1024;
        } 
        $count = count($norm) -1;
        $x = 0;
        while ($size >= $factor && $x < $count) { 
          $size /= $factor; 
          $x++;
        } 
        $size = sprintf("%01.2f", $size) . ' ' . $norm[$x];
        return $size; 
    }
    
    static public function getMemoryUsage($realUsage = false)
    {
        return memory_get_usage($realUsage);
    }
    
    static public function formatSql($sql)
    {
        return preg_replace('/\b(UPDATE|SET|SELECT|FROM|AS|LIMIT|ASC|COUNT|DESC|WHERE|LEFT JOIN|INNER JOIN|RIGHT JOIN|ORDER BY|GROUP BY|IN|LIKE|DISTINCT|DELETE|INSERT|INTO|VALUES)\b/', '<span class="weeDeveloperToolbarLogInfo">\\1</span>', $sql);
    }
    
    static public function getMediaUrl()
    {
    	return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);
    }
}