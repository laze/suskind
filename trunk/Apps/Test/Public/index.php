<?php

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


require_once realpath('../Library').'/Application.php';

$application = new Suskind_Application();
$application->init()
			->show();

?>