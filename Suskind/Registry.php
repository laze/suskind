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
		$this->loadFile();
	}

	/**
	 * Loading different configuration files:
	 * - First try to get the application's global configuration.
	 *
	 * @param string $filename
	 */
	public function loadFile(string $filename = null) {
			//- Gets the application's global configuration.
		if (file_exists($_ENV['PATH_APPLICATION'].'/Configuration/application.ini')) array_merge_recursive($this->registry, parse_ini_file($_ENV['PATH_APPLICATION'].'/Configuration/application.ini', true));
			//- Gets the application's host-related configuration.
		if (file_exists($_ENV['PATH_APPLICATION'].'/Configuration/'.$_SERVER['SERVER_NAME'].'/application.ini')) array_merge_recursive($this->registry, parse_ini_file($_ENV['PATH_APPLICATION'].'/Configuration/'.$_SERVER['SERVER_NAME'].'/application.ini', true));
			//- Add advanced configurations to registry.
		if (!is_null($filename) && file_exists($filename)) array_merge_recursive($this->registry, parse_ini_file($filename, true));
	}
}
?>
