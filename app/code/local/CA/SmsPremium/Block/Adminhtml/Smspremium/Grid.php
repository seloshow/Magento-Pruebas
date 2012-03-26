<?php
class CA_Smspremium_Block_Adminhtml_Smspremium_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function _prepareCollection(){
		/*Vamos a crear los campos que futuramente va a almacenar, pero aun no los vamos a tomar de la BBDD
		 * por comodidad y ver como queda y tener algunos datos de ejemplo*/
		/*Creamos los datos de ejemplo*/
		$thing_1 = new Varien_Object();
		$thing_1->setCampaignId(1)
				->setNumReg(200)
				->setNombreLista('Lista de chicas')
				->setFechaCreacion('2012-03-14')
				->setDescripcion('Descripción de la primera lista')
				->setNameList('SMS_linstachicas_388232.csv');
		
		$thing_2 = new Varien_Object();
		$thing_2->setCampaignId(2);
		$thing_2->setNumReg(200);
		$thing_2->setNombreLista('Lista de chicos');
		$thing_2->setFechaCreacion('2012-03-13');
		$thing_2->setDescripcion('Descripción de la segunda lista');
		$thing_2->setNameList('SMS_linstachicos_384562.csv');
		
		$thing_3 = new Varien_Object();
		$thing_3->setCampaignId(3);
		$thing_3->setNumReg(200);
		$thing_3->setNombreLista('Lista de compradores');
		$thing_3->setFechaCreacion('2012-03-12');
		$thing_3->setDescripcion('Descripción de la tercera lista');
		$thing_3->setNameList('SMS_linstacompradores_198232.csv');
		
		$collectionDemo= new Varien_Data_Collection();
		$collectionDemo->addItem($thing_1)
						->addItem($thing_2)
						->addItem($thing_3);
		/* Fin de los datos de ejemplo*/
		
		$this->setCollection($collectionDemo);
		return parent::_prepareCollection();
		
	}
	
	/*@davidselo: Otro metodo que tenemos que reescrubur es el de _prepareColums() en el cual indicaremos como se tienen que mostrar el 
	 * collection que configuramos en _prepareCollection()*/
	public function _prepareColumns(){
		/*Para el campo de id*/
		$this->addColumn('campaign_id', array(
				'header'    => Mage::helper('smspremiumhelper')->__('id'),
				'align'     => 'left',
				'index'     => 'campaign_id',
				'type'      => 'text',
				
		));
		
		/*Para el campo de número de registros*/
		$this->addColumn('nombre_lista', array(
				'header'    => Mage::helper('smspremiumhelper')->__('Nombre de la lista'),
				'index'     => 'nombre_lista',
				'type'      => 'text',
		
		));
		
		/*Para el campo de número de registros*/
		$this->addColumn('num_reg', array(
				'header'    => Mage::helper('smspremiumhelper')->__('numero registros'),
				'index'     => 'num_reg',
				'type'      => 'text',
		
		));
		/*Campo con el nombre de la lista*/
		$this->addColumn('name_list', array(
				'header'    => Mage::helper('smspremiumhelper')->__('id'),
				'align'     => 'left',
				'index'     => 'name_list',
				'type'      => 'text',
		
		));
		
		/*Para el campo de fecha de creación, este campo es interesante para saber la antiguedad de la lista*/
		$this->addColumn('fecha_creacion', array(
				'header'    => Mage::helper('smspremiumhelper')->__('Fecha Creación'),
				'align'     => 'left',
				'width'     => '135px',
				'type'      => 'datetime',
				'default'   => '--',
				'index'     => 'fecha_creacion',
		));
		/*Campo con la descripción de la lista*/
		$this->addColumn('descripcion', array(
				'header'    => Mage::helper('smspremiumhelper')->__('Descripción'),
				'align'     => 'left',
				'index'     => 'descripcion',
				'type'      => 'text',
		
		));
		
		
		
		parent::_prepareColumns();
	}
}