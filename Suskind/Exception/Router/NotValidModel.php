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
class Suskind_Exception_Router_NotValidModel extends Suskind_Exception {
    //put your code here
	public function  __construct($modelName) {
		$this->message = 'Süskind Framework\'s router can not found the given model: '.$modelName.')';
	}
}
?>
