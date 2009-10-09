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
class Application_View_Default extends Suskind_View_Layout {

	/**
	 * Construction of template.
	 */
	public function __construct() {
		parent::__construct(__CLASS__);
	}

	public function show() {
		echo $this->compile();
	}
}

?>
