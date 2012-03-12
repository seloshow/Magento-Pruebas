<?php
/**
 * @author @davidselo
 * @description 	En esta clase es donde vamos a definir el formulario. Vamos a ir describiendo los diferentes pasos
 * que se van realizando. Bajo la carpeta Tab vamos a tener el tab en concreto que queremos tener disponible cuando pulsemos sobre
 * 
 * PASO 1: nuestra clase container tiene heredar de la clase Form, en este caso Mage_Adminhtml_Block_Widget_Form
 * */
class CA_Smspremium_Block_Adminhtml_Smspremium_Edit_Tab_Segmentacion extends Mage_Adminhtml_Block_Widget_Form
{
	/*PASO 2: crear un objeto de tipo Form y asignarlo a nuestro container*/
	public function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);	
		
		/*PASO 3: Creamos un fielset*/
		$fieldset = $form->addFieldset('smspremium_segmentacion', array('legend'=>Mage::helper('smspremiumhelper')->__('Informacion de la segmentacion')));
		
		/*PASO 4: Añadimos los campos necesarios*/
		
		/*Campo reservado para el nombre*/
		$field = $fieldset->addField('smspremium_name', 'text', array(
				'label'     => Mage::helper('smspremiumhelper')->__('Nombre'),
				'name'      => 'smspremium_name',
				'class'     => 'required-entry',
				'required'  => true,
		));
		
		$field = $fieldset->addField('smspremium_apellido', 'text', array(
				'label'     => Mage::helper('smspremiumhelper')->__('Apellido'),
				'name'      => 'smspremium_apellido',
				'class'     => 'required-entry',
				'required'  => true,
		));
		
		
		/*Para no tener problemas con las franjas horarias de cada localización*/
		
		if (substr(Mage::app()->getLocale()->getLocaleCode(),0,2)!='en') {
			$dateFormatIso = Mage::app()->getLocale()->getDateFormat(
					Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
			);
		} else {
			$dateFormatIso = Mage::app()->getLocale()->getDateFormat(
					Mage_Core_Model_Locale::FORMAT_TYPE_LONG
			);
		}
		
		/*Ahora el campo destinado a almacenar la hora de disponibilidad*/
		$fieldset->addField('hora_desponibilidad', 'time', array(
				'name'      => 'hora_disponibilidad',
				'label'     => Mage::helper('smspremiumhelper')->__('Hora de Disponibilidad'),
				'required'  => true,
				'required'  => false,
		));
		
		/*Otro campo para poner la fecha de disponibilidad*/
		$fieldset->addField('fecha_disponibilidad', 'date', array(
				'name'      => 'fecha_disponibilidad',
				'label'     => Mage::helper('smspremiumhelper')->__('Fecha de disponibilidad'),
				'image'     => $this->getSkinUrl('images/grid-cal.gif'),
				'class'     => 'required-entry',
				'required'  => true,
				'format'    => $dateFormatIso
		));
		
		return parent::_prepareForm();
	}
	
}