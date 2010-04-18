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
	protected $render;
	protected $preferedLayout = null;

	public function __construct($className = null) {
		$this->render = Suskind_Render_Factory::createRender();
		if (!is_null($className)) $this->render->setTemplate(str_replace('Application', Suskind_Registry::getApplicationSettings(Suskind_Registry::CKEY_PATH).DIRECTORY_SEPARATOR.'Assets'.DIRECTORY_SEPARATOR.'Templates', str_replace('_', DIRECTORY_SEPARATOR, $className)).'.html');
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

	/**
	 * Set the prefered layout of the given view.
	 *
	 * @param string $layout The layout to be the default layout of this view.
	 * @return void;
	 */
	public function setPreferedLayout($layout) {
		if (class_exists($layout, true)) $this->preferedLayout = $layout;
	}

	/**
	 * Get the prefered layout of the given view.
	 *
	 * @return Suskind_View_Layout Returns with the prefered layout or null if it is not set yet.
	 */
	public function getPreferedLayout() {
		return $this->preferedLayout;
	}
}
?>
