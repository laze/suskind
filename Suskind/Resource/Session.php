<?php

/**
 * License
 */

/**
 * Suskind_Resource_Resource class
 *
 * @package     Suskind
 * @package     Resources
 * @author		Balazs Ercsey <laze@laze.hu>
 * @license     http://www.opensource.org/licenses/gpl-3.0.html GPLv3
 * @link        http://code.google.com/p/suskind
 * @since       0.1
 * @version
 */
interface Suskind_Resource_Session extends Suskind_Resource_Interface {
	public function setEnvironment(array $parameters);

	public function destroy();
}
?>
