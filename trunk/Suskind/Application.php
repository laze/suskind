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
		$_ENV['PATH_APPLICATION'] = realpath('..'.DIRECTORY_SEPARATOR);
		$_ENV['PATH_SYSTEM'] = realpath('..'.DIRECTORY_SEPARATOR.'Library'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR);

			//- Gets the Fountain, the most important class of the SF.
		require_once $_ENV['PATH_SYSTEM'].DIRECTORY_SEPARATOR.'Suskind'.DIRECTORY_SEPARATOR.'Fountain.php';
		$this->fountain = new Suskind_Fountain();
		echo('<a href="#">Klikk hír!</a>');
	}

	public function init() {
		return $this->fountain->initApplication($this);
	}

	public function run() {
		//echo('dfsdef');
		/*
        try {
			$this->fountain->renderApplication();
        } catch(Suskind_Exception $exception) {
			Suskind_Render_Html::showError($exception);
        }
		 * 
		 */
	}
}

?>
