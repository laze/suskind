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

	public function show() {
		ob_end_clean();
		$output = new Suskind_Render_Html();
		$output->showError($this);
		
		exit ($this->getCode());
	}
}

?>