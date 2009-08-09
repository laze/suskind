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
	/**
	 * Path to the session file.
	 * @var string 
	 */
	private $path;

	public function __get(string $name) {
	}

	public function setEnvironment(array $parameters) {
		$this->setPath($parameters[0]);
		$this->name = $parameters[1];
	}

	public function setPath($path) {
		$this->path = $path;
	}

	public function setName($name) {
		;
	}

	public function setId($id) {
		;
	}

	public function getId() {
		;
	}

	public function read() {
	
	}

	public function write($data) {
		
	}

	public function open() {
		;
	}

	public function close() {
		;
	}
	
	public function destroy() {
		return (true);
	}
}

?>
