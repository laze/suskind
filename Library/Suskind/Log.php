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
 * Suskind Framework's general log handler.
 *
 * @category	Suskind
 * @package		Suskind
 * @subpackage	Log
 * @author		Balazs Ercsey <laze@laze.hu>
 * @license		http://www.opensource.org/licenses/gpl-3.0.html GPLv3
 * @link		http://code.google.com/p/suskind/
 * @since		0.1
 * @version		$Rev$
 */
class Suskind_Log {
	private $file = null;
	private $name = null;

    public function __construct($filename) {
		$this->name = Suskind_Loader::$paths['_ROOT'].DIRECTORY_SEPARATOR.'Log'.DIRECTORY_SEPARATOR.$filename.'_'.date('Ymd-His').'.log';
		$this->file = fopen($this->name, 'a');
	}

	public function __destruct() {
		if (!is_null($this->file)) fclose($this->file);
	}
	
	public function write($string) {
		fwrite($this->file, $string, strlen($string));
	}

	public function getPath() {
		return $this->name;
	}
}

?>
