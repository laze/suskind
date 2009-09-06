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

	private $control;

	private $event;


	/**
	 * The configured routes. Routes can be short a query or can be used for any
	 * else reserved request in the URI, e.g.: dashboard, debug, etc...
	 *
	 * @var array
	 */
	private $routes = array(
		'info' => 'Suskind_Fountain/getPHPInfo'
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
		$this->parseRoute();
	}

	/**
	 * Parses the request URI. If something wrong, then throw an error, normally
	 * return with true, if an application's model called, false if any system
	 * related.
	 *
	 * @return void
	 */
	public function parseRoute() {
		list($url) = explode('?', $_SERVER['REQUEST_URI']);
		$this->referrerRequestURI = (isset ($_SERVER['HTTP_REFERER'])) ? array_values(array_diff(explode( '/', $_SERVER['HTTP_REFERER']), explode( '/', $_SERVER['SCRIPT_NAME']))) : null;
		$this->originalRequestURI = array_values(array_diff(explode( '/', $url), explode( '/', $_SERVER['SCRIPT_NAME'])));
		$this->forwardRequestURI = (isset ($_REQUEST['next'])) ? array_values(array_diff(explode( '/', $_REQUEST['next']), explode( '/', $_SERVER['SCRIPT_NAME']))) : null;
			//- Check in routes to replace request if neccesary.
		$routersMatch = array_values(array_intersect(array_values($this->originalRequestURI), array_keys($this->routes)));
		if (sizeof($routersMatch) > 0) $this->originalRequestURI = explode( '/', $this->routes[$routersMatch[0]]);
			/**
			 * Sets the model and the view, if they avaliable. The parser set
			 * these variables to null, if no value given. Later, if view is
			 * null, then has to get the model's default view.
			 *
			 * If there are neither valid model nor valid view, then throw an
			 * exception.
			 */
		if (sizeof($this->originalRequestURI) < 1) return false;
		try {
			if ($this->originalRequestURI[0] == 'Suskind_Fountain') call_user_func($this->originalRequestURI);
			if ($this->originalRequestURI[0] == 'sf') $this->getFile($this->originalRequestURI);
			$this->control = (class_exists('Application_Control_'.ucfirst($this->originalRequestURI[0]), true)) ? 'Application_Control_'.ucfirst($this->originalRequestURI[0]) : null;
			if (isset ($this->originalRequestURI[1])) $this->event = (!is_null($this->control)) ? $this->control->registerEvent($this->originalRequestURI[1]) : null;
			else $this->event = null;

			return true;
		} catch (Exception $excpetion) {
			/**
			 * @todo: Create a valid exception for this.
			 */
			throw new Suskind_Exception_Router_NotValidModel($this->originalRequestURI[0]);
		}
	}

	/**
	 * Returns with the current request URI.
	 * 
	 * @return array
	 */
	public function getRoute() {
		return $this->originalRequestURI;
	}

	/**
	 * Returns with the previously parsed control object.
	 *
	 * @return Suskind_Control
	 * @see parseRoute
	 */
	public function getControl() {
		return (!is_null($this->control)) ? new $this->control : false;
	}

	public function getEvent() {
		return (!is_null($this->event)) ? $this->event : false;
	}

	/**
	 * Get a file from an array, what contains path. The array's items will glue
	 * with directory separator to read file.
	 *
	 * @param array $request The request, what is received, so this content the path to the file.
	 */
	public function getFile(array $path) {
		$fileRequest = str_replace('sf', $_ENV['PATH_SYSTEM'].DIRECTORY_SEPARATOR.'Suskind'.DIRECTORY_SEPARATOR.'Assets', implode(DIRECTORY_SEPARATOR, $path));
			//- Sending file
		header('Content-type: '.mime_content_type($fileRequest));
		readfile($fileRequest);
	}
}

?>
