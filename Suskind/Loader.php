<?php

/**
 * License
 */

/**
 * Description of Loader
 *
 * @author Balazs Ercsey <laze@laze.hu>
 */
final class Suskind_Loader {

    /**
     * @var Suskind_Loader Singleton instance
     */
    protected static $instance;

	protected $registry;

	/**
	 * Constructor
	 *
	 * Registers instance with spl_autoload stack
	 *
	 * @return void
	 */
	protected function __construct() {
			//- Register __autoload methods
		spl_autoload_register(array(__CLASS__, 'autoload'));
		self::buildRegistry();
	}

	/**
	 * Retrieve singleton instance
	 *
	 * @return Suskind_Loader
	 */
	public static function getInstance() {
		if (null === self::$instance) self::$instance = new self();
		return self::$instance;
	}

	/**
	 * Reset the singleton instance
	 *
	 * @return void
	 */
	public static function resetInstance() {
		self::$instance = null;
	}

	private function buildRegistry() {
		$this->registry = new Suskind_Registry();
	}

	/**
	 *
	 * @return Suskind_Registry
	 */
	public function getRegistry() {
		return $this->registry;
	}
	
	/**
	 * Gets name of class and include file from possible pathes.
	 *
	 * @param $className string Name of the class to include.
	 * @return void
	 */
	public static function autoload( $className ) {
		var_dump($className);
		require_once (str_replace('_', '/', $className).'.php');
		/*
			//- Set filename.
		$fileNameClass = 'WAF.'.ucfirst( $className ).'.class.php';
		$fileNameInterface = 'WAF.'.ucfirst( $className ).'.interface.php';
		$moduleDirectoryName = 'WAF.'.ucfirst( $className ).'.module';
			//- Loads configuration. It needs, because static method doesn't see the loader object configuration parameter.
		if( file_exists( '.'.DIRECTORY_SEPARATOR.'configuration'.DIRECTORY_SEPARATOR.$_SERVER['SERVER_NAME'] ) ) $configurationPath = '.'.DIRECTORY_SEPARATOR.'configuration'.DIRECTORY_SEPARATOR.$_SERVER['SERVER_NAME'].DIRECTORY_SEPARATOR;
		else $configurationPath = '.'.DIRECTORY_SEPARATOR.'configuration'.DIRECTORY_SEPARATOR;
			//- Loads configuration and parses result.
		$configuration = array_merge_recursive( parse_ini_file( $configurationPath.'configuration.ini', 1 ), parse_ini_file( $configurationPath.'configuration_secure.ini', 1 ) );
		$fileSearch = explode( ';', $configuration['system']['directories'] );
			//- Check directories.
		foreach( $fileSearch as $directoryName ) {
			if( file_exists( './'.$directoryName.DIRECTORY_SEPARATOR.$fileNameClass ) ) include_once( './'.$directoryName.DIRECTORY_SEPARATOR.$fileNameClass );
			if( file_exists( './'.$directoryName.DIRECTORY_SEPARATOR.$moduleDirectoryName.DIRECTORY_SEPARATOR.$fileNameClass ) ) include_once( './'.$directoryName.DIRECTORY_SEPARATOR.$moduleDirectoryName.DIRECTORY_SEPARATOR.$fileNameClass );
			if( file_exists( './'.$directoryName.DIRECTORY_SEPARATOR.$moduleDirectoryName.DIRECTORY_SEPARATOR.$fileNameInterface ) ) include_once( './'.$directoryName.DIRECTORY_SEPARATOR.$moduleDirectoryName.DIRECTORY_SEPARATOR.$fileNameInterface );
			if( file_exists( './'.$directoryName.DIRECTORY_SEPARATOR.$fileNameInterface ) ) include_once( './'.$directoryName.DIRECTORY_SEPARATOR.$fileNameInterface );
		}
		return;
		 * 
		 */
	}
}


class loader {
	public $configuration = false;
	/**
	 * @author laze
	 * @constructor
	 * @classDescription The loader class, which defines the system pathes, and
	 * handle loading of classes.
	 * @return void
	 */
	public function __construct() {
		$this->definePathes();
			//- After pathes defined, you can load the configuration...
		$this->configuration = array_merge_recursive( parse_ini_file( PATH_CONFIGURATION.'configuration.ini', 1 ), parse_ini_file( PATH_CONFIGURATION.'configuration_secure.ini', 1 ) );
		$this->defineConstants();
		$this->defineErrorMessages();
		$this->defineVersion();
			//- Register special autoloader
		spl_autoload_register(array('loader', 'loadAuto'));
		spl_autoload_register(array('loader', 'loadLibrary'));
		ini_set('session.gc_maxlifetime', SESSION_TIME); //- Set up session's timeout
	}

	/**
	 * Define pathes based on enviroment variables.
	 * @author laze
	 * @return void
	 */
	private function definePathes() {
		if( !defined( 'PATH_ROOT' ) ) {
			if( strlen( dirname( $_SERVER['SCRIPT_NAME'] ) ) > 1 ) define( 'PATH_ROOT', dirname( $_SERVER['SCRIPT_NAME'] ).DIRECTORY_SEPARATOR );
			else define( 'PATH_ROOT', DIRECTORY_SEPARATOR );
		}
		//- if( !defined( 'PATH_ROOT' ) ) define( 'PATH_ROOT', '.'.DIRECTORY_SEPARATOR );
		if( !defined( 'PATH_DATASOURCES' ) ) define( 'PATH_DATASOURCES', PATH_ROOT.'main'.DIRECTORY_SEPARATOR.'datasources'.DIRECTORY_SEPARATOR );
		if( !defined( 'PATH_RENDERS' ) ) define( 'PATH_RENDERS', PATH_ROOT.'main'.DIRECTORY_SEPARATOR.'renders'.DIRECTORY_SEPARATOR );
		if( !defined( 'PATH_MODULES' ) ) define( 'PATH_MODULES', '.'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR );
		if( !defined( 'PATH_CONFIGURATION' ) ) {
			if( file_exists( '.'.DIRECTORY_SEPARATOR.'configuration'.DIRECTORY_SEPARATOR.$_SERVER['SERVER_NAME'] ) ) define( 'PATH_CONFIGURATION', '.'.DIRECTORY_SEPARATOR.'configuration'.DIRECTORY_SEPARATOR.$_SERVER['SERVER_NAME'].DIRECTORY_SEPARATOR );
			else define( 'PATH_CONFIGURATION', '.'.DIRECTORY_SEPARATOR.'configuration'.DIRECTORY_SEPARATOR );
		}
		if( !defined( 'PATH_TEMPLATES' ) ) define( 'PATH_TEMPLATES', '.'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR );
		if( !defined( 'PATH_COMPILE' ) ) define( 'PATH_COMPILE', '.'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'templates_c'.DIRECTORY_SEPARATOR );
		if( !defined( 'PATH_CACHE' ) ) define( 'PATH_CACHE', '.'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR );
		if( !defined( 'PATH_ASSETS' ) ) define( 'PATH_ASSETS', PATH_ROOT.'assets'.DIRECTORY_SEPARATOR );
		if( !defined( 'PATH_IMAGES' ) ) define( 'PATH_IMAGES', PATH_ASSETS.'images'.DIRECTORY_SEPARATOR );
		if( !defined( 'PATH_JS' ) ) define( 'PATH_JS', PATH_ASSETS.'js'.DIRECTORY_SEPARATOR );
		if( !defined( 'PATH_CSS' ) ) define( 'PATH_CSS', PATH_ASSETS.'css'.DIRECTORY_SEPARATOR );
	}

	/**
	 * Define system constants.
	 * @author laze
	 * @return void
	 */
	private function defineConstants() {
			//- Some constant
		if (!defined('RESULT_COMPARE_REMOVE')) define('RESULT_COMPARE_REMOVE', 1101);
			//- Session settings
		if (!defined('SESSION_TIME')) define('SESSION_TIME', $this->configuration['session']['timeout']);
			//- Parse for handlers
		foreach( $this->configuration['handlers'] as $handlerType => $handlerObject ) {
			if( !defined( 'HANDLER_'.strtoupper( $handlerType ) ) ) define( 'HANDLER_'.strtoupper( $handlerType ), $handlerObject );
		}
			//- Workflow statuses
		foreach( $this->configuration['workflow'] as $worklfowStatus => $value ) {
			if( !defined( 'WAF_WORKFLOW_STATUS_'.strtoupper( $worklfowStatus ) ) ) define(  'WAF_WORKFLOW_STATUS_'.strtoupper( $worklfowStatus ), $value );
		}
	}

	/**
	 * Define error messages and error codes from error.ini.
	 * @return void
	 */
	private function defineErrorMessages() {
		$errorMessages = parse_ini_file( PATH_CONFIGURATION.'error.ini', 1 );
		foreach( $errorMessages as $errorId => $errorData ) {
			if( !defined( $errorId.'_CODE' ) ) define( $errorId.'_CODE', $errorData['code'] );
			if( !defined( $errorId.'_MESSAGE' ) ) define( $errorId.'_MESSAGE', $errorData['message'] );
		}
	}

	/**
	 * Define version number from version.ini.
	 * @return void
	 */
	private function defineVersion() {
		$version = parse_ini_file( PATH_CONFIGURATION.'version.ini', 1 );
		define( 'SOFTWARE_VERSION', $version['version'] );
	}

	/**
	 * Gets name of class and include file from possible pathes.
	 * @param $className string Name of the class to include.
	 * @return void
	 */
	public static function loadAuto( $className ) {
			//- Set filename.
		$fileNameClass = 'WAF.'.ucfirst( $className ).'.class.php';
		$fileNameInterface = 'WAF.'.ucfirst( $className ).'.interface.php';
		$moduleDirectoryName = 'WAF.'.ucfirst( $className ).'.module';
			//- Loads configuration. It needs, because static method doesn't see the loader object configuration parameter.
		if( file_exists( '.'.DIRECTORY_SEPARATOR.'configuration'.DIRECTORY_SEPARATOR.$_SERVER['SERVER_NAME'] ) ) $configurationPath = '.'.DIRECTORY_SEPARATOR.'configuration'.DIRECTORY_SEPARATOR.$_SERVER['SERVER_NAME'].DIRECTORY_SEPARATOR;
		else $configurationPath = '.'.DIRECTORY_SEPARATOR.'configuration'.DIRECTORY_SEPARATOR;
			//- Loads configuration and parses result.
		$configuration = array_merge_recursive( parse_ini_file( $configurationPath.'configuration.ini', 1 ), parse_ini_file( $configurationPath.'configuration_secure.ini', 1 ) );
		$fileSearch = explode( ';', $configuration['system']['directories'] );
			//- Check directories.
		foreach( $fileSearch as $directoryName ) {
			if( file_exists( './'.$directoryName.DIRECTORY_SEPARATOR.$fileNameClass ) ) include_once( './'.$directoryName.DIRECTORY_SEPARATOR.$fileNameClass );
			if( file_exists( './'.$directoryName.DIRECTORY_SEPARATOR.$moduleDirectoryName.DIRECTORY_SEPARATOR.$fileNameClass ) ) include_once( './'.$directoryName.DIRECTORY_SEPARATOR.$moduleDirectoryName.DIRECTORY_SEPARATOR.$fileNameClass );
			if( file_exists( './'.$directoryName.DIRECTORY_SEPARATOR.$moduleDirectoryName.DIRECTORY_SEPARATOR.$fileNameInterface ) ) include_once( './'.$directoryName.DIRECTORY_SEPARATOR.$moduleDirectoryName.DIRECTORY_SEPARATOR.$fileNameInterface );
			if( file_exists( './'.$directoryName.DIRECTORY_SEPARATOR.$fileNameInterface ) ) include_once( './'.$directoryName.DIRECTORY_SEPARATOR.$fileNameInterface );
		}
		return;
	}

	/**
	 * Gets name of class and include file from possible pathes.
	 * @param $className string Name of the library's class to include.
	 * @return void
	 */
	public static function loadLibrary( $className ) {
			//- Gets configuration files.
		if( file_exists( '.'.DIRECTORY_SEPARATOR.'configuration'.DIRECTORY_SEPARATOR.$_SERVER['SERVER_NAME'] ) ) $configurationPath = '.'.DIRECTORY_SEPARATOR.'configuration'.DIRECTORY_SEPARATOR.$_SERVER['SERVER_NAME'].DIRECTORY_SEPARATOR;
		else $configurationPath = '.'.DIRECTORY_SEPARATOR.'configuration'.DIRECTORY_SEPARATOR;
			//- Loads configuration
		$configuration = array_merge_recursive( parse_ini_file( $configurationPath.'configuration.ini', 1 ), parse_ini_file( $configurationPath.'configuration_secure.ini', 1 ) );
			//- Include neccesary files.
		if( array_key_exists( $className, $configuration['libraries'] ) ) {
			if( file_exists( './'.$configuration['libraries'][$className] ) ) include_once( './'.$configuration['libraries'][$className] );
		}
	}

}

?>