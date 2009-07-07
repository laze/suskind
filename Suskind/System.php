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
		$this->buildRegistry();
		$this->setEnvironment();
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
		if(!is_a($this->registry, 'Suskind_Registry')) $this->registry = new Suskind_Registry();
	}

	private function setEnvironment() {
		if($this->registry->checkGroup('application.debug') === true) foreach ($this->registry->getGroup('system') as $varname => $value) ini_set($varname, $value);
	}
}

?>