<?php

/**
 * License
 */

/**
 * Suskind_Resource_Render class
 *
 * This class is the basic of the other renderer classes: this contains
 * the variable assign handlers and variable modification functions.
 *
 * @package     Suskind
 * @package     Render
 * @author		Balazs Ercsey <laze@laze.hu>
 * @license     http://www.opensource.org/licenses/gpl-3.0.html GPLv3
 * @link        http://code.google.com/p/suskind
 * @since       0.1
 * @version
 */
class Suskind_Render_Render implements Suskind_Render_Interface {
	/**
	 * This array contains named variables for rendering. It can managed by
	 * assign and remove functions.
	 * 
	 * @var array 
	 */
	protected $assigns;

	public function assign($variableName, $variableValue, $variableModification = null) {
		$this->assigns[$variableName] = array(
			'value' => $variableValue,
			'modification' => $variableModification,
			'compiled' => (!is_null($variableModification)) ? call_user_func($variableModification, $variableValue) : null
		);
	}

	public function remove($variableName) {
		unset ($this->assigns[$variableName]);
	}

	public function compile() {
	}

	public static function uppercaseFirst(string $value) {
		if (is_string($value)) return ucfirst($value);
	}
}

?>
