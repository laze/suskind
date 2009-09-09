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

    public static function PermissionDenied($fileName) {
		return array(
			'message'	=> 'Permission denied for file: '.$fileName.')',
			'code'		=> 12345
		);
	}

    public static function NotExists($fileName) {
		return array(
			'message'	=> 'File not exists: '.$fileName.')',
			'code'		=> 12345
		);
	}
}
?>