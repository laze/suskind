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
	 * @var Suskind_Registry|null	The configurations of the Suskind_Router class. It sets by the constructor.
	 */
	private $registry = null;

	/**
	 * This variable stores the actually parsed routing directive. It's null by
	 * deafult, but it will an array what is parsing from Routing.yml file.
	 *
	 * @var array|null				The actually routing rules.
	 */
	private $directive = null;

	/**
	 *
	 * @var array					The keywords to parse routing URLs.
	 */
	private $param = array(
		'module',
		'action'
	);

	/**
	 * Construction of the Router.
	 *
	 * @param array $uri	The optional request URI, what is parsed in an array by the framework, if it's exits
	 */
	public function __construct($uri = null) {
		$this->registry = Suskind_Loader::loadConfiguration('Routing.yml');
		if (is_array($uri)) $this->setDirective($uri);
		else $this->directive = $this->getDirective(self::DIRECTIVE_HOME);
	}

	public function setDirective($uri) {
		$this->directive = $this->getDirectiveByRequest();
		if (is_null($directive)) $this->directive = $this->getDirectiveByUri($uri);
	}

	private function getDirectiveByRequest() {
		return null;
	}

	/**
	 * Try to find the right compiler for the directive, based on request's URI.
	 *
	 * @param array $url	The parsed request URI as it forwarded by the setDirective method.
	 * @return null|array	Returns with the directive if it's found, or null, if not found anything.
	 */
	private function getDirectiveByUri(array $uri) {
		foreach ($this->registry->asArray() as $directive_name => $directive) {
			/**
			 * The exact URL is exists in the directive.
			 */
			if (implode('/', $uri) == $directive['url']) return $directive;

			/**
			 * Parse advanced URLs...
			 */
			$uri_parse = array_diff(explode('/', $directive['url']), $uri);
			/**
			 * @todo Maybe we should do it faster, stronger, more nice, later,
			 * but now it works.
			 */

			if (sizeof($uri_parse) > 1) {
				(array) $param = (array_key_exists('param', $directive)) ? array_diff($this->param, array_keys($directive['param'])) : $this->param;

				if (sizeof($param) > 0) {
					foreach ($param as $mode) {
						$index = array_search(':'.$mode, explode('/', $directive['url']));
						if ($index) {
							$directive['param'][$mode] = $uri[$index];
							unset($uri_parse[$index]);
						}
					}
				}
			}

			/**
			 * The possible end of the URL, the star character.
			 */
			if (sizeof($uri_parse) == 1 && in_array('*', $uri_parse) == true) {
				$directive['param']['param'] = array_slice($uri, array_search('*', explode('/', $directive['url'])));
				return $directive;
			}
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
