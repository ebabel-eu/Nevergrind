<?php
	if(php_uname('n')=="JOE-PC"){
		$link = mysqli_connect("localhost:3306","root","2M@elsw6","nevergrind");
	}else{
		$link = mysqli_connect("localhost", "nevergri_ng", "!M6a1e8l2f4y6n", "nevergri_ngLocal");
	}
	if (!$link) {
		die('Could not connect: ' . mysqli_error('Could not connect'));
	}
?>