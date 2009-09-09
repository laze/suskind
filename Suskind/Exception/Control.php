<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Control
 *
 * @author bercsey
 */
class Suskind_Exception_Control extends Suskind_Exception {
    public static function NotExists() {
		return array(
			'message'	=> 'Control object not exists',
			'code'		=> 12345
		);
	}
}
?>
