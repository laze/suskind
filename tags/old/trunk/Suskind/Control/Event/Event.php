<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Event
 *
 * @author bercsey
 */
class Suskind_Control_Event_Event implements Suskind_Control_Event_Interface {
    public function  __construct() {
		
	}

	public function getView() {
		return new $this->view;
	}
}

?>
