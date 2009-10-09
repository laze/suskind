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
		$this->control = __CLASS__;
		$this->defaultLayout = new Application_View_Guestbook_List();
	}
}
?>
