<?php

/**
 * loader.php
 * 
 * The ultimate loader: Here is the definition the loader class, which defines
 * system wide settings and registers PHP system calls to include class files
 * automatically, and handle debug in advanced mode.
 * 
 * @author laze <laze@laze.hu>
 * @copyright laze, 2008.
 * 
 * @see http://laze.hu/projects/suskind/
 */
class loader {
	/**
	 * @classDescription The loader class define constants, variables, pathes 
	 * and defines registered PHP systems calls, to do functions automatically.
	 * @constructor
	 * @return void
	 */
	public function __construct() {
			//- php.ini sets.
		# ini_set( 'session.auto_start', 1 );
		ini_set( 'register_globals', 0 );
			//- character encoding sets
		iconv_set_encoding( 'internal_encoding', 'UTF-8' );
		iconv_set_encoding( 'output_encoding', 'UTF-8' );
			//- Defines
		$this->definePath();
		$this->defineError();
			//- Register __autoload method
		spl_autoload_register( array( 'loader', 'loadClass' ) );
			//- Include the engine.
		$this->includeEngine();
	}

	private static function definePath() {
		if ( !defined( 'PATH_SLASH' ) ) define( 'PATH_SLASH', '/' );
		if ( !defined( 'PATH_ROOT' ) ) define( 'PATH_ROOT', '.'.PATH_SLASH );
		//- if ( !defined( 'PATH_ROOT' ) ) define( 'PATH_ROOT', getcwd().PATH_SLASH );
		if ( !defined( 'PATH_ENGINE' ) ) define( 'PATH_ENGINE' , PATH_ROOT.'engine'.PATH_SLASH );
		if ( !defined( 'PATH_CLASSES' ) ) define( 'PATH_CLASSES' , PATH_ENGINE.'classes'.PATH_SLASH );
		if ( !defined( 'PATH_REGISTRY' ) ) define( 'PATH_REGISTRY' , PATH_ROOT.'registry'.PATH_SLASH.$_SERVER['SERVER_NAME'].PATH_SLASH );
		if ( !defined( 'PATH_MODULES' ) ) define( 'PATH_MODULES' , PATH_ROOT.'modules'.PATH_SLASH );
		if ( !defined( 'PATH_TEMPLATES' ) ) define( 'PATH_TEMPLATES', PATH_ROOT.'templates'.PATH_SLASH );
		if ( !defined( 'PATH_CACHE' ) ) define( 'PATH_CACHE', PATH_ROOT.'cache'.PATH_SLASH );
		if ( !defined( 'PATH_IMAGES' ) ) define( 'PATH_IMAGES', PATH_ROOT.'assets'.PATH_SLASH.'images'.PATH_SLASH );
		if ( !defined( 'PATH_JS' ) ) define( 'PATH_JS', PATH_ROOT.'assets'.PATH_SLASH.'js'.PATH_SLASH );
		if ( !defined( 'PATH_CSS' ) ) define( 'PATH_CSS', PATH_ROOT.'assets'.PATH_SLASH.'css'.PATH_SLASH );
		if ( !defined( 'PATH_IMPORT' ) ) define( 'PATH_IMPORT' , PATH_ROOT.'imports'.PATH_SLASH );
	}

	function defineError() {
	}

	/**
	 * The most important things: Includes "The Engine" what is the base of everything...
	 *
	 * @return void;
	 */
	function includeEngine() {
		require_once( PATH_ENGINE.'engine.php' );
	}

	/**
	 * Try to load class, named className.
	 * 
	 * @method loadClass
	 * @return void
	 * @param $className string
	 */
	public static function loadClass( $className ) {
		$file = PATH_CLASSES.$class.'.php';
		if ( file_exists( $file ) ) {
			if ( $required == false ) include_once( $file );
			else require_once( $file );
		} else {
			$file = PATH_MODULES.$class.PATH_SLASH.$class.'.php';
			/**
			 * @TODO Build error handler and change this throw.
			 */
			if ( file_exists( $file ) ) {
				if ( $required == false ) include_once( $file );
				else require_once( $file );
			} else {
				/**
				 *  @throws File not exists.
				 */
				throw new Exception( 'The file doesn\'t exists: '.$file );
			}
		}
	}

	/**
	 * Include a file from directory defined PATH_MODULES
	 *
	 * @param string $_path
	 */
	function includeModule( $_path ) {
		if ( file_exists( PATH_MODULES.$_path ) ) include_once( PATH_MODULES.$_path );
		else throw new Exception( 'The file doesn\'t exists: '.PATH_MODULES.$_path );
	}
}

?>