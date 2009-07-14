<?php
/* 
 * License.
 */

/**
 * Description of Suskind_Fountain
 *
 * @author Balazs Ercsey <laze@laze.hu>
 */
final class Suskind_Fountain {
	/**
	 * The Süskind's loader, what defines autoload methods, etc...
	 *
	 * @var Suskind_Loader
	 */
	private $loader;

	/**
     * The Süskind system hadler object. It controls the registry, server
     * settings, etc.
     * 
     * @var Suskind_System 
     */
    private $system;

	public function __construct() {
			//- Include the Suskind_Loader class to define automatic loader methods.
		require_once $_ENV['PATH_SYSTEM'].'/Suskind/Loader.php';
		$this->loader = Suskind_Loader::getInstance();
		$this->system = Suskind_System::getInstance();
	}

	public function getRoute() {
		$this->system->router->parseRoute();
	}
}

?>