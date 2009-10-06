<?php
/**
 * License
 */

/**
 * This class handles the general exceptions in place of PHP's own Excpetion class.
 *
 * @author Balazs Ercsey <laze@laze.hu>
 */
class Suskind_Exception extends Exception {

	public function __construct(array $parameters) {
		parent::__construct($parameters['message'], $parameters['code']);
	}

	public function show() {
		/**
		 * @todo check is ob started or not?
		 */
//		ob_end_clean();
//		$output = new Suskind_Render_Html();
//		$output->showError($this);
	/*
		echo('<pre>');
		var_dump($this);
		echo '</pre>';
	 *
	 */
		echo $this->code.': '.$this->message.' @ '.$this->file.' ('.$this->line.')';
		
		exit ($this->getCode());
	}
}

?>
