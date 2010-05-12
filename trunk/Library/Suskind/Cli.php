<?php

/**
 * Suskind Framework
 *
 * LICENSE
 *
 * This source file is a subject of the GPLv3 that is bundled with this package
 * in the file License.txt
 * It is also available at this URL:
 * http://www.opensource.org/licenses/gpl-3.0.html
 */

/**
 * Command line interface for Suskind Framework
 *
 * @category	Suskind
 * @package		Suskind
 * @subpackage	CLI
 * @author		Balazs Ercsey <laze@laze.hu>
 * @license		http://www.opensource.org/licenses/gpl-3.0.html GPLv3
 * @link		http://code.google.com/p/suskind/
 * @since		0.1
 * @version		$Rev$
 */
class Suskind_Cli {
    public static function help() {
		print "-? -h --help\tHelp screen\n";
		print "-v --ver\tVersion screen\n";

	}

	public static function version() {
		print Suskind::LIB_NAME.' '.Suskind::LIB_VER.' ('.Suskind::LIB_STATE.')';
	}

	public static function parseCommand($command) {
		switch (str_replace('-', '', $command)) {
			case 'v':
			case 'ver':
				self::version();
				break;
			case '?':
			case 'h':
			case 'help':
			default:
				self::help();
				break;
		}
	}

	public static function parseCommandLibrary($command, $parameters = null) {
		var_dump($command, $parameters);
		list ($class, $method_name) = explode(':', $command);

//		if (class_exists($class)) && method_exists($object, $method_name)) {
//
//		}
	}
}
?>
