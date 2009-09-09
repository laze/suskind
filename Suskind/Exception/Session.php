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
class Suskind_Exception_Session extends Suskind_Exception {
    //put your code here
	public static function Start() {
		return array(
			'message' => 'Session can\'t started...'
		);
	}
}
?>