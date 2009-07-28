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
		$this->registry = Suskind_Registry::getInstance();
		$this->setEnvironment();
		
		$this->router = Suskind_Router::getInstance();
		$this->router->parseRoute();

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
		if($this->registry->checkKey(__CLASS__) === true) foreach ($this->registry->getSettings(__CLASS__) as $varname => $value) ini_set($varname, $value);

		session_set_save_handler(array('Suskind_Session_Session', 'open'), array('Suskind_Session_Session', 'close'), array('Suskind_Session_Session', 'read'), array('Suskind_Session_Session', 'write'), array('Suskind_Session_Session', 'destroy'), array('Suskind_Session_Session', 'garbageCollector'));
		session_name($this->registry->)
session_start();

		$_SESSION['visit'] ++;

		var_dump($_SESSION);
	}

	public static function isAjax() {
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
	}

	public static function getPHPinfo() {
		phpinfo();
	}
}

?>
