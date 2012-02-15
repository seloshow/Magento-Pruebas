<?php
class Nofrills_Booklayout_LayoutdemoController extends Mage_Core_Controller_Front_Action
{
	public function _initLayout()
		{
			$layout = Mage::getSingleton('core/layout');			
			$layout->addOutputBlock('root');
			
			$additional_head = $layout->createBlock('nofrills_booklayout/template','additional_head')
									  ->setTemplate('simple-page/head.phtml');
			//var_dump($additional_head->getTemplateFile());

			$sidebar = $layout->createBlock('nofrills_booklayout/template','sidebar')
							  ->setTemplate('simple-page/sidebar.phtml');

			$content = $layout->createBlock('core/text_list','content');//clase Mage_Core_Block_Test_List	
			//automatically render all child blocks that have been added to it.
			//Any block we add will be auto-matically rendered.	

			$root			= $layout->createBlock('nofrills_booklayout/template','root')
									->setTemplate('simple-page/2col.phtml')
									->insert($additional_head)
									->insert($sidebar)
									->insert($content);
			//var_dump($sidebar->getTemplateFile());
			
			return $layout;
		}
		public function indexAction()
		{
			
			$layout = $this->_initLayout();
			
			$text = $layout->createBlock('core/text','words');
			$text->setText('It was the best of times, it was the BLURST?! of times?');
			
			$content = $layout->getBlock('content');
			$content->insert($text);
			
			 //var_dump($text->toHtml());
			$layout->setDirectOutput(true);
			$layout->getOutput();
			
			exit;
		}
	
}