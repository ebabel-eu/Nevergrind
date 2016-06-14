<?php
	// Site-wide values
	$_SESSION['protocol'] = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https:" : "http:";
	if(php_uname('n')=="JOE-PC"){
		$_SESSION['STRIPE_TEST'] = 'sk_test_3zyOCnInUEhcpkM6H0FDegZr';
	}else{
		$_SESSION['STRIPE_LIVE'] = 'sk_live_GtiutFgWYDWNyXnaaL4ShHQt';
	}
	$_SESSION['salt'] = "IJPOIJpj9823f98jhjlkjj984jv22j8SLKJDF:LKJ";
	date_default_timezone_set('UTC');
	// Firmament Wars values
	$_SESSION['lag'] = 20;
	$_SESSION['refreshGameLag'] = 2;
?>