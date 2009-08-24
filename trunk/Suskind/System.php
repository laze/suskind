<?php

/**
 * License
 */

/**
 * Description of Loader
 *
 * @author Balazs Ercsey <laze@laze.hu>
 */
final class Suskind_System {
	const SESSION_ID = 'SUSKINDSESSID';
    /**
     * @var Suskind_Loader Singleton instance
     */
    private static $instance;
	/**
	 * The registry, what stores every settings of the application and
	 * runtime settings for the server. (php.ini)
	 *
	 * @var Suskind_Registry
	 */
	private $registry;

	/**
	 * This object will able to recognize URLs.
	 *
	 * @var Suskind_Router
	 */
	private $router;


	/**
	 * Constructor
	 *
	 * Registers instance with spl_autoload stack
	 *
	 * @return void
	 */
	protected function __construct() {
;

//		Suskind_Session_Session::start();
	}

	/**
	 * Retrieve singleton instance
	 *
	 * @return Suskind_Loader
	 */
	public static function getInstance() {
		if (null === self::$instance) self::$instance = new self();
		return self::$instance;
	}

	/**
	 * Reset the singleton instance
	 *
	 * @return void
	 */
	public static function resetInstance() {
		self::$instance = null;
	}

	private function setEnvironment() {

	}

	public static function isAjax() {
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
	}

	public static function getPHPinfo() {
		phpinfo();
	}

	public function getModel() {
		var_dump($this->router->getModel());

	}

	public function getView() {
		return false;
	}

	public function getRegistry() {
		return $this->registry->getApplicationSettings();
	}
}

?>
