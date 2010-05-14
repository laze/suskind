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
	//- Styles
	const FORMAT_STYLE_BOLD			= 1;
	const FORMAT_STYLE_UNDERSCORE	= 4;
	const FORMAT_STYLE_BLINK		= 5;
	const FORMAT_STYLE_REVERSE		= 7;
	const FORMAT_STYLE_CONCEAL		= 8;
	//- Foreground Colors
	const FORMAT_FOREGROUND_BLACK	= 30;
	const FORMAT_FOREGROUND_RED		= 31;
	const FORMAT_FOREGROUND_GREEN	= 32;
	const FORMAT_FOREGROUND_YELLOW	= 33;
	const FORMAT_FOREGROUND_BLUE	= 34;
	const FORMAT_FOREGROUND_MAGENTA	= 35;
	const FORMAT_FOREGROUND_CYAN	= 36;
	const FORMAT_FOREGROUND_WHITE	= 37;
	//- BackgroundColors
	const FORMAT_BACKGROUND_BLACK	= 40;
	const FORMAT_BACKGROUND_RED		= 41;
	const FORMAT_BACKGROUND_GREEN	= 42;
	const FORMAT_BACKGROUND_YELLOW	= 43;
	const FORMAT_BACKGROUND_BLUE	= 44;
	const FORMAT_BACKGROUND_MAGENTA	= 45;
	const FORMAT_BACKGROUND_CYAN	= 46;
	const FORMAT_BACKGROUND_WHITE	= 47;

    public static function help() {
		/*
		print "-? -h --help\tHelp screen\n";
		print "-v --ver\tVersion screen\n";
		*/
		self::write("--help\t\t-h\t", array(self::FORMAT_STYLE_BOLD, self::FORMAT_FOREGROUND_GREEN));
		self::write("Help screen\n");
		self::write("--version\t-v\t", array(self::FORMAT_STYLE_BOLD, self::FORMAT_FOREGROUND_GREEN));
		self::write("Display Suskind's version information.\n");
	}

	public static function version() {
		print Suskind::LIB_NAME.' '.Suskind::LIB_VER.' ('.Suskind::LIB_STATE.')';
	}

	public static function parseCommand($command) {
		switch ($command) {
			case '-v':
			case '-version':
				self::version();
				break;
			case '-h':
			case '--help':
				self::help();
				break;
			default:
				self::write("No parameter given!\n");
				self::write("Usage:\n");
				self::write("\tsuskind [options] task [arguments]\n");
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

	private static function write($text, $format = '') {
		if (is_array($format)) $format = implode(';', $format);
		fwrite(STDOUT, "\033[".$format.'m'.$text."\033[0m");
	}

	public static function getExitCode() {
		return (int) 0;
	}
}
?>
