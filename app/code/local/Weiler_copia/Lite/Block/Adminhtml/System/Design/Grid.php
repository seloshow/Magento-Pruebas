<?php

/**
 * Design changes grid
 */
class Weiler_Lite_Block_Adminhtml_System_Design_Grid extends Mage_Adminhtml_Block_System_Design_Grid
{

    /**
     * Define grid columns
     *
     * @return Mage_Adminhtml_Block_System_Design_Grid
     */
    protected function _prepareColumns()
    {
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'        => Mage::helper('catalog')->__('Store'),
                'width'         => '100px',
                'type'          => 'store',
                'store_view'    => true,
                'sortable'      => false,
                'index'         => 'store_id',
            ));
        }

        $this->addColumn('package', array(
                'header'    => Mage::helper('catalog')->__('Design'),
                'width'     => '150px',
                'index'     => 'design',
        ));
        
        //lite: catalogrule to core helper
        $this->addColumn('date_from', array(
            'header'    => Mage::helper('core')->__('Date From'),
            'align'     => 'left',
            'width'     => '100px',
            'type'      => 'date',
            'index'     => 'date_from',
        ));
        //

        $this->addColumn('date_to', array(
            'header'    => Mage::helper('core')->__('Date To'),
            'align'     => 'left',
            'width'     => '100px',
            'type'      => 'date',
            'index'     => 'date_to',
        ));

        //lite:
        //return parent::_prepareColumns();
        $this->sortColumnsByOrder();
        return $this;
        //
    }

}
