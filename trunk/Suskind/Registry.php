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
	 * The registry values
	 *
	 * @var array
	 */
	private $registry = array();

	public function  __construct() {
		$this->load();
	}

	public function __get($property) {
	}


	public function getGroup($group) {
		if (strpos($group, '.')) {
			list ($parent, $key) = explode('.', $group, 2);
			if (array_key_exists($parent, $this->registry)) {
				if (array_key_exists($key, $this->registry[$parent])) return $this->registry[$parent][$key];
				else return false;
			} else return false;
		} else {
			if (array_key_exists($group, $this->registry)) return $this->registry[$group];
			else return false;
		}
	}

	public function checkGroup($group) {
		var_dump(array_key_exists($group, $this->registry));
		if (strpos($group, '.')) {
			list ($parent, $key) = explode('.', $group, 2);
			if (array_key_exists($parent, $this->registry)) {
				if (array_key_exists($key, $this->registry[$parent])) return true;
				else return false;
			} else return false;
		} else {
			if (array_key_exists($group, $this->registry)) return true;
			else return false;
		}
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
		foreach ($configuration as $key => $value) {
			if(strpos($key, '.') !== false) {
				list($parent, $folder) = explode('.', $key);
				$this->registry[$parent][$folder] = $value;
			} else $this->registry[$key] = $value;
		}
		echo( '<pre>' );
		var_dump($this->registry);
		echo( '</pre>' );
	}
}
?>
