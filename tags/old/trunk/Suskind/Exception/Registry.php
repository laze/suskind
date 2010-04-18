<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NotValidModel
 *
 * @author bercsey
 */
class Suskind_Exception_Registry extends Suskind_Exception {
	const package = 'File';

    public static function ConfigurationNotExists() {
		return array(
			'message'	=> Suskind_Exception_Helper::compile('The application hasn\'t got any configuration file in the place where it should be. (0)', func_get_args()),
			'code'		=> 1011
		);
	}
}
?>