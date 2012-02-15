<?php
# File:app/code/local/Nofrills/Booklayout/Block/Helloworld.php
class Nofrills_Booklayout_Block_Helloworld extends Mage_Core_Block_Template
{
	/*@davidselo: Este método constructor es diferente al método constructor de PHP.
	 * Con esta llamada aseguramos que todo bloque Nofrills_Booklayout_Block_Helloworld
	 * va a tener un template asociado.
	 * */
	public function _construct()
	{
		$this ->setTemplate('nofrills/helloworld.phtml');
		return parent::_construct();
	}
	public function _beforeToHtml()
	{
		$block_1= new Mage_Core_Block_Text();
		$block_1->setText('The first sentence.');
		$this->setChild('the_first',$block_1);
		$block_2= new Mage_Core_Block_Text();
		$block_2->setText('The second sentence .');
		$this->setChild('the_second', $block_2);
	}
	public function fetchTitle()
	{
		return 'Hello Fancy World ';
	}
}