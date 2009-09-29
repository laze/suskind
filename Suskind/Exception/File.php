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
class Suskind_Exception_File extends Suskind_Exception {
	const package = 'File';

    public static function NotExists() {
		$vars = func_get_args();
		return array(
			'message'	=> Suskind_Exception_Helper::compile('File not exists: 0', $vars),
			'code'		=> 1001
		);
	}

    public static function PermissionDenied() {
		return array(
			'message'	=> Suskind_Exception_Helper::compile('Permission denied for file: 0', func_get_args()),
			'code'		=> 1002
		);
	}
}
?>