<?php
/**
 * License
 */

/**
 * Suskind_Session_Interface interface
 *
 * @package     Suskind
 * @package     Resources
 * @author		Balazs Ercsey <laze@laze.hu>
 * @license     http://www.opensource.org/licenses/gpl-3.0.html GPLv3
 * @link        http://code.google.com/p/suskind
 * @since       0.1
 * @version
 */
interface Suskind_Session_Interface {

	public static function open($save_path, $session_name);

	public static function close();

	public static function read($id);

	public static function write($id, $sess_data);

	public static function destroy($id);

	public static function garbageCollector($maxlifetime);
}

?>
