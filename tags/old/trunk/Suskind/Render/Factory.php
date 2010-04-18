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

	public static final function createRender($type = null) {
		if (!is_null($type) && array_key_exists($type, self::$renders)) return new self::$renders[$type]();
		
		self::searchRender();
		$render = (self::isAjax()) ? 'ajax' : self::$defaultRender;

		return new self::$renders[$render]();
	}

	private static final function isAjax() {
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
	}

	private static final function searchRender() {
		if (is_array(Suskind_Registry::getApplicationSettings('Render')))
			foreach (Suskind_Registry::getApplicationSettings('Render') as $renderType => $renderClass) {
				if ($renderType != Suskind_Registry::CKEY_PATH) {
					self::$renders[strtolower($renderType)] = 'Suskind_Render_Plugin_'.$renderClass;
				}
			}
	}
}

?>
