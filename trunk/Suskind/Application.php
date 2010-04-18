<?php

/**
 * License
 */

/**
 * Description of Loader
 *
 * @author Balazs Ercsey <laze@laze.hu>
 */
final class Suskind_Application {

	/**
	 *
	 */
	const DEFAULT_VIEW = 'Application_View_Default';
	/**
	 *
	 * @var Suskind_Fountain
	 */
	private $fountain;

	/**
	 *
	 * @param Suskind_Fountain $fountain
	 */
    public function __construct(Suskind_Fountain $fountain) {
		$this->fountain = $fountain;
    }

	public function init() {
		$this->fountain->initControl();
		$this->fountain->initLayout(self::DEFAULT_VIEW);
	}

	/**
	 * This method try to return with the default view of the application. First,
	 * try to get it from the registry, and if it not defined there, try to get
	 * from the filesystem.
	 * If not found any, returns with boolean false.
	 * 
	 * @return void Return boolean false if application view not set.
	 */
	public function getDefaultView() {
		//- if (array_key_exists('Suskind_Application_Views', $this->environment) && $this->environment['Suskind_Application_Views']['Default']) return $this->environment['Suskind_Application_Views']['Default'];
		if (class_exists('Application_View_Default', true)) return Application_View_Default();
    }
	
	public function compile() {
		/**
		 * @todo Decide, whether compile or show needed!
		 */
//		 echo '<pre>';
//		 var_dump($this);
//		 echo '</pre>';
		$this->fountain->compile(true);
	}

	public static final function run() {
		try {
			require_once substr_replace(__FILE__, 'Fountain.php', strrpos(__FILE__, DIRECTORY_SEPARATOR)+1);

			$application = new Suskind_Application(Suskind_Fountain::getInstance());
			$application->init();
			$application->compile();
		} catch (Suskind_Exception $exception) {
			$exception->show();
		} catch (Exception $exception) {
			echo $exception->__toString();
		}
	}
}

?>
