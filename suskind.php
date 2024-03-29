#!/usr/bin/php
<?php

// Include the Suskind_Loader...
require_once('Library/Suskind/Loader.php');
Suskind_Loader::load();

// There is no information about task or options or wishes, so we show a default
// text about the usage of the Süskind CLI.
if ($argc == 1) Suskind_Cli::help();
else {
	if (substr($argv[1], 0, 1) == '-' || substr($argv[1], 0, 2) == '--') Suskind_Cli::parseCommand($argv[1]);
	if (substr_count($argv[1], ':') > 0) Suskind_Cli::parseCommandLibrary($argv[1], array_slice($argv, 2));
}

print "\n";

?>
