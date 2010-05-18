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

	/**
	 * This variable says what we have to do with the given command. If it's
	 * true then the command don't will be executed, just show information about
	 * its usage.
	 *
	 * @var boolean $help	True to show help about command, not execute.
	 * @static
	 */
	private static $help = false;

    public static function help($command = null) {
		if (!$command) {
			self::write("No parameter given!\n", array(self::FORMAT_FOREGROUND_RED));
			self::write("Usage:\n");
			self::write("\tsuskind", array(self::FORMAT_STYLE_BOLD));
			self::write(" [options] task [arguments]\n\n");
		}
		self::write("--help\t\t-h\t", array(self::FORMAT_STYLE_BOLD, self::FORMAT_FOREGROUND_GREEN));
		self::write("Help screen.\n");
		self::write("--version\t-v\t", array(self::FORMAT_STYLE_BOLD, self::FORMAT_FOREGROUND_GREEN));
		self::write("Display Suskind's version information.\n");
	}

	public static function version() {
		self::write(Suskind::LIB_NAME.' '.Suskind::LIB_VER.' ('.Suskind::LIB_STATE.')'."\n", array(self::FORMAT_STYLE_BOLD, self::FORMAT_FOREGROUND_GREEN));
	}

	public static function parseOptions($options) {
		foreach (explode(' ', $options) as $option) {
			switch (trim($option)) {
				case '-v':
				case '--version':
					self::version();
					exit (Suskind::EXIT_SUCCESSFULL);
					break;
				case '-h':
				case '--help':
					self::$help = true;
					break;
				default:
//					self::help(true);
					break;
			}
		}
	}

	public static function parseCommand($command, $parameters = null) {
		if (self::$help) self::help($command);

//		if (class_exists($class)) && method_exists($object, $method_name)) {
//
//		}
	}

	private static function write($text, $format = '') {
		if (is_array($format)) {
			$format = implode(';', $format);
			$text = "\033[".$format.'m'.$text."\033[0m";
		}
		print($text);
	}

	public static function getExitCode() {
		return (int) 0;
	}

	public static function parse(array $parameters) {
		/**
		 * This array stores the different pathes, like the application's path, the
		 * Suskind library's path, the global libraries' path, and also it stores
		 * the different libraries.
		 *
		 * @var array $paths	Array of paths.
		 * @static
		 */
		$args = array();
		$argc = preg_match_all('/^suskind\s+(?P<options>(-{1,2}[\w]+[\s]*)*)\s*(?P<command>[^\s^=^-]*)\s*(?P<parameters>(-{0,2}[\w]+[\:|\=|\s]*[\w\d]*[\s]*)*)$/i', trim(implode(' ', $parameters)), $args);
		if ($argc == 0) self::help();
		else {
			self::parseOptions($args['options'][0]);
			self::parseCommand($args['command'][0], $args['parameters'][0]);
		}
	}
}

?>
