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
	const DIRECTIVE_DEFAULT	= 'default';
	const DIRECTIVE_MODULE	= 'default_index';
	const DIRECTIVE_HOME	= 'homepage';
	

	/**
	 * This variable stores the contents of the different configuration files.
	 * It gets two configuration files, a common and an application related.
	 * Actually the application related has privileges.
	 *
	 * @var Suskind_Registry	The configurations of the Suskind_Router class.
	 */
	private $registry = null;

	private $directive = null;

	public function __construct($uri = null) {
		$this->registry = Suskind_Loader::loadConfiguration('Routing.yml');
		if (is_array($uri)) $this->setDirective($uri);
	}

	public function setDirective($uri) {
		if (sizeof($uri) == 0) $this->directive = $this->getDirective(self::DIRECTIVE_HOME);
		if (!is_null($this->getDirectiveByUrl(implode('/', $uri)))) $this->directive = $this->getDirectiveByUrl(implode('/', $uri));
		if (sizeof($uri) == 1 && is_null($this->directive)) $this->directive = $this->getDirective(self::DIRECTIVE_MODULE);
		if (is_null($this->directive)) $this->directive = $this->getDirective(self::DIRECTIVE_DEFAULT);
	}

	private function getDirectiveByUrl($url) {
		foreach ($this->registry->asArray() as $directive) {
			if ('/'.$url == $directive['url']) return $directive;
		}
		return null;
	}

	/**
	 * Get the selected routing directive if its exists.
	 *
	 * @param string $directive		The name of the routing directive.
	 * @return null|array Null, if not exists, or the directive array if exists.
	 */
	public function getDirective($directive) {
		$directives = $this->registry->asArray();
		return (array_key_exists($directive, $directives)) ? $directives[$directive] : null;
	}

	/**
	 * Searchin for a parameter.
	 *
	 * @param string $key		Search key in param's array.
	 * @return null|string		Param's array value of "name" key...
	 */
	public function getParam($key) {
		return (is_array($this->directive['param']) && array_key_exists($key, $this->directive['param'])) ? $this->directive['param'][$key] : null;
	}

}

?>
