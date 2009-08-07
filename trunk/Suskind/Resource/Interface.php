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

	public function setPath($path);

	/**
	 * Connect to the
	 */
	public function open();
	
	/**
	 * Disconnect from the resource.
	 *
	 * @return void
	 */
	public function close();
}

?>
