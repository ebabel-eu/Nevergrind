<?php
	require('values.php');
	require('connect1.php');
	
	$start = microtime(true);
	$delay = microtime(true) - $start;
	echo $delay;

?>