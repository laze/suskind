<?php

/**
 * License
 */

/**
 * Description of Loader
 *
 * @author Balazs Ercsey <laze@laze.hu>
 */
final class Suskind_Application {
	/**
	 * Application environment
	 *
 	 * @var array
	 */
	private $environment;
	
	/**
	 * The Süskind Fountain. This is the most important thing in the whole system.
	 * 
	 * @var Suskind_Fountain 
	 */
	private $fountain;

	/**
	 * The actually loaded model.
	 *
	 * @var Suskind_Model
	 */
	public $model;

	/**
	 * The called view.
	 *
	 * @var Suskind_View
	 */
	public $view;

    /**
     * @todo: Check wether is included via include_path or via regular path.
     */
    public function __construct() {
		ob_start();
			//- Set application and system paths.
		$_ENV['PATH_APPLICATION'] = realpath('..'.DIRECTORY_SEPARATOR);
		$_ENV['PATH_SYSTEM'] = realpath('..'.DIRECTORY_SEPARATOR.'Library'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR);
		$_ENV['URL'] = $_SERVER['SERVER_NAME'];

			//- Gets the Fountain, the most important class of the SF.
		require_once $_ENV['PATH_SYSTEM'].DIRECTORY_SEPARATOR.'Suskind'.DIRECTORY_SEPARATOR.'Fountain.php';
		$this->fountain = new Suskind_Fountain();
		$this->environment = Suskind_Registry::getApplicationSettings();
	}

	public function init() {
		return $this->fountain->initApplication($this);
	}

	public function setModel(Suskind_Model $model) {
		$this->model = $model;
	}

	public function setView(Suskind_View $view) {
		$this->view = $view;
	}

	public function getView() {
		return $this->view;
	}

	/**
	 * This method try to return with the default view of the application. First,
	 * try to get it from the registry, and if it not defined there, try to get
	 * from the filesystem.
	 * If not found any, returns with boolean false.
	 * 
	 * @return void Return boolean false if application view not set.
	 */
	public function getDefaultView() {
		try {
			if (array_key_exists('Suskind_Application_Views', $this->environment) && $this->environment['Suskind_Application_Views']['Default']) $this->view = $this->environment['Suskind_Application_Views']['Default'];
			else $this->view = new Application_View_Default();
		} catch (Suskind_Exception $exception) {
			$exception->show();
		}
	}
	
	public function compileView() {
		return $this->view;
	}
}

?>
