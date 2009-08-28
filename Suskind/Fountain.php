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
	const SESSION_ID = 'SUSKINDSESSID';
	/**
	 * The Süskind's loader, what defines autoload methods, etc...
	 *
	 * @var Suskind_Loader
	 */
	private $loader;

	/**
     * The Süskind registry hadler object. It controls the registry, server
     * settings, etc.
     * 
     * @var Suskind_Registry
     */
    private $registry;

	/**
	 * The Süskind request URI handler object.
	 *
	 * @var Suskind_Router
	 */
	private $router;

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
			require_once $_ENV['PATH_SYSTEM'].DIRECTORY_SEPARATOR.'Suskind'.DIRECTORY_SEPARATOR.'Loader.php';
			$this->loader = Suskind_Loader::getInstance();
			$this->registry = Suskind_Registry::getInstance();
			if ($this->registry->checkKey('Suskind_System') === true) foreach ($this->registry->getSettings('Suskind_System') as $variable => $value) ini_set($variable, $value);
				//- Starting session...
			Suskind_Session_Session::start();
				//- Get routes...
			$this->router = Suskind_Router::getInstance();
		} catch (Suskind_Exception $exception) {
			$exception->show();
		}
		return;
	}

	/**
	 * Execute static calls.s
	 *
	 * @param string $method
	 * @param mixed $arguments
	 * @return mixed
	 */
	public function  __callStatic($method, $arguments) {
		switch ($method) {
			case 'isAJAX':
				return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
				break;
			case 'getDefaultRender':
				return (self::isAjax()) ? new Suskind_Render_Json() : new Suskind_Render_Html();
				break;
			case 'getPHPInfo':
				phpinfo();
				break;
		}
	}

	/**
	 * Initializes an application.
	 * 
	 * @param Suskind_Application $application The applocation itself to initialize.
	 * @return Suskind_View_Static_Default
	 */
	public function initApplication(Suskind_Application $application) {
		if ($this->router->getModel() !== false) {
			$application->setModel($this->router->getModel());
			if ($this->router->getView() !== false) {
				$application->setView($this->router->getView());
				return $application->compileView();
			}
		}
		if ($application->getDefaultView() !== false) {
			$application->getDefaultView();
			return $application->compileView();
		} else return new Suskind_View_Static_Default();
	}

	public function renderApplication() {
		if (!Suskind_System::isAjax()) $this->render->setTemplate();
			//- At least... :)
		$this->render->show();
	}

	private function executeSystemRequest() {
		$request = $this->system->router->getRoute();
		if (sizeof($request)) call_user_method($request[1], $request[0]);
	}

	public function getApplicationSettings() {
		return Suskind_Registry::getApplicationSettings();
	}
}

?>