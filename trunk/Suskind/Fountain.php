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

	private $system;

	public function __construct() {
		require_once 'Loader.php';
		$this->loader = Suskind_Loader::getInstance();
		
		$this->system = Suskind_System::getInstance();
	}
}
?>
