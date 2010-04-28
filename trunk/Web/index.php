<?php

require_once('../Library/Suskind/Loader.php');

Suskind_Loader::load();

$application = Suskind::Application();
$application->run();

?>