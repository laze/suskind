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
class Suskind_Exception_Session_Start extends Suskind_Exception {
    //put your code here
	public function  __construct() {
		$this->message = 'Session can\'t started...';
	}
}
?>