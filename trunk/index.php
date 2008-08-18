<?php

/**
 * index.php
 * 
 * Here start's the "süskind project" if a request accepted.
 * 
 * @author laze <laze@laze.hu>
 * @copyright laze, 2008.
 * 
 * @see http://laze.hu/projects/suskind/
 */

require_once( 'header.php' );

$suskind = fountain::getInstance();
$suskind->execute();

?>