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
	 * The actually loaded model.
	 *
	 * @var Suskind_Model
	 */
	public $model;

	/**
	 * The called view.
	 *
	 * @var Suskind_View
	 */
	public $view;

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
			$this->fountain->initApplication($this);
			var_dump($this->model);
        } catch (Suskind_Exception $exception) {

        }

	}

	public function run() {
        try {
			$this->fountain->renderApplication();
        } catch(Suskind_Exception $exception) {
			Suskind_Render_Html::showError($exception);
        }
	}
}

?>
