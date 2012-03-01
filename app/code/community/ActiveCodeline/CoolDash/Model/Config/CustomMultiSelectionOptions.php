<?php

class ActiveCodeline_CoolDash_Model_Config_CustomMultiSelectionOptions extends Mage_Core_Model_Config_Data
{
    /**
     * Xml config path to value of samplefield1fromgroup1 field from system.xml
     *
     */
    const XML_PATH_COOLDASH_GROUP3_VALUES = 'samplesection1/samplegroup3/samplefield1fromgroup3';
    
    const OPTION1_VALUE = 0;
    const OPTION2_VALUE = 1;
    const OPTION3_VALUE = 2;
    const OPTION4_VALUE = 3;
    const OPTION5_VALUE = 4;

    protected $_options;

    public function toOptionArray($isMultiselect)
    {
        if (!$this->_options) {
            $this->_options = $this->getMyOptions();
        }
        $options = $this->_options;
        return $options;
    }     
    
    public function getSomeValueFromSystemConfigFile()
    {
        return Mage::getStoreConfig(self::XML_PATH_COOLDASH_GROUP3_VALUES);
    }

    public function getMyOptions()
    {
    	
    	/**
    	 * 
    	 * If we were to choose "Cool custom value 4" from admin backend then 
    	 * var_dump would result in "3" which is the value of const OPTION4_VALUE. 
    	 * 
    	 */
    	//var_dump($this->getSomeValueFromSystemConfigFile());
    	
        return array(            
            array('value' => self::OPTION1_VALUE, 'label' => Mage::helper('somecooldashhelper1')->__('Cool custom multiselect value 1')),
            array('value' => self::OPTION2_VALUE, 'label' => Mage::helper('somecooldashhelper1')->__('Cool custom multiselect value 2')),
            array('value' => self::OPTION3_VALUE, 'label' => Mage::helper('somecooldashhelper1')->__('Cool custom multiselect value 3')),
            array('value' => self::OPTION4_VALUE, 'label' => Mage::helper('somecooldashhelper1')->__('Cool custom multiselect value 4')),
            array('value' => self::OPTION5_VALUE, 'label' => Mage::helper('somecooldashhelper1')->__('Cool custom multiselect value 5')),
        );
    }    
}
