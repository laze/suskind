<?php
/**
 * License
 */

/**
 * Suskind_Resource_Session_Store class
 *
 * @package     Suskind
 * @package     Session
 * @author		Balazs Ercsey <laze@laze.hu>
 * @license     http://www.opensource.org/licenses/gpl-3.0.html GPLv3
 * @link        http://code.google.com/p/suskind
 * @since       0.1
 * @version
 */
class Suskind_Resource_Session_Store implements Suskind_Resource_Session_Interface {
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
        $this->path = (strlen($path) > 0) ? $path : $_ENV['PATH_SYSTEM'].DIRECTORY_SEPARATOR.'Suskind'.DIRECTORY_SEPARATOR.'Log';
	}

	public function setName($name) {
		;
	}

	public function read() {
		return (string) @file_get_contents($this->path.'/sess_'.Suskind_Fountain::SESSION_ID);
	}

	public function write($sessionData) {
 		if ($fp = @fopen($this->path.'/sess_'.Suskind_Fountain::SESSION_ID, 'w')) {
			$return = fwrite($fp, $sessionData['encodedData']);
			fclose($fp);
			return $return;
		} else throw new Suskind_Exception_File_PermissionDenied($this->path.'/sess_'.Suskind_Fountain::SESSION_ID);
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
