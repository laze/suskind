<?php

class Suskind_Fountain {
	protected $registry;

	public function __construct() {
		$this->registry = Suskind_Loader::loadConfiguration('Settings.yml');

		return new Suskind_Application(new Suskind_Request());
	}
}

?>
