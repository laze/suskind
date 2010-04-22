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
 * Router class handling the browser requests. This class parses the PHP's
 * $_SERVER['REQUEST_URI'] and - by using some configuration files - try to set
 * the callable user module.
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
	 * Directives' definitions.
	 * - DEFAULT describes, how will be recognized a regular request, what
	 *   is usually /module/method/everything_else
	 * - MODULE describes what router should do if only the module's name given
	 *   in the request.
	 * - HOME describes if nothing given in the query.
	 */
	const DIRECTIVE_DEFAULT = 'default';
	const DIRECTIVE_MODULE = 'module';
	const DIRECTIVE_HOME = 'homepage';
	

	/**
	 * This variable stores the contents of the different configuration files.
	 * It gets two configuration files, a common and an application related.
	 * Actually the application related has privileges.
	 *
	 * @var Suskind_Registry	The configurations of the Suskind_Router class.
	 */
	private $registry = null;

	private $request = array();

	public function __construct() {
		$this->registry = new Suskind_Registry(array(
			Suskind_Loader::$paths[Suskind_Loader::DIR_APP].'/Configuration/Routing.yml',
			Suskind_Loader::$paths['_ROOT'].'/Configuration/Routing.yml'
		));
		$this->parse();
	}

	private function parse() {
		$this->request = array_values(array_diff(explode('/', $_SERVER['REQUEST_URI']), explode(DIRECTORY_SEPARATOR, getcwd())));
		var_dump($this->request);
		if (sizeof($this->request) == 0) { //- HOME

		}
	}
}

?>
