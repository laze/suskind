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
	 *
	 * @var Suskind_View_Layout
	 */
	private $layout;

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
		if (is_null($this->router->getControl())) {
			if (is_null($this->router->getMethod()) && !class_exists($this->getApplicationLayout())) call_user_func(array(__CLASS__, $this->getDefaultLayout()));
			elseif (is_null($this->router->getMethod()) && class_exists($this->getApplicationLayout())) return array(
				'Suskind_Application',
				$this->getApplicationLayout()
			);
		} else {
			if ($this->router->getControl() !== __CLASS__) return array(
				$this->router->getControl(),
				(!is_null($this->router->getMethod())) ? $this->router->getMethod() : self::DEFAULT_VIEW
			);
			else call_user_func(array(__CLASS__,$this->router->getMethod()));
		}
	}

	private function getDefaultLayout() {
		echo('deflay');
	}

	public function getApplicationLayout(Suskind_View_Layout $layout) {
		return $this->layout;
	}

	public function setApplicationLayout(Suskind_View_Layout $layout) {
		$this->layout = $layout;
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