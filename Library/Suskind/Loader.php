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
 * @subpackage	Loader
 * @author		Balazs Ercsey <laze@laze.hu>
 * @license		http://www.opensource.org/licenses/gpl-3.0.html GPLv3
 * @link		http://code.google.com/p/suskind/
 * @since		0.1
 * @version		$Rev$
 */
class Suskind_Loader
{
	/**
	 * Directory constants. They have to be the same as in the disk.
	 */
	const DIR_APPLICATION = 'Application';
	const DIR_SUSKIND = 'Suskind';
	const DIR_LIBRARY = 'Library';
	const DIR_CONFIGURATION = 'Configuration';
	const DIR_ASSETS = 'Assets';
	const DIR_MODEL = 'Model';
	
	/**
	 * This array stores the different pathes, like the application's path, the
	 * Suskind library's path, the global libraries' path, and also it stores
	 * the different libraries.
	 *
	 * @var array $paths	Array of paths.
	 * @static
	 */
	public static $paths;

	/**
	 * __construct
	 *
	 * @return void
	 * @throws Suskind_Exception
	 */
	public function  __construct() {
		throw Suskind_Exception::ClassStaticConstruct();
	}

	/**
	 * Set up path variables for autoload methods.
	 *
	 * @return void
	 */
	private static function setPath() {
		self::$paths = array(
			self::DIR_APPLICATION	=> realpath(getcwd().DIRECTORY_SEPARATOR.'..'),
			self::DIR_SUSKIND		=> realpath(dirname(__FILE__)),
			self::DIR_LIBRARY		=> realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'),
			self::DIR_MODEL			=> realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Models'),
			'_ROOT' => realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..')
		);
		$dir = dir(self::$paths[self::DIR_LIBRARY]);
		while (false !== ($entry = $dir->read())) {
			if (substr($entry, 0, 1) !== '.' && !array_key_exists($entry, self::$paths)) self::$paths[$entry] = self::$paths[self::DIR_LIBRARY].DIRECTORY_SEPARATOR.$entry;
		}
		$dir->close();
	}

	/**
	 * The mean of the Loader class. This method will be called first in an
	 * application, so this method shoud prepare everything.
	 *  * Set up path variables
	 *  * Register autolad handler methods.
	 *
	 * @see Suskind_Loader::setPath()
	 * @see Suskind_Loader::addAutoload()
	 *
	 * @return void
	 */
	static public function load() {
		self::setPath();
		self::addAutoload();
	}

	/**
	 * Register Suskind_Loader in spl_autoload.
	 *
	 * @return void
	 *
	 * @throws Suskind_Exception
	 */
	static public function addAutoload() {
		ini_set('unserialize_callback_func', 'spl_autoload_call');

		if (false === spl_autoload_register(array(__CLASS__, 'autoload')))  throw new Suskind_Exception(sprintf('Unable to register %s::autoload as an autoloading method.', __CLASS__));
	}

	/**
	 * Unregister Suskind_Loader from spl_autoload.
	 *
	 * @return void
	 */
	static public function removeAutoload() {
		spl_autoload_unregister(array(self::getIntance(), 'autoload'));
	}

	/**
	 * Gets name of class and include file from possible pathes.
	 *
	 * @param string $class				Name of the class to include.
	 * @return void
	 */
	public static function autoload($class) {
		return self::loadClass($class);
	}

	/**
	 * Calculate the path from the class' name.
	 *
	 * @param string $class				The name of the class what we want include.
	 * @return true|void				True, if class or interface previously included.
	 *
	 * @throws Suskind_Exception
	 */
	private static function loadClass($class) {
		if (class_exists($class, false) || interface_exists($class, false)) return true;

		$path = explode('_', $class);
		if (sizeof($path) > 1 && array_key_exists($path[0], self::$paths)) $path[0] = self::$paths[$path[0]];
		else $path[0] = self::$paths[self::DIR_LIBRARY].DIRECTORY_SEPARATOR.$path[0].DIRECTORY_SEPARATOR.$path[0];
		if (file_exists(implode(DIRECTORY_SEPARATOR, $path).'.php')) require_once implode(DIRECTORY_SEPARATOR, $path).'.php';
		else throw Suskind_Exception::ClassNotExists($class);
	}

	/**
	 * This function checks the two possible places of the Suskind Framework
	 * configuration files: the server-related and the application related, and
	 * creates Suskind_Registry based on these files.
	 *
	 * @see Suskind_Registry::loadFiles()
	 *
	 * @param string $filename			The name of the configuration file.
	 * @return Suskind_Registry
	 */
	public static function loadConfiguration($filename) {
		$files = array();
		if (file_exists(self::$paths[self::DIR_APPLICATION].DIRECTORY_SEPARATOR.self::DIR_CONFIGURATION.DIRECTORY_SEPARATOR.$filename)) $files[] = self::$paths[self::DIR_APPLICATION].DIRECTORY_SEPARATOR.self::DIR_CONFIGURATION.DIRECTORY_SEPARATOR.$filename;
		if (file_exists(self::$paths[self::DIR_APPLICATION].DIRECTORY_SEPARATOR.self::DIR_CONFIGURATION.DIRECTORY_SEPARATOR.self::DIR_SUSKIND.DIRECTORY_SEPARATOR.$filename)) $files[] = self::$paths[self::DIR_APPLICATION].DIRECTORY_SEPARATOR.self::DIR_CONFIGURATION.DIRECTORY_SEPARATOR.self::DIR_SUSKIND.DIRECTORY_SEPARATOR.$filename;
		return Suskind_Registry::loadFiles($files);
	}

	/**
	 * Returns with a correct path from assets folder.
	 *
	 * @param string|array $filename	The path and the name of the asset file.
	 * @return void
	 */
	public static function getFile($filename) {
		$filename = ucwords(self::$paths[self::DIR_APPLICATION].DIRECTORY_SEPARATOR.self::DIR_ASSETS.DIRECTORY_SEPARATOR.((is_array($filename)) ? implode(DIRECTORY_SEPARATOR, $filename) : $filename));
		if (file_exists($filename)) {
			header('Content-Type: '.self::getFileMime($filename));
			readfile($filename);
		} else throw Suskind_Exception::FileNotExists($filename);
	}

	/**
	 * Get a file's mime type.
	 * 
	 * @param string $filename			The name of the file for what we want know the mime type.
	 * @return string
	 */
	public static function getFileMime($filename) {
		return self::getFileInfo(FILEINFO_MIME, $filename);
	}

	/**
	 *
	 * @param int $infotype				The type of the requested information.
	 * @param string $filename			The name of the file for what we want know the mime type.
	 * @param string $infodatabase		Path to mime magic database.
	 * @return string
	 *
	 * @see http://php.net/manual/en/fileinfo.constants.php
	 */
	private static function getFileInfo($infotype, $filename, $infodatabase = null) {
		$infodata = ($infodatabase) ? finfo_open($infotype, $infodatabase) : finfo_open($infotype);
		$fileinfo = finfo_file($infodata, $filename);
					finfo_close($infodata);

		return $fileinfo;
	}
}
?>