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
	 * @var string SESSION_ID The default session id for session handler.
	 */
	const SESSION_ID = 'SUSKINDSESSID';

    /**
     * @var Suskind_Loader Singleton instance
     */
    private static $instance;
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
	 * Retrieve singleton instance
	 *
	 * @return Suskind_Fountain
	 */
	public static function getInstance() {
		if (null === self::$instance) self::$instance = new self();
		return self::$instance;
	}

	private function __construct() {
		try {
				//- Set application and system paths.
			$_ENV['PATH_APPLICATION'] = realpath('..'.DIRECTORY_SEPARATOR);
			$_ENV['PATH_SYSTEM'] = realpath('..'.DIRECTORY_SEPARATOR.'Library'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR);
			$_ENV['URL'] = $_SERVER['SERVER_NAME'];

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
	}

	/**
	 * Show PHP info
	 * 
	 * @return void
	 */
	public static function getPHPInfo() {
		phpinfo();
	}

	/**
	 * Initializes an application.
	 * 
	 * @return Suskind_Application
	 */
	public function init() {
		try {
			return new Suskind_Application(array(
				'control'	=> ($this->router->getControl() !== false) ? $this->router->getControl() : null,
				'event'		=> ($this->router->getEvent() !== false) ? $this->router->getEvent() : null
			));
		} catch (Suskind_Exception $exception) {
			$exception->show();
		}
	}

	private function executeSystemRequest() {
		$request = $this->router->getRoute();
		if (sizeof($request)) call_user_method($request[1], $request[0]);
	}

	public function getApplicationSettings() {
		return Suskind_Registry::getApplicationSettings();
	}
}

?>