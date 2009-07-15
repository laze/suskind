<?php

/**
 * License
 */

/**
 * Suskind_Resource_Interface interface
 *
 * @package     Suskind
 * @package     Render
 * @author		Balazs Ercsey <laze@laze.hu>
 * @license     http://www.opensource.org/licenses/gpl-3.0.html GPLv3
 * @link        http://code.google.com/p/suskind
 * @since       0.1
 * @version
 */
class Suskind_Render_Html extends Suskind_Render_Render {
	/**
	 * Path to template to 
	 * @var string 
	 */
	private $template;

	public function setTemplate($filename) {
		if (!file_exists($filename)) throw new Suskind_Render_Exception('Template not exists! ('.$filename.')',1111);
	}

	public function show() {
		
	}

	public static function showError(Suskind_Exception $exception) {
		ob_get_clean();
		/**
		 * @todo Same method as show() to render template
		 */
		echo('<pre>');
		var_dump($exception);
		echo('</pre>');
	}
}

?>
