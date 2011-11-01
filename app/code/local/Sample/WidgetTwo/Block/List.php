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
 * Widget which displays the social bookmarking services list
 *
 * @category    Sample
 * @package     Sample_WidgetTwo
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Sample_WidgetTwo_Block_List
    extends Mage_Core_Block_Template
    implements Mage_Widget_Block_Interface
{

    /**
     * A model to serialize attributes
     * @var Varien_Object
     */
    protected $_serializer = null;

    /**
     * Initialization
     */
    protected function _construct()
    {
        $this->_serializer = new Varien_Object();
        parent::_construct();
    }

    /**
     * Produces links list html
     *
     * @return string
     */
    protected function _toHtml()
    {
        $html = '';
        $config = $this->getData('enabled_services');
        if (empty($config)) {
            return $html;
        }
        $services = explode(',', $config);
        $list = array();
        foreach ($services as $service) {
            $item = $this->_generateServiceLink($service);
            if ($item) {
                $list[] = $item;
            }
        }
        $this->assign('list', $list);
        return parent::_toHtml();
    }

    /**
     * Generates link attributes
     *
     * The method return an array, containing any number of link attributes,
     * All values are optional
     * array(
     *  'href' => '...',
     *  'title' => '...',
     *  '_target' => '...',
     *  'onclick' => '...',
     * )
     *
     * @param string $service
     * @return array
     */
    protected function _generateServiceLink($service)
    {
        /**
         * Page title
         */
        $pageTitle = '';
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $pageTitle = $headBlock->getTitle();
        }

        /**
         * Current URL
         */
         $currentUrl = $this->getUrl('*/*/*', array('_current' => true, '_use_rewrite' => true));

        /**
         * Link HTML
         */
        $attributes = array();
        $icon = '';
        switch ($service) {
            case 'digg':
                $attributes = array(
                    'href'  => 'http://www.digg.com/submit?url=' . rawurlencode($currentUrl) . '&amp;phase=2',
                    'title' => 'You Digg?',
                );
                $icon = 'digg.gif';
                break;
            case 'delicious':
                $attributes = array(
                    'href'  => 'http://del.icio.us/post?url=' . rawurlencode($currentUrl),
                    'title' => 'Add to del.icio.us',
                    'onclick'   => 'window.open(\'http://del.icio.us/post?v=4&amp;noui&amp;jump=close&amp;url='
                        . rawurlencode($currentUrl) . "&amp;title=" . rawurlencode($pageTitle)
                        . "','delicious', 'toolbar=no,width=700,height=400'); return false;",
                );
                $icon = 'delicious.gif';
                break;
            case 'twitter':
                $attributes = array(
                    'href'      => 'http://twitter.com/home?status='
                        . rawurlencode('Currently reading ' . $pageTitle . ' at ' . $currentUrl ),
                    'title'     => 'Tweet This!',
                    'target'    => '_blank',
                );
                $icon = 'twitter.gif';
                break;
            default:
                return array();
                break;
        }

        $item = array(
            'text' => $attributes['title'],
            'attributes' => $this->_serializer->setData($attributes)->serialize(),
            'image' => $this->getSkinUrl("images/" . $icon),
        );

        return $item;
    }

}
