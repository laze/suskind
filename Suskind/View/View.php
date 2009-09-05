<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of General
 *
 * @author Balazs Ercsey <laze@laze.hu>
 */
class Suskind_View_View implements Suskind_View_Interface {
	private $render;
	protected $class = null;

	public function __construct() {
		$this->render = Suskind_Render_Factory::createRender();
		if ($this->class !== null) $this->render->setTemplate(str_replace('Application', $_ENV['PATH_APPLICATION'].DIRECTORY_SEPARATOR.'Assets'.DIRECTORY_SEPARATOR.'Templates', str_replace('_', DIRECTORY_SEPARATOR, $this->class)).'.html');
	}

	/**
	 * Compile template, and returns with the 'rendered' content, what is
	 * a string, usually.
	 * 
	 * @return string 
	 */
	public function compile() {
		return $this->render->compile();
	}

	/**
	 * Displays the compiled template.
	 *
	 * @param bool $force Cleans output buffer before show, or not. Optional.
	 */
	public function show(bool $force = null) {
		if ($force === true) ob_end_clean();
		echo $this->compile();
	}
}
?>
