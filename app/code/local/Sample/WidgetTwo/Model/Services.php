<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category    Sample
 * @package     Sample_WidgetTwo
 * @copyright   Copyright (c) 2009 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */


/**
 * Source model for the social bookmarking widget configuration
 *
 * @category    Sample
 * @package     Sample_WidgetTwo
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Sample_WidgetTwo_Model_Services
{

    /**
     * Provides a value-label array of available options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'digg', 'label' => 'Digg'),
            array('value' => 'delicious', 'label' => 'Delicious'),
            array('value' => 'twitter', 'label' => 'Twitter'),
        );
    }

}
