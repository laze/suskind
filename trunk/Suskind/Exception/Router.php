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
class Suskind_Exception_Router extends Suskind_Exception {
    //put your code here
	public static function NotValidModel() {
		return array(
			'message'	=> Suskind_Exception_Helper::compile('Süskind Framework\'s router can not found the given model: 0)', func_get_args()),
			'code'		=> 4001
		);
	}
}
?>
