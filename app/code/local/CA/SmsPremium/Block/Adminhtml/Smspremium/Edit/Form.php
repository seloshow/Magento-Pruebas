<?php
class CA_smspremium_Block_Adminhtml_Smspremium_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm(){
		/*@davidselo: el id del formulario esta asociado posteriormente a la acción que vamos a desencadenar.
		 * Si por ejemplo quisieramos crear otra acción diferente a la que realiza el formulario de edit_form
		 * tendriamos que crear nuestro propio javascript. Es mejor que utilizamos lógica del edit_form.*/
		$form = new Varien_Data_Form(array(
				'id' => 'edit_form',
				'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
				'method' => 'post',
				'enctype' => 'multipart/form-data'
		)
		);
		/*@davidselo: me resulta interesante explicar como esta construida la url que le estamos pasando al formulario
		 * con la instrucción $this->getUrl(, la cual no pongo su interior dado que me cerraria el comentario. Así pues la 
		 * explico su contenido: el primer asterisco indica que vamos a obtener la url del módulo en el que estoy, con el segundo
		 * asterisco voy a indicar que es en el controller en el que estoy actualmente y lo último es el action que vamos a desencadenar
		 * que en este caso se save.
		 * */
		$form->setUseContainer(true);
		$this->setForm($form);
		return parent::_prepareForm();
	}
}