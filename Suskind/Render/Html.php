<?php

/**
 * License
 */

/**
 * Suskind_Resource_Interface interface
 *
 * @package     Suskind
 * @package     Render
 * @author		Balazs Ercsey <laze@laze.hu>
 * @license     http://www.opensource.org/licenses/gpl-3.0.html GPLv3
 * @link        http://code.google.com/p/suskind
 * @since       0.1
 * @version
 */
class Suskind_Render_Html extends Suskind_Render_Render {
	const delimiter_start = '<:';
	const delimiter_end = ':>';

	public function __construct() {
		$renders = Suskind_Registry::getSettings('render');
		if (is_array($renders) && array_key_exists('html', $renders)) $this->render = new $renders['html'];
	}

	public function compile() {
		if (is_array($this->assigns)) {
			foreach ($this->assigns as $variable => $value) {
				$patterns[] = '\''.self::delimiter_start.$variable.self::delimiter_end.'\'';
				$replacements[] = (is_null($value['compiled'])) ? $value['value'] : $value['compiled'];
			}
			return preg_replace($patterns, $replacements, $this->template);
		} else return $this->template;
	}

	public function showError(Suskind_Exception $exception) {
		$this->setTemplate($_ENV['PATH_SYSTEM'].DIRECTORY_SEPARATOR.'Suskind'.DIRECTORY_SEPARATOR.'Assets'.DIRECTORY_SEPARATOR.'Templates'.DIRECTORY_SEPARATOR.'Exception.html');
		$this->assign('message', $exception->getMessage());
		$this->assign('code', $exception->getCode());
		$this->assign('file', $exception->getFile());
		$this->assign('line', $exception->getLine());
		echo $this->compile();
	}
}

?>