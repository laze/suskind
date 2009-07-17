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
			//- Include the Suskind_Loader class to define automatic loader methods.
		require_once $_ENV['PATH_SYSTEM'].'/Suskind/Loader.php';
		$this->loader = Suskind_Loader::getInstance();
		$this->system = Suskind_System::getInstance();
	}

	public function getRoute() {
		$this->system->router->parseRoute();
	}

	public function initApplication(Suskind_Application $application) {
		$this->render = $this->setRender();
//		$this->resources = $this->setResources();

		if ($this->system->router->parseRoute()) {
			$application->model = $this->system->router->getModel();
			$application->view = $this->system->router->getView();
		} else {
			call_user_func($this->system->router->getModel());
		}
	}

	public function renderApplication() {
		if (!Suskind_System::isAjax()) $this->render->setTemplate();
			//- At least... :)
		$this->render->show();
	}

	private function setRender() {
		if (Suskind_System::isAjax()) return new Suskind_Render_Json();
		else return new Suskind_Render_Html();
	}
}

?>