<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Plugin
 *
 * @author laze
 */
class Suskind_Render_Plugins_Template_Lite implements Suskind_Render_Interface {
	/**
	 * The object, what is defined in the registry. This object
	 * @var object
	 */
	private $engine;
	private $cache = 'suskind';

	/**
	 * The path to template file.
	 * 
	 * @var string
	 */
	private $template;

	public function __construct() {
		$this->engine = new Template_Lite();
		/**
		 * Setting up the Template Lite engine.
		 */
		$this->engine->left_delimiter = '<:';
		$this->engine->right_delimiter =':>';
		$this->engine->cache = true;
		$this->engine->template_dir = $_ENV['PATH_APPLICATION'].DIRECTORY_SEPARATOR.'Assets'.DIRECTORY_SEPARATOR.'Templates';
		$this->engine->cache_dir = $_ENV['PATH_APPLICATION'].DIRECTORY_SEPARATOR.'Assets'.DIRECTORY_SEPARATOR.'Templates'.DIRECTORY_SEPARATOR.'Cached';
		$this->engine->compile_dir = $_ENV['PATH_APPLICATION'].DIRECTORY_SEPARATOR.'Assets'.DIRECTORY_SEPARATOR.'Templates'.DIRECTORY_SEPARATOR.'Compiled';
		/**
		 * Assigning default variables.
		 */
		$this->engine->assign('application', Suskind_Registry::getSettings('Suskind_Application'));
	}

	public function assign($variableName, $variableValue, $variableModification = null) {
		$this->engine->assign($variableName, $variableValue);
	}

	public function remove($variableName) {
		$this->engine->clear_assign($variableName);
	}

	public function compile() {
		return $this->engine->fetch($this->template, $this->cache);
	}

	public function setTemplate($fileName) {
		if (file_exists($fileName)) $this->template = $fileName;
		else throw new Suskind_Exception(Suskind_Exception_File::NotExists($fileName));
	}

}

?>
