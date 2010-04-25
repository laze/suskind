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
	 * @var string $method		Request's method.
	 */
	public $method;
	/**
	 *
	 * @var boolean $ajax		Is the request came via AJAX or not?
	 */
	public $ajax;

	public function __construct() {
		$this->method = $_SERVER['REQUEST_METHOD'];
		$this->ajax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
		var_dump($this);
		var_dump($_SERVER);
		$router = new Suskind_Router();
	}

	public function isAjax() {

	}
}