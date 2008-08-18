<?php

class fountain {
	private static $instance = false;

	/**
	 * 
	 * @return 
	 */
	function getInstance() {
		if ( self::$instance === false ) self::$instance = new fountain();
		return self::$instance;
	}

	public function __clone() {
		throw new Exception( 'Clone is not allowed.', E_USER_ERROR );
	}

	/**
	 * @classDescription
	 */
	private function __construct() {
	}
}
