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
 * @package     Sample_WidgetOne
 * @copyright   Copyright (c) 2009 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */


/**
 * Delicious link widget
 *
 * @category    Sample
 * @package     Sample_WidgetOne
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Sample_WidgetOne_Block_Delicious
    extends Mage_Core_Block_Abstract
    implements Mage_Widget_Block_Interface
{

    /**
     * Produces delicious link html
     *
     * @return string
     */
    protected function _toHtml()
    {
        $pageTitle = '';
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $pageTitle = $headBlock->getTitle();
        }

        $html = '<a class="delicious" href="'
            . 'http://del.icio.us/post?url='
            . $this->getUrl('*/*/*', array('_current' => true, '_use_rewrite' => true))
            . '" onclick="window.open(\'http://del.icio.us/post?v=4&amp;noui&amp;jump=close&amp;url=\'+encodeURIComponent(\''
            . $this->getUrl('*/*/*', array('_current' => true, '_use_rewrite' => true))
            . "')+'&amp;title='+encodeURIComponent('"
            . $pageTitle
            . "'),'delicious', 'toolbar=no,width=700,height=400'); return false;"
            . '" title="Add to del.icio.us">Del.icio.us</a>';

        return $html;
    }

}
