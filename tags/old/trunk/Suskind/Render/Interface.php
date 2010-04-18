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
interface Suskind_Render_Interface {
	public function assign($variableName, $variableValue, $variableModification = null);

	public function remove($variableName);

	public function compile();

	public function setTemplate($fileName);
}

?>