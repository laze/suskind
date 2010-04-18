<?php
/**
 * License
 */

/**
 * Suskind_Loader class.
 *
 * This class help loading classes, etc...
 *
 * @package suskind
 * @author Balazs Ercsey <laze@laze.hu>
 */
final class Suskind_Loader {

	const PLUGIN_DIR = 'Plugin';

	/**
	 *
	 * @var Suskind_Loader The instance of the loader.
	 */
	static protected $instance;

	/**
	 *
	 * @var array The calculated pathes.
	 */
	static protected $paths = array(
		'Application' => '',
		'Suskind' => ''
	);

	protected function  __construct(array $paths) {
		self::$paths = $paths;
	}

	static public function getInstance() {
		if (!isset (self::$instance)) self::$instance = new Suskind_Loader(array(
			'Application' => realpath(getcwd().'/../'),
			'Suskind' => realpath(dirname(__FILE__))
		));
		return self::$instance;
	}

	/**
	 * Register Suskind_Loader in spl_autoload.
	 *
	 * @return void
	 */
	static public function register() {
		ini_set('unserialize_callback_func', 'spl_autoload_call');

		if (false === spl_autoload_register(array(self::getInstance(), 'autoload')))  throw new Suskind_Exception(sprintf('Unable to register %s::autoload as an autoloading method.', get_class(self::getInstance())));
	}

	/**
	 * Unregister Suskind_Loader from spl_autoload.
	 *
	 * @return void
	 */
	static public function unregister() {
		spl_autoload_unregister(array (self::getIntance(), 'autoload'));
	}

	public function reloadClasses($force = false) {
		
	}

	/**
	 * Calculate the path from the class' name.
	 *
	 * @param string $class
	 */
	public static function compileClass($class) {
		if (class_exists($class, false) || interface_exists($class, false)) return true;

		$classNameParsed = split('_',$class, substr_count($class, self::PLUGIN_DIR) > 0 ? substr_count($class, '_') : substr_count($class, '_') + 1);
		if (array_key_exists($classNameParsed[0], self::$paths)) {
			$classNameParsed[0] = self::$paths[$classNameParsed[0]];

			try {
				if (file_exists(implode(DIRECTORY_SEPARATOR, $classNameParsed).'.php')) require_once implode(DIRECTORY_SEPARATOR, $classNameParsed).'.php';
				else return false;
			} catch (Suskind_Exception $exception) {

			}
			return true;
		}
	}

	/**
	 * Search class' name in plugins. First, in application plugins, and after
	 * in system plugins directory.
	 * 
	 * @param string $className The class' name.
	 */
	public static function searchClassName($className) {
		$applicationPlugins = Suskind_Registry::getApplicationSettings(Suskind_Registry::CKEY_PLUGIN);
		if (is_array($applicationPlugins) && array_key_exists($className, $applicationPlugins) && file_exists($applicationPlugins[Suskind_Registry::CKEY_PATH].DIRECTORY_SEPARATOR.$applicationPlugins[$className])) include_once $applicationPlugins[Suskind_Registry::CKEY_PATH].DIRECTORY_SEPARATOR.$applicationPlugins[$className];

		$systemPlugins = Suskind_Registry::getSystemSettings(Suskind_Registry::CKEY_PLUGIN);
		if (is_array($systemPlugins) && array_key_exists($className, $systemPlugins) && file_exists($systemPlugins[Suskind_Registry::CKEY_PATH].DIRECTORY_SEPARATOR.$systemPlugins[$className])) include_once $systemPlugins[Suskind_Registry::CKEY_PATH].DIRECTORY_SEPARATOR.$systemPlugins[$className];
	}

	/**
	 * Gets name of class and include file from possible pathes.
	 *
	 * @param string $class Name of the class to include.
	 * @return void
	 */
	public static function autoload($class) {
		if (!self::$instance->classes) self::reloadClasses();

		return self::compileClass($class);
	}
}

?>