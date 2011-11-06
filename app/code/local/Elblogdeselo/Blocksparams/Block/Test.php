<?php
/**
 * 
 * Enter description here ...
 * @author davidselo
 * @twitter @davidselo
 * @category design
 * @desc podemos ver en este ejemplo que si heredamos de Mage_core_Block_Abstract tendríamos 
 * un bloque en el que su salida al ponerlo en cms mediante {{block type="blocksparams/test" name="bloque_con_parametros" nombre="david" apellidos="villalba flores"}}
 * o con <block ...> en el layout sería lo que imprime el método _toHtml, ademas de que en este método podemos capturar cualquier parámetro que le pasamos 
 * en la creación del bloque, en este caso le hemos pasado nombre y apellido y los recogemos con $this->getNombre() y con $this->getApellidos().Aunque le pongamos en la 
 * creación del bloque que contiene una plantilla no nos la va a mostrar por que no es un bloque destinado para ello, sin embargo si
 * extendemos de Mage_Core_Block_template automáticamente el template que le pongamos en el parámetro de creación será su salida html.
 *{{block type="blocksparams/test" name="bloque_con_parametros" nombre="david" apellidos="villalba flores" template="blocksparams/test.phtml"}}
 *tomará el template="blocksparams/test.phtml" como salida html.
 *Nota: el bloque Mage_core_Block_Template si creamos método _toHtml() prevalecerá sobre el template y mostrará ese html,esto es 
 *debido a que dicha clase extiende de Mage_Core_Block_template y tiene ese método heredado.
 *
 */
class Elblogdeselo_Blocksparams_Block_Test extends Mage_Core_Block_Abstract{
//class Elblogdeselo_Blocksparams_Block_Test extends Mage_Core_Block_Template{
	
	
	protected function _toHtml(){
		
		$nombre=$this->getNombre();
		$apellidos=$this->getApellidos();
		$html=$nombre." ".$apellidos;
		return $html;
	}
}