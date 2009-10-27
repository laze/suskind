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

	const CKEY_APP		= 'Application';
	const CKEY_CONFIG	= 'Configuration';
	const CKEY_DB		= 'Database';
	const CKEY_PATH		= 'Path';
	const CKEY_PLUGIN	= 'Plugin';
	const CKEY_RENDER	= 'Render';
	const CKEY_RESOURCE	= 'Resource';
	const CKEY_SERVER	= 'Server';
	const CKEY_STORE	= 'Store';
	const CKEY_SYSTEM	= 'Suskind';
	const CKEY_USER		= 'Client';

	/**
	 * The logical map of the registry. Only these keys are available to store
	 * variables.
	 * 
	 * @var array
	 */
	private static $registryKeys = array(
		self::CKEY_SYSTEM => array(
			self::CKEY_RENDER => array(),
			self::CKEY_RESOURCE => array(
                            self::CKEY_DB => array()
                        ),
			self::CKEY_CONFIG => array(),
			self::CKEY_PLUGIN => array(),
			self::CKEY_PATH => array()
		),
		self::CKEY_APP => array(
			self::CKEY_RENDER => array(),
			self::CKEY_RESOURCE => array(
				self::CKEY_DB => array()
			),
			self::CKEY_CONFIG => array(),
			self::CKEY_PLUGIN => array(),
			self::CKEY_PATH => array()
		),
		self::CKEY_SERVER => array(),
		self::CKEY_USER => array(),
		self::CKEY_STORE => array()
	);
	
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
	 *
	 * @param array $paths The array of the application and the system paths.
	 * @return void
	 */
	private static function loadPaths(array $paths) {
		self::$registry[self::CKEY_SYSTEM][self::CKEY_PATH] = $paths[self::CKEY_SYSTEM];
		if (file_exists(self::$registry[self::CKEY_SYSTEM][self::CKEY_PATH].DIRECTORY_SEPARATOR.self::CKEY_CONFIG.DIRECTORY_SEPARATOR.self::CKEY_CONFIG.'.ini')) self::$registry[self::CKEY_SYSTEM][self::CKEY_CONFIG] = self::$registry[self::CKEY_SYSTEM]['Path'].DIRECTORY_SEPARATOR.self::CKEY_CONFIG.DIRECTORY_SEPARATOR.self::CKEY_CONFIG.'.ini';

		self::$registry[self::CKEY_APP][self::CKEY_PATH] = $paths[self::CKEY_APP];

		self::$registry[self::CKEY_APP][self::CKEY_PLUGIN][self::CKEY_PATH] = self::checkPath(self::CKEY_PLUGIN);
		self::$registry[self::CKEY_APP][self::CKEY_RESOURCE][self::CKEY_PATH] = self::checkPath(self::CKEY_RESOURCE);
		self::$registry[self::CKEY_APP][self::CKEY_RENDER][self::CKEY_PATH] = self::checkPath(self::CKEY_RENDER);

		self::$registry[self::CKEY_APP][self::CKEY_CONFIG] = self::checkConfigurationPath(self::$registry[self::CKEY_APP][self::CKEY_PATH].DIRECTORY_SEPARATOR.self::CKEY_CONFIG.DIRECTORY_SEPARATOR);
	}

	private static function checkConfigurationPath($path) {
		if (file_exists($path.$_SERVER['SERVER_NAME'].DIRECTORY_SEPARATOR.'Application.ini')) return $path.$_SERVER['SERVER_NAME'].DIRECTORY_SEPARATOR.'Configuration.ini';
		else {
			if ($path.'Application.ini') return $path.'Configuration.ini';
			else throw new Suskind_Exception(Suskind_Exception_Registry::ConfigurationNotExists(self::$registry[self::CKEY_APP][self::CKEY_PATH].DIRECTORY_SEPARATOR.self::CKEY_CONFIG));
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
		return (file_exists(self::$registry[self::CKEY_APP][self::CKEY_PATH].DIRECTORY_SEPARATOR.$path)) ? self::$registry[self::CKEY_APP][self::CKEY_PATH].DIRECTORY_SEPARATOR.$path : self::$registry[self::CKEY_SYSTEM]['Path'].DIRECTORY_SEPARATOR.$path;
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
		if (array_key_exists(self::CKEY_CONFIG, self::$registry[self::CKEY_SYSTEM])) self::addRegistry(parse_ini_file(self::$registry[self::CKEY_SYSTEM][self::CKEY_CONFIG], true));
		if (array_key_exists(self::CKEY_CONFIG, self::$registry[self::CKEY_APP])) self::addRegistry(parse_ini_file(self::$registry[self::CKEY_APP][self::CKEY_CONFIG], true));
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
	 * @todo Later try to rewrite with recursive methods to handle more of the
	 * different resources or any other extends what are improving the usability
	 * of the registry.
	 */
	private static function addRegistry(array $configuration) {
		foreach ($configuration as $key => $settings) {
			$key = ucfirst(strtolower(trim($key)));
			if (!array_key_exists($key, self::$registry) && array_key_exists($key, self::$registryKeys)) self::$registry[$key] = array();
			if (is_array($settings)) {
				foreach ($settings as $variable => $value) {
					$variable = strtolower(trim($variable));
					if (strpos($variable, '.') > 0) {
						if (is_array(self::$registryKeys[$key]) && array_key_exists(ucfirst(strtolower(substr($variable, 0, strpos($variable, '.')))), self::$registryKeys[$key])) {
							if (ucfirst(strtolower(substr($variable, 0, strpos($variable, '.')))) == self::CKEY_RESOURCE) { //- Check Resources
								if (ucfirst(strtolower(substr($variable, strpos($variable, '.')+1, 8))) == self::CKEY_DB) {
									list(,, $group, $variable) = explode('.', $variable);
									self::$registry[self::CKEY_APP][self::CKEY_RESOURCE][self::CKEY_DB][$group][$variable] = $value;
								} else self::$registry[$key][ucfirst(strtolower(substr($variable, 0, strpos($variable, '.'))))][substr($variable, strpos($variable, '.')+1)] = $value;
							} else self::$registry[$key][ucfirst(strtolower(substr($variable, 0, strpos($variable, '.'))))][substr($variable, strpos($variable, '.')+1)] = $value;
						} else self::$registry[$key][$variable] = $value;
					} else self::$registry[$key][$variable] = $value;
				}
			} else self::$registry[$key] = $settings;
		}
	}

	private static function get($key, $variable = null) {
		if (is_null($variable)) return self::$registry[$key];
		if (array_key_exists($variable, self::$registry[$key])) return self::$registry[$key][$variable];
		else return null;
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
	 * Get one ore more variable from the Store.
	 *
	 * @param string $name The key to get value. If it's empty (is null) then the Registry will come back with the full array of this part.
	 * @return mixed Returns with the value, or null, if key not exists, or array, if $name was null.
	 */
	public static final function getStore($name = null) {
		return self::get(self::CKEY_STORE, $name);
	}

	/**
	 * Get one ore more variable from the Registry's server related settings.
	 *
	 * @param string $name The key to get value. If it's empty (is null) then the Registry will come back with the full array of this part.
	 * @return mixed Returns with the value, or null, if key not exists, or array, if $name was null.
	 */
	public static final function getServerSettings($name = null) {
		return self::get(self::CKEY_SERVER, $name);
	}

	/**
	 * Get one ore more variable from the Registry's application related settings.
	 *
	 * @param string $name The key to get value. If it's empty (is null) then the Registry will come back with the full array of this part.
	 * @return mixed Returns with the value, or null, if key not exists, or array, if $name was null.
	 */
	public static final function getApplicationSettings($name = null) {
		return self::get(self::CKEY_APP, $name);
	}

	/**
	 * Get one ore more variable from the Registry's system related settings.
	 *
	 * @param string $name The key to get value. If it's empty (is null) then the Registry will come back with the full array of this part.
	 * @return mixed Returns with the value, or null, if key not exists, or array, if $name was null.
	 */
	public static final function getSystemSettings($name = null) {
		return self::get(self::CKEY_SYSTEM, $name);
	}

	public static final function getAll() {
		return array(
			self::CKEY_APP => self::get(self::CKEY_APP),
			self::CKEY_SYSTEM => self::get(self::CKEY_SYSTEM)
		);
	}
}
?>
