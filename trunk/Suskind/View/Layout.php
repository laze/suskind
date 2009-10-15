<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Layout
 *
 * @author bercsey
 */
class Suskind_View_Layout implements Suskind_View_Layout_Interface {
	protected $render;

	public function __construct($className = null) {
		$this->render = Suskind_Render_Factory::createRender();
		if (!is_null($className)) $this->render->setTemplate(str_replace('Application', Suskind_Registry::getApplicationSettings(Suskind_Registry::CKEY_PATH).DIRECTORY_SEPARATOR.'Assets'.DIRECTORY_SEPARATOR.'Templates', str_replace('_', DIRECTORY_SEPARATOR, $className)).'.html');
	}

	/**
	 * Compile template, and returns with the 'rendered' content, what is
	 * a string, usually.
	 *
	 * @return void
	 */
	public function compile() {
		$this->render->compile();
	}

	/**
	 * Displays the compiled template.
	 *
	 * @param bool $force Cleans output buffer before show, or not. Optional.
	 */
	public function show(bool $force = null) {
		if ($force === true) ob_end_clean();
		if ($this->render->compiled === false) $this->compile();
		$this->render->show();
	}
}
?>
