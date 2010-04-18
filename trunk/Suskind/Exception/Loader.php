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
	public static function ClassNotExists() {
		return array(
			'message'	=> Suskind_Exception_Helper::compile('Süskind framework ccouldn\'t load class: 0)', func_get_args()),
			'code'		=> 3001
		);
	}
}
?>
