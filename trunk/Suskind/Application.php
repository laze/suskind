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
	 * The Süskind's loader, what defines autoload methods, etc...
	 *
	 * @var Suskind_Loader
	 */
	protected $loader;
	
	/**
	 * Application environment
	 *
	 * @var array
	 */
	protected $environment;

	/**
	 * The applicvation's registry where it stores every necessary informations, parsed config files.
	 *
	 * @var array
	 */
	protected $registry;

	public function __construct() {
		require_once('Loader.php');
		$this->loader = Suskind_Loader::getInstance();
	}

	public function run() {
	}
}

?>
