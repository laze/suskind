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
interface Suskind_Resource_Interface {

	/**
	 * Oveload function to get properties.
	 *
	 * @param string $name
	 */
	public function __get(string $name);

	public function setDriver(string $driver);

	public function setHost(string $host);

	public function setPort(int $port);

	public function setUser(string $user);

	/**
	 * Set the private DSN property from the previously set informations.
	 */
	final private function createDSN();

	/**
	 * Connect to the
	 */
	public function connect();
	
	/**
	 * Disconnect from the resource.
	 *
	 * @return void
	 */
	public function disconnect();
}

?>
