<?php

class Inchoo_CoffeeFreak_Block_ShowTabsAdminBlock extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct()
    {
        parent::__construct();
        $this->setId('my_custom_freely_assigned_id_for_tabs');
        /*
         * By default DestElementId = 'content'... if you trace the function you will see.
         * Meaning, it responds to layout block name?! like "content", "footer", "left"... 
         * Its basicaly telling the layout where to output tabs canvas aka display area
         */
        //$this->setDestElementId('my_custom_edit_form');
        
        $this->setTitle(Mage::helper('coffefreakhelper1')->__('Custom CoffeeFreak_ShowTabs Block title here'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('custom_assigned_tab1_id_name', array(
            'label'     => Mage::helper('coffefreakhelper1')->__('Custom tab1 here'),
            'title'     => Mage::helper('coffefreakhelper1')->__('My custom tab1 title here'),
             'content'   => 'Some content here. We could add direct string here, or we can use something like $this->getLayout()->createBlock("adminhtml/cms_page_edit_tab_main")->toHtml()',  
           
        ));

        $this->addTab('custom_aka_freely_assigned_tab2_id_name', array(
            'label'     => Mage::helper('coffefreakhelper1')->__('Custom tab2 here'),
            'title'     => Mage::helper('coffefreakhelper1')->__('My custom tab2 title here'),
            'content'   => 'Another content here. As mentioned, we could add direct string here, or we can use something like $this->getLayout()->createBlock("adminhtml/cms_page_edit_tab_main")->toHtml()',
           
        ));
        /*@davidselo: podemos añadir bloques estáticos aquí.*/
        $this->addTab('custom_aka_freely_assigned_tab3_id_name', array(
            'label'     => Mage::helper('coffefreakhelper1')->__('Custom tab3 here<br />(usses class block)'),
            'title'     => Mage::helper('coffefreakhelper1')->__('My custom tab3 title here'),
            'content'   => $this->getLayout()->createBlock("coffefreakblock2/SampleBlockForTabAreaShowoff")->toHtml(),
           
        ));    

        $this->addTab('custom_aka_freely_assigned_tab4_id_name', array(
            'label'     => Mage::helper('coffefreakhelper1')->__('Custom tab4 here<br />(usses class block and external view file)'),
            'title'     => Mage::helper('coffefreakhelper1')->__('My custom tab4 title here'),
            'content'   => $this->getLayout()->createBlock("coffefreakblock1/SampleBlockForTabAreaShowoffWithExtraInfo")->toHtml(),
           
        ));       
        
        return parent::_beforeToHtml();
    }  
}