<?php

/**
 * License
 */

/**
 * Description of Loader
 *
 * @author Balazs Ercsey <laze@laze.hu>
 */
final class Suskind_Application {
	/**
	 * Application environment
	 *
	 * @var array
	 */
	private $environment;
	
	/**
	 * The Süskind Fountain. This is the most important thing in the whole system.
	 * 
	 * @var Suskind_Fountain 
	 */
	private $fountain;

	public function __construct() {
		if (SUSKIND_SYSTEM_RUN !== true) {
			require_once 'Fountain.php';
			$this->fountain = new Suskind_Fountain();

		}

		var_dump(SUSKIND_SYSTEM_RUN);
	}

	public function run() {
	}
}

?>
