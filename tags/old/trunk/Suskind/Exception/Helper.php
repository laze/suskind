<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Helper
 *
 * @author bercsey
 */
class Suskind_Exception_Helper {
	public static function compile($message, array $variables) {
		return str_replace(array_keys($variables), $variables, $message);
	}
}
?>
