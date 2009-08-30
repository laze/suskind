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
     * @var Suskind_Loader Singleton instance
     */
    private static $instance;

	/**
	 * Constructor
	 *
	 * Registers instance with spl_autoload stack
	 *
	 * @return void
	 */
	private function __construct() {
			//- Register __autoload methods
		spl_autoload_register(array(__CLASS__, 'autoload'));
	}

	/**
	 * Retrieve singleton instance
	 *
	 * @return Suskind_Loader
	 */
	public static function getInstance() {
		if (null === self::$instance) self::$instance = new self();
		return self::$instance;
	}

	/**
	 * Reset the singleton instance
	 *
	 * @return void
	 */
	public static function resetInstance() {
		self::$instance = null;
	}

	/**
	 * Gets name of class and include file from possible pathes.
	 *
	 * @param $className string Name of the class to include.
	 * @return void
	 */
	public static function autoload($className) {
		try {
			if (strpos($className, 'Application') === (int) 0) {
				if (file_exists($_ENV['PATH_APPLICATION'].str_replace('_', DIRECTORY_SEPARATOR, str_replace('Application','', $className)).'.php')) include_once $_ENV['PATH_APPLICATION'].str_replace('_', DIRECTORY_SEPARATOR, str_replace('Application','', $className)).'.php';
			} else {
				if (file_exists($_ENV['PATH_SYSTEM'].DIRECTORY_SEPARATOR.str_replace('_', DIRECTORY_SEPARATOR, $className).'.php')) include_once $_ENV['PATH_SYSTEM'].DIRECTORY_SEPARATOR.str_replace('_', DIRECTORY_SEPARATOR, $className).'.php';
			}
		} catch(Exception $exception) {
			throw new Suskind_Exception('Class not exists: '.$className);
		}
	}
}

?>