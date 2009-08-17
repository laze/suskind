<?php

/**
 * License
 */

/**
 * Suskind_Resource_Remote class
 *
 * @package     Suskind
 * @package     Resources
 * @author		Balazs Ercsey <laze@laze.hu>
 * @license     http://www.opensource.org/licenses/gpl-3.0.html GPLv3
 * @link        http://code.google.com/p/suskind
 * @since       0.1
 * @version
 */
class Suskind_Resource_Remote extends Suskind_Resource_Resource {
	/**
	 * PHP' inside resource pointer.
	 *
	 * @var object
	 */
	protected $connector;

	/**
	 * The DSN specifies the path to given resource.
	 *
	 * @var string
	 */
	protected $dsn;

	/**
	 * It's a readonly property, handled by the __get overload function.
	 * Returns true, if the resource is connected, false if not.
	 *
	 * @var boolean
	 */
	protected $connected;

	/**
	 * Host name.
	 *
	 * @var string
	 */
	protected $host;

	public function setHost(string $host) {
		$this->host = $host;
	}

	/**
	 * Connect to the
	 */
	public function connect() {
		$this->open();
	}

	/**
	 * Disconnect from the resource.
	 *
	 * @return void
	 */
	public function disconnect() {
		$this->close();
	}
}

?>