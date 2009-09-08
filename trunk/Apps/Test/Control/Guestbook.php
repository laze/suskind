<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Guestbook
 *
 * @author laze
 */
class Application_Control_Guestbook extends Suskind_Control_Control {

	public function __construct() {
		$this->events = array(
			'List', //- First item is the default
			'Add'
		);
		$this->model = new Application_Model_Guestbook();
	}

	public function getDefaultView() {
		$viewClass = str_replace('Control', 'View', __CLASS__.'_'.$this->events[0]);
		if (class_exists($viewClass)) return new $viewClass($viewClass);
		else return new Suskind_View_View(str_replace('Control', 'View', __CLASS__.'_Default'));
	}
}
?>
