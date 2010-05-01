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
 * Registry handles the configuration files. It handles YAML files, and ini files
 * too.
 *
 * @category	Suskind
 * @package		Suskind
 * @subpackage	Registry
 * @author		Balazs Ercsey <laze@laze.hu>
 * @license		http://www.opensource.org/licenses/gpl-3.0.html GPLv3
 * @link		http://code.google.com/p/suskind/
 * @since		0.1
 * @version		$Rev$
 */
class Suskind_Registry
{
	const TYPE_YAML = 'yml;yaml';
	const TYPE_INI = 'ini';

	private $registry = null;
	
	public function __construct() {
	}

	public function asArray() {
		return (array) $this->registry;
	}

	/**
	 * Parse file content. It just receive a filename, with full path and
	 * extension. Describes the file's type with getFileType() method and try
	 * parse it and merge content.
	 *
	 * @see self::getFileType()
	 *
	 * @param string $filename		The name of the file parse.
	 * @return void
	 */
	private function parseFile($filename) {
		if (!file_exists($filename)) throw Suskind_Exception::FileNotExists($filename);

		switch (self::getFileType($filename)) {
			case self::TYPE_YAML: //- Parse YAML file.
				$this->merge($this->parseYamlFile($filename));
				break;
			case self::TYPE_INI: //- Parse ini file.
				$this->merge($this->parseIniFile($filename));
				break;
			default: //- ...just do it.
				$this->merge(file($filename));
				break;
		}
	}

	/**
	 * @todo Finish
	 *
	 * @param <type> $filename
	 * @return <type>
	 */
	private function parseYamlFile($filename) {
		try {
			if (class_exists('Spyc')) return Spyc::YAMLLoad($filename);
		} catch (Exception $e) {
			throw Suskind_Exception::FileNotReadYaml($filename);
		}
	}

	/**
	 * @todo Finish
	 *
	 * @param <type> $filename
	 * @return <type>
	 */
	private function parseIniFile($filename) {
		try {
			return parse_ini_file($filename, true);
		} catch (Exception $e) {
			throw Suskind_Exception::FileNotReadYaml($filename);
		}
	}

	/**
	 * Try to merge - or simply write - data into registry.
	 *
	 * @param array $content	The new parts of the registry's content.
	 */
	private function merge(array $content) {
		if (is_array($this->registry)) $this->registry = array_merge($content, $this->registry);
		else $this->registry = $content;
	}

	/**
	 * To have a more nice - practically empty - construct method, with a string
	 * or an array parameter, we did this static method, what accepts only array
	 * and returns with a registry object. It reads the files step by step and
	 * merge it in the registry handler object.
	 * This method does not check whether a file exist or not, becase it just
	 * get an array fulled with probably checked files.
	 * The parseFile method checks file exists.
	 *
	 * @see parseFile
	 * 
	 * @param array $files
	 * @return Suskind_Registry
	 */
	public static function loadFiles(array $files) {
		/**
		 * Creating an object from Suskind_Registry class, to load configuration
		 * onto, and merge the files' contants.
		 */
		$registry = new Suskind_Registry();
		/**
		 * Parse files step by step.
		 */
		foreach ($files as $file) $registry->parseFile($file);
		return $registry;
	}

	/**
	 * Describe file type.
	 *
	 * @param string $filename
	 * @return string
	 */
	private static function getFileType($filename) {
		if (in_array(strtolower(substr($filename, strrpos($filename, '.') + 1)), explode(';', self::TYPE_YAML))) return self::TYPE_YAML;
		if (in_array(strtolower(substr($filename, strrpos($filename, '.') + 1)), explode(';', self::TYPE_INI))) return self::TYPE_INI;
	}
}

?>
