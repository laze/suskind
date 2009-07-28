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

	public static function open($path, $session_name) {
		self::$path = $path;

		return (true);
	}

	public static function close() {
		return (true);
	}

	public static function read($id) {
		return (string) @file_get_contents(self::$path.'/sess_'.$id);
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
