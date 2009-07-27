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
	private $save_path;
	private static $sessionId;
	private static $valid;

   	public static function open($save_path, $session_name) {
		global $sess_save_path;

		$sess_save_path = $save_path;
		return (true);
	}

	public static function close() {
		return(true);
	}

	public static function read($id) {
		global $sess_save_path;

		$sess_file = "$sess_save_path/sess_$id";
		return (string) @file_get_contents($sess_file);
	}

	public static function write($id, $sess_data) {
		global $sess_save_path;

		$sess_file = "$sess_save_path/sess_$id";
		if ($fp = @fopen($sess_file, "w")) {
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
