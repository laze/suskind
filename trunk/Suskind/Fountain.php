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
     * @var Suskind_Fountain Singleton instance
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
		if (!isset (self::$instance)) self::$instance = new Suskind_Fountain();
		return self::$instance;
	}

	private function __construct() {
		try {	
			if (is_array(Suskind_Registry::getServerSettings())) foreach (Suskind_Registry::getServerSettings() as $variable => $value) {
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

	public function compile($show = false) {
		if ($show === false) return $this->layout->compile();
		else $this->layout->show();
	}

	public function getApplicationLayout(Suskind_View_Layout $layout) {
		return $this->layout;
	}

	public function setApplicationLayout(Suskind_View_Layout $layout) {
		$this->layout = $layout;
	}

	public function initControl($control = null) {
		$className = null;

		if (is_null($this->router->getControl())) {
			if (!is_null($control)) $className = 'Application_Control_'.ucfirst($control);	
		} else $className = 'Application_Control_'.ucfirst($this->router->getControl());
		
		if (!is_null($className)) $this->control = new $className;
	}

	public function initLayout($preferedLayout = null) {
		if (!is_null($this->router->getView())) {
			$view = call_user_func(array($this->control,$this->router->getView()));
			$preferedLayout = $view->getPreferedLayout();
		}
		if (!is_null($preferedLayout) && class_exists($preferedLayout)) $this->layout = new $preferedLayout;
		else $this->layout = new Suskind_View_Static_Default();
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