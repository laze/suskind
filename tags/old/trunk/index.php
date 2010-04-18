<?php
/**
 * index.php
 *
 * @author laze <laze@laze.hu>
 * @copyright laze.hu, 2009.
 */
session_start();

//require_once( 'main/WAF.Debug.class.php' );
require_once( 'header.php' );

$wafController = new controller();
$wafController->execute();

?>