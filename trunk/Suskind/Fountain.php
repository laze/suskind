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
			$_ENV['URL'] = $_SERVER['SERVER_NAME'];
				//- Include the Suskind_Loader class to define automatic loader methods.
			require_once substr_replace(__FILE__, 'Loader.php', strrpos(__FILE__, DIRECTORY_SEPARATOR)+1);
			Suskind_Loader::init(array(
				'Application'	=> realpath(getcwd()),
				'Suskind'		=> realpath(substr(__FILE__, 0, strrpos(__FILE__, DIRECTORY_SEPARATOR)))
			));
			if (is_array(Suskind_Registry::getServer())) foreach (Suskind_Registry::getServer() as $variable => $value) {
				if (strtolower(substr($variable, 0, 7)) == 'php_ini') ini_set(substr($variable, 7), $value);
			}
				//- Starting session...
			Suskind_Session_Session::start();
				//- Get routes...
			$this->router = Suskind_Router::getInstance();
				//- Creating the application
		} catch (Suskind_Exception $exception) {
			$exception->show();
		}
	}

	public function compile() {
		$control = ($this->router->getControl()) ? $this->router->getControl() : 'Suskind_Application';
		if (is_null($this->router->getMethod()) && !class_exists('Application_View_Default')) {
			$control = __CLASS__;
			$method = (class_exists('Suskind_View_Default')) ? 'Suskind_View_Default' : 'Suskind_View_Static_Default';
		} else $method = $this->router->getMethod();


		echo(__CLASS__.' compile use: '.$control.'->'.$method);
		var_dump($control);
	}

	/**
	 * Show PHP info
	 * 
	 * @return void
	 */
	public static function getPHPInfo() {
		phpinfo();
	}
}

?>