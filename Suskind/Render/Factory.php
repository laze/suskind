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
	private static $renders = array(
		'html'	=> 'Suskind_Render_Html',
		'ajax'	=> 'Suskind_Render_Json',
		'xml'	=> 'Suskind_Render_Xml'
	);
	private static $defaultRender = 'html';

	public static function createRender($type = null) {
		if (!is_null($type) && array_key_exists($type, self::$renders)) return new self::$renders[$type]();
		else {
			$render = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') ? 'ajax' : self::$defaultRender;
			if (is_array(Suskind_Registry::getApplicationSettings('Render'))) {
				self::$renders = array_merge(self::$renders, Suskind_Registry::getApplicationSettings('Render'));
				foreach (Suskind_Registry::getApplicationSettings('Render') as $renderType => $renderClass)
					if (substr($renderClass, 0, 7) != 'Suskind') self::$renders[$renderType] = 'Suskind_Render_Plugin_'.$renderClass;
			}

			var_dump(self::$renders);
			return new self::$renders[$render]();
		}
	}
}

?>
