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
class Suskind_Exception_File_PermissionDenied extends Suskind_Exception {
    //put your code here
	public function  __construct($fileName) {
		$this->message = 'Permission denied for file: '.$fileName.')';
	}
}
?>