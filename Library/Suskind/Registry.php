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
 * @subpackage	Registry
 * @author		Balazs Ercsey <laze@laze.hu>
 * @license		http://www.opensource.org/licenses/gpl-3.0.html GPLv3
 * @link		http://code.google.com/p/suskind/
 * @since		0.1
 * @version		$Rev$
 */
class Suskind_Registry
{
	private $registry = null;
	
	public function __construct($filename) {
		if (is_string($filename)) $this->parseFile($filename);
		if (is_array($filename)) $this->parseFiles($filename);

		echo('<pre>');
		var_dump($this->registry);
		echo('</pre>');
	}

	public function parseFile($filename, $type = 'yaml') {
		if (!file_exists($filename)) throw Suskind_Exception::FileNotExists($filename);
		switch ($type) {
			case 'yaml':
				$registry = $this->parseYamlFile($filename);
				break;
			case 'ini':
				$registry = parse_ini_file($filename, true);
				break;
			default:
				$registry = file($filename);
				break;
		}
		if (!is_null($this->registry)) array_merge_recursive($this->registry, $registry);
		else $this->registry = $registry;
	}

	/**
	 * Try to loads more files. It's just for use registry easier. If one of the
	 * files is missing, then it doesn't throws an exception, only, if _every_
	 * paths are wrong.
	 * This method just check the files, the real parser called in the parseFile
	 * method.
	 *
	 * @see parseFile
	 *
	 * @param array $filenames	Array of strings. Every string is a path to a file.
	 * @param string $type		The parsing method of the file.
	 * @return void
	 * @throws Suskind_Exception
	 */
	public function parseFiles($filenames, $type = 'yaml') {
		$filemissings = array();

		foreach ($filenames as $filename) {
			if (!file_exists($filename)) $filemissings[] = $filename;
			else $this->parseFile($filename, $type);
		}
		if (sizeof($filemissings) == sizeof($filenames)) throw Suskind_Exception::FileNotExists($filemissings[0]);
	}

	public function parseYamlFile($file) {
		return Spyc::YAMLLoad($file);
	}

	public function parse() {
		var_dump(func_get_args());
	}
}

?>
