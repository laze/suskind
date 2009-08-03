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
	private static $store;

	public static function open($sessionPath, $sessionName) {
		if (class_exists('Application_Plugin_Session_Store')) self::$store = new Application_Plugin_Session_Store();
		else self::$store = new Suskind_Session_Store();

		self::$path = $sessionPath;

		self::$store->setEnvironment();
		return (true);
	}

	public static function close() {
		self::$store->destroy();
		return (true);
	}

	public static function read($sessionId) {
		return (string) self::$store->read($sessionId);
	}

	public static function write($id, $sess_data) {
		if ($fp = @fopen(self::$path.'/sess_'.$id, "w")) {
			$return = fwrite($fp, $sess_data);
			fclose($fp);
			return $return;
		} else {
			return(false);
		}
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
