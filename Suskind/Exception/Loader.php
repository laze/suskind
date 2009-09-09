<?php
/**
 * License
 */

/**
 * Description of Suskind_Exception_Router_ClassNotExists
 *
 * @author Balazs Ercsey <laze@laze.hu>
 */
class Suskind_Exception_Loader extends Suskind_Exception {
    //put your code here
	public static function ClassNotExists($className) {
		return array(
			'message' => 'Süskind framework ccouldn\'t load class: '.$className.')'
		);
	}
}
?>
