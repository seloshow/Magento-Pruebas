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

class Wee_DeveloperToolbar_Block_Toolbar_Item_Profiler extends Wee_DeveloperToolbar_Block_Toolbar_Item
{
    public function __construct($name, $label = '')
    {
        parent::__construct($name, $label);
        $this->setIcon(Mage::helper('wee_developertoolbar')->getMediaUrl().'wee_developertoolbar/profiler.png');
        $this->_content = new Wee_DeveloperToolbar_Block_TabContainer_Profiler('profiler');
    }
}