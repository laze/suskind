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
	 *
	 * @var Suskind_Fountain
	 */
	private $fountain;

    /**
     * @todo: Check wether is included via include_path or via regular path.
     */
    public function __construct() {


		$this->fountain = Suskind_Fountain::getInstance();
    }

	public function init() {
		echo('me either');
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
			if (array_key_exists('Suskind_Application_Views', $this->environment) && $this->environment['Suskind_Application_Views']['Default']) return $this->environment['Suskind_Application_Views']['Default'];
			else if (class_exists('Application_View_Default', true)) return new Application_View_Default();
			else return new Suskind_View_Static_Default();
		} catch (Suskind_Exception $exception) {
			$exception->show();
		}
    }
	
	public function compileView() {
		return $this->view;
	}

	public function show() {
		try {
			$view = (!is_null($this->control)) ? $this->control->getView() : null;

			if (is_null($view))  $this->getDefaultView()->show();
			else $view->show();
		} catch (Suskind_Exception $exception) {
			$exception->show();
		}
	}

	public static final function run() {
		$pathToFountain = explode(DIRECTORY_SEPARATOR, __FILE__);
		$pathToFountain[count($pathToFountain)-1] = 'Fountain.php';
		require_once implode(DIRECTORY_SEPARATOR, $pathToFountain);
		$application = new Suskind_Application();
		$application->init();
	}
}

?>
