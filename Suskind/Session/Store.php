<?php
/**
 * License
 */

/**
 * Suskind_Session_Store class
 *
 * @package     Suskind
 * @package     Session
 * @author		Balazs Ercsey <laze@laze.hu>
 * @license     http://www.opensource.org/licenses/gpl-3.0.html GPLv3
 * @link        http://code.google.com/p/suskind
 * @since       0.1
 * @version
 */
class Suskind_Session_Store implements Suskind_Resource_Session {

	public function __get(string $name) {
	}

	public function setEnvironment() {
		var_dump(get_object_vars(Suskind_Session_Session));
	}

	public function setHost(string $host) {
		;
	}

	public function connect() {
		;
	}

	public function disconnect() {
		;
	}
	
	public function destroy() {
		return (true);
	}
}

?>
