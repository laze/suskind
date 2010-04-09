<?php
/**
 * License
 */

/**
 * Description of Loader
 *
 * @author Balazs Ercsey <laze@laze.hu>
 */
final class Suskind_Loader {
	/**
	 *
	 * @var array Calculated paths.
	 */
	private static $paths;

	private static $pluginDir = 'Plugin';

	/**
	 * Retrieve singleton instance.
	 *
	 * @param array $paths The previously set paths from the Fountain.
	 * @return Suskind_Loader
	 */
	public static function init(array $paths) {
		self::$paths = $paths;
			//- Register __autoload methods
		spl_autoload_register(array(__CLASS__, 'autoload'));
		Suskind_Registry::init($paths);
	}

	/**
	 * Calculate the path from the class' name.
	 *
	 * @param string $className
	 */
	public static function compileClassName($className) {
		$classNameParsed = split('_',$className, substr_count($className, self::$pluginDir) > 0 ? substr_count($className, '_') : substr_count($className, '_') + 1);
		if (array_key_exists($classNameParsed[0], self::$paths)) {
			$classNameParsed[0] = self::$paths[$classNameParsed[0]];
			return implode(DIRECTORY_SEPARATOR, $classNameParsed).'.php';
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
	 * @param string $className Name of the class to include.
	 * @return void
	 */
	public static function autoload($className) {
		try {
			echo(self::compileClassName($className));
			if (file_exists(self::compileClassName($className))) include_once self::compileClassName($className);
			else self::searchClassName($className);
		} catch(Exception $exception) {
			throw new Suskind_Exception('Class not exists: '.$className);
		}
	}
}

?>