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
	 * Application environment
	 *
 	 * @var array
	 */
	private $environment;
	
	/**
	 * The Süskind Fountain. This is the most important thing in the whole system.
	 * 
	 * @var Suskind_Fountain 
	 */
	private $fountain;

    /**
     * @todo: Check wether is included via include_path or via regular path.
     */
    public function __construct() {
            //- Set application and system paths.
		$_ENV['PATH_APPLICATION'] = realpath('../');
		$_ENV['PATH_SYSTEM'] = realpath('../Library/../');

			//- Gets the Fountain, the most important class of the SF.
		require_once $_ENV['PATH_SYSTEM'].'/Suskind/Fountain.php';

        try {
            $this->fountain = new Suskind_Fountain();
        } catch (Suskind_Exception $exception) {

        } catch (Exception $exception) {

        }

	}

	public function run() {
        try {
    		$this->fountain->getRoute();
        } catch(Suskind_Exception $exception) {
            $errorRender = new Suskind_Render_Html('error.htpl');
        }
	}
}

?>
