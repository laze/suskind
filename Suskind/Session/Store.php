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
class Suskind_Session_Store extends Suskind_Resource_File {
	public function __construct($host, $name) {
		$this->host = $host;
		$this->name = $name;
	}
	public function destroy() {
		return (true);
	}
}

?>
