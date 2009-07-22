<?php
/**
 * License
 */

/**
 * Description of Suskind_Exception_Router_ClassNotExists
 *
 * @author Balazs Ercsey <laze@laze.hu>
 */
class Suskind_Exception_Router_ClassNotExists extends Suskind_Exception {
    //put your code here
	public function  __construct($className) {
		$this->message = 'Süskind framework ccouldn\'t load class: '.$className.')';
	}
}
?>
