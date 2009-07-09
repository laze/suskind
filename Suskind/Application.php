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
			//- Set application and system paths.
		$_ENV['PATH_APPLICATION'] = realpath('../');
		$_ENV['PATH_SYSTEM'] = realpath('../Library/../');

			//- Gets the Fountain, the most important class of the SF.
		require_once $_ENV['PATH_SYSTEM'].'/Suskind/Fountain.php';

		$this->fountain = new Suskind_Fountain();

	}

	public function run() {
		$this->fountain->getRoute();
	}
}

?>
