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
	private $model;

	public function __construct() {
		$this->model = new Application_Model_Guestbook();
	}

	public function getDefaultView() {
		echo __CLASS__.'_Default';
		return new Suskind_View_View(__CLASS__.'_Default');
	}
}
?>
