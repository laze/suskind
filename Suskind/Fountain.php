<?php
/* 
 * License.
 */

/**
 * Description of Suskind_Fountain
 *
 * @author Balazs Ercsey <laze@laze.hu>
 */
final class Suskind_Fountain {
	/**
	 * The Süskind's loader, what defines autoload methods, etc...
	 *
	 * @var Suskind_Loader
	 */
	private $loader;

	/**
     * The Süskind system hadler object. It controls the registry, server
     * settings, etc.
     * 
     * @var Suskind_System 
     */
    private $system;

	/**
	 * This property implementation can be any class what extends
	 * Suskind_Render_Render, like HTML render or JSON render.
	 *
	 * @var Suskind_Render_Render
	 */
	public $render;

	public function __construct() {
		try {
				//- Include the Suskind_Loader class to define automatic loader methods.
			require_once $_ENV['PATH_SYSTEM'].'/Suskind/Loader.php';
			$this->loader = Suskind_Loader::getInstance();
			$this->system = Suskind_System::getInstance();
				/**
				 * Parses the route, to decide, run the application or not.
				 */
				 /*
			$this->system->router->parseRoute();
			if (!is_null($this->system->router->getModel())) $this->setApplication();
			else $this->executeSystemRequest();
				  * 
				  */
		} catch (Suskind_Exception $exception) {
			echo($exception->getMessage());
		}
	}

	public function initApplication(Suskind_Application $application) {
		$application->setModel($this->system->getModel());
		$application->setView($this->system->getView());

		$this->render = $this->setRender();

		return (is_null($this->system->getView())) ? $this->renderPlatformDefaultView() : $application->compileView();
	}

	public function renderApplication() {
		if (!Suskind_System::isAjax()) $this->render->setTemplate();
			//- At least... :)
		$this->render->show();
	}

	public function renderPlatformDefaultView() {
		
	}

	public static function renderApplicationDefaultView() {
	}

	private function executeSystemRequest() {
		$request = $this->system->router->getRoute();
		if (sizeof($request)) call_user_method($request[1], $request[0]);
	}

	private function setRender() {
		if (Suskind_System::isAjax()) return new Suskind_Render_Json();
		else return new Suskind_Render_Html();
	}
}

?>