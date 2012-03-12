<?php
class CA_Smspremium_Helper_Data extends Mage_Core_Helper_Abstract
{
	/*Me parece interesante poner estas funciones en el HELPER, aunque en este caso no sea una asociación entre la
	 * bbdd y la apariencia visual. La otra opción es ponerla en el controller que es donde la usa, pero prefiero ponerlas aquí para
	* poder reutilizarla en diferentes sitios.*/
	
	public function filterPostData($data)
	{
		$data = $this->filterDatesCustom($data, array('fecha_disponibilidad'));
		return $data;
	}
	
	public function filterDatesCustom($array, $dateFields)
	{
		if (empty($dateFields)) {
			return $array;
		}
	
		foreach ($dateFields as $dateField) {
			if (array_key_exists($dateField, $array) && !empty($dateField)) {
				$array[$dateField] = $this->LocalizedToNormalized($array[$dateField]);
				$array[$dateField] = $this->NormalizedToLocalized($array[$dateField]);
			}
		}
		return $array;
	}
	public function LocalizedToNormalized($value)
	{
		if (substr(Mage::app()->getLocale()->getLocaleCode(),0,2)!='en') {
			$dateFormatIso = Mage::app()->getLocale()->getDateFormat(
					Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
			);
		} else {
			$dateFormatIso = Mage::app()->getLocale()->getDateFormat(
					Mage_Core_Model_Locale::FORMAT_TYPE_LONG
			);
		}
	
		$_options = array(
				'locale'      => Mage::app()->getLocale()->getLocaleCode(),
				'date_format' => $dateFormatIso,
				'precision'   => null
		);
		return Zend_Locale_Format::getDate($value, $_options);
	}
	
	public function NormalizedToLocalized($value)
	{
	#require_once 'Zend/Date.php';
	$date = new Zend_Date($value, Mage::app()->getLocale()->getLocaleCode());
	return $date->toString('yyyy-MM-dd');
	}
}