<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Suskind_Render_Factory
 *
 * @author Balazs Ercsey <laze@laze.hu>
 */
class Suskind_Render_Factory {
	public static function createRender() {
		return ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) ? new Suskind_Render_Json() : new Suskind_Render_Html();
	}
}

?>
