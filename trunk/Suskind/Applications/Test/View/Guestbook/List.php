<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of List
 *
 * @author bercsey
 */
class Application_View_Guestbook_List extends Suskind_View_View {

	public function  __construct() {
		parent::__construct(__CLASS__);
		$this->setPreferedLayout('Application_View_Default');
	}

	public function compile() {
//		$
		parent::$render->compile();
	}
}

?>
