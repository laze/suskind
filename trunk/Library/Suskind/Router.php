<?php

/**
 * Suskind Framework
 *
 * LICENSE
 *
 * This source file is a subject of the GPLv3 that is bundled with this package
 * in the file License.txt
 * It is also available at this URL:
 * http://www.opensource.org/licenses/gpl-3.0.html
 */

/**
 * Loader class for handling autoloaders.
 *
 * @category	Suskind
 * @package		Suskind
 * @subpackage	Router
 * @author		Balazs Ercsey <laze@laze.hu>
 * @license		http://www.opensource.org/licenses/gpl-3.0.html GPLv3
 * @link		http://code.google.com/p/suskind/
 * @since		0.1
 * @version		$Rev$
 */
class Suskind_Router
{
	/**
	 * This variable stores the contents of the different configuration files.
	 * It gets two configuration files, a common and an application related.
	 * Actually the application related has privileges.
	 *
	 * @var Suskind_Registry		The configurations of the Suskind_Router class.
	 */
	private $registry = null;

	public function __construct() {

		$this->registry = new Suskind_Registry(array(
			Suskind_Loader::$paths[Suskind_Loader::DIR_APP].'/Configuration/Routing.yml',
			Suskind_Loader::$paths['_ROOT'].'/Configuration/Routing.yml'
		));
		$_SERVER['REQUEST_URI'] = implode('/', array_diff(explode('/', $_SERVER['REQUEST_URI']), explode(DIRECTORY_SEPARATOR, getcwd())));
		var_dump($_SERVER['REQUEST_URI']);
	}
}

?>
