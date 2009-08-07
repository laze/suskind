<?php

/**
 * License
 */

/**
 * Suskind_Resource_Resource class
 *
 * @package     Suskind
 * @package     Resources
 * @author		Balazs Ercsey <laze@laze.hu>
 * @license     http://www.opensource.org/licenses/gpl-3.0.html GPLv3
 * @link        http://code.google.com/p/suskind
 * @since       0.1
 * @version
 */
class Suskind_Resource_Resource implements Suskind_Resource_Interface {
	/**
	 * The path of the local resource.
	 *
	 * @var string 
	 */
	protected $path;
	/**
	 * Oveload function to get properties.
	 *
	 * @param string $name
	 */
	public function __get(string $name) {
		return $this->$name;
	}

	public function setPath(string $path) {
		$this->path = $path;
	}

	/**
	 * Connect to the
	 */
	public function open() {
	}

	/**
	 * Disconnect from the resource.
	 *
	 * @return void
	 */
	public function close() {
	}
}

?>
