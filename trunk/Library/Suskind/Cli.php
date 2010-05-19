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
	 * @var boolean $help		True to show help about command, not execute.
	 * @static
	 */
	private static $help = false;

	/**
	 * If -f switch given, Süskind will log into a file and don't use the STDOUT
	 * for communication. If CLI interpreter received that file log needed,
	 * generates a new log file, with a unique file name, and use that for logging.
	 *
	 * @var null|string $file	A filename or null, if not logging needed.
	 * @static
	 */
	private static $file = null;

    public static function help($command = '') {
		if (strlen($command)) {
			self::write("Commandos lobos: ".$command);
		} else {
			self::write("Options:\n");
			self::write("\t--help -h [command]\t", array(self::FORMAT_STYLE_BOLD, self::FORMAT_FOREGROUND_GREEN));
			self::write("Help screen. If command given, shows information about that.\n");
			self::write("\t--version -v\t\t", array(self::FORMAT_STYLE_BOLD, self::FORMAT_FOREGROUND_GREEN));
			self::write("Display Suskind's version information.\n");
			self::write("\nCommands:\n");
			self::write("\tbuild\t\t\t", array(self::FORMAT_STYLE_BOLD, self::FORMAT_FOREGROUND_GREEN));
			self::write("Build MVC objects.\n");
		}
	}

	public static function version() {
		self::write(Suskind::LIB_NAME.' '.Suskind::LIB_VER.' ('.Suskind::LIB_STATE.')'."\n");
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
				case '-f':
					self::$file = new Suskind_Log(__CLASS__);
				default:
//					self::help(true);
					break;
			}
		}
	}

	public static function parseCommand($command, $parameters = null) {
		if (self::$help) self::help($command);
		else switch($command) {
			case 'build':
				self::build($parameters);
				break;
			default:
				self::write("Suskind CLI can't interprete the command: '", array(self::FORMAT_FOREGROUND_RED));
				self::write("$command", array(self::FORMAT_FOREGROUND_RED, self::FORMAT_STYLE_BOLD));
				self::write("'\n", array(self::FORMAT_FOREGROUND_RED));
				break;
		}

	}

	private static function build($parameters = null) {
		$options = array(
			'packagesPrefix'  =>  'Plugin',
			'baseClassName'   =>  'MyDoctrineRecord',
			'suffix'          =>  '.php'
		);
		Doctrine::generateModelsFromYaml('/path/to/yaml', Suskind_Loader::$paths[Suskind_Loader::DIR_MODEL], $options);
	}

	/**
	 * Write out message on standard out or in a file, is it's previously set.
	 *
	 * @param string $text		Text to write out.
	 * @param array $format		Optional array of format rules.
	 */
	private static function write($text, array $format = null) {
		if (is_a(self::$file, 'Suskind_Log')) self::$file->write("\033[".(is_array($format) ? implode(';', $format) : '').'m'.$text."\033[0m");
		else print("\033[".(is_array($format) ? implode(';', $format) : '').'m'.$text."\033[0m");
	}

	public static function getExitCode() {
		return (int) 0;
	}

	/**
	 * This method parses the PHP's built-in $argv array - as a string - by
	 * regular expression.
	 *
	 * @param array $parameters	The PHP's $argv array.
	 */
	public static function parse(array $parameters) {
		/**
		 * This array stores the data received from the command line. It has
		 * three big part:
		 *  - options	Global options, like help, output, etc...
		 *  - command	The command to execute.
		 *  - arguments Parameters for the command.
		 *
		 * @var array $args		Array of parameters parsed from the command line.
		 */
		$args = array();
		
		if (preg_match_all('/^suskind\s+(?P<options>(-{1,2}[\w]+[\s]*)*)\s*(?P<command>[^\s^=^-]*)\s*(?P<arguments>(-{0,2}[\w]+[\:|\=|\s]*[\w\d]*[\s]*)*)$/i', trim(implode(' ', $parameters)), $args)) {
			/**
			 * Some regex matches are exists, try to compile the separate parts
			 * of them.
			 */
			self::parseOptions($args['options'][0]);
			self::parseCommand($args['command'][0], $args['arguments'][0]);
		} else {
			/**
			 * No matches are exists. Put some little message and show help screen.
			 */
			self::write("No parameter given!\n", array(self::FORMAT_FOREGROUND_RED));
			self::write("Usage:\n");
			self::write("\tsuskind", array(self::FORMAT_STYLE_BOLD));
			self::write(" [options] command [arguments]\n\n");
			self::help();
		}
		/**
		 * Work ended. If file pointer is previously set, this method shows the
		 * path to that.
		 */
		if (is_a(self::$file, 'Suskind_Log')) print("Log file created at: ".self::$file->getPath()."\n");
	}
}

?>
