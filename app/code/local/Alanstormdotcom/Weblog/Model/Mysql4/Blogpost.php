<?php
class Alanstormdotcom_Weblog_Model_Mysql4_Blogpost extends Mage_Core_Model_Mysql4_Abstract{
    
	protected function _construct()
    {
        $this->_init('weblog/blogpost', 'blogpost_id');//el primer parámeto es usado para identificar el Model. 
        //El segundo parámetro es el campo en la BBDD que es una columna de identificación única.
    }   
}