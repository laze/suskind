<?php

/**
 * License
 */

/**
 * Description of Loader
 *
 * @author Balazs Ercsey <laze@laze.hu>
 */
class Suskind_Router {
    /**
     * @var Suskind_Router Singleton instance
     */
    private static $instance;

	/**
	 * The parsed request URI. It contains
	 * @var array
	 */
	private $requestURI;

	/**
	 * Retrieve singleton instance
	 *
	 * @return Suskind_Router
	 */
	public static function getInstance() {
		if (null === self::$instance) self::$instance = new self();
		return self::$instance;
	}

	public function parseRoute() {
		$this->requestURI = array_diff(split( '[\?\/]', $_SERVER['REQUEST_URI']), split( '[\?\/]', $_SERVER['SCRIPT_NAME']));
		
		if(Suskind_Registry::checkKey('routes') === true) $akarmi = Suskind_Registry::getSettings('routes');
		var_dump($akarmi);
	}
}

?>
