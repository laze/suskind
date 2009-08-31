<?php

/**
 * License
 */

/**
 * Suskind_View_Static_Default class.
 *
 * @package     Suskind
 * @package     View
 * @author		Balazs Ercsey <laze@laze.hu>
 * @license     http://www.opensource.org/licenses/gpl-3.0.html GPLv3
 * @link        http://code.google.com/p/suskind
 * @since       0.1
 * @version
 */
class Suskind_View_Static_Default implements Suskind_View_Static_Interface {
	private $render;

	public function  __construct() {
		$this->render = new Suskind_Render_Html();
		$this->render->setTemplate($_ENV['PATH_SYSTEM'].DIRECTORY_SEPARATOR.'Suskind'.DIRECTORY_SEPARATOR.'Assets'.DIRECTORY_SEPARATOR.'Templates'.DIRECTORY_SEPARATOR.'Framework'.DIRECTORY_SEPARATOR.'Default.html');
	}

	public function show() {
		$this->render->show();
	}
}

?>