<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Registry
 *
 * @author Balazs Ercsey <laze@laze.hu>
 */
class Suskind_Registry {
	
	/**
	 * The registry values.
	 *
	 * @var array
	 */
	private static $registry = array(
		'System'		=> array(
			'Server'		=> array(),
			'Path'			=> array(),
			'Client'		=> array()
		),
		'Application'	=> array(
			'Plugins'		=> array(),
			'Render'		=> array(),
			'Resource'		=> array()
		)
	);

	/**
	 * Build up the registry. This method call other methods, to calculate paths,
	 * and read configuration files.
	 *
	 * @param array $paths
	 * @return void
	 */
	public static function init(array $paths) {
		self::loadPaths($paths);
		self::loadConfigurations();

		return;
	}
	/**
	 * Get settings from registry.
	 *
	 * @param string $key
	 * @return mixed Returns with value, what is aassigned to given key, or false, if key not exists.
	 */
	public static function getSettings($key) {
		if (array_key_exists($key, self::$registry)) return self::$registry[$key];
		elseif (array_key_exists('Suskind_Application_'.ucfirst($key), self::$registry)) return self::$registry['Suskind_Application_'.ucfirst($key)];
		else return;
	}

	/**
	 * Returns with application settings.
	 *
	 * @return array
	 */
	public static function getApplicationSettings() {
		$applicationSettings = array();

		foreach (self::$registry as $key => $settings) {
			if (substr($key, 0, 19) == 'Suskind_Application') $applicationSettings[$key] = $settings;
		}
		return $applicationSettings;
	}

	/**
	 * Check, whether key exists or not.
	 * 
	 * @param string $key
	 * @return boolean
	 */
	public static function checkKey($key) {
		return array_key_exists($key, self::$registry) || array_key_exists('Suskind_Application_'.ucfirst($key), self::$registry);
	}

	/**
	 *
	 * @param array $paths The array of the application and the system paths.
	 * @return void
	 */
	private static function loadPaths(array $paths) {
		self::$registry['System']['Path'] = $paths;
		echo('<pre>');
		var_dump(self::$registry);
		echo('</pre>');
	}

	/**
	 * Loading different configuration files: First of all try to get the
	 * application's global configuration. After that, try to get the
	 * host-related configurations. If any key exists in the second file, what
	 * is also exists in the first, then it will be overwritten.
	 *
	 * @return void
	 */
	private static function loadConfigurations() {
		//- Gets the application's global configuration.
		if (file_exists(self::$paths['Application'].'/Configuration/application.ini')) self::addRegistry(parse_ini_file(self::$paths['Application'].'/Configuration/application.ini', true));
		//- Gets the application's host-related configuration.
		if (file_exists(self::$paths['Application'].'/Configuration/'.$_SERVER['SERVER_NAME'].'/application.ini')) $this->addRegistry(parse_ini_file(self::$paths['Application'].'/Configuration/'.$_SERVER['SERVER_NAME'].'/application.ini', true));
	}

	/**
	 * This method can be used to handle advanced configuration, user can set
	 * new registry from a specified file. This method DOES NOT write over the
	 * registry, these options are just will be added to it.
	 *
	 * @param string $filename The path of the file to load.
	 * @return void
	 */
	public static function loadFile(string $filename) {
		if (file_exists($filename)) self::getInstance()->addRegistry(parse_ini_file($filename, true));
		else throw new Suskind_Exception(1001,array($filename));
	}

	/**
	 * Add settings to the registry.
	 *
	 * @param array $configuration A previously parsed ini file.
	 * @return void
	 */
	private static function addRegistry(array $configuration) {
		foreach ($configuration as $path => $settings) {
			$path = 'Suskind_'.str_replace(' ', '_', ucwords(str_replace('.', ' ', $path)));
			self::$registry[$path] = $settings;
		}
	}
}
?>
