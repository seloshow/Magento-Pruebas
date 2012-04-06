<?php
//class Nofrills_Booklayout_Block_Youtube extends Mage_Core_Block_Abstract implements Mage_Widget_Block_Interface
/*Tambien podemos hacerlo que extienda del Bloque de tipo template*/
class Nofrills_Booklayout_Block_Youtube extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface
{
// 	protected function _toHtml()
// 	{
		
		
		/*Primer caso, en el que no se le pasa ningún parámetro*/
// 		return '<object width ="640" height ="505" >
// 		<param name ="movie"
// 		value ="http://www.youtube.com/v/dQw4w9WgXcQ?fs=1&amp;hl=en_US">
// 		</param>
// 		<param name ="allowFullScreen" value ="true"></param>
// 		<param name ="allowscriptaccess" value ="always"></param>
// 		<embed src ="http://www.youtube.com/v/dQw4w9WgXcQ?fs=1&amp;hl=en_US"
// 		type ="application/x-shockwave-flash"
// 		allowscriptaccess ="always" allowfullscreen ="true"
// 		width ="640" height ="505"> </embed></object>';

		/*Segundo caso: en el que capturamos un parámetro*/
		//$this ->setVideoId('dQw4w9WgXcQ');
// 		return '
// 		<object width ="640" height ="505" >
// 		<param name ="movie" value ="http://www.youtube.com/v/'.
// 		$this->getVideoId().
// 		'?fs=1&amp;hl=en_US"></param>
// 		<param name="allowFullScreen" value ="true"></param>
// 		<param name ="allowscriptaccess" value ="always"></param>
// 		<embed src ="http://www.youtube.com/v/'.
// 		$this->getVideoId().
// 		'?fs=1&amp;hl=en_US"
// 		type="application/x-shockwave-flash"allowscriptaccess="always"'.
// 		'allowfullscreen="true" width="640" height="505"></embed>
// 		</object>';
// 	}
}