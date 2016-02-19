<?php
	session_start();
	session_set_cookie_params(86400);
	ini_set('session.gc_maxlifetime', 86400);
	if(php_uname('n')=="JOE-PC"){
		$link = mysqli_connect("localhost:3306","root","2M@elsw6","nevergrind");
	}else{
		$link = mysqli_connect("localhost", "nevergri_ng", "!M6a1e8l2f4y6n", "nevergri_ngLocal");
	}
	if (!$link) {
		die('Could not connect: ' . mysqli_error());
	}
?>