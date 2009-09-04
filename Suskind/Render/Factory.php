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
		$registry = Suskind_Registry::getSettings('render');

		if ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
			if (is_array($registry) && array_key_exists('json', $registry)) return new $registry['json']();
			else return new Suskind_Render_Json();
		} else {
			if (is_array($registry) && array_key_exists('html', $registry)) return new $registry['html']();
			else return new Suskind_Render_Html();
		}
	}
}

?>
