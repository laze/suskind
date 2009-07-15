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
	private $request;

	/**
	 * The configured routes. Routes can be short a query or can be used for any
	 * else reserved request in the URI, e.g.: dashboard, debug, etc...
	 *
	 * @var array
	 */
	private $routes = array(
		'info' => 'Suskind_System/getPHPinfo'
	);

	/**
	 * Retrieve singleton instance
	 *
	 * @return Suskind_Router
	 */
	public static function getInstance() {
		if (null === self::$instance) self::$instance = new self();
		return self::$instance;
	}

	private function __construct() {
		if(Suskind_Registry::checkKey('routes') === true) $this->routes = array_merge(Suskind_Registry::getSettings('routes'), $this->routes);
	}

	public function parseRoute() {
		$this->request = array_diff(split( '[\?\/]', $_SERVER['REQUEST_URI']), split( '[\?\/]', $_SERVER['SCRIPT_NAME']));
			//- Check in routes to replace request if neccesary.
		$routersMatch = array_intersect(array_values($this->request), array_keys($this->routes));
		if (sizeof($routersMatch) > 0) $this->request = split( '[\?\/]', $this->routes[$routersMatch[0]]);
	}
}

?>
