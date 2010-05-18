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
 * @subpackage	Application
 * @author		Balazs Ercsey <laze@laze.hu>
 * @license		http://www.opensource.org/licenses/gpl-3.0.html GPLv3
 * @link		http://code.google.com/p/suskind/
 * @since		0.1
 * @version		$Rev$
 */
class Suskind_Application
{
	protected $registry;
	
	protected $request;

	function __construct(Suskind_Request $request) {
		$this->registry = Suskind_Loader::loadConfiguration('Application.yml');
		$this->request = $request;
	}

	public function run() {
		call_user_func(array($this->request->module(), $this->request->action()), $this->request->vars());
		exit(Suskind::EXIT_SUCCESSFULL);
	}
}
?>
