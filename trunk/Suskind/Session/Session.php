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
	private static $store = null;

	public static function start() {
		session_set_save_handler(array('Suskind_Session_Session', 'open'), array('Suskind_Session_Session', 'close'), array('Suskind_Session_Session', 'read'), array('Suskind_Session_Session', 'write'), array('Suskind_Session_Session', 'destroy'), array('Suskind_Session_Session', 'garbageCollector'));
		session_id(Suskind_Fountain::SESSION_ID);
		session_start();
	}

	public static function open($sessionPath, $sessionName) {
		if (is_null(self::$store)) {
			if (class_exists('Application_Plugin_Session_Store')) self::$store = new Application_Plugin_Session_Store();
			else self::$store = new Suskind_Resource_Session_Store();
		}
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
		/*
		$variables = explode(';',session_encode());
		foreach ($variables as $variable) {
			$var = explode('|', $variable);
			if (sizeof($var) > 1) {
				$names[] = $var[0];
				if (substr($var[1],0,2) == 's:') $data[] = str_replace('"', '', strstr($var[1], '"'));
				else $data[] = substr($var[1], 2);
			}
		}
		if ($sessionId == Suskind_System::SESSION_ID) return self::$store->write(array_combine($names, $data));
		 * 
		 */
        if ($sessionId == Suskind_System::SESSION_ID) return self::$store->write(array(
			'clientIP'		=> $_SERVER['REMOTE_ADDR'],
			'clientStamp'	=> time(),
			'clientAuth'	=> self::isAuthenticated(),
			'clientTrust'	=> false,
			'encodedData'	=> $sessionData
        ));
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

	private static function isAuthenticated() {
		return false;
	}
	
	private static function needAuthentication() {
		return false;
	}

	private static function checkAuthenticated() {
		if (!self::isAuthenticated() && self::needAuthentication()) echo('be köllessen lépni!');
		else return true;
	}
}

?>
