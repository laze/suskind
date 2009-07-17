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
		'info' => 'Suskind_System::getPHPinfo()'
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

	/**
	 * Parses the request URI. If something wrong, then throw an error, normally
	 * return with true, if an application's model called, false if any system
	 * related.
	 *
	 * @return boolean
	 */
	public function parseRoute() {
		$this->request = array_diff(split( '[\?\/]', $_SERVER['REQUEST_URI']), split( '[\?\/]', $_SERVER['SCRIPT_NAME']));
			//- Check in routes to replace request if neccesary.
		$routersMatch = array_intersect(array_values($this->request), array_keys($this->routes));
		if (sizeof($routersMatch) > 0) $this->request = split( '[\?\/]', $this->routes[$routersMatch[0]]);
		if (class_exists($this->request[0])) return (is_subclass_of($this->request[0], 'Suskind_Model'));
		else {
			/**
			 * @todo Throw an "invalid module called" exception in the new valid
			 * SF Excepttion system.
			 */
			throw new Suskind_Exception();
		}
	}

	/**
	 * Checks the
	 *
	 * @return Suskind_Model
	 */
	public function getModel() {
		return $this->request[0];
	}

	public function getView() {
//		if (method_exists($object, $method_name))
	}
}

?>
