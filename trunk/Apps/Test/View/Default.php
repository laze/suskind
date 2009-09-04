<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Default
 *
 * @author Balazs Ercsey <laze@laze.hu>
 */
class Application_View_Default extends Suskind_View_View {

	/**
	 * Construction of template.
	 */
	public function __construct() {
		$this->class = __CLASS__;
		parent::__construct();
	}

	public function show() {
		echo $this->compile();
	}
}

?>
