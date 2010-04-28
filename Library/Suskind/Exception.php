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
 * Loader class for handling autoloaders.
 *
 * @category	Suskind
 * @package		Suskind
 * @subpackage	Exception
 * @author		Balazs Ercsey <laze@laze.hu>
 * @license		http://www.opensource.org/licenses/gpl-3.0.html GPLv3
 * @link		http://code.google.com/p/suskind/
 * @since		0.1
 * @version		$Rev$
 */
class Suskind_Exception extends Exception
{
	public static function ClassStaticConstruct() {
		return new Suskind_Exception("NEMJÓÓÓÓ", 4120);
	}

	public static function ClassNotExists($class) {
		return new Suskind_Exception(sprintf('%s class not exists!', $class));
	}
	
	public static function FileNotExists($file) {
		return new Suskind_Exception(sprintf('File: %s not exists!', $file));
	}

	public static function FileNotReadYaml($file) {
		return new Suskind_Exception(sprintf('File %s is exists, hopfully but not readable by YAML parser. Maybe the YAML parser missing.', $file));
	}

	public function show() {
		/*
		 * @todo: define template for different outputs
		 */
		echo "<pre>{$this->__toString()}</pre>";
	}
}

?>
