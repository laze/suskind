<?php
/**
 * License
 */

/**
 * Description of Suskind_Session_Session
 *
 * @author Balazs Ercsey <laze@laze.hu>
 */
class Suskind_Session_Session implements Suskind_Session_Interface {
	private static $path;
	private static $session = array();
	private static $store = null;

	public static function open($sessionPath, $sessionName) {
		if (is_null(self::$store)) {
			if (class_exists('Application_Plugin_Session_Store')) self::$store = new Application_Plugin_Session_Store();
			else self::$store = new Suskind_Resource_Session_Store();
		}
		self::$path = $sessionPath;
		self::$store->setEnvironment(func_get_args());
		return (true);
	}

	public static function close() {
		self::$store->destroy();
		return (true);
	}

	public static function read($sessionId) {
		if ($sessionId == Suskind_System::SESSION_ID) return (string) self::$store->read();
	}

	public static function write($sessionId, $sessionData) {
		if ($sessionId == Suskind_System::SESSION_ID) return self::$store->write($_SESSION);
	}

	public static function destroy($id) {
		global $sess_save_path;

		$sess_file = "$sess_save_path/sess_$id";
		return(@unlink($sess_file));
	}

	public static function garbageCollector($maxlifetime) {
		global $sess_save_path;

		foreach (glob("$sess_save_path/sess_*") as $filename) {
			if (filemtime($filename) + $maxlifetime < time()) {
				@unlink($filename);
			}
		}
		return true;
	}
}
?>
