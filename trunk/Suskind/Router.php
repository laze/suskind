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
	private $originalRequestURI;
	
	private $referrerRequestURI;
	
	private $forwardRequestURI;

	private $model;
	private $view;


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

	/**
	 * Parses the request URI. If something wrong, then throw an error, normally
	 * return with true, if an application's model called, false if any system
	 * related.
	 *
	 * @return void
	 */
	public function parseRoute() {
		$this->referrerRequestURI = (array_key_exists('HTTP_REFERER', $_REQUEST) && isset ($_REQUEST['HTTP_REFERER'])) ? array_values(array_diff(split( '[\?\/]', $_SERVER['HTTP_REFERER']), split( '[\?\/]', $_SERVER['SCRIPT_NAME']))) : null;
		$this->originalRequestURI = array_values(array_diff(split( '[\?\/]', $_SERVER['REQUEST_URI']), split( '[\?\/]', $_SERVER['SCRIPT_NAME'])));
			//- Check in routes to replace request if neccesary.
		$routersMatch = array_values(array_intersect(array_values($this->originalRequestURI), array_keys($this->routes)));
		if (sizeof($routersMatch) > 0) $this->originalRequestURI = split( '[\?\/]', $this->routes[$routersMatch[0]]);
			/**
			 * Sets the model and the view, if they avaliable. The parser set
			 * these variables to null, if no value given. Later, if view is
			 * null, then has to get the model's default view.
			 *
			 * If there are neither valid model nor valid view, then throw an
			 * exception.
			 */
		if (class_exists($this->originalRequestURI[0])) {
			if (is_subclass_of($this->originalRequestURI[0], 'Suskind_Model')) {
				$this->model = $this->originalRequestURI[0];
				$this->view = (is_subclass_of($this->originalRequestURI[1], 'Suskind_View')) ? $this->originalRequestURI[1] : null;
			} else {
				$this->model = null;
			}
		} else throw new Suskind_Exception_Router_NotValidModel($this->originalRequestURI[0]);
		var_dump($this->originalRequestURI);
	}

	/**
	 * Returns with the current request URI.
	 * 
	 * @return array
	 */
	public function getRoute() {
		var_dump( $this->originalRequestURI);
		return $this->originalRequestURI;
	}

	/**
	 * Returns with the previously parsed model.
	 *
	 * @return Suskind_Model
	 * @see parseRoute
	 */
	public function getModel() {
		return $this->model;
	}

	/**
	 * Returns with the previously parsed view.
	 *
	 * @return Suskind_View
	 * @see parseRoute
	 */
	public function getView() {
		return $this->view;
	}
}

?>
