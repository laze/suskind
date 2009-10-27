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

	public static function searchClassName($className) {
		array_walk_recursive(Suskind_Registry::getAll(), array('Suskind_Loader', 'parsePaths'), self::$paths);
		array_walk_recursive(Suskind_Registry::getAll(), array('Suskind_Loader', 'includePaths'), $className);
	}

	public static function includePaths($registryValue, $registryKey, $className) {
		if (strtolower($className) === strtolower($registryKey)) {
			foreach (self::$paths as $path) {
				if (file_exists($path.DIRECTORY_SEPARATOR.$registryValue)) include_once $path.DIRECTORY_SEPARATOR.$registryValue;
			}
		}
	}

	public static function parsePaths($registryValue, $registryKey) {
		if ($registryKey === Suskind_Registry::CKEY_PATH && !in_array($registryValue, self::$paths)) self::$paths[] = $registryValue;
	}

	/**
	 * Gets name of class and include file from possible pathes.
	 *
	 * @param string $className Name of the class to include.
	 * @return void
	 */
	public static function autoload($className) {
		try {
			if (file_exists(self::compileClassName($className))) include_once self::compileClassName($className);
			else {
				self::searchClassName($className);

				/*
				$paths = Suskind_Registry::getSettings('include');
				if (array_key_exists($className, $paths) && file_exists($_ENV['PATH_SYSTEM'].DIRECTORY_SEPARATOR.$paths[$className])) include_once $_ENV['PATH_SYSTEM'].DIRECTORY_SEPARATOR.$paths[$className];
				 * 
				 */
			}
			/*
			if (file_exists(str_replace(array('Application','Suskind'), array($_ENV['PATH_APPLICATION'], $_ENV['PATH_SYSTEM']), str_replace('_', DIRECTORY_SEPARATOR, $className))).'.php') include_once(str_replace(array('Application','Suskind'), array($_ENV['PATH_APPLICATION'], $_ENV['PATH_SYSTEM']), str_replace('_', DIRECTORY_SEPARATOR, $className).'.php'));

			if (strpos($className, 'Application') === (int) 0) {
				if (file_exists(str_replace('Application', $_ENV['PATH_APPLICATION'], str_replace('_', DIRECTORY_SEPARATOR, $className)).'.php')) include_once str_replace('Application', $_ENV['PATH_APPLICATION'], str_replace('_', DIRECTORY_SEPARATOR, $className)).'.php';
			} else {
				if (file_exists(str_replace('Suskind', $_ENV['PATH_SYSTEM'], str_replace('_', DIRECTORY_SEPARATOR, $className)).'.php')) include_once str_replace('Suskind', $_ENV['PATH_SYSTEM'], str_replace('_', DIRECTORY_SEPARATOR, $className)).'.php';
			}
			*/

			/*
			echo($_ENV['PATH_SYSTEM'].DIRECTORY_SEPARATOR.str_replace('_', DIRECTORY_SEPARATOR, $className).'.php');
				if (file_exists($_ENV['PATH_SYSTEM'].DIRECTORY_SEPARATOR.str_replace('_', DIRECTORY_SEPARATOR, $className).'.php')) include_once $_ENV['PATH_SYSTEM'].DIRECTORY_SEPARATOR.str_replace('_', DIRECTORY_SEPARATOR, $className).'.php';
				else {
					$paths = Suskind_Registry::getSettings('include');

					if (array_key_exists($className, $paths) && file_exists($_ENV['PATH_SYSTEM'].DIRECTORY_SEPARATOR.$paths[$className])) include_once $_ENV['PATH_SYSTEM'].DIRECTORY_SEPARATOR.$paths[$className];
				}
			 */
		} catch(Exception $exception) {
			throw new Suskind_Exception('Class not exists: '.$className);
		}
	}
}

?>