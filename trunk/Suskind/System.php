<?php

/**
 * License
 */

/**
 * Description of Loader
 *
 * @author Balazs Ercsey <laze@laze.hu>
 */
final class Suskind_System {
    /**
     * @var Suskind_Loader Singleton instance
     */
    private static $instance;

	private $registry;

	const SUSKIND_SYSTEM_RUN = true;

	/**
	 * Constructor
	 *
	 * Registers instance with spl_autoload stack
	 *
	 * @return void
	 */
	protected function __construct() {
		self::buildRegistry();
	}

	/**
	 * Retrieve singleton instance
	 *
	 * @return Suskind_Loader
	 */
	public static function getInstance() {
		if (null === self::$instance) self::$instance = new self();
		return self::$instance;
	}

	/**
	 * Reset the singleton instance
	 *
	 * @return void
	 */
	public static function resetInstance() {
		self::$instance = null;
	}

	private function buildRegistry() {
		$this->registry = new Suskind_Registry();
	}

	/**
	 *
	 * @return Suskind_Registry
	 */
	public static function getRegistry() {
		return $this->registry;
	}

	public static function checkResourceDriver() {
		;
	}
}

?>