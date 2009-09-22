<?php

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once realpath('../../').'/Fountain.php';

Suskind_Fountain::getInstance()->init()
	->show();

?>