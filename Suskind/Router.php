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
	private $originalRequestURI = null;
	
	private $referrerRequestURI = null;
	
	private $control = null;

	private $view = null;

	private $parameters = null;


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
		if (is_array(Suskind_Registry::getApplicationSettings('routes'))) $this->routes = array_merge(Suskind_Registry::getApplicationSettings('routes'), $this->routes);
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
			//- Check in routes to replace request if neccesary.
		if (array_key_exists($this->originalRequestURI[0], $this->routes)) $this->originalRequestURI = array_merge(explode( '/', $this->routes[$this->originalRequestURI[0]]), array_slice($this->originalRequestURI, 1));
		if (count($this->originalRequestURI) > 0) {
			if ($this->originalRequestURI[0] == 'Assets') $this->getFile($this->originalRequestURI);
			else $this->control = $this->originalRequestURI[0];
		}
		if (count($this->originalRequestURI) > 1) $this->view = $this->originalRequestURI[1];
		if (count($this->originalRequestURI) > 2) $this->parameters = array_merge(array_slice($this->originalRequestURI, 2),$_REQUEST);
	}

	public function isRouteParsed() {
		return !is_null($this->originalRequestURI);
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
	 * @return string Returns with the controler part of the parsed request, or null if not exists.
	 * @see parseRoute
	 */
	public function getControl() {
		return $this->control;
	}

	/**
	 *
	 * @return string Returns with the method part of the parsed request, or null if not exists.
	 * @see parseRoute
	 */
	public function getView() {
		return $this->view;
	}

	/**
	 * Get a file from an array, what contains path. The array's items will glue
	 * with directory separator to read file.
	 *
	 * @param array $request The request, what is received, so this content the path to the file.
	 *
	 * @todo REMOVE FROM HERE!
	 */
	public function getFile(array $path) {
		$fileRequest = Suskind_Registry::getSystemSettings(Suskind_Registry::CKEY_PATH).DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR, $path);
			//- Sending file
		if (file_exists($fileRequest)){
			header('Content-type: '.mime_content_type($fileRequest));
			readfile($fileRequest);
		}
	}
}

?>
