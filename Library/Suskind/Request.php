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
 * Request handler parse the request's every parameters, is it secure, or not,
 * or is it came via AJAX or not, and also creates a Suskind_Router class, to
 * compile the request.
 *
 * @category	Suskind
 * @package		Suskind
 * @subpackage	Request
 * @author		Balazs Ercsey <laze@laze.hu>
 * @license		http://www.opensource.org/licenses/gpl-3.0.html GPLv3
 * @link		http://code.google.com/p/suskind/
 * @see			Suskind_Router
 * @since		0.1
 * @version		$Rev$
 */
class Suskind_Request
{
	/**
	 *
	 * @var string $method			Request's method.
	 */
	private $method;

	/**
	 *
	 * @var boolean $ajax			True if the request came via AJAX, false if not.
	 */
	private $ajax;

	/**
	 *
	 * @var boolean $secure			True if request came via HTTPS.
	 */
	private $secure;

	/**
	 *
	 * @var Suskind_Router $router	The router parser.
	 */
	private $router;

	/**
	 *
	 * @var array $uri				The request URI parsed into array.
	 */
	private $uri;

	public function __construct() {
		$this->secure = $this->checkSecure();
		$this->method = $_SERVER['REQUEST_METHOD'];
		$this->ajax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
		$this->uri = array_values(array_diff(explode('/', $_SERVER['REQUEST_URI']), explode(DIRECTORY_SEPARATOR, substr(getcwd(), 1))));
		$this->router = new Suskind_Router($this->uri);
	}

	/**
	 * Checks security settings, and protocols, and forbidden IP, etc.
	 *
	 * @return boolean				True, if the request is secure, false, if not.
	 */
	private function checkSecure() {
		//- First, get the security configuration:
		$security = Suskind_Loader::loadConfiguration('Security.yml')->asArray();
		/**
		 * @todo We should check the IP with possibilities of semi-regular
		 * expressions, for example, * for every number in a province, or
		 * [1-45] for limitations.
		 */
		if (!sizeof($security)) return array_key_exists('HTTPS', $_SERVER);
		if (is_array($security['default']['restricted']) && in_array($_SERVER['REMOTE_ADDR'], $security['default']['restricted'])) throw Suskind_Exception::HttpAccessForbidden();
		if ($security['default']['is_secure'] && !array_key_exists('HTTPS', $_SERVER)) header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		if (!$security['default']['is_secure'] && array_key_exists('HTTPS', $_SERVER)) header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		else return array_key_exists('HTTPS', $_SERVER);
	}

	/**
	 * Returns with the private $ajax property.
	 *
	 * @return boolean
	 */
	public function isAjax() {
		return $this->ajax;
	}

	/**
	 *
	 * @return string			The name of the requested module.
	 */
	public function module() {
		return $this->router->getParam('module');
	}

	/**
	 *
	 * @return string			The name of the requested action.
	 */
	public function action() {
		return $this->router->getParam('action');
	}
}