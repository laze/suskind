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
     * @var Suskind_Registry Singleton instance
     */
    private static $instance;
	
	/**
	 * The registry values
	 *
	 * @var array
	 */
	private $registry = array();

	private function  __construct() {
		$this->load();
	}

	public function __get($property) {
	}


	/**
	 * Retrieve singleton instance
	 *
	 * @return Suskind_Registry
	 */
	public static function getInstance() {
		if (null === self::$instance) self::$instance = new self();
		return self::$instance;
	}


	public static function getSettings($key) {
		if (array_key_exists($key, self::$instance->registry)) return self::$instance->registry[$key];
		elseif (array_key_exists('Suskind_Application_'.ucfirst($key), self::$instance->registry)) return self::$instance->registry['Suskind_Application_'.ucfirst($key)];
		else return;
	}

	public static function checkKey($key) {
		return array_key_exists($key, self::$instance->registry) || array_key_exists('Suskind_Application_'.ucfirst($key), self::$instance->registry);
	}

	/**
	 * Loading different configuration files: First of all try to get the
	 * application's global configuration. After that, try to get the
	 * host-related configurations. If any key exists in the second file, what
	 * is also exists in the first, then it will be overwritten.
	 *
	 * @return void
	 */
	public function load() {
		//- Gets the application's global configuration.
		if (file_exists($_ENV['PATH_APPLICATION'].'/Configuration/application.ini')) $this->addRegistry(parse_ini_file($_ENV['PATH_APPLICATION'].'/Configuration/application.ini', true));
		//- Gets the application's host-related configuration.
		if (file_exists($_ENV['PATH_APPLICATION'].'/Configuration/'.$_SERVER['SERVER_NAME'].'/application.ini')) $this->addRegistry(parse_ini_file($_ENV['PATH_APPLICATION'].'/Configuration/'.$_SERVER['SERVER_NAME'].'/application.ini', true));
	}

	/**
	 * This method can be used to handle advanced configuration, user can set
	 * new registry from a specified file. This method DOES NOT write over the
	 * registry, these options are just will be added to it.
	 *
	 * @param string $filename The path of the file to load.
	 * @return void
	 */
	public function loadFile(string $filename) {
		if (file_exists($filename)) $this->addRegistry(parse_ini_file($filename, true));
		else throw new Suskind_Exception(1001,array($filename));
	}

	/**
	 * Add settings to the registry.
	 *
	 * @param array $configuration A previously parsed ini file.
	 * @return void
	 */
	private function addRegistry(array $configuration) {
		foreach ($configuration as $path => $settings) {
			$path = 'Suskind_'.str_replace(' ', '_', ucwords(str_replace('.', ' ', $path)));
			$this->registry[$path] = $settings;
		}
	}
}
?>
