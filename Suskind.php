<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Suskind
 *
 * @author laze
 */
class Suskind {
	/**
	 *
	 * @var Suskind_Request
	 * @static
	 */
	public $request;

	/**
	 *
	 * @var Suskind
	 * @static
	 */
	private static $instance = null;

	private function __construct() {
		$this->request = new Suskind_Request();
	}

	public static function getInstance() {
		if (!is_a(self::$instance, __CLASS__)) self::$instance = new Suskind();
		return self::$instance;
	}

    public static function Application() {
		$suskind = self::getInstance();

		return new Suskind_Application($suskind->registry);
	}
}
?>
