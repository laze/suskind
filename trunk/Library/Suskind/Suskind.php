<?php


class Suskind {
	const LIB_NAME	= 'Suskind Framework';
	const LIB_VER	= '0.1';
	const LIB_STATE	= 'alpha';

	const EXIT_SUCCESSFULL	= 202; //- Accepted
	const EXIT_ERROR		= 500; //- Internal server error
	const EXIT_FORBIDDEN	= 403; //- Forbidden

	/**
	 *
	 * @var Suskind_Request
	 * @static
	 */
	public $request;

	/**
	 *
	 * @var Suskind
	 * @static
	 */
	private static $instance = null;

	/**
	 * Construct Suskind
	 *
	 * @return void
	 */
	private function __construct() {
		$this->request = new Suskind_Request();
	}

	/**
	 * Creates an instance of the Suskind, if not exists and returns with that.
	 *
	 * @return Suskind
	 */
	public static function getInstance() {
		if (!is_a(self::$instance, __CLASS__)) self::$instance = new Suskind();
		return self::$instance;
	}

    public static function Application() {
		try {
			$suskind = self::getInstance();
			if ($suskind->request->module() == __CLASS__) {
				call_user_func(array($suskind->request->module(), $suskind->request->action()));
				exit(self::EXIT_SUCCESSFULL);
			} else return new Suskind_Application($suskind->request);
			
		} catch (Suskind_Exception $exception) {
			$exception->show();
			exit($exception->getCode());
		} catch (Exception $exception) {
			echo $exception->__toString();
			exit(self::EXIT_ERROR);
		}
	}

	/**
	 * Shows PHP info panel.
	 * 
	 * @return void
	 */
	public static function info() {
		phpinfo();
	}

	public static function about() {
		echo self::LIB_NAME.' '.self::LIB_VER.' ('.self::LIB_STATE.')';
	}
}

?>
