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
	 * Retrieve singleton instance
	 *
	 * @return Suskind_Router
	 */
	public static function getInstance() {
		if (null === self::$instance) self::$instance = new self();
		return self::$instance;
	}

	public function parseRoute() {
		var_dump($_SERVER['REQUEST_URI']);
		$this->requestURI = split( '[\?\/]', $_SERVER['REQUEST_URI']);
		var_dump($this->requestURI);
		/*
		$this->requestURI->clean();
		$this->requestURI->compare( new result( explode( '/', dirname( $_SERVER['PHP_SELF'] ) ) ), RESULT_COMPARE_REMOVE );
		return;
		 *
		 */
	}
}

?>
