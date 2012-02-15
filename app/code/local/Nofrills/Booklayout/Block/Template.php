<?php
	class Nofrills_Booklayout_Block_Template extends Mage_Core_Block_Template
	{
// 		public function setScriptPath($dir)
// 		{
// 			parent::setScriptPath($dir); 	//if anything important happens up there in a future version
// 			$this->_viewDir = Mage::getModuleDir('', 'Nofrills_Booklayout') . DS . 'design';
// 			return $this; 					//as the original 
// 		}

	    public function fetchView($fileName)			    
	    {	    	
	    	//ignores file name, just uses a simple include with template name
			$this->setScriptPath(Mage::getModuleDir('', 'Nofrills_Booklayout') . DS . 'design');			
	    	return parent::fetchView($this->getTemplate());
	    }

	}	
	