<?php

/**
 * License
 */

/**
 * Suskind_Resource_Interface interface
 *
 * @package     Suskind
 * @package     Resources
 * @author		Balazs Ercsey <laze@laze.hu>
 * @license     http://www.opensource.org/licenses/gpl-3.0.html GPLv3
 * @link        http://code.google.com/p/suskind
 * @since       0.1
 * @version
 */
abstract class Suskind_Resource_Abstrat {
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
	 * It's a readonly property, handled by the __get overload function. Returns true, if the resource is connected, false if not.
	 *
	 * @var boolean
	 */
	protected $connected;

	/**
	 * @var string The driver's name.
	 */
	protected $driver;

	/**
	 * Host name.
	 *
	 * @var string
	 */
	protected $host;

	/**
	 * Port number.
	 *
	 * @var integer
	 */
	protected $port;
	
	/**
	 * The name of the user.
	 *
	 * @var string
	 */
	protected $user;

	/**
	 * The password of the user.
	 *
	 * @var string
	 */
	protected $password;

	/**
	 * Oveload function to get properties.
	 *
	 * @param string $name
	 */
	public function __get(string $name) {
	}

	public function setDriver(string $driver) {
		$this->driver = Suskind_Loader::
	}

	public function setHost(string $host) {
		$this->host = $host;
	}

	public function setPort(int $port) {
		$this->port = $port;
	}

	public function setUser(string $user) {
		$this->user = $user;
	}

	/**
	 * Set the private DSN property from the previously set informations.
	 */
	final private function createDSN() {
		$driver = ($this->driver) ? $this->driver.'://' : '';
		if($this->user) {
			if($this->password) $user = $this->user.':'.$this->password;
			else $user = $this->user;
		} else $user = '';
		if($this->host) $host = ($user) ? '@'.$this->host : $this->host;
		else throw new Resoource_Exception(ERROR_SUSKIND_RESOURCE_NO_HOST); //- There is no host to connect, throw an error.
		$this->dsn = preg_replace(array(
			'driver',
			'user',
			'host'
		), array(
			$driver,
			$user,
			$host
		), 'driveruserhost');
	}

	/**
	 * Connect to the
	 */
	public function connect() {
	}

	/**
	 * Disconnect from the resource.
	 *
	 * @return void
	 */
	public function disconnect() {
	}
}

?>
