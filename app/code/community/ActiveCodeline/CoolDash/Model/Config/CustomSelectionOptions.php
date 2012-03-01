<?php

class ActiveCodeline_CoolDash_Model_Config_CustomSelectionOptions extends Mage_Core_Model_Config_Data
{
    /**
     * Xml config path to value of samplefield1fromgroup1 field from system.xml
     *
     */
    const XML_PATH_COOLDASH_GROUP1_VALUES = 'samplesection1/samplegroup1/samplefield1fromgroup1';
    
    const OPTION1_VALUE = 0;
    const OPTION2_VALUE = 1;
    const OPTION3_VALUE = 2;
    const OPTION4_VALUE = 3;
    const OPTION5_VALUE = 4;

    public function getSomeValueFromSystemConfigFile()
    {
        return Mage::getStoreConfig(self::XML_PATH_COOLDASH_GROUP1_VALUES);
    }

    /**
     * Fills the select field with values
     * 
     * @return array
     */
    public function toOptionArray()
    {
    	
    	/**
    	 * 
    	 * If we were to choose "Cool custom value 4" from admin backend then 
    	 * var_dump would result in "3" which is the value of const OPTION4_VALUE. 
    	 * 
    	 */
    	//var_dump($this->getSomeValueFromSystemConfigFile());
    	
    	
        return array(            
            self::OPTION1_VALUE => Mage::helper('somecooldashhelper1')->__('Cool custom value 1'),
            self::OPTION2_VALUE => Mage::helper('somecooldashhelper1')->__('Cool custom value 2'),
            self::OPTION3_VALUE => Mage::helper('somecooldashhelper1')->__('Cool custom value 3'),
            self::OPTION4_VALUE => Mage::helper('somecooldashhelper1')->__('Cool custom value 4'),
            self::OPTION5_VALUE => Mage::helper('somecooldashhelper1')->__('Cool custom value 5'),
        );
    }
}
