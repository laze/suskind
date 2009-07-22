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
	private static $sessionId;
	private static $valid;

   	public static function open() {
		self::$sessionId++;
		self::$valid = true;
		$f = fopen($_ENV['PATH_APPLICATION'].'/Public/session.log', 'a');
		fwrite($f, 'Session OPEN (id: '.self::$sessionId.' valid: '.self::$valid.')'."\n");
		fclose($f);
	}

	public static function close() {
		self::$valid = false;
		$f = fopen($_ENV['PATH_APPLICATION'].'/Public/session.log', 'a');
		fwrite($f, 'Session OPEN (id: '.self::$sessionId.' valid: '.self::$valid.')'."\n");
		fclose($f);
	}

	public static function read() {
	}

	public static function write() {
	}

	public static function destroy() {
		self::$sessionId = null;
		$f = fopen($_ENV['PATH_APPLICATION'].'/Public/session.log', 'a');
		fwrite($f, 'Session OPEN (id: '.self::$sessionId.' valid: '.self::$valid.')'."\n");
		fclose($f);
	}

	public static function garbageCollector() {
	}
}
?>
