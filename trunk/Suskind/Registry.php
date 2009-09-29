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

	const CKEY_SYSTEM	= 'Suskind';
	const CKEY_APP		= 'Application';
	const CKEY_SERVER	= 'Server';
	const CKEY_USER		= 'Client';
	const CKEY_PLUGIN	= 'Plugin';
	const CKEY_RESOURCE	= 'Resource';
	const CKEY_RENDER	= 'Render';
	const CKEY_CONFIG	= 'Configuration';
	const CKEY_STORE	= 'Store';
	
	/**
	 * The registry values.
	 *
	 * @var array
	 */
	private static $registry = array();

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
		return self::$registry[self::CKEY_APP];
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
		self::$registry[self::CKEY_SYSTEM]['Path'] = $paths[self::CKEY_SYSTEM];
		self::$registry[self::CKEY_APP]['Path'] = $paths[self::CKEY_APP];

		self::$registry[self::CKEY_APP][self::CKEY_PLUGIN]['Path'] = self::checkPath(self::CKEY_PLUGIN);
		self::$registry[self::CKEY_APP][self::CKEY_RESOURCE]['Path'] = self::checkPath(self::CKEY_RESOURCE);
		self::$registry[self::CKEY_APP][self::CKEY_RENDER]['Path'] = self::checkPath(self::CKEY_RENDER);

		self::$registry[self::CKEY_APP][self::CKEY_CONFIG] = self::checkConfigurationPath(self::$registry[self::CKEY_APP]['Path'].DIRECTORY_SEPARATOR.self::CKEY_CONFIG.DIRECTORY_SEPARATOR);
	}

	private static function checkConfigurationPath($path) {
		if (file_exists($path.$_SERVER['SERVER_NAME'].DIRECTORY_SEPARATOR.'Application.ini')) return $path.$_SERVER['SERVER_NAME'].DIRECTORY_SEPARATOR.'Configuration.ini';
		else {
			if ($path.'Application.ini') return $path.'Configuration.ini';
			else throw new Suskind_Exception(Suskind_Exception_Registry::ConfigurationNotExists(self::$registry[self::CKEY_APP]['Path'].DIRECTORY_SEPARATOR.self::CKEY_CONFIG));
		}
	}

	/**
	 * First, try to find th folder in the Application part, and if it not exists
	 * there, then checks the System path.
	 *
	 * @param string $path The name of the folder to find.
	 * @return string
	 */
	private static function checkPath($path) {
		return (file_exists(self::$registry[self::CKEY_APP]['Path'].DIRECTORY_SEPARATOR.$path)) ? self::$registry[self::CKEY_APP]['Path'].DIRECTORY_SEPARATOR.$path : self::$registry[self::CKEY_SYSTEM]['Path'].DIRECTORY_SEPARATOR.$path;
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
		self::addRegistry(parse_ini_file(self::$registry[self::CKEY_APP][self::CKEY_CONFIG], true));
		/*
		//- Gets the application's global configuration.
		if (file_exists(self::$paths['Application'].'/Configuration/application.ini')) self::addRegistry(parse_ini_file(self::$paths['Application'].'/Configuration/application.ini', true));
		//- Gets the application's host-related configuration.
		if (file_exists(self::$paths['Application'].'/Configuration/'.$_SERVER['SERVER_NAME'].'/application.ini')) $this->addRegistry(parse_ini_file(self::$paths['Application'].'/Configuration/'.$_SERVER['SERVER_NAME'].'/application.ini', true));
		 *
		 */
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
		else throw new Suskind_Exception(Suskind_Exception_File::NotExists($filename));
	}

	/**
	 * Add settings to the registry.
	 *
	 * @param array $configuration A previously parsed ini file.
	 * @return void
	 *
	 * @todo This method need more development to parse more informations, like
	 * registry, etc.
	 */
	private static function addRegistry(array $configuration) {
		foreach ($configuration as $key => $settings) {
			if (array_key_exists(trim($key), self::$registry)) {

				$path = 'Suskind_'.str_replace(' ', '_', ucwords(str_replace('.', ' ', $path)));
				self::$registry[trim($key)] = array_merge($settings, self::$registry[trim($key)]);
			}
		}
	}

	/**
	 * Store a variable in the the registry's runtime store.
	 *
	 * @param string $name The key to store any value.
	 * @param mixed $value The value for the name.
	 * @param boolean $force If it's true, then doesn't check whether $name is exists or not, before writing value.
	 * @return mixed Return the value what is set. If force was false, and key exists, then return the previously set value.
	 */
	public static final function setStore($name, $value = null, $force = false) {
		if ($force === false) {
			if (!array_key_exists($name, self::$registry[self::CKEY_STORE])) self::$registry[self::CKEY_STORE][$name] = $value;
		} else self::$registry[self::CKEY_STORE][$name] = $value;
		return self::$registry[self::CKEY_STORE][$name];
	}

	/**
	 * Get a variable from the store.
	 *
	 * @param string $name The key to get value.
	 * @return mixed Returns with the value, or null, if key not exists.
	 */
	public static final function getStore($name) {
		if (array_key_exists($name, self::$registry[self::CKEY_STORE])) return self::$registry[self::CKEY_STORE][$name];
		else return null;
	}
}
?>
